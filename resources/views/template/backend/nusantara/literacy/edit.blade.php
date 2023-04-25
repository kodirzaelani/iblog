@extends('template.backend.nusantara.layouts.appb')
@section('title', 'Literacy Edit')

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
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.literacies.index') }}">All Literacy</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit a literacy</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
<section class="content">
    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.literacies.update', $literacy) }}"  method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Edit a Literacy
                            {{-- <small>Advanced and full of features</small> --}}
                        </h4>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="form-group">
                            <h5>Title <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $literacy->title  }}" placeholder="Title" required>
                            </div>
                            @error('title')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">URL Content <span class="text-danger">*</span></label>
                            <textarea  rows="5" cols="80" class="form-control @error('urlcontent') is-invalid @enderror" name="urlcontent" >{{  old('urlcontent') ?? $literacy->urlcontent  }}</textarea>
                            <small>Example : file/d/0B8TiTqB1Sz_5ZUFZOFFCWGdUWk0/preview?resourcekey=0-tLJ0mPL_xz6diUFSzGf7Vw</small>
                            @error('urlcontent')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <h5>ID File Download </h5>
                            <div class="controls">
                                <input type="text" name="linkdownload" class="form-control @error('linkdownload') is-invalid @enderror" value="{{ old('linkdownload') ?? $literacy->linkdownload}}" placeholder="ID File" >
                            </div>
                            <small>Example : 0B8TiTqB1Sz_5ZUFZOFFCWGdUWk0</small>
                            @error('linkdownload')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea id="editor1"  rows="10" cols="80" class="form-control @error('content') is-invalid @enderror" name="content" >{{  old('content') ?? $literacy->content  }}</textarea>
                            @error('content')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Current Content</label>
                            @if ($literacy->urlcontent)
                            <div class="box border-0 rounded-lg shadow-sm">
                                <div class="text-center box-body">
                                    <iframe src="https://drive.google.com/{{ $literacy->urlcontent }}" width="540" height="480" allow="autoplay"></iframe>
                                </div>
                            </div>
                        @endif
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
                    <div class="box-body">
                        <div class="form-group row">
                            <label for="status">
                                Status :
                                @if ($literacy->status == 1)
                                <font style="color: rgb(18, 168, 13)">Publish</font>
                                @else
                                <font style="color: rgb(58, 40, 224)"> Draft</font>
                                @endif
                            </label>
                        </div>
                        <div class="form-group row">
                            <label class="form-label">Comments :</label>
                            <div class="c-inputs-stacked">
                                <input {{$literacy->comment_status == 1 ? "checked" : ""}} value= "1" name="comment_status" type="radio" id="radio_35" class="with-gap radio-col-success"  />
                                <label for="radio_35">Active</label>
                                <input {{$literacy->comment_status == 0 ? "checked" : ""}} value= "0" name="comment_status" type="radio" id="radio_36" class="with-gap radio-col-success" />
                                <label for="radio_36">Inactive</label>
                            </div>
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
                            Literacy Category
                        </h4>
                    </div>

                    <div class="box-body">
                        <div class="form-group @error('literacycategory_id') has-error @enderror">
                            <label class="form-label">Literacy Category <span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" name="literacycategory_id">
                                <option value="" holder>Select Literacy Category</option>
                                @foreach ($literacycategories as $item)
                                <option value="{{ $item->id }}" {{ (old('literacycategory_id') == $item->id ? 'selected': '') }}
                                    @if($item->id == $literacy->literacycategory_id)
                                    selected
                                    @endif>
                                    {{ $item->title }}
                                </option>
                                @endforeach
                            </select>
                            @error('literacycategory_id')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="form-group @error('literacysubcategory_id') has-error @enderror">
                            <label class="form-label">Literacy Sub Category </label>
                            <select class="form-control select2" style="width: 100%;" name="literacysubcategory_id" id="literacysubcategory_id" disabled>
                                <option value="" holder>Select Literacy Category</option>
                                @foreach ($literacysubcategories as $item)
                                <option value="{{ $item->id }}" {{ (old('literacysubcategory_id') == $item->id ? 'selected': '') }}
                                    @if($item->id == $literacy->literacysubcategory_id)
                                    selected
                                    @endif
                                    >{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('literacysubcategory_id')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">
                            Cover Image
                        </h4>
                    </div>
                    <div class="box-body  ">
                        <div class="form-group text-center">
                            <div class=" fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                    <img src="{{ ($literacy->imageThumbUrl) ? $literacy->imageThumbUrl : '/assets/images/no_image.png' }}"  alt="...">
                                    {{-- <img src="{{ asset('/assets/images/no_image.png') }}"  alt="..."> --}}
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
                        <div class="form-group">
                            <label for="caption_image">Caption Cover</label>
                            <textarea name="caption_image" id="caption_image" class="form-control @error('caption_image') is-invalid @enderror" placeholder="Caption Image" >{{ old('caption_image') ?? $literacy->caption_image }}</textarea>
                            @error('caption_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="literacycategory_id"]').on('change', function(){
            var literacycategory_id = $(this).val();
            if(literacycategory_id) {
                $.ajax({
                    url: "{{  url('/backend/get/literacysubcategory/') }}/"+literacycategory_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        $("#literacysubcategory_id").empty();
                        $("#literacysubcategory_id").removeAttr("disabled")
                        $.each(data,function(key,value){
                            $("#literacysubcategory_id").append('<option value="'+value.id+'">'+value.title+'</option>');
                        });
                        //  console.log(data)
                    },

                });
            } else {
                alert('danger');
            }
        });
    });
</script>
@endpush
@endsection
