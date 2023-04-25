<div>
        <form enctype="multipart/form-data" wire:submit.prevent="store">
            <div class="box-body">
                <div class="form-group">
                    <h5>Judul <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $title }}</small></div> <br/>
                    @error('title')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <h5>Nomor <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" wire:model="pergubnum" class="form-control @error('pergubnum') is-invalid @enderror" placeholder="Nomor" required>
                            </div>
                            <div class="form-control-feedback"><small class="text-primary"> {{ $pergubnum }}</small></div> <br/>
                            @error('pergubnum')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <h5>Tahun <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="numeric" wire:model="year" class="form-control @error('year') is-invalid @enderror" placeholder="Year" required>
                            </div>
                            <div class="form-control-feedback"><small class="text-primary"> {{ $year }}</small></div> <br/>
                            @error('year')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="form-label">Tentang <span class="text-danger">*</span></label>
                    <textarea id="editor1"  rows="3"  class="form-control @error('about') is-invalid @enderror" wire:model="about">{{ old('about') }}</textarea>
                    @error('about')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="text-end flex-grow">
                    <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Save</button>
                </div>
            </div>
        </form>
</div>
