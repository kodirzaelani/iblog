<div>
    <!-- Content Header (Foto header) -->

<!-- Main content -->
<section class="content">
    {{-- <form id="post-form" enctype="multipart/form-data" wire:submit.prevent="store"> --}}
    <form enctype="multipart/form-data" wire:submit.prevent="store">
        <div class="row">
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
                                <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Title" required>
                            </div>
                            @error('title')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Target View <span class="text-danger">*</span></label>
                            <div class="demo-radio-button in-line">
                                <input value= "_self" wire:model="targetview" type="radio" id="radio_20" class="@error('targetview') is-invalid @enderror with-gap radio-col-success" />
                                <label for="radio_20">Self</label>
                                <input value= "_blank" wire:model="targetview" type="radio" id="radio_21" class="@error('targetview') is-invalid @enderror with-gap radio-col-success" />
                                <label for="radio_21">Blank </label>
                                @error('targetview')
                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Type Link <span class="text-danger">*</span></h5>
                            <div class="demo-radio-button in-line">
                                <input value= "1" wire:model="typelink" wire:click="resetLink" type="radio" id="radio_11" class="@error('typelink') is-invalid @enderror with-gap radio-col-primary" />
                                <label for="radio_11">Custome Link</label>
                                <input value= "2" wire:model="typelink" wire:click="resetLink" type="radio" id="radio_12" class="@error('typelink') is-invalid @enderror with-gap radio-col-primary" />
                                <label for="radio_12">Page </label>
                                <input value= "3" wire:model="typelink" wire:click="resetLink" type="radio" id="radio_13" class="@error('typelink') is-invalid @enderror with-gap radio-col-primary" />
                                <label for="radio_13">Category Blog</label>
                                @error('typelink')
                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                            </div>
                        </div>

                        @if ($typelink == 1)

                        <div class="form-group">
                            <h5>Link <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" placeholder="Link" required>
                            </div>
                            @error('link')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                        @elseif ($typelink == 2)

                        <div class="form-group @error('link') has-error @enderror">
                            <label class="form-label">Link   <span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" wire:model="link" required>
                                <option value="" holder>Select Page </option>
                                @foreach ($pages as $item)
                                <option value="page/detail/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                @endforeach
                            </select>
                            @error('link')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        @elseif ($typelink == 3)
                        <div class="form-group @error('link') has-error @enderror">
                            <label class="form-label">Link  <span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" wire:model="link" required>
                                <option value="" holder>Select Blog Category </option>
                                <option value="blog" holder>All Blog </option>
                                @foreach ($postcategory as $item)
                                @if ($item->posts->where('status', 1)->count() > 0)
                                <option value="blog/category/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                @endif
                                @endforeach
                            </select>
                            @error('link')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        @elseif ($typelink == 4)
                        <div class="form-group @error('link') has-error @enderror">
                            <label class="form-label">Semua album  <span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" wire:model="link" required>
                                <option value="" holder selected>Select Album </option>
                                <option value="album" >All Album </option>
                                @foreach ($albums as $item)
                                @if ($item->foto->count() > 0)
                                <option value="album/detail/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                @endif
                                @endforeach
                            </select>
                            @error('link')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        @endif
                    </div>

                </div>
                <!-- /.box -->
            </div>
            <div class="col-lg-4 col-12">


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
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Save
                            <small>Publish or Draft</small>
                        </h4>
                    </div>
                    <div class="box-footer text-end">
                        <input type="text" wire:model="status" id="status" hidden>
                        {{-- <button id="draft-btn"   class="btn btn-warning me-1">
                            Draft
                        </button> --}}
                        <button id="publish-btn" class="btn btn-primary">
                            Publish
                        </button>
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
</div>
