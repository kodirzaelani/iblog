<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Menuitem;

use Livewire\Component;
use Livewire\WithPagination;
use NguyenHuy\Menu\Models\MenuItems;

class Menuitemall extends Component
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
    public $sortColumn    = 'id';
    public $statusUpdate  = 0;
    public $headersTable;
    public $action;
    public $selectedItem;

    public $label;


    protected $listeners = [
        'menuitemStored',
        'menuitemUpdated',
        'menuitemCancel',
    ];

    protected $queryString = [
        // Keeping A Clean Query String https://laravel-livewire.com/docs/2.x/query-string#clean-query-string
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'label' => 'Title',
            // 'parent' => 'Parent',
            'menu'  => 'Position',
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

    public function getMenuitemQueryProperty()
    {

        return MenuItems::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getMenuitemProperty()
    {
        return $this->menuitemQuery->paginate($this->paginate);
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->menuitem->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->menuitemQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function menuitemCancel()
    {
        $this->statusUpdate = 0;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function menuitemStored($menuitem)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'icon'=>'success',
            'text'=>'Menu Item ' . $menuitem['label'] . ' was Stored',
            'toast'=>true, // Jika mau menggunakan toas
            'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->statusUpdate = 0;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function menuitemUpdated($menuitem)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'icon'=>'success',
            'text'=>'Menu Item ' . $menuitem['label'] . ' was Updated',
            // 'toast'=>true, // Jika mau menggunakan toas
            // 'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->statusUpdate = 0;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function selectItem($itemId, $action)
    {
        $this->statusUpdate = 0;

        $this->selectedItem = $itemId;
        if ($action == 'delete') {
            // This will show the modal in the frontend
            $this->dispatchBrowserEvent('openDeleteModal');
        } elseif ($action == 'edit') {
            $this->statusUpdate = 1;
            $this->emit('getModelId', $this->selectedItem);
        } elseif ($action == 'add') {
            $this->statusUpdate = 2;
        }  elseif ($action == 'inactive'){
            $this->changeInactive();
        } elseif ($action == 'active') {
            $this->changeActive();
        }
    }
    public function changeInactive()
    {
       $data = [];
       $data = array_merge($data, ['status' => 0]);
       $post = MenuItems::find($this->selectedItem);

       $post->update($data);
       session()->flash('success', 'MenuItems Change to InAcctive was successfully');
       return redirect()->to('backend/menuitem');
    }
    public function changeActive()
    {
       $data = [];
       $data = array_merge($data, ['status' => 1]);
       $post = MenuItems::find($this->selectedItem);

       $post->update($data);
       session()->flash('success', 'MenuItems Change to Active was successfully');
       return redirect()->to('backend/menuitem');
    }

    public function delete()
    {
        MenuItems::destroy($this->selectedItem);

        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Deleted Success!',
            'timer' => 4000,
            'icon'  => 'success',
            'text'  => 'Menu Items was deleted',
            // 'toast'=>true, // Jika mau menggunakan toas
            // 'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton' => true,
            'showCancelButton'  => false,
        ]);

        $this->emit('refreshParent');
        // This will hide the modal in the frontend
        $this->dispatchBrowserEvent('closeDeleteModal');
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.menuitem.menuitemall',[
            'datamenuitem' => $this->menuitem,
        ]);
    }
}
