<?php

namespace App\Http\Controllers;

use App\Traits\ActivationClass;
use App\Traits\UnloadedHelpers;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Mockery\Exception;
use Modules\BusinessSettingsModule\Entities\BusinessSettings;
use Modules\BusinessSettingsModule\Entities\DataSetting;
use Modules\BusinessSettingsModule\Entities\LandingPageFeature;
use Modules\BusinessSettingsModule\Entities\LandingPageSpeciality;
use Modules\BusinessSettingsModule\Entities\LandingPageTestimonial;
use Modules\UserManagement\Entities\User;
use Illuminate\Support\Facades\Schema;

class UpdateController extends Controller
{
    use UnloadedHelpers;
    use ActivationClass;

    public function update_software_index()
    {
        Artisan::call('module:enable');
        return view('update.update-software');
    }

    public function update_software(Request $request)
    {
        $this->setEnvironmentValue('SOFTWARE_ID', 'NDAyMjQ3NzI=');
        $this->setEnvironmentValue('BUYER_USERNAME', $request['username']);
        $this->setEnvironmentValue('PURCHASE_CODE', $request['purchase_key']);
        $this->setEnvironmentValue('SOFTWARE_VERSION', '2.2');
        $this->setEnvironmentValue('APP_ENV', 'live');
        $this->setEnvironmentValue('APP_URL', url('/'));

        $data = $this->actch();
        try {
            if (!$data->getData()->active) {
                $remove = array("http://", "https://", "www.");
                $url = str_replace($remove, "", url('/'));

                $activation_url = base64_decode('aHR0cHM6Ly9hY3RpdmF0aW9uLjZhbXRlY2guY29t');
                $activation_url .= '?username=' . $request['username'];
                $activation_url .= '&purchase_code=' . $request['purchase_key'];
                $activation_url .= '&domain=' . $url . '&';

                return redirect($activation_url);
            }
        } catch (Exception $exception) {
            Toastr::error('verification failed! try again');
            return back();
        }

        //database
        try {
            if (!Schema::hasTable('addon_settings')) {
                $sql = File::get(base_path($request['path'] . 'Modules/PaymentModule/Database/addon_settings.sql'));
                DB::unprepared($sql);
                $this->set_data();
            }

            if (!Schema::hasTable('payment_requests')) {
                $sql = File::get(base_path($request['path'] . 'Modules/PaymentModule/Database/payment_requests.sql'));
                DB::unprepared($sql);
            }

        } catch (\Exception $exception) {
            Toastr::error('Database import failed! try again');
            return back();
        }

        Artisan::call('migrate', ['--force' => true]);

        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
        Artisan::call('config:clear');
        Artisan::call('optimize:clear');

        //============== new keys for business settings ==============

        //minimum_withdraw_amount
        if (BusinessSettings::where(['key_name' => 'minimum_withdraw_amount', 'settings_type' => 'business_information'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'minimum_withdraw_amount', 'settings_type' => 'business_information'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //maximum_withdraw_amount
        if (BusinessSettings::where(['key_name' => 'maximum_withdraw_amount', 'settings_type' => 'business_information'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'maximum_withdraw_amount', 'settings_type' => 'business_information'], [
                'live_values' => 0,
                'test_values' => 0,
            ]);
        }

        //promotional cost setup
        if (BusinessSettings::where(['key_name' => 'discount_cost_bearer', 'settings_type' => 'promotional_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'discount_cost_bearer', 'settings_type' => 'promotional_setup'], [
                'live_values' => ["bearer" => "provider", "admin_percentage" => 0, "provider_percentage" => 100, "type" => "discount"],
                'test_values' => ["bearer" => "provider", "admin_percentage" => 0, "provider_percentage" => 100, "type" => "coupon"]
            ]);
        }
        if (BusinessSettings::where(['key_name' => 'coupon_cost_bearer', 'settings_type' => 'promotional_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'coupon_cost_bearer', 'settings_type' => 'promotional_setup'], [
                'live_values' => ["bearer" => "provider", "admin_percentage" => 0, "provider_percentage" => 100, "type" => "coupon"],
                'test_values' => ["bearer" => "provider", "admin_percentage" => 0, "provider_percentage" => 100, "type" => "coupon"]
            ]);
        }
        if (BusinessSettings::where(['key_name' => 'campaign_cost_bearer', 'settings_type' => 'promotional_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'campaign_cost_bearer', 'settings_type' => 'promotional_setup'], [
                'live_values' => ["bearer" => "provider", "admin_percentage" => 0, "provider_percentage" => 100, "type" => "campaign"],
                'test_values' => ["bearer" => "provider", "admin_percentage" => 0, "provider_percentage" => 100, "type" => "campaign"]
            ]);
        }
        if (BusinessSettings::where(['key_name' => 'phone_number_visibility_for_chatting', 'settings_type' => 'business_information'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'phone_number_visibility_for_chatting', 'settings_type' => 'business_information'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //cookies_text
        if (BusinessSettings::where(['key_name' => 'cookies_text', 'settings_type' => 'business_information'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'cookies_text', 'settings_type' => 'business_information'], [
                'live_values' => "",
                'test_values' => ""
            ]);
        }

        //customer_referral_earning
        if (BusinessSettings::where(['key_name' => 'customer_referral_earning', 'settings_type' => 'customer_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'customer_referral_earning', 'settings_type' => 'customer_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //referral_value_per_currency_unit
        if (BusinessSettings::where(['key_name' => 'referral_value_per_currency_unit', 'settings_type' => 'customer_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'referral_value_per_currency_unit', 'settings_type' => 'customer_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //customer_wallet
        if (BusinessSettings::where(['key_name' => 'customer_wallet', 'settings_type' => 'customer_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'customer_wallet', 'settings_type' => 'customer_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //loyalty_point_value_per_currency_unit
        if (BusinessSettings::where(['key_name' => 'loyalty_point_value_per_currency_unit', 'settings_type' => 'customer_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'loyalty_point_value_per_currency_unit', 'settings_type' => 'customer_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //min_loyalty_point_to_transfer
        if (BusinessSettings::where(['key_name' => 'min_loyalty_point_to_transfer', 'settings_type' => 'customer_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'min_loyalty_point_to_transfer', 'settings_type' => 'customer_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //customer_loyalty_point
        if (BusinessSettings::where(['key_name' => 'customer_loyalty_point', 'settings_type' => 'customer_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'customer_loyalty_point', 'settings_type' => 'customer_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //loyalty_point_percentage_per_booking
        if (BusinessSettings::where(['key_name' => 'loyalty_point_percentage_per_booking', 'settings_type' => 'customer_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'loyalty_point_percentage_per_booking', 'settings_type' => 'customer_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //cash_after_service
        if (BusinessSettings::where(['key_name' => 'cash_after_service', 'settings_type' => 'service_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'cash_after_service', 'settings_type' => 'service_setup'], [
                'live_values' => 1,
                'test_values' => 1
            ]);
        }

        //digital_payment
        if (BusinessSettings::where(['key_name' => 'digital_payment', 'settings_type' => 'service_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'digital_payment', 'settings_type' => 'service_setup'], [
                'live_values' => 1,
                'test_values' => 1
            ]);
        }

        //forget_password_verification_method
        if (BusinessSettings::where(['key_name' => 'forget_password_verification_method', 'settings_type' => 'business_information'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'forget_password_verification_method', 'settings_type' => 'business_information'], [
                'live_values' => 'email',
                'test_values' => 'email'
            ]);
        }

        //email_verification
        if (BusinessSettings::where(['key_name' => 'email_verification', 'settings_type' => 'service_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'email_verification', 'settings_type' => 'service_setup'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //phone_verification
        if (BusinessSettings::where(['key_name' => 'phone_verification', 'settings_type' => 'service_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'phone_verification', 'settings_type' => 'service_setup'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //max_booking_amount
        if (BusinessSettings::where(['key_name' => 'max_booking_amount', 'settings_type' => 'booking_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'max_booking_amount', 'settings_type' => 'booking_setup'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //min_booking_amount
        if (BusinessSettings::where(['key_name' => 'min_booking_amount', 'settings_type' => 'booking_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'min_booking_amount', 'settings_type' => 'booking_setup'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //service_complete_photo_evidence
        if (BusinessSettings::where(['key_name' => 'service_complete_photo_evidence', 'settings_type' => 'booking_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'service_complete_photo_evidence', 'settings_type' => 'booking_setup'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //booking_otp
        if (BusinessSettings::where(['key_name' => 'booking_otp', 'settings_type' => 'booking_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'booking_otp', 'settings_type' => 'booking_setup'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //guest_checkout
        if (BusinessSettings::where(['key_name' => 'guest_checkout', 'settings_type' => 'service_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'guest_checkout', 'settings_type' => 'service_setup'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //apple_login
        if (BusinessSettings::where(['key_name' => 'apple_login', 'settings_type' => 'third_party'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'apple_login', 'settings_type' => 'third_party'], [
                'live_values' => ["party_name" => "apple_login", "status" => 0, "client_id" => null, "team_id" => null, 'key_id' => null, 'service_file' => null],
                'test_values' => ["party_name" => "apple_login", "status" => 0, "client_id" => null, "team_id" => null, 'key_id' => null, 'service_file' => null],
            ]);
        }

        //booking_additional_charge
        if (BusinessSettings::where(['key_name' => 'booking_additional_charge', 'settings_type' => 'booking_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'booking_additional_charge', 'settings_type' => 'booking_setup'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //additional_charge_label_name
        if (BusinessSettings::where(['key_name' => 'additional_charge_label_name', 'settings_type' => 'booking_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'additional_charge_label_name', 'settings_type' => 'booking_setup'], [
                'live_values' => null,
                'test_values' => null
            ]);
        }

        //additional_charge_fee_amount
        if (BusinessSettings::where(['key_name' => 'additional_charge_fee_amount', 'settings_type' => 'booking_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'additional_charge_fee_amount', 'settings_type' => 'booking_setup'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //partial_payment
        if (BusinessSettings::where(['key_name' => 'partial_payment', 'settings_type' => 'service_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'partial_payment', 'settings_type' => 'service_setup'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //partial_payment_combinator
        if (BusinessSettings::where(['key_name' => 'partial_payment_combinator', 'settings_type' => 'service_setup'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'partial_payment_combinator', 'settings_type' => 'service_setup'], [
                'live_values' => 'all',
                'test_values' => 'all'
            ]);
        }

        //serviceman_can_cancel_booking
        if (BusinessSettings::where(['key_name' => 'serviceman_can_cancel_booking', 'settings_type' => 'serviceman_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'serviceman_can_cancel_booking', 'settings_type' => 'serviceman_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //serviceman_can_edit_booking
        if (BusinessSettings::where(['key_name' => 'serviceman_can_edit_booking', 'settings_type' => 'serviceman_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'serviceman_can_edit_booking', 'settings_type' => 'serviceman_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //provider_can_cancel_booking
        $provider_can_cancel_booking = BusinessSettings::where(['key_name' => 'provider_can_cancel_booking'])->whereIn('settings_type', ['service_setup', 'provider_config'])->first();
        if ($provider_can_cancel_booking) {
            $provider_can_cancel_booking->update([
                'settings_type' => 'provider_config',
            ]);
        } else {
            BusinessSettings::updateOrCreate([
                'key_name' => 'provider_can_cancel_booking',
                'settings_type' => 'provider_config',
            ], [
                'live_values' => 0,
                'test_values' => 0,
            ]);
        }

        //provider_can_edit_booking
        if (BusinessSettings::where(['key_name' => 'provider_can_edit_booking', 'settings_type' => 'provider_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'provider_can_edit_booking', 'settings_type' => 'provider_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //provider_self_registration
        $provider_self_registration = BusinessSettings::where(['key_name' => 'provider_self_registration'])->whereIn('settings_type', ['service_setup', 'provider_config'])->first();
        if ($provider_self_registration) {
            $provider_self_registration->update([
                'settings_type' => 'provider_config',
            ]);
        } else {
            BusinessSettings::updateOrCreate([
                'key_name' => 'provider_self_registration',
                'settings_type' => 'provider_config',
            ], [
                'live_values' => 0,
                'test_values' => 0,
            ]);
        }

        //provider self delete
        if (BusinessSettings::where(['key_name' => 'provider_self_delete', 'settings_type' => 'provider_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'provider_self_delete', 'settings_type' => 'provider_config'], [
                'live_values' => 1,
                'test_values' => 1
            ]);
        }

        //provider suspend on exceed cash limit
        if (BusinessSettings::where(['key_name' => 'suspend_on_exceed_cash_limit_provider', 'settings_type' => 'provider_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'suspend_on_exceed_cash_limit_provider', 'settings_type' => 'provider_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //provider_can_edit_booking
        if (BusinessSettings::where(['key_name' => 'max_cash_in_hand_limit_provider', 'settings_type' => 'provider_config'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'max_cash_in_hand_limit_provider', 'settings_type' => 'provider_config'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //bidding system
        if (BusinessSettings::where(['key_name' => 'bid_offers_visibility_for_providers', 'settings_type' => 'bidding_system'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'bid_offers_visibility_for_providers', 'settings_type' => 'bidding_system'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }
        if (BusinessSettings::where(['key_name' => 'bidding_post_validity', 'settings_type' => 'bidding_system'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'bidding_post_validity', 'settings_type' => 'bidding_system'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }
        if (BusinessSettings::where(['key_name' => 'bidding_status', 'settings_type' => 'bidding_system'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'bidding_status', 'settings_type' => 'bidding_system'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        if (BusinessSettings::where(['key_name' => 'bidding_status', 'settings_type' => 'bidding_system'])->first() == false) {
            BusinessSettings::updateOrCreate(['key_name' => 'bidding_status', 'settings_type' => 'bidding_system'], [
                'live_values' => 0,
                'test_values' => 0
            ]);
        }

        //language
        $system_language = business_config('system_language', 'business_information');
        $lan_data = [
            [
                'id' => 1,
                'name' => 'english',
                'direction' => 'ltr',
                'code' => 'en',
                'status' => 1,
                'default' => true
            ]
        ];
        if (!isset($system_language)) {
            BusinessSettings::updateOrCreate(['key_name' => 'system_language', 'settings_type' => 'business_information'], [
                'live_values' => $lan_data,
                'test_values' => $lan_data
            ]);
        }

        //notification for customer
        $customer_notification_collection = collect(NOTIFICATION_FOR_USER);

        $customer_notification_collection->each(function ($customer_notification) {
            $keyName = $customer_notification['key'];
            $value = $customer_notification['value'];
            $notificationRecord = BusinessSettings::where(['key_name' => $keyName, 'settings_type' => 'customer_notification'])->first();
            if ($notificationRecord == null) {
                BusinessSettings::updateOrCreate(['key_name' => $keyName, 'settings_type' => 'customer_notification'], [
                    'key_name' => $keyName,
                    'live_values' => [
                        $keyName . '_status' => "1",
                        $keyName . '_message' => $value,
                    ],
                    'test_values' => [
                        $keyName . '_status' => "1",
                        $keyName . '_message' => $value,
                    ],
                    'settings_type' => 'customer_notification',
                    'mode' => 'live',
                    'is_active' => 1,
                ]);
            }
        });

        //notification for provider
        $provider_notification_collection = collect(NOTIFICATION_FOR_PROVIDER);

        $provider_notification_collection->each(function ($provider_notification) {
            $keyName = $provider_notification['key'];
            $value = $provider_notification['value'];

            $notificationRecord = BusinessSettings::where(['key_name' => $keyName, 'settings_type' => 'provider_notification'])->first();
            if ($notificationRecord == null) {
                BusinessSettings::updateOrCreate(['key_name' => $keyName, 'settings_type' => 'provider_notification'], [
                    'key_name' => $keyName,
                    'live_values' => [
                        $keyName . '_status' => "1",
                        $keyName . '_message' => $value,
                    ],
                    'test_values' => [
                        $keyName . '_status' => "1",
                        $keyName . '_message' => $value,
                    ],
                    'settings_type' => 'provider_notification',
                    'mode' => 'live',
                    'is_active' => 1,
                ]);
            }
        });

        //notification for serviceman
        $serviceman_notification_collection = collect(NOTIFICATION_FOR_SERVICEMAN);

        $serviceman_notification_collection->each(function ($serviceman_notification) {
            $keyName = $serviceman_notification['key'];
            $value = $serviceman_notification['value'];

            $notificationRecord = BusinessSettings::where(['key_name' => $keyName, 'settings_type' => 'serviceman_notification'])->first();
            if ($notificationRecord == null) {
                BusinessSettings::updateOrCreate(['key_name' => $keyName, 'settings_type' => 'serviceman_notification'], [
                    'key_name' => $keyName,
                    'live_values' => [
                        $keyName . '_status' => "1",
                        $keyName . '_message' => $value,
                    ],
                    'test_values' => [
                        $keyName . '_status' => "1",
                        $keyName . '_message' => $value,
                    ],
                    'settings_type' => 'serviceman_notification',
                    'mode' => 'live',
                    'is_active' => 1,
                ]);
            }
        });

        //for business and landing page
        $business_keys = [
            ['key_name' => 'about_us', 'settings_type' => 'pages_setup'],
            ['key_name' => 'privacy_policy', 'settings_type' => 'pages_setup'],
            ['key_name' => 'terms_and_conditions', 'settings_type' => 'pages_setup'],
            ['key_name' => 'refund_policy', 'settings_type' => 'pages_setup'],
            ['key_name' => 'cancellation_policy', 'settings_type' => 'pages_setup'],
            ['key_name' => 'top_title', 'settings_type' => 'landing_text_setup'],
            ['key_name' => 'top_description', 'settings_type' => 'landing_text_setup'],
            ['key_name' => 'top_sub_title', 'settings_type' => 'landing_text_setup'],
            ['key_name' => 'mid_title', 'settings_type' => 'landing_text_setup'],
            ['key_name' => 'about_us_title', 'settings_type' => 'landing_text_setup'],
            ['key_name' => 'about_us_description', 'settings_type' => 'landing_text_setup'],
            ['key_name' => 'registration_title', 'settings_type' => 'landing_text_setup'],
            ['key_name' => 'registration_description', 'settings_type' => 'landing_text_setup'],
            ['key_name' => 'bottom_title', 'settings_type' => 'landing_text_setup'],
            ['key_name' => 'bottom_description', 'settings_type' => 'landing_text_setup'],
            ['key_name' => 'web_top_title', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'web_top_description', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'web_mid_title', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'mid_sub_title_1', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'mid_sub_description_1', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'mid_sub_title_2', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'mid_sub_description_2', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'mid_sub_title_3', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'mid_sub_description_3', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'download_section_title', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'download_section_description', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'web_bottom_title', 'settings_type' => 'landing_web_app'],
            ['key_name' => 'testimonial_title', 'settings_type' => 'landing_web_app'],

        ];
        foreach ($business_keys as $key_number => $business_data) {
            $businessSetting = BusinessSettings::where('key_name', $business_keys[$key_number]['key_name'])
                ->where('settings_type', $business_keys[$key_number]['settings_type'])
                ->first();

            if ($businessSetting) {
                $key_name = $businessSetting->key_name;
                $isActive = $businessSetting->is_active;
                $type = $businessSetting->settings_type;

                // Check if the record already exists in DataSetting
                $dataSettingExists = DataSetting::where('key', $key_name)->where('type', $type)->exists();

                // Update or insert into data_settings table if not exists
                if (!$dataSettingExists) {
                    DataSetting::updateOrCreate(
                        ['key' => $key_name, 'type' => $type],
                        [
                            'key' => $key_name,
                            'value' => $businessSetting->live_values,
                            'type' => $type,
                            'is_active' => $isActive,
                        ]
                    );
                }
            }
        }


        $specialites = BusinessSettings::where('key_name', 'speciality')
            ->where('settings_type', 'landing_speciality')
            ->first();


        if ($specialites) {
            $business_values = $specialites?->live_values;

            foreach ($business_values as $data_value) {

                // Check if the record already exists in Speciality
                $speciality = LandingPageSpeciality::where('title', $data_value['title'])->where('description', $data_value['description'])->exists();

                // Update or insert into speciality table if not exists
                if (!$speciality) {
                    $speciality = new LandingPageSpeciality();
                    $speciality->title = $data_value['title'];
                    $speciality->description = $data_value['description'];
                    $speciality->image = $data_value['image'];
                    $speciality->save();
                }
            }
        }

        $testimonials = BusinessSettings::where('key_name', 'testimonial')
            ->where('settings_type', 'landing_testimonial')
            ->first();


        if ($testimonials) {
            $business_values = $testimonials?->live_values;

            foreach ($business_values as $data_value) {

                // Check if the record already exists in Speciality
                $testimonial = LandingPageTestimonial::where('name', $data_value['name'])->where('designation', $data_value['designation'])->exists();

                // Update or insert into speciality table if not exists
                if (!$testimonial) {
                    $testimonial = new LandingPageTestimonial();
                    $testimonial->name = $data_value['name'];
                    $testimonial->designation = $data_value['designation'];
                    $testimonial->review = $data_value['review'];
                    $testimonial->image = $data_value['image'];
                    $testimonial->save();
                }
            }
        }

        $features = BusinessSettings::where('key_name', 'features')
            ->where('settings_type', 'landing_features')
            ->first();


        if ($features) {
            $business_values = $features?->live_values;

            foreach ($business_values as $data_value) {

                // Check if the record already exists in Speciality
                $feature = LandingPageFeature::where('title', $data_value['title'])->where('sub_title', $data_value['sub_title'])->exists();

                // Update or insert into speciality table if not exists
                if (!$feature) {
                    $feature = new LandingPageFeature();
                    $feature->title = $data_value['title'];
                    $feature->sub_title = $data_value['sub_title'];
                    $feature->image_1 = $data_value['image_1'];
                    $feature->image_2 = $data_value['image_2'];
                    $feature->save();
                }
            }
        }


        //user referral code
        $users = User::whereNull('ref_code')->get();
        foreach ($users as $user) {
            $user->ref_code = generate_referer_code();
            $user->save();
        }

        return redirect(env('APP_URL'));
    }

    private function set_data()
    {
        try {
            $gateway = [
                'sslcommerz',
                'razor_pay',
                'stripe',
                'senang_pay',
                'paystack',
                'flutterwave',
            ];

            $data = BusinessSettings::whereIn('key_name', $gateway)->pluck('live_values', 'key_name')->toArray();


            foreach ($data as $key => $value) {

                $gateway = $key;
                if ($key == 'sslcommerz') {
                    $gateway = 'ssl_commerz';
                }

                $data = ['gateway' => $gateway,
                    'mode' => isset($value['status']) == 1 ? 'live' : 'test'
                ];

                if ($gateway == 'ssl_commerz') {
                    $additional_data = [
                        'status' => $value['status'],
                        'store_id' => $value['store_id'],
                        'store_password' => $value['store_password'],
                    ];
                } elseif ($gateway == 'stripe') {
                    $additional_data = [
                        'status' => $value['status'],
                        'api_key' => $value['api_key'],
                        'published_key' => $value['published_key'],
                    ];
                } elseif ($gateway == 'razor_pay') {
                    $additional_data = [
                        'status' => $value['status'],
                        'api_key' => $value['api_key'],
                        'api_secret' => $value['api_secret'],
                    ];
                } elseif ($gateway == 'senang_pay') {
                    $additional_data = [
                        'status' => $value['status'],
                        'callback_url' => $value['callback_url'],
                        'secret_key' => $value['secret_key'],
                        'merchant_id' => $value['merchant_id'],
                    ];
                } elseif ($gateway == 'paystack') {
                    $additional_data = [
                        'status' => $value['status'],
                        'public_key' => $value['public_key'],
                        'secret_key' => $value['secret_key'],
                        'merchant_email' => $value['merchant_email'],
                    ];
                } elseif ($gateway == 'flutterwave') {
                    $additional_data = [
                        'status' => $value['status'],
                        'secret_key' => $value['secret_key'],
                        'public_key' => $value['public_key'],
                        'hash' => $value['hash'],
                    ];
                }

                $credentials = json_encode(array_merge($data, $additional_data));

                $payment_additional_data = ['gateway_title' => ucfirst(str_replace('_', ' ', $gateway)),
                    'gateway_image' => null];

                DB::table('addon_settings')->updateOrInsert(['key_name' => $gateway, 'settings_type' => 'payment_config'], [
                    'key_name' => $gateway,
                    'live_values' => $credentials,
                    'test_values' => $credentials,
                    'settings_type' => 'payment_config',
                    'mode' => isset($decoded_value['status']) == 1 ? 'live' : 'test',
                    'is_active' => isset($decoded_value['status']) == 1 ? 1 : 0,
                    'additional_data' => json_encode($payment_additional_data),
                ]);
            }

        } catch (\Exception $exception) {
            Toastr::error('Database import failed! try again');
            return true;
        }
        return true;
    }
}
