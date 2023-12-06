<?php

namespace App\Http\Controllers;

use Dflydev\DotAccessData\Data;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\BusinessSettingsModule\Entities\BusinessSettings;
use Modules\BusinessSettingsModule\Entities\DataSetting;
use Modules\BusinessSettingsModule\Entities\LandingPageFeature;
use Modules\BusinessSettingsModule\Entities\LandingPageSpeciality;
use Modules\BusinessSettingsModule\Entities\LandingPageTestimonial;
use Modules\CategoryManagement\Entities\Category;

class LandingController extends Controller
{
    private BusinessSettings $businessSettings;
    private DataSetting $data_setting;
    private Category $category;

    public function __construct(BusinessSettings $businessSettings, Category $category, DataSetting $data_setting)
    {
        $this->businessSettings = $businessSettings;
        $this->data_setting = $data_setting;
        $this->category = $category;
    }

    public function home(): Factory|View|Application
    {
        $settings = $this->businessSettings->whereNotIn('settings_type', ['payment_config', 'third_party'])->get();
        $settingss = $this->data_setting->whereIn('type', ['landing_web_app', 'landing_text_setup'])->get();
        $categories = $this->category->ofType('main')->ofStatus(1)->with(['children'])->withCount('zones')->get();
        $testimonials = LandingPageTestimonial::all();
        $features = LandingPageFeature::all();
        $specialities = LandingPageSpeciality::all();

        return view('welcome', compact('settings', 'categories', 'testimonials', 'features', 'specialities', 'settingss'));
    }

    public function about_us(): Factory|View|Application
    {
        $settings = $this->businessSettings->whereNotIn('settings_type', ['payment_config', 'third_party'])->get();
        $data_settings = $this->data_setting->where('type', 'pages_setup')->get();
        return view('about-us', compact('settings', 'data_settings'));
    }

    public function privacy_policy(): Factory|View|Application
    {
        $settings = $this->businessSettings->whereNotIn('settings_type', ['payment_config', 'third_party'])->get();
        $data_settings = $this->data_setting->where('type', 'pages_setup')->get();
        return view('privacy-policy', compact('settings', 'data_settings'));
    }

    public function terms_and_conditions(): Factory|View|Application
    {
        $settings = $this->businessSettings->whereNotIn('settings_type', ['payment_config', 'third_party'])->get();
        $data_settings = $this->data_setting->where('type', 'pages_setup')->get();
        return view('terms-and-conditions', compact('settings', 'data_settings'));
    }

    public function contact_us()
    {
        $settings = $this->businessSettings->whereNotIn('settings_type', ['payment_config', 'third_party'])->get();
        return view('contact-us', compact('settings'));
    }

    public function cancellation_policy(): Factory|View|Application
    {
        $settings = $this->businessSettings->whereNotIn('settings_type', ['payment_config', 'third_party'])->get();
        $data_settings = $this->data_setting->where('type', 'pages_setup')->get();
        return view('cancellation-policy', compact('settings', 'data_settings'));
    }

    public function refund_policy(): Factory|View|Application
    {
        $settings = $this->businessSettings->whereNotIn('settings_type', ['payment_config', 'third_party'])->get();
        $data_settings = $this->data_setting->where('type', 'pages_setup')->get();
        return view('refund-policy', compact('settings', 'data_settings'));
    }

    public function lang($local): \Illuminate\Http\RedirectResponse
    {
        $direction = $this->businessSettings->where('key_name', 'site_direction')->first();
        $direction = $direction->live_values ?? 'ltr';
        $language = $this->businessSettings->where('key_name', 'system_language')->first();
        foreach ($language?->live_values as $key => $data) {
            if ($data['code'] == $local) {
                $direction = isset($data['direction']) ? $data['direction'] : 'ltr';
            }
        }
        session()->forget('landing_language_settings');
        landing_language_load();
        session()->put('landing_site_direction', $direction);
        session()->put('landing_local', $local);
        return redirect()->back();
    }
}
