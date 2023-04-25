@extends('template.backend.nusantara.layouts.appb')
@section('title', 'Post Edit')

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
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.posts.index') }}">All Post</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit a post</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
<section class="content">
    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.posts.update', $post) }}"  method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Edit a Post
                            {{-- <small>Advanced and full of features</small> --}}
                        </h4>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="form-group">
                            <h5>Title <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $post->title  }}" placeholder="Title" required>
                            </div>
                            @error('title')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label class="form-label">Headline :</label>
                            <div class="demo-radio-button">
                                <input {{$post->headline == 0 ? "checked" : ""}} value= "0" name="headline" type="radio" id="radio_32" class="with-gap radio-col-success" />
                                <label for="radio_32">Inactive</label>
                                <input {{$post->headline == 1 ? "checked" : ""}} value= "1" name="headline" type="radio" id="radio_30" class="with-gap radio-col-success"  />
                                <label for="radio_30">Active</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Primary / Selection :</label>
                            <div class="demo-radio-button">
                                <input {{$post->selection == 0 ? "checked" : ""}} value= "0" name="selection" type="radio" id="radio_33" class="with-gap radio-col-primary" checked />
                                <label for="radio_33">Primary</label>
                                <input {{$post->selection == 1 ? "checked" : ""}} value= "1" name="selection" type="radio" id="radio_34" class="with-gap radio-col-primary" />
                                <label for="radio_34">Selection</label>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea id="editor1"  rows="10" cols="80" class="form-control @error('content') is-invalid @enderror" name="content" >{{  old('content') ?? $post->content  }}</textarea>
                            @error('content')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tags</label>
                            <select class="form-control select2" multiple="multiple" name="tags[]" data-placeholder="Select a Tag" style="width: 100%;">
                                @foreach ($tags as $item)
                                <option value="{{$item->id}}" {{ in_array($item->id, $post->tags()->pluck('id')->toArray()) ? 'selected' : '' }}> {{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="video">Video</label>
                            <input id="video" name="video" type="text" class="form-control @error('video') is-invalid @enderror" placeholder="Video" value="{{ old('video') ?? $post->video }}">
                            <span class="font-italic"> Example ID Video on Youtube: DfMz1NMIVe4</span>
                            @error('video')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="caption_video">Caption Video</label>
                            <textarea name="caption_video" id="caption_video" class="form-control  @error('caption_video') is-invalid @enderror" placeholder="Caption Video" >{{ old('caption_video') ?? $post->caption_video }}</textarea>
                            @error('caption_video')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            @if ($post->video)
                            <div class="box border-0 rounded-lg shadow-sm">
                                <div class="text-center box-body">
                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $post->video }}"
                                    frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                                    <h6 class="fw-lighter fst-italic">{{ $post->caption_video }}</h6>
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
                                @if ($post->status == 1)
                                <font style="color: rgb(18, 168, 13)">Publish</font>
                                @else
                                <font style="color: rgb(58, 40, 224)"> Draft</font>
                                @endif
                            </label>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="form-label">Comments :</label>
                            <div class="c-inputs-stacked">
                                <input {{$post->comment_status == 0 ? "checked" : ""}} value= "0" name="comment_status" type="radio" id="radio_36" class="with-gap radio-col-success" />
                                <label for="radio_36">Inactive</label>
                                <input {{$post->comment_status == 1 ? "checked" : ""}} value= "1" name="comment_status" type="radio" id="radio_35" class="with-gap radio-col-success"  />
                                <label for="radio_35">Active</label>

                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="form-label">Tutorial Set :</label>
                            <div class="c-inputs-stacked justify-content-center">
                                <input {{$post->statusblog == 0 ? "checked" : ""}} value= "0" name="statusblog" type="radio" id="radio_41" class="with-gap radio-col-primary" />
                                <label for="radio_41">No</label>
                                <input {{$post->statusblog == 1 ? "checked" : ""}} value= "1" name="statusblog" type="radio" id="radio_40" class="with-gap radio-col-primary"  />
                                <label for="radio_40">Yes</label>

                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-form-label">Published At</label>
                            <div class="col">
                                <input class="form-control @error('published_at') is-invalid @enderror" name="published_at" type="date" value="{{ old('published_at')?? $post->published_at }}" id="example-date-input">
                                @error('published_at')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

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
                            Post Category
                        </h4>
                    </div>

                    <div class="box-body">
                        <div class="form-group @error('postcategory_id') has-error @enderror">
                            <label class="form-label">Post Category <span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" name="postcategory_id">
                                <option value="" holder>Select Post Category</option>
                                @foreach ($postcatagories as $item)
                                <option value="{{ $item->id }}" {{ (old('postcategory_id') == $item->id ? 'selected': '') }}
                                    @if($item->id == $post->postcategory_id)
                                    selected
                                    @endif>
                                    {{ $item->title }}
                                </option>
                                @endforeach
                            </select>
                            @error('postcategory_id')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group @error('postsubcategory_id') has-error @enderror">
                            <label class="form-label">Post Subcategory </label>
                            <select class="form-control select2" style="width: 100%;" name="postsubcategory_id" id="postsubcategory_id" disabled>
                                <option value="" holder>Select Post Category</option>
                                @foreach ($postsubcatagories as $item)
                                <option value="{{ $item->id }}"
                                    @if($item->id == $post->postsubcategory_id)
                                    selected
                                    @endif
                                    {{ (old('postsubcategory_id') == $item->id ? 'selected': '') }}
                                    >{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('postsubcategory_id')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">
                            Feature Image
                        </h4>
                    </div>
                    <div class="box-body  ">
                        <div class="form-group text-center">
                            <div class=" fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                    <img src="{{ ($post->imageThumbUrl) ? $post->imageThumbUrl : '/assets/images/no_image.png' }}"  alt="...">
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
                            <label for="caption_image">Caption Image</label>
                            <textarea name="caption_image" id="caption_image" class="form-control @error('caption_image') is-invalid @enderror" placeholder="Caption Image" >{{ old('caption_image') ?? $post->caption_image }}</textarea>
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
          $('select[name="postcategory_id"]').on('change', function(){
              var postcategory_id = $(this).val();
              if(postcategory_id) {
                  $.ajax({
                      url: "{{  url('/backend/get/postsubcategory/') }}/"+postcategory_id,
                      type:"GET",
                      dataType:"json",
                      success:function(data) {
                         $("#postsubcategory_id").empty();
                         $("#postsubcategory_id").removeAttr("disabled")
                           $.each(data,function(key,value){
                               $("#postsubcategory_id").append('<option value="'+value.id+'">'+value.title+'</option>');
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
