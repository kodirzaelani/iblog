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
                    {{-- <div class="form-control-feedback"><small class="text-primary"> {{ $title }}</small></div> --}}
                    @error('title')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="text-end flex-grow">
                    <a class="btn btn-sm btn-info mr-20" href="{{ route('backend.download.categoryindex') }}"><i class="fa fa-undo" aria-hidden="true"></i> Cancel</a>
                    <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
