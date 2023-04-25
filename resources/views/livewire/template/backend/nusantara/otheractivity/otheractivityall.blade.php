<div>

        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                <div class="box ">
                    <div class="box-header with-border">
                        <h4 class="box-title">Other  Activiy</h4>
                        @can('otheractivity.create')
                        <div class="box-controls pull-right">
                            <button wire:click="selectItemview('{{ $employeID }}','create')"  class="btn btn-primary btn-xs"><i class="ti-plus"></i> Add</button>
                        </div>
                        @endcan
                    </div>

                    <div class="box-body">
                        @if ($statusUpdate == true)
                        <div class="row mb-20">
                            <div class="col-12">
                                <div class="box bs-3 border-success">
                                    <div class="box-header">
                                        <h4 class="box-title"><strong>Edit</strong></h4>
                                        <div class="box-controls pull-right">
                                            <button wire:click="selectItemview('{{ $employeID }}','cancel')"  class="btn btn-info btn-sm"><i class="fa fa-undo" aria-hidden="true"></i> Cancel</button>
                                        </div>
                                    </div>
                                @livewire('template.backend.nusantara.otheractivity.otheractivityedit')
                                </div>
                                <hr>
                            </div>
                        </div>
                        @elseif ($statusView == 1)
                        <div class="row mb-20">
                            <div class="col-12">
                                <div class="box bs-3 border-success">
                                    <div class="box-header">
                                        <h4 class="box-title"><strong>Create</strong></h4>
                                        <div class="box-controls pull-right">
                                            <button wire:click="selectItemview('{{ $employeID }}','cancel')"  class="btn btn-info btn-sm"><i class="fa fa-undo" aria-hidden="true"></i> Cancel</button>
                                        </div>
                                    </div>
                                @livewire('template.backend.nusantara.otheractivity.otheractivitycreate')
                                </div>
                                <hr>
                            </div>
                        </div>
                        @endif
                        {{-- <h3>id: {{$employeID}} </h3> --}}
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
                                        You have selected all <strong>{{ $dataotheractivityall->total() }}</strong> items.
                                    </div>
                                    @else
                                    <div>
                                        You have selected <strong>{{ count($checked) }}</strong> items, Do you want to Select All
                                        <strong>{{ $dataotheractivityall->total() }}</strong>?
                                        <a href="#" class="ml-2" wire:click="selectAll">Select All</a>
                                    </div>
                                    @endif

                                </div>
                                @endif
                            </div> <!-- end row count selected item -->
                        </div>



                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                                @if ($dataotheractivityall->count())
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

                                                @can('otheractivity.edit')
                                                <th scope="col" width="20%" class="text-center">Action</th>
                                                @endcan
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            @foreach ($dataotheractivityall as $no =>  $item)
                                            <tr>
                                                <th class="text-right" scope="row">{{ $no + $dataotheractivityall->firstItem() }}</th>

                                                <td width="20%">
                                                    {{ !empty($item->title) ? $item->title:'' }}
                                                </td>
                                                <td>
                                                    {{ !empty($item->jobtitle) ? $item->jobtitle:'' }}
                                                </td>

                                                <td class="text-center align-midle">
                                                    @if ($item->status == 1)
                                                    <button wire:click="selectItem('{{ $item->id }}', 'inactive')" class="btn btn-xs btn-success" title="Change to Draft"><i class="fa fa-eye"></i></button>
                                                    @else
                                                    <button wire:click="selectItem('{{ $item->id }}', 'active')" class="btn btn-xs btn-default" title="Change to Publish"><i class="fa fa-eye"></i></button>
                                                    @endif
                                                    @can('otheractivity.edit')
                                                    <button wire:click="selectItem('{{ $item->id }}', 'edit')" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></button>
                                                    @endcan
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3 row">
                                    <div class="col-xl-7 col-md-7 col-lg-7 col-12 ">
                                        {{ $dataotheractivityall->links() }}
                                    </div>
                                    <div class="col-xl-5 col-md-5 col-lg-5 col-12 text-center">
                                        Page : {{ $dataotheractivityall->currentPage() }} | Show {{ $dataotheractivityall->count() }} data of {{ $dataotheractivityall->total() }}
                                    </div>
                                </div>
                                @else
                                <hr>
                                <h2 style="color: red" class="text-center">other activity @yield('title')  not available</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                title: event.detail.title,
                text: event.detail.text,
                type: event.detail.type,
            });
        });
        window.addEventListener('swal:modaldelete', event => {
            swal({
                type: event.detail.type,
                title: event.detail.title,
                text: event.detail.text,
                timer: event.detail.timer,

            });
        });
    </script>
    @endpush
</div>
