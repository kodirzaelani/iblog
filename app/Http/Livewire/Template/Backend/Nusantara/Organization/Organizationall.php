<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Organization;

use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;


class Organizationall extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $currentPage   = 1;
    public $paginate      = 10;
    public $search        = '';
    public $checked       = [];
    public $selectOrganization    = false;
    public $selectAll     = false;
    public $sortDirection = 'asc';
    public $sortColumn    = 'urut';
    public $statusUpdate  = false;
    public $headersTable;
    public $action;
    public $selectedItem;
    public $uploadPath= 'uploads/images/organizations';

    public $title;
    public $slug;


    protected $listeners = [
        'organizationStored',
        'organizationUpdated',
    ];

    protected $queryString = [
        // Keeping A Clean Query String https://laravel-livewire.com/docs/2.x/query-string#clean-query-string
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'logo'      => 'Logo',
            'title'      => 'Title',
            'parent_id' => 'Parent',
            'updated_by' => 'UpdatedBy',
            // 'status'     => 'Status',
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

    public function getOrganizationallQueryProperty()
    {

        return Organization::orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getOrganizationallProperty()
    {
        return $this->organizationallQuery->paginate($this->paginate);
    }

    public function updatedSelectOrganization($value)
    {
        if ($value) {
            $this->checked = $this->organizationall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->checked = [];
        }
    }

    public function updatedChecked()
    {
        $this->selectOrganization = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->organizationallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function organizationStored($organization)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'icon'=>'success',
            'text'=>'Organization Category ' . $organization['title'] . ' was Stored',
            'toast'=>true, // Jika mau menggunakan toas
            'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton'=>true,
            'showCancelButton'=>false,
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function organizationUpdated($organization)
    {
        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer'=>5000,
            'icon'=>'success',
            'text'=>'Organization Category ' . $organization['title'] . ' was Updated',
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

        $organization = Organization::find($this->selectedItem);

        $organization->update($data);
        session()->flash('success', 'Organization Change to Draft was successfully');
        return redirect()->to('backend/organizations');
    }
    public function changeActive()
    {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $data = array_merge($data, ['updated_by' => Auth::id()]);
        $organization = Organization::find($this->selectedItem);

        $organization->update($data);
        session()->flash('success', 'Organization Change to Publish was successfully');
        return redirect()->to('backend/organizations');
    }
    public function changeImageinactive()
    {
        $data = [];
        $data = array_merge($data, ['masterstatus' => 1]);
        $data = array_merge($data, ['updated_by' => Auth::id()]);
        $organization = Organization::find($this->selectedItem);

        $organization->update($data);
        session()->flash('success', 'Image Organization Change to unPublish was successfully');
        return redirect()->to('backend/organizations');
    }
    public function changeImageActive()
    {
        $data = [];
        $data = array_merge($data, ['masterstatus' => 0]);
        $data = array_merge($data, ['updated_by' => Auth::id()]);
        $organization = Organization::find($this->selectedItem);

        $organization->update($data);
        session()->flash('success', 'Image Organization Change to Publish was successfully');
        return redirect()->to('backend/organizations');
    }
    public function deleteRecords()
    {
        Organization::whereKey($this->checked)->delete();

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
        $organization = Organization::find($this->selectedItem);

        $organization->update($data);

        if ($organization->logo) {
            $this->removeImage($organization->logo);
        }

        $this->dispatchBrowserEvent('closemodalFormRemoveImage');
        session()->flash('success', 'Remove Image was successfully');
        return redirect()->to('backend/organizations');
    }

    public function delete()
    {
        $organization = Organization::find($this->selectedItem);

        if ($organization->logo) {
            $this->removeImage($organization->logo);
        }

        Organization::destroy($this->selectedItem);

        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Deleted Success!',
            'timer' => 4000,
            'icon'  => 'success',
            'text'  => 'Organization Category was deleted',
            // 'toast'=>true, // Jika mau menggunakan toas
            // 'position'=>'top-right', // Jika mau menggunakan toas
            'showConfirmButton' => true,
            'showCancelButton'  => false,
        ]);

        $this->emit('refreshParent');
        // This will hide the modal in the frontend
        $this->dispatchBrowserEvent('closeDeleteModal');
    }

    private function removeImage($logo)
    {
        if ( ! empty($logo) )
        {
            $imagePath     = $this->uploadPath . '/' . $logo;
            $ext           = substr(strrchr($logo, '.'), 1);
            $thumbnail     = str_replace(".{$ext}", "_thumb.{$ext}", $logo);
            $thumbnailPath = $this->uploadPath . '/' . $thumbnail;

            if ( file_exists($imagePath) ) unlink($imagePath);
            if ( file_exists($thumbnailPath) ) unlink($thumbnailPath);
        }
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.organization.organizationall',[
            'dataorganizationall' => $this->organizationall,
        ]);
    }
}
