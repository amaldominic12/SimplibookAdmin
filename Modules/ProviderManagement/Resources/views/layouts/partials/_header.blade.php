<header class="header fixed-top">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col-2">
                <!-- Header Menu -->
                <div class="header-toogle-menu">
                    <button class="toggle-menu-button aside-toggle border-0 bg-transparent p-0 dark-color">
                        <span class="material-icons">menu</span>
                    </button>
                </div>
                <!-- End Header Menu -->
            </div>
            <div class="col-10">
                <!-- Header Right -->
                <div class="header-right">
                    <ul class="nav justify-content-end align-items-center gap-30">
                        <li>
                            <button class="toggle-search-btn px-0 d-sm-none">
                                <span class="material-icons">search</span>
                            </button>

                            <!-- Header Search -->
                            <form action="#" class="search-form">
                                <div class="input-group position-relative search-form__input_group">
                                    <span class="search-form__icon">
                                        <span class="material-icons">search</span>
                                    </span>
                                    <input type="search" class="theme-input-style search-form__input"
                                           id="search-form__input" placeholder="{{translate('Search_Here')}}"
                                           autocomplete="off"/>
                                    <div class="dropdown-menu rounded">
                                        <div class="show-search-result">
                                            @foreach(get_routes('provider') as $route)
                                                <a href="{{url('/')}}/{{$route}}"
                                                   class="dropdown-item-text title-color hover-color-c2 text-capitalize">
                                                    {{str_replace('provider','',implode(' ',explode('/',$route)))}}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- End Header Search -->
                        </li>
                        <li class="nav-item max-sm-m-0">
                            <div class="hs-unfold">
                                <div>
                                    @php( $local = session()->has('provider_local')?session('provider_local'):'en')
                                    @php($lang = Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first())
                                    @if ($lang)
                                        <div class="topbar-text dropdown d-flex">
                                            <a class="topbar-link dropdown-toggle d-flex align-items-center title-color gap-1 text-uppercase"
                                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                @foreach ($lang?->live_values as $data)
                                                    @if($data['code']==$local)
                                                        <span class="material-icons">language</span>
                                                        {{$data['code']}}
                                                    @endif
                                                @endforeach
                                            </a>
                                            <ul class="dropdown-menu lang-menu">
                                                @foreach($lang['live_values'] as $key =>$data)
                                                    @if($data['status']==1)
                                                        <li>
                                                            <a class="dropdown-item py-1"
                                                               href="{{route('provider.lang',[$data['code']])}}">
                                                                <span class="text-capitalize">{{$data['code']}}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </li>
                        <li>
                            <!-- Header Messages -->
                            <div class="messages">
                                <a href="{{route('provider.chat.index')}}" class="header-icon count-btn">
                                    <span class="material-icons">sms</span>
                                    <span class="count" id="message_count">0</span>
                                </a>
                            </div>
                            <!-- End Main Header Messages -->
                        </li>
                        <li>
                            <!-- Notification -->
                            <div class="notification">
                                <a href="#" onclick="update_notification()"
                                   class="header-icon count-btn notification-icon" data-bs-toggle="dropdown">
                                    <span class="material-icons">notifications</span>
                                    <span class="count" id="notification_count">0</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="show-notification-list" id="show-notification-list"></div>
                                </div>
                            </div>
                            <!-- End Notification -->
                        </li>
                        <li>
                            <!-- User -->
                            <div class="user mt-n1">
                                <a href="#" class="header-icon user-icon" data-bs-toggle="dropdown">
                                    <img width="30" height="30"
                                         src="{{asset('storage/app/public/provider/logo')}}/{{ auth()->user()->provider->logo }}"
                                         onerror="this.src='{{asset('public/assets/provider-module')}}/img/user2x.png'"
                                         class="rounded-circle" alt="">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{route('provider.profile_update')}}"
                                       class="dropdown-item-text media gap-3 align-items-center">
                                        <div class="avatar">
                                            <img class="avatar-img rounded-circle" width="50" height="50"
                                                 src="{{asset('storage/app/public/provider/logo')}}/{{ auth()->user()->provider->logo }}"
                                                 onerror="this.src='{{asset('public/assets/provider-module')}}/img/user2x.png'"
                                                 alt="">
                                        </div>
                                        <div class="media-body ">
                                            <h5 class="card-title">{{ Str::limit(auth()->user()->first_name, 20) }}</h5>
                                            <span class="card-text">{{ Str::limit(auth()->user()->email, 20) }}</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="{{route('provider.profile_update')}}">
                                        <span class="text-truncate" title="Settings">{{translate('Settings')}}</span>
                                    </a>
                                    <a class="dropdown-item" href="{{route('provider.auth.logout')}}">
                                        <span class="text-truncate" title="Sign Out">{{translate('Sign_Out')}}</span>
                                    </a>
                                    <?php
                                        $provider_self_delete = business_config('provider_self_delete', 'provider_config')->live_values ?? 0;
                                    ?>
                                    @if($provider_self_delete)
                                        <button class="dropdown-item" @if(env('APP_ENV')!='demo')
                                            onclick="form_alert('delete-{{auth()->user()->id}}','{{translate('want_to_delete_your_account')}}?')"
                                                @endif>
                                        <span class="text-truncate"
                                              title="delete account">{{translate('Delete Account')}}</span>
                                        </button>
                                        <form
                                                action="{{route('provider.delete_account',[auth()->user()->id])}}"
                                                method="post" id="delete-{{auth()->user()->id}}"
                                                class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <!-- End User -->
                        </li>
                    </ul>
                </div>
                <!-- End Header Right -->
            </div>
        </div>
    </div>
</header>
