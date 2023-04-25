<div>
    <div class="box bs-3 border-success">
        <div class="box-header">
          <h4 class="box-title"><strong>Edit</strong></h4>
        </div>
        <form enctype="multipart/form-data" wire:submit.prevent="update">
        <div class="box-body">
            <div class="form-group">
                <h5>ID <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" wire:model="sortid" class="form-control @error('sortid') is-invalid @enderror" placeholder="ID" >
                </div>
                <div class="form-control-feedback"><small class="text-primary"> {{ $sortid }}</small></div>
                @error('sortid')
                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                @enderror
            </div>

            <div class="form-group">
                <h5>Nama <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Description" >
                </div>
                <div class="form-control-feedback"><small class="text-primary"> {{ $title }}</small></div>
                @error('title')
                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                @enderror
            </div>

        </div>
        <div class="box-footer flexbox">
          <div class="text-end flex-grow">
            <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Update</button>
          </div>
        </div>
       </form>
      </div>
</div>
