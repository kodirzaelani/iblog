@extends('template.backend.nusantara.layouts.appb')
@section('title', 'Structure Menu Item')
@section('content')
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">Menu Items</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.menuitem.index') }}">All Menu Item</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12 col-12">
            <div class="box box-bordered border-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">@yield('title')</h4>
                    <ul class="box-controls pull-right">
                        <li><button  class="btn btn-success" >Structure</button></li>|
                        <li><a href="{{ route('backend.menuitem.index') }}" class="btn btn-primary" style="margin:0 4px; padding: 0 4px; vertical-align: middle; font-size: 0.8571rem; font-weight: 400;">List Menu Item</a></li>
                    </ul>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                            {!! Menu::render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('styles')
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
{{-- <link href="{{asset('vendor/nguyendachuy-menu/style.css')}}" rel="stylesheet"> --}}
@endpush
@push('scripts')
<!-- Menu Js -->
    {!! Menu::scripts() !!}
@endpush
