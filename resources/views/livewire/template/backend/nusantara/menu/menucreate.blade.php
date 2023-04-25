<div>
    <div class="box bs-3 border-success">
        <div class="box-header">
          <h4 class="box-name"><strong>Create</strong></h4>
        </div>
        <form enctype="multipart/form-data" wire:submit.prevent="store">
        <div class="box-body">
            <div class="form-group">
                <h5>Name <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" required>
                </div>
                <div class="form-control-feedback"><small class="text-primary"> {{ $name }}</small></div>
                @error('name')
                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                @enderror
            </div>
        </div>
        <div class="box-footer flexbox">
          <div class="text-end flex-grow">
            <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Save</button>
            {{-- <button class="btn btn-sm btn-secondary">Cancel</button> --}}
          </div>
        </div>
       </form>
      </div>
</div>
