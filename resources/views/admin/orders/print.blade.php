<!DOCTYPE html>
<html lang="en">
@php
    if(Auth::user()->type == 4)
    {
        $vendor_id = Auth::user()->vendor_id;
    }else{
        $vendor_id = Auth::user()->id;
    }
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('labels.print') }}</title>
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ helper::image_path(@helper::appdata($getorderdata->vendor_id)->favicon) }}">
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/css/bootstrap/bootstrap.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/css/fontawesome/all.min.css') }}">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/css/toastr/toastr.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/css/sweetalert/sweetalert2.min.css') }}">
    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/css/style.css') }}"><!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/css/responsive.css') }}">
    <!-- Responsive CSS -->
    <style type="text/css">
        body {
            width: 88mm;
            height: 100%;
            margin: 0;
            padding: 0;
            --webkit-font-smoothing: antialiased;
        }

        #printDiv {
            font-weight: 600;
            margin-left: 15px;
            padding: 0;
        }

        #printDiv div .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }

        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 1.6cm;
            }

            #btnPrint {
                display: none;
            }
        }

        .border-top-bottom {
            border-top: 1px solid black !important;
            border-bottom: 1px solid black !important;
        }
    </style>
</head>

<body>
    <div class="overflow-auto h-100vh">
        <div id="printDiv" class="pos-modal">
            <h3 class="text-center mb-4 mt-2">{{ @helper::appdata($getorderdata->vendor_id)->website_title }}</h3>
            <div class="order-details border-0">
                <p class="fw-normal">#{{ @$getorderdata->order_number }}</p>
                <p class="fw-500">{{ @$getorderdata->customer_name }}</p>
                <p>{{ @$getorderdata->customer_email }}</p>
                <p>{{ @$getorderdata->mobile }}</p>
                <p>{{ @$getorderdata->delivery_area }}</p>
            </div>
            <div class="store-details border-bottom pb-2">
                <p class="fw-normal">{{ trans('labels.date') }} :
                    <span>{{ @date('Y-m-d', strtotime($getorderdata->created_at)) }}</span></p>
                @if ($getorderdata->order_notes)
                    <p>{{ trans('labels.order_note') }} : <small style="color: gray">
                            {{ $getorderdata->order_notes }}</small></p>
                @endif
            </div>

            @if (!empty($ordersdetails))
                @php $i=0; @endphp
                @foreach ($ordersdetails as $item)
                    @php $i++; @endphp
                    <div class="items-details border-bottom mt-2">
                        <span class="fw-500 mb-3"> {{ @$item->item_name }} @if ($item->variants_name != null)
                                - ({{ $item->variants_name }} :
                                {{ helper::currency_formate($item->variants_price, $vendor_id) }})
                            @else
                                ({{ helper::currency_formate($item->variants_price, $vendor_id) }})
                            @endif
                        </span>
                        @if ($item->extras_id != '')
                            <?php
                            $extras_id = explode('|', $item->extras_id);
                            $extras_name = explode('|', $item->extras_name);
                            $extras_price = explode('|', $item->extras_price);
                            $extras_total_price = 0;
                            ?>
                            <br>
                            @foreach ($extras_id as $key => $addons)
                                <small>
                                    <b class="text-muted">{{ $extras_name[$key] }}</b> :
                                    {{ helper::currency_formate($extras_price[$key], $vendor_id) }}<br>
                                </small>
                                @php
                                    $extras_total_price += (float) $extras_price[$key];
                                @endphp
                            @endforeach
                        @else
                            @php
                                $extras_total_price = 0;
                            @endphp
                        @endif
                        @php
                            $price = (float) $extras_total_price + (float) $item->variants_price;
                            $total = (float) $price * (float) $item->qty;
                        @endphp
                        <div class="items border-0 mb-2">
                            <p class="fw-normal">{{ trans('labels.price') }}</p>
                            <p class="fw-normal">{{ @$item->qty }} X
                                {{ @helper::currency_formate($price, $vendor_id) }}</p>
                        </div>
                        <div class="items border-0 mb-2">
                            <p class="fw-normal">{{ trans('labels.tax') }}</p>
                            <p class="fw-normal">{{ @helper::currency_formate($$getorderdata->tax, $vendor_id) }}
                            </p>
                        </div>
                        <div class="items border-0 mb-2">
                            <p class="fw-normal">{{ trans('labels.total') }}</p>
                            <p class="fw-normal">{{ @helper::currency_formate($total, $vendor_id) }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="total-amount mt-2">
                <div class="items border-0 mb-2 fw-500">
                    <p>{{ trans('labels.sub_total') }}</p>
                    <p>{{ @helper::currency_formate($getorderdata->sub_total, $vendor_id) }}</p>
                </div>

              
                @php
                    $tax = explode('|', $getorderdata->tax);
                    $tax_name = explode('|', $getorderdata->tax_name);
                @endphp
                @if ($getorderdata->tax != null && $getorderdata->tax != '')
                    @foreach ($tax as $key => $tax_value)
                        <div class="items border-0 mb-2 fw-500">
                            <p>{{ $tax_name[$key] }}</p>
                            <p>{{ @helper::currency_formate(@(float) $tax[$key], $vendor_id) }}</p>
                        </div>
                    @endforeach
                @endif

              
                @if ($getorderdata->order_type == 1)
                    <div class="items border-0 mb-2 fw-500">
                        <p>{{ trans('labels.delivery_charge') }} (+)</p>
                        <p>{{ @helper::currency_formate($getorderdata->delivery_charge, $vendor_id) }}</p>
                    </div>
                @endif
                  @if (
                    $getorderdata->discount_amount != '' &&
                        $getorderdata->discount_amount != null &&
                        $getorderdata->discount_amount != 0)
                    <div class="items border-0 mb-2 fw-500">
                        <p>
                            @if ($getorderdata->offer_type == 'loyalty')
                                {{ trans('labels.loyalty_discount') }}
                            @endif
                            @if ($getorderdata->order_type == 4)
                                {{ trans('labels.discount') }}
                            @else
                                @if ($getorderdata->offer_type == 'promocode')
                                    {{ trans('labels.discount') }}
                                @endif
                            @endif
                        </p>
                        <p>(-) {{ @helper::currency_formate($getorderdata->discount_amount, $vendor_id) }}</p>
                    </div>
                @endif
                <div class="items border-0 border-top-bottom mt-3 fs-5 fw-600">
                    <p>{{ trans('labels.grand_total') }}</p>
                    <p>{{ @helper::currency_formate($getorderdata->grand_total, $vendor_id) }}</p>
                </div>
            </div>
            <h6 class="fw-500 text-center mt-4">{{ trans('labels.thank_you_note') }}</h6>

        </div>
        <div class="d-flex align-items-center justify-content-center mt-4">
            <button id="btnPrint" class="btn btn-secondary hidden-print center">
                <i class="fa-solid fa-print"></i>
                <span class="px-2">
                    {{ trans('labels.print') }}
                </span>
            </button>
        </div>
    </div>
    <script>
        const $btnPrint = document.querySelector("#btnPrint");
        $btnPrint.addEventListener("click", () => {
            window.print();
        });
    </script>
</body>
