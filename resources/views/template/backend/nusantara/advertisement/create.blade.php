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
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}"><i
                                        class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a
                                    href="{{ route('backend.advertisements.index') }}">All Page</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create a advertisement</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.advertisements.store') }}"
            method="post">
            <div class="row">
                @csrf
                <div class="col-lg-8 col-12">
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Create a advertisement
                                {{-- <small>Advanced and full of features</small> --}}
                            </h4>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <h5>Title <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}" placeholder="Title" required>
                                </div>
                                @error('title')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Position :</label>
                                <div class="demo-radio-button">
                                    <input value="1" name="position" type="radio" id="radio_30"
                                        class="with-gap radio-col-success" checked />
                                    <label for="radio_30">Home Top</label>
                                    <input value="2" name="position" type="radio" id="radio_32"
                                        class="with-gap radio-col-success" />
                                    <label for="radio_32">Home Midle</label>
                                    <input value="3" name="position" type="radio" id="radio_33"
                                        class="with-gap radio-col-success" />
                                    <label for="radio_33">Home Bottom</label>
                                    <input value="4" name="position" type="radio" id="radio_34"
                                        class="with-gap radio-col-success" />
                                    <label for="radio_34">Sidebar Right Top</label>
                                    <input value="5" name="position" type="radio" id="radio_35"
                                        class="with-gap radio-col-success" />
                                    <label for="radio_35">Sidebar Right Midle</label>
                                    <input value="6" name="position" type="radio" id="radio_36"
                                        class="with-gap radio-col-success" />
                                    <label for="radio_36">Sidebar Right Bottom</label>
                                    <input value="7" name="position" type="radio" id="radio_37"
                                        class="with-gap radio-col-success" />
                                    <label for="radio_37">Sidebar Left Top</label>
                                    <input value="8" name="position" type="radio" id="radio_38"
                                        class="with-gap radio-col-success" />
                                    <label for="radio_38">Sidebar Left Midlle</label>
                                    <input value="9" name="position" type="radio" id="radio_39"
                                        class="with-gap radio-col-success" />
                                    <label for="radio_39">Sidebar Left Bottom</label>
                                </div>
                                @error('position')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Link HTML </label>
                                <textarea rows="10" cols="80" class="form-control @error('scripthtml') is-invalid @enderror"
                                    name="scripthtml">{{ old('scripthtml') }}</textarea>
                                @error('scripthtml')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="linkimage">Link URL</label>
                                <input id="linkimage" name="linkimage" type="text"
                                    class="form-control @error('linkimage') is-invalid @enderror"
                                    placeholder="Link untuk gambar" value="{{ old('linkimage') }}">
                                <span class="font-italic"> Example: https://www.youtube.com/embed/DfMz1NMIVe4</span>
                                @error('linkimage')
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
                            <button id="draft-btn" type="submit" class="btn btn-warning me-1">
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
                                Advertisement Image <span class="text-danger">*</span>
                            </h4>
                        </div>
                        <div class="box-body text-center ">
                            <label class="form-label">Size : 1920 pixel x 1088 pixel</label>
                            <div class="form-group">
                                <div class=" fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                        <img src="{{ asset('/assets/images/no_image.png') }}" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists img-thumbnail"
                                        style="max-width: 200px;"></div>
                                    <div>
                                        <span class="btn btn-outline-secondary btn-file"><span
                                                class="fileinput-new">Select image</span><span
                                                class="fileinput-exists">Change</span>
                                            <input type="file" class="@error('image') is-invalid @enderror"
                                                name="image" value="{{ old('image') }}"></span>
                                        <a href="#" class="btn btn-outline-secondary fileinput-exists"
                                            data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                                @error('image')
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
        <link rel="stylesheet"
            href="{{ asset('') }}assets/vendor_plugins/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
    @endpush

    @push('scripts')
        <script src="{{ asset('') }}assets/vendor_plugins/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
        <script src="{{ asset('') }}assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
        <script src="{{ asset('') }}assets/vendor_components/select2/dist/js/select2.full.js"></script>
        <script src="{{ asset('') }}assets/vendor_components/ckeditor/ckeditor.js"></script>
        <script src="{{ asset('') }}assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>
        <script src="{{ asset('') }}assets/backend/js/pages/editor.js"></script>
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
        </script>
    @endpush
@endsection
