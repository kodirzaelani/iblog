@extends('template.backend.nusantara.layouts.appb')
@section('title', $title)

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
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.organizations.index') }}">All </a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit a unit</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
<section class="content">
    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.organizations.update', $organization) }}"  method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Edit a unit
                            {{-- <small>Advanced and full of features</small> --}}
                        </h4>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="form-group">
                            <h5>Title <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $organization->title  }}" placeholder="Title" required>
                            </div>
                            @error('title')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <h5>Singkatan <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="singkatan" class="form-control @error('singkatan') is-invalid @enderror" value="{{ old('singkatan') ?? $organization->singkatan  }}" placeholder="Singkatan" required>
                            </div>
                            @error('singkatan')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group @error('pergub_id') has-error @enderror">
                            <label class="form-label">SK Gubernur <span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" name="pergub_id">
                                <option value="" holder>Select SK Gubernur</option>
                                @foreach ($pergubs as $item)
                                <option value="{{ $item->id }}" {{ (old('pergub_id') == $item->id ? 'selected': '') }}
                                    @if($item->id == $organization->pergub_id)
                                    selected
                                    @endif>
                                    {{ $item->year }} | {{ $item->title }}
                                </option>
                                @endforeach
                            </select>
                            @error('pergub_id')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea id="editor1"  rows="10" cols="80" class="form-control @error('description') is-invalid @enderror" name="description" >{{  old('description') ?? $organization->description  }}</textarea>
                            @error('description')
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
                            <small>Publish or Draft</small>
                        </h4>
                    </div>
                    <div class="box-footer text-end">
                        <input type="text" name="status" id="status" hidden>
                        <button id="draft-btn" type="submit"  class="btn btn-warning me-1">
                            Draft
                        </button>
                        <button id="publish-btn" type="submit"class="btn btn-primary">
                            Publish
                        </button>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">
                            Parent
                        </h4>
                    </div>

                    <div class="box-body">

                        <div class="form-group @error('parent_id') has-error @enderror">
                            <label class="form-label">Parent <span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" name="parent_id">
                                <option value="" holder>Select Parent</option>
                                @foreach ($strukturorganisasi as $item)
                                <option value="{{ $item->id }}" {{ (old('parent_id') == $item->id ? 'selected': '') }}
                                    @if($item->id == $organization->parent_id)
                                    selected
                                    @endif>
                                    {{ $item->title }}
                                </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <h5>Urutan <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="number" name="urut" class="form-control @error('urut') is-invalid @enderror" value="{{ old('urut') ?? $organization->urut }}" placeholder="Urutan" required>
                            </div>
                            @error('urut')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">
                            Feature Logo
                        </h4>
                    </div>
                    <div class="box-body text-center ">
                        <div class="form-group">
                            <div class=" fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                    <img src="{{ ($organization->imageThumbUrl) ? $organization->imageThumbUrl : '/assets/images/no_image.png' }}"  alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px;"></div>
                                <div>
                                    <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                    <input type="file" class="@error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}"></span>
                                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                            @error('logo')
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
<script src="{{ asset('') }}assets/vendor_components/ckeditor/ckeditor.js"></script>
<script src="{{ asset('') }}assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>
{{-- <script src="{{ asset('') }}assets/backend/js/organizations/editor.js"></script> --}}
<script>
    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };
</script>
<script>
    CKEDITOR.replace('editor1', options);
    //Initialize Select2 Elements
    $('.select2').select2();

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
