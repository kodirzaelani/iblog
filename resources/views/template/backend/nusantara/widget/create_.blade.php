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
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.widgets.index') }}">All Widget</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create a widget</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
<section class="content">
    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.widgets.store') }}" method="post">
        <div class="row">
            @csrf
            <div class="col-lg-8 col-12">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Create a Widget
                            {{-- <small>Advanced and full of features</small> --}}
                        </h4>
                    </div>
                    <!-- /.box-header -->

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
                            <label class="form-label">Position <span class="text-danger">*</span></label>
                            <div class="demo-radio-button in-line">
                                <input  name="position" value= "10" {{ old('position') == "10" ? 'checked' : '' }} type="radio" id="radio_18" class="@error('position') is-invalid @enderror with-gap radio-col-success" />
                                <label for="radio_18">Home Page</label>
                                <input  name="position" value= "20"{{ old('position') == "20" ? 'checked' : '' }} type="radio" id="radio_19" class="@error('position') is-invalid @enderror with-gap radio-col-success" />
                                <label for="radio_19">Sidebar Right </label>
                                @error('position')
                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Target View <span class="text-danger">*</span></label>
                            <div class="demo-radio-button in-line">
                                <input value= "_self" name="targetview" {{ old('targetview') == "_self" ? 'checked' : '' }} type="radio" id="radio_20" class="@error('targetview') is-invalid @enderror with-gap radio-col-success" />
                                <label for="radio_20">Self</label>
                                <input value= "_blank" name="targetview" {{ old('targetview') == "_blank" ? 'checked' : '' }} type="radio" id="radio_21" class="@error('targetview') is-invalid @enderror with-gap radio-col-success" />
                                <label for="radio_21">Blank </label>
                                @error('targetview')
                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Type Link <span class="text-danger">*</span></h5>
                            <div class="demo-radio-button in-line">
                                <input value= "1" name="typelink" {{ old('typelink') == "1" ? 'checked' : '' }} type="radio" id="radio_11" class="@error('typelink') is-invalid @enderror with-gap radio-col-primary" />
                                <label for="radio_11">Custome Link</label>
                                <input value= "2" name="typelink" {{ old('typelink') == "2" ? 'checked' : '' }} type="radio" id="radio_12" class="@error('typelink') is-invalid @enderror with-gap radio-col-primary" />
                                <label for="radio_12">Page </label>
                                <input value= "3" name="typelink" {{ old('typelink') == "3" ? 'checked' : '' }} type="radio" id="radio_13" class="@error('typelink') is-invalid @enderror with-gap radio-col-primary" />
                                <label for="radio_13">Category Blog</label>
                                @error('typelink')
                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group 1 boxlink">
                            <h5>Link <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="link" value="{{ old('link') }}" class="form-control @error('link') is-invalid @enderror" placeholder="Link" required>
                            </div>
                            @error('link')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>

                        <div class="form-group @error('link') has-error @enderror 2 boxlink">
                            <label class="form-label">Link   <span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" name="link" required>
                                <option value="" holder>Select Page </option>
                                @foreach ($pages as $item)
                                <option value="page/detail/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                @endforeach
                            </select>
                            @error('link')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>

                        <div class="form-group @error('link') has-error @enderror 3 boxlink">
                            <label class="form-label">Link  <span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" name="link" required>
                                <option value="" holder>Select Blog Category </option>
                                <option value="blog" holder>All Blog </option>
                                @foreach ($postcategory as $item)
                                @if ($item->posts->where('status', 1)->count() > 0)
                                <option value="blog/category/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                @endif
                                @endforeach
                            </select>
                            @error('link')
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
                            Image <span class="text-danger">*</span>
                        </h4>
                    </div>
                    <div class="box-body text-center ">
                        <label class="form-label">Size : 1Mb</label>
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
<style>
    .boxlink{
        /* display: none; */

    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('') }}assets/vendor_plugins/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
<script src="{{ asset('') }}assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{ asset('') }}assets/vendor_components/select2/dist/js/select2.full.js"></script>
{{-- <script src="{{ asset('') }}assets/backend/js/pages/editor.js"></script> --}}

<script>
    $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            var inputValue = $(this).attr("value");
            var targetBox = $("." + inputValue);
            $(".boxlink").not(targetBox).hide();
            $(targetBox).show();
        });
    });
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
