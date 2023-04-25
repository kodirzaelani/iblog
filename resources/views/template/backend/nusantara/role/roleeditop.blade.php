@extends('template.backend.nusantara.layouts.appb')

@section('title', 'Edit Role')
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
<section class="content">

    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">
                        Update a Role
                    </h4>
                    <div class="box-controls pull-right">
                        <div class="box-header-actions ">
                            <a href="{{ route('backend.roles.index') }}" class="btn btn-sm btn-warning me-1 mb-2">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <form action="{{ route('backend.roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="box-body">
                        <div class="form-group">
                            <h5>Name <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" placeholder="Name" required>
                            </div>
                            @error('name')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <h5>Description</h5>
                            <div class="controls">
                                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $role->description) }}" placeholder="Name" >
                            </div>
                            @error('description')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">PERMISSIONS:</label><br/>
                            @foreach ($permissions as $permission)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->name }}"
                                id="check-{{ $permission->id }}"
                                @if($role->permissions->contains($permission)) checked @endif>
                                <label class="form-check-label" for="check-{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="box-footer text-end">
                        <a href="{{ route('backend.roles.index') }}" class="btn btn-warning me-1">
                            Cancel
                        </a>
                        <button id="publish-btn" type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </form>

            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection
