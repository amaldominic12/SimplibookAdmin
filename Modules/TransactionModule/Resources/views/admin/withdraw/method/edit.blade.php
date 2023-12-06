@extends('adminmodule::layouts.master')

@section('title',translate('withdrawal_method'))

@push('css_or_js')

@endpush

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3 mb-3">
                        <h2 class="page-title">{{translate('Withdrawal_Methods')}}</h2>
                        <button class="btn btn--primary" id="add-more-field">
                            <span class="material-icons">add</span> {{translate('Add_fields')}}
                        </button>
                    </div>

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

                    <div class="card">
                        <form action="{{route('admin.withdraw.method.update')}}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="{{$withdrawal_method['id']}}" name="id">
                            <div class=" p-30">
                                @if ($language)
                                    <div class="form-floating mb-30 lang-form" id="default-form">
                                        <input type="text" name="method_name[]" class="form-control"
                                               placeholder="{{translate('method_name')}}"
                                               value="{{$withdrawal_method?->getRawOriginal('method_name')}}">
                                        <label>{{translate('method_name')}} ({{ translate('default') }})</label>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    @foreach ($language?->live_values as $lang)
                                            <?php
                                            if (count($withdrawal_method['translations'])) {
                                                $translate = [];
                                                foreach ($withdrawal_method['translations'] as $t) {
                                                    if ($t->locale == $lang['code'] && $t->key == "method_name") {
                                                        $translate[$lang['code']]['method_name'] = $t->value;
                                                    }
                                                }
                                            }
                                            ?>
                                        <div class="form-floating mb-30 d-none lang-form" id="{{$lang['code']}}-form">
                                            <input type="text" name="method_name[]" class="form-control"
                                                   placeholder="{{translate('method_name')}}"
                                                   {{$lang['status'] == '1' ? 'required':''}}
                                                   value="{{$translate[$lang['code']]['method_name']??''}}"
                                                   @if($lang['status'] == '1') oninvalid="document.getElementById('{{$lang['code']}}-link').click()" @endif>
                                            <label>{{translate('method_name')}} ({{strtoupper($lang['code'])}})</label>
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{$lang['code']}}">
                                    @endforeach
                                @else
                                    <div class="form-floating mb-30">
                                        <input type="text" name="method_name[]" class="form-control"
                                               placeholder="{{translate('method_name')}}" value="{{$withdrawal_method['method_name']}}" required>
                                        <label>{{translate('method_name')}}</label>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                @endif

                                @if($withdrawal_method['method_fields'][0])
                                @php($field = $withdrawal_method['method_fields'][0])
                                <div class="card card-body mb-30">
                                    <div class="row gy-4 align-items-center">
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating">
                                                <select class="form-control" name="field_type[]" required>
                                                    <option value="string" {{$field=='string'?'selected':''}}>{{translate('String')}}</option>
                                                    <option value="number" {{$field=='number'?'selected':''}}>{{translate('Number')}}</option>
                                                    <option value="date" {{$field=='date'?'selected':''}}>{{translate('Date')}}</option>
                                                    <option value="password" {{$field=='password'?'selected':''}}>{{translate('Password')}}</option>
                                                    <option value="email" {{$field=='email'?'selected':''}}>{{translate('Email')}}</option>
                                                    <option value="phone" {{$field=='phone'?'selected':''}}>{{translate('Phone')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="field_name[]"
                                                       placeholder="Select field name"
                                                       value="{{$field['input_name']??''}}"
                                                       required>
                                                <label>{{translate('field_name')}} *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="placeholder_text[]"
                                                       placeholder="Select placeholder text"
                                                       value="{{$field['placeholder']??''}}"
                                                       required>
                                                <label>{{translate('placeholder_text')}} *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                       name="is_required[0]" id="flexCheckDefault"
                                                       {{$field['is_required'] ? 'checked' : ''}}>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    {{translate('This_field_required')}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- HERE CUSTOM FIELDS WILL BE ADDED -->
                                <div id="custom-field-section">
                                    @foreach($withdrawal_method['method_fields'] as $key=>$field)
                                        @if($key>0)
                                            <div class="card card-body mb-30" id="field-row--{{$key}}">
                                                <div class="row gy-4 align-items-center">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-floating">
                                                            <select class="form-control" name="field_type[]" required>
                                                                <option value="string" {{$field['input_type']=='string'?'selected':''}}>{{translate('String')}}</option>
                                                                <option value="number" {{$field['input_type']=='number'?'selected':''}}>{{translate('Number')}}</option>
                                                                <option value="date" {{$field['input_type']=='date'?'selected':''}}>{{translate('Date')}}</option>
                                                                <option value="password" {{$field['input_type']=='password'?'selected':''}}>{{translate('Password')}}</option>
                                                                <option value="email" {{$field['input_type']=='email'?'selected':''}}>{{translate('Email')}}</option>
                                                                <option value="phone" {{$field['input_type']=='phone'?'selected':''}}>{{translate('Phone')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" name="field_name[{{$key}}]"
                                                                   placeholder="Select field name"
                                                                   value="{{$field['input_name']??''}}"
                                                                   required>
                                                            <label>{{translate('field_name')}} *</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" name="placeholder_text[{{$key}}]"
                                                                   placeholder="Select placeholder text"
                                                                   value="{{$field['placeholder']??''}}"
                                                                   required>
                                                            <label>{{translate('placeholder_text')}} *</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="1"
                                                                   name="is_required[{{$key}}]" id="flexCheckDefault__{{$key}}"
                                                                    {{$field['is_required'] ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="flexCheckDefault__{{$key}}">
                                                                {{translate('This_field_required')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <span class="btn btn--danger" onclick="remove_field({{$key}})">
                                                            <span class="material-icons">delete</span>
                                                                {{translate('Remove')}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="d-flex justify-content-start">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_default" id="flexCheckDefaultMethod" {{$withdrawal_method['is_default'] == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="flexCheckDefaultMethod">
                                            {{translate('default_method')}}
                                        </label>
                                    </div>
                                </div>

                                <!-- BUTTON -->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn--secondary mx-2">{{translate('Reset')}}</button>
                                    <button type="submit" class="btn btn--primary demo_check">{{translate('Submit')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->


@endsection

@push('script')
    <script>
        function remove_field(fieldRowId) {
            $( `#field-row--${fieldRowId}` ).remove();
            counter--;
        }

        jQuery(document).ready(function ($) {
            counter = {{count($withdrawal_method['method_fields']) ?? 0 }};

            $('#add-more-field').on('click', function (event) {
                if(counter < 15) {
                    event.preventDefault();

                    $('#custom-field-section').append(
                        `<div class="card card-body mb-30" id="field-row--${counter}">
                            <div class="row gy-4 align-items-center">
                                <div class="col-md-6 col-12">
                                    <div class="form-floating">
                                        <select class="form-control" name="field_type[]" required>
                                            <option value="string">{{translate('String')}}</option>
                                            <option value="number">{{translate('Number')}}</option>
                                            <option value="date">{{translate('Date')}}</option>
                                            <option value="password">{{translate('Password')}}</option>
                                            <option value="email">{{translate('Email')}}</option>
                                            <option value="phone">{{translate('Phone')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="field_name[${counter}]"
                                               placeholder="Select field name" value="" required>
                                        <label>{{translate('field_name')}} *</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="placeholder_text[${counter}]"
                                               placeholder="Select placeholder text" value="" required>
                                        <label>{{translate('placeholder_text')}} *</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_required[${counter}]" id="flexCheckDefault__${counter}" checked>
                                        <label class="form-check-label" for="flexCheckDefault__${counter}">
                                            {{translate('This_field_required')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <span class="btn btn--danger" onclick="remove_field(${counter})">
                                        <span class="material-icons">delete</span>
                                            {{translate('Remove')}}
                                    </span>
                                </div>
                            </div>
                        </div>`
                    );

                    counter++;
                } else {
                    Swal.fire({
                        title: '{{translate('Reached maximum')}}',
                        confirmButtonText: '{{translate('ok')}}',
                    });
                }
            })

            $('form').on('reset', function (event) {
                if(counter > 1) {
                    $('#custom-field-section').html("");
                    $('#method_name').val("");
                }

                counter = 1;
            })
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
        });
    </script>


@endpush
