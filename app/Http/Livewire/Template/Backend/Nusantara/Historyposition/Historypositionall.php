<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Historyposition;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Historyposition;
use Illuminate\Http\Request;

class Historypositionall extends Component
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
    public $sortColumn    = 'startdate';
    public $statusUpdate  = false;
    public $headersTable;
    public $action;
    public $selectedItem;
    public $selectItemview;

    public $author_id;
    public $statusView = 0 ;

    public $segment;

    protected $listeners = [
        'historypositionStored',
        'historypositionUpdated',
    ];

    protected $queryString = [
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'title'         => 'Title',
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

    public function mount(Request $request)
    {
        $this->segment = $request->segment(3);

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

    public function getHistorypositionallQueryProperty()
    {
        return Historyposition::orderBy($this->sortColumn, $this->sortDirection)
        ->where('employe_id', $this->segment)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getHistorypositionallProperty()
    {
        return $this->historypositionallQuery->paginate($this->paginate);
    }

    public function updatedSelectHistoryposition($value)
    {
        if ($value) {
            $this->checked = $this->historypositionall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->historypositionallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function historypositionStored($historyposition)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Historyposition  was Stored',
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

    public function historypositionUpdated($historyposition)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Historyposition  was Updated',
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->statusUpdate = false;
        $this->statusView = 0;
    }

    public function selectItemview($employeId, $action)
    {
        $this->statusView = false;
        $this->selectItemview = $employeId;

        if ($action == 'create') {
            $this->statusView = 1;
            $this->statusUpdate = false;
            $this->emit('getEmployeId', $this->selectItemview);
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
        $historyposition = Historyposition::find($this->selectedItem);

        $historyposition->update($data);
        session()->flash('success', 'Historyposition Change to Draft was successfully');
        return redirect()->to('backend/historyposition');
     }

     public function changePublish()
     {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $historyposition = Historyposition::find($this->selectedItem);

        $historyposition->update($data);
        session()->flash('success', 'Historyposition Change to Publish was successfully');
        return redirect()->to('backend/historyposition');
     }

    public function deleteRecords()
    {
        Historyposition::whereKey($this->checked)->delete();

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

     $historyposition = Historyposition::find($this->selectedItem);

     if ($historyposition->masterstatus == config('cms.default_masterhistoryposition')) {
         $this->dispatchBrowserEvent('swal:modaldelete', [
             'title' => 'Importan!',
             'timer' => 4000,
             'type'  => 'warning',
             'text'  => 'Historyposition cannot deleted',
             'showConfirmButton' => true,
             'showCancelButton'  => false,
         ]);
         $this->emit('refreshParent');
         $this->dispatchBrowserEvent('closeDeleteModal');

     } else {



         Historyposition::destroy($this->selectedItem);

         if ($historyposition->image) {
             $this->removeImage($historyposition->image);
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
        return view('livewire.template.backend.nusantara.historyposition.historypositionall',[
            'datahistorypositionall' => $this->historypositionall,
            'title' => 'Struktur Historyposition',
            'employeID' => $this->segment,
        ]);
    }
}
