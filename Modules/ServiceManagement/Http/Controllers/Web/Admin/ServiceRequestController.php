<?php

namespace Modules\ServiceManagement\Http\Controllers\Web\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\CategoryManagement\Entities\Category;
use Modules\ProviderManagement\Entities\Provider;
use Modules\ServiceManagement\Entities\ServiceRequest;
use Modules\UserManagement\Entities\User;

class ServiceRequestController extends Controller
{
    private ServiceRequest $service_request;
    public function __construct(ServiceRequest $service_request)
    {
        $this->service_request = $service_request;
    }


    /**
     * Display a listing of the resource.
     * @return Application|Factory|View
     */
    public function request_list(Request $request): View|Factory|Application
    {
        $search = $request['search'];
        $requests = $this->service_request->with(['category', 'user.provider'])
            ->when($request->has('search'), function ($query) use ($request) {
                $keys = explode(' ', $request['search']);
                return $query->whereHas('category', function ($query) use ($keys) {
                    foreach ($keys as $key) {
                        $query->where('name', 'LIKE', '%' . $key . '%');
                    }
                });
            })
            ->latest()
            ->paginate(pagination_limit());

        return view('servicemanagement::admin.service.request-list', compact('requests', 'search'));
    }

    /**
     * Display a listing of the resource.
     * @return RedirectResponse
     */
    public function update_status($id, Request $request): RedirectResponse
    {
        $service_request = $this->service_request->find($id);
        $service_request->status = $request['review_status'] == 1 ? 'approved' : 'denied';
        $service_request->admin_feedback = $request['admin_feedback'];
        $service_request->save();

        if ($service_request->user && $service_request->user->provider) {
            $user_info = $service_request?->user?->provider;
            $language_key = $user_info->owner?->current_language_key;
            if (!is_null($user_info->owner?->fcm_token)) {
                if ($service_request->status == 'approved') {
                    $data_info = [
                        'provider_name' => $user_info?->company_name
                    ];
                    $title = get_push_notification_message('service_request_approve', 'provider_notification', $language_key);
                    device_notification($user_info->owner?->fcm_token, $title, null, null, null, 'service_request', null,null, $data_info);
                } elseif ($service_request->status == 'denied') {
                    $data_info = [
                        'provider_name' => $user_info?->company_name
                    ];
                    $title = get_push_notification_message('service_request_deny', 'provider_notification', $language_key);
                    device_notification($user_info?->owner?->fcm_token, $title, null, null, null, 'service_request', null, null, $data_info);
                }
            }
        }

        Toastr::success(DEFAULT_STORE_200['message']);
        return back();
    }

}
