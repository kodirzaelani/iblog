<div>
    <!-- Content Header (Foto header) -->

    <!-- Main content -->
    <section class="content">
        <div class="box bs-3 border-success">
            <form enctype="multipart/form-data" wire:submit.prevent="update">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">Edit a Widget
                                    {{-- <small>Advanced and full of features</small> --}}
                                </h4>
                            </div>
                            <!-- /.box-header -->

                            <div class="box-body">
                                <div class="form-group">
                                    <h5>Title <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Title" >
                                    </div>
                                    @error('title')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                    <textarea  rows="3" cols="80" class="form-control @error('description') is-invalid @enderror" wire:model="description" >{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Type Widget <span class="text-danger">*</span></label>
                                    <div class="demo-radio-button in-line">
                                        <input  wire:model="typewidget" value= "1" {{ old('typewidget') == "1" ? 'checked' : '' }} type="radio" id="radio_18" class="@error('typewidget') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_18">Fitur</label>
                                        <input  wire:model="typewidget" value= "2"{{ old('typewidget') == "2" ? 'checked' : '' }} type="radio" id="radio_19" class="@error('typewidget') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_19">Advertisement </label>
                                        @error('typewidget')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                </div>

                                 @if ($typewidget == 1)
                                <div class="form-group ">
                                    <label class="form-label">Position <span class="text-danger">*</span></label>
                                    <select  wire:model="position" class="form-select @error('position') is-invalid @enderror">
                                        <option value="" selected>Select Position</option>
                                        <option {{ (old($position) == '1' ? 'selected' : '') }}  value="1" wire:click="selectPostion('fitur')">Home Page</option>
                                        <option {{ (old($position) == '2' ? 'selected' : '') }}  value="2">Sidebar</option>
                                        <option {{ (old($position) == '3' ? 'selected' : '') }}  value="3">Both</option>
                                    </select>
                                    @error('position')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>

                                <div class="form-group form-group-float">
                                    <label class="form-label">Type Link <span class="text-danger">*</span></label>
                                    <select  wire:model="typelink" wire:change='resetLink' class="form-select @error('typelink') is-invalid @enderror">
                                        <option value="" selected>Select Type Link</option>
                                        <option {{ (old($typelink) == '1' ? 'selected' : '') }}  value="1">Custome Link</option>
                                        <option {{ (old($typelink) == '2' ? 'selected' : '') }}  value="2">Page</option>
                                        <option {{ (old($typelink) == '3' ? 'selected' : '') }}  value="3">Category Blog</option>
                                    </select>
                                    @error('typelink')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    @if ($typelink == 1)
                                    <h5>Link <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="Link" >
                                    </div>
                                    @elseif ($typelink == 2)
                                    <h5>Link <span class="text-danger">*</span></h5>
                                    <select class="form-control select2" style="width: 100%;" wire:model="link" >
                                        <option value="" holder>Select Page </option>
                                        @foreach ($pages as $item)
                                        <option value="page/detail/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                        @endforeach
                                    </select>
                                    @elseif ($typelink == 3)
                                    <h5>Link <span class="text-danger">*</span></h5>
                                    <select class="form-control select2" style="width: 100%;" wire:model="link" >
                                        <option value="" holder>Select Blog Category </option>
                                        <option value="blog" holder>All Blog </option>
                                        @foreach ($postcategory as $item)
                                        @if ($item->posts->where('status', 1)->count() > 0)
                                        <option value="blog/category/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @elseif ($typelink == 4)
                                    <h5>Link <span class="text-danger">*</span></h5>
                                    <select class="form-control select2" style="width: 100%;" wire:model="link" >
                                        <option value="" holder selected>Select Album </option>
                                        <option value="album" >All Album </option>
                                        @foreach ($albums as $item)
                                        @if ($item->foto->count() > 0)
                                        <option value="album/detail/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @endif
                                    @error('link')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>

                                @elseif ($typewidget == 2)
                                <div class="form-group ">
                                    <label class="form-label">Position <span class="text-danger">*</span></label>
                                    <select  wire:model="position" class="form-select @error('position') is-invalid @enderror">
                                        <option value="" selected>Select Position</option>
                                        <option {{ (old($position) == '4' ? 'selected' : '') }}  value="4">Home Page Top</option>
                                        <option {{ (old($position) == '5' ? 'selected' : '') }}  value="5">Home Page Midle</option>
                                        <option {{ (old($position) == '6' ? 'selected' : '') }}  value="6">Home Page Bottom</option>
                                        <option {{ (old($position) == '7' ? 'selected' : '') }}  value="7">Sidebar Top</option>
                                        <option {{ (old($position) == '8' ? 'selected' : '') }}  value="8">Sidebar Midle</option>
                                        <option {{ (old($position) == '9' ? 'selected' : '') }}  value="9">Sidebar Bottom</option>
                                        <option {{ (old($position) == '10' ? 'selected' : '') }}  value="10">Post Detail Top</option>
                                        <option {{ (old($position) == '11' ? 'selected' : '') }}  value="11">Post Detail Midle</option>
                                        <option {{ (old($position) == '12' ? 'selected' : '') }}  value="12">Post Detail Bottom</option>
                                    </select>
                                    @error('position')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                @endif

                                @if ($position == 1 or $position == 3)
                                <div class="form-group">
                                    <h5>Type Content <span class="text-danger">*</span></h5>
                                    <div class="demo-radio-button in-line">
                                        <input  wire:model="typecontent" value= "2" {{ old('typecontent') == "2" ? 'checked' : '' }} type="radio" id="radio_2" disabled class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_2">Script HTML </label>
                                        <input  wire:model="typecontent"  value= "1" {{ old('typecontent') == "1" ? 'checked' : '' }} type="radio" id="radio_1"  class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" checked />
                                        <label for="radio_1">Image</label>

                                        @error('typecontent')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <h5>Type Content <span class="text-danger">*</span></h5>
                                    <div class="demo-radio-button in-line">
                                        <input  wire:model="typecontent" value= "2"{{ old('typecontent') == "2" ? 'checked' : '' }} type="radio" id="radio_2" class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_2">Script HTML </label>
                                        <input  wire:model="typecontent" value= "1" {{ old('typecontent') == "1" ? 'checked' : '' }} type="radio" id="radio_1" class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_1">Image</label>

                                        @error('typecontent')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                </div>
                                @endif

                                @if ($typecontent == 2)
                                <div class="form-group">
                                    <label class="form-label">Script HTML <span class="text-danger">*</span></label>
                                    <textarea  rows="3" cols="80" class="form-control @error('scripthtml') is-invalid @enderror" wire:model="scripthtml" >{{ old('scripthtml') }}</textarea>
                                    @error('scripthtml')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                @endif
                                @if ($typecontent == 1)
                                <div class="form-group">
                                    <label class="form-label">Target View </label>
                                    <div class="demo-radio-button in-line">
                                        <input value= "_self" wire:model="targetview" {{ old('targetview') == "_self" ? 'checked' : '' }} type="radio" id="radio_20" class="@error('targetview') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_20">Self</label>
                                        <input value= "_blank" wire:model="targetview" {{ old('targetview') == "_blank" ? 'checked' : '' }} type="radio" id="radio_21" class="@error('targetview') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_21">Blank </label>
                                        @error('targetview')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                </div>
                                @endif

                                <div class="form-group form-group-float">
                                    <label class="form-label">Type Link <span class="text-danger">*</span></label>
                                    <select  wire:model="typelink" wire:change='resetLink' class="form-select @error('typelink') is-invalid @enderror">
                                        <option value="" selected>Select Type Link</option>
                                        <option {{ (old($typelink) == '1' ? 'selected' : '') }}  value="1">Custome Link</option>
                                        <option {{ (old($typelink) == '2' ? 'selected' : '') }}  value="2">Page</option>
                                        <option {{ (old($typelink) == '3' ? 'selected' : '') }}  value="3">Category Blog</option>
                                    </select>
                                    @error('typelink')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <h5>Type Link <span class="text-danger">*</span></h5>
                                    <div class="demo-radio-button in-line">
                                        <input value= "1" wire:model="typelink" {{ old('typelink') == "1" ? 'checked' : '' }} type="radio" id="radio_11" class="@error('typelink') is-invalid @enderror with-gap radio-col-primary" />
                                        <label for="radio_11">Custome Link</label>
                                        <input value= "2" wire:model="typelink" {{ old('typelink') == "2" ? 'checked' : '' }} type="radio" id="radio_12" class="@error('typelink') is-invalid @enderror with-gap radio-col-primary" />
                                        <label for="radio_12">Page </label>
                                        <input value= "3" wire:model="typelink" {{ old('typelink') == "3" ? 'checked' : '' }} type="radio" id="radio_13" class="@error('typelink') is-invalid @enderror with-gap radio-col-primary" />
                                        <label for="radio_13">Category Blog</label>
                                        @error('typelink')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                </div> --}}


                                <div class="form-group">
                                    <h5>Link <span class="text-danger">*</span></h5>
                                    @if ($typelink == 1)
                                    <div class="controls">
                                        <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="Link" >
                                    </div>
                                    @elseif ($typelink == 2)
                                    <select class="form-control select2" style="width: 100%;" wire:model="link" >
                                        <option value="" holder>Select Page </option>
                                        @foreach ($pages as $item)
                                        <option value="page/detail/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                        @endforeach
                                    </select>
                                    @elseif ($typelink == 3)
                                    <select class="form-control select2" style="width: 100%;" wire:model="link" >
                                        <option value="" holder>Select Blog Category </option>
                                        <option value="blog" holder>All Blog </option>
                                        @foreach ($postcategory as $item)
                                        @if ($item->posts->where('status', 1)->count() > 0)
                                        <option value="blog/category/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @elseif ($typelink == 4)
                                    <select class="form-control select2" style="width: 100%;" wire:model="link" >
                                        <option value="" holder selected>Select Album </option>
                                        <option value="album" >All Album </option>
                                        @foreach ($albums as $item)
                                        @if ($item->foto->count() > 0)
                                        <option value="album/detail/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @endif

                                    <div class="form-control-feedback">
                                        <small class="text-primary">
                                            Current link :
                                            @if ($prevtypelink == 1 )
                                            {{ $prevlink }}
                                            @else
                                            {{ asset('') }} {{ $prevlink }}
                                            @endif
                                        </small>
                                    </div>
                                    @error('link')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h5>Type Content <span class="text-danger">*</span></h5>
                                    <div class="demo-radio-button in-line">
                                        <input  wire:model="typecontent" value= "2"{{ old('typecontent') == "2" ? 'checked' : '' }} type="radio" id="radio_2" class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_2">Script HTML </label>
                                        <input  wire:model="typecontent" value= "1" {{ old('typecontent') == "1" ? 'checked' : '' }} type="radio" id="radio_1" class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_1">Image</label>

                                        @error('typecontent')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                </div>
                                @if ($typecontent == 2)
                                <div class="form-group">
                                    <label class="form-label">Script HTML <span class="text-danger">*</span></label>
                                    <textarea  rows="3" cols="80" class="form-control @error('scripthtml') is-invalid @enderror" wire:model="scripthtml" >{{ old('scripthtml') }}</textarea>
                                    @error('scripthtml')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                @endif
                                @if (!empty($prevscripthtml))
                                <div class="form-group">
                                    <label class="form-label">Current Script HTML </label>
                                    <textarea  rows="5" cols="80" class="form-control @error('prevscripthtml') is-invalid @enderror" wire:model="prevscripthtml" readonly>{{ $prevscripthtml }}</textarea>
                                </div>
                                @endif

                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">Update
                                    <small>Publish</small>
                                </h4>
                            </div>
                            <div class="box-footer text-end">
                                <button  class="btn btn-sm btn-primary">
                                    Update
                                </button>
                                <button wire:click="selectCancel('cancel')" class="btn btn-sm btn-secondary">
                                    Cancel
                                </button>
                            </div>
                        </div>
                        @if (!empty($previmage))
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">
                                    Current Image
                                </h4>
                            </div>
                            <div class="box-body text-center ">
                                <p class="text-center">
                                    <p>
                                        <img class="rounded" src="{{ asset('') }}uploads/images/widget/images_thumb/{{ ($previmage) ? $previmage : '/assets/images/no_image.png' }}"  alt="...">
                                    </p>
                                </p>
                            </div>
                        </div>
                        @endif

                        @if ($typecontent == 1)

                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">
                                    Image <span class="text-danger">*</span>
                                </h4>
                            </div>
                            <div class="box-body text-center ">
                                <label class="form-label">Size : Max 1Mb | 420 x 320 pixel</label>
                                <div class="mt-3">
                                    <input wire:model="image" type="file"  class="form-control @error('image') is-invalid @enderror" id="formFile">
                                </div>
                                <div class="mb-3">
                                    @error('image')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror

                                    @if ($image)
                                    <label for="formFile" class="form-label">Image Preview:</label>
                                    <br/>
                                    <img class="rounded" src="{{ $image->temporaryUrl() }}" style="max-width: 80%">
                                    @endif
                                </div>
                                @error('image')
                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror

                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
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

    </script>
    @endpush
</div>
