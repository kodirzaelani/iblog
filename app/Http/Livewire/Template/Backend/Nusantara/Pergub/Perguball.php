<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Pergub;

use Livewire\Component;
use App\Models\Download;
use Livewire\WithPagination;
use App\Models\Pergub;

class Perguball extends Component
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
    public $sortColumn    = 'year';
    public $statusUpdate  = false;
    public $headersTable;
    public $action;
    public $selectedItem;

    public $author_id;
    public $title;
    public $slug;
    public $statusView = 0 ;


    protected $listeners = [
        'pergubStored',
        'pergubUpdated',
    ];

    protected $queryString = [
        // Keeping A Clean Query String https://laravel-livewire.com/docs/2.x/query-string#clean-query-string
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'year'           => 'Year',
            'title'           => 'Title',
            'pergubnum' => 'Nomor'
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

    public function getPerguballQueryProperty()
    {
        return Pergub::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getPerguballProperty()
    {
        return $this->perguballQuery->paginate($this->paginate);
    }

    public function updatedSelectPergub($value)
    {
        if ($value) {
            $this->checked = $this->perguball->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->perguballQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function pergubStored($pergub)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Peraturan ' . $pergub['title'] . ' was Stored',
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

    public function pergubUpdated($pergub)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Peraturan ' . $pergub['title'] . ' was Updated',
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
        $pergub = Pergub::find($this->selectedItem);

        $pergub->update($data);
        session()->flash('success', 'Pergub Change to Draft was successfully');
        return redirect()->to('backend/peraturan');
     }

     public function changePublish()
     {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $pergub = Pergub::find($this->selectedItem);

        $pergub->update($data);
        session()->flash('success', 'Pergub Change to Publish was successfully');
        return redirect()->to('backend/peraturan');
     }

    public function deleteRecords()
    {
        Pergub::whereKey($this->checked)->delete();

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
     $masterpergub = Pergub::where('masterstatus', 1)->first();

     $pergub = Pergub::find($this->selectedItem);

     if ($pergub->masterstatus == config('cms.default_masterpergub')) {
         $this->dispatchBrowserEvent('swal:modaldelete', [
             'title' => 'Importan!',
             'timer' => 4000,
             'type'  => 'warning',
             'text'  => 'Peraturan cannot deleted',
             // 'toast'=>true, // Jika mau menggunakan toas
             // 'position'=>'top-right', // Jika mau menggunakan toas
             'showConfirmButton' => true,
             'showCancelButton'  => false,
         ]);
         $this->emit('refreshParent');
         $this->dispatchBrowserEvent('closeDeleteModal');

     } else {

         // Update downloads yang pergub_id dihapus ke pergub_id master
         Download::where('pergub_id', $pergub->id)->update(['pergub_id' => $masterpergub->id]);

         Pergub::destroy($this->selectedItem);

         if ($pergub->image) {
             $this->removeImage($pergub->image);
         }
         // Sweet alert
         $this->dispatchBrowserEvent('swal:modal', [
             'title' => 'Deleted Success!',
             'timer' => 4000,
             'type'  => 'success',
             'text'  => 'Peraturan was deleted',
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
        return view('livewire.template.backend.nusantara.pergub.perguball',[
            'dataperguball' => $this->perguball,
        ]);
    }
}
