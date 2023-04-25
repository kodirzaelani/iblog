@extends('template.backend.nusantara.layouts.appb')
@section('title', 'List Post')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">Posts</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.posts.index') }}">All Post</a></li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
@livewire('template.backend.nusantara.post.postindex')
@endsection
