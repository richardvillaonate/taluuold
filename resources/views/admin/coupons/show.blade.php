@extends('admin.layout.default')
@php
    if(Auth::user()->type == 4)
    {
        $vendor_id = Auth::user()->vendor_id;
    }else{
        $vendor_id = Auth::user()->id;
    }
@endphp
@section('content')
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-12">
            <h5 class="pages-title fs-2">{{ trans('labels.edit') }}</h5>
            @include('admin.layout.breadcrumb')
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4 mb-lg-0">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/coupons/update-' . $cdata->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">{{ trans('labels.coupon_name') }}<span class="text-danger"> *
                                    </span></label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ trans('labels.enter_name') }}" name="name" id="name"
                                        value="{{ $cdata->name }}" required>
                                    @error('name')
                                    <span class="text-danger" id="name">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="code">{{ trans('labels.coupon_code') }}<span class="text-danger"> *
                                    </span></label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ trans('labels.enter_name') }}" name="code" id="code"
                                        value="{{ $cdata->code }}" required>
                                    @error('code')
                                    <span class="text-danger" id="code">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="price">{{ trans('labels.amount') }}<span class="text-danger"> *
                                    </span></label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ trans('labels.enter_price') }}" name="price" id="price"
                                        value="{{ $cdata->price }}" required>
                                    @error('price')
                                    <span class="text-danger" id="price">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="limit">{{ trans('labels.usage_limit') }}<span class="text-danger"> *
                                    </span></label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ trans('labels.limit_number') }}" name="limit" id="limit"
                                        value="{{ $cdata->limit }}" required>
                                    @error('limit')
                                    <span class="text-danger" id="limit">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="active_from">{{ trans('labels.start_date')
                                        }} <span class="text-danger"> *
                                    </span></label>
                                    <input type="date" class="form-control"
                                        placeholder="{{ trans('labels.enter_active_from') }}" name="active_from"
                                        id="active_from" value="{{ $cdata->active_from }}" required>
                                    @error('active_from')
                                    <span class="text-danger" id="active_from">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="active_to">{{ trans('labels.end_date')
                                        }} <span class="text-danger"> *
                                    </span></label>
                                    <input type="date" class="form-control"
                                        placeholder="{{ trans('labels.enter_active_to') }}" name="active_to"
                                        id="active_to" value="{{ $cdata->active_to }}" required>
                                    @error('active_to')
                                    <span class="text-danger" id="active_to">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-end">
                            <a type="button" class="btn btn-danger btn-cancel m-1" href="{{ route('coupons') }}"><i
                                    class="ft-x"></i> {{ trans('labels.cancel') }}</a>
                            <button class="btn btn-success btn-succes m-1 {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, $vendor_id, 'edit') == 1  ? '' : 'd-none') : '' }}" @if (env('Environment') == 'sendbox') type="button"
                                onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection