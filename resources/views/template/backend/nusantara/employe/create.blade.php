@extends('template.backend.nusantara.layouts.appb')

@section('title', 'Create Officer')
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
                        <li class="breadcrumb-item"><a href="{{ route('backend.employes.index') }}">Officer list</a></li>
                        <li class="breadcrumb-item" aria-current="page">Create Officer</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
<section class="content">
    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.employes.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Create a Employe
                        </h4>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Full Name <span class="text-danger">*</span></label>
                            <input
                            name="name"
                            type="text"
                            required
                            value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter a full name">
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nik">NIK <span class="text-danger">*</span></label>
                                    <input
                                    name="nik"
                                    type="text"
                                    required
                                    value="{{ old('nik') }}"
                                    class="form-control @error('nik') is-invalid @enderror" placeholder="Enter a employe nik">
                                    @error('nik')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
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
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="birth_place">Birth Place</label>
                                    <input
                                    name="birth_place"
                                    type="text"
                                    value="{{ old('birth_place') }}"
                                    class="form-control @error('birth_place') is-invalid @enderror" placeholder="Enter a Birth Place">
                                    @error('birth_place')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="example-date-input" >Birth Date <span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" name="birth_date" value="{{ old('birth_date') }}" id="example-date-input">
                                    @error('birth_date')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-12">
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
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input
                                    name="email"
                                    type="email"
                                    required
                                    value="{{ old('email') }}"
                                    class="text-lowercase form-control @error('email') is-invalid @enderror" placeholder="Enter a employe email">
                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <div class="form-group @error('gender') has-error @enderror">
                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="gender">
                                        <option value="" holder>Select Gender</option>
                                        <option value="L" {{ (old('gender') == 'L' ? 'selected': '') }}>Laki-laki</option>
                                        <option value="P" {{ (old('gender') == 'P' ? 'selected': '') }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                    <span class="help-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group @error('agama_id') has-error @enderror">
                                    <label class="form-label">Religi <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="agama_id">
                                        <option value="" holder>Select Religi</option>
                                        @foreach ($religions as $item)
                                        <option value="{{ $item->agamaid }}" {{ (old('agama_id') == $item->agamaid ? 'selected': '') }}>{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('agama_id')
                                    <span class="help-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group @error('jenjangpendidikan_id') has-error @enderror">
                                    <label class="form-label">Education <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="jenjangpendidikan_id">
                                <option value="" holder>Select Education</option>
                                @foreach ($educations as $item)
                                        <option value="{{ $item->id }}" {{ (old('jenjangpendidikan_id') == $item->id ? 'selected': '') }}>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenjangpendidikan_id')
                                    <span class="help-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <label for="department">Education Department <span class="text-danger">*</span></label>
                                <input
                                name="department"
                                type="text"
                                value="{{ old('department') }}"
                                class="form-control @error('department') is-invalid @enderror" placeholder="Department">
                                @error('department')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        <div class="form-group">
                            <label for="family">Family <span class="text-danger">*</span></label>
                            <input
                            name="family"
                            type="text"
                            value="{{ old('family') }}"
                            class="form-control @error('family') is-invalid @enderror" placeholder="Family">
                            @error('family')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phonefamily">Phone Family <span class="text-danger">*</span></label>
                            <input
                            name="phonefamily"
                            type="text"
                            value="{{ old('phonefamily') }}"
                            class="form-control @error('phonefamily') is-invalid @enderror" placeholder="Phone Family">
                            @error('phonefamily')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('statusfamily') has-error @enderror">
                            <label class="form-label">Status family <span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" name="statusfamily">
                                <option value="" holder>Select status family</option>
                                <option value="1" {{ (old('statusfamily') == '1' ? 'selected': '') }}>Suami</option>
                                <option value="2" {{ (old('statusfamily') == '2' ? 'selected': '') }}>Istri</option>
                                <option value="3" {{ (old('statusfamily') == '3' ? 'selected': '') }}>Saudara</option>
                            </select>
                            @error('statusfamily')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea id="editor1"  rows="3" cols="80" class="form-control @error('address') is-invalid @enderror" name="address" >{{ old('address') }}</textarea>
                            @error('address')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>

                    </div>

                </div>
                <!-- /.box -->
            </div>
            <div class="col-lg-4 col-12">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Save
                            <small>Create</small>
                        </h4>
                    </div>
                    <div class="box-body">
                            <div class="form-group">
                                <label for="password">Password : <span class="text-danger fs-16">KaltimBerdaulat!</span></label>
                            </div>
                    </div>
                    <div class="box-footer text-end">
                        <input type="text" name="status" id="status" hidden>
                        <a href="{{route('backend.employes.index')}}" class="btn btn-sm btn-info me-1">Back</a>
                        <button id="draft-btn" type="submit"  class="btn btn-sm btn-warning me-1">
                            Draft
                        </button>
                        <button id="publish-btn" type="submit" class="btn btn-sm btn-primary">
                            Save
                        </button>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">
                            Image
                        </h4>
                    </div>
                    <div class="box-body text-center ">
                        <div class="form-group">
                            <div class=" fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                    <img src="{{ asset('/assets/images/no_image.png') }}"  alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px;"></div>
                                <div>
                                    <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                    <input type="file" class="@error('image') is-invalid @enderror" name="image" value="{{ old('image') }}"></span>
                                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                            @error('image')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</section>

@push('styles')
<!-- Jasny Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('') }}assets/vendor_plugins/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
@endpush

@push('scripts')
<script src="{{ asset('') }}assets/vendor_plugins/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
<script src="{{ asset('') }}assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{ asset('') }}assets/vendor_components/select2/dist/js/select2.full.js"></script>

<script>

    //Save Draft
    $('#draft-btn').click(function(e) {
        e.preventDefault();
        $('#status').val(0);
        $('#post-form').submit();
    });
    //Save Publish
    $('#publish-btn').click(function(e) {
        e.preventDefault();
        $('#status').val(1);
        $('#post-form').submit();
    });

</script>
@endpush
@endsection
