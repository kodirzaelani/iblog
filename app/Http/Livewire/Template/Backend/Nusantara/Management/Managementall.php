<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Management;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Management;

class Managementall extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $currentPage   = 1;
    public $paginate      = 10;
    public $search        = '';
    public $checked       = [];
    public $selectPage    = false;
    public $selectAll     = false;
    public $sortDirection = 'asc';
    public $sortColumn    = 'sortm';
    public $statusUpdate  = false;
    public $headersTable;
    public $action;
    public $selectedItem;

    public $author_id;
    public $statusView = 0 ;


    protected $listeners = [
        'managementStored',
        'managementUpdated',
    ];

    protected $queryString = [
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'employe_id'           => 'Nama Pegawai',
            'startdate'     => 'Periode',
            'structuroganization_id'           => 'Unit Kerja',
            // 'structuroganization_id'           => 'Jabatan',
            // 'title'           => 'Nama Jabatan',

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

    public function getManagementallQueryProperty()
    {
        return Management::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getManagementallProperty()
    {
        return $this->managementallQuery->paginate($this->paginate);
    }

    public function updatedSelectManagement($value)
    {
        if ($value) {
            $this->checked = $this->managementall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->managementallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function managementStored($management)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Management  was Stored',
            'toast'=>true, // Jika mau menggunakan toas
            'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->statusUpdate = false;
        $this->statusView = 0;

    }

    public function managementUpdated($management)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Management  was Updated',
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->statusUpdate = false;
        $this->statusView = 0;
    }

    public function selectItemview($action)
    {
        $this->statusView = false;

        if ($action == 'create') {
            $this->statusView = 1;
            $this->statusUpdate = false;
        } elseif ($action == 'cancel'){
            $this->statusView = 0;
            $this->statusUpdate = false;

        }
    }

    public function selectItem($itemId, $action)
    {
        $this->statusUpdate = false;

        $this->selectedItem = $itemId;

        if ($action == 'delete') {
            // This will show the modal in the frontend
            $this->dispatchBrowserEvent('openDeleteModal');
        } elseif ($action == 'show') {
            $this->emit('getModelId', $this->selectedItem);
            // This will show the openShowModal in the frontend
            $this->dispatchBrowserEvent('openShowModal');
        } elseif ($action == 'edit') {
            $this->statusUpdate = true;
            $this->emit('getModelId', $this->selectedItem);
        } elseif ($action == 'inactive'){
            $this->changeDraft();
        } elseif ($action == 'active') {
            $this->changePublish();
        } else {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openEditModal');
        }
    }

     public function changeDraft()
     {
        $data = [];
        $data = array_merge($data, ['status' => 0]);
        $management = Management::find($this->selectedItem);

        $management->update($data);
        session()->flash('success', 'Management Change to Draft was successfully');
        return redirect()->to('backend/management');
     }

     public function changePublish()
     {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $management = Management::find($this->selectedItem);

        $management->update($data);
        session()->flash('success', 'Management Change to Publish was successfully');
        return redirect()->to('backend/management');
     }

    public function deleteRecords()
    {
        Management::whereKey($this->checked)->delete();

        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Deleted Success!',
            'timer'=>4000,
            'icon'=>'success',
            'text'=>'Selected Records were deleted Successfully',
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeDeleteModalAll');
    }

 // Delete Single Record
 public function delete()
 {

     $management = Management::find($this->selectedItem);

     if ($management->masterstatus == config('cms.default_mastermanagement')) {
         $this->dispatchBrowserEvent('swal:modaldelete', [
             'title' => 'Importan!',
             'timer' => 4000,
             'type'  => 'warning',
             'text'  => 'Management cannot deleted',
             'showConfirmButton' => true,
             'showCancelButton'  => false,
         ]);
         $this->emit('refreshParent');
         $this->dispatchBrowserEvent('closeDeleteModal');

     } else {



         Management::destroy($this->selectedItem);

         if ($management->image) {
             $this->removeImage($management->image);
         }
         // Sweet alert
         $this->dispatchBrowserEvent('swal:modal', [
             'title' => 'Deleted Success!',
             'timer' => 4000,
             'type'  => 'success',
             'text'  => 'Download Category was deleted',
             'showConfirmButton' => true,
             'showCancelButton'  => false,
         ]);

         $this->emit('refreshParent');
         $this->dispatchBrowserEvent('closeDeleteModal');
     }


 }

    public function render()
    {
        return view('livewire.template.backend.nusantara.management.managementall',[
            'datamanagementall' => $this->managementall,
            'title' => 'Struktur Management',
        ]);
    }
}
