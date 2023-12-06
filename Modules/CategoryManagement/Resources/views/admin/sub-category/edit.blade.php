@extends('adminmodule::layouts.master')

@section('title',translate('sub_category_update'))

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
                        <h2 class="page-title">{{translate('sub_category_update')}}</h2>
                    </div>

                    <!-- Category Setup -->
                    <div class="card category-setup mb-30">
                        <div class="card-body p-30">
                            <form action="{{route('admin.sub-category.update',[$sub_category->id])}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('put')
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
                                <div class="row">
                                    <div class="col-lg-8 mb-5 mb-lg-0">
                                        <div class="d-flex flex-column">
                                            <select class="js-select theme-input-style w-100" name="parent_id">
                                                <option value="0" selected disabled>
                                                    {{translate('Select_Category_Name')}}
                                                </option>
                                                @foreach($main_categories as $item)
                                                    <option
                                                        value="{{$item['id']}}" {{$sub_category->parent_id==$item->id?'selected':''}}>
                                                        {{$item->name}}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @if($language)
                                                <div class="lang-form" id="default-form">
                                                    <div class="form-floating mb-30 mt-30">
                                                        <input type="text" name="name[]" class="form-control"
                                                               oninvalid="document.getElementById('en-link').click()"
                                                               placeholder="{{translate('sub_category_name')}}"
                                                               value="{{$sub_category?->getRawOriginal('name')}}">
                                                        <label>{{translate('sub_category_name')}}
                                                            ({{ translate('default') }})</label>
                                                    </div>

                                                    <div class="form-floating mb-30">
                                                <textarea type="text" name="short_description[]" class="form-control"
                                                >{{$sub_category?->getRawOriginal('description')}}</textarea>
                                                        <label>{{translate('short_description')}}
                                                            ({{ translate('default') }})</label>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="lang[]" value="default">
                                                @foreach ($language?->live_values as $lang)
                                                        <?php
                                                        if (count($sub_category['translations'])) {
                                                            $translate = [];
                                                            foreach ($sub_category['translations'] as $t) {
                                                                if ($t->locale == $lang['code'] && $t->key == "name") {
                                                                    $translate[$lang['code']]['name'] = $t->value;
                                                                }

                                                                if ($t->locale == $lang['code'] && $t->key == "description") {
                                                                    $translate[$lang['code']]['description'] = $t->value;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    <div class="lang-form d-none" id="{{ $lang['code'] }}-form">
                                                        <div class="form-floating mb-30 mt-30">
                                                            <input type="text" name="name[]" class="form-control"
                                                                   oninvalid="document.getElementById('en-link').click()"
                                                                   placeholder="{{translate('sub_category_name')}} "
                                                                   value="{{$translate[$lang['code']]['name']??''}}"
                                                                   {{$lang['status'] == '1' ? 'required':''}}
                                                                   @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                                            <label>{{translate('sub_category_name')}}
                                                                ({{ strtoupper($lang['code']) }})</label>
                                                        </div>

                                                        <div class="form-floating mb-30">
                                                            <textarea type="text" name="short_description[]"
                                                                      class="form-control"
                                                                      {{$lang['status'] == '1' ? 'required':''}}
                                                                      @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>{{$translate[$lang['code']]['description']??''}}</textarea>
                                                            <label>{{translate('short_description')}}
                                                                ({{ strtoupper($lang['code']) }})</label>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="{{$lang['code']}}">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="form-floating mb-30 mt-30 lang-form">
                                                    <input type="text" name="name[]" class="form-control"
                                                           value="{{$sub_category->name}}"
                                                           placeholder="{{translate('sub_category_name')}}" required>
                                                    <label>{{translate('sub_category_name')}}
                                                        ({{ translate('default') }})</label>
                                                </div>

                                                <div class="form-floating mb-30">
                                                <textarea type="text" name="short_description[]" class="form-control"
                                                          required>{{$sub_category->description}}</textarea>
                                                    <label>{{translate('short_description')}}
                                                    </label>
                                                </div>

                                                <input type="hidden" name="lang[]" value="default">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="d-flex  gap-3 gap-xl-5">
                                            <p class="opacity-75 max-w220">{{translate('image_format_-_jpg,_png,_jpeg,_gif_image
                                                size_-_
                                                maximum_size_2_MB_Image_Ratio_-_1:1')}}</p>
                                            <div>
                                                <div class="upload-file">
                                                    <input type="file" class="upload-file__input" name="image">
                                                    <div class="upload-file__img">
                                                        <img
                                                            src="{{asset('storage/app/public/category')}}/{{$sub_category->image}}"
                                                            onerror="this.src='{{asset('public/assets/admin-module')}}/img/media/upload-file.png'"
                                                            alt="">
                                                    </div>
                                                    <span class="upload-file__edit">
                                                        <span class="material-icons">edit</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-20 mt-30">
                                            <button class="btn btn--secondary"
                                                    type="reset">{{translate('reset')}}</button>
                                            <button class="btn btn--primary" type="submit">{{translate('update')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Category Setup -->
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
    <script>

        $(".lang_link").on('click', function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang-form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');

            if (lang == '{{$default_lang}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>
    <script src="{{asset('public/assets/admin-module')}}/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/admin-module')}}/plugins/dataTables/dataTables.select.min.js"></script>
@endpush
