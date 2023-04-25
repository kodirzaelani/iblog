<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Menu;

use Livewire\Component;
use Livewire\WithPagination;
use NguyenHuy\Menu\Models\Menus;

class Menuindex extends Component
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
    public $sortColumn    = 'name';
    public $statusUpdate  = false;
    public $headersTable;
    public $action;
    public $selectedItem;

    public $name;


    protected $listeners = [
        'menucategoryStored',
        'menucategoryUpdated',
    ];

    protected $queryString = [
        // Keeping A Clean Query String https://laravel-livewire.com/docs/2.x/query-string#clean-query-string
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'name' => 'Position',
            // 'status'  => 'Status',
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

    public function getMenucategoryQueryProperty()
    {

        return Menus::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getMenucategoryProperty()
    {
        return $this->menucategoryQuery->paginate($this->paginate);
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->menucategory->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->menucategoryQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function menucategoryStored($menucategory)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Menu ' . $menucategory['name'] . ' was Stored',
            'toast'=>true, // Jika mau menggunakan toas
            'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function menucategoryUpdated($menucategory)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'type'=>'success',
            'text'=>'Menu ' . $menucategory['name'] . ' was Updated',
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
        } elseif ($action == 'edit') {
            $this->statusUpdate = true;
            $this->emit('getModelId', $this->selectedItem);
        }  elseif ($action == 'inactive'){
            $this->changeInactive();
        } elseif ($action == 'active') {
            $this->changeActive();
        }
    }
    // Delete Single Record
    public function delete()
    {
        Menus::destroy($this->selectedItem);

            // Sweet alert
            $this->dispatchBrowserEvent('swal:modaldelete', [
                'title' => 'Deleted Success!',
                'timer' => 4000,
                'icon'  => 'success',
                'text'  => 'Menu was deleted',
                // 'toast'=>true, // Jika mau menggunakan toas
                // 'position'=>'top-right', // Jika mau menggunakan toas
                'showConfirmButton' => true,
                'showCancelButton'  => false,
            ]);


            $this->emit('refreshParent');
            // This will hide the modal in the frontend
            $this->dispatchBrowserEvent('closeDeleteModal');
    }
    public function changeInactive()
    {
       $data = [];
       $data = array_merge($data, ['status' => 0]);
       $post = Menus::find($this->selectedItem);

       $post->update($data);
       session()->flash('success', 'Menu Change to Draft was successfully');
       return redirect()->to('backend/admin/categorymenu');
    }
    public function changeActive()
    {
       $data = [];
       $data = array_merge($data, ['status' => 1]);
       $post = Menus::find($this->selectedItem);

       $post->update($data);
       session()->flash('success', 'Menu Change to Active was successfully');
       return redirect()->to('backend/admin/categorymenu');
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.menu.menuindex',[
            'datamenucategory' => $this->menucategory,
        ]);
    }
}
