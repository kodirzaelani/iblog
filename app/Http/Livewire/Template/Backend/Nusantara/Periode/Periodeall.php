<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Periode;

use Livewire\Component;
use App\Models\Download;
use Livewire\WithPagination;
use App\Models\Periode;

class Periodeall extends Component
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

    public $author_id;
    public $title;
    public $slug;
    public $statusView = 0 ;


    protected $listeners = [
        'periodeStored',
        'periodeUpdated',
    ];

    protected $queryString = [
        // Keeping A Clean Query String https://laravel-livewire.com/docs/2.x/query-string#clean-query-string
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'pergub_id'           => 'SK Gubernur',
            'startdate'           => 'Periode',
            'status'     => 'Status',

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

    public function getPeriodeallQueryProperty()
    {
        return Periode::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getPeriodeallProperty()
    {
        return $this->periodeallQuery->paginate($this->paginate);
    }

    public function updatedSelectPeriode($value)
    {
        if ($value) {
            $this->checked = $this->periodeall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->periodeallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function periodeStored($periode)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Periode ' . $periode['startdate'] . ' was Stored',
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

    public function periodeUpdated($periode)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Periode ' . $periode['startdate'] . ' was Updated',
            // 'toast'=>true, // Jika mau menggunakan toas
            // 'position'=>'top-right', // Jika mau menggunakan toas
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
            // This will show the openUpdateModal in the frontend
            $this->dispatchBrowserEvent('openEditModal');
        }
    }

     public function changeDraft()
     {
        $data = [];
        $data = array_merge($data, ['status' => 0]);
        $periode = Periode::find($this->selectedItem);

        $periode->update($data);
        session()->flash('success', 'Periode Change to Draft was successfully');
        return redirect()->to('backend/periode');
     }

     public function changePublish()
     {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $periode = Periode::find($this->selectedItem);

        $periode->update($data);
        session()->flash('success', 'Periode Change to Publish was successfully');
        return redirect()->to('backend/periode');
     }

    public function deleteRecords()
    {
        Periode::whereKey($this->checked)->delete();

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
     $masterperiode = Periode::where('masterstatus', 1)->first();

     $periode = Periode::find($this->selectedItem);

     if ($periode->masterstatus == config('cms.default_masterperiode')) {
         $this->dispatchBrowserEvent('swal:modaldelete', [
             'title' => 'Importan!',
             'timer' => 4000,
             'type'  => 'warning',
             'text'  => 'Periode cannot deleted',
             // 'toast'=>true, // Jika mau menggunakan toas
             // 'position'=>'top-right', // Jika mau menggunakan toas
             'showConfirmButton' => true,
             'showCancelButton'  => false,
         ]);
         $this->emit('refreshParent');
         $this->dispatchBrowserEvent('closeDeleteModal');

     } else {

         // Update downloads yang periode_id dihapus ke periode_id master
         Download::where('periode_id', $periode->id)->update(['periode_id' => $masterperiode->id]);

         Periode::destroy($this->selectedItem);

         if ($periode->image) {
             $this->removeImage($periode->image);
         }
         // Sweet alert
         $this->dispatchBrowserEvent('swal:modal', [
             'title' => 'Deleted Success!',
             'timer' => 4000,
             'type'  => 'success',
             'text'  => 'Download Category was deleted',
             // 'toast'=>true, // Jika mau menggunakan toas
             // 'position'=>'top-right', // Jika mau menggunakan toas
             'showConfirmButton' => true,
             'showCancelButton'  => false,
         ]);

         $this->emit('refreshParent');
         // This will hide the modal in the frontend
         $this->dispatchBrowserEvent('closeDeleteModal');
     }


 }

    public function render()
    {
        return view('livewire.template.backend.nusantara.periode.periodeall',[
            'dataperiodeall' => $this->periodeall,
        ]);
    }
}
