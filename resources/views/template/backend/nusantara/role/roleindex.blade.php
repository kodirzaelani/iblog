@extends('template.backend.nusantara.layouts.appb')
@section('title', 'List of Role')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">@yield('title')</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Role</li>
                        {{-- <li class="breadcrumb-item active" aria-current="page"></li> --}}
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
@livewire('template.backend.nusantara.role.roleall')
@endsection
