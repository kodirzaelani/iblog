<div>
        <form enctype="multipart/form-data" wire:submit.prevent="store">
            <div class="box-body">
                <div class="form-group @error('pergub_id') has-error @enderror">
                    <label class="form-label">SK Gubernur <span class="text-danger">*</span></label>
                    <select class="form-control select2" style="width: 100%;" wire:model="pergub_id">
                        <option value="" holder>Select SK Gubernur</option>
                        @foreach ($pergubs as $item)
                        <option value="{{ $item->id }}" {{ (old('pergub_id') == $item->id ? 'selected': '') }}>
                            {{ $item->year }} | {{ $item->title }}
                        </option>
                        @endforeach
                    </select>
                    @error('pergub_id')
                    <span class="help-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>


                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <h5>Periode awal <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" wire:model="startdate" class="form-control @error('startdate') is-invalid @enderror" placeholder="Periode awal" required>
                            </div>
                            <div class="form-control-feedback"><small class="text-primary"> {{ $startdate }}</small></div> <br/>
                            @error('startdate')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <h5>Periode Akhir <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" wire:model="enddate" class="form-control @error('enddate') is-invalid @enderror" placeholder="Periode Akhir" required>
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
