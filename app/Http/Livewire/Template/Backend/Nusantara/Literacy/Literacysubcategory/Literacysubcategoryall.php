<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Literacy\Literacysubcategory;

use App\Models\Literacy;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Literacysubcategory;

class Literacysubcategoryall extends Component
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
    public $uploadPath= 'uploads/images/literacysubcategory';

    public $author_id;
    public $title;
    public $slug;


    protected $listeners = [
        'literacysubcategoryStored',
        'literacysubcategoryUpdated',
    ];

    protected $queryString = [
        // Keeping A Clean Query String https://laravel-livewire.com/docs/2.x/query-string#clean-query-string
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'literacycategory_id' => 'Category',
            'title'               => 'Title',
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

    public function getLiteracysubcategoryallQueryProperty()
    {
        return Literacysubcategory::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getLiteracysubcategoryallProperty()
    {
        return $this->literacysubcategoryallQuery->paginate($this->paginate);
    }

    public function updatedSelectLiteracysubcategory($value)
    {
        if ($value) {
            $this->checked = $this->literacysubcategoryall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->literacysubcategoryallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function literacysubcategoryStored($literacysubcategory)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Literacy Category ' . $literacysubcategory['title'] . ' was Stored',
            'toast'=>true, // Jika mau menggunakan toas
            'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function literacysubcategoryUpdated($literacysubcategory)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Literacy Category ' . $literacysubcategory['title'] . ' was Updated',
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
        $literacysubcategory = Literacysubcategory::find($this->selectedItem);

        $literacysubcategory->update($data);
        session()->flash('success', 'Literacysubcategory Change to Draft was successfully');
        return redirect()->to('backend/literacycategories');
     }

     public function changePublish()
     {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $literacysubcategory = Literacysubcategory::find($this->selectedItem);

        $literacysubcategory->update($data);
        session()->flash('success', 'Literacysubcategory Change to Publish was successfully');
        return redirect()->to('backend/literacycategories');
     }

    public function deleteRecords()
    {
        Literacysubcategory::whereKey($this->checked)->delete();

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
     $masterliteracysubcategory = Literacysubcategory::where('masterstatus', 1)->first();

     $literacysubcategory = Literacysubcategory::find($this->selectedItem);

     if ($literacysubcategory->masterstatus == config('cms.default_masterliteracysubcategory')) {
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

         // Update literacys yang literacysubcategory_id dihapus ke literacysubcategory_id master
         Literacy::where('literacysubcategory_id', $literacysubcategory->id)->update(['literacysubcategory_id' => $masterliteracysubcategory->id]);

         Literacysubcategory::destroy($this->selectedItem);

         if ($literacysubcategory->image) {
             $this->removeImage($literacysubcategory->image);
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
        return view('livewire.template.backend.nusantara.literacy.literacysubcategory.literacysubcategoryall',[
            'dataliteracysubcategoryall' => $this->literacysubcategoryall,
        ]);
    }
}
