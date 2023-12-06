@extends('adminmodule::layouts.master')

@section('title',translate('3rd_party'))

@push('css_or_js')
    <link rel="stylesheet" href="{{asset('public/assets/admin-module')}}/plugins/swiper/swiper-bundle.min.css"/>
@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title">{{translate('3rd_party')}}</h2>
                    </div>

                    <!-- Nav Tabs -->
                    <div class="mb-3">
                        <ul class="nav nav--tabs nav--tabs__style2">
                            @include('businesssettingsmodule::admin.partials.third-party-partial')
                        </ul>
                    </div>
                    <!-- End Nav Tabs -->

                    <!-- Tab Content -->
                    @if($web_page == 'google_map')
                    <div class="tab-content">
                        <div class="tab-pane fade {{$web_page == 'google_map' ? 'show active' : ''}}" id="google-map">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">{{translate('google_map_api_key_setup')}}</h4>
                                </div>
                                <div class="card-body p-30">
                                    <div class="alert alert-danger mb-30">
                                        <p><i class="material-icons">info</i>
                                            {{translate('Client Key Should Have Enable Map Javascript Api And You Can Restrict It With Http Refere. Server Key Should Have Enable Place Api Key And You Can Restrict It With Ip. You Can Use Same Api For Both Field Without Any Restrictions.')}}
                                        </p>
                                    </div>
                                    <form action="{{route('admin.configuration.set-third-party-config')}}" method="POST"
                                          id="google-map-update-form" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="discount-type">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="mb-30">
                                                        <div class="form-floating">
                                                            <input name="party_name" value="google_map"
                                                                   class="hide-div">
                                                            <input type="text" class="form-control"
                                                                   name="map_api_key_server"
                                                                   placeholder="{{translate('map_api_key_server')}} *"
                                                                   required=""
                                                                   value="{{bs_data($data_values,'google_map')['map_api_key_server']??''}}">
                                                            <label>{{translate('map_api_key_server')}} *</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="mb-30">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control"
                                                                   name="map_api_key_client"
                                                                   placeholder="{{translate('map_api_key_client')}} *"
                                                                   required=""
                                                                   value="{{bs_data($data_values,'google_map')['map_api_key_client']??''}}">
                                                            <label>{{translate('map_api_key_client')}} *</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn--primary demo_check">
                                                {{translate('update')}}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($web_page == 'push_notification')
                    <div class="tab-content">
                        <div class="tab-pane fade {{$web_page == 'push_notification' ? 'show active' : ''}}" id="firebase-push-notification">
                            <div class="card">
                                <div class="card-header">

                                    <div class="d-flex justify-content-between mb-5">
                                        <div class="page-header align-items-center">
                                            <h4>{{translate('Firebase_Push_Notification_Setup')}}</h4>
                                        </div>
                                        <div class="d-flex align-items-center gap-3 font-weight-bolder">
                                            {{ translate('Read Instructions') }}
                                            <div class="ripple-animation" data-bs-toggle="modal"
                                                 data-bs-target="#carouselModal" type="button">
                                                <img src="{{asset('/public/assets/admin-module/img/info.svg')}}" class="svg"
                                                     alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-30">
                                    <form action="{{route('admin.configuration.set-third-party-config')}}" method="POST"
                                          id="firebase-form" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="discount-type">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="mb-30">
                                                        <div class="form-floating">
                                                            <input name="party_name" value="push_notification"
                                                                   class="hide-div">
                                                            <input type="text" class="form-control"
                                                                   name="server_key"
                                                                   placeholder="{{translate('server_key')}} *"
                                                                   required=""
                                                                   value="{{bs_data($data_values,'push_notification')['server_key']??''}}">
                                                            <label>{{translate('server_key')}} *</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn--primary demo_check">
                                                {{translate('update')}}
                                            </button>
                                        </div>
                                    </form>
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
                                                        <h5 class="modal-title text-center mb-3">Go to Firebase Console</h5>

                                                        <ul class="d-flex flex-column gap-2 px-3">
                                                            <li>Open your web browser and go to the Firebase Console ( <a
                                                                    href="https://console.firebase.google.com">https://console.firebase.google.com/</a>
                                                                ).
                                                            </li>
                                                            <li>Select the project for which you want to configure FCM from the Firebase
                                                                Console dashboard.
                                                            </li>
                                                            <li>If you don’t have any project before. Create one with the website name.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="d-flex flex-column align-items-center gap-2 fs-12">
                                                        <img width="80" class="mb-3"
                                                             src="{{asset('public/assets/admin-module/img/media/project-settings.png')}}"
                                                             alt="">
                                                        <h5 class="modal-title text-center mb-3">Navigate to Project Settings</h5>

                                                        <ul class="d-flex flex-column gap-2 px-3">
                                                            <li>In the left-hand menu, click on the <strong>"Settings"</strong> gear icon,
                                                                there you will vae a dropdown. and then select <strong>"Project
                                                                    settings"</strong> from the dropdown.
                                                            </li>
                                                            <li>In the Project settings page, click on the "Cloud Messaging" tab from the
                                                                top menu.
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="d-flex flex-column align-items-center gap-2 fs-12">
                                                        <img width="80" class="mb-3"
                                                             src="{{asset('public/assets/admin-module/img/media/cloud-message.png')}}"
                                                             alt="">
                                                        <h5 class="modal-title text-center mb-3">Cloud Messaging API</h5>

                                                        <ul class="d-flex flex-column gap-2 px-3">
                                                            <li>From Cloud Messaging Page there will be a section called Cloud Messaging
                                                                API.
                                                            </li>
                                                            <li>Click on the menu icon and enable the API</li>
                                                            <li>Refresh the Cloud Messaging Page - You will have your server key. Just copy
                                                                the code and paste here
                                                            </li>
                                                        </ul>

                                                        <div class="d-flex justify-content-center mt-2 w-100">
                                                            <button type="button" class="btn btn-primary w-100 max-w320"
                                                                    data-bs-dismiss="modal">Got It
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
                    @endif

                    @if($web_page == 'recaptcha')
                    <div class="tab-content">
                        <div class="tab-pane fade {{$web_page == 'recaptcha' ? 'show active' : ''}}" id="recaptcha">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">{{translate('recaptcha_setup')}}</h4>
                                </div>
                                <div class="card-body p-30">
                                    <form action="{{route('admin.configuration.set-third-party-config')}}" method="POST"
                                          id="recaptcha-form" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="discount-type">
                                            <div class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                                <div class="custom-radio">
                                                    <input type="radio" id="active" name="status"
                                                           value="1" {{$data_values->where('key_name','recaptcha')->first()->live_values['status']?'checked':''}}>
                                                    <label for="active">{{translate('active')}}</label>
                                                </div>
                                                <div class="custom-radio">
                                                    <input type="radio" id="inactive" name="status"
                                                           value="0" {{$data_values->where('key_name','recaptcha')->first()->live_values['status']?'':'checked'}}>
                                                    <label for="inactive">{{translate('inactive')}}</label>
                                                </div>
                                            </div>

                                            <br>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="mb-30">
                                                        <div class="form-floating">
                                                            <input name="party_name" value="recaptcha" class="hide-div">
                                                            <input type="text" class="form-control"
                                                                   name="site_key"
                                                                   placeholder="{{translate('site_key')}} *"
                                                                   required=""
                                                                   value="{{bs_data($data_values,'recaptcha')['site_key']??''}}">
                                                            <label>{{translate('site_key')}} *</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="mb-30">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control"
                                                                   name="secret_key"
                                                                   placeholder="{{translate('secret_key')}} *"
                                                                   required=""
                                                                   value="{{bs_data($data_values,'recaptcha')['secret_key']??''}}">
                                                            <label>{{translate('secret_key')}} *</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn--primary demo_check">
                                                {{translate('update')}}
                                            </button>
                                        </div>
                                    </form>

                                    <div class="mt-3">
                                        <h4 class="mb-3">{{translate('Instructions')}}</h4>
                                        <ol>
                                            <li>To get site key and secret keyGo to the Credentials page
                                                (<a href="https://developers.google.com/recaptcha/docs/v3" class="c1">Click
                                                    Here</a>)
                                            </li>
                                            <li>Add a Label (Ex: abc company)</li>
                                            <li>Select reCAPTCHA v2 as ReCAPTCHA Type</li>
                                            <li>Select Sub type: I'm not a robot Checkbox</li>
                                            <li>Add Domain (For ex: demo.6amtech.com)</li>
                                            <li>Check in “Accept the reCAPTCHA Terms of Service”</li>
                                            <li>Press Submit</li>
                                            <li>Copy Site Key and Secret Key, Paste in the input filed below and Save.
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @php($apple_login = (business_config('apple_login', 'third_party'))->live_values)

                    @if($web_page == 'apple_login')
                    <div class="tab-content">
                        <div class="tab-pane fade {{$web_page == 'apple_login' ? 'show active' : ''}}" id="apple_login">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">
                                        <img src="{{asset('public/assets/admin-module/img/media/apple.png')}}" alt="">
                                        {{translate('Apple_login')}}
                                    </h4>
                                </div>
                                <div class="card-body p-30">
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-30">
                                            <form action="{{route('admin.configuration.set-third-party-config')}}"
                                                  method="POST"
                                                  id="apple-login-form" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="discount-type">
                                                    <div class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                                        <input name="party_name" value="apple_login"
                                                               class="hide-div">
                                                        <div class="custom-radio">
                                                            <input type="radio" id="apple-login-active"
                                                                   name="status"
                                                                   value="1" {{$apple_login['status']?'checked':''}}>
                                                            <label
                                                                for="apple-login-active">{{translate('active')}}</label>
                                                        </div>
                                                        <div class="custom-radio">
                                                            <input type="radio" id="apple-login-inactive"
                                                                   name="status"
                                                                   value="0" {{$apple_login['status']?'':'checked'}}>
                                                            <label
                                                                for="apple-login-inactive">{{translate('inactive')}}</label>
                                                        </div>
                                                    </div>

                                                    <div class="form-floating mb-30 mt-30">
                                                        <input type="text" class="form-control" name="client_id"
                                                               value="{{env('APP_ENV')=='demo'?'':$apple_login['client_id']}}">
                                                        <label>{{translate('client_id')}} *</label>
                                                    </div>

                                                    <div class="form-floating mb-30 mt-30">
                                                        <input type="text" class="form-control" name="team_id"
                                                               value="{{env('APP_ENV')=='demo'?'':$apple_login['team_id']}}">
                                                        <label>{{translate('team_id')}} *</label>
                                                    </div>

                                                    <div class="form-floating mb-30 mt-30">
                                                        <input type="text" class="form-control" name="key_id"
                                                               value="{{env('APP_ENV')=='demo'?'':$apple_login['key_id']}}">
                                                        <label>{{translate('key_id')}} *</label>
                                                    </div>

                                                    <div class="form-floating mb-30 mt-30">
                                                        <input type="file" accept=".p8" class="form-control"
                                                               name="service_file"
                                                               value="{{ 'storage/app/public/apple-login/'.$apple_login['service_file'] }}">
                                                        <label>{{translate('service_file')}} {{ $apple_login['service_file']? translate('(Already Exists)'):'*' }}</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn--primary demo_check">
                                                        {{translate('update')}}
                                                    </button>
                                                </div>
                                            </form>
                                            <div class="mt-3">
                                                <h4 class="mb-3">{{translate('Instructions')}}</h4>
                                                <ol>
                                                    <li>{{translate('Go to Apple Developer page')}} (<a
                                                            href="https://developer.apple.com/account/resources/identifiers/list"
                                                            target="_blank">{{translate('click_here')}}</a>)
                                                    </li>
                                                    <li>{{translate('Here in top left corner you can see the')}}
                                                        <b>{{ translate('Team ID') }}</b> {{ translate('[Apple_Deveveloper_Account_Name - Team_ID]')}}
                                                    </li>
                                                    <li>{{translate('Click Plus icon -> select App IDs -> click on Continue')}}</li>
                                                    <li>{{translate('Put a description and also identifier (identifier that used for app) and this is the')}}
                                                        <b>{{ translate('Client ID') }}</b></li>
                                                    <li>{{translate('Click Continue and Download the file in device named AuthKey_ID.p8 (Store it safely and it is used for push notification)')}} </li>
                                                    <li>{{translate('Again click Plus icon -> select Service IDs -> click on Continue')}} </li>
                                                    <li>{{translate('Push a description and also identifier and Continue')}} </li>
                                                    <li>{{translate('Download the file in device named')}}
                                                        <b>{{ translate('AuthKey_KeyID.p8') }}</b> {{translate('[This is the Service Key ID file and also after AuthKey_ that is the Key ID]')}}
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($web_page == 'email_config')
                    <div class="tab-content">
                        <div class="tab-pane fade {{$web_page == 'email_config' ? 'show active' : ''}}" id="email_config">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">
                                        {{translate('Email Setup')}}
                                    </h4>
                                </div>
                                <div class="card-body p-30">
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-30">
                                            <form action="{{route('admin.configuration.set-email-config')}}" method="POST"
                                                  id="config-form" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="discount-type">
                                                    <div class="row">
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       name="mailer_name"
                                                                       placeholder="{{translate('mailer_name')}} *"
                                                                       value="{{bs_data($data_values,'email_config')['mailer_name']??''}}">
                                                                <label>{{translate('mailer_name')}} *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" name="host"
                                                                       placeholder="{{translate('host')}} *"
                                                                       value="{{bs_data($data_values,'email_config')['host']??''}}">
                                                                <label>{{translate('host')}} *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" name="driver"
                                                                       placeholder="{{translate('driver')}} *"
                                                                       value="{{bs_data($data_values,'email_config')['driver']??''}}">
                                                                <label>{{translate('driver')}} *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" name="port"
                                                                       placeholder="{{translate('port')}} *"
                                                                       value="{{bs_data($data_values,'email_config')['port']??''}}">
                                                                <label>{{translate('port')}} *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" name="user_name"
                                                                       placeholder="{{translate('user_name')}} *"
                                                                       value="{{bs_data($data_values,'email_config')['user_name']??''}}">
                                                                <label>{{translate('user_name')}} *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" name="email_id"
                                                                       placeholder="{{translate('email_id')}} *"
                                                                       value="{{bs_data($data_values,'email_config')['email_id']??''}}">
                                                                <label>{{translate('email_id')}} *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" name="encryption"
                                                                       placeholder="{{translate('encryption')}} *"
                                                                       value="{{bs_data($data_values,'email_config')['encryption']??''}}">
                                                                <label>{{translate('encryption')}} *</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-30">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" name="password"
                                                                       placeholder="{{translate('password')}} *"
                                                                       value="{{bs_data($data_values,'email_config')['password']??''}}">
                                                                <label>{{translate('password')}} *</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn--primary">
                                                        {{translate('update')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($web_page == 'sms_config')
                    <div class="tab-content">
                        <div class="tab-pane fade {{$web_page == 'sms_config' ? 'show active' : ''}}" id="sms_config">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">
                                        {{translate('Sms Setup')}}
                                    </h4>
                                </div>
                                <div class="card-body p-30">
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-30">
                                            @if($published_status == 1)
                                                <div class="col-md-12 mb-3">
                                                    <div class="card">
                                                        <div class="card-body d-flex justify-content-around">
                                                            <h4 style="color: #8c1515; padding-top: 10px">
                                                                <i class="tio-info-outined"></i>
                                                                Your current sms settings are disabled, because you have enabled
                                                                sms gateway addon, To visit your currently active sms gateway settings please follow
                                                                the link.</h4>

                                                            <a href="{{!empty($payment_url) ? $payment_url : ''}}" class="btn btn-outline-primary">{{translate('settings')}}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Tab Content -->
                                            <div class="row">
                                                @php($is_published = $published_status == 1 ? 'disabled' : '')
                                                @foreach($data_values as $key_value => $gateway)
                                                    <div class="col-12 col-md-6 mb-30">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="page-title">{{translate($gateway->key_name)}}</h4>
                                                            </div>
                                                            <div class="card-body p-30">
                                                                <form action="{{route('admin.configuration.sms-set')}}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="discount-type">
                                                                        <div class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                                                            <div class="custom-radio">
                                                                                <input type="radio" id="{{$gateway->key_name}}-active"
                                                                                       name="status"
                                                                                       value="1" {{$data_values->where('key_name',$gateway->key_name)->first()->live_values['status']?'checked':''}} {{$is_published}}>
                                                                                <label
                                                                                    for="{{$gateway->key_name}}-active">{{translate('active')}}</label>
                                                                            </div>
                                                                            <div class="custom-radio">
                                                                                <input type="radio" id="{{$gateway->key_name}}-inactive"
                                                                                       name="status"
                                                                                       value="0" {{$data_values->where('key_name',$gateway->key_name)->first()->live_values['status']?'':'checked'}} {{$is_published}}>
                                                                                <label
                                                                                    for="{{$gateway->key_name}}-inactive">{{translate('inactive')}}</label>
                                                                            </div>
                                                                        </div>

                                                                        <input name="gateway" value="{{$gateway->key_name}}" class="hide-div">
                                                                        <input name="mode" value="live" class="hide-div">

                                                                        @php($skip=['gateway','mode','status'])
                                                                        @foreach($data_values->where('key_name',$gateway->key_name)->first()->live_values as $key=>$value)
                                                                            @if(!in_array($key,$skip))
                                                                                <div class="form-floating mb-30 mt-30">
                                                                                    <input type="text" class="form-control"
                                                                                           name="{{$key}}"
                                                                                           placeholder="{{translate($key)}} *"
                                                                                           value="{{env('APP_ENV')=='demo'?'':$value}}" {{$is_published}}>
                                                                                    <label>{{translate($key)}} *</label>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="submit" class="btn btn--primary demo_check" {{$is_published}}>
                                                                            {{translate('update')}}
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($web_page == 'payment_config' && $type == 'digital_payment')
                    <div class="tab-content">
                        <div class="tab-pane fade {{$web_page == 'payment_config' && $type == 'digital_payment' ? 'show active' : ''}}" id="digital_payment">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="page-title">
                                        {{translate('Payment Gateway Configuration')}}
                                    </h4>
                                </div>
                                <div class="card-body p-30">
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-30">
                                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                                                <ul class="nav nav--tabs nav--tabs__style2" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link {{$type=='digital_payment'?'active':''}}"
                                                           href="{{url('admin/configuration/get-third-party-config')}}?type=digital_payment&web_page=payment_config">{{translate('Digital Payment Gateways')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link {{$type=='offline_payment'?'active':''}}"
                                                           href="{{url('admin/configuration/offline-payment/list')}}?type=offline_payment&web_page=payment_config">{{translate('Offline Payment')}}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            @if($published_status == 1)
                                                <div class="col-12 mb-3">
                                                    <div class="card">
                                                        <div class="card-body d-flex justify-content-around">
                                                            <h4 class="text-danger pt-2">
                                                                <i class="tio-info-outined"></i>
                                                                Your current payment settings are disabled, because you have enabled
                                                                payment gateway addon, To visit your currently active payment gateway settings please follow
                                                                the link.</h4>

                                                            <a href="{{!empty($payment_url) ? $payment_url : ''}}" class="btn btn-outline-primary">{{translate('settings')}}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Tab Content -->
                                            <div class="row">
                                                @php($is_published = $published_status == 1 ? 'disabled' : '')
                                                @foreach($data_values as $gateway)
                                                    <div class="col-12 col-md-6 mb-30">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="page-title">{{translate($gateway->key_name)}}</h4>
                                                            </div>
                                                            <div class="card-body p-30">
                                                                <form action="{{route('admin.configuration.payment-set')}}" method="POST"
                                                                      id="{{$gateway->key_name}}-form" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    @php($additional_data = $gateway['additional_data'] != null ? json_decode($gateway['additional_data']) : [])
                                                                    <div class="discount-type">
                                                                        <div class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                                                            <div class="custom-radio">
                                                                                <input type="radio" id="{{$gateway->key_name}}-active"
                                                                                       name="status"
                                                                                       value="1" {{$data_values->where('key_name',$gateway->key_name)->first()->live_values['status']?'checked':''}} {{$is_published}}>
                                                                                <label
                                                                                    for="{{$gateway->key_name}}-active">{{translate('active')}}</label>
                                                                            </div>
                                                                            <div class="custom-radio">
                                                                                <input type="radio" id="{{$gateway->key_name}}-inactive"
                                                                                       name="status"
                                                                                       value="0" {{$data_values->where('key_name',$gateway->key_name)->first()->live_values['status']?'':'checked'}} {{$is_published}}>
                                                                                <label
                                                                                    for="{{$gateway->key_name}}-inactive">{{translate('inactive')}}</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="payment--gateway-img justify-content-center d-flex align-items-center">
                                                                            <img style="max-width:100%; height:100px" id="{{$gateway->key_name}}-image-preview"
                                                                                 src="{{asset('storage/app/public/payment_modules/gateway_image')}}/{{$additional_data != null ? $additional_data->gateway_image : ''}}"
                                                                                 onerror="this.src='{{asset('public/assets/admin-module')}}/img/placeholder.png'"
                                                                                 alt="public">
                                                                        </div>

                                                                        <input name="gateway" value="{{$gateway->key_name}}" class="hide-div">

                                                                        @php($mode=$data_values->where('key_name',$gateway->key_name)->first()->live_values['mode'])
                                                                        <div class="form-floating mb-30 mt-30">
                                                                            <select class="js-select theme-input-style w-100" name="mode" {{$is_published}}>
                                                                                <option value="live" {{$mode=='live'?'selected':''}}>{{translate('live')}}</option>
                                                                                <option value="test" {{$mode=='test'?'selected':''}}>{{translate('test')}}</option>
                                                                            </select>
                                                                        </div>

                                                                        @php($skip=['gateway','mode','status'])
                                                                        @foreach($data_values->where('key_name',$gateway->key_name)->first()->live_values as $key=>$value)
                                                                            @if(!in_array($key,$skip))
                                                                                <div class="form-floating mb-30 mt-30">
                                                                                    <input type="text" class="form-control"
                                                                                           name="{{$key}}"
                                                                                           placeholder="{{translate($key)}} *"
                                                                                           value="{{env('APP_ENV')=='demo'?'':$value}}" {{$is_published}}>
                                                                                    <label>{{translate($key)}} *</label>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach

                                                                        @if($gateway['key_name'] == 'paystack')
                                                                            <div class="form-floating mb-30 mt-30">
                                                                                <input type="text" class="form-control"
                                                                                       placeholder="{{translate('Callback Url')}} *" readonly
                                                                                       value="{{env('APP_ENV')=='demo'?'': route('paystack.callback')}}" {{$is_published}}>
                                                                                <label>{{translate('Callback Url')}} *</label>
                                                                            </div>
                                                                        @endif

                                                                        <div class="form-floating" style="margin-bottom: 10px">
                                                                            <input type="text" class="form-control" id="{{$gateway->key_name}}-title"
                                                                                   name="gateway_title"
                                                                                   placeholder="{{translate('payment_gateway_title')}}"
                                                                                   value="{{$additional_data != null ? $additional_data->gateway_title : ''}}" {{$is_published}}>
                                                                            <label for="{{$gateway->key_name}}-title"
                                                                                   class="form-label">{{translate('payment_gateway_title')}}</label>
                                                                        </div>

                                                                        <div class="form-floating mb-3">
                                                                            <input type="file" class="form-control" name="gateway_image" accept=".jpg, .png, .jpeg|image/*" id="{{$gateway->key_name}}-image">
                                                                            {{-- <label for="{{$gateway->key_name}}-image"
                                                                                class="form-label">{{translate('logo')}}</label> --}}
                                                                        </div>

                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="submit" class="btn btn--primary demo_check" {{$is_published}}>
                                                                            {{translate('update')}}
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($web_page == 'payment_config' && $type == 'offline_payment')
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page == 'payment_config' && $type == 'offline_payment' ? 'show active' : ''}}" id="offline_payment">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="page-title">
                                            {{translate('Payment Config')}}
                                        </h4>
                                    </div>
                                    <div class="card-body p-30">
                                        <div class="row">
                                            <div class="col-12 col-md-12 mb-30">
                                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                                                    <ul class="nav nav--tabs nav--tabs__style2" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link {{$type=='digital_payment'?'active':''}}"
                                                               href="{{url()->current()}}?type=digital_payment&web_page=payment_config">{{translate('Digital Payment Gateways')}}</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link {{$type=='offline_payment'?'active':''}}"
                                                               href="{{url()->current()}}?type=offline_payment&web_page=payment_config">{{translate('Offline Payment')}}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @if($published_status == 1)
                                                    <div class="col-12 mb-3">
                                                        <div class="card">
                                                            <div class="card-body d-flex justify-content-around">
                                                                <h4 class="text-danger pt-2">
                                                                    <i class="tio-info-outined"></i>
                                                                    Your current payment settings are disabled, because you have enabled
                                                                    payment gateway addon, To visit your currently active payment gateway settings please follow
                                                                    the link.</h4>

                                                                <a href="{{!empty($payment_url) ? $payment_url : ''}}" class="btn btn-outline-primary">{{translate('settings')}}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Tab Content -->
                                                <div class="row">
                                                    @php($is_published = $published_status == 1 ? 'disabled' : '')
                                                    @foreach($data_values as $gateway)
                                                        <div class="col-12 col-md-6 mb-30">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h4 class="page-title">{{translate($gateway->key_name)}}</h4>
                                                                </div>
                                                                <div class="card-body p-30">
                                                                    <form action="{{route('admin.configuration.payment-set')}}" method="POST"
                                                                          id="{{$gateway->key_name}}-form" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        @php($additional_data = $gateway['additional_data'] != null ? json_decode($gateway['additional_data']) : [])
                                                                        <div class="discount-type">
                                                                            <div class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                                                                <div class="custom-radio">
                                                                                    <input type="radio" id="{{$gateway->key_name}}-active"
                                                                                           name="status"
                                                                                           value="1" {{$data_values->where('key_name',$gateway->key_name)->first()->live_values['status']?'checked':''}} {{$is_published}}>
                                                                                    <label
                                                                                        for="{{$gateway->key_name}}-active">{{translate('active')}}</label>
                                                                                </div>
                                                                                <div class="custom-radio">
                                                                                    <input type="radio" id="{{$gateway->key_name}}-inactive"
                                                                                           name="status"
                                                                                           value="0" {{$data_values->where('key_name',$gateway->key_name)->first()->live_values['status']?'':'checked'}} {{$is_published}}>
                                                                                    <label
                                                                                        for="{{$gateway->key_name}}-inactive">{{translate('inactive')}}</label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="payment--gateway-img justify-content-center d-flex align-items-center">
                                                                                <img style="max-width:100%; height:100px" id="{{$gateway->key_name}}-image-preview"
                                                                                     src="{{asset('storage/app/public/payment_modules/gateway_image')}}/{{$additional_data != null ? $additional_data->gateway_image : ''}}"
                                                                                     onerror="this.src='{{asset('public/assets/admin-module')}}/img/placeholder.png'"
                                                                                     alt="public">
                                                                            </div>

                                                                            <input name="gateway" value="{{$gateway->key_name}}" class="hide-div">

                                                                            @php($mode=$data_values->where('key_name',$gateway->key_name)->first()->live_values['mode'])
                                                                            <div class="form-floating mb-30 mt-30">
                                                                                <select class="js-select theme-input-style w-100" name="mode" {{$is_published}}>
                                                                                    <option value="live" {{$mode=='live'?'selected':''}}>{{translate('live')}}</option>
                                                                                    <option value="test" {{$mode=='test'?'selected':''}}>{{translate('test')}}</option>
                                                                                </select>
                                                                            </div>

                                                                            @php($skip=['gateway','mode','status'])
                                                                            @foreach($data_values->where('key_name',$gateway->key_name)->first()->live_values as $key=>$value)
                                                                                @if(!in_array($key,$skip))
                                                                                    <div class="form-floating mb-30 mt-30">
                                                                                        <input type="text" class="form-control"
                                                                                               name="{{$key}}"
                                                                                               placeholder="{{translate($key)}} *"
                                                                                               value="{{env('APP_ENV')=='demo'?'':$value}}" {{$is_published}}>
                                                                                        <label>{{translate($key)}} *</label>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach

                                                                            <div class="form-floating" style="margin-bottom: 10px">
                                                                                <input type="text" class="form-control" id="{{$gateway->key_name}}-title"
                                                                                       name="gateway_title"
                                                                                       placeholder="{{translate('payment_gateway_title')}}"
                                                                                       value="{{$additional_data != null ? $additional_data->gateway_title : ''}}" {{$is_published}}>
                                                                                <label for="{{$gateway->key_name}}-title"
                                                                                       class="form-label">{{translate('payment_gateway_title')}}</label>
                                                                            </div>

                                                                            <div class="form-floating mb-3">
                                                                                <input type="file" class="form-control" name="gateway_image" accept=".jpg, .png, .jpeg|image/*" id="{{$gateway->key_name}}-image">
                                                                                {{-- <label for="{{$gateway->key_name}}-image"
                                                                                    class="form-label">{{translate('logo')}}</label> --}}
                                                                            </div>

                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit" class="btn btn--primary demo_check" {{$is_published}}>
                                                                                {{translate('update')}}
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page == 'social_login')
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page == 'social_login' ? 'show active' : ''}}" id="social_login">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="page-title">
                                            {{translate('Social Login Setup')}}
                                        </h4>
                                    </div>
                                    <div class="card-body p-30">
                                        <div class="row">
                                            <div class="col-12 col-md-12 mb-30">
                                                <!-- Tab Content -->
                                                <div class="tab-content">
                                                    <div class="tab-pane fade active show" id="social-login">
                                                        <div class="card">
                                                            @php($mediums = ['google', 'facebook'])
                                                            <div class="card-body p-30">
                                                                <div class="table-responsive">
                                                                    <table id="example" class="table align-middle">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>{{translate('Medium')}}</th>
                                                                            <th>{{translate('Status')}}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($mediums as $medium)
                                                                            @php($config = $social_login_configs->where('key_name', $medium.'_social_login')->first())
                                                                            <tr>
                                                                                <td class="text-capitalize">{{translate($medium)}}</td>
                                                                                <td>
                                                                                    <label class="switcher">
                                                                                        <input class="switcher_input"
                                                                                               onclick="update_social_media_status('{{$medium}}_social_login', $(this).is(':checked')===true?1:0)"
                                                                                               type="checkbox" {{isset($config) && $config->live_values ? 'checked' : ''}}>
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
                                                    </div>
                                                </div>
                                                <!-- End Tab Content -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($web_page == 'app_settings')
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page == 'app_settings' ? 'show active' : ''}}" id="app_settings">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="page-title">
                                            {{translate('Customer App Configuration')}}
                                        </h4>
                                    </div>
                                    <div class="card-body p-30">
                                        <div class="row">
                                            <div class="col-12 col-md-12 mb-30">
                                                <!-- Nav Tabs -->
                                                <div class="mb-3">
                                                    <ul class="nav nav--tabs nav--tabs__style2">
                                                        <li class="nav-item">
                                                            <button data-bs-toggle="tab" data-bs-target="#customer" class="nav-link active">
                                                                {{translate('Customer')}}
                                                            </button>
                                                        </li>
                                                        <li class="nav-item">
                                                            <button data-bs-toggle="tab" data-bs-target="#provider"
                                                                    class="nav-link">
                                                                {{translate('Provider')}}
                                                            </button>
                                                        </li>
                                                        <li class="nav-item">
                                                            <button data-bs-toggle="tab" data-bs-target="#serviceman" class="nav-link">
                                                                {{translate('Serviceman')}}
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- End Nav Tabs -->

                                                <!-- Tab Content -->
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="customer">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="page-title">{{translate('Customer_app_configuration')}}</h4>
                                                            </div>
                                                            <div class="card-body p-30">
                                                                <div class="alert alert-danger mb-30">
                                                                    <p>
                                                                        <i class="material-icons">info</i>
                                                                        {{translate('If there is any update available in the admin panel and for that the previous app will not work. You can force the customer from here by providing the minimum version for force update. That means if a customer has an app below this version the customers must need to update the app first. If you do not need a force update just insert here zero (0) and ignore it.')}}
                                                                    </p>
                                                                </div>
                                                                <form action="{{route('admin.configuration.set-app-settings')}}" method="POST"
                                                                      id="google-map-update-form" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="discount-type">
                                                                        <div class="row">
                                                                            <div class="col-md-6 col-12">
                                                                                <div class="mb-30">
                                                                                    <div class="form-floating">
                                                                                        <input type="text" class="form-control"
                                                                                               name="min_version_for_android"
                                                                                               placeholder="{{translate('min_version_for_android')}} *"
                                                                                               required=""
                                                                                               value="{{$customer_data_values->min_version_for_android??''}}">
                                                                                        <label>{{translate('min_version_for_android')}} *</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 col-12">
                                                                                <div class="mb-30">
                                                                                    <div class="form-floating">
                                                                                        <input type="text" class="form-control"
                                                                                               name="min_version_for_ios"
                                                                                               placeholder="{{translate('min_version_for_IOS')}} *"
                                                                                               required=""
                                                                                               value="{{$customer_data_values->min_version_for_ios??''}}">
                                                                                        <label>{{translate('min_version_for_IOS')}} *</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <input name="app_type" value="customer" class="hide-div">
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="submit" class="btn btn--primary demo_check">
                                                                            {{translate('update')}}
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-content">
                                                    <div class="tab-pane fade" id="provider">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="page-title">{{translate('Provider_app_configuration')}}</h4>
                                                            </div>
                                                            <div class="card-body p-30">
                                                                <div class="alert alert-danger mb-30">
                                                                    <p>
                                                                        <i class="material-icons">info</i>
                                                                        {{translate('If there is any update available in the admin panel and for that the previous app will not work. You can force the user from here by providing the minimum version for force update. That means if a user has an app below this version the users must need to update the app first. If you do not need a force update just insert here zero (0) and ignore it.')}}
                                                                    </p>
                                                                </div>
                                                                <form action="{{route('admin.configuration.set-app-settings')}}" method="POST"
                                                                      id="google-map-update-form" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="discount-type">
                                                                        <div class="row">
                                                                            <div class="col-md-6 col-12">
                                                                                <div class="mb-30">
                                                                                    <div class="form-floating">
                                                                                        <input type="text" class="form-control"
                                                                                               name="min_version_for_android"
                                                                                               placeholder="{{translate('min_version_for_android')}} *"
                                                                                               required=""
                                                                                               value="{{$provider_data_values->min_version_for_android??''}}">
                                                                                        <label>{{translate('min_version_for_android')}} *</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 col-12">
                                                                                <div class="mb-30">
                                                                                    <div class="form-floating">
                                                                                        <input type="text" class="form-control"
                                                                                               name="min_version_for_ios"
                                                                                               placeholder="{{translate('min_version_for_IOS')}} *"
                                                                                               required=""
                                                                                               value="{{$provider_data_values->min_version_for_ios??''}}">
                                                                                        <label>{{translate('min_version_for_IOS')}} *</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <input name="app_type" value="provider" class="hide-div">
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="submit" class="btn btn--primary demo_check">
                                                                            {{translate('update')}}
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-content">
                                                    <div class="tab-pane fade" id="serviceman">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="page-title">{{translate('Serviceman_app_configuration')}}</h4>
                                                            </div>
                                                            <div class="card-body p-30">
                                                                <div class="alert alert-danger mb-30">
                                                                    <p>
                                                                        <i class="material-icons">info</i>
                                                                        {{translate('If there is any update available in the admin panel and for that the previous app will not work. You can force the user from here by providing the minimum version for force update. That means if a user has an app below this version the users must need to update the app first. If you do not need a force update just insert here zero (0) and ignore it.')}}
                                                                    </p>
                                                                </div>
                                                                <form action="{{route('admin.configuration.set-app-settings')}}" method="POST"
                                                                      id="google-map-update-form" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="discount-type">
                                                                        <div class="row">
                                                                            <div class="col-md-6 col-12">
                                                                                <div class="mb-30">
                                                                                    <div class="form-floating">
                                                                                        <input type="text" class="form-control"
                                                                                               name="min_version_for_android"
                                                                                               placeholder="{{translate('min_version_for_android')}} *"
                                                                                               required=""
                                                                                               value="{{$serviceman_data_values->min_version_for_android??''}}">
                                                                                        <label>{{translate('min_version_for_android')}} *</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 col-12">
                                                                                <div class="mb-30">
                                                                                    <div class="form-floating">
                                                                                        <input type="text" class="form-control"
                                                                                               name="min_version_for_ios"
                                                                                               placeholder="{{translate('min_version_for_IOS')}} *"
                                                                                               required=""
                                                                                               value="{{$serviceman_data_values->min_version_for_ios??''}}">
                                                                                        <label>{{translate('min_version_for_IOS')}} *</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <input name="app_type" value="serviceman" class="hide-div">
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="submit" class="btn btn--primary demo_check">
                                                                            {{translate('update')}}
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Tab Content -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

{{--                    <div class="tab-content">--}}
{{--                        <div class="tab-pane fade" id="email_config">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header">--}}
{{--                                    <h4 class="page-title">--}}
{{--                                        <img src="{{asset('public/assets/admin-module/img/media/apple.png')}}" alt="">--}}
{{--                                        {{translate('Email Setup')}}--}}
{{--                                    </h4>--}}
{{--                                </div>--}}
{{--                                <div class="card-body p-30">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-12 col-md-12 mb-30">--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!-- End Tab Content -->

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('#google-map').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(document.getElementById("google-map-update-form"));
            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.configuration.set-third-party-config')}}",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                success: function (response) {
                    console.log(response)
                    toastr.success('{{translate('successfully_updated')}}')
                },
                error: function () {

                }
            });
        });

        $('#firebase-form').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(document.getElementById("firebase-form"));
            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.configuration.set-third-party-config')}}",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                success: function (response) {
                    console.log(response)
                    toastr.success('{{translate('successfully_updated')}}')
                },
                error: function () {

                }
            });
        });

        $('#recaptcha-form').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(document.getElementById("recaptcha-form"));
            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.configuration.set-third-party-config')}}",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                success: function (response) {
                    console.log(response)
                    toastr.success('{{translate('successfully_updated')}}')
                },
                error: function () {

                }
            });
        });

        $('#apple-login-form').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(document.getElementById("apple-login-form"));
            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.configuration.set-third-party-config')}}",
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                success: function (response) {
                    console.log(response)
                    toastr.success('{{translate('successfully_updated')}}')
                },
                error: function () {

                }
            });
        });

        $('#config-form').on('submit', function (event) {
            event.preventDefault();
            if ('{{env('APP_ENV')=='demo'}}') {
                demo_mode()
            } else {
                var formData = new FormData(document.getElementById("config-form"));
                // Set header if need any otherwise remove setup part
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('admin.configuration.set-email-config')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'post',
                    success: function (response) {
                        console.log(response)
                        if (response.response_code === 'default_400') {
                            toastr.error('{{translate('all_fields_are_required')}}')
                        } else {
                            toastr.success('{{translate('successfully_updated')}}')
                        }
                    },
                    error: function () {

                    }
                });
            }
        });

        function update_social_media_status(key_name, value) {
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
                        url: "{{route('admin.configuration.social-login-config-set')}}",
                        data: {
                            key: key_name,
                            value: value,
                        },
                        type: 'put',
                        success: function (response) {
                            toastr.success('{{translate('successfully_updated')}}')
                        },
                        error: function () {

                        }
                    });
                }
            })
        }

    </script>

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
@endpush
