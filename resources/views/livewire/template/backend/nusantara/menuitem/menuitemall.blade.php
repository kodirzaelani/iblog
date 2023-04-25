<div>
    @section('title', 'List Menu Front End')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Menu Front End</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('backend.menuitem.index') }}">All Menu Item</a></li>
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
                        <h4 class="box-title">@yield('title')</h4>
                        <ul class="box-controls pull-right">
                            <li><a href="{{ route('backend.menuitem.structure') }}"  class="btn btn-primary" style="margin:0 4px; padding: 0 4px; vertical-align: middle; font-size: 0.8571rem; font-weight: 400;">Structure</a></li>|
                            {{-- <li><button  class="btn btn-primary" >List Menu Item</button></li>| --}}
                            <li><button wire:click="selectItem('', 'add')"  class="btn btn-success" >Add Menu Item</button></li>
                        </ul>
                    </div>
                    <div class="box-body">
                        <div class="row mb-2">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-12 mb-2">
                                <select wire:model="paginate" name="" id="" class="w-auto form-control-sm custom-select">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="col-lg-5 col-md-5 col-12 mb-2">
                                @if ($checked)
                                <div class="btn-group mb-5">
                                    <button type="button" class="waves-effect waves-light btn btn-info">With Checked ({{ count($checked) }})</button>
                                    <button type="button" class="waves-effect waves-light btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#modalFormDeleteAll">
                                            Delete Selected
                                        </a>
                                        <a href="#" class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#modalFormExportExcel">
                                            Export Excel
                                        </a>
                                        <a href="#" class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#modalFormExportPDF">
                                            Export PDF
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-5 col-lg-5 col-12 mb-2 text-right ">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input type="search" wire:model.debounce.500ms="search" class="form-control" wire:keydown.escape="resetSearch" wire:keydown.tab="resetSearch" class="form-control float-right" placeholder="Search by ...">
                                        <span class="input-group-text"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2"> <!-- row count selected item -->
                            <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                                @if ($selectPage)
                                <div class="col-md-10 mb-2">
                                    @if ($selectAll)
                                    <div>
                                        You have selected all <strong>{{ $datamenuitem->total() }}</strong> items.
                                    </div>
                                    @else
                                    <div>
                                        You have selected <strong>{{ count($checked) }}</strong> items, Do you want to Select All
                                        <strong>{{ $datamenuitem->total() }}</strong>?
                                        <a href="#" class="ml-2" wire:click="selectAll">Select All</a>
                                    </div>
                                    @endif

                                </div>
                                @endif
                            </div> <!-- end row count selected item -->
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                                @if ($statusUpdate == 2)
                                @livewire('template.backend.nusantara.menuitem.menuitemcreate')
                                @elseif ($statusUpdate == 1)
                                @livewire('template.backend.nusantara.menuitem.menuitemedit')
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                                <div class="box bs-3 border-success">
                                    <div class="box-body">
                                        @if ($datamenuitem->count())
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th width="4%" scope="col">#</th>
                                                        @foreach ($headersTable as $key => $value)
                                                        <th scope="col" wire:click.prevent="sortBy('{{ $key }}')" style="cursor: pointer">
                                                            {{ $value }}
                                                            @if ($sortColumn == $key)
                                                            <span>{!! $sortDirection == 'asc' ? '&#8659':'&#8657' !!}</span>
                                                            @endif
                                                        </th>
                                                        @endforeach
                                                        <th scope="col" width="25%" class="text-center">Action</th>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    @foreach ($datamenuitem as $no =>  $item)
                                                    <tr class="@if ($this->isChecked($item->id))
                                                        table-primary
                                                        @endif">
                                                        <th class="text-right" scope="row">{{ $no + $datamenuitem->firstItem() }}</th>
                                                        <td>
                                                            {{ !empty($item->label) ? $item->label:'' }}</br>
                                                            <small class="text-primary">
                                                                <a target="_blank" href="{{ $item->link }}">{{ $item->link }}</a>
                                                            </small>
                                                            {{-- @if ($item->typemenu == 1)
                                                            <small class="text-primary">
                                                                <a target="_blank" href="{{ $item->link }}">{{ $item->link }}</a>
                                                            </small>
                                                            @elseif ($item->typemenu == 9)
                                                            <small class="text-primary"><a target="_blank" href="{{ $item->link }}">{{ $item->link }}</a></small>
                                                            @else
                                                            <small class="text-primary"><a target="_blank" href="{{ $item->linkid }}">{{ $item->linkid }}</a></small>
                                                            @endif --}}
                                                        </td>
                                                        {{-- <td>
                                                            @if ($item->paren > 0)
                                                            {{ !empty($item->parent) ? $item->parent_menu->label:'' }}
                                                            @else
                                                            <span class="fw-bold">-</span>
                                                            @endif
                                                        </td> --}}
                                                        <td>
                                                            {{ !empty($item->parent_menu) ? $item->parent_menu->name:'' }}
                                                        </td>
                                                        <td class="text-center align-midle">
                                                            @if ($item->status == 1)
                                                            <button wire:click="selectItem('{{ $item->id }}', 'inactive')" class="btn btn-xs btn-success" title="Change to InActive"><i class="fa fa-eye"></i></button>
                                                            @else
                                                            <button wire:click="selectItem('{{ $item->id }}', 'active')" class="btn btn-xs btn-default" title="Change to Active"><i class="fa fa-eye"></i></button>
                                                            @endif
                                                            <button wire:click="selectItem('{{ $item->id }}', 'edit')" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit    "></i></button>
                                                            @can('menu.delete')
                                                            <button wire:click="selectItem('{{ $item->id }}' , 'delete')"  class="btn btn-sm btn-danger mx-1 my-1" title="Delete"><i class="fa fa-trash    "></i></button>
                                                            @else
                                                            <button title="Forbidden" class="btn btn-xs btn-danger " disabled><i class="fa fa-trash"></i></button>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3 row">
                                            <div class="col-xl-7 col-md-7 col-lg-7 col-12 ">
                                                {{ $datamenuitem->links() }}
                                            </div>
                                            <div class="col-xl-5 col-md-5 col-lg-5 col-12 text-center">
                                                Page : {{ $datamenuitem->currentPage() }} | Show {{ $datamenuitem->count() }} data of {{ $datamenuitem->total() }}
                                            </div>
                                        </div>
                                        @else
                                        <hr>
                                        <h2 style="color: red" class="text-center">@yield('title') not available</h2>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    {{-- Modal Delete--}}
    <div class="modal center-modal fade" id="modalFormDelete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Selected Item {{ $selectedItem }} --}}
                    <p><h3>Do you wish to continue?</h3></p>
                </div>
                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button wire:click="delete" class="btn btn-primary float-end">Yes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete--}}
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
