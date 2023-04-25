<div>
        <form enctype="multipart/form-data" wire:submit.prevent="store">
            <div class="box-body">
                <div class="form-group">
                    <h5>Title <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $title }}</small></div> <br/>
                    @error('title')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="text-end flex-grow">
                    <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Save</button>
                </div>
            </div>
        </form>
</div>
