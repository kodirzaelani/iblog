<div>
    <form enctype="multipart/form-data" wire:submit.prevent="store">
        <div class="box-body">

            <div class="form-group @error('title') has-error @enderror">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <div class="controls">
                    <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" required>
                </div>
                @error('title')
                <span class="help-block"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <h5>Awal Periode <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" wire:model="startdate" class="form-control @error('startdate') is-invalid @enderror" placeholder="Nama Jabatan" required>
                        </div>
                        <div class="form-control-feedback"><small class="text-primary"> {{ $startdate }}</small></div> <br/>
                        @error('startdate')
                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <h5>Akhir Periode <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" wire:model="enddate" class="form-control @error('enddate') is-invalid @enderror" placeholder="Nama Jabatan" required>
                        </div>
                        <div class="form-control-feedback"><small class="text-primary"> {{ $enddate }}</small></div> <br/>
                        @error('enddate')
                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-end flex-grow">
                <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Save</button>
            </div>
        </div>
    </form>
</div>
