<div>
    <div class="box bs-3 border-success">
        <div class="box-header">
            <h4 class="box-title"><strong>Create</strong></h4>
        </div>
        <form enctype="multipart/form-data" wire:submit.prevent="store">
            <div class="box-body">
                <div class="form-group">
                    <h5>Title <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" required>
                    </div>
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
                <div class="form-group form-group-float">
                    <label class="form-label">Category</label>
                    <select  wire:model="literacysubcategory_id" class="form-select @error('literacysubcategory_id') is-invalid @enderror">
                        <option value="" selected>Select Sub Category</option>
                        @foreach ($literacysubcategories as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach

                    </select>
                    @error('literacysubcategory_id')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
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
                    <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
