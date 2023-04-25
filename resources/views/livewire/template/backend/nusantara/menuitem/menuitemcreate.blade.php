<div>

    <div class="box bs-3 border-success">
        <form enctype="multipart/form-data" wire:submit.prevent="store">
            <div class="box-body">

                <h4 class="box-name"><strong>Create Menu Item</strong></h4>
                <div class="form-group">
                    <label class="form-label">Menu Postion :</label>
                    <div class="demo-radio-button in-line">
                        @foreach ($menus as $item)
                        <input value= "{{ $item->id }}" wire:model="menu" type="radio" id="radio_{{ $item->id }}" class="@error('menu') is-invalid @enderror with-gap radio-col-primary" />
                        <label for="radio_{{ $item->id }}">{{ $item->name }}</label>
                        @endforeach
                        @error('menu')
                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Type Menu :</label>
                    <select class="form-control select2" style="width: 100%;" wire:model="typemenu" required>
                        <option value="" holder>Select Type Menu </option>
                        <option value="1">Custome Internal </option>
                        <option value="2">Page </option>
                        <option value="3">Category Post </option>
                        <option value="4">Galery Album </option>
                        <option value="5">Contact </option>
                        <option value="6">Literacy </option>
                        <option value="7">Download File </option>
                        <option value="8">Galery Video </option>
                        <option value="9">Custome Eksternal </option>
                        <option value="10">Management </option>
                    </select>

                    @error('typemenu')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Target :</label>
                    <div class="demo-radio-button in-line">
                        <input value= "_self" wire:model="target" type="radio" id="radio_20" class="@error('target') is-invalid @enderror with-gap radio-col-success" />
                        <label for="radio_20">Self</label>
                        <input value= "_blank" wire:model="target" type="radio" id="radio_21" class="@error('target') is-invalid @enderror with-gap radio-col-success" />
                        <label for="radio_21">Blank </label>
                        @error('target')
                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                        @enderror
                    </div>
                </div>

                @if ($typemenu == 1)
                <div class="form-group">
                    <h5>Label Menu<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="label" class="form-control @error('label') is-invalid @enderror" placeholder="Label" required autofocus>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $label }}</small></div>
                    @error('label')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <h5>Link <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" placeholder="Link" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $link }}</small></div>
                    @error('link')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>

                @elseif ($typemenu == 2)
                <div class="form-group @error('link') has-error @enderror">
                    <label class="form-label">Link Page  <span class="text-danger">*</span></label>
                    <select class="form-control select2" style="width: 100%;" wire:model="link" required>
                        <option value="" holder>Select Page </option>
                        @foreach ($pages as $item)
                        <option value="page/detail/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                        @endforeach
                    </select>
                    <div class="form-control-feedback"><small class="text-primary">{{ $link }}</small></div>
                    @error('link')
                    <span class="help-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <h5>Label Menu<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="label" class="form-control @error('label') is-invalid @enderror" placeholder="Label" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $label }}</small></div>
                    @error('label')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                    <input type="text" wire:model="link" value={{ $link }} class="form-control @error('link') is-invalid @enderror" placeholder="Link" hidden>
                </div>
                @elseif ($typemenu == 3)
                <div class="form-group @error('link') has-error @enderror">
                    <label class="form-label">Link  <span class="text-danger">*</span></label>
                    <select class="form-control select2" style="width: 100%;" wire:model="link" required>
                        <option value="" holder>Select Post Category </option>
                        <option value="posts" holder>All Post </option>
                        @foreach ($postcategory as $item)
                        @if ($item->posts->where('status', 1)->count() > 0)
                        <option value="posts/category/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                        @endif
                        @endforeach
                    </select>
                    <div class="form-control-feedback"><small class="text-primary">{{ $link }}</small></div>
                    @error('link')
                    <span class="help-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <h5>Label Menu<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="label" class="form-control @error('label') is-invalid @enderror" placeholder="Label" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $label }}</small></div>
                    @error('label')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                    <input type="text" wire:model="link" value="#" class="form-control @error('link') is-invalid @enderror" placeholder="Link" hidden>
                </div>

                @elseif ($typemenu == 4)
                <div class="form-group @error('link') has-error @enderror">
                    <label class="form-label">Semua album  <span class="text-danger">*</span></label>
                    <select class="form-control select2" style="width: 100%;" wire:model="link" required>
                        <option value="" holder >Select Album </option>
                        <option value="album"holder >All Album </option>
                        @foreach ($albums as $item)
                        @if ($item->foto->count() > 0)
                        <option value="album/detail/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->title }} </option>
                        @endif
                        @endforeach
                    </select>
                    <div class="form-control-feedback"><small class="text-primary">{{ $link }}</small></div>
                    @error('link')
                    <span class="help-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <h5>Label Menu<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="label" class="form-control @error('label') is-invalid @enderror"  placeholder="Label Menu" required>
                    </div>
                    @error('label')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                @elseif ($typemenu == 5)
                <div class="form-group">
                    <h5>Label Menu<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="label" class="form-control @error('label') is-invalid @enderror" placeholder="Label" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $label }}</small></div>
                    @error('label')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <h5>Link <span class="text-danger">Type contact</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" placeholder="Link" value="contact" required>
                    </div>
                    {{-- <div class="form-control-feedback"><small class="text-primary"> {{ $link }}</small></div> --}}
                    @error('link')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                @elseif ($typemenu == 6)
                <div class="form-group @error('link') has-error @enderror">
                    <label class="form-label">Link  <span class="text-danger">*</span></label>
                    <select class="form-control select2" style="width: 100%;" wire:model="link" >
                        <option value="" holder>Select Literacy Category </option>
                        <option value="literacy" >All Literacy </option>
                    </select>
                    <div class="form-control-feedback"><small class="text-primary">{{ $link }}</small></div>
                    @error('link')
                    <span class="help-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <h5>Label Menu<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="label" class="form-control @error('label') is-invalid @enderror" placeholder="Label" >
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $label }}</small></div>
                    @error('label')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="controls">
                        <input type="text" wire:model="link" value="#" class="form-control @error('link') is-invalid @enderror" placeholder="Link" required hidden>
                    </div>
                    @error('link')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                @elseif ($typemenu == 7)
                <div class="form-group">
                    <h5>Label Menu<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="label" class="form-control @error('label') is-invalid @enderror" placeholder="Label" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $label }}</small></div>
                    @error('label')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    {{-- <h5>Link <span class="text-danger">-> /download</span></h5> --}}
                    <div class="controls">
                        <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" placeholder="Link" value="download" >
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> Pleace type "download"</small></div>
                    @error('link')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                @elseif ($typemenu == 8)
                <div class="form-group">
                    <h5>Label Menu<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="label" class="form-control @error('label') is-invalid @enderror" placeholder="Label" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $label }}</small></div>
                    @error('label')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <h5>Link <span class="text-danger">Type video</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" placeholder="Link" value="video" required  >
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $link }}</small></div>
                    @error('link')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                @elseif ($typemenu == 9)
                <div class="form-group">
                    <h5>Label Menu<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="label" class="form-control @error('label') is-invalid @enderror" placeholder="Label" required autofocus>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $label }}</small></div>
                    @error('label')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <h5>Link <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" placeholder="Link" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary">example: https://www.kaltimprov.go.id/</small></div>
                    @error('link')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                </div>
                @elseif ($typemenu == 10)
                <div class="form-group @error('link') has-error @enderror">
                    <label class="form-label">Link Management  <span class="text-danger">*</span></label>
                    <select class="form-control select2" style="width: 100%;" wire:model="link" required>
                        <option value="" holder>Select Management </option>
                        @foreach ($structuroganizations as $item)
                        <option value="dewanpengurus/{{ $item->slug }}" {{ (old('link') == $item->id ? 'selected': '') }}>{{ $item->department }} </option>
                        @endforeach
                    </select>
                    <div class="form-control-feedback"><small class="text-primary">{{ $link }}</small></div>
                    @error('link')
                    <span class="help-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <h5>Label Menu<span class="text-danger">*</span></h5>
                    <div class="controls">
                        <input type="text" wire:model="label" class="form-control @error('label') is-invalid @enderror" placeholder="Label" required>
                    </div>
                    <div class="form-control-feedback"><small class="text-primary"> {{ $label }}</small></div>
                    @error('label')
                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                    @enderror
                    <input type="text" wire:model="link" value={{ $link }} class="form-control @error('link') is-invalid @enderror" placeholder="Link" hidden>
                </div>
                @endif
                <div class="flexbox">
                    <div class="text-end flex-grow">
                        <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Save</button>
                    </form>
                    <button wire:click="selectCancel('cancel')" class="btn btn-sm btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('') }}assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
    <script src="{{ asset('') }}assets/vendor_components/select2/dist/js/select2.full.js"></script>
    @endpush
</div>
