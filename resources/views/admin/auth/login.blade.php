@extends('admin.layout.auth_default')
@section('content')

<body class="bg-white">
    <div class="wrapper">
        <section>
            <div class="row justify-content-center align-items-center g-0 h-100vh">
                <div class="col-lg-6 col-12 bg-white">
                    <div class="row horizontal-schroll g-0 vh-100 d-flex justify-content-center align-items-center">
                        <div class="col-md-8 col-lg-10 col-xl-7">
                            <div class="card overflow-hidden border-0 w-100 bg-transparent">
                                <div class="card-body pt-4">
                                    <h4 class="fw-bold text-dark fs-1 pb-0 mb-0">{{ trans('labels.welcome_back') }}</h4>
                                    @if (helper::appdata('')->vendor_register == 1)
                                    <div class="d-flex align-items-center py-3">
                                        <p class="fs-7 text-center fw-500 text-muted">{{ trans('labels.dont_have_account') }}</p>
                                        <a href="{{ URL::to('admin/register') }}" class="text-primary fw-semibold px-1">{{ trans('labels.register') }}</a>
                                    </div>
                                    @endif
                                    <form class="my-3" method="POST" action="{{ URL::to('admin/checklogin-normal') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="email" class="form-label">{{ trans('labels.email') }}<span class="text-danger"> * </span></label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="{{ trans('labels.email') }}" required>
                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="form-label">{{ trans('labels.password') }}<span class="text-danger"> * </span></label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="{{ trans('labels.password') }}" required>
                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="text-end mb-1">
                                            <a href="{{ URL::to('admin/forgot_password?redirect=admin') }}" class="fs-8 fw-600">
                                                <i class="fa-solid fa-lock-keyhole mx-2 fs-7"></i>{{ trans('labels.forgot_password') }}?
                                            </a>
                                        </div>
                                        <div class="row align-items-center g-2">
                                            <div class="">
                                                <button class="btn btn-primary mt-2 w-100" type="submit">{{ trans('labels.login') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                    @if (env('Environment') == 'sendbox')
                                    <div class="form-group mt-3">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Admin<br>admin@gmail.com</td>
                                                    <td>123456</td>
                                                    <td><button class="btn btn-info btn-sm" onclick="fillData('admin@gmail.com','123456')">{{ trans('labels.copy') }}</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Vendor<br>theme1@yopmail.com</td>
                                                    <td>123456</td>
                                                    <td><button class="btn btn-info btn-sm" onclick="fillData('theme1@yopmail.com','123456')">{{ trans('labels.copy') }}</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row align-items-center g-2">
                                        @if (env('Environment') == 'sendbox')
                                        <div class="col-4">
                                            <a class="btn btn-dark mt-2 w-100" href="{{ URL::to('/chicken-store') }}" target="_blank">Chicken Shop</a>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-dark mt-2 w-100" href="{{ URL::to('/the-pizza') }}" target="_blank">The Pizza</a>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-dark mt-2 w-100" href="{{ URL::to('/burger-shop') }}" target="_blank">Burger Shop</a>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-dark mt-2 w-100" href="{{ URL::to('/cake-shop') }}" target="_blank">Cake Shop</a>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-dark mt-2 w-100" href="{{ URL::to('/cafe-amore') }}" target="_blank">Cafe Amore</a>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-dark mt-2 w-100" href="{{ URL::to('/scoop-haven') }}" target="_blank">Scoop Haven</a>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-dark mt-2 w-100" href="{{ URL::to('/bar-bliss') }}" target="_blank">Bar Bliss</a>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-dark mt-2 w-100" href="{{ URL::to('/the-kitchens') }}" target="_blank">The Kitchens</a>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-dark mt-2 w-100" href="{{ URL::to('/tea-shop') }}" target="_blank">Tea Shop</a>
                                        </div>
                                        <div class="col-12">
                                            <a class="btn btn-dark mt-2 w-100" href="{{ URL::to('/the-chocolate') }}" target="_blank">The Chocolate</a>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    {{-- @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)

                                    @if(@helper::appdata('')->google_login == 1 || @helper::appdata('')->facebook_login == 1)
                                    <div class="d-flex align-items-center my-3 m-auto">
                                        <div class="line"></div>
                                        <p class="text-center mx-2 fs-7 m-0 fw-600">OR</p>
                                        <div class="line"></div>
                                    </div>
                                    @endif

                                    
                                    <div class="d-grid gap-2 d-flex justify-content-start social-icon mt-3">
                                        @if(@helper::appdata('')->google_login == 1)
                                        <a class="btn icon-btn-google w-100 btn-outline-primary bg-white" type="button" @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else href="{{ URL::to('admin/login/google-vendor') }}" @endif>
                                            <img src="storage/app/public/admin-assets/images/about/google.svg" alt="">
                                            <span class="px-2 text-dark">{{ trans('labels.google') }}</span>
                                        </a>
                                        @endif
                                        @if(@helper::appdata('')->facebook_login == 1)
                                        <a class="btn btn-outline-primary bg-white icon-btn-facebook w-100" type="button" @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else href="{{ URL::to('admin/login/facebook-vendor') }}" @endif>
                                            <img src="storage/app/public/admin-assets/images/about/facebook.svg" alt="">
                                            <span class="px-2 text-dark">{{ trans('labels.facebook') }}</span>
                                        </a>
                                        @endif
                                    </div>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 d-none d-lg-block">
                    <div class="vh-100 d-flex justify-content-center align-items-center m-auto">
                        <img src="{{url(env('ASSETSPATHURL').'admin-assets/images/about/login.jpg')}}" alt="" class="formimg">
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection
    @section('scripts')
    <script>
        function fillData(email, password) {
            "use strict";
            $('#email').val(email);
            $('#password').val(password);
        }
    </script>
    @endsection