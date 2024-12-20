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
    <div class="col-12 col-md-4">
        <h5 class="pages-title fs-2">{{ trans('labels.coupons') }}</h5>
        @include('admin.layout.breadcrumb')
    </div>
    <div class="col-12 col-md-4">
        <div class="d-flex justify-content-end">
            <a href="{{ URL::to('admin/coupons/add') }}" class="btn-add {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">
                <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}
            </a>
        </div>
    </div>
</div>
<div class="row mb-7">
    <div class="col-12 mb-lg-0">
        <div class="card border-0 box-shadow">
            <div class="card-body">
                <div class="table-responsive">
                    @include('admin.coupons.coupons_table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection