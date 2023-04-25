<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Literacy;

use Livewire\Component;
use App\Models\Literacy;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Literacyall extends Component
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
    public $action;
    public $selectedItem;
    public $uploadPath= 'uploads/images/literacy';

    public $author_id;
    public $title;
    public $slug;


    protected $listeners = [
        'literacyStored',
        'literacyUpdated',
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
            'literacycategory_id'           => 'Category',
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

    public function getLiteracyallQueryProperty()
    {
        $this->author_id = Auth::id();
        return Literacy::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getLiteracyallProperty()
    {
        return $this->literacyallQuery->paginate($this->paginate);
    }

    public function updatedSelectLiteracy($value)
    {
        if ($value) {
            $this->checked = $this->literacyall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->literacyallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function literacyStored($literacy)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Literacy  ' . $literacy['title'] . ' was Stored',
            'toast'=>true, // Jika mau menggunakan toas
            'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function literacyUpdated($literacy)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Literacy  ' . $literacy['title'] . ' was Updated',
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
        } elseif($action == 'draft'){
            $this->changeDraft();
        } else {
            $this->changePublish();
        }
    }

     public function changeDraft()
     {
        $data = [];
        $data = array_merge($data, ['status' => 0]);
        $literacy = Literacy::find($this->selectedItem);

        $literacy->update($data);
        session()->flash('success', 'Literacy Change to Draft was successfully');
        return redirect()->to('backend/allliteracies');
     }

     public function changePublish()
     {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $literacy = Literacy::find($this->selectedItem);

        $literacy->update($data);
        session()->flash('success', 'Literacy Change to Publish was successfully');
        return redirect()->to('backend/allliteracies');
     }

    public function deleteRecords()
    {
        Literacy::whereKey($this->checked)->delete();

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
     $masterliteracy = Literacy::where('masterstatus', 1)->first();

     $literacy = Literacy::find($this->selectedItem);

     if ($literacy->masterstatus == config('cms.default_masterliteracy')) {
         $this->dispatchBrowserEvent('swal:modaldelete', [
             'title' => 'Importan!',
             'timer' => 4000,
             'type'  => 'warning',
             'text'  => 'Literacy  cannot deleted',
             // 'toast'=>true, // Jika mau menggunakan toas
             // 'position'=>'top-right', // Jika mau menggunakan toas
             'showConfirmButton' => true,
             'showCancelButton'  => false,
         ]);
         $this->emit('refreshParent');
         $this->dispatchBrowserEvent('closeDeleteModal');

     } else {

         // Update literacys yang literacy_id dihapus ke literacy_id master
         Literacy::where('literacy_id', $literacy->id)->update(['literacy_id' => $masterliteracy->id]);

         Literacy::destroy($this->selectedItem);

         if ($literacy->image) {
             $this->removeImage($literacy->image);
         }
         // Sweet alert
         $this->dispatchBrowserEvent('swal:modal', [
             'title' => 'Deleted Success!',
             'timer' => 4000,
             'type'  => 'success',
             'text'  => 'Literacy  was deleted',
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
        return view('livewire.template.backend.nusantara.literacy.literacyall',[
            'dataliteracyall' => $this->literacyall,
        ]);
    }
}
