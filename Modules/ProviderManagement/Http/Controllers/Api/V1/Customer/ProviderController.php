<?php

namespace Modules\ProviderManagement\Http\Controllers\Api\V1\Customer;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Modules\BookingModule\Entities\Booking;
use Modules\CategoryManagement\Entities\Category;
use Modules\ProviderManagement\Entities\Provider;
use Modules\ProviderManagement\Entities\SubscribedService;
use Modules\ServiceManagement\Entities\Service;
use Modules\ServiceManagement\Entities\Variation;

class ProviderController extends Controller
{
    private Provider $provider;
    private Category $category;
    private SubscribedService $subscribed_service;
    private Booking $booking;

    private Service $service;
    private Variation $variation;

    public function __construct(Provider $provider, Category $category, SubscribedService $subscribed_service, Booking $booking, Service $service, Variation $variation)
    {
        $this->provider = $provider;
        $this->category = $category;
        $this->subscribed_service = $subscribed_service;
        $this->booking = $booking;
        $this->service = $service;
        $this->variation = $variation;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_provider_list(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|min:1|max:200',
            'offset' => 'required|numeric|min:1|max:100000',
            'sort_by' => 'in:asc,desc',
            'category_ids' => 'array',
            'category_ids.*' => 'uuid',
            'rating' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(response_formatter(DEFAULT_400, null, error_processor($validator)), 400);
        }

        $providers = $this->provider->with(['owner', 'subscribed_services.sub_category'=>function($query){
                $query->withoutGlobalScopes();
            }])
            ->where('zone_id', Config::get('zone_id'))
            ->ofStatus(1)
            ->when($request->has('category_ids'), function ($query) use($request) {
                $query->whereHas('subscribed_services', function ($query) use($request) {
                    if ($request->has('category_ids')) $query->whereIn('category_id', $request['category_ids']);
                });
            })
            ->when($request->has('rating'), function ($query) use($request) {
                $query->where('avg_rating', '>=', $request['rating']);
            })
            ->when($request->has('sort_by'), function ($query) use($request) {
                $query->orderBy('company_name', $request['sort_by']);
            })
            ->when(!$request->has('sort_by'), function ($query) use($request) {
                $query->latest();
            })
            ->where('is_suspended',0)
            ->paginate($request['limit'], ['*'], 'offset', $request['offset'])->withPath('');

        return response()->json(response_formatter(DEFAULT_200, $providers), 200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function get_provider_details(Request $request): \Illuminate\Http\JsonResponse
    {
        $provider = $this->provider->with('owner')->with(['reviews.customer'])->find($request['id']);

        $limit_status = provider_warning_amount_calculate($provider->owner->account->account_payable,$provider->owner->account->account_receivable);
        $provider['cash_limit_status'] = $limit_status == false ? 'available' : $limit_status;

        $subscribed_sub_category_ids = $this->subscribed_service->ofStatus(1)->where('provider_id', $provider->id)->pluck('sub_category_id')->toArray();
        $sub_categories = $this->category->withoutGlobalScopes()->with('services.variations')
            ->whereHas('services', function ($query) {
                $query->ofStatus(1);
            })
            ->whereIn('id', $subscribed_sub_category_ids)->get();

        foreach ($sub_categories as $item) {
            if ($item->services) {
                $item->services = self::variation_mapper($item->services);
            }
        }

        return response()->json(response_formatter(DEFAULT_200, ['provider'=>$provider, 'sub_categories'=>$sub_categories]), 200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function get_provider_list_by_sub_category(Request $request): JsonResponse
    {
        $providers = $this->provider->with(['owner'])
            ->where('zone_id', Config::get('zone_id'))
            ->whereHas('subscribed_services', function ($query) use($request) {
                $query->where('sub_category_id', $request['sub_category_id']);
            })
            ->where('is_suspended',0)
            ->get();

        foreach ($providers as $provider) {
            $limit_status = provider_warning_amount_calculate($provider->owner->account->account_payable, $provider->owner->account->account_receivable);
            $provider['cash_limit_status'] = $limit_status === false ? 'available' : $limit_status;
        }

        return response()->json(response_formatter(DEFAULT_200, $providers), 200);
    }

    private function variation_mapper($services)
    {
        $services->map(function ($service) {
            $service['variations_app_format'] = self::variations_app_format($service);
            return $service;
        });
        return $services;
    }

    private function variations_app_format($service): array
    {
        $formatting = [];
        $filtered = $service['variations']->where('zone_id', Config::get('zone_id'));
        $formatting['zone_id'] = Config::get('zone_id');
        $formatting['default_price'] = $filtered->first() ? $filtered->first()->price : 0;
        foreach ($filtered as $data) {
            $formatting['zone_wise_variations'][] = [
                'variant_key' => $data['variant_key'],
                'variant_name' => $data['variant'],
                'price' => $data['price']
            ];
        }
        return $formatting;
    }

    public function get_available_provider(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|min:1|max:200',
            'offset' => 'required|numeric|min:1|max:100000',
            'sort_by' => 'in:asc,desc',
            'booking_id' => 'required|uuid',
            'rating' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(response_formatter(DEFAULT_400, null, error_processor($validator)), 400);
        }

        $booking = $this->booking->where('id', $request->booking_id)->first();

        $providers = $this->provider
            ->where('zone_id', $booking->zone_id)
            ->ofStatus(1)
            ->when(isset($booking->sub_category_id), function ($query) use($request, $booking) {
                $query->whereHas('subscribed_services', function ($query) use($request, $booking) {
                    $query->where('sub_category_id', $booking->sub_category_id)->where('is_subscribed', 1);
                });
            })
            ->when($request->has('rating'), function ($query) use($request) {
                $query->where('avg_rating', '>=', $request['rating']);
            })
            ->when($request->has('sort_by'), function ($query) use($request) {
                $query->orderBy('company_name', $request['sort_by']);
            })
            ->when(!$request->has('sort_by'), function ($query) use($request) {
                $query->latest();
            })
            ->paginate($request['limit'], ['*'], 'offset', $request['offset'])->withPath('');


        return response()->json(response_formatter(DEFAULT_200, $providers), 200);
    }

    public function get_available_service(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|min:1|max:200',
            'offset' => 'required|numeric|min:1|max:100000',
            'service_ids' => 'array',
            'service_ids.*' => 'uuid',
        ]);

        if ($validator->fails()) {
            return response()->json(response_formatter(DEFAULT_400, null, error_processor($validator)), 400);
        }

        $serivces = $this->service
            ->where('is_active', 1)
            ->whereIn('id', $request['service_ids'])
            ->paginate($request['limit'], ['*'], 'offset', $request['offset'])->withPath('');

        return response()->json(response_formatter(DEFAULT_200, $serivces), 200);
    }

    public function rebooking_information(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|min:1|max:200',
            'offset' => 'required|numeric|min:1|max:100000',
            'booking_id' => 'required|uuid',
        ]);

        if ($validator->fails()) {
            return response()->json(response_formatter(DEFAULT_400, null, error_processor($validator)), 400);
        }

        $booking = $this->booking->with('detail')->where('id', $request->booking_id)->first();
        $booking_services = $booking->detail ?? [];

        //provider ...
        $provider = $this->provider
            ->where('id', $booking?->provider->id)
            ->ofStatus(1)
            ->whereHas('owner', function($query){
                $query->ofStatus(1);
            })
            ->where('zone_id', $request->header('zoneid'))
            ->when(business_config('suspend_on_exceed_cash_limit_provider', 'provider_config')->live_values, function($query){
                $query->where('is_suspended', 0);
            })
            ->whereHas('subscribed_services', function ($query) use($request, $booking) {
                $query->where('sub_category_id', $booking->sub_category_id)->where('is_subscribed', 1);
            })
            ->first();

        //service ...
        $services = [];
        foreach ($booking_services as $key => $service) {
                $service_data = $this->service->with(['variations' => function($query) use ($service, $booking, $request) {
                    $query->where('variant_key', $service->variant_key)->where('zone_id', $request->header('zoneid'));
                }])->where('id',$service->service_id)->active()->first();

            $services[] = [
                'service_id' => $service->service_id,
                'service_name' => $service->service_name,
                'variant_key' => $service->variant_key,

                'service_unit_cost' => $service_data?->variations?->first()?->price,
                'booking_service_unit_cost' => $service->service_cost,

                'is_available' => $service_data?->variations?->first() ? 1 : 0,
                'is_price_changed' => ($service_data?->variations?->first()?->price == $service->service_cost) || $service_data?->variations?->first()?->price == null ? 0 : 1,
            ];
        }

        $is_service_info_unchanged = count(array_filter($services, function($service) {
            return $service['is_price_changed'] === 1;
        })) === 0 ? 1 : 0;

        $data = [
            'is_provider_available' => $provider ? 1 : 0,
            'is_service_info_unchanged' => $is_service_info_unchanged,
            'services' => $services,
        ];

        if ($validator->fails()) {
            return response()->json(response_formatter(DEFAULT_400, null, error_processor($validator)), 400);
        }

        return response()->json(response_formatter(DEFAULT_200, $data), 200);
    }

}
