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
                    <select  wire:model="literacycategory_id" class="form-select @error('literacycategory_id') is-invalid @enderror">
                        <option value="" selected>Select Category</option>
                        @foreach ($literacycategories as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach

                    </select>
                    @error('literacycategory_id')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Current Image</label>
                    <p>
                        <img class="w-80 rounded" src="{{ asset('') }}uploads/images/literacysubcategory/images_thumb/{{ ($prevImage) ? $prevImage : '/assets/images/no_image.png' }}"  alt="...">
                    </p>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input wire:model="image" type="file"  class="form-control @error('image') is-invalid @enderror" id="formFile">
                </div>
                <div class="mb-3">
                    @error('image')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror

                    @if ($image)
                    <label for="formFile" class="form-label">Image Preview:</label>
                    <br/>
                    <img src="{{ $image->temporaryUrl() }}" style="max-width: 40%">
                    @endif
                </div>
            </div>
            <div class="box-footer flexbox">
                <div class="text-end flex-grow">
                    <a class="btn btn-sm btn-info mr-20" href="{{ route('backend.literacysubcategories.index') }}"><i class="fa fa-undo" aria-hidden="true"></i> Cancel</a>
                    <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
