@extends('template.backend.nusantara.layouts.appb')
@section('title', $title)

@section('content')
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">@yield('title')</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.widgets.index') }}">All Widget</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create a widget</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
    @livewire('template.backend.nusantara.widget.create')
@endsection
