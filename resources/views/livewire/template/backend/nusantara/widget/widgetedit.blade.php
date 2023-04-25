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
                                    <label class="form-label">Type Widget <span class="text-danger">*</span></label>
                                    <select  wire:model="typewidget" wire:change='resetTypecontent' class="form-select @error('typewidget') is-invalid @enderror">
                                        <option value="" selected>Select Type Widget</option>
                                        <option {{ (old($typewidget) == '1' ? 'selected' : '') }}  value="1"> Fitur</option>
                                        <option {{ (old($typewidget) == '2' ? 'selected' : '') }}  value="2">Advertisement/HTML</option>
                                        <option {{ (old($typewidget) == '3' ? 'selected' : '') }}  value="3">Link Text</option>
                                        <option {{ (old($typewidget) == '4' ? 'selected' : '') }}  value="4">Link Image</option>
                                    </select>
                                    @error('typewidget')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
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
                                    <label class="form-label">Status Title Widget <span class="text-danger">*</span></label>
                                    <div class="demo-radio-button in-line">
                                        <input  wire:model="statustitle" value= "1" {{ old('statustitle') == "1" ? 'checked' : '' }} type="radio" id="radio_3" class="@error('statustitle') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_3">Active</label>
                                        <input  wire:model="statustitle" value= "2"{{ old('statustitle') == "2" ? 'checked' : '' }} type="radio" id="radio_4" class="@error('statustitle') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_4">Non Active </label>
                                        @error('statustitle')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                    <textarea  rows="3" cols="80" class="form-control @error('description') is-invalid @enderror" wire:model="description" >{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>


                                @if ($typewidget == 1)
                                <div class="form-group ">
                                    <label class="form-label">Position <span class="text-danger">*</span></label>
                                    <select  wire:model="position" wire:change='resetTypecontent' class="form-select @error('position') is-invalid @enderror">
                                        <option value="" selected>Select Position</option>
                                        <option {{ (old($position) == '1' ? 'selected' : '') }}  value="1" wire:click="selectPostion('fitur')">Fitur Home Page</option>
                                        <option {{ (old($position) == '2' ? 'selected' : '') }}  value="2">Fitur Home Page & Sidebar Left midle</option>
                                        <option {{ (old($position) == '3' ? 'selected' : '') }}  value="3">Fitur Home Page & Sidebar Right midle</option>
                                        <option {{ (old($position) == '7' ? 'selected' : '') }}  value="7">Sidebar Right Top</option>
                                        <option {{ (old($position) == '8' ? 'selected' : '') }}  value="8">Sidebar Right Midle</option>
                                        <option {{ (old($position) == '9' ? 'selected' : '') }}  value="9">Sidebar Right Bottom</option>
                                        <option {{ (old($position) == '13' ? 'selected' : '') }}  value="13">Sidebar Left Top</option>
                                        <option {{ (old($position) == '14' ? 'selected' : '') }}  value="14">Sidebar Left Midle</option>
                                        <option {{ (old($position) == '15' ? 'selected' : '') }}  value="15">Sidebar Left Bottom</option>
                                    </select>
                                    @error('position')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                @if ($position == 1 or $position == 2 or $position == 3)
                                <div class="form-group">
                                    <h5>Type Content <span class="text-danger">*</span></h5>
                                    <div class="demo-radio-button in-line">
                                        <input  wire:model="typecontent"  value= "1" {{ old('typecontent') == "1" ? 'checked' : '' }} type="radio" id="radio_1"  class="@error('typecontent') is-invalid @enderror with-gap radio-col-success"  />
                                        <label for="radio_1">Image</label>
                                        <input  wire:model="typecontent" value= "2"{{ old('typecontent') == "2" ? 'checked' : '' }} type="radio" id="radio_2" class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" disabled/>
                                        <label for="radio_2">Script HTML </label>
                                        @error('typecontent')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <h5>Type Content <span class="text-danger">*</span></h5>
                                    <div class="demo-radio-button in-line">
                                        <input  wire:model="typecontent" value= "1" {{ old('typecontent') == "1" ? 'checked' : '' }} type="radio" id="radio_1" class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_1">Image</label>
                                        <input  wire:model="typecontent" value= "2"{{ old('typecontent') == "2" ? 'checked' : '' }} type="radio" id="radio_2" class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_2">Script HTML </label>

                                        @error('typecontent')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                </div>
                                @endif

                                @elseif ($typewidget == 2)
                                <div class="form-group ">
                                    <label class="form-label">Position <span class="text-danger">*</span></label>
                                    <select  wire:model="position" wire:change="resetTypecontent" class="form-select @error('position') is-invalid @enderror">
                                        <option value="" selected>Select Position</option>
                                        <option {{ (old($position) == '4' ? 'selected' : '') }}  value="4">Home Page Top</option>
                                        <option {{ (old($position) == '5' ? 'selected' : '') }}  value="5">Home Page Midle</option>
                                        <option {{ (old($position) == '6' ? 'selected' : '') }}  value="6">Home Page Bottom</option>
                                        <option {{ (old($position) == '7' ? 'selected' : '') }}  value="7">Sidebar Right Top</option>
                                        <option {{ (old($position) == '8' ? 'selected' : '') }}  value="8">Sidebar Right Midle</option>
                                        <option {{ (old($position) == '9' ? 'selected' : '') }}  value="9">Sidebar Right Bottom</option>
                                        <option {{ (old($position) == '10' ? 'selected' : '') }}  value="10">Post Detail Top</option>
                                        <option {{ (old($position) == '11' ? 'selected' : '') }}  value="11">Post Detail Midle</option>
                                        <option {{ (old($position) == '12' ? 'selected' : '') }}  value="12">Post Detail Bottom</option>
                                        <option {{ (old($position) == '13' ? 'selected' : '') }}  value="13">Sidebar Left Top</option>
                                        <option {{ (old($position) == '14' ? 'selected' : '') }}  value="14">Sidebar Left Midle</option>
                                        <option {{ (old($position) == '15' ? 'selected' : '') }}  value="15">Sidebar Left Bottom</option>
                                        <option {{ (old($position) == '16' ? 'selected' : '') }}  value="16">Footer</option>
                                    </select>
                                    @error('position')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h5>Type Content <span class="text-danger">*</span></h5>
                                    <div class="demo-radio-button in-line">
                                        <input  wire:model="typecontent" value= "1" {{ old('typecontent') == "1" ? 'checked' : '' }} type="radio" id="radio_1" class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_1">Image</label>
                                        <input  wire:model="typecontent" value= "2"{{ old('typecontent') == "2" ? 'checked' : '' }} type="radio" id="radio_2" class="@error('typecontent') is-invalid @enderror with-gap radio-col-success" />
                                        <label for="radio_2">Script HTML </label>

                                        @error('typecontent')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                </div>
                                @elseif ($typewidget == 3)
                                <div class="form-group ">
                                    <label class="form-label">Position <span class="text-danger">*</span></label>
                                    <select  wire:model="position" wire:change="resetTypecontent" class="form-select @error('position') is-invalid @enderror">
                                        <option value="" selected>Select Position</option>
                                        <option {{ (old($position) == '7' ? 'selected' : '') }}  value="7">Sidebar Right Top</option>
                                        <option {{ (old($position) == '8' ? 'selected' : '') }}  value="8">Sidebar Right Midle</option>
                                        <option {{ (old($position) == '9' ? 'selected' : '') }}  value="9">Sidebar Right Bottom</option>
                                        <option {{ (old($position) == '13' ? 'selected' : '') }}  value="13">Sidebar Left Top</option>
                                        <option {{ (old($position) == '14' ? 'selected' : '') }}  value="14">Sidebar Left Midle</option>
                                        <option {{ (old($position) == '15' ? 'selected' : '') }}  value="15">Sidebar Left Bottom</option>
                                    </select>
                                    @error('position')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h5>Link <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="Link" >
                                    </div>
                                    @error('link')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
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
                                @elseif ($typewidget == 4)
                                <div class="form-group ">
                                    <label class="form-label">Position <span class="text-danger">*</span></label>
                                    <select  wire:model="position" wire:change="resetTypecontent" class="form-select @error('position') is-invalid @enderror">
                                        <option value="" selected>Select Position</option>
                                        <option {{ (old($position) == '7' ? 'selected' : '') }}  value="7">Sidebar Right Top</option>
                                        <option {{ (old($position) == '8' ? 'selected' : '') }}  value="8">Sidebar Right Midle</option>
                                        <option {{ (old($position) == '9' ? 'selected' : '') }}  value="9">Sidebar Right Bottom</option>
                                        <option {{ (old($position) == '13' ? 'selected' : '') }}  value="13">Sidebar Left Top</option>
                                        <option {{ (old($position) == '14' ? 'selected' : '') }}  value="14">Sidebar Left Midle</option>
                                        <option {{ (old($position) == '15' ? 'selected' : '') }}  value="15">Sidebar Left Bottom</option>
                                    </select>
                                    @error('position')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h5>Link <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="Link" >
                                    </div>
                                    @error('link')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
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

                                @if ($typecontent == 1)
                                <div class="form-group form-group-float">
                                    <label class="form-label">Type Link <span class="text-danger">*</span></label>
                                    <select  wire:model="typelink" wire:change='resetLink' class="form-select @error('typelink') is-invalid @enderror">
                                        <option value="" selected>Select Type Link</option>
                                        <option {{ (old($typelink) == '1' ? 'selected' : '') }}  value="1">Custome Link</option>
                                        <option {{ (old($typelink) == '2' ? 'selected' : '') }}  value="2">Page</option>
                                        <option {{ (old($typelink) == '3' ? 'selected' : '') }}  value="3">Category Blog</option>
                                        {{-- <option {{ (old($typelink) == '4' ? 'selected' : '') }}  value="3">Sub Category Blog</option> --}}
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
                                        <option value="blog" holder>Semua Category </option>
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
                                @endif
                                @if ($typecontent == 2)
                                <div class="form-group">
                                    <label class="form-label">Script HTML <span class="text-danger">*</span></label>
                                    <textarea  rows="3" cols="80" class="form-control @error('scripthtml') is-invalid @enderror" wire:model="scripthtml" >{{ old('scripthtml') }}</textarea>
                                    @error('scripthtml')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                @if (!empty($prevscripthtml))
                                <div class="form-group">
                                    <label class="form-label">Current Script HTML </label>
                                    <textarea  rows="5" cols="80" class="form-control @error('prevscripthtml') is-invalid @enderror" wire:model="prevscripthtml" readonly>{{ $prevscripthtml }}</textarea>
                                </div>
                                @endif
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
                        @if ($typewidget == 4)

                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">
                                    Image Link<span class="text-danger">*</span>
                                </h4>
                            </div>
                            <div class="box-body text-center ">
                                <label class="form-label">Size : Max 500kb | 100 x 320 pixel</label>
                                <div class="mt-3">
                                    <input wire:model="image" type="file"  class="form-control @error('image') is-invalid @enderror" id="formFile">
                                </div>
                                <div class="mb-3">
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
