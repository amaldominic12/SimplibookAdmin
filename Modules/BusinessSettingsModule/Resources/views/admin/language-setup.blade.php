@extends('adminmodule::layouts.master')

@section('title',translate('Language Setup'))

@push('css_or_js')

@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title">{{translate('Language_Setup')}}</h2>
                    </div>

                    <div class="card">
                        <div class="card-body p-30">
                            <form action="{{route('admin.language.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-30">
                                            <select class="js-select" name="code" id="user_id" required>
                                                <option value="af">Afrikaans</option>
                                                <option value="sq">Albanian - shqip</option>
                                                <option value="am">Amharic - አማርኛ</option>
                                                <option value="ar">Arabic - العربية</option>
                                                <option value="an">Aragonese - aragonés</option>
                                                <option value="hy">Armenian - հայերեն</option>
                                                <option value="ast">Asturian - asturianu</option>
                                                <option value="az">Azerbaijani - azərbaycan dili</option>
                                                <option value="eu">Basque - euskara</option>
                                                <option value="be">Belarusian - беларуская</option>
                                                <option value="bn">Bengali - বাংলা</option>
                                                <option value="bs">Bosnian - bosanski</option>
                                                <option value="br">Breton - brezhoneg</option>
                                                <option value="bg">Bulgarian - български</option>
                                                <option value="ca">Catalan - català</option>
                                                <option value="ckb">Central Kurdish - کوردی (دەستنوسی عەرەبی)</option>
                                                <option value="zh">Chinese - 中文</option>
                                                <option value="zh-HK">Chinese (Hong Kong) - 中文（香港）</option>
                                                <option value="zh-CN">Chinese (Simplified) - 中文（简体）</option>
                                                <option value="zh-TW">Chinese (Traditional) - 中文（繁體）</option>
                                                <option value="co">Corsican</option>
                                                <option value="hr">Croatian - hrvatski</option>
                                                <option value="cs">Czech - čeština</option>
                                                <option value="da">Danish - dansk</option>
                                                <option value="nl">Dutch - Nederlands</option>
                                                <option value="en-AU">English (Australia)</option>
                                                <option value="en-CA">English (Canada)</option>
                                                <option value="en-IN">English (India)</option>
                                                <option value="en-NZ">English (New Zealand)</option>
                                                <option value="en-ZA">English (South Africa)</option>
                                                <option value="en-GB">English (United Kingdom)</option>
                                                <option value="en-US">English (United States)</option>
                                                <option value="eo">Esperanto - esperanto</option>
                                                <option value="et">Estonian - eesti</option>
                                                <option value="fo">Faroese - føroyskt</option>
                                                <option value="fil">Filipino</option>
                                                <option value="fi">Finnish - suomi</option>
                                                <option value="fr">French - français</option>
                                                <option value="fr-CA">French (Canada) - français (Canada)</option>
                                                <option value="fr-FR">French (France) - français (France)</option>
                                                <option value="fr-CH">French (Switzerland) - français (Suisse)</option>
                                                <option value="gl">Galician - galego</option>
                                                <option value="ka">Georgian - ქართული</option>
                                                <option value="de">German - Deutsch</option>
                                                <option value="de-AT">German (Austria) - Deutsch (Österreich)</option>
                                                <option value="de-DE">German (Germany) - Deutsch (Deutschland)</option>
                                                <option value="de-LI">German (Liechtenstein) - Deutsch (Liechtenstein)
                                                </option>
                                                <option value="de-CH">German (Switzerland) - Deutsch (Schweiz)</option>
                                                <option value="el">Greek - Ελληνικά</option>
                                                <option value="gn">Guarani</option>
                                                <option value="gu">Gujarati - ગુજરાતી</option>
                                                <option value="ha">Hausa</option>
                                                <option value="haw">Hawaiian - ʻŌlelo Hawaiʻi</option>
                                                <option value="he">Hebrew - עברית</option>
                                                <option value="hi">Hindi - हिन्दी</option>
                                                <option value="hu">Hungarian - magyar</option>
                                                <option value="is">Icelandic - íslenska</option>
                                                <option value="id">Indonesian - Indonesia</option>
                                                <option value="ia">Interlingua</option>
                                                <option value="ga">Irish - Gaeilge</option>
                                                <option value="it">Italian - italiano</option>
                                                <option value="it-IT">Italian (Italy) - italiano (Italia)</option>
                                                <option value="it-CH">Italian (Switzerland) - italiano (Svizzera)
                                                </option>
                                                <option value="ja">Japanese - 日本語</option>
                                                <option value="kn">Kannada - ಕನ್ನಡ</option>
                                                <option value="kk">Kazakh - қазақ тілі</option>
                                                <option value="km">Khmer - ខ្មែរ</option>
                                                <option value="ko">Korean - 한국어</option>
                                                <option value="ku">Kurdish - Kurdî</option>
                                                <option value="ky">Kyrgyz - кыргызча</option>
                                                <option value="lo">Lao - ລາວ</option>
                                                <option value="la">Latin</option>
                                                <option value="lv">Latvian - latviešu</option>
                                                <option value="ln">Lingala - lingála</option>
                                                <option value="lt">Lithuanian - lietuvių</option>
                                                <option value="mk">Macedonian - македонски</option>
                                                <option value="ms">Malay - Bahasa Melayu</option>
                                                <option value="ml">Malayalam - മലയാളം</option>
                                                <option value="mt">Maltese - Malti</option>
                                                <option value="mr">Marathi - मराठी</option>
                                                <option value="mn">Mongolian - монгол</option>
                                                <option value="ne">Nepali - नेपाली</option>
                                                <option value="no">Norwegian - norsk</option>
                                                <option value="nb">Norwegian Bokmål - norsk bokmål</option>
                                                <option value="nn">Norwegian Nynorsk - nynorsk</option>
                                                <option value="oc">Occitan</option>
                                                <option value="or">Oriya - ଓଡ଼ିଆ</option>
                                                <option value="om">Oromo - Oromoo</option>
                                                <option value="ps">Pashto - پښتو</option>
                                                <option value="fa">Persian - فارسی</option>
                                                <option value="pl">Polish - polski</option>
                                                <option value="pt">Portuguese - português</option>
                                                <option value="pt-BR">Portuguese (Brazil) - português (Brasil)</option>
                                                <option value="pt-PT">Portuguese (Portugal) - português (Portugal)
                                                </option>
                                                <option value="pa">Punjabi - ਪੰਜਾਬੀ</option>
                                                <option value="qu">Quechua</option>
                                                <option value="ro">Romanian - română</option>
                                                <option value="mo">Romanian (Moldova) - română (Moldova)</option>
                                                <option value="rm">Romansh - rumantsch</option>
                                                <option value="ru">Russian - русский</option>
                                                <option value="gd">Scottish Gaelic</option>
                                                <option value="sr">Serbian - српски</option>
                                                <option value="sh">Serbo-Croatian - Srpskohrvatski</option>
                                                <option value="sn">Shona - chiShona</option>
                                                <option value="sd">Sindhi</option>
                                                <option value="si">Sinhala - සිංහල</option>
                                                <option value="sk">Slovak - slovenčina</option>
                                                <option value="sl">Slovenian - slovenščina</option>
                                                <option value="so">Somali - Soomaali</option>
                                                <option value="st">Southern Sotho</option>
                                                <option value="es">Spanish - español</option>
                                                <option value="es-AR">Spanish (Argentina) - español (Argentina)</option>
                                                <option value="es-419">Spanish (Latin America) - español (Latinoamérica)
                                                </option>
                                                <option value="es-MX">Spanish (Mexico) - español (México)</option>
                                                <option value="es-ES">Spanish (Spain) - español (España)</option>
                                                <option value="es-US">Spanish (United States) - español (Estados Unidos)
                                                </option>
                                                <option value="su">Sundanese</option>
                                                <option value="sw">Swahili - Kiswahili</option>
                                                <option value="sv">Swedish - svenska</option>
                                                <option value="tg">Tajik - тоҷикӣ</option>
                                                <option value="ta">Tamil - தமிழ்</option>
                                                <option value="tt">Tatar</option>
                                                <option value="te">Telugu - తెలుగు</option>
                                                <option value="th">Thai - ไทย</option>
                                                <option value="ti">Tigrinya - ትግርኛ</option>
                                                <option value="to">Tongan - lea fakatonga</option>
                                                <option value="tr">Turkish - Türkçe</option>
                                                <option value="tk">Turkmen</option>
                                                <option value="tw">Twi</option>
                                                <option value="uk">Ukrainian - українська</option>
                                                <option value="ur">Urdu - اردو</option>
                                                <option value="ug">Uyghur</option>
                                                <option value="uz">Uzbek - o‘zbek</option>
                                                <option value="vi">Vietnamese - Tiếng Việt</option>
                                                <option value="wa">Walloon - wa</option>
                                                <option value="cy">Welsh - Cymraeg</option>
                                                <option value="fy">Western Frisian</option>
                                                <option value="xh">Xhosa</option>
                                                <option value="yi">Yiddish</option>
                                                <option value="yo">Yoruba - Èdè Yorùbá</option>
                                                <option value="zu">Zulu - isiZulu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-30">
                                            <div class="rounded form-control d-flex min-h45">
                                                <div class="d-flex align-items-center gap-4 gap-xl-5">
                                                    <div class="custom-radio">
                                                        <input type="radio" id="ltr" name="direction" value="ltr"
                                                               checked="">
                                                        <label for="ltr">LTR</label>
                                                    </div>
                                                    <div class="custom-radio">
                                                        <input type="radio" id="rtl" name="direction" value="rtl">
                                                        <label for="rtl">RTL</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-3">
                                            <button class="btn btn-secondary" type="reset">
                                                {{translate('reset')}}
                                            </button>
                                            <button class="btn btn--primary" type="submit">
                                                {{translate('submit')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="#"
                                      class="search-form search-form_style-two"
                                      method="GET">
                                    @csrf
                                    <div class="input-group search-form__input_group">
                                    <span class="search-form__icon">
                                        <span class="material-icons">search</span>
                                    </span>
                                        <input type="search" class="theme-input-style search-form__input" name="search"
                                               placeholder="{{translate('search_here')}}"
                                               value="{{ request()?->search ?? null }}">
                                    </div>
                                    <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                                </form>

                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div class="dropdown">
                                        <button type="button"
                                                class="btn btn--secondary text-capitalize dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                            <span
                                                class="material-icons">file_download</span> {{translate('download')}}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                            <a class="dropdown-item" href="#">
                                                {{translate('excel')}}
                                            </a>
                                        </ul>
                                    </div>
                                    <div>
                                        <span class="material-icons">
                                            settings
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table align-middle">
                                    <thead class="text-nowrap">
                                    <tr>
                                        <th>{{translate('ID')}}</th>
                                        <th>{{translate('Language')}}</th>
                                        <th>{{translate('Translated Content')}}</th>
                                        <th>{{translate('Default Status')}}</th>
                                        <th>{{translate('Status')}}</th>
                                        <th>{{translate('action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $searchValue = request()->search;

                                        $collection = collect($system_language['live_values'] ?? []);

                                        $filteredValues = $collection;

                                        if (!empty($searchValue)) {
                                            $filteredValues = $filteredValues->filter(function ($item) use ($searchValue) {
                                                return isset($item['code']) && $item['code'] == $searchValue;
                                            });
                                        }
                                        $filteredValues = $filteredValues->all();
                                    @endphp
                                    @foreach($filteredValues ?? [] as $key =>$data)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$data['code']}}</td>
                                            <td>
                                                <a href="{{( env('APP_MODE') == 'demo') ? 'javascript:' :route('admin.language.translate',[$data['code']]) }}"
                                                   class="btn border">{{translate('View Translations')}}</a>
                                            </td>
                                            <td>
                                                @if($data['default'] == 'true' && array_key_exists('default', $data))
                                                    <span class="btn"
                                                          style="background: #D2FFE666; color: #00904B;">{{translate(('Default Language'))}}</span>
                                                @else
                                                    <button class="btn btn--light"
                                                            onclick="default_status_change('{{route('admin.language.update-default-status',['code' =>$data['code']])}}','{{translate('want_to_update_default_status')}}')"
                                                    >{{translate('Mark As Default')}}</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if (array_key_exists('default', $data) && $data['default']==true)
                                                    <label class="switcher" data-bs-toggle="modal"
                                                           onclick="default_language_status_alert()"
                                                           data-bs-target="#deactivateAlertModal">
                                                        <input class="switcher_input"
                                                               checked disabled
                                                               type="checkbox" {{$data['status']?'checked':''}}>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                @elseif(array_key_exists('default', $data) && $data['default']==false)
                                                    <label class="switcher" data-bs-toggle="modal"
                                                           data-bs-target="#deactivateAlertModal">
                                                        <input class="switcher_input"
                                                               onclick="route_alert('{{route('admin.language.update-status',['code' =>$data['code']])}}','{{translate('want_to_update_status')}}')"
                                                               type="checkbox" {{$data['status']?'checked':''}}>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-actions">
                                                    @if($data['code']!='en')
                                                        <a data-bs-toggle="modal"
                                                           data-bs-target="{{ (env('APP_MODE') == 'demo') ? '' :'#lang-modal-update-'.$data['code'] }}"
                                                           class="table-actions_edit">
                                                            <span class="material-icons">edit</span>
                                                        </a>
                                                        @if($data['default'] != true)
                                                            <button type="button"
                                                                    onclick="{{env('APP_ENV') !='demo'}} ? form_alert('delete-{{$data['code']}}','{{translate('delete_this_language')}}?') :'javascript:demo_mode()'"
                                                                    class="table-actions_delete bg-transparent border-0 p-0">
                                                                <span class="material-icons">delete</span>
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                                <form
                                                    action="{{route('admin.language.delete',[$data['code']])}}"
                                                    method="post" id="delete-{{$data['code']}}" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
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
        </div>
    </div>
    @foreach($system_language['live_values'] ?? [] as $key =>$data)
        <div class="modal fade" id="lang-modal-update-{{$data['code']}}" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{translate('new_language')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('admin.language.update')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="hidden" name="code" value="{{ $data['code'] }}">
                                        <label for="message-text"
                                               class="col-form-label">{{translate('language')}}</label>
                                        <select disabled id="lang_code" class="form-control js-select2-custom">
                                            {{-- <option value="en" {{ $data['code']== 'en'?'selected':'' }}>English</option> --}}
                                            <option value="af" {{ $data['code']== 'af'?'selected':'' }}>Afrikaans
                                            </option>
                                            <option value="sq" {{ $data['code']== 'sq'?'selected':'' }}>Albanian -
                                                shqip
                                            </option>
                                            <option value="am" {{ $data['code']== 'am'?'selected':'' }}>Amharic - አማርኛ
                                            </option>
                                            <option value="ar" {{ $data['code']== 'ar'?'selected':'' }}>Arabic -
                                                العربية
                                            </option>
                                            <option value="an" {{ $data['code']== 'an'?'selected':'' }}>Aragonese -
                                                aragonés
                                            </option>
                                            <option value="hy" {{ $data['code']== 'hy'?'selected':'' }}>Armenian -
                                                հայերեն
                                            </option>
                                            <option value="ast" {{ $data['code']== 'ast'?'selected':'' }}>Asturian -
                                                asturianu
                                            </option>
                                            <option value="az" {{ $data['code']== 'az'?'selected':'' }}>Azerbaijani -
                                                azərbaycan dili
                                            </option>
                                            <option value="eu" {{ $data['code']== 'eu'?'selected':'' }}>Basque -
                                                euskara
                                            </option>
                                            <option value="be" {{ $data['code']== 'be'?'selected':'' }}>Belarusian -
                                                беларуская
                                            </option>
                                            <option value="bn" {{ $data['code']== 'bn'?'selected':'' }}>Bengali -
                                                বাংলা
                                            </option>
                                            <option value="bs" {{ $data['code']== 'bs'?'selected':'' }}>Bosnian -
                                                bosanski
                                            </option>
                                            <option value="br" {{ $data['code']== 'br'?'selected':'' }}>Breton -
                                                brezhoneg
                                            </option>
                                            <option value="bg" {{ $data['code']== 'bg'?'selected':'' }}>Bulgarian -
                                                български
                                            </option>
                                            <option value="ca" {{ $data['code']== 'ca'?'selected':'' }}>Catalan -
                                                català
                                            </option>
                                            <option value="ckb" {{ $data['code']== 'ckb'?'selected':'' }}>Central
                                                Kurdish - کوردی (دەستنوسی عەرەبی)
                                            </option>
                                            <option value="zh" {{ $data['code']== 'zh'?'selected':'' }}>Chinese - 中文
                                            </option>
                                            <option value="zh-HK" {{ $data['code']== 'zh-HK'?'selected':'' }}>Chinese
                                                (Hong Kong) - 中文（香港）
                                            </option>
                                            <option value="zh-CN" {{ $data['code']== 'zh-CN'?'selected':'' }}>Chinese
                                                (Simplified) - 中文（简体）
                                            </option>
                                            <option value="zh-TW" {{ $data['code']== 'zh-TW'?'selected':'' }}>Chinese
                                                (Traditional) - 中文（繁體）
                                            </option>
                                            <option value="co" {{ $data['code']== 'co'?'selected':'' }}>Corsican
                                            </option>
                                            <option value="hr" {{ $data['code']== 'hr'?'selected':'' }}>Croatian -
                                                hrvatski
                                            </option>
                                            <option value="cs" {{ $data['code']== 'cs'?'selected':'' }}>Czech -
                                                čeština
                                            </option>
                                            <option value="da" {{ $data['code']== 'da'?'selected':'' }}>Danish - dansk
                                            </option>
                                            <option value="nl" {{ $data['code']== 'nl'?'selected':'' }}>Dutch -
                                                Nederlands
                                            </option>
                                            <option value="en-AU" {{ $data['code']== 'en-AU'?'selected':'' }}>English
                                                (Australia)
                                            </option>
                                            <option value="en-CA" {{ $data['code']== 'en-CA'?'selected':'' }}>English
                                                (Canada)
                                            </option>
                                            <option value="en-IN" {{ $data['code']== 'en-IN'?'selected':'' }}>English
                                                (India)
                                            </option>
                                            <option value="en-NZ" {{ $data['code']== 'en-NZ'?'selected':'' }}>English
                                                (New Zealand)
                                            </option>
                                            <option value="en-ZA" {{ $data['code']== 'en-ZA'?'selected':'' }}>English
                                                (South Africa)
                                            </option>
                                            <option value="en-GB" {{ $data['code']== 'en-GB'?'selected':'' }}>English
                                                (United Kingdom)
                                            </option>
                                            <option value="en-US" {{ $data['code']== 'en-US'?'selected':'' }}>English
                                                (United States)
                                            </option>
                                            <option value="eo" {{ $data['code']== 'eo'?'selected':'' }}>Esperanto -
                                                esperanto
                                            </option>
                                            <option value="et" {{ $data['code']== 'et'?'selected':'' }}>Estonian -
                                                eesti
                                            </option>
                                            <option value="fo" {{ $data['code']== 'fo'?'selected':'' }}>Faroese -
                                                føroyskt
                                            </option>
                                            <option value="fil" {{ $data['code']== 'fil'?'selected':'' }}>Filipino
                                            </option>
                                            <option value="fi" {{ $data['code']== 'fi'?'selected':'' }}>Finnish -
                                                suomi
                                            </option>
                                            <option value="fr" {{ $data['code']== 'fr'?'selected':'' }}>French -
                                                français
                                            </option>
                                            <option value="fr-CA" {{ $data['code']== 'fr-CA'?'selected':'' }}>French
                                                (Canada) - français (Canada)
                                            </option>
                                            <option value="fr-FR" {{ $data['code']== 'fr-FR'?'selected':'' }}>French
                                                (France) - français (France)
                                            </option>
                                            <option value="fr-CH" {{ $data['code']== 'fr-CH'?'selected':'' }}>French
                                                (Switzerland) - français (Suisse)
                                            </option>
                                            <option value="gl" {{ $data['code']== 'gl'?'selected':'' }}>Galician -
                                                galego
                                            </option>
                                            <option value="ka" {{ $data['code']== 'ka'?'selected':'' }}>Georgian -
                                                ქართული
                                            </option>
                                            <option value="de" {{ $data['code']== 'de'?'selected':'' }}>German -
                                                Deutsch
                                            </option>
                                            <option value="de-AT" {{ $data['code']== 'de-AT'?'selected':'' }}>German
                                                (Austria) - Deutsch (Österreich)
                                            </option>
                                            <option value="de-DE" {{ $data['code']== 'de-DE'?'selected':'' }}>German
                                                (Germany) - Deutsch (Deutschland)
                                            </option>
                                            <option value="de-LI" {{ $data['code']== 'de-LI'?'selected':'' }}>German
                                                (Liechtenstein) - Deutsch (Liechtenstein)
                                            </option>
                                            <option value="de-CH" {{ $data['code']== 'de-CH'?'selected':'' }}>German
                                                (Switzerland) - Deutsch (Schweiz)
                                            </option>
                                            <option value="el" {{ $data['code']== 'el'?'selected':'' }}>Greek -
                                                Ελληνικά
                                            </option>
                                            <option value="gn" {{ $data['code']== 'gn'?'selected':'' }}>Guarani</option>
                                            <option value="gu" {{ $data['code']== 'gu'?'selected':'' }}>Gujarati -
                                                ગુજરાતી
                                            </option>
                                            <option value="ha" {{ $data['code']== 'ha'?'selected':'' }}>Hausa</option>
                                            <option value="haw" {{ $data['code']== 'haw'?'selected':'' }}>Hawaiian -
                                                ʻŌlelo Hawaiʻi
                                            </option>
                                            <option value="he" {{ $data['code']== 'he'?'selected':'' }}>Hebrew - עברית
                                            </option>
                                            <option value="hi" {{ $data['code']== 'hi'?'selected':'' }}>Hindi - हिन्दी
                                            </option>
                                            <option value="hu" {{ $data['code']== 'hu'?'selected':'' }}>Hungarian -
                                                magyar
                                            </option>
                                            <option value="is" {{ $data['code']== 'is'?'selected':'' }}>Icelandic -
                                                íslenska
                                            </option>
                                            <option value="id" {{ $data['code']== 'id'?'selected':'' }}>Indonesian -
                                                Indonesia
                                            </option>
                                            <option value="ia" {{ $data['code']== 'ia'?'selected':'' }}>Interlingua
                                            </option>
                                            <option value="ga" {{ $data['code']== 'ga'?'selected':'' }}>Irish -
                                                Gaeilge
                                            </option>
                                            <option value="it" {{ $data['code']== 'it'?'selected':'' }}>Italian -
                                                italiano
                                            </option>
                                            <option value="it-IT" {{ $data['code']== 'it-IT'?'selected':'' }}>Italian
                                                (Italy) - italiano (Italia)
                                            </option>
                                            <option value="it-CH" {{ $data['code']== 'it-CH'?'selected':'' }}>Italian
                                                (Switzerland) - italiano (Svizzera)
                                            </option>
                                            <option value="ja" {{ $data['code']== 'ja'?'selected':'' }}>Japanese -
                                                日本語
                                            </option>
                                            <option value="kn" {{ $data['code']== 'kn'?'selected':'' }}>Kannada -
                                                ಕನ್ನಡ
                                            </option>
                                            <option value="kk" {{ $data['code']== 'kk'?'selected':'' }}>Kazakh - қазақ
                                                тілі
                                            </option>
                                            <option value="km" {{ $data['code']== 'km'?'selected':'' }}>Khmer - ខ្មែរ
                                            </option>
                                            <option value="ko" {{ $data['code']== 'ko'?'selected':'' }}>Korean - 한국어
                                            </option>
                                            <option value="ku" {{ $data['code']== 'ku'?'selected':'' }}>Kurdish -
                                                Kurdî
                                            </option>
                                            <option value="ky" {{ $data['code']== 'ky'?'selected':'' }}>Kyrgyz -
                                                кыргызча
                                            </option>
                                            <option value="lo" {{ $data['code']== 'lo'?'selected':'' }}>Lao - ລາວ
                                            </option>
                                            <option value="la" {{ $data['code']== 'la'?'selected':'' }}>Latin</option>
                                            <option value="lv" {{ $data['code']== 'lv'?'selected':'' }}>Latvian -
                                                latviešu
                                            </option>
                                            <option value="ln" {{ $data['code']== 'ln'?'selected':'' }}>Lingala -
                                                lingála
                                            </option>
                                            <option value="lt" {{ $data['code']== 'lt'?'selected':'' }}>Lithuanian -
                                                lietuvių
                                            </option>
                                            <option value="mk" {{ $data['code']== 'mk'?'selected':'' }}>Macedonian -
                                                македонски
                                            </option>
                                            <option value="ms" {{ $data['code']== 'ms'?'selected':'' }}>Malay - Bahasa
                                                Melayu
                                            </option>
                                            <option value="ml" {{ $data['code']== 'ml'?'selected':'' }}>Malayalam -
                                                മലയാളം
                                            </option>
                                            <option value="mt" {{ $data['code']== 'mt'?'selected':'' }}>Maltese -
                                                Malti
                                            </option>
                                            <option value="mr" {{ $data['code']== 'mr'?'selected':'' }}>Marathi -
                                                मराठी
                                            </option>
                                            <option value="mn" {{ $data['code']== 'mn'?'selected':'' }}>Mongolian -
                                                монгол
                                            </option>
                                            <option value="ne" {{ $data['code']== 'ne'?'selected':'' }}>Nepali -
                                                नेपाली
                                            </option>
                                            <option value="no" {{ $data['code']== 'no'?'selected':'' }}>Norwegian -
                                                norsk
                                            </option>
                                            <option value="nb" {{ $data['code']== 'nb'?'selected':'' }}>Norwegian Bokmål
                                                - norsk bokmål
                                            </option>
                                            <option value="nn" {{ $data['code']== 'nn'?'selected':'' }}>Norwegian
                                                Nynorsk - nynorsk
                                            </option>
                                            <option value="oc" {{ $data['code']== 'oc'?'selected':'' }}>Occitan</option>
                                            <option value="or" {{ $data['code']== 'or'?'selected':'' }}>Oriya - ଓଡ଼ିଆ
                                            </option>
                                            <option value="om" {{ $data['code']== 'om'?'selected':'' }}>Oromo - Oromoo
                                            </option>
                                            <option value="ps" {{ $data['code']== 'ps'?'selected':'' }}>Pashto - پښتو
                                            </option>
                                            <option value="fa" {{ $data['code']== 'fa'?'selected':'' }}>Persian -
                                                فارسی
                                            </option>
                                            <option value="pl" {{ $data['code']== 'pl'?'selected':'' }}>Polish -
                                                polski
                                            </option>
                                            <option value="pt" {{ $data['code']== 'pt'?'selected':'' }}>Portuguese -
                                                português
                                            </option>
                                            <option value="pt-BR" {{ $data['code']== 'pt-BR'?'selected':'' }}>Portuguese
                                                (Brazil) - português (Brasil)
                                            </option>
                                            <option value="pt-PT" {{ $data['code']== 'pt-PT'?'selected':'' }}>Portuguese
                                                (Portugal) - português (Portugal)
                                            </option>
                                            <option value="pa" {{ $data['code']== 'pa'?'selected':'' }}>Punjabi -
                                                ਪੰਜਾਬੀ
                                            </option>
                                            <option value="qu" {{ $data['code']== 'qu'?'selected':'' }}>Quechua</option>
                                            <option value="ro" {{ $data['code']== 'ro'?'selected':'' }}>Romanian -
                                                română
                                            </option>
                                            <option value="mo" {{ $data['code']== 'mo'?'selected':'' }}>Romanian
                                                (Moldova) - română (Moldova)
                                            </option>
                                            <option value="rm" {{ $data['code']== 'rm'?'selected':'' }}>Romansh -
                                                rumantsch
                                            </option>
                                            <option value="ru" {{ $data['code']== 'ru'?'selected':'' }}>Russian -
                                                русский
                                            </option>
                                            <option value="gd" {{ $data['code']== 'gd'?'selected':'' }}>Scottish
                                                Gaelic
                                            </option>
                                            <option value="sr" {{ $data['code']== 'sr'?'selected':'' }}>Serbian -
                                                српски
                                            </option>
                                            <option value="sh" {{ $data['code']== 'sh'?'selected':'' }}>Serbo-Croatian -
                                                Srpskohrvatski
                                            </option>
                                            <option value="sn" {{ $data['code']== 'sn'?'selected':'' }}>Shona -
                                                chiShona
                                            </option>
                                            <option value="sd" {{ $data['code']== 'sd'?'selected':'' }}>Sindhi</option>
                                            <option value="si" {{ $data['code']== 'si'?'selected':'' }}>Sinhala -
                                                සිංහල
                                            </option>
                                            <option value="sk" {{ $data['code']== 'sk'?'selected':'' }}>Slovak -
                                                slovenčina
                                            </option>
                                            <option value="sl" {{ $data['code']== 'sl'?'selected':'' }}>Slovenian -
                                                slovenščina
                                            </option>
                                            <option value="so" {{ $data['code']== 'so'?'selected':'' }}>Somali -
                                                Soomaali
                                            </option>
                                            <option value="st" {{ $data['code']== 'st'?'selected':'' }}>Southern Sotho
                                            </option>
                                            <option value="es" {{ $data['code']== 'es'?'selected':'' }}>Spanish -
                                                español
                                            </option>
                                            <option value="es-AR" {{ $data['code']== 'es-AR'?'selected':'' }}>Spanish
                                                (Argentina) - español (Argentina)
                                            </option>
                                            <option value="es-419" {{ $data['code']== 'es-419'?'selected':'' }}>Spanish
                                                (Latin America) - español (Latinoamérica)
                                            </option>
                                            <option value="es-MX" {{ $data['code']== 'es-MX'?'selected':'' }}>Spanish
                                                (Mexico) - español (México)
                                            </option>
                                            <option value="es-ES" {{ $data['code']== 'es-ES'?'selected':'' }}>Spanish
                                                (Spain) - español (España)
                                            </option>
                                            <option value="es-US" {{ $data['code']== 'es-US'?'selected':'' }}>Spanish
                                                (United States) - español (Estados Unidos)
                                            </option>
                                            <option value="su" {{ $data['code']== 'su'?'selected':'' }}>Sundanese
                                            </option>
                                            <option value="sw" {{ $data['code']== 'sw'?'selected':'' }}>Swahili -
                                                Kiswahili
                                            </option>
                                            <option value="sv" {{ $data['code']== 'sv'?'selected':'' }}>Swedish -
                                                svenska
                                            </option>
                                            <option value="tg" {{ $data['code']== 'tg'?'selected':'' }}>Tajik - тоҷикӣ
                                            </option>
                                            <option value="ta" {{ $data['code']== 'ta'?'selected':'' }}>Tamil - தமிழ்
                                            </option>
                                            <option value="tt" {{ $data['code']== 'tt'?'selected':'' }}>Tatar</option>
                                            <option value="te" {{ $data['code']== 'te'?'selected':'' }}>Telugu -
                                                తెలుగు
                                            </option>
                                            <option value="th" {{ $data['code']== 'th'?'selected':'' }}>Thai - ไทย
                                            </option>
                                            <option value="ti" {{ $data['code']== 'ti'?'selected':'' }}>Tigrinya -
                                                ትግርኛ
                                            </option>
                                            <option value="to" {{ $data['code']== 'to'?'selected':'' }}>Tongan - lea
                                                fakatonga
                                            </option>
                                            <option value="tr" {{ $data['code']== 'tr'?'selected':'' }}>Turkish -
                                                Türkçe
                                            </option>
                                            <option value="tk" {{ $data['code']== 'tk'?'selected':'' }}>Turkmen</option>
                                            <option value="tw" {{ $data['code']== 'tw'?'selected':'' }}>Twi</option>
                                            <option value="uk" {{ $data['code']== 'uk'?'selected':'' }}>Ukrainian -
                                                українська
                                            </option>
                                            <option value="ur" {{ $data['code']== 'ur'?'selected':'' }}>Urdu - اردو
                                            </option>
                                            <option value="ug" {{ $data['code']== 'ug'?'selected':'' }}>Uyghur</option>
                                            <option value="uz" {{ $data['code']== 'uz'?'selected':'' }}>Uzbek - o‘zbek
                                            </option>
                                            <option value="vi" {{ $data['code']== 'vi'?'selected':'' }}>Vietnamese -
                                                Tiếng Việt
                                            </option>
                                            <option value="wa" {{ $data['code']== 'wa'?'selected':'' }}>Walloon - wa
                                            </option>
                                            <option value="cy" {{ $data['code']== 'cy'?'selected':'' }}>Welsh -
                                                Cymraeg
                                            </option>
                                            <option value="fy" {{ $data['code']== 'fy'?'selected':'' }}>Western
                                                Frisian
                                            </option>
                                            <option value="xh" {{ $data['code']== 'xh'?'selected':'' }}>Xhosa</option>
                                            <option value="yi" {{ $data['code']== 'yi'?'selected':'' }}>Yiddish</option>
                                            <option value="yo" {{ $data['code']== 'yo'?'selected':'' }}>Yoruba - Èdè
                                                Yorùbá
                                            </option>
                                            <option value="zu" {{ $data['code']== 'zu'?'selected':'' }}>Zulu - isiZulu
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{translate('direction')}} :</label>
                                        <select class="form-control" name="direction">
                                            <option
                                                value="ltr" {{isset($data['direction'])?$data['direction']=='ltr'?'selected':'':''}}>
                                                {{translate('LTR')}}
                                            </option>
                                            <option
                                                value="rtl" {{isset($data['direction'])?$data['direction']=='rtl'?'selected':'':''}}>
                                                {{translate('RTL')}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{translate('close')}}</button>
                            <button type="submit" class="btn btn--primary">{{translate('update')}} <i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('script')
    <script>
        function default_language_status_alert() {
            toastr.warning('{{translate("default_language_can_not_be_deactive") }}!');
        }
    </script>

    <script>
        function default_status_change(route, message) {
            Swal.fire({
                title: "<?php echo e(translate('are_you_sure')); ?>?",
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'var(--c2)',
                confirmButtonColor: 'var(--c1)',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: route,
                        dataType: 'json',
                        data: {},
                        beforeSend: function () {
                            /*$('#loading').show();*/
                        },
                        success: function (data) {
                            console.log(data)
                            setTimeout(function () {
                                location.reload();
                            }, 1000);

                            toastr.success(data.message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        },
                        complete: function () {
                            /*$('#loading').hide();*/
                        },
                    });
                }
            })
        }
    </script>

@endpush
