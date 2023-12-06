@extends('adminmodule::layouts.master')

@section('title',translate('notification_setup'))

@push('css_or_js')
    <link rel="stylesheet" href="{{asset('public/assets/admin-module')}}/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="{{asset('public/assets/admin-module')}}/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="{{asset('public/assets/admin-module')}}/plugins/dataTables/select.dataTables.min.css"/>
    <link rel="stylesheet" href="{{asset('public/assets/admin-module')}}/plugins/swiper/swiper-bundle.min.css"/>
@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title">{{translate('notification_setup')}}</h2>
                    </div>

                    <div class="card mb-30">
                        <div class="card-body p-30">
                            <div class="table-responsive">
                                <table id="example" class="table align-middle">
                                    <thead>
                                    <tr>
                                        <th>{{translate('Notifications')}}</th>
                                        <th>{{translate('Push_Notification')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($array=['booking','tnc_update','pp_update'])
                                    @foreach($data_settings_values->whereIn('key_name',$array)->all() as $value)
                                        @if($value['key_name']=='tnc_update')
                                            @php($name='terms & conditions update')
                                        @elseif($value['key_name']=='pp_update')
                                            @php($name='privacy policy update')
                                        @else
                                            @php($name=str_replace('_',' ',$value['key_name']))
                                        @endif
                                        <tr>
                                            <td class="text-capitalize">{{$name}}</td>

                                            <td>
                                                <label class="switcher">
                                                    <input class="switcher_input"
                                                           onclick="update_action_status('push_notification_{{$value['key_name']}}',$(this).is(':checked')===true?1:0)"
                                                           type="checkbox" {{$value->live_values['push_notification_'.$value['key_name']]?'checked':''}}>
                                                    <span class="switcher_control"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-30">
                            <div class="discount-type">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="page-header align-items-center">
                                        <h4>{{translate('Firebase_Push_Notification_Setup')}}</h4>
                                    </div>
                                    <div class="d-flex align-items-center gap-3 font-weight-bolder text-primary">
                                        {{ translate('Read Instructions') }}
                                        <div class="ripple-animation" data-bs-toggle="modal"
                                             data-bs-target="#documentationModal" type="button">
                                            <img src="{{asset('/public/assets/admin-module/img/info.svg')}}" class="svg"
                                                 alt="">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex flex-wrap justify-content-between gap-3 mb-2">
                                    @php($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first())
                                    @php($default_lang = str_replace('_', '-', app()->getLocale()))
                                    @if($language)
                                        <ul class="nav nav--tabs border-color-primary">
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

                                    <div class="select-box mb-5">
                                        <select class="js-select" id="notification_type" name="notification_type">
                                            <option
                                                value="customers" {{ $query_params == 'customers' ? 'selected' : '' }}>{{ translate('Messages_For_Customers') }}</option>
                                            <option
                                                value="providers" {{ $query_params == 'providers' ? 'selected' : '' }}>{{ translate('Messages_For_Providers') }}</option>
                                            <option
                                                value="serviceman" {{ $query_params == 'serviceman' ? 'selected' : '' }}>{{ translate('Messages_For_Serviceman') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    @if($query_params == 'customers')
                                        @foreach(NOTIFICATION_FOR_USER as $user_notification)
                                            <div class="col-md-6">
                                                <form method="POST"
                                                      action="{{route('admin.configuration.set-message-setting', ['type' => $query_params])}}">
                                                    @csrf
                                                    @method('PUT')
                                                    @if($language)
                                                        <div class="mb-30 lang-form default-form">
                                                            <div class="mb-20 d-flex justify-content-between">
                                                                <b>{{ translate($user_notification['value'] . '_Message') }}</b>

                                                                <label class="switcher">
                                                                    <input class="switcher_input"
                                                                           name="status"
                                                                           id="{{$user_notification['key']}}_status"
                                                                           {{$data_values->where('key_name', $user_notification['key'])->where('settings_type', 'customer_notification')->first()?->live_values[$user_notification['key'].'_status']?'checked':''}}
                                                                           onclick="update_message('{{$user_notification['key'] ?? ''}}')"
                                                                           type="checkbox"
                                                                           value="1">
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" name="id"
                                                                   value="{{ $user_notification['key'] }}">
                                                            <div class="form-floating">
                                                                <textarea class="form-control"
                                                                          id="{{ $user_notification['key'] }}_message"
                                                                          name="{{ $user_notification['key'] ?? '' }}_message[]">{{$data_values->where('key_name', $user_notification['key'])->where('settings_type', 'customer_notification')->first()?->live_values[$user_notification['key'].'_message']}}</textarea>
                                                            </div>
                                                            <div class="d-flex justify-content-end mt-10">
                                                                <button type="submit"
                                                                        class="btn btn--primary">
                                                                    {{translate('update')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="default">
                                                        @foreach ($language?->live_values as $lang)
                                                                <?php
                                                                $notification_row = $data_values->where('key_name', $user_notification['key'])->where('settings_type', 'customer_notification')->first();
                                                                if (count($notification_row['translations'])) {
                                                                    $translate = [];
                                                                    foreach ($notification_row['translations'] as $t) {
                                                                        if ($t->locale == $lang['code'] && $t->key == $notification_row->key_name) {
                                                                            $translate[$lang['code']][$notification_row->key_name] = $t->value;
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            <div class="mb-30 d-none lang-form {{$lang['code']}}-form">
                                                                <div class="mb-20 d-flex justify-content-between">
                                                                    <b>{{ translate($user_notification['value'] . '_Message') }}
                                                                        ({{strtoupper($lang['code'])}})</b>

                                                                    <label class="switcher">
                                                                        <input class="switcher_input"
                                                                               name="status"
                                                                               id="{{$user_notification['key']}}_status"
                                                                               {{$data_values->where('key_name', $user_notification['key'])->where('settings_type', 'customer_notification')->first()?->live_values[$user_notification['key'].'_status']?'checked':''}}
                                                                               onclick="update_message('{{$user_notification['key'] ?? ''}}')"
                                                                               type="checkbox"
                                                                               value="1">
                                                                        <span class="switcher_control"></span>
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="id"
                                                                       value="{{ $user_notification['key'] }}">
                                                                <div class="form-floating">
                                                                <textarea class="form-control"
                                                                          id="{{ $user_notification['key'] }}_message"
                                                                          name="{{ $user_notification['key'] ?? '' }}_message[]"
                                                                          {{$lang['status'] == '1' ? 'required':''}}
                                                                          @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>{{$translate[$lang['code']][$notification_row->key_name] ?? ''}}</textarea>
                                                                </div>
                                                                <div class="d-flex justify-content-end mt-10">
                                                                    <button type="submit"
                                                                            class="btn btn--primary">
                                                                        {{translate('update')}}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="lang[]"
                                                                   value="{{$lang['code']}}">
                                                        @endforeach
                                                    @else
                                                        <div class="mb-30 lang-form">
                                                            <div class="mb-20 d-flex justify-content-between">
                                                                <b>{{ translate($user_notification['value'] . '_Message') }}</b>

                                                                <label class="switcher">
                                                                    <input class="switcher_input"
                                                                           name="status"
                                                                           id="{{$user_notification['key']}}_status"
                                                                           {{$data_values->where('key_name', $user_notification['key'])->where('settings_type', 'customer_notification')->first()?->live_values[$user_notification['key'].'_status']?'checked':''}}
                                                                           onclick="update_message('{{$user_notification['key'] ?? ''}}')"
                                                                           type="checkbox"
                                                                           value="1">
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" name="id"
                                                                   value="{{ $user_notification['key'] }}">
                                                            <div class="form-floating">
                                                                <textarea class="form-control"
                                                                          id="{{ $user_notification['key'] }}_message"
                                                                          name="{{ $user_notification['key'] ?? '' }}_message[]">{{$data_values->where('key_name', $user_notification['key'])->where('settings_type', 'customer_notification')->first()?->live_values[$user_notification['key'].'_message']}}</textarea>
                                                            </div>
                                                            <div class="d-flex justify-content-end mt-10">
                                                                <button type="submit"
                                                                        class="btn btn--primary">
                                                                    {{translate('update')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="default">
                                                    @endif
                                                </form>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if($query_params == 'providers')
                                        @foreach(NOTIFICATION_FOR_PROVIDER as $provider_notification)
                                            <div class="col-md-6">
                                                <form method="POST"
                                                      action="{{route('admin.configuration.set-message-setting', ['type' => $query_params])}}">
                                                    @csrf
                                                    @method('PUT')
                                                    @if($language)
                                                        <div class="mb-30 lang-form default-form">
                                                            <div class="mb-20 d-flex justify-content-between">
                                                                <b>{{ translate($provider_notification['value'] . '_Message') }}</b>

                                                                <label class="switcher">
                                                                    <input class="switcher_input"
                                                                           name="status"
                                                                           id="{{$provider_notification['key']}}_status"
                                                                           {{$data_values->where('key_name', $provider_notification['key'])->where('settings_type', 'provider_notification')->first()?->live_values[$provider_notification['key'].'_status']?'checked':''}}
                                                                           onclick="update_message('{{$provider_notification['key'] ?? ''}}')"
                                                                           type="checkbox"
                                                                           value="1">
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" name="id"
                                                                   value="{{ $provider_notification['key'] }}">
                                                            <div class="form-floating">
                                                                <textarea class="form-control"
                                                                          id="{{ $provider_notification['key'] }}_message"
                                                                          name="{{ $provider_notification['key'] ?? '' }}_message[]">{{$data_values->where('key_name', $provider_notification['key'])->where('settings_type', 'provider_notification')->first()?->live_values[$provider_notification['key'].'_message']}}</textarea>
                                                            </div>
                                                            <div class="d-flex justify-content-end mt-10">
                                                                <button type="submit"
                                                                        class="btn btn--primary">
                                                                    {{translate('update')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="default">
                                                        @foreach ($language?->live_values as $lang)
                                                                <?php
                                                                $notification_row = $data_values->where('key_name', $provider_notification['key'])->where('settings_type', 'provider_notification')->first();
                                                                if (count($notification_row['translations'])) {
                                                                    $translate = [];
                                                                    foreach ($notification_row['translations'] as $t) {
                                                                        if ($t->locale == $lang['code'] && $t->key == $notification_row->key_name) {
                                                                            $translate[$lang['code']][$notification_row->key_name] = $t->value;
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            <div class="mb-30 d-none lang-form {{$lang['code']}}-form">
                                                                <div class="mb-20 d-flex justify-content-between">
                                                                    <b>{{ translate($provider_notification['value'] . '_Message') }}
                                                                        ({{strtoupper($lang['code'])}})</b>

                                                                    <label class="switcher">
                                                                        <input class="switcher_input"
                                                                               name="status"
                                                                               id="{{$provider_notification['key']}}_status"
                                                                               {{$data_values->where('key_name', $provider_notification['key'])->where('settings_type', 'provider_notification')->first()?->live_values[$provider_notification['key'].'_status']?'checked':''}}
                                                                               onclick="update_message('{{$provider_notification['key'] ?? ''}}')"
                                                                               type="checkbox"
                                                                               value="1">
                                                                        <span class="switcher_control"></span>
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="id"
                                                                       value="{{ $provider_notification['key'] }}">
                                                                <div class="form-floating">
                                                                <textarea class="form-control"
                                                                          id="{{ $provider_notification['key'] }}_message"
                                                                          name="{{ $provider_notification['key'] ?? '' }}_message[]"
                                                                          {{$lang['status'] == '1' ? 'required':''}}
                                                                          @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>{{$translate[$lang['code']][$notification_row->key_name] ?? ''}}</textarea>
                                                                </div>
                                                                <div class="d-flex justify-content-end mt-10">
                                                                    <button type="submit"
                                                                            class="btn btn--primary">
                                                                        {{translate('update')}}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="lang[]"
                                                                   value="{{$lang['code']}}">
                                                        @endforeach
                                                    @else
                                                        <div class="mb-30 lang-form">
                                                            <div class="mb-20 d-flex justify-content-between">
                                                                <b>{{ translate($provider_notification['value'] . '_Message') }}</b>

                                                                <label class="switcher">
                                                                    <input class="switcher_input"
                                                                           name="status"
                                                                           id="{{$provider_notification['key']}}_status"
                                                                           {{$data_values->where('key_name', $provider_notification['key'])->where('settings_type', 'provider_notification')->first()?->live_values[$provider_notification['key'].'_status']?'checked':''}}
                                                                           onclick="update_message('{{$provider_notification['key'] ?? ''}}')"
                                                                           type="checkbox"
                                                                           value="1">
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" name="id"
                                                                   value="{{ $provider_notification['key'] }}">
                                                            <div class="form-floating">
                                                                <textarea class="form-control"
                                                                          id="{{ $provider_notification['key'] }}_message"
                                                                          name="{{ $provider_notification['key'] ?? '' }}_message[]">{{$data_values->where('key_name', $provider_notification['key'])->where('settings_type', 'provider_notification')->first()?->live_values[$provider_notification['key'].'_message']}}</textarea>
                                                            </div>
                                                            <div class="d-flex justify-content-end mt-10">
                                                                <button type="submit"
                                                                        class="btn btn--primary">
                                                                    {{translate('update')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="default">
                                                    @endif
                                                </form>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if($query_params == 'serviceman')
                                        @foreach(NOTIFICATION_FOR_SERVICEMAN as $serviceman_notification)
                                            <div class="col-md-6">
                                                <form method="POST"
                                                      action="{{route('admin.configuration.set-message-setting', ['type' => $query_params])}}">
                                                    @csrf
                                                    @method('PUT')
                                                    @if($language)
                                                        <div class="mb-30 lang-form default-form">
                                                            <div class="mb-20 d-flex justify-content-between">
                                                                <b>{{ translate($serviceman_notification['value'] . '_Message') }}</b>

                                                                <label class="switcher">
                                                                    <input class="switcher_input"
                                                                           name="status"
                                                                           id="{{$serviceman_notification['key']}}_status"
                                                                           {{$data_values->where('key_name', $serviceman_notification['key'])->where('settings_type', 'serviceman_notification')->first()?->live_values[$serviceman_notification['key'].'_status']?'checked':''}}
                                                                           onclick="update_message('{{$serviceman_notification['key'] ?? ''}}')"
                                                                           type="checkbox"
                                                                           value="1">
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" name="id"
                                                                   value="{{ $serviceman_notification['key'] }}">
                                                            <div class="form-floating">
                                                                <textarea class="form-control"
                                                                          id="{{ $serviceman_notification['key'] }}_message"
                                                                          name="{{ $serviceman_notification['key'] ?? '' }}_message[]">{{$data_values->where('key_name', $serviceman_notification['key'])->where('settings_type', 'serviceman_notification')->first()?->live_values[$serviceman_notification['key'].'_message']}}</textarea>
                                                            </div>
                                                            <div class="d-flex justify-content-end mt-10">
                                                                <button type="submit"
                                                                        class="btn btn--primary">
                                                                    {{translate('update')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="default">
                                                        @foreach ($language?->live_values as $lang)
                                                                <?php
                                                                $notification_row = $data_values->where('key_name', $serviceman_notification['key'])->where('settings_type', 'serviceman_notification')->first();
                                                                if (count($notification_row['translations'])) {
                                                                    $translate = [];
                                                                    foreach ($notification_row['translations'] as $t) {
                                                                        if ($t->locale == $lang['code'] && $t->key == $notification_row->key_name) {
                                                                            $translate[$lang['code']][$notification_row->key_name] = $t->value;
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            <div class="mb-30 d-none lang-form {{$lang['code']}}-form">
                                                                <div class="mb-20 d-flex justify-content-between">
                                                                    <b>{{ translate($serviceman_notification['value'] . '_Message') }}
                                                                        ({{strtoupper($lang['code'])}})</b>

                                                                    <label class="switcher">
                                                                        <input class="switcher_input"
                                                                               name="status"
                                                                               id="{{$serviceman_notification['key']}}_status"
                                                                               {{$data_values->where('key_name', $serviceman_notification['key'])->where('settings_type', 'serviceman_notification')->first()?->live_values[$serviceman_notification['key'].'_status']?'checked':''}}
                                                                               onclick="update_message('{{$serviceman_notification['key'] ?? ''}}')"
                                                                               type="checkbox"
                                                                               value="1">
                                                                        <span class="switcher_control"></span>
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="id"
                                                                       value="{{ $serviceman_notification['key'] }}">
                                                                <div class="form-floating">
                                                                <textarea class="form-control"
                                                                          id="{{ $serviceman_notification['key'] }}_message"
                                                                          name="{{ $serviceman_notification['key'] ?? '' }}_message[]"
                                                                          {{$lang['status'] == '1' ? 'required':''}}
                                                                          @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>{{$translate[$lang['code']][$notification_row->key_name] ?? ''}}</textarea>
                                                                </div>
                                                                <div class="d-flex justify-content-end mt-10">
                                                                    <button type="submit"
                                                                            class="btn btn--primary">
                                                                        {{translate('update')}}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="lang[]"
                                                                   value="{{$lang['code']}}">
                                                        @endforeach
                                                    @else
                                                        <div class="mb-30 lang-form">
                                                            <div class="mb-20 d-flex justify-content-between">
                                                                <b>{{ translate($serviceman_notification['value'] . '_Message') }}</b>

                                                                <label class="switcher">
                                                                    <input class="switcher_input"
                                                                           name="status"
                                                                           id="{{$serviceman_notification['key']}}_status"
                                                                           {{$data_values->where('key_name', $serviceman_notification['key'])->where('settings_type', 'serviceman_notification')->first()?->live_values[$serviceman_notification['key'].'_status']?'checked':''}}
                                                                           onclick="update_message('{{$serviceman_notification['key'] ?? ''}}')"
                                                                           type="checkbox"
                                                                           value="1">
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" name="id"
                                                                   value="{{ $serviceman_notification['key'] }}">
                                                            <div class="form-floating">
                                                                <textarea class="form-control"
                                                                          id="{{ $serviceman_notification['key'] }}_message"
                                                                          name="{{ $serviceman_notification['key'] ?? '' }}_message[]">{{$data_values->where('key_name', $serviceman_notification['key'])->where('settings_type', 'serviceman_notification')->first()?->live_values[$serviceman_notification['key'].'_message']}}</textarea>
                                                            </div>
                                                            <div class="d-flex justify-content-end mt-10">
                                                                <button type="submit"
                                                                        class="btn btn--primary">
                                                                    {{translate('update')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="default">
                                                    @endif
                                                </form>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Documentation Modal -->
    <div class="modal fade" id="documentationModal" tabindex="-1" aria-labelledby="documentationModalLabel"
         aria-hidden="true" style="--bs-modal-width: 436px">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-1">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column align-items-center gap-2 max-w360 mx-auto fs-12">
                        <img width="80" class="mb-3"
                             src="{{asset('public/assets/admin-module/img/media/documentation.png')}}" alt="">
                        <h5 class="modal-title text-center mb-3">Documentation</h5>
                        <p>{{translate('If disabled customers and seller will not receive notifications on their devices')}}</p>

                        <ul class="d-flex flex-column gap-2 px-3">
                            <li><span
                                    class="fw-medium">&#123;&#123;providerName&#125;&#125;:</span> {{translate('the name of the provider.')}}
                            </li>
                            <li><span
                                    class="fw-medium">&#123;&#123;serviceManName&#125;&#125;:</span> {{translate('the name of the service man name.')}}
                            </li>
                            <li><span
                                    class="fw-medium">&#123;&#123;bookingId&#125;&#125;:</span> {{translate('the unique ID of the Booking.')}}
                            </li>
                            <li><span
                                    class="fw-medium">&#123;&#123;scheduleTime&#125;&#125;:</span> {{translate('the expected sechedule time.')}}
                            </li>
                            <li><span
                                    class="fw-medium">&#123;&#123;userName&#125;&#125;:</span> {{translate('the name of the user who placed the order.')}}
                            </li>
                            <li><span
                                    class="fw-medium">&#123;&#123;zoneName&#125;&#125;:</span> {{translate('the name of the zone.')}}
                            </li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-center mt-2">
                        <button type="button" class="btn btn-primary w-100 max-w320" data-bs-dismiss="modal">Got It
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel Modal -->
    <div class="modal fade" id="carouselModal" tabindex="-1" aria-labelledby="carouselModal" aria-hidden="true"
         style="--bs-modal-width: 480px">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-1">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 px-sm-5 pt-0">
                    <div dir="ltr" class="swiper modalSwiper pb-4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="d-flex flex-column align-items-center gap-2 fs-12">
                                    <img width="80" class="mb-3"
                                         src="{{asset('public/assets/admin-module/img/media/firebase-console.png')}}"
                                         alt="">
                                    <h5 class="modal-title text-center mb-3">{{translate('Go to Firebase Console')}}</h5>

                                    <ul class="d-flex flex-column gap-2 px-3">
                                        <li>{{translate('Open your web browser and go to the Firebase Console')}} ( <a
                                                href="https://console.firebase.google.com">https://console.firebase.google.com/</a>
                                            ).
                                        </li>
                                        <li>{{translate('Select the project for which you want to configure FCM from the Firebase
                                            Console dashboard.')}}
                                        </li>
                                        <li>{{translate('If you don’t have any project before. Create one with the website name.')}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="d-flex flex-column align-items-center gap-2 fs-12">
                                    <img width="80" class="mb-3"
                                         src="{{asset('public/assets/admin-module/img/media/project-settings.png')}}"
                                         alt="">
                                    <h5 class="modal-title text-center mb-3">{{translate('Navigate to Project Settings')}}</h5>

                                    <ul class="d-flex flex-column gap-2 px-3">
                                        <li>{{translate('In the left-hand menu, click on the')}}
                                            <strong>"Settings"</strong> {{translate('gear icon,
                                            there you will vae a dropdown. and then select ')}}<strong>"Project
                                                settings"</strong> {{translate('from the dropdown.')}}
                                        </li>
                                        <li>{{translate('In the Project settings page, click on the "Cloud Messaging" tab from the
                                            top menu.')}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="d-flex flex-column align-items-center gap-2 fs-12">
                                    <img width="80" class="mb-3"
                                         src="{{asset('public/assets/admin-module/img/media/cloud-message.png')}}"
                                         alt="">
                                    <h5 class="modal-title text-center mb-3">{{translate('Cloud Messaging API')}}</h5>

                                    <ul class="d-flex flex-column gap-2 px-3">
                                        <li>{{translate('From Cloud Messaging Page there will be a section called Cloud Messaging
                                            API.')}}
                                        </li>
                                        <li>{{translate('Click on the menu icon and enable the API')}}</li>
                                        <li>{{translate('Refresh the Cloud Messaging Page - You will have your server key. Just copy
                                            the code and paste here')}}
                                        </li>
                                    </ul>

                                    <div class="d-flex justify-content-center mt-2 w-100">
                                        <button type="button" class="btn btn-primary w-100 max-w320"
                                                data-bs-dismiss="modal">{{translate('Got It')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination mb-2"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
@endsection

@push('script')
    <script src="{{asset('public/assets/admin-module')}}/plugins/select2/select2.min.js"></script>
    <script src="{{asset('public/assets/admin-module')}}/plugins/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".modalSwiper", {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
                autoHeight: true,
            },
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.js-select').select2();
        });
    </script>
    <script src="{{asset('public/assets/admin-module')}}/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/admin-module')}}/plugins/dataTables/dataTables.select.min.js"></script>

    <script>
        $('#business-info-update-form').on('submit', function (event) {
            event.preventDefault();

            var form = $('#business-info-update-form')[0];
            var formData = new FormData(form);
            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.business-settings.set-business-information')}}",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (response) {
                    toastr.success('{{translate('successfully_updated')}}')
                },
                error: function () {

                }
            });
        });

        function update_action_status(key_name, value) {
            Swal.fire({
                title: "{{translate('are_you_sure')}}?",
                text: '{{translate('want_to_update_status')}}',
                type: 'warning',
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonColor: 'var(--c2)',
                confirmButtonColor: 'var(--c1)',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.configuration.set-notification-setting')}}",
                        data: {
                            key: key_name,
                            value: value,
                        },
                        type: 'put',
                        success: function (response) {
                            console.log(response)
                            toastr.success('{{translate('successfully_updated')}}')
                        },
                        error: function () {

                        }
                    });
                }
            })
        }

        function update_message(id) {
            Swal.fire({
                title: "{{translate('are_you_sure')}}?",
                text: '{{translate('want_to_update')}}',
                type: 'warning',
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonColor: 'var(--c2)',
                confirmButtonColor: 'var(--c1)',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.configuration.set-message-setting')}}",
                        data: {
                            id: id,
                            status: $('#' + id + '_status').is(':checked') === true ? 1 : 0,
                            message: $('#' + id + '_message').val(),
                            type: "{{$query_params}}"
                        },
                        type: 'PUT',
                        success: function (response) {
                            console.log(response)
                            toastr.success('{{translate('successfully_updated')}}')
                        },
                        error: function () {

                        }
                    });
                }
            })
        }
    </script>

    <script>
        $(document).ready(function () {
            $('#notification_type').on('change', function () {
                var selectedOption = $(this).val();

                // Get the current URL
                var currentUrl = window.location.href;
                var url = new URL(currentUrl);

                // Update the value part of the 'type' parameter
                url.searchParams.set('type', selectedOption);

                // Reload the page with the updated URL
                window.location.href = url.toString();
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
