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
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.agendas.index') }}">All Foto</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit a agenda</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
<section class="content">
    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.agendas.update', $agenda) }}"  method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Edit a Agenda
                            {{-- <small>Advanced and full of features</small> --}}
                        </h4>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">

                        <div class="form-group">
                            <h5>Title <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $agenda->title  }}" placeholder="Title" required>
                            </div>
                            @error('title')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea id="editor1"  rows="10" cols="80" class="form-control @error('description') is-invalid @enderror" name="description" >{{  old('description') ?? $agenda->description  }}</textarea>
                            @error('description')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Location </label>
                            <textarea  rows="6" cols="80" class="form-control @error('location') is-invalid @enderror" name="location" >{{  old('location') ?? $agenda->location  }}</textarea>
                            @error('location')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Attach File <span class="text-danger">PDF</span></label>
                            <label class="file">
                                <input type="file"  name="attach" @error('attach') is-invalid @enderror" id="file">
                            </label>
                            @error('attach')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        @php
                        $extension = pathinfo(storage_path('/uploads/images/agenda/'.$agenda->attach), PATHINFO_EXTENSION);
                        $fileSize = \File::size(public_path('/uploads/images/agenda/'.$agenda->attach));
                        @endphp
                        @if ($agenda->attach)
                        <h5><i class="fa fa-paperclip m-r-10 m-b-10"></i> Attachments </h5>
                        <ul class="mailbox-attachments clearfix">
                            <li>
                                <div class="mailbox-attachment-info">
                                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> {{ $agenda->attach }}</a>
                                    <span class="mailbox-attachment-size">
                                        {{ $fileSize }} KB
                                        <a href="{{ url('') }}/uploads/images/agenda/{{ $agenda->attach }}" target="_blank"  class="btn btn-primary btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                    </span>
                                </div>
                            </li>
                        </ul>
                        {{-- <p><a href="{{ url('') }}/uploads/images/agenda/{{ $agenda->attach }}"  target="_blank" class="btn  btn-info" title="View"><i class="fa fa-paperclip"></i> Surat Pendukung </a></p> --}}
                        @endif
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
                                @if ($agenda->status == 1)
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
                            <label for="example-date-input" class="col-sm-4 col-form-label">Start Date <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="date" name="startdate" value="{{ old('startdate') ?? $agenda->startdate}}" id="example-date-input">
                            </div>
                            @error('startdate')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-4 col-form-label">End Date <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="date" name="enddate" value="{{ old('enddate') ?? $agenda->enddate}}" id="example-date-input1">
                            </div>
                            @error('enddate')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="example-time-input" class="col-sm-4 col-form-label">Time <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="time" name="periode" value="{{ old('periode') ?? $agenda->periode}}" id="example-time-input">
                            </div>
                            @error('periode')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="example-time-input" class="col-sm-4 col-form-label">End Time <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="time" name="endperiode" value="{{ old('endperiode') ?? $agenda->endperiode}}" id="example-time-inputend">
                            </div>
                            @error('endperiode')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">
                            Flayer
                        </h4>
                    </div>
                    <div class="box-body text-center ">
                        <div class="form-group">
                            <div class=" fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                    <img src="{{ ($agenda->imageThumbUrl) ? $agenda->imageThumbUrl : '/assets/images/no_image.png' }}"  alt="...">
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
