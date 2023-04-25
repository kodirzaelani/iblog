@extends('template.backend.nusantara.layouts.appb')

@section('title', 'Create User')
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
                        <li class="breadcrumb-item" aria-current="page">Create User</li>
                        {{-- <li class="breadcrumb-item active" aria-current="page"></li> --}}
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
{{-- @livewire('template.backend.nusantara.user.usercreate') --}}
<section class="content">
    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12 col-12">
            <div class="box box-bordered border-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">@yield('title')</h4>
                </div>
                <div class="box-body">
                    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.users.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input
                                    name="name"
                                    type="text"
                                    required
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter a Your full name">
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input
                                    name="email"
                                    type="email"
                                    required
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter a user email">
                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input
                                    name="username"
                                    type="text"

                                    value="{{ old('username') }}"
                                    class="form-control @error('username') is-invalid @enderror" placeholder="Enter a username">
                                    @error('username')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="celuller_no">Whatapps</label>
                                    <input
                                    name="celuller_no"
                                    type="text"
                                    value="{{ old('celuller_no') }}"
                                    class="form-control @error('celuller_no') is-invalid @enderror" placeholder="Enter a Whatapps">
                                    @error('celuller_no')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">ROLE : <span class="text-danger">*</span></label><br/>

                                    @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="roles[]"  value="{{ $role->name }}" id="check-{{ $role->id }}">
                                        <label class="form-check-label" for="check-{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Kecamatan </label>
                                    <select class="form-control form-control" name="selectedDistrict">
                                        <option value="">Pilih Kecamatan</option>
                                        @foreach ($district as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if ($selectedDistrict != 0 && !is_null($selectedDistrict))
                                <div class="form-group">
                                    <label for="whatapps">Sekolah</label>
                                    <select class="form-control form-control" name="selectedSekolah">
                                        <option value="">Pilih Sekolah</option>
                                        @foreach ($sekolah as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div> --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input
                                    name="password"
                                    type="password"
                                    required
                                    value="{{ old('password') }}"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Enter a user password">
                                    @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password_confirmation">Password Confirmation <span class="text-danger">*</span></label>
                                    <input
                                    name="password_confirmation"
                                    type="password"
                                    required
                                    value="{{ old('password_confirmation') }}"
                                    class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Enter a user password confirmation">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
