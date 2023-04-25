@extends('template.backend.nusantara.layouts.appb')
@section('title', $title)

@section('content')
<!-- Content Header (Foto header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">@yield('title')</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.download.downloadindex') }}">All Page</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create a dowload</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
<section class="content">
    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.download.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-12">
                    <div class="box bs-3 border-success">
                            <div class="box-header">
                                <h4 class="box-title"><strong>Create</strong></h4>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <h5>Title <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Title" required>
                                    </div>
                                    @error('title')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="urlcontent">URL  Content</label>
                                    <textarea name="urlcontent" id="urlcontent" rows="5" class="form-control  @error('urlcontent') is-invalid @enderror" placeholder="URL  Content" >{{ old('urlcontent') }}</textarea>
                                    <small>Example : file/d/0B8TiTqB1Sz_5ZUFZOFFCWGdUWk0/preview?resourcekey=0-tLJ0mPL_xz6diUFSzGf7Vw</small>
                                    @error('urlcontent')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h5>ID File Download </h5>
                                    <div class="controls">
                                        <input type="text" name="linkdownload" class="form-control @error('linkdownload') is-invalid @enderror" value="{{ old('linkdownload') }}" placeholder="ID File" >
                                    </div>
                                    <small>Example : 0B8TiTqB1Sz_5ZUFZOFFCWGdUWk0</small>
                                    @error('linkdownload')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea id="editor1"  rows="10" cols="80" class="form-control @error('description') is-invalid @enderror" name="description" >{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                            </div>


                    </div>
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
                        <a class="btn btn-sm btn-info me-2" href="{{ route('backend.download.downloadindex') }}"><i class="fa fa-undo" aria-hidden="true"></i> Cancel</a>
                        <button id="draft-btn" type="submit"  class="btn-sm btn btn-warning me-2">
                            Draft
                        </button>
                        <button id="publish-btn" type="submit"class="btn-sm btn btn-primary">
                            Publish
                        </button>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">
                            Category <span class="text-danger">*</span>
                        </h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group form-group-float">
                            <select  name="downloadcategory_id" class="form-select @error('downloadcategory_id') is-invalid @enderror">
                                <option value="" selected>Select Category</option>
                                @foreach ($downloadcategories as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach

                            </select>
                            @error('downloadcategory_id')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">
                            Attachment <span class="text-danger">*</span>
                        </h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="form-label">File <span class="text-danger">PDF</span></label>
                            <label class="file">
                                <input type="file" name="attach" @error('attach') is-invalid @enderror" id="file">
                            </label>
                            @error('attach')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
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
{{-- <script src="{{ asset('') }}assets/backend/js/pages/editor.js"></script> --}}
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
