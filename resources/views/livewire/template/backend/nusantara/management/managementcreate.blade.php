<div>
    <form enctype="multipart/form-data" wire:submit.prevent="store">
        <div class="box-body">
            <div class="form-group @error('employe_id') has-error @enderror">
                <label class="form-label">Pegawai <span class="text-danger">*</span></label>
                <select class="form-control select2" style="width: 100%;" wire:model="employe_id">
                    <option value="" holder>Select Officer</option>
                    @foreach ($employes as $item)
                    <option value="{{ $item->id }}" {{ (old('employe_id') == $item->id ? 'selected': '') }}>
                        {{ $item->name }}
                    </option>
                    @endforeach
                </select>
                @error('employe_id')
                <span class="help-block"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group @error('structuroganization_id') has-error @enderror">
                <label class="form-label">Nama Struktur <span class="text-danger">*</span></label>
                <select class="form-control select2" style="width: 100%;" wire:model="structuroganization_id">
                    <option value="" holder>Select Struktur</option>
                    @foreach ($structuroganization as $item)
                    <option value="{{ $item->id }}" {{ (old('structuroganization_id') == $item->id ? 'selected': '') }}>
                        {{ $item->department }}| {{ $item->title }}
                    </option>
                    @endforeach
                </select>
                @error('structuroganization_id')
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
                <div class="col">
                    <div class="form-group">
                        <h5>Urutan <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" wire:model="sortm" class="form-control @error('sortm') is-invalid @enderror" value="{{ old('sortm')  }}" placeholder="Urutan" required>
                        </div>
                        @error('sortm')
                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end flex-grow">
            <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Save</button>
        </div>
    </form>
</div>
