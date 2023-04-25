<div>
    <div class="box bs-3 border-success">
        <div class="box-header">
            <h4 class="box-title"><strong>Edit</strong></h4>
        </div>
        <form enctype="multipart/form-data" wire:submit.prevent="update">
            <div class="box-body">
                <div class="form-group">
                    <h5>Title <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $title }}</small></div>
                    @error('title')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group form-group-float">
                    <label class="form-label">Category</label>
                    <select  wire:model="downloadcategory_id" class="form-select @error('downloadcategory_id') is-invalid @enderror">
                        <option value="" selected>Select Category</option>
                        @foreach ($downloadcategories as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach

                    </select>
                    @error('downloadcategory_id')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">File <span class="text-danger">PDF</span></label>
                    <label class="file">
                        <input type="file" wire:model="attach" @error('attach') is-invalid @enderror" id="file">

                    </label>
                    <p><small>Current : {{$prevAttach}}</small></p>
                    @error('attach')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="urlcontent">URL  Content</label>
                    <textarea wire:model="urlcontent" id="urlcontent" rows="5" class="form-control  @error('urlcontent') is-invalid @enderror" placeholder="URL  Content" >{{ old('urlcontent') }}</textarea>
                    <small>Example : file/d/0B8TiTqB1Sz_5ZUFZOFFCWGdUWk0/preview?resourcekey=0-tLJ0mPL_xz6diUFSzGf7Vw</small>
                    @error('urlcontent')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <h5>ID File Download </h5>
                    <div class="controls">
                        <input type="text" wire:model="linkdownload" class="form-control @error('linkdownload') is-invalid @enderror" value="{{ old('linkdownload') }}" placeholder="ID File" >
                    </div>
                    <small>Example : 0B8TiTqB1Sz_5ZUFZOFFCWGdUWk0</small>
                    @error('linkdownload')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea id="editor1"  rows="10" cols="80" class="form-control @error('description') is-invalid @enderror" wire:model="description" >{{ old('description') }}</textarea>
                    @error('description')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
            </div>
            <div class="box-footer flexbox">
                <div class="text-end flex-grow">
                    <a class="btn btn-sm btn-info mr-20" href="{{ route('backend.download.downloadindex') }}"><i class="fa fa-undo" aria-hidden="true"></i> Cancel</a>
                    <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
