<div>
    @section('title', 'Menu Item')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Menu Item</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.menuitem.index') }}">All Menu Item</a></li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                <div class="box box-bordered border-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">{{ $title }}</h4>
                        <ul class="box-controls pull-right">
                            <li><a href="{{ route('admin.menuitem.structure') }}"  class="btn btn-primary">Structure</a></li>|
                            <li><button  class="btn btn-primary">List Menu Item</button></li>
                        </ul>
                    </div>
                    @if ($statusView == 0)
                    @livewire('template.backend.nusantara.menuitem.menuitemall')
                    @elseif ($statusView == 1)
                    @include('backend.menu.menuitemstructur')
                    {{-- @livewire('template.backend.nusantara.menuitem.menuitemstructur') --}}
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
