<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Download;

use Livewire\Component;
use App\Models\Download;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Downloadall extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $currentPage   = 1;
    public $paginate      = 10;
    public $search        = '';
    public $checked       = [];
    public $selectPage    = false;
    public $selectAll     = false;
    public $sortDirection = 'desc';
    public $sortColumn    = 'created_at';
    public $statusUpdate  = false;
    public $headersTable;
    public $statusView  = 0;
    public $action;
    public $selectedItem;

    public $uploadPath= 'uploads/downloads/files';

    public $author_id;
    public $title;
    public $slug;


    protected $listeners = [
        'downloadStored',
        'downloadUpdated',
    ];

    protected $queryString = [
        // Keeping A Clean Query String https://laravel-livewire.com/docs/2.x/query-string#clean-query-string
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'title'           => 'Title',
            'downloadcategory_id'           => 'Category',
        ];
    }

    public function sortBy($column)
    {
        $this->sortColumn = $column;

        $this->sortDirection = $this->reverseSort();

    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
        ? 'desc'
        : 'asc';
    }

    public function mount()
    {
        $this->fill(request()->only('search', 'currentPage'));
        $this->resetSearch();
        $this->headersTable = $this->headerConfig();

    }

    public function resetSearch()
    {
        $this->search = '';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getDownloadallQueryProperty()
    {
        $this->author_id = Auth::id();
        return Download::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getDownloadallProperty()
    {
        return $this->downloadallQuery->paginate($this->paginate);
    }

    public function updatedSelectDownload($value)
    {
        if ($value) {
            $this->checked = $this->downloadall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->checked = [];
        }
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->downloadallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function downloadStored($download)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Download  ' . $download['title'] . ' was Stored',
            'toast'=>true, // Jika mau menggunakan toas
            'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->statusView = 0;
    }



    public function downloadUpdated($download)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Download  ' . $download['title'] . ' was Updated',
            // 'toast'=>true, // Jika mau menggunakan toas
            // 'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->statusUpdate = false;
    }

    public function selectItemview($action)
    {
        $this->statusView = 0;

        if ($action == 'create') {
            $this->statusView = 1;
        }
    }


    public function selectItem($itemId, $action)
    {
        $this->statusUpdate = false;

        $this->selectedItem = $itemId;

        if ($action == 'delete') {
            // This will show the modal in the frontend
            $this->dispatchBrowserEvent('openDeleteModal');
        } elseif ($action == 'edit') {
            $this->statusUpdate = true;
            $this->emit('getModelId', $this->selectedItem);
        }
    }

    public function changeDraft()
    {
        $data = [];
        $data = array_merge($data, ['status' => 0]);
        $download = Download::find($this->selectedItem);

        $download->update($data);
        session()->flash('success', 'Download Change to Draft was successfully');
        return redirect()->to('backend/download');
    }

    public function changePublish()
    {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $download = Download::find($this->selectedItem);

        $download->update($data);
        session()->flash('success', 'Download Change to Publish was successfully');
        return redirect()->to('backend/download');
    }

    public function deleteRecords()
    {
        Download::whereKey($this->checked)->delete();

        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Deleted Success!',
            'timer'=>4000,
            'icon'=>'success',
            'text'=>'Selected Records were deleted Successfully',
            // 'toast'=>true, // Jika mau menggunakan toas
            // 'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeDeleteModalAll');
    }



    // Delete Single Record
    public function delete()
    {
        $download = Download::find($this->selectedItem);
        if ($download->attach) {
            $this->removeAttach($download->attach);
        }
        Download::destroy($this->selectedItem);


        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Deleted Success!',
            'timer' => 4000,
            'type'  => 'success',
            'text'  => 'Download  was deleted',
            // 'toast'=>true, // Jika mau menggunakan toas
            // 'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton' => true,
            'showCancelButton'  => false,
        ]);

        $this->emit('refreshParent');
        // This will hide the modal in the frontend
        $this->dispatchBrowserEvent('closeDeleteModal');

    }

    private function removeAttach($attach)
    {
        if ( ! empty($attach) )
        {
            $imagePath     = $this->uploadPath . '/' . $attach;

            if ( file_exists($imagePath) ) unlink($imagePath);
        }
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.download.downloadall',[
            'datadownloadall' => $this->downloadall,
            'title' => 'List Download'
        ]);
    }
}
