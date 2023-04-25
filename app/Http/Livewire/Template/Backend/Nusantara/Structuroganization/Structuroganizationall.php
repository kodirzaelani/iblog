<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Structuroganization;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Structuroganization;

class Structuroganizationall extends Component
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
    public $sortColumn    = 'sort';
    public $statusUpdate  = false;
    public $headersTable;
    public $action;
    public $selectedItem;

    public $author_id;
    public $statusView = 0 ;


    protected $listeners = [
        'structuroganizationStored',
        'structuroganizationUpdated',
    ];

    protected $queryString = [
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'pergub_id'           => 'SK Gubernur',
            'department'           => 'Struktur',
            'parent_id'     => 'Induk',
            'sort'           => 'Urutan',

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

    public function getStructuroganizationallQueryProperty()
    {
        return Structuroganization::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getStructuroganizationallProperty()
    {
        return $this->structuroganizationallQuery->paginate($this->paginate);
    }

    public function updatedSelectStructuroganization($value)
    {
        if ($value) {
            $this->checked = $this->structuroganizationall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->structuroganizationallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function structuroganizationStored($structuroganization)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Structuroganization ' . $structuroganization['department'] . ' was Stored',
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

    public function structuroganizationUpdated($structuroganization)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Structuroganization ' . $structuroganization['department'] . ' was Updated',
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
        $structuroganization = Structuroganization::find($this->selectedItem);

        $structuroganization->update($data);
        session()->flash('success', 'Structuroganization Change to Draft was successfully');
        return redirect()->to('backend/structuroganization');
     }

     public function changePublish()
     {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $structuroganization = Structuroganization::find($this->selectedItem);

        $structuroganization->update($data);
        session()->flash('success', 'Structuroganization Change to Publish was successfully');
        return redirect()->to('backend/structuroganization');
     }

    public function deleteRecords()
    {
        Structuroganization::whereKey($this->checked)->delete();

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

    //  $structuroganization = Structuroganization::find($this->selectedItem);



         Structuroganization::destroy($this->selectedItem);


         // Sweet alert
         $this->dispatchBrowserEvent('swal:modal', [
             'title' => 'Deleted Success!',
             'timer' => 4000,
             'type'  => 'success',
             'text'  => 'Structuroganization was deleted',
             'showConfirmButton' => true,
             'showCancelButton'  => false,
         ]);

         $this->emit('refreshParent');
         $this->dispatchBrowserEvent('closeDeleteModal');


 }

    public function render()
    {
        return view('livewire.template.backend.nusantara.structuroganization.structuroganizationall',[
            'datastructuroganizationall' => $this->structuroganizationall,
        ]);
    }
}
