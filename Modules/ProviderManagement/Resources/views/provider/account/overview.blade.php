@extends('providermanagement::layouts.master')

@section('title',translate('Account_Overview'))

@push('css_or_js')

    <style>
        .statistics-card__style2 .btn--warning {
            background: #F8924F
        }
    </style>
@endpush

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            {{-- Alert --}}
            @if(provider_warning_amount_calculate($provider->owner->account->account_payable,$provider->owner->account->account_receivable) == '80_percent'
             && business_config('max_cash_in_hand_limit_provider', 'provider_config')->live_values > 0
             && business_config('suspend_on_exceed_cash_limit_provider', 'provider_config')->live_values)
                <div class="alert alert-danger">
                    <div class="media gap-3 align-items-center">
                        <div class="alert-close-btn">
                            <span class="material-symbols-outlined">close</span>
                        </div>
                        <div class="media-body">
                            <h5 class="text-capitalize">{{translate('Attention Please')}}!</h5>
                            <p class="text-dark fs-12">
                                {{translate('Looks like your limit to hold cash will be exceed soon. Please pay the due amount or other wise your account will be suspended if the amount exceed')}}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if(business_config('suspend_on_exceed_cash_limit_provider', 'provider_config')->live_values && Request()->user()->provider->is_suspended == 1)
                <div class="alert alert-danger">
                    <div class="media gap-3 align-items-center">
                        <div class="alert-close-btn">
                            <span class="material-symbols-outlined">close</span>
                        </div>
                        <div class="media-body">
                            <h5 class="text-capitalize">{{translate('Attention Please')}}!</h5>
                            <p class="text-dark fs-12">
                                {{translate('Your limit to hold cash is exceeded. Your account has been suspended until you pay the due. You will not receive any new booking requests from now')}}
                                <a class="text-primary text-decoration-underline" type="button"
                                   data-bs-target="#paymentMethodModal"
                                   data-bs-toggle="modal">{{translate('Pay the Due')}}</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="page-title-wrap mb-3">
                <h2 class="page-title">{{translate('Account_Information')}}</h2>
            </div>

            @php($flagParam = request('flag'))
            <!-- Nav Tabs -->
            <div class="mb-3">
                <ul class="nav nav--tabs nav--tabs__style2">
                    <li class="nav-item">
                        <a class="nav-link {{$page_type=='overview' || in_array($flagParam, ['success', 'failed']) ?'active':''}}"
                           href="{{url()->current()}}?page_type=overview">{{translate('Overview')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$page_type=='commission-info'?'active':''}}"
                           href="{{url()->current()}}?page_type=commission-info">{{translate('Commission_Info')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$page_type=='review'?'active':''}}"
                           href="{{url()->current()}}?page_type=review">{{translate('Reviews')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$page_type=='promotional_cost'?'active':''}}"
                           href="{{url()->current()}}?page_type=promotional_cost">{{translate('Promotional_Cost')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$page_type=='withdraw_transaction'?'active':''}}"
                           href="{{route('provider.withdraw.list', ['page_type'=>'withdraw_transaction'])}}">{{translate('withdraw_list')}}</a>
                    </li>
                </ul>
            </div>
            <!-- End Nav Tabs -->

            <!-- Provider Details Overview -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row gy-2">
                        @php($checkAdjust = $provider->owner->account->account_payable == $provider->owner->account->account_receivable && $provider->owner->account->account_payable == 0 && $provider->owner->account->account_receivable == 0)
                        <div class="@if($checkAdjust) col-lg-6 @else col-lg-3 @endif">
                            <div class="statistics-card statistics-card__style2">
                                <h2>{{with_currency_symbol($provider->owner->account->account_receivable)}}</h2>
                                <p class="d-flex align-items-center gap-2 text-muted">{{translate('receivable_balance')}}
                                    <i class="material-icons text-muted" data-bs-toggle="tooltip"
                                       title="{{translate('Total amount of payments that you’ll receive from admin.')}}">info</i>
                                </p>
                            </div>
                        </div>
                        <div class="@if($checkAdjust) col-lg-6 @else col-lg-3 @endif">
                            <div class="statistics-card statistics-card__style2">
                                <h2>{{with_currency_symbol($provider->owner->account->account_payable)}}</h2>
                                <p class="d-flex align-items-center gap-2 text-muted">{{translate('cash_in_hand')}} <i
                                        class="material-icons text-muted" data-bs-toggle="tooltip"
                                        title="{{translate('Total amount you’ve received from the customer in cash (Cash after Service)')}}">info</i>
                                </p>
                            </div>
                        </div>
                        @if($provider->owner->account->account_payable > $provider->owner->account->account_receivable && $provider->owner->account->account_receivable != 0)
                            <div class="col-lg-6">
                                <div
                                    class="statistics-card statistics-card__style2 d-flex justify-content-between gap-2 align-items-center">
                                    <div class="">
                                        <h2>{{with_currency_symbol($provider->owner->account->account_payable - $provider->owner->account->account_receivable)}}</h2>
                                        <p class="d-flex align-items-center gap-2 text-muted">{{translate('Payable Balance')}}
                                            <i class="material-icons text-muted" data-bs-toggle="tooltip" title="Info">info</i>
                                        </p>
                                    </div>
                                    <button type="button" data-bs-target="#paymentMethodModal" data-bs-toggle="modal"
                                            class="btn btn--primary">{{translate('adjust_&_pay')}}</button>
                                </div>
                            </div>
                        @elseif($provider->owner->account->account_payable > $provider->owner->account->account_receivable && $provider->owner->account->account_receivable == 0)
                            <div class="col-lg-6">
                                <div
                                    class="statistics-card statistics-card__style2 d-flex justify-content-between gap-2 align-items-center">
                                    <div class="">
                                        <h2>{{with_currency_symbol($provider->owner->account->account_payable - $provider->owner->account->account_receivable)}}</h2>
                                        <p class="d-flex align-items-center gap-2 text-muted">{{translate('Payable Balance')}}
                                            <i class="material-icons text-muted" data-bs-toggle="tooltip" title="{{translate('You now have to pay this amount to the admin.
                                            (Cash in Hand - Receivable Balance = Payable Balance)
                                            Or,
                                            As you have more amount as ‘Cash in Hand’, you now have to pay this amount to admin.
                                            (Cash in Hand - Receivable Balance = Payable Balance)
                                            ')}}">info</i>
                                        </p>
                                    </div>
                                    <button type="button" data-bs-target="#paymentMethodModal" data-bs-toggle="modal"
                                            class="btn btn--primary">{{translate('pay')}}</button>
                                </div>
                            </div>
                        @elseif($provider->owner->account->account_receivable > $provider->owner->account->account_payable && $provider->owner->account->account_payable != 0)
                            <div class="col-lg-6">
                                <div
                                    class="statistics-card statistics-card__style2 d-flex justify-content-between gap-2 align-items-center">
                                    <div class="">
                                        <h2>{{with_currency_symbol($provider->owner->account->account_receivable - $provider->owner->account->account_payable)}}</h2>
                                        <p class="d-flex align-items-center gap-2 text-muted">{{translate('Withdraw-able Balance')}}
                                            <i class="material-icons text-muted" data-bs-toggle="tooltip"
                                               title="Info">info</i></p>
                                    </div>
                                    <button class="btn btn--warning" data-bs-toggle="modal"
                                            data-bs-target="#withdrawRequestModal">{{translate('adjust_&_withdraw')}}</button>
                                </div>
                            </div>
                        @elseif($provider->owner->account->account_receivable > 0 && $provider->owner->account->account_payable == 0)
                            <div class="col-lg-6">
                                <div
                                    class="statistics-card statistics-card__style2 d-flex justify-content-between gap-2 align-items-center">
                                    <div class="">
                                        <h2>{{with_currency_symbol($provider->owner->account->account_receivable - $provider->owner->account->account_payable)}}</h2>
                                        <p class="d-flex align-items-center gap-2 text-muted">{{translate('Withdraw-able Balance')}}
                                            <i class="material-icons text-muted" data-bs-toggle="tooltip"
                                               title="{{translate('You can now request this amount for withdrawal from admin.
                                            (Receivable Balance - Cash in Hand = Withdrawable Balance)
                                            Or,
                                            As admin has most of your payments in hand, you can now request the admin for withdrawal.
                                             (Receivable Balance - Cash in Hand = Withdrawable Balance)
                                            ')}}">info</i></p>
                                    </div>
                                    <button class="btn btn--warning" data-bs-toggle="modal"
                                            data-bs-target="#withdrawRequestModal">{{translate('withdraw')}}</button>
                                </div>
                            </div>
                        @elseif($provider->owner->account->account_payable == $provider->owner->account->account_receivable && $provider->owner->account->account_payable != 0 && $provider->owner->account->account_receivable != 0)
                            <div class="col-lg-6">
                                <div
                                    class="statistics-card statistics-card__style2 d-flex justify-content-between gap-2 align-items-center">
                                    <div class="">
                                        <h2>{{with_currency_symbol($provider->owner->account->account_receivable - $provider->owner->account->account_payable)}}</h2>
                                        <p class="d-flex align-items-center gap-2 text-muted">{{translate('withdraw_or_payable Balance')}}
                                            <i class="material-icons text-muted" data-bs-toggle="tooltip"
                                               title="Info">info</i></p>
                                    </div>
                                    <a class="btn btn--primary"
                                       href="{{ route('provider.adjust') }}">{{translate('adjust')}}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="row gy-2">
                        <div class="col-md-4">
                            <div class="p-4 rounded" style="background-color: #E0F1FF">
                                <h3 class="mb-2">{{translate('Pending Withdraw')}}</h3>
                                <h5 class="d-flex align-items-center gap-2 text-muted">{{with_currency_symbol($provider->owner->account->balance_pending)}}
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 rounded" style="background-color: #CDFFE2">
                                <h3 class="mb-2">{{translate('Already Withdrawn')}}</h3>
                                <h5 class="d-flex align-items-center gap-2 text-muted">{{with_currency_symbol($provider->owner->account->total_withdrawn)}}
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 rounded" style="background-color: #FFF5E1">
                                <h3 class="mb-2">{{translate('Total Earning')}}</h3>
                                <h5 class="d-flex align-items-center gap-2 text-muted">{{ with_currency_symbol($total_earning) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between gap-3 mb-3 mt-4">
                <h2>{{translate('Information_Details')}}</h2>
                <a href="{{route('provider.profile_update')}}" class="btn btn--primary">
                    <span class="material-icons">border_color</span>
                    {{translate('Edit')}}
                </a>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <!-- Information Details Box -->
                    <div class="bg-white information-details-box media flex-column flex-sm-row gap-20 h-100">
                        <img class="avatar-img radius-5 max-w220"
                             src="{{asset('storage/app/public/provider/logo')}}/{{$provider->logo}}"
                             onerror="this.src='{{asset('public/assets/provider-module')}}/img/media/info-details.png'"
                             alt="">
                        <div class="media-body ">
                            <h2 class="information-details-box__title text-capitalize">{{Str::limit($provider->company_name, 30)}}</h2>

                            <ul class="contact-list">
                                <li>
                                    <span class="material-symbols-outlined">phone_iphone</span>
                                    <a href="tel:{{$provider->company_phone}}">{{$provider->company_phone}}</a>
                                </li>
                                <li>
                                    <span class="material-symbols-outlined">mail</span>
                                    <a href="mailto:{{$provider->company_email}}">{{$provider->company_email}}</a>
                                </li>
                                <li>
                                    <span class="material-symbols-outlined">map</span>
                                    {{Str::limit($provider->company_address, 100)}}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Information Details Box -->
                </div>
                <div class="col-lg-6">
                    <!-- Information Details Box -->
                    <div class="bg-white information-details-box h-100">
                        <h2 class="information-details-box__title c1">{{translate('Contact_Person_Information')}}
                        </h2>
                        <h3 class="information-details-box__subtitle text-capitalize">{{Str::limit($provider->contact_person_name, 30)}}</h3>

                        <ul class="contact-list">
                            <li>
                                <span class="material-symbols-outlined">phone_iphone</span>
                                <a href="tel:{{$provider->contact_person_phone}}">{{$provider->contact_person_phone}}</a>
                            </li>
                            <li>
                                <span class="material-symbols-outlined">mail</span>
                                <a href="mailto:{{$provider->contact_person_email}}">{{$provider->contact_person_email}}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Information Details Box -->
                </div>
                <div class="col-12">
                    <!-- Information Details Box -->
                    <div class="bg-white information-details-box">
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <h2 class="information-details-box__title c1 mb-3">{{translate('Business_Information')}}
                                </h2>
                                <p><strong
                                        class="text-capitalize">{{translate($provider->owner->identification_type)}}
                                        -</strong> {{$provider->owner->identification_number}}</p>
                            </div>
                            <div class="col-lg-9">
                                <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
                                    @if(isset($provider->owner->identification_image) && count($provider->owner->identification_image) > 0)
                                        @foreach($provider->owner->identification_image as $key=>$image)
                                            <div>
                                                <img class="max-w320"
                                                     src="{{asset('storage/app/public/provider/identity')}}/{{$image}}"
                                                     onerror="this.src='{{asset('public/assets/provider-module')}}/img/media/provider-id.png'"
                                                     alt="">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Information Details Box -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-xl-5">
                    <h3 class="mb-2">{{translate('Payment Method')}}</h3>
                    <p>{{translate('Payment with secured Digital payment gateways')}}</p>
                    <p class="text-muted fs-12">{{translate('Select Payment Method')}}</p>

                    <form action="{{url('payment/')}}?is_pay_to_admin=true" class="payment-method-form" method="post">
                        <div class="payment_method_grid gap-3 gap-lg-4">
                            @foreach($payment_gateways ?? [] as $gateway)
                                <div class="border bg-white p-4 rounded">
                                    <input type="radio" id="{{$gateway['gateway']}}" name="payment_method"
                                           value="{{ $gateway['gateway'] }}" required>
                                    <label for="{{$gateway['gateway']}}" class="d-flex align-items-center gap-3">
                                        <img
                                            src="{{ asset('storage/app/public/payment_modules/gateway_image') }}/{{ $gateway['gateway_image'] }}"
                                            onerror="this.src='{{ asset('public/assets/admin-module') }}/img/placeholder.png'"
                                            alt="">
                                    </label>
                                </div>
                                <input type="hidden" id="{{$gateway['gateway']}}" name="provider_id"
                                       value="{{ $provider['id'] }}">
                            @endforeach
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-3 my-4">
                            <button type="button" class="btn btn--secondary"
                                    data-bs-dismiss="modal">{{translate('Cancel')}}</button>
                            <button type="submit" class="btn btn--primary">{{translate('Proceed to Pay')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- withdraw Request Modal  -->

    <div class="modal fade" id="withdrawRequestModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{route('provider.withdraw.store')}}" method="POST">
                    @csrf
                    <div class="modal-body p-30">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h3 class="modal-body_title mb-4">{{translate('Withdraw_Request')}}</h3>

                        <select class="js-select" id="withdraw_method" name="withdraw_method" required>
                            <option value="" selected disabled>{{translate('Select_Withdraw_Method')}}</option>
                            @foreach($withdrawal_methods as $item)
                                <option value="{{$item['id']}}"
                                        @if($item->is_default == 1) selected @endif>{{$item['method_name']}}</option>
                            @endforeach
                        </select>

                        <div id="method-filed__div">

                        </div>

                        <div class="form-group mt-2">
                            <label for="wr_num" class="fz-16 c1 mb-2">{{translate('Note')}}</label>
                            <textarea type="text" class="form-control" name="note" placeholder="{{translate('Note')}}"
                                      maxlength="255"></textarea>
                        </div>

                        <input type="number" class="my-3 fz-34 text-center bg-transparent border-0" step="any"
                               name="amount"
                               value="0" placeholder="{{translate('Amount')}}" id="amount"
                               min="{{$withdraw_request_amount['minimum']}}"
                               max="{{$withdraw_request_amount['maximum']}}"
                        >
                        <label class="my-3 fz-34 text-left">{{currency_symbol()}}</label>

                        <div class="fz-15 text-muted border-bottom pb-4 text-center">
                            <div>{{translate('Available_Balance')}} {{with_currency_symbol($collectable_cash)}}</div>

                            <div>{{translate('Minimum_Request_Amount')}} {{with_currency_symbol($withdraw_request_amount['minimum'])}}</div>
                            <div>{{translate('Maximum_Request_Amount')}} {{with_currency_symbol($withdraw_request_amount['maximum'])}}</div>
                        </div>

                        <ul class="radio-list justify-content-center mt-4">
                            @forelse($withdraw_request_amount['random'] as $key=>$item)
                                <li>
                                    <input type="radio" id="withdraw_amount{{$key+1}}" name="withdraw_amount"
                                           onclick="predefined_amount_input({{$item}})" hidden>
                                    <label for="withdraw_amount{{$key+1}}">{{with_currency_symbol($item)}}</label>
                                </li>
                            @empty
                                <li>
                                    <input type="radio" id="withdraw_amount" name="withdraw_amount"
                                           onclick="predefined_amount_input(500)" hidden>
                                    <label for="withdraw_amount">500 {{currency_symbol()}}</label>
                                </li>
                                <li>
                                    <input type="radio" id="withdraw_amount2" name="withdraw_amount"
                                           onclick="predefined_amount_input(1000)" hidden>
                                    <label for="withdraw_amount2">1000 {{currency_symbol()}}</label>
                                </li>
                                <li>
                                    <input type="radio" id="withdraw_amount3" name="withdraw_amount"
                                           onclick="predefined_amount_input(2000)" hidden>
                                    <label for="withdraw_amount3">2000 {{currency_symbol()}}</label>
                                </li>
                                <li>
                                    <input type="radio" id="withdraw_amount4" name="withdraw_amount"
                                           onclick="predefined_amount_input(5000)" hidden>
                                    <label for="withdraw_amount4">5000 {{currency_symbol()}}</label>
                                </li>
                                <li>
                                    <input type="radio" id="withdraw_amount5" name="withdraw_amount"
                                           onclick="predefined_amount_input(10000)" hidden>
                                    <label for="withdraw_amount5">10000 {{currency_symbol()}}</label>
                                </li>
                            @endforelse
                        </ul>

                        <div class="modal-body_btns d-flex justify-content-center mt-4">
                            <button type="submit"
                                    class="btn btn--primary">{{translate('Send_Withdraw_Request')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{asset('public/assets/provider-module')}}/plugins/apex/apexcharts.min.js"></script>

    <script>
        var options = {
            labels: ['accepted', 'ongoing', 'completed', 'canceled'],
            series: {{json_encode($total)}},
            chart: {
                width: 235,
                height: 160,
                type: 'donut',
            },
            dataLabels: {
                enabled: false
            },
            title: {
                text: "{{$provider->bookings_count}} Bookings",
                align: 'center',
                offsetX: 0,
                offsetY: 58,
                floating: true,
                style: {
                    fontSize: '12px',
                },
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        show: true
                    }
                }
            }],
            legend: {
                position: 'bottom',
                offsetY: -5,
                height: 30,
            },
        };

        var chart = new ApexCharts(document.querySelector("#apex-pie-chart"), options);
        chart.render();
    </script>

    <script>
        "use Strict"
        $('#withdraw_method').on('change', function () {
            var method_id = this.value;

            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('provider.withdraw.method.list')}}" + "?method_id=" + method_id,
                data: {},
                processData: false,
                contentType: false,
                type: 'get',
                success: function (response) {
                    let method_fields = response.content.method_fields;
                    $("#method-filed__div").html("");
                    method_fields.forEach((element, index) => {
                        $("#method-filed__div").append(`
                        <div class="form-group mt-2">
                            <label for="wr_num" class="fz-16 c1 mb-2">${element.input_name.replaceAll('_', ' ')}</label>
                            <input type="${element.input_type}" class="form-control" name="${element.input_name}" placeholder="${element.placeholder}" ${element.is_required === 1 ? 'required' : ''}>
                        </div>
                    `);
                    })

                },
                error: function () {

                }
            });
        });

        if ($('#withdraw_method').val()) {
            $('#withdraw_method').trigger('change');
        }

        function predefined_amount_input(amount) {
            document.getElementById("amount").value = amount;
        }
    </script>

@endpush
