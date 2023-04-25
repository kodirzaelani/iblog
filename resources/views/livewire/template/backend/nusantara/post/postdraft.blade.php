<div>
    <!-- Main content -->
    @auth
    @php
    $currentUser = Auth::user()
    @endphp
    @endauth
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
                        You have selected all <strong>{{ $datapostall->total() }}</strong> items.
                    </div>
                    @else
                    <div>
                        You have selected <strong>{{ count($checked) }}</strong> items, Do you want to Select All
                        <strong>{{ $datapostall->total() }}</strong>?
                        <a href="#" class="ml-2" wire:click="selectAll">Select All</a>
                    </div>
                    @endif

                </div>
                @endif
            </div> <!-- end row count selected item -->
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                @if ($datapostall->count())
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            <tr>
                                <th width="4%" scope="col">#</th>
                                {{-- <th>
                                    <div class="checkbox">
                                        <input id="checkbox2" type="checkbox" wire:model="selectPage">
                                        <label for="checkbox2"> </label>
                                    </div>
                                </th> --}}
                                @foreach ($headersTable as $key => $value)
                                <th scope="col" wire:click.prevent="sortBy('{{ $key }}')" style="cursor: pointer">
                                    {{ $value }}
                                    @if ($sortColumn == $key)
                                    <span>{!! $sortDirection == 'asc' ? '&#8659':'&#8657' !!}</span>
                                    @endif
                                </th>
                                @endforeach
                                <th scope="col" width="20%" class="text-center">Action</th>
                            </tr>
                        </tbody>
                        <tbody>
                            @foreach ($datapostall as $no =>  $item)
                            <tr class="@if ($this->isChecked($item->id))
                                table-primary
                                @endif">
                                <th class="text-right" scope="row">{{ $no + $datapostall->firstItem() }}</th>
                                {{-- <td>
                                    <div class="checkbox">
                                        <input type="checkbox" id="Checkbox_{{ $no + $datapostall->firstItem() }}" value="{{ $item->id }}" wire:model="checked">
                                        <label for="Checkbox_{{ $no + $datapostall->firstItem() }}"></label>
                                    </div>
                                </td> --}}
                                <td width="10%">
                                    <img class="w-80 rounded" src="{{ ($item->imageThumbUrl) ? $item->imageThumbUrl : '/assets/images/no_image.png' }}"  alt="...">
                                </td>
                                <td>
                                    {{ $item->author->name }}
                                </td>
                                <td>
                                    <a title="Show"  href="{{ route('post.detail', $item->slug) }}" target="_blank" style="text-decoration: none;" >
                                        {{ !empty($item->title) ? $item->title:'' }}
                                    </a><br>
                                    @if ($item->statuspost == 1)
                                     Tutorial
                                    @else
                                     News/Article
                                    @endif
                                    <i class="fa fa-folder-open me-2 ms-2" aria-hidden="true"></i><a  title="Category"  href="{{ route('post.category', $item->postcategory->slug) }}" target="_blank" style="text-decoration: none; ">
                                        {{ !empty($item->postcategory_id) ? $item->postcategory->title:'' }}
                                    </a>
                                    <i class="fa fa-tags ms-2 me-2" aria-hidden="true" title="Tags"> </i>{!! $item->tags_htmlback !!}
                                </td>

                                {{-- <td >
                                    <a title="Category"  href="{{ route('post.category', $item->postcategory->slug) }}" target="_blank" style="text-decoration: none; ">
                                        {{ !empty($item->postcategory_id) ? $item->postcategory->title:'' }}
                                    </a>
                                    <br> <small>Sub: {{ !empty($item->postsubcategory_id) ? $item->postsubcategory->title:'' }}</small>
                                </td> --}}
                                <td class="text-center align-midle">
                                    @if ($item->author_id == $author_id || $currentUser->masterstatus == 1 )
                                    @if ($item->selection == 1)
                                    <button wire:click="selectItem('{{ $item->id }}', 'primary')" class="btn btn-xs btn-info" title="Change to primary"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                                    @else
                                    <button wire:click="selectItem('{{ $item->id }}', 'selection')" class="btn btn-xs btn-default" title="Change to Selection"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                                    @endif
                                    @if ($item->headline == 1)
                                    <button wire:click="selectItem('{{ $item->id }}', 'inactiveh')" class="btn btn-xs btn-warning" title="Change to General"><i class="fa fa-window-maximize"></i></button>
                                    @else
                                    <button wire:click="selectItem('{{ $item->id }}', 'activeh')" class="btn btn-xs btn-default" title="Change to  Headline"><i class="fa fa-window-maximize"></i></button>
                                    @endif
                                    @if ($item->status == 1)
                                    <button wire:click="selectItem('{{ $item->id }}', 'draft')" class="btn btn-xs btn-success" title="Change to Draft"><i class="fa fa-eye"></i></button>
                                    @else
                                    <button wire:click="selectItem('{{ $item->id }}', 'publish')" class="btn btn-xs btn-default" title="Change to Publish"><i class="fa fa-eye"></i></button>
                                    @endif
                                    <a title="Edit" class="btn btn-xs btn-warning edit-row" href="{{route('backend.posts.edit', $item->id)}}"><i class="fa fa-edit"></i></a>
                                    <button wire:click="selectItem('{{ $item->id }}' , 'delete')"  class="btn btn-xs btn-danger mx-1 my-1" title="Send to Trash"><i class="fa fa-trash    "></i></button>
                                    @else
                                    <button title="Forbidden" class="btn btn-xs btn-default" title="Change to Selection"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                                    <button title="Forbidden" class="btn btn-xs btn-default" title="Change to  Headline"><i class="fa fa-window-maximize"></i></button>
                                    <button title="Forbidden" class="btn btn-xs btn-default" title="Change to Publish"><i class="fa fa-eye"></i></button>
                                    <button title="Forbidden" class="btn btn-xs btn-warning edit-row" disabled><i class="fa fa-edit"></i></button>
                                    <button title="Forbidden" class="btn btn-xs btn-danger " disabled><i class="fa fa-trash"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="mt-3 row">
                    <div class="col-xl-7 col-md-7 col-lg-7 col-12 ">
                        {{ $datapostall->links() }}
                    </div>
                    <div class="col-xl-5 col-md-5 col-lg-5 col-12 text-center">
                        Page : {{ $datapostall->currentPage() }} | Show {{ $datapostall->count() }} data of {{ $datapostall->total() }}
                    </div>
                </div>
                @else
                <hr>
                <h2 style="color: red" class="text-center">Posts Draft not available</h2>
                @endif
            </div>
        </div>
    </div>
    {{-- Modal Delete--}}
    <div class="modal center-modal fade" id="modalFormDelete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send to Trash Item</h5>
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
    </script>
    @endpush
</div>
