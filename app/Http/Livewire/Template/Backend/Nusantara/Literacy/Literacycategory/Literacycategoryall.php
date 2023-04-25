<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Literacy\Literacycategory;

use App\Models\Literacy;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Literacycategory;

class Literacycategoryall extends Component
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
    public $sortColumn    = 'title';
    public $statusUpdate  = false;
    public $headersTable;
    public $action;
    public $selectedItem;
    public $uploadPath= 'uploads/images/literacycategory';

    public $author_id;
    public $title;
    public $slug;


    protected $listeners = [
        'literacycategoryStored',
        'literacycategoryUpdated',
    ];

    protected $queryString = [
        // Keeping A Clean Query String https://laravel-livewire.com/docs/2.x/query-string#clean-query-string
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            // 'image'           => 'Image',
            'title'           => 'Title',
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

    public function getLiteracycategoryallQueryProperty()
    {
        return Literacycategory::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getLiteracycategoryallProperty()
    {
        return $this->literacycategoryallQuery->paginate($this->paginate);
    }

    public function updatedSelectLiteracycategory($value)
    {
        if ($value) {
            $this->checked = $this->literacycategoryall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->literacycategoryallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function literacycategoryStored($literacycategory)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Literacy Category ' . $literacycategory['title'] . ' was Stored',
            'toast'=>true, // Jika mau menggunakan toas
            'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function literacycategoryUpdated($literacycategory)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Literacy Category ' . $literacycategory['title'] . ' was Updated',
            // 'toast'=>true, // Jika mau menggunakan toas
            // 'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->statusUpdate = false;
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
        $literacycategory = Literacycategory::find($this->selectedItem);

        $literacycategory->update($data);
        session()->flash('success', 'Literacycategory Change to Draft was successfully');
        return redirect()->to('backend/literacycategories');
     }

     public function changePublish()
     {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $literacycategory = Literacycategory::find($this->selectedItem);

        $literacycategory->update($data);
        session()->flash('success', 'Literacycategory Change to Publish was successfully');
        return redirect()->to('backend/literacycategories');
     }

    public function deleteRecords()
    {
        Literacycategory::whereKey($this->checked)->delete();

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
     $masterliteracycategory = Literacycategory::where('masterstatus', 1)->first();

     $literacycategory = Literacycategory::find($this->selectedItem);

     if ($literacycategory->masterstatus == config('cms.default_masterliteracycategory')) {
         $this->dispatchBrowserEvent('swal:modaldelete', [
             'title' => 'Importan!',
             'timer' => 4000,
             'type'  => 'warning',
             'text'  => 'Literacy Category cannot deleted',
             // 'toast'=>true, // Jika mau menggunakan toas
             // 'position'=>'top-right', // Jika mau menggunakan toas
             'showConfirmButton' => true,
             'showCancelButton'  => false,
         ]);
         $this->emit('refreshParent');
         $this->dispatchBrowserEvent('closeDeleteModal');

     } else {

         // Update literacys yang literacycategory_id dihapus ke literacycategory_id master
         Literacy::where('literacycategory_id', $literacycategory->id)->update(['literacycategory_id' => $masterliteracycategory->id]);

         Literacycategory::destroy($this->selectedItem);

         if ($literacycategory->image) {
             $this->removeImage($literacycategory->image);
         }
         // Sweet alert
         $this->dispatchBrowserEvent('swal:modal', [
             'title' => 'Deleted Success!',
             'timer' => 4000,
             'type'  => 'success',
             'text'  => 'Literacy Category was deleted',
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
        return view('livewire.template.backend.nusantara.literacy.literacycategory.literacycategoryall',[
            'dataliteracycategoryall' => $this->literacycategoryall,
        ]);
    }
}
