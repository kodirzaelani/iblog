@extends('template.backend.nusantara.layouts.appb')

@section('title', 'Edit User')
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
                        <li class="breadcrumb-item" aria-current="page">Edit User</li>
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
                    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input
                                    name="name"
                                    type="text"
                                    required
                                    value="{{ old('name') ?? $user->name }}"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter a Your full name">
                                    @error('name')
                                     <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
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
                                    value="{{ old('email') ?? $user->email }}"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter a user email">
                                    @error('email')
                                     <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input
                                    name="username"
                                    type="text"

                                    value="{{ old('username') ?? $user->username }}"
                                    class="form-control @error('username') is-invalid @enderror" placeholder="Enter a username">
                                    @error('username')
                                     <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="celuller_no">Whatapps</label>
                                    <input
                                    name="celuller_no"
                                    type="text"
                                    value="{{ old('celuller_no') ?? $user->celuller_no}}"
                                    class="form-control @error('celuller_no') is-invalid @enderror" placeholder="Enter a Whatapps">
                                    @error('celuller_no')
                                     <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                @if ($user->masterstatus == config('cms.default_masteruser'))
                                <div class="form-group">
                                    <label class="form-label">Status : {!! $user->statustext !!}</label>
                                    <input type="text" name="status" value= "1" hidden>
                                </div>
                                @else
                                <div class="form-group">
                                    <label class="form-label">Status :</label>
                                    <div class="demo-radio-button">
                                        <input {{$user->status == 1 ? "checked" : ""}} value= "1" name="status" type="radio" id="radio_30" class="with-gap radio-col-success" checked />
                                        <label for="radio_30">Active</label>
                                        <input {{$user->status == 0 ? "checked" : ""}} value= "0" name="status" type="radio" id="radio_32" class="with-gap radio-col-success" />
                                        <label for="radio_32">Inactive</label>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                @if ($user->masterstatus == config('cms.default_masteruser'))
                                <div class="form-group">
                                    <label class="form-label">Role : <span class="fw-bold">Superadmin</span></label>
                                    @foreach ($roles as $role)
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="check-{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }} hidden>
                                    @endforeach
                                </div>
                                @else
                                <div class="form-group">
                                    <label class="font-weight-bold">ROLE : <span class="text-danger">*</span></label><br/>

                                    @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}"
                                            id="check-{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="check-{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
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
                                    <label for="password">New Password</label>
                                    <input
                                    name="password"
                                    type="password"
                                    value="{{ old('password') }}"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Enter a user password">
                                    @error('password')
                                     <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password_confirmation">New Password Confirmation</label>
                                    <input name="password_confirmation" type="password" value="{{ old('password_confirmation') }}" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Enter a user password confirmation">
                                    @error('password_confirmation')
                                     <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                            </div>
                            @if ($user->masterstatus == config('cms.default_masteruser'))
                            <div class="form-group">
                                <label for="current_password_for_password">Current Password <span class="text-danger">*</span></label>
                                <input name="current_password_for_password" type="password" class="form-control @error('current_password_for_password') is-invalid @enderror" placeholder="Current Password" />
                                <span class="form-text text-muted">Your Password <code>in system</code></span>
                                @error('current_password_for_password')
                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>
                            @endif
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
