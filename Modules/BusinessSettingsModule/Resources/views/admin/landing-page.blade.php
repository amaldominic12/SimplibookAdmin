@extends('adminmodule::layouts.master')

@section('title',translate('landing_page_setup'))

@push('css_or_js')
    <link rel="stylesheet" href="{{asset('public/assets/admin-module')}}/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="{{asset('public/assets/admin-module')}}/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="{{asset('public/assets/admin-module')}}/plugins/dataTables/select.dataTables.min.css"/>
@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title">{{translate('landing_page_setup')}}</h2>
                    </div>

                    <!-- Nav Tabs -->
                    <div class="mb-3">
                        <ul class="nav nav--tabs nav--tabs__style2">
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=text_setup"
                                   class="nav-link {{$web_page=='text_setup'?'active':''}}">
                                    {{translate('text_setup')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=button_and_links"
                                   class="nav-link {{$web_page=='button_and_links'?'active':''}}">
                                    {{translate('button_&_links')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=speciality"
                                   class="nav-link {{$web_page=='speciality'?'active':''}}">
                                    {{translate('speciality')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=testimonial"
                                   class="nav-link {{$web_page=='testimonial'?'active':''}}">
                                    {{translate('testimonial')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=features"
                                   class="nav-link {{$web_page=='features'?'active':''}}">
                                    {{translate('features')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=images"
                                   class="nav-link {{$web_page=='images'?'active':''}}">
                                    {{translate('images')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=background"
                                   class="nav-link {{$web_page=='background'?'active':''}}">
                                    {{translate('background')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=social_media"
                                   class="nav-link {{$web_page=='social_media'?'active':''}}">
                                    {{translate('social_media')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=meta"
                                   class="nav-link {{$web_page=='meta'?'active':''}}">
                                    {{translate('meta')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=web_app"
                                   class="nav-link {{$web_page=='web_app'?'active':''}}">
                                    {{translate('Web_App')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url()->current()}}?web_page=web_app_image"
                                   class="nav-link {{$web_page=='web_app_image'?'active':''}}">
                                    {{translate('Web_App')}} <small class="opacity-75">({{translate('Images')}})</small>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Nav Tabs -->

                    <!-- Tab Content -->
                    @if($web_page=='text_setup')
                        @php($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first())
                        @php($default_lang = str_replace('_', '-', app()->getLocale()))
                        @if($language)
                            <ul class="nav nav--tabs border-color-primary mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active"
                                       href="#"
                                       id="default-link">{{translate('default')}}</a>
                                </li>
                                @foreach ($language?->live_values as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link"
                                           href="#"
                                           id="{{ $lang['code'] }}-link">{{ get_language_name($lang['code']) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='text_setup'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <form action="javascript:void(0)" method="POST" id="landing-info-update-form">
                                            @csrf
                                            @method('PUT')
                                            @if ($language)
                                                <div class="discount-type lang-form default-form">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="top_title[]"
                                                                           value="{{$data_values->where('key','top_title')->first()?->getRawOriginal('value') ?? ''}}">
                                                                    <label>{{translate('top_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="top_description[]"
                                                                           value="{{$data_values->where('key','top_description')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('top_description')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="top_sub_title[]"
                                                                           value="{{$data_values->where('key','top_sub_title')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('top_sub_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_title[]"
                                                                           value="{{$data_values->where('key','mid_title')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('mid_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="about_us_title[]"
                                                                           value="{{$data_values->where('key','about_us_title')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('about_us_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="about_us_description[]"
                                                                           value="{{$data_values->where('key','about_us_description')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('about_us_description')}}
                                                                        *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="registration_title[]"
                                                                           value="{{$data_values->where('key','registration_title')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('registration_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="registration_description[]"
                                                                           value="{{$data_values->where('key','registration_description')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('registration_description')}}
                                                                        *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="bottom_title[]"
                                                                           value="{{$data_values->where('key','bottom_title')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('bottom_title')}} *</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                                @foreach ($language?->live_values as $lang)
                                                        <?php
                                                        $top_title = $data_values->where('key', 'top_title')->where('type', 'landing_text_setup')->first();
                                                        $top_description = $data_values->where('key', 'top_description')->where('type', 'landing_text_setup')->first();
                                                        $top_sub_title = $data_values->where('key', 'top_sub_title')->where('type', 'landing_text_setup')->first();
                                                        $mid_title = $data_values->where('key', 'mid_title')->where('type', 'landing_text_setup')->first();
                                                        $about_us_title = $data_values->where('key', 'about_us_title')->where('type', 'landing_text_setup')->first();
                                                        $about_us_description = $data_values->where('key', 'about_us_description')->where('type', 'landing_text_setup')->first();
                                                        $registration_title = $data_values->where('key', 'registration_title')->where('type', 'landing_text_setup')->first();
                                                        $registration_description = $data_values->where('key', 'registration_description')->where('type', 'landing_text_setup')->first();
                                                        $bottom_title = $data_values->where('key', 'bottom_title')->where('type', 'landing_text_setup')->first();
                                                        if (isset($top_title['translations']) && count($top_title['translations'])) {
                                                            $translate_top_title = [];
                                                            foreach ($top_title['translations'] as $t) {

                                                                if ($t->locale == $lang['code'] && $t->key == "top_title") {
                                                                    $translate_top_title[$lang['code']]['top_title'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($top_description['translations']) && count($top_description['translations'])) {
                                                            $translate_top_description = [];
                                                            foreach ($top_description['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "top_description") {
                                                                    $translate_top_description[$lang['code']]['top_description'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($top_sub_title['translations']) && count($top_sub_title['translations'])) {
                                                            $translate_top_sub_title = [];
                                                            foreach ($top_sub_title['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "top_sub_title") {
                                                                    $translate_top_sub_title[$lang['code']]['top_sub_title'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($mid_title['translations']) && count($mid_title['translations'])) {
                                                            $translate_mid_title = [];
                                                            foreach ($mid_title['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "mid_title") {
                                                                    $translate_mid_title[$lang['code']]['mid_title'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($about_us_title['translations']) && count($about_us_title['translations'])) {
                                                            $translate_about_us_title = [];
                                                            foreach ($about_us_title['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "about_us_title") {
                                                                    $translate_about_us_title[$lang['code']]['about_us_title'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($about_us_description['translations']) && count($about_us_description['translations'])) {
                                                            $translate_about_us_description = [];
                                                            foreach ($about_us_description['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "about_us_description") {
                                                                    $translate_about_us_description[$lang['code']]['about_us_description'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($registration_title['translations']) && count($registration_title['translations'])) {
                                                            $translate_registration_title = [];
                                                            foreach ($registration_title['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "registration_title") {
                                                                    $translate_registration_title[$lang['code']]['registration_title'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($registration_description['translations']) && count($registration_description['translations'])) {
                                                            $translate_registration_description = [];
                                                            foreach ($registration_description['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "registration_description") {
                                                                    $translate_registration_description[$lang['code']]['registration_description'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($bottom_title['translations']) && count($bottom_title['translations'])) {
                                                            $translate_bottom_title = [];
                                                            foreach ($bottom_title['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "bottom_title") {
                                                                    $translate_bottom_title[$lang['code']]['bottom_title'] = $t->value;
                                                                }
                                                            }
                                                        }
                                                        ?>

                                                    <div class="discount-type d-none lang-form {{$lang['code']}}-form">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="top_title[]"
                                                                               value="{{ $translate_top_title[$lang['code']]['top_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                        <label>{{translate('top_title')}} *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="top_description[]"
                                                                               value="{{ $translate_top_description[$lang['code']]['top_description'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                        <label>{{translate('top_description')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="top_sub_title[]"
                                                                               value="{{ $translate_top_sub_title[$lang['code']]['top_sub_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                        <label>{{translate('top_sub_title')}} *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="mid_title[]"
                                                                               value="{{ $translate_mid_title[$lang['code']]['mid_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                        <label>{{translate('mid_title')}} *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="about_us_title[]"
                                                                               value="{{ $translate_about_us_title[$lang['code']]['about_us_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                        <label>{{translate('about_us_title')}} *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="about_us_description[]"
                                                                               value="{{ $translate_about_us_description[$lang['code']]['about_us_description'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                        <label>{{translate('about_us_description')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="registration_title[]"
                                                                               value="{{ $translate_registration_title[$lang['code']]['registration_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                        <label>{{translate('registration_title')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="registration_description[]"
                                                                               value="{{ $translate_registration_description[$lang['code']]['registration_description'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                        <label>{{translate('registration_description')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="bottom_title[]"
                                                                               value="{{ $translate_bottom_title[$lang['code']]['bottom_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                        <label>{{translate('bottom_title')}} *</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="{{$lang['code']}}">
                                                @endforeach
                                            @else
                                                <div class="discount-type lang-form">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="top_title[]"
                                                                           value="{{$data_values->where('key','top_title')->first()->value ?? ''}}">
                                                                    <label>{{translate('top_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="top_description[]"
                                                                           value="{{$data_values->where('key','top_description')->first()->value ?? ''}}">
                                                                    <label>{{translate('top_description')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="top_sub_title[]"
                                                                           value="{{$data_values->where('key','top_sub_title')->first()->value ?? ''}}">
                                                                    <label>{{translate('top_sub_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_title[]"
                                                                           value="{{$data_values->where('key','mid_title')->first()->value ?? ''}}">
                                                                    <label>{{translate('mid_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="about_us_title[]"
                                                                           value="{{$data_values->where('key','about_us_title')->first()->value ?? ''}}">
                                                                    <label>{{translate('about_us_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="about_us_description[]"
                                                                           value="{{$data_values->where('key','about_us_description')->first()->value ?? ''}}">
                                                                    <label>{{translate('about_us_description')}}
                                                                        *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="registration_title[]"
                                                                           value="{{$data_values->where('key','registration_title')->first()->value ?? ''}}">
                                                                    <label>{{translate('registration_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="registration_description[]"
                                                                           value="{{$data_values->where('key','registration_description')->first()->value ?? ''}}">
                                                                    <label>{{translate('registration_description')}}
                                                                        *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="bottom_title[]"
                                                                           value="{{$data_values->where('key','bottom_title')->first()->value ?? ''}}">
                                                                    <label>{{translate('bottom_title')}} *</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                            @endif

                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="reset" class="btn btn-secondary">
                                                    {{translate('reset')}}
                                                </button>
                                                <button type="submit" class="btn btn--primary">
                                                    {{translate('update')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page=='button_and_links')
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='button_and_links'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <form action="javascript:void(0)" method="POST" id="landing-info-update-form">
                                            @csrf
                                            @method('PUT')
                                            <div class="discount-type">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        @php($value=$data_values->where('key_name','app_url_playstore')->first()->is_active??0)
                                                        <label class="switcher mb-4">
                                                            <input class="switcher_input" type="checkbox"
                                                                   name="app_url_playstore_is_active"
                                                                   {{$value?'checked':''}}
                                                                   value="1">
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="app_url_playstore"
                                                                       value="{{$data_values->where('key_name','app_url_playstore')->first()->live_values??''}}">
                                                                <label>
                                                                    {{translate('app_url_( playstore )')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        @php($value=$data_values->where('key_name','app_url_appstore')->first()->is_active??0)
                                                        <label class="switcher mb-4">
                                                            <input class="switcher_input" type="checkbox"
                                                                   name="app_url_appstore_is_active"
                                                                   {{$value?'checked':''}}
                                                                   value="1">
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="app_url_appstore"
                                                                       value="{{$data_values->where('key_name','app_url_appstore')->first()->live_values??''}}">
                                                                <label>
                                                                    {{translate('app_url_( appstore )')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        @php($value=$data_values->where('key_name','web_url')->first()->is_active??0)
                                                        <label class="switcher mb-4">
                                                            <input class="switcher_input" type="checkbox"
                                                                   name="web_url_is_active"
                                                                   {{$value?'checked':''}}
                                                                   value="1">
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="web_url"
                                                                       value="{{$data_values->where('key_name','web_url')->first()->live_values??''}}">
                                                                <label>{{translate('web_url')}} *</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="reset" class="btn btn-secondary">
                                                    {{translate('reset')}}
                                                </button>
                                                <button type="submit" class="btn btn--primary">
                                                    {{translate('update')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page=='speciality')
                        @php($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first())
                        @php($default_lang = str_replace('_', '-', app()->getLocale()))
                        @if($language)
                            <ul class="nav nav--tabs border-color-primary mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active"
                                       href="#"
                                       id="default-link">{{translate('default')}}</a>
                                </li>
                                @foreach ($language?->live_values as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link"
                                           href="#"
                                           id="{{ $lang['code'] }}-link">{{ get_language_name($lang['code']) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='speciality'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <form
                                            action="{{route('admin.business-settings.set-landing-speciality')}}?web_page={{$web_page}}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="discount-type">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if($language)
                                                            <div class="lang-form default-form">
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="title[]">
                                                                        <label>
                                                                            {{translate('speciality_title')}}
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="description[]">
                                                                        <label>
                                                                            {{translate('speciality_description')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="lang[]" value="default">
                                                            @foreach ($language?->live_values as $lang)
                                                                <div
                                                                    class="mb-30 d-none lang-form {{$lang['code']}}-form">
                                                                    <div class="mb-30">
                                                                        <div class="form-floating">
                                                                            <input type="text" class="form-control"
                                                                                   name="title[]" {{$lang['status'] == '1' ? 'required':''}}
                                                                                   @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                            <label>
                                                                                {{translate('speciality_title')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-30">
                                                                        <div class="form-floating">
                                                                            <input type="text" class="form-control"
                                                                                   name="description[]" {{$lang['status'] == '1' ? 'required':''}}
                                                                                   @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                            <label>
                                                                                {{translate('speciality_description')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="lang[]"
                                                                       value="{{$lang['code']}}">
                                                            @endforeach
                                                        @else
                                                            <div class="lang-form">
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="title[]">
                                                                        <label>
                                                                            {{translate('speciality_title')}}
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="description[]">
                                                                        <label>
                                                                            {{translate('speciality_description')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="lang[]" value="default">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-30 d-flex flex-column align-items-center gap-2">
                                                            <div class="upload-file mb-30 max-w-100">
                                                                <input type="file" class="upload-file__input"
                                                                       name="image">
                                                                <div class="upload-file__img">
                                                                    <img
                                                                        src='{{asset('public/assets/admin-module/img/media/upload-file.png')}}'
                                                                        alt="">
                                                                </div>
                                                                <span class="upload-file__edit">
                                                                    <span class="material-icons">edit</span>
                                                                </span>
                                                            </div>
                                                            <p class="opacity-75 max-w220">{{translate('Image format - jpg, png, jpeg, gif Image Size - maximum size 2 MB Image Ratio - 1:1')}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="reset" class="btn btn-secondary">
                                                    {{translate('reset')}}
                                                </button>
                                                <button type="submit" class="btn btn--primary">
                                                    {{translate('add')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="card-body p-30">
                                        <div class="table-responsive">
                                            <table id="example" class="table align-middle">
                                                <thead>
                                                <tr>
                                                    <th>{{translate('title')}}</th>
                                                    <th>{{translate('description')}}</th>
                                                    <th>{{translate('image')}}</th>
                                                    <th>{{translate('action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($specialities??[] as $key=>$item)
                                                    <tr>
                                                        <td>{{$item['title']}}</td>
                                                        <td>{{$item['description']}}</td>
                                                        <td>
                                                            <img style="height: 50px;width: 50px"
                                                                 src="{{asset('storage/app/public/landing-page')}}/{{$item['image']}}">
                                                        </td>
                                                        <td>
                                                            <div class="table-actions">
                                                                <button type="button"
                                                                        onclick="form_alert('delete-{{$item['id']}}','{{translate('want_to_delete_this')}}?')"
                                                                        class="table-actions_delete bg-transparent border-0 p-0">
                                                                    <span class="material-icons">delete</span>
                                                                </button>
                                                                <form
                                                                    action="{{route('admin.business-settings.delete-landing-speciality',[$item['id']])}}"
                                                                    method="post" id="delete-{{$item['id']}}"
                                                                    class="hidden">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page=='testimonial')
                        @php($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first())
                        @php($default_lang = str_replace('_', '-', app()->getLocale()))
                        @if($language)
                            <ul class="nav nav--tabs border-color-primary mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active"
                                       href="#"
                                       id="default-link">{{translate('default')}}</a>
                                </li>
                                @foreach ($language?->live_values as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link"
                                           href="#"
                                           id="{{ $lang['code'] }}-link">{{ get_language_name($lang['code']) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='testimonial'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <form
                                            action="{{route('admin.business-settings.set-landing-testimonial')}}?web_page={{$web_page}}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="discount-type">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if($language)
                                                            <div class="lang-form default-form">
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="name[]">
                                                                        <label>
                                                                            {{translate('reviewer_name')}}
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="designation[]">
                                                                        <label>
                                                                            {{translate('reviewer_designation')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="review[]">
                                                                        <label>
                                                                            {{translate('review')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="lang[]" value="default">
                                                            @foreach ($language?->live_values as $lang)
                                                                <div class="mb-30 d-none lang-form {{$lang['code']}}-form">
                                                                    <div class="mb-30">
                                                                        <div class="form-floating">
                                                                            <input type="text" class="form-control"
                                                                                   name="name[]" {{$lang['status'] == '1' ? 'required':''}}
                                                                                   @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                            <label>
                                                                                {{translate('reviewer_name')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-30">
                                                                        <div class="form-floating">
                                                                            <input type="text" class="form-control"
                                                                                   name="designation[]" {{$lang['status'] == '1' ? 'required':''}}
                                                                                   @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                            <label>
                                                                                {{translate('reviewer_designation')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-30">
                                                                        <div class="form-floating">
                                                                            <input type="text" class="form-control"
                                                                                   name="review[]" {{$lang['status'] == '1' ? 'required':''}}
                                                                                   @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                            <label>
                                                                                {{translate('review')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="lang[]"
                                                                       value="{{$lang['code']}}">
                                                            @endforeach
                                                        @else
                                                            <div class="lang-form">
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="name[]">
                                                                        <label>
                                                                            {{translate('reviewer_name')}}
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="designation[]">
                                                                        <label>
                                                                            {{translate('reviewer_designation')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="review[]">
                                                                        <label>
                                                                            {{translate('review')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-30 d-flex flex-column align-items-center gap-2">
                                                            <div class="upload-file mb-30 max-w-100">
                                                                <input type="file" class="upload-file__input"
                                                                       name="image">
                                                                <div class="upload-file__img">
                                                                    <img
                                                                        src='{{asset('public/assets/admin-module/img/media/upload-file.png')}}'
                                                                        alt="">
                                                                </div>
                                                                <span class="upload-file__edit">
                                                                    <span class="material-icons">edit</span>
                                                                </span>
                                                            </div>
                                                            <p class="opacity-75 max-w220">{{translate('Image format - jpg, png, jpeg, gif Image Size - maximum size 2 MB Image Ratio - 1:1')}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="reset" class="btn btn-secondary">
                                                    {{translate('reset')}}
                                                </button>
                                                <button type="submit" class="btn btn--primary">
                                                    {{translate('add')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="card-body p-30">
                                        <div class="table-responsive">
                                            <table id="example" class="table align-middle">
                                                <thead>
                                                <tr>
                                                    <th>{{translate('name')}}</th>
                                                    <th>{{translate('designation')}}</th>
                                                    <th>{{translate('review')}}</th>
                                                    <th>{{translate('image')}}</th>
                                                    <th>{{translate('action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($testimonials ?? [] as $key=>$item)
                                                    <tr>
                                                        <td>{{$item['name']}}</td>
                                                        <td>{{$item['designation']}}</td>
                                                        <td>{{$item['review']}}</td>
                                                        <td>
                                                            <img style="height: 50px;width: 50px"
                                                                 src="{{asset('storage/app/public/landing-page')}}/{{$item['image']}}">
                                                        </td>
                                                        <td>
                                                            <div class="table-actions">
                                                                <button type="button"
                                                                        onclick="form_alert('delete-{{$item['id']}}','{{translate('want_to_delete_this')}}?')"
                                                                        class="table-actions_delete bg-transparent border-0 p-0">
                                                                    <span class="material-icons">delete</span>
                                                                </button>
                                                                <form
                                                                    action="{{route('admin.business-settings.delete-landing-testimonial',[$item['id']])}}"
                                                                    method="post" id="delete-{{$item['id']}}"
                                                                    class="hidden">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page=='features')
                        @php($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first())
                        @php($default_lang = str_replace('_', '-', app()->getLocale()))
                        @if($language)
                            <ul class="nav nav--tabs border-color-primary mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active"
                                       href="#"
                                       id="default-link">{{translate('default')}}</a>
                                </li>
                                @foreach ($language?->live_values as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link"
                                           href="#"
                                           id="{{ $lang['code'] }}-link">{{ get_language_name($lang['code']) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='features'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <form
                                            action="{{route('admin.business-settings.set-landing-feature')}}?web_page={{$web_page}}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="discount-type">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if($language)
                                                            <div class="lang-form default-form">
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="title[]">
                                                                        <label>{{translate('feature_title')}}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="sub_title[]">
                                                                        <label>{{translate('feature_sub_title')}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="lang[]" value="default">
                                                            @foreach ($language?->live_values as $lang)
                                                                <div
                                                                    class="mb-30 d-none lang-form {{$lang['code']}}-form">
                                                                    <div class="mb-30">
                                                                        <div class="form-floating">
                                                                            <input type="text" class="form-control"
                                                                                   name="title[]" {{$lang['status'] == '1' ? 'required':''}}
                                                                                   @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                            <label>{{translate('feature_title')}}</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-30">
                                                                        <div class="form-floating">
                                                                            <input type="text" class="form-control"
                                                                                   name="sub_title[]" {{$lang['status'] == '1' ? 'required':''}}
                                                                                   @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                            <label>{{translate('feature_sub_title')}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="lang[]" value="{{$lang['code']}}">
                                                            @endforeach
                                                        @else
                                                            <div class="lang-form">
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="title[]">
                                                                        <label>{{translate('feature_title')}}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="sub_title[]">
                                                                        <label>{{translate('feature_sub_title')}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="lang[]" value="default">
                                                        @endif
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div
                                                            class="mb-30 d-flex flex-column align-items-center gap-2">
                                                            <div class="upload-file mb-30 max-w-100">
                                                                <input type="file" class="upload-file__input"
                                                                       name="image_1">
                                                                <div class="upload-file__img">
                                                                    <img
                                                                        src='{{asset('public/assets/admin-module/img/media/upload-file.png')}}'
                                                                        alt="">
                                                                </div>
                                                                <span class="upload-file__edit">
                                                                    <span class="material-icons">edit</span>
                                                                </span>
                                                            </div>
                                                            <p class="opacity-75 max-w220">{{translate('Image Size - 200x381')}}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div
                                                            class="mb-30 d-flex flex-column align-items-center gap-2">
                                                            <div class="upload-file mb-30 max-w-100">
                                                                <input type="file" class="upload-file__input"
                                                                       name="image_2">
                                                                <div class="upload-file__img">
                                                                    <img
                                                                        src='{{asset('public/assets/admin-module/img/media/upload-file.png')}}'
                                                                        alt="">
                                                                </div>
                                                                <span class="upload-file__edit">
                                                                    <span class="material-icons">edit</span>
                                                                </span>
                                                            </div>
                                                            <p class="opacity-75 max-w220">{{translate('Image Size - 200x381')}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="reset" class="btn btn-secondary">
                                                    {{translate('reset')}}
                                                </button>
                                                <button type="submit" class="btn btn--primary">
                                                    {{translate('add')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="card-body p-30">
                                        <div class="table-responsive">
                                            <table id="example" class="table align-middle">
                                                <thead>
                                                <tr>
                                                    <th>{{translate('title')}}</th>
                                                    <th>{{translate('sub_title')}}</th>
                                                    <th>{{translate('images')}}</th>
                                                    <th>{{translate('action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($features??[] as $key=>$item)
                                                    <tr>
                                                        <td>{{$item['title']}}</td>
                                                        <td>{{$item['sub_title']}}</td>
                                                        <td>
                                                            <img style="height: 50px;width: 50px"
                                                                 src="{{asset('storage/app/public/landing-page')}}/{{$item['image_1']}}">
                                                            <img style="height: 50px;width: 50px"
                                                                 src="{{asset('storage/app/public/landing-page')}}/{{$item['image_2']}}">
                                                        </td>
                                                        <td>
                                                            <div class="table-actions">
                                                                <button type="button"
                                                                        onclick="form_alert('delete-{{$item['id']}}','{{translate('want_to_delete_this')}}?')"
                                                                        class="table-actions_delete bg-transparent border-0 p-0">
                                                                    <span class="material-icons">delete</span>
                                                                </button>
                                                                <form
                                                                    action="{{route('admin.business-settings.delete-landing-feature',[$item['id']])}}"
                                                                    method="post" id="delete-{{$item['id']}}"
                                                                    class="hidden">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page=='images')
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='images'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <div class="discount-type">
                                            <div class="row">
                                                @php($keys = ['top_image_1', 'top_image_2', 'top_image_3', 'top_image_4', 'about_us_image', 'service_section_image', 'provider_section_image'])
                                                @php($ratios = ['370x200', '315x200', '200x200', '485x200', '684x440', '200x350', '238x228'])
                                                @foreach($keys as $index=>$key)
                                                    <div class="col-md-3 mb-30">
                                                        <form
                                                            action="{{route('admin.business-settings.set-landing-information')}}?web_page={{$web_page}}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div
                                                                class="mb-1 d-flex flex-column align-items-center gap-2">
                                                                <p class="title-color text-center" style="width: 160px">
                                                                    {{translate($key)}}, {{translate('size')}}
                                                                    :{{$ratios[$index]}}
                                                                </p>
                                                                <div class="upload-file max-w-100">
                                                                    <input type="file" class="upload-file__input"
                                                                           name="{{$key}}" id="image-{{$key}}">
                                                                    <div class="upload-file__img">
                                                                        <img
                                                                            onerror="this.src='{{asset('public/assets/admin-module/img/media/upload-file.png')}}'"
                                                                            src='{{asset('storage/app/public/landing-page')}}/{{$data_values->where('key_name',$key)->first()->live_values??''}}'
                                                                            alt="">
                                                                    </div>
                                                                    <span class="upload-file__edit"
                                                                          onclick="$('#image-{{$key}}').click()">
                                                                        <span class="material-icons">edit</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-2 justify-content-center">
                                                                <button type="submit"
                                                                        class="btn btn--primary btn-block">
                                                                    {{translate('upload')}}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page=='background')
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='background'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <form action="javascript:void(0)" method="POST" id="landing-info-update-form">
                                            @csrf
                                            @method('PUT')
                                            <div class="discount-type">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="color" class="form-control"
                                                                       name="header_background"
                                                                       value="{{$data_values->where('key_name','header_background')->first()->live_values??"#E3F2FC"}}">
                                                                <label>
                                                                    {{translate('header_background')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="color" class="form-control"
                                                                       name="body_background"
                                                                       value="{{$data_values->where('key_name','body_background')->first()->live_values??'white'}}">
                                                                <label>
                                                                    {{translate('body_background')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="color" class="form-control"
                                                                       name="footer_background"
                                                                       value="{{$data_values->where('key_name','footer_background')->first()->live_values??'#E3F2FC'}}">
                                                                <label>
                                                                    {{translate('footer_background')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="reset" class="btn btn-secondary">
                                                    {{translate('reset')}}
                                                </button>
                                                <button type="submit" class="btn btn--primary">
                                                    {{translate('update')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page=='social_media')
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='social_media'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <form
                                            action="{{route('admin.business-settings.set-landing-information')}}?web_page={{$web_page}}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="discount-type">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-30">
                                                            <select class="js-select theme-input-style w-100"
                                                                    name="media" required>
                                                                <option value="" selected disabled>
                                                                    ---{{translate('Select_media')}}---
                                                                </option>
                                                                <option
                                                                    value="facebook">{{translate('Facebook')}}</option>
                                                                <option
                                                                    value="instagram">{{translate('Instagram')}}</option>
                                                                <option
                                                                    value="linkedin">{{translate('LinkedIn')}}</option>
                                                                <option
                                                                    value="twitter">{{translate('Twitter')}}</option>
                                                                <option
                                                                    value="youtube">{{translate('Youtube')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" name="link"
                                                                       placeholder="{{translate('link')}}" required>
                                                                <label>{{translate('link')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="reset" class="btn btn-secondary">
                                                    {{translate('reset')}}
                                                </button>
                                                <button type="submit" class="btn btn--primary">
                                                    {{translate('add')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="card-body p-30">
                                        <div class="table-responsive">
                                            <table id="example" class="table align-middle">
                                                <thead>
                                                <tr>
                                                    <th>{{translate('media')}}</th>
                                                    <th>{{translate('link')}}</th>
                                                    <th>{{translate('action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data_values[0]->live_values??[] as $key=>$item)
                                                    <tr>
                                                        <td>{{$item['media']}}</td>
                                                        <td><a href="{{$item['link']}}">{{$item['link']}}</a></td>
                                                        <td>
                                                            <div class="table-actions">
                                                                <button type="button"
                                                                        onclick="form_alert('delete-{{$item['id']}}','{{translate('want_to_delete_this')}}?')"
                                                                        class="table-actions_delete bg-transparent border-0 p-0">
                                                                    <span class="material-icons">delete</span>
                                                                </button>
                                                                <form
                                                                    action="{{route('admin.business-settings.delete-landing-information',[$web_page,$item['id']])}}"
                                                                    method="post" id="delete-{{$item['id']}}"
                                                                    class="hidden">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page=='meta')
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='meta'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <form action="javascript:void(0)" method="POST" id="landing-info-update-form">
                                            @csrf
                                            @method('PUT')
                                            <div class="discount-type">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       placeholder="{{translate('meta_title')}} *"
                                                                       name="meta_title"
                                                                       value="{{$data_values->where('key_name','meta_title')->first()->live_values??''}}"
                                                                       required>
                                                                <label>
                                                                    {{translate('meta_title')}}
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       placeholder="{{translate('meta_description')}} *"
                                                                       name="meta_description"
                                                                       value="{{$data_values->where('key_name','meta_description')->first()->live_values??''}}"
                                                                       required>
                                                                <label>
                                                                    {{translate('meta_description')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-30 d-flex flex-column align-items-center gap-2">
                                                            <div class="upload-file mb-30 max-w-100">
                                                                <input type="file" class="upload-file__input"
                                                                       name="meta_image">
                                                                <div class="upload-file__img">
                                                                    <img
                                                                        src="{{asset('storage/app/public/landing-page/meta')}}/{{$data_values->where('key_name','meta_image')->first()->live_values??''}}"
                                                                        onerror="this.src='{{asset('public/assets/placeholder.png')}}'"
                                                                        alt="">
                                                                </div>
                                                                <span class="upload-file__edit">
                                                                    <span class="material-icons">edit</span>
                                                                </span>
                                                            </div>
                                                            <p class="opacity-75 max-w220">{{translate('Image format - jpg, png, jpeg, gif Image Size - maximum size 2 MB Image Ratio - 1:1')}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="reset" class="btn btn-secondary">
                                                    {{translate('reset')}}
                                                </button>
                                                <button type="submit" class="btn btn--primary">
                                                    {{translate('add')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page=='web_app')
                        @php($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first())
                        @php($default_lang = str_replace('_', '-', app()->getLocale()))
                        @if($language)
                            <ul class="nav nav--tabs border-color-primary mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active"
                                       href="#"
                                       id="default-link">{{translate('default')}}</a>
                                </li>
                                @foreach ($language?->live_values as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link"
                                           href="#"
                                           id="{{ $lang['code'] }}-link">{{ get_language_name($lang['code']) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='web_app'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <form action="javascript:void(0)" method="POST" id="landing-info-update-form">
                                            @csrf
                                            @method('PUT')
                                            @if($language)
                                                <div class="discount-type lang-form default-form">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="web_top_title[]"
                                                                           placeholder="{{translate('top_title')}}"
                                                                           value="{{$data_values->where('key','web_top_title')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('top_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="web_top_description[]"
                                                                           placeholder="{{translate('top_description')}}"
                                                                           value="{{$data_values->where('key','web_top_description')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('top_description')}} *</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="web_mid_title[]"
                                                                           placeholder="{{translate('mid_title')}}"
                                                                           value="{{$data_values->where('key','web_mid_title')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           >
                                                                    <label>{{translate('mid_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_title_1[]"
                                                                           value="{{$data_values->where('key','mid_sub_title_1')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           placeholder="{{translate('mid_sub_title_1')}}"
                                                                           >
                                                                    <label>{{translate('mid_sub_title_1')}} *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_description_1[]"
                                                                           value="{{$data_values->where('key','mid_sub_description_1')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           placeholder="{{translate('mid_sub_description_1')}}"
                                                                           >
                                                                    <label>{{translate('mid_sub_description_1')}}
                                                                        *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_title_2[]"
                                                                           value="{{$data_values->where('key','mid_sub_title_2')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           placeholder="{{translate('mid_sub_title_2')}}"
                                                                           >
                                                                    <label>{{translate('mid_sub_title_2')}} *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_description_2[]"
                                                                           value="{{$data_values->where('key','mid_sub_description_2')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           placeholder="{{translate('mid_sub_description_2')}}"
                                                                           >
                                                                    <label>{{translate('mid_sub_description_2')}}
                                                                        *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_title_3[]"
                                                                           value="{{$data_values->where('key','mid_sub_title_3')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           placeholder="{{translate('mid_sub_title_3')}}"
                                                                           >
                                                                    <label>{{translate('mid_sub_title_3')}} *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_description_3[]"
                                                                           value="{{$data_values->where('key','mid_sub_description_3')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           placeholder="{{translate('mid_sub_description_3')}}"
                                                                           >
                                                                    <label>{{translate('mid_sub_description_3')}}
                                                                        *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="download_section_title[]"
                                                                           value="{{$data_values->where('key','download_section_title')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           placeholder="{{translate('download_section_title')}}"
                                                                           >
                                                                    <label>{{translate('download_section_title')}}
                                                                        *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="download_section_description[]"
                                                                           value="{{$data_values->where('key','download_section_description')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           placeholder="{{translate('download_section_description')}}"
                                                                           >
                                                                    <label>{{translate('download_section_description')}}
                                                                        *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="web_bottom_title[]"
                                                                           value="{{$data_values->where('key','web_bottom_title')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           placeholder="{{translate('bottom_title')}}"
                                                                           >
                                                                    <label>{{translate('bottom_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="testimonial_title[]"
                                                                           value="{{$data_values->where('key','testimonial_title')->first()?->getRawOriginal('value') ?? ''}}"
                                                                           placeholder="{{translate('testimonial_title')}}"
                                                                           >
                                                                    <label>{{translate('testimonial_title')}} *</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                                @foreach ($language?->live_values as $lang)
                                                        <?php
                                                        $web_top_title = $data_values->where('key', 'web_top_title')->first();
                                                        $web_top_description = $data_values->where('key', 'web_top_description')->first();
                                                        $web_mid_title = $data_values->where('key', 'web_mid_title')->first();
                                                        $mid_sub_title_1 = $data_values->where('key', 'mid_sub_title_1')->first();
                                                        $mid_sub_title_2 = $data_values->where('key', 'mid_sub_title_2')->first();
                                                        $mid_sub_description_1 = $data_values->where('key', 'mid_sub_description_1')->first();
                                                        $mid_sub_description_2 = $data_values->where('key', 'mid_sub_description_2')->first();
                                                        $mid_sub_title_3 = $data_values->where('key', 'mid_sub_title_3')->first();
                                                        $mid_sub_description_3 = $data_values->where('key', 'mid_sub_description_3')->first();
                                                        $download_section_title = $data_values->where('key', 'download_section_title')->first();
                                                        $download_section_description = $data_values->where('key', 'download_section_description')->first();
                                                        $web_bottom_title = $data_values->where('key', 'web_bottom_title')->first();
                                                        $testimonial_title = $data_values->where('key', 'testimonial_title')->first();

                                                        if (isset($web_top_title['translations']) && count($web_top_title['translations'])) {
                                                            $translate_web_top_title = [];
                                                            foreach ($web_top_title['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "web_top_title") {
                                                                    $translate_web_top_title[$lang['code']]['web_top_title'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($web_top_description['translations']) && count($web_top_description['translations'])) {
                                                            $translate_web_top_description = [];
                                                            foreach ($web_top_description['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "web_top_description") {
                                                                    $translate_web_top_description[$lang['code']]['web_top_description'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($web_mid_title['translations']) && count($web_mid_title['translations'])) {
                                                            $translate_web_mid_title = [];
                                                            foreach ($web_mid_title['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "web_mid_title") {
                                                                    $translate_web_mid_title[$lang['code']]['web_mid_title'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($mid_sub_title_1['translations']) && count($mid_sub_title_1['translations'])) {
                                                            $translate_mid_sub_title_1 = [];
                                                            foreach ($mid_sub_title_1['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "mid_sub_title_1") {
                                                                    $translate_mid_sub_title_1[$lang['code']]['mid_sub_title_1'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($mid_sub_description_1['translations']) && count($mid_sub_description_1['translations'])) {
                                                            $translate_mid_sub_description_1 = [];
                                                            foreach ($mid_sub_description_1['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "mid_sub_description_1") {
                                                                    $translate_mid_sub_description_1[$lang['code']]['mid_sub_description_1'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($mid_sub_description_2['translations']) && count($mid_sub_description_2['translations'])) {
                                                            $translate_mid_sub_description_2 = [];
                                                            foreach ($mid_sub_description_2['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "mid_sub_description_2") {
                                                                    $translate_mid_sub_description_2[$lang['code']]['mid_sub_description_2'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($mid_sub_title_2['translations']) && count($mid_sub_title_2['translations'])) {
                                                            $translate_mid_sub_title_2 = [];
                                                            foreach ($mid_sub_title_2['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "mid_sub_title_2") {
                                                                    $translate_mid_sub_title_2[$lang['code']]['mid_sub_title_2'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($mid_sub_title_3['translations']) && count($mid_sub_title_3['translations'])) {
                                                            $translate_mid_sub_title_3 = [];
                                                            foreach ($mid_sub_title_3['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "mid_sub_title_3") {
                                                                    $translate_mid_sub_title_3[$lang['code']]['mid_sub_title_3'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($mid_sub_description_3['translations']) && count($mid_sub_description_3['translations'])) {
                                                            $translate_mid_sub_description_3 = [];
                                                            foreach ($mid_sub_description_3['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "mid_sub_description_3") {
                                                                    $translate_mid_sub_description_3[$lang['code']]['mid_sub_description_3'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($download_section_title['translations']) && count($download_section_title['translations'])) {
                                                            $translate_download_section_title = [];
                                                            foreach ($download_section_title['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "download_section_title") {
                                                                    $translate_download_section_title[$lang['code']]['download_section_title'] = $t->value;
                                                                }
                                                            }
                                                        }



                                                        if (isset($download_section_description['translations']) && count($download_section_description['translations'])) {
                                                            $translate_download_section_description = [];
                                                            foreach ($download_section_description['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "download_section_description") {
                                                                    $translate_download_section_description[$lang['code']]['download_section_description'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($web_bottom_title['translations']) && count($web_bottom_title['translations'])) {
                                                            $translate_web_bottom_title = [];
                                                            foreach ($web_bottom_title['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "web_bottom_title") {
                                                                    $translate_web_bottom_title[$lang['code']]['web_bottom_title'] = $t->value;
                                                                }
                                                            }
                                                        }

                                                        if (isset($testimonial_title['translations']) && count($testimonial_title['translations'])) {
                                                            $translate_testimonial_title = [];
                                                            foreach ($testimonial_title['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "testimonial_title") {
                                                                    $translate_testimonial_title[$lang['code']]['testimonial_title'] = $t->value;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    <div class="discount-type d-none lang-form {{$lang['code']}}-form">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="web_top_title[]"
                                                                               placeholder="{{translate('top_title')}}"
                                                                               value="{{ $translate_web_top_title[$lang['code']]['web_top_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               required>
                                                                        <label>{{translate('top_title')}} *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="web_top_description[]"
                                                                               placeholder="{{translate('top_description')}}"
                                                                               value="{{ $translate_web_top_description[$lang['code']]['web_top_description'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               required>
                                                                        <label>{{translate('top_description')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="web_mid_title[]"
                                                                               placeholder="{{translate('mid_title')}}"
                                                                               value="{{ $translate_web_mid_title[$lang['code']]['web_mid_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               required>
                                                                        <label>{{translate('mid_title')}} *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="mid_sub_title_1[]"
                                                                               value="{{ $translate_mid_sub_title_1[$lang['code']]['mid_sub_title_1'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               placeholder="{{translate('mid_sub_title_1')}}"
                                                                               required>
                                                                        <label>{{translate('mid_sub_title_1')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="mid_sub_description_1[]"
                                                                               value="{{ $translate_mid_sub_description_1[$lang['code']]['mid_sub_description_1'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               placeholder="{{translate('mid_sub_description_1')}}"
                                                                               required>
                                                                        <label>{{translate('mid_sub_description_1')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="mid_sub_title_2[]"
                                                                               value="{{ $translate_mid_sub_title_2[$lang['code']]['mid_sub_title_2'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               placeholder="{{translate('mid_sub_title_2')}}"
                                                                               required>
                                                                        <label>{{translate('mid_sub_title_2')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="mid_sub_description_2[]"
                                                                               value="{{ $translate_mid_sub_description_2[$lang['code']]['mid_sub_description_2'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               placeholder="{{translate('mid_sub_description_2')}}"
                                                                               required>
                                                                        <label>{{translate('mid_sub_description_2')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="mid_sub_title_3[]"
                                                                               value="{{ $translate_mid_sub_title_3[$lang['code']]['mid_sub_title_3'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               placeholder="{{translate('mid_sub_title_3')}}"
                                                                               required>
                                                                        <label>{{translate('mid_sub_title_3')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="mid_sub_description_3[]"
                                                                               value="{{ $translate_mid_sub_description_3[$lang['code']]['mid_sub_description_3'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               placeholder="{{translate('mid_sub_description_3')}}"
                                                                               required>
                                                                        <label>{{translate('mid_sub_description_3')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="download_section_title[]"
                                                                               value="{{ $translate_download_section_title[$lang['code']]['download_section_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               placeholder="{{translate('download_section_title')}}"
                                                                               required>
                                                                        <label>{{translate('download_section_title')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="download_section_description[]"
                                                                               value="{{ $translate_download_section_description[$lang['code']]['download_section_description'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               placeholder="{{translate('download_section_description')}}"
                                                                               required>
                                                                        <label>{{translate('download_section_description')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="web_bottom_title[]"
                                                                               value="{{ $translate_web_bottom_title[$lang['code']]['web_bottom_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               placeholder="{{translate('bottom_title')}}"
                                                                               required>
                                                                        <label>{{translate('bottom_title')}} *</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-30">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                               name="testimonial_title[]"
                                                                               value="{{ $translate_testimonial_title[$lang['code']]['testimonial_title'] ?? ''}}"
                                                                               {{$lang['status'] == '1' ? 'required':''}}
                                                                               @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()"
                                                                               @endif
                                                                               placeholder="{{translate('testimonial_title')}}"
                                                                               required>
                                                                        <label>{{translate('testimonial_title')}}
                                                                            *</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="{{$lang['code']}}">
                                                @endforeach
                                            @else
                                                <div class="discount-type lang-form">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="web_top_title"
                                                                           placeholder="{{translate('top_title')}}"
                                                                           value="{{$data_values->where('key','web_top_title')->first()->value ??''}}"
                                                                           required>
                                                                    <label>{{translate('top_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="web_top_description"
                                                                           placeholder="{{translate('top_description')}}"
                                                                           value="{{$data_values->where('key','web_top_description')->first()->value??''}}"
                                                                           required>
                                                                    <label>{{translate('top_description')}} *</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="web_mid_title"
                                                                           placeholder="{{translate('mid_title')}}"
                                                                           value="{{$data_values->where('key','web_mid_title')->first()->value??''}}"
                                                                           required>
                                                                    <label>{{translate('mid_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_title_1"
                                                                           value="{{$data_values->where('key','mid_sub_title_1')->first()->value??''}}"
                                                                           placeholder="{{translate('mid_sub_title_1')}}"
                                                                           required>
                                                                    <label>{{translate('mid_sub_title_1')}} *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_description_1"
                                                                           value="{{$data_values->where('key','mid_sub_description_1')->first()->value??''}}"
                                                                           placeholder="{{translate('mid_sub_description_1')}}"
                                                                           required>
                                                                    <label>{{translate('mid_sub_description_1')}}
                                                                        *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_title_2"
                                                                           value="{{$data_values->where('key','mid_sub_title_2')->first()->value??''}}"
                                                                           placeholder="{{translate('mid_sub_title_2')}}"
                                                                           required>
                                                                    <label>{{translate('mid_sub_title_2')}} *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_description_2"
                                                                           value="{{$data_values->where('key','mid_sub_description_2')->first()->value??''}}"
                                                                           placeholder="{{translate('mid_sub_description_2')}}"
                                                                           required>
                                                                    <label>{{translate('mid_sub_description_2')}}
                                                                        *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_title_3"
                                                                           value="{{$data_values->where('key','mid_sub_title_3')->first()->value??''}}"
                                                                           placeholder="{{translate('mid_sub_title_3')}}"
                                                                           required>
                                                                    <label>{{translate('mid_sub_title_3')}} *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="mid_sub_description_3"
                                                                           value="{{$data_values->where('key','mid_sub_description_3')->first()->value??''}}"
                                                                           placeholder="{{translate('mid_sub_description_3')}}"
                                                                           required>
                                                                    <label>{{translate('mid_sub_description_3')}}
                                                                        *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="download_section_title"
                                                                           value="{{$data_values->where('key','download_section_title')->first()->value??''}}"
                                                                           placeholder="{{translate('download_section_title')}}"
                                                                           required>
                                                                    <label>{{translate('download_section_title')}}
                                                                        *</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="download_section_description"
                                                                           value="{{$data_values->where('key','download_section_description')->first()->value??''}}"
                                                                           placeholder="{{translate('download_section_description')}}"
                                                                           required>
                                                                    <label>{{translate('download_section_description')}}
                                                                        *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="web_bottom_title"
                                                                           value="{{$data_values->where('key','web_bottom_title')->first()->value??''}}"
                                                                           placeholder="{{translate('bottom_title')}}"
                                                                           required>
                                                                    <label>{{translate('bottom_title')}} *</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-30">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control"
                                                                           name="testimonial_title"
                                                                           value="{{$data_values->where('key','testimonial_title')->first()->value??''}}"
                                                                           placeholder="{{translate('testimonial_title')}}"
                                                                           required>
                                                                    <label>{{translate('testimonial_title')}} *</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                            @endif
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="reset" class="btn btn-secondary">
                                                    {{translate('reset')}}
                                                </button>
                                                <button type="submit" class="btn btn--primary">
                                                    {{translate('update')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page=='web_app_image')
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page=='web_app_image'?'active show':''}}">
                                <div class="card">
                                    <div class="card-body p-30">
                                        <div class="discount-type">
                                            <div class="row">
                                                @php($keys = ['support_section_image', 'download_section_image', 'feature_section_image'])
                                                @php($ratios = ['200x242', '500x500', '500x500'])
                                                @foreach($keys as $index=>$key)
                                                    <div class="col-md-4 mb-30">
                                                        <form
                                                            action="{{route('admin.business-settings.set-landing-information')}}?web_page={{$web_page}}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div
                                                                class="mb-1 d-flex flex-column align-items-center gap-2">
                                                                <p class="title-color text-center" style="width: 160px">
                                                                    {{translate($key)}}, <small
                                                                        class="opacity-75">{{translate('size')}}
                                                                        : {{$ratios[$index]}}</small>
                                                                </p>
                                                                <div class="upload-file max-w-100">
                                                                    <input type="file" class="upload-file__input"
                                                                           name="{{$key}}" id="image-{{$key}}">
                                                                    <div class="upload-file__img">
                                                                        <img
                                                                            onerror="this.src='{{asset('public/assets/admin-module/img/media/upload-file.png')}}'"
                                                                            src='{{asset('storage/app/public/landing-page/web')}}/{{$data_values->where('key_name',$key)->first()->live_values??''}}'
                                                                            alt="">
                                                                    </div>
                                                                    <span class="upload-file__edit"
                                                                          onclick="$('#image-{{$key}}').click()">
                                                                        <span class="material-icons">edit</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-2 justify-content-center">
                                                                <button type="submit"
                                                                        class="btn btn--primary btn-block">
                                                                    {{translate('upload')}}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/admin-module')}}/plugins/select2/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.js-select').select2();
        });
    </script>
    <script src="{{asset('public/assets/admin-module')}}/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/admin-module')}}/plugins/dataTables/dataTables.select.min.js"></script>

    <script>
        $('#landing-info-update-form').on('submit', function (event) {
            event.preventDefault();

            var form = $('#landing-info-update-form')[0];
            var formData = new FormData(form);
            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.business-settings.set-landing-information')}}?web_page={{$web_page}}",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (response) {
                    console.log(response)
                    if (response.errors.length > 0) {
                        response.errors.forEach((value, key) => {
                            toastr.error(value.message);
                        });
                    } else {
                        toastr.success('{{translate('successfully_updated')}}');
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
        });
    </script>

    <script>
        $(".lang_link").on('click', function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang-form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            console.log(lang);
            $("." + lang + "-form").removeClass('d-none');
        });
    </script>
@endpush
