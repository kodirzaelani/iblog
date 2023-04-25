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
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.petugasjumat.index') }}">All petugas jumat</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit a petugas jumat</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
<section class="content">
    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.petugasjumat.update', $petugasjumat) }}"  method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Edit a petugas jumat
                            {{-- <small>Advanced and full of features</small> --}}
                        </h4>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">

                        <div class="form-group">
                            <h5>Title <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $petugasjumat->title  }}" placeholder="Title" required>
                            </div>
                            @error('title')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <h5>Khotib <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="title_khotib" class="form-control @error('title_khotib') is-invalid @enderror" value="{{ old('title_khotib')  ?? $petugasjumat->title_khotib }}" placeholder="Khotib" required>
                            </div>
                            @error('title_khotib')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <h5>Imam <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="title_imam" class="form-control @error('title_imam') is-invalid @enderror" value="{{ old('title_imam')  ?? $petugasjumat->title_imam  }}" placeholder="Imam" required>
                            </div>
                            @error('title_imam')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <h5>Muadzin <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="title_muadzin" class="form-control @error('title_muadzin') is-invalid @enderror" value="{{ old('title_muadzin')  ?? $petugasjumat->title_muadzin }}" placeholder="Muadzin" required>
                            </div>
                            @error('title_muadzin')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea id="editor1"  rows="10" cols="80" class="form-control @error('description') is-invalid @enderror" name="description" >{{  old('description') ?? $petugasjumat->description  }}</textarea>
                            @error('description')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="video">Video</label>
                            <input id="video" name="video" type="text" class="form-control @error('video') is-invalid @enderror" placeholder="Video" value="{{ old('video') ?? $petugasjumat->video }}">
                            <span class="font-italic"> Example ID Video on Youtube: DfMz1NMIVe4</span>
                            @error('video')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            @if ($petugasjumat->video)
                            <div class="box border-0 rounded-lg shadow-sm">
                                <div class="text-center box-body">
                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $petugasjumat->video }}"
                                        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box -->
                <div class="col-lg-4 col-12">
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Save
                                <small>Publish or Draft</small>
                            </h4>
                        </div>
                        <div class="box-body">
                            <div class="form-group row">
                                <label for="status">
                                    Status :
                                    @if ($petugasjumat->status == 1)
                                    <font style="color: rgb(18, 168, 13)">Publish</font>
                                    @else
                                    <font style="color: rgb(58, 40, 224)"> Draft</font>
                                    @endif
                                </label>
                            </div>
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
                                Periode
                            </h4>
                        </div>
                        <div class="box-body">
                            <div class="form-group row">
                                <label for="example-date-input" class="col-sm-4 col-form-label">Date <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="date" name="startdate" value="{{ old('startdate') ?? $petugasjumat->startdate}}" id="example-date-input">
                                </div>
                                @error('startdate')
                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="example-time-input" class="col-sm-4 col-form-label">Time <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="time" name="periode" value="{{ old('periode') ?? $petugasjumat->periode}}" id="example-time-input">
                                </div>
                                @error('periode')
                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">
                                    Attachmen <br>
                                    <span class="text-danger">Flayer / Brosur </span>
                                </h4>
                            </div>
                            <div class="box-body text-center ">
                                <div class="form-group">
                                    <div class=" fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                            <img src="{{ ($petugasjumat->imageThumbUrl) ? $petugasjumat->imageThumbUrl : '/assets/images/no_image.png' }}"  alt="...">
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
        <script src="{{ asset('') }}assets/vendor_components/ckeditor/ckeditor.js"></script>
        <script src="{{ asset('') }}assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>
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
