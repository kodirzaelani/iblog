<div>
    <div class="box bs-3 border-success">
        <div class="box-header">
          <h4 class="box-title"><strong>Create </strong></h4>
        </div>

        <form enctype="multipart/form-data" wire:submit.prevent="store">
        <div class="box-body">

            <div class="form-group">
                <h5>ID <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" wire:model="agamaid" class="form-control @error('agamaid') is-invalid @enderror" placeholder="ID" >
                </div>
                <div class="form-control-feedback"><small class="text-primary"> {{ $agamaid }}</small></div>
                @error('agamaid')
                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                @enderror
            </div>

            <div class="form-group">
                <h5>Nama <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" wire:model="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Description" >
                </div>
                <div class="form-control-feedback"><small class="text-primary"> {{ $nama }}</small></div>
                @error('nama')
                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                @enderror
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
