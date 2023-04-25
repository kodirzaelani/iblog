<div>
    <form enctype="multipart/form-data" wire:submit.prevent="update">
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
            <div class="form-group @error('jobtitle') has-error @enderror">
                <label class="form-label">Job Title <span class="text-danger">*</span></label>
                <div class="controls">
                    <input type="text" wire:model="jobtitle" class="form-control @error('jobtitle') is-invalid @enderror" placeholder="Job Title" required>
                </div>
                @error('jobtitle')
                <span class="help-block"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            </div>
        </div>
        <div class="text-end flex-grow">
            <button class="btn btn-sm btn-primary"><i class="ti-save"></i> Update</button>
        </div>
    </form>
</div>
