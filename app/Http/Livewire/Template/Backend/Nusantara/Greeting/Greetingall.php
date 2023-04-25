<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Greeting;

use App\Models\Greeting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Greetingall extends Component
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
    public $uploadPath= 'uploads/images/greetings';

    public $title;
    public $slug;


    protected $listeners = [
        'greetingStored',
        'greetingUpdated',
    ];

    protected $queryString = [
        // Keeping A Clean Query String https://laravel-livewire.com/docs/2.x/query-string#clean-query-string
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'image'      => 'Image',
            'title'      => 'Title',
            'status'     => 'Status',
            'created_at' => 'Created',
            'updated_by' => 'UpdatedBy',
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

    public function getGreetingallQueryProperty()
    {

        return Greeting::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getGreetingallProperty()
    {
        return $this->greetingallQuery->paginate($this->paginate);
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->greetingall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->greetingallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function greetingStored($greeting)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'icon'=>'success',
            'text'=>'Page Category ' . $greeting['title'] . ' was Stored',
            'toast'=>true, // Jika mau menggunakan toas
            'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function greetingUpdated($greeting)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'icon'=>'success',
            'text'=>'Page Category ' . $greeting['title'] . ' was Updated',
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
        } elseif ($action == 'inactive'){
            $this->changeInactive();
        } elseif ($action == 'active') {
            $this->changeActive();
        } elseif ($action == 'imageinactive') {
            $this->changeImageinactive();
        } elseif ($action == 'imageactive') {
            $this->changeImageActive();
        } elseif ($action == 'imageremove') {
            // This will show the modal in the frontend
            $this->dispatchBrowserEvent('openmodalFormRemoveImage');
        }
    }
    public function changeInactive()
    {
        $data = [];
        $data = array_merge($data, ['status' => 0]);
        $data = array_merge($data, ['updated_by' => Auth::id()]);
        $greeting = Greeting::find($this->selectedItem);

        $greeting->update($data);
        session()->flash('success', 'Page Change to Draft was successfully');
        return redirect()->to('backend/greetings');
    }
    public function changeActive()
    {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $data = array_merge($data, ['updated_by' => Auth::id()]);
        $greeting = Greeting::find($this->selectedItem);

        $greeting->update($data);
        session()->flash('success', 'Page Change to Publish was successfully');
        return redirect()->to('backend/greetings');
    }

    public function changeImageinactive()
    {
        $data = [];
        $data = array_merge($data, ['masterstatus' => 1]);
        $data = array_merge($data, ['updated_by' => Auth::id()]);
        $page = Greeting::find($this->selectedItem);

        $page->update($data);
        session()->flash('success', 'Image Greeting Change to unPublish was successfully');
        return redirect()->to('backend/greetings');
    }
    public function changeImageActive()
    {
        $data = [];
        $data = array_merge($data, ['masterstatus' => 0]);
        $data = array_merge($data, ['updated_by' => Auth::id()]);
        $page = Greeting::find($this->selectedItem);

        $page->update($data);
        session()->flash('success', 'Image Greeting Change to Publish was successfully');
        return redirect()->to('backend/greetings');
    }

    public function deleteRecords()
    {
        Greeting::whereKey($this->checked)->delete();

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
    public function remove_image()
    {
        $data = [];
        $data = array_merge($data, ['image' => NULL]);
        $greeting = Greeting::find($this->selectedItem);

        $greeting->update($data);

        if ($greeting->image) {
            $this->removeImage($greeting->image);
        }

        $this->dispatchBrowserEvent('closemodalFormRemoveImage');
        session()->flash('success', 'Remove Image was successfully');
        return redirect()->to('backend/admin/greetings');
    }

    public function delete()
    {
        $greeting = Greeting::find($this->selectedItem);

        if ($greeting->image) {
            $this->removeImage($greeting->image);
        }

        Greeting::destroy($this->selectedItem);

        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Deleted Success!',
            'timer' => 4000,
            'icon'  => 'success',
            'text'  => 'Page Category was deleted',
            // 'toast'=>true, // Jika mau menggunakan toas
            // 'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton' => true,
            'showCancelButton'  => false,
        ]);

        $this->emit('refreshParent');
        // This will hide the modal in the frontend
        $this->dispatchBrowserEvent('closeDeleteModal');
    }

    private function removeImage($image)
    {
        if ( ! empty($image) )
        {
            $imagePath     = $this->uploadPath . '/' . $image;
            $ext           = substr(strrchr($image, '.'), 1);
            $thumbnail     = str_replace(".{$ext}", "_thumb.{$ext}", $image);
            $thumbnailPath = $this->uploadPath . '/' . $thumbnail;

            if ( file_exists($imagePath) ) unlink($imagePath);
            if ( file_exists($thumbnailPath) ) unlink($thumbnailPath);
        }
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.greeting.greetingall',[
            'datagreetingall' => $this->greetingall,
        ]);
    }


}
