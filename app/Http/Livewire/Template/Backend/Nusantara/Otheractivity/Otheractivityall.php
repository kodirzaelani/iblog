<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Otheractivity;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Otheractivity;
use Illuminate\Http\Request;

class Otheractivityall extends Component
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
    public $sortColumn    = 'created_at';
    public $statusUpdate  = false;
    public $headersTable;
    public $action;
    public $selectedItem;
    public $selectItemview;

    public $author_id;
    public $statusView = 0 ;

    public $segment;

    protected $listeners = [
        'otheractivityStored',
        'otheractivityUpdated',
    ];

    protected $queryString = [
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'title'         => 'Title',
            'jobtitle'     => 'Jabatan',
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

    public function getOtheractivityallQueryProperty()
    {
        return Otheractivity::orderBy($this->sortColumn, $this->sortDirection)
        ->where('employe_id', $this->segment)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getOtheractivityallProperty()
    {
        return $this->otheractivityallQuery->paginate($this->paginate);
    }

    public function updatedSelectOtheractivity($value)
    {
        if ($value) {
            $this->checked = $this->otheractivityall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->otheractivityallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function otheractivityStored($otheractivity)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Otheractivity  was Stored',
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

    public function otheractivityUpdated($otheractivity)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Otheractivity  was Updated',
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
        $otheractivity = Otheractivity::find($this->selectedItem);

        $otheractivity->update($data);
        session()->flash('success', 'Otheractivity Change to Draft was successfully');
        return redirect()->to('backend/otheractivity');
     }

     public function changePublish()
     {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $otheractivity = Otheractivity::find($this->selectedItem);

        $otheractivity->update($data);
        session()->flash('success', 'Otheractivity Change to Publish was successfully');
        return redirect()->to('backend/otheractivity');
     }

    public function deleteRecords()
    {
        Otheractivity::whereKey($this->checked)->delete();

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

     $otheractivity = Otheractivity::find($this->selectedItem);

     if ($otheractivity->masterstatus == config('cms.default_masterotheractivity')) {
         $this->dispatchBrowserEvent('swal:modaldelete', [
             'title' => 'Importan!',
             'timer' => 4000,
             'type'  => 'warning',
             'text'  => 'Otheractivity cannot deleted',
             'showConfirmButton' => true,
             'showCancelButton'  => false,
         ]);
         $this->emit('refreshParent');
         $this->dispatchBrowserEvent('closeDeleteModal');

     } else {



         Otheractivity::destroy($this->selectedItem);

         if ($otheractivity->image) {
             $this->removeImage($otheractivity->image);
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
        return view('livewire.template.backend.nusantara.otheractivity.otheractivityall',[
            'dataotheractivityall' => $this->otheractivityall,
            'title' => 'Struktur Otheractivity',
            'employeID' => $this->segment,
        ]);
    }
}
