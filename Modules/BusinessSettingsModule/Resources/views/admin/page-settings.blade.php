@extends('adminmodule::layouts.master')

@section('title',translate('page_setup'))

@push('css_or_js')

@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title">{{translate('page_setup')}}</h2>
                    </div>

                    <!-- Nav Tabs -->
                    <div class="mb-3">
                        <ul class="nav nav--tabs nav--tabs__style2">
                            @foreach($data_values as $page_data)
                                <li class="nav-item">
                                    <a href="{{url()->current()}}?web_page={{$page_data->key}}"
                                       class="nav-link {{$web_page==$page_data->key?'active':''}}">
                                        {{translate($page_data->key)}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- End Nav Tabs -->

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

                    <!-- Tab Content -->
                    @foreach($data_values as $page_data)
                        <div class="tab-content">
                            <div class="tab-pane fade {{$web_page==$page_data->key?'active show':''}}">
                                <div class="card">
                                    <form action="{{route('admin.business-settings.set-pages-setup')}}" method="POST">
                                        @csrf
                                        <div class="card-header" style="display: flex; justify-content: space-between">
                                            <h4 class="page-title">{{translate($page_data->key)}}</h4>
                                            @if(!in_array($page_data->key,['about_us','privacy_policy', 'terms_and_conditions']))
                                                <label class="switcher">
                                                    <input class="switcher_input"
                                                           onclick="$(this).submit()"
                                                           type="checkbox"
                                                           name="is_active"
                                                           {{$page_data->is_active?'checked':''}} value="1">
                                                    <span class="switcher_control"></span>
                                                </label>
                                            @else
                                                <input name="is_active" value="1" class="hide-div">
                                            @endif
                                        </div>
                                        <div class="card-body p-30">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if ($language)
                                                        <div class="mb-30 dark-support lang-form default-form">
                                                            <input name="page_name" value="{{$page_data->key}}"
                                                                   class="hide-div">
                                                            <textarea class="ckeditor" required
                                                                      name="page_content[]">{!! $page_data?->getRawOriginal('value') !!}</textarea>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="default">
                                                        @foreach ($language?->live_values ?? [] as $lang)
                                                                <?php
                                                                if (count($page_data['translations'])) {
                                                                    $translate = [];
                                                                    foreach ($page_data['translations'] as $t) {
                                                                        if ($t->locale == $lang['code'] && $t->key == $page_data->key) {
                                                                            $translate[$lang['code']][$page_data->key] = $t->value;
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            <div
                                                                class="form-floating mb-30 d-none lang-form {{$lang['code']}}-form"
                                                            >
                                                               <textarea class="ckeditor"
                                                                         name="page_content[]"
                                                                         {{$lang['status'] == '1' ? 'required':''}}
                                                                         @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                                   {!! $translate[$lang['code']][$page_data->key] ?? '' !!}
                                                               </textarea>
                                                            </div>
                                                            <input type="hidden" name="lang[]"
                                                                   value="{{$lang['code']}}">
                                                        @endforeach
                                                    @else
                                                        <div class="mb-30 dark-support lang-form default-form">
                                                            <input name="page_name" value="{{$page_data->key}}"
                                                                   class="hide-div">
                                                            <textarea class="ckeditor"
                                                                      name="page_content[]">{!! $page_data?->getRawOriginal('live_values') !!}</textarea>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="default">
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn--primary demo_check">
                                                        {{translate('update')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- End Tab Content -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    {{--<script src="{{asset('public/assets/ckeditor/ckeditor.js')}}"></script>--}}
    <script src="{{asset('public/assets/ckeditor/jquery.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('textarea.ckeditor').each(function () {
                CKEDITOR.replace($(this).attr('id'));
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
