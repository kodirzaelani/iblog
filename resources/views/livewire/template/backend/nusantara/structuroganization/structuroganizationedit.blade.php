<div>

        <form enctype="multipart/form-data" wire:submit.prevent="update">
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
                            <h5>Nama Struktur <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" wire:model="department" class="form-control @error('department') is-invalid @enderror" placeholder="Nama Struktur" required>
                            </div>
                            <div class="form-control-feedback"><small class="text-primary"> {{ $department }}</small></div> <br/>
                            @error('department')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <h5>Nama Jabatan <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Nama Jabatan" required>
                            </div>
                            <div class="form-control-feedback"><small class="text-primary"> {{ $title }}</small></div> <br/>
                            @error('title')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group @error('parent_id') has-error @enderror">
                            <label class="form-label">Induk</label>
                            <select class="form-control select2" style="width: 100%;" wire:model="parent_id">
                                <option value="" holder>Select Induk</option>
                                @foreach ($strukturorganisasi as $item)
                                <option value="{{ $item->id }}" {{ (old('parent_id') == $item->id ? 'selected': '') }}>{{ $item->department }}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
                            <span class="help-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <h5>Urutan <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" wire:model="sort" class="form-control @error('sort') is-invalid @enderror" value="{{ old('sort')  }}" placeholder="Urutan" required>
                            </div>
                            @error('sort')
                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-end flex-grow">
                    <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Update</button>
                </div>
            </div>
        </form>
</div>
