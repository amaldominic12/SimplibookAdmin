<?php

namespace Modules\BusinessSettingsModule\Http\Controllers\Web\Admin;

use App\Traits\ActivationClass;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Modules\BusinessSettingsModule\Entities\BusinessSettings;
use Illuminate\Contracts\Support\Renderable;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    use ActivationClass;

    private BusinessSettings $business_setting;

    public function __construct(BusinessSettings $business_setting)
    {
        $this->business_setting = $business_setting;

        if (request()->isMethod('get')) {
            $response = $this->actch();
            $data = json_decode($response->getContent(), true);
            if (!$data['active']) {
                return Redirect::away(base64_decode('aHR0cHM6Ly82YW10ZWNoLmNvbS9zb2Z0d2FyZS1hY3RpdmF0aW9u'))->send();
            }
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse|void
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable',
            'code' => 'required',
        ],[
            'code' => translate('Country code select is required'),
        ]);

        $language = business_config('system_language', 'business_information');
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
        if (!isset($language)) {
            BusinessSettings::updateOrCreate(['key_name' => 'system_language', 'settings_type' => 'business_information'], [
                'live_values' => $lan_data,
                'test_values' => $lan_data,
            ]);
            $language = business_config('system_language', 'business_information');
        }

        $lang_array = [];
        $codes = [];
        foreach ($language?->live_values as $key => $data) {
            if ($data['code'] != $request['code']) {
                if (!array_key_exists('default', $data)) {
                    $default = array('default' => ($data['code'] == 'en') ? true : false);
                    $data = array_merge($data, $default);
                }
                $lang_array[] = $data;
                $codes[] = $data['code'];
            }
        }
        $codes[] = $request['code'];

        if (!file_exists(base_path('resources/lang/' . $request['code']))) {
            mkdir(base_path('resources/lang/' . $request['code']), 0777, true);
        }

        $lang_file = fopen(base_path('resources/lang/' . $request['code'] . '/' . 'lang.php'), "w") or die("Unable to open file!");
        $read = file_get_contents(base_path('resources/lang/en/lang.php'));
        fwrite($lang_file, $read);

        $lang_array[] = [
            'id' => count($language?->live_values) + 1,
            'name' => $request['code'],
            'code' => $request['code'],
            'direction' => $request['direction'],
            'status' => 1,
            'default' => false,
        ];

        $this->business_setting->updateOrCreate(['key_name' => 'system_language'], [
            'live_values' => $lang_array,
            'test_values' => $lang_array,
        ]);

        Toastr::success(translate('Language Added!'));
        return back();
    }

    public function update_status(Request $request)
    {
        $language = $this->business_setting->where('key_name', 'system_language')->first();
        $lang_array = [];
        foreach ($language?->live_values as $key => $data) {

            if ($data['code'] == $request['code']) {
                if( array_key_exists('default', $data) && $data['default'] == true ){
                    return response()->json(['error' => 403]);
                }
                $lang = [
                    'id' => $data['id'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'] == 1 ? 0 : 1,
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            } else {
                $lang = [
                    'id' => $data['id'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'],
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            }
        }
        $this->business_setting->where('key_name', 'system_language')->update([
            'live_values' => $lang_array,
            'test_values' => $lang_array,
        ]);

        return response()->json(DEFAULT_STATUS_UPDATE_200, 200);
    }

    public function update_default_status(Request $request): \Illuminate\Http\JsonResponse
    {
        $language = $this->business_setting->where('key_name', 'system_language')->first();
        $lang_array = [];
        foreach ($language?->live_values as $key => $data) {
            if ($data['code'] == $request['code']) {
                $lang = [
                    'id' => $data['id'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => 1,
                    'default' => true,
                ];
                $lang_array[] = $lang;
            } else {
                $lang = [
                    'id' => $data['id'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'],
                    'default' => false,
                ];
                $lang_array[] = $lang;
            }
        }
        $this->business_setting->where('key_name', 'system_language')->update([
            'live_values' => $lang_array,
            'test_values' => $lang_array,
        ]);

        $direction = $this->business_setting->where('key_name', 'site_direction')->first();
        $direction = $direction->value ?? 'ltr';
        $language = $this->business_setting->where('key_name', 'system_language')->first();
        foreach ($language?->live_values ?? [] as $key => $data) {
            if ($data['code'] == $request['code']) {
                $direction = isset($data['direction']) ? $data['direction'] : 'ltr';
            }
        }
        session()->forget('language_settings');
        language_load();
        session()->put('local', $request['code']);
        session()->put('site_direction', $direction);
//        Toastr::success('Default Language Changed!');
        return response()->json(DEFAULT_UPDATE_200, 200);
    }

    public function update(Request $request): RedirectResponse
    {
        $language = $this->business_setting->where('key_name', 'system_language')->first();
        $lang_array = [];
        foreach ($language?->live_values as $key => $data) {
            if ($data['code'] == $request['code']) {
                $lang = [
                    'id' => $data['id'],
                    'direction' => $request['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'],
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            } else {
                $lang = [
                    'id' => $data['id'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'],
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            }
        }
        $this->business_setting->where('key_name', 'system_language')->update([
            'live_values' => $lang_array,
            'test_values' => $lang_array,
        ]);
        Toastr::success('Language updated!');
        return back();
    }

    public function convertArrayToCollection($lang, $items, $perPage = null, $page = null, $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options = [
            "path" => route('admin.language.translate',[$lang]),
            "pageName" => "page"
        ];
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function translate(Request $request,$lang): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $searchTerm =$request['search'];
        $full_data = include(base_path('resources/lang/' . $lang . '/lang.php'));
        $full_data = array_filter($full_data, fn($value) => !is_null($value) && $value !== '');

        // If a search term is provided, filter the array based on the search term
        if (!empty($searchTerm)) {
            $full_data = array_filter($full_data, function ($value, $key) use ($searchTerm) {
                return (stripos($value, $searchTerm) !== false) || (stripos(ucfirst(str_replace('_', ' ', remove_invalid_charcaters($key))), $searchTerm) !== false);
            }, ARRAY_FILTER_USE_BOTH);
        }


        ksort($full_data);
        $full_data = $this->convertArrayToCollection($lang,$full_data,config('default_pagination'));

        return view('businesssettingsmodule::admin.translation-page', compact('lang', 'full_data'));
    }

    public function translate_key_remove(Request $request, $lang): void
    {
        $full_data = include(base_path('resources/lang/' . $lang . '/lang.php'));
        unset($full_data[$request['key']]);
        $str = "<?php return " . var_export($full_data, true) . ";";
        file_put_contents(base_path('resources/lang/' . $lang . '/lang.php'), $str);
    }

    public function translate_submit(Request $request, $lang): void
    {
        $full_data = include(base_path('resources/lang/' . $lang . '/lang.php'));
        $full_data[urldecode($request['key'])] = $request['value'];
        $str = "<?php return " . var_export($full_data, true) . ";";
        file_put_contents(base_path('resources/lang/' . $lang . '/lang.php'), $str);
    }

    public function auto_translate(Request $request, $lang): \Illuminate\Http\JsonResponse
    {
        $lang_code = getLanguageCode($lang);
        $full_data = include(base_path('resources/lang/' . $lang . '/lang.php'));
        $data_filtered = [];
        foreach ($full_data as $key => $data) {
            $data_filtered[$key] = $data;
        }
        $translated=  str_replace('_', ' ', remove_invalid_charcaters($request['key']));
        $translated = auto_translator($translated, 'en', $lang_code);
        $data_filtered[$request['key']] = $translated;
        $str = "<?php return " . var_export($data_filtered, true) . ";";
        file_put_contents(base_path('resources/lang/' . $lang . '/lang.php'), $str);

        return response()->json([
            'translated_data' => $translated
        ]);
    }

    public function delete($lang): RedirectResponse
    {
        $language = $this->business_setting->where('key_name', 'system_language')->first();

        $del_default = false;
        foreach ($language?->live_values as $key => $data) {
            if ($data['code'] == $lang && array_key_exists('default', $data) && $data['default'] == true) {
                $del_default = true;
            }
        }

        $lang_array = [];
        foreach ($language?->live_values as $key => $data) {
            if ($data['code'] != $lang) {
                $lang_data = [
                    'id' => $data['id'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => ($del_default == true && $data['code'] == 'en') ? 1 : $data['status'],
                    'default' => ($del_default == true && $data['code'] == 'en') ? true : (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                array_push($lang_array, $lang_data);
            }
        }

        $this->business_setting->where('key_name', 'system_language')->update([
            'live_values' => $lang_array,
            'test_values' => $lang_array,
        ]);

        $dir = base_path('resources/lang/' . $lang);
        if (File::isDirectory($dir)) {
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
        }


        $languages = array();
        $language = $this->business_setting->where('key_name', 'system_language')->first();
        foreach ($language?->live_values as $key => $data) {
            if ($data != $lang) {
                array_push($languages, $data);
            }
        }
        if (in_array('en', $languages)) {
            unset($languages[array_search('en', $languages)]);
        }
        array_unshift($languages, 'en');

        $this->business_setting->updateOrCreate(['key_name' => 'language'], [
            'live_values' => $languages,
            'test_values' => $languages,
        ]);

        Toastr::success('Removed Successfully!');
        return back();
    }

    public function lang($local): RedirectResponse
    {
        $direction = $this->business_setting->where('key_name', 'site_direction')->first();
        $direction = $direction->live_values ?? 'ltr';
        $language = $this->business_setting->where('key_name', 'system_language')->first();
        foreach ($language?->live_values as $key => $data) {
            if ($data['code'] == $local) {
                $direction = isset($data['direction']) ? $data['direction'] : 'ltr';
            }
        }
        session()->forget('language_settings');
        language_load();
        session()->put('local', $local);
        session()->put('site_direction', $direction);
        return redirect()->back();
    }
}
