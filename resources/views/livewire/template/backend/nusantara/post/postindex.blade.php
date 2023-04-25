<div>
    <section class="content">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                <div class="box box-bordered border-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">{{ $title }}</h4>
                        <ul class="box-controls pull-right">
                            <li><a href="{{ route('backend.posts.create') }}"  class="btn btn-success">Add New</a></li>|
                            <li><button wire:click="selectItem('trash')"  class="btn btn-default">Trash</button></li>|
                            <li><button wire:click="selectItem('draft')"  class="btn btn-default">Draft</button></li>|
                            <li><button wire:click="selectItem('published')"  class="btn btn-default">Published</button></li>|
                            <li><button wire:click="selectItem('own')" class="btn btn-default">Own </button></li>|
                            <li><button wire:click="selectItem('all')" class="btn btn-default">All </button></li>
                        </ul>
                    </div>
                    @if ($statusView == 0)
                    @livewire('template.backend.nusantara.post.postall')
                    @elseif ($statusView == 1)
                    @livewire('template.backend.nusantara.post.postpublished')
                    @elseif ($statusView == 2)
                    @livewire('template.backend.nusantara.post.postdraft')
                    @elseif ($statusView == 3)
                    @livewire('template.backend.nusantara.post.posttrash')
                    @elseif ($statusView == 4)
                    @livewire('template.backend.nusantara.post.postown')
                    @endif
                </div>
            </div>
        </div>

    </section>
    @push('scripts')
    <script>
        // Sweet Alert
        window.addEventListener('swal:modal', event => {
            swal({
                type: event.detail.icon,
                title: event.detail.title,
                text: event.detail.text,
                timer: event.detail.timer,

            });
        });
        window.addEventListener('swal:modalrestore', event => {
            swal({
                type: event.detail.icon,
                title: event.detail.title,
                text: event.detail.text,
                timer: event.detail.timer,

            });
        });

    </script>
    @endpush
</div>
