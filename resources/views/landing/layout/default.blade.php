<!DOCTYPE html>
<html lang="en" dir="{{session()->get('direction') == 2 ? 'rtl' : 'ltr'}}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="{{ helper::appdata('')->meta_title }}" />
    <meta property="og:description" content="{{ helper::appdata('')->meta_description }}" />
    <meta property="og:image" content='{{ helper::image_path(helper::appdata('')->og_image) }}' />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 

    
    <link rel="icon" type="image" sizes="16x16" href="{{ helper::image_path(helper::appdata('')->favicon) }}"><!-- Favicon icon -->
    <title>{{helper::appdata('')->landing_website_title}}</title>
    <!-- Font Awesome icon css-->

    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'landing/css/all.min.css')}}">

    <!-- owl carousel css -->

    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'landing/css/owl.carousel.min.css')}}">

    <!-- owl carousel css -->

    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'landing/css/owl.theme.default.min.css')}}">

    <!-- Poppins fonts -->

    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'landing/fonts/poppins.css')}}">

    <!-- bootstrap-icons css -->

    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'landing/css/bootstrap-icons.css')}}">

    <!-- bootstrap css -->

    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'landing/css/bootstrap.min.css')}}">

    <!-- style css -->

    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'landing/css/style.css')}}">

    <!-- responsive css -->

    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'landing/css/responsive.css')}}">
    <style>
        :root {

            /* Color */
            --bs-primary: {{helper::appdata('')->primary_color}};
            --bs-secondary : {{helper::appdata('')->secondary_color}};

        }
    </style>
    @yield('styles')
</head>

<body>
    @include('landing.layout.preloader')

    @include('landing.layout.header')
    <div>
      
        @yield('content')
    </div>
    @include('landing.layout.footer')

    <!-- Modal -->
    <div class="d-flex align-items-center float-end">
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content search-modal-content rounded-5">
                    <div class="modal-header border-0 px-4 align-items-center">
                        <h3 class="page-title mb-0 d-block d-md-none">search</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 mb-0">
                        <form class="" action="{{URL::to('stores')}}" method="get">

                            <div class="col-12">
                                <div class="row align-items-center justify-content-between">

                                    <div class="col-6 d-none d-lg-block">
                                        <div class="Search-left-img">
                                            <img src="{{ url(env('ASSETSPATHURL').'landing/images/search.webp')}}" alt="search-left-img" class="w-100 object-fit-cover search-left-img">
                                        </div>
                                    </div>


                                    <div class="col-12 col-lg-6">
                                        <div class="search-content text-capitalize">
                                            <h4 class="fs-2 text-dark fw-bolder mb-2 d-none d-md-block">{{ trans('labels.search') }}</h4>
                                            <p class="fs-6">{{ trans('labels.search_title') }}</p>
                                        </div>
                                    <div class="select-input-box">
                                        <select name="store" class="py-2 input-width px-2 mt-4 mb-1 w-100 border rounded-5 fs-7" id="store">
                                            <option value="">{{ trans('landing.select_store_category') }}</option>
                                            @foreach (@helper::storecategory() as $store)
                                            <option value="{{$store->name}}"  {{ request()->get('store') == $store->name ? 'selected' : '' }}>{{$store->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                        <select name="city" id="city" class="py-2 input-width px-2 mt-2 mb-1 w-100 border rounded-5 fs-7">
                                            <option value="" data-value="{{ URL::to('/stores?city=' . '&area=' . request()->get('area')) }}" data-id="0" selected>{{ trans('landing.select_city') }}</option>

                                            @foreach (helper::get_city() as $city)
                                            <option value="{{ $city->name }}" data-value="{{ URL::to('/stores?city=' . request()->get('city') . '&area=' . request()->get('area')) }}" data-id={{ $city->id }} {{ request()->get('city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>

                                        <select name="area" id="area" class="py-2 input-width px-2 mt-2 mb-1 w-100 border rounded-5 fs-7">
                                            <option value="">{{ trans('landing.select_area') }}</option>
                                            @if(request()->get('area'))
                                            <option value="{{request()->get('area')}}" selected>{{request()->get('area')}}</option>
                                            @endif


                                        </select>

                                        <div class="search-btn-group">
                                            <div class="d-flex justify-content-between align-items-center mt-5">
                                                <a type="submit" class="btn-primary bg-danger w-100 rounded-3 rounded-3 m-1 text-center" data-bs-dismiss="modal">{{ trans('labels.cancel') }} </a>
                                                <input type="submit" class="btn-primary w-100 rounded-3 rounded-3 m-1 text-center" value="{{ trans('labels.submit') }}" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (env('Environment') == 'sendbox') 
    <button type="button" class="demo_label main-button border-0 d-none" data-bs-toggle="modal" data-bs-target="#demo-modal">
    <i class="fa fa-info-circle"></i>
    <span>Note</span></button>
    @endif
    <!--Modal: order-modal-->
    <div class="modal fade" id="demo-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
            <div class="modal-content text-center">
                <div class="modal-header d-flex justify-content-center">
                    <h5>Script License Information</h5>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-md-6 border-line text-danger">
                                <h4>Regular License</h4>
                                <hr>
                                <ul class="text-start">
                                    <li> <i class="fa-regular fa-circle-check text-danger "></i>
                                    You can not create subscription plans
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-danger "></i>
                                    You can not charge your end customers using subscription plans
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 text-success">
                                <h4 class="mt-3 mt-sm-0">Extended License</h4>
                                <hr>
                                <ul class="text-start">
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    You can create subscription plans
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    You can charge your end customers using subscription plans
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <h5 class="mb-3">Script Installation & Configuration Service</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6 border-line text-danger">
                                <h4>Regular License</h4>
                                <hr>
                                <ul class="text-start">
                                    <li> <i class="fa-regular fa-circle-check text-danger "></i>
                                    One time installation service (cPanel OR Plesk based hosting server) : $49
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-danger "></i>
                                    One time installation service (Any other hosting server) : Contact us for pricing
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 text-success">
                                <h4 class="mt-3 mt-sm-0">Extended License</h4>
                                <hr>
                                <ul class="text-start">
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    One time installation service (cPanel OR Plesk based hosting server) : FREE
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    One time installation service (Any other hosting server) : Contact us for pricing
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <h5 class="mb-3">Script Addons Information</h5>
                        <p class="text-info">(We have installed all addons in the demo script. You will get the addons as mentioned below)</p>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4 border-line text-danger">
                                <h4>Regular License</h4>
                                <hr>
                                <ul class="text-start">
                                    <li> <i class="fa-regular fa-circle-check text-danger "></i>
                                    No addons available
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 border-line ms-auto text-success">
                                <h4 class="mt-3 mt-sm-0">Extended License</h4>
                                <small class="text-primary">(You will get below mentioned 7 addons free)</small>
                                <hr>
                                <ul class="text-start">
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    Google Analytics
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    Customer Login
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    Blogs
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    Language
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    Coupons
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    Custom Domain
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    Themes
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 ms-auto text-dark">
                                <h4>Priemum Addons</h4>
                                <hr>
                                <ul class="text-start">
                                    <li> <i class="fa-regular fa-circle-check text-dark "></i>
                                    PayPal
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-dark "></i>
                                    MyFatoorah
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-dark "></i>
                                    Mercado Pago
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-dark "></i>
                                    toyyibPay
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-dark "></i>
                                    POS (Point Of Sale)
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-dark "></i>
                                    Telegram
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-dark "></i>
                                    Table QR
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-dark "></i>
                                    PWA (Progressive Web App)
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6 border-line text-danger">
                                <h4>Notes</h4>
                                <hr>
                                <ul class="text-start">
                                    <li> <i class="fa-regular fa-circle-check text-danger "></i>
                                    Any third party configuration service will be charged extra (Example : Email Configuration, Custom Domain Configuration, Social Login Configuration, Google Analytics Configuration, Google reCaptcha Configuration, etc…)
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-danger "></i>
                                    If you have any questions regarding LICENSE, INSTALLATION & ADDONS then please contact us
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 text-success">
                                <h4 class="mt-3 mt-sm-0">Contact Information</h4>
                                <hr>
                                <ul class="text-start">
                                <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    Email : <a href="mailto: infotechgravity@gmail.com" target="_blank"> infotechgravity@gmail.com</a>
                                    </li>
                                    <li> <i class="fa-regular fa-circle-check text-success "></i>
                                    Whatsapp : <a href="https://api.whatsapp.com/send?text=Hello I found your from Demo&phone=919499874557" target="_blank">+91 9499874557</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <a href="https://1.envato.market/R5mbvb" target="_blank" class="btn btn-danger m-1">Buy Regular License</a>
                    <a href="https://1.envato.market/3eoEDd" target="_blank" class="btn btn-success m-1">Buy Extended License</a>
                    <a href="https://rb.gy/nc1f9" target="_blank" class="btn btn-dark m-1">Buy Priemum Addons</a>
                    <button type="button" class="btn btn-info m-1" data-bs-dismiss="modal">Continue to Demo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- whatsapp modal start -->
    @if(helper::appdata(1)->contact != "")
    <input type="checkbox" id="check">
    <div class="whatsapp_icon {{session()->get('direction') == 2 ? 'whatsapp_icon_rtl' : 'whatsapp_icon_ltr'}}">
        <label class="chat-btn" for="check">
            <i class="fa-brands fa-whatsapp comment"></i>
            <i class="fa fa-close close"></i>
        </label>
    </div>

    <!--Start of Tawk.to Script-->
    @if (helper::appdata('')->tawk_on_off == 1 )
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src =
                    'https://embed.tawk.to/65d7258a9131ed19d9700056/{{ helper::appdata('')->tawk_widget_id }}';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    @endif
    <!--Start of Tawk.to Script-->
    
    <div class="{{session()->get('direction') == 2 ? 'wrapper_rtl' : 'wrapper'}}  wp_chat_box d-none">
        <div class="msg_header">
            <h6>{{ helper::appdata('')->website_title }}</h6>
        </div>
        <div class="text-start p-3 bg-msg">
            <div class="card p-2 msg">
                How can I help you ?
            </div>
        </div>
        <div class="chat-form">
        
            <form action="https://api.whatsapp.com/send" method="get" target="_blank" class="d-flex align-items-center d-grid gap-2">
                <textarea class="form-control" name="text" placeholder="Your Text Message"></textarea>
                <input type="hidden" name="phone" value="{{ helper::appdata('')->contact }}">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
    @endif
    <!-- whatsapp modal end -->




    <!-- Jquery Min js -->
    <script>
        let direction = "{{ session()->get('direction') }}";

    </script>

    <script src="{{url(env('ASSETSPATHURL').'landing/js/jquery.min.js')}}"></script>

    <!-- Bootstrap js -->

    <script src="{{url(env('ASSETSPATHURL').'landing/js/bootstrap.bundle.min.js')}}"></script>

    <!-- owl carousel js -->

    <script src="{{url(env('ASSETSPATHURL').'landing/js/owl.carousel.min.js')}}"></script>

    <!-- custom js -->

    <script src="{{url(env('ASSETSPATHURL').'landing/js/custom.js')}}"></script>

    @yield('scripts')

    <script>
        var areaurl = "{{ URL::to('admin/getarea') }}";
        var select = "{{ trans('landing.select_area') }}";
        var areaname = "{{ request()->get('area') }}";
        var env = "{{ env('Environment') }}";

        $('.whatsapp_icon').on("click",function(event)
        {  
            $(".wp_chat_box").toggleClass("d-none"); 
        });

        // if (env == "sendbox") {
        //     $(window).on("load", function () {
        //         "use strict";
        //         var info = localStorage.getItem("info-show");
        //         if (info != 'yes') {
        //             jQuery("#demo-modal").modal('show');
        //             localStorage.setItem("info-show", 'yes');
        //         }
        //     });
        // }
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ helper::appdata(1)->tracking_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ helper::appdata(1)->tracking_id }}');
        </script>

    
</body>