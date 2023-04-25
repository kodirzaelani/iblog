<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Postall extends Component
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
    public $uploadPath= 'uploads/images/posts';

    public $author_id;
    public $title;
    public $slug;

    protected $queryString = [
        // Keeping A Clean Query String https://laravel-livewire.com/docs/2.x/query-string#clean-query-string
        'search'      => ['except' => ''],
        'currentPage' => ['except' => 1]
    ];

    private function headerConfig()
    {
        return [
            'image'           => 'Image',
            'author_id'       => 'Author',
            'title'           => 'Title',
            // 'postcategory_id' => 'Category',
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

    public function getPostallQueryProperty()
    {
        $this->author_id = Auth::id();
        return Post::with('author', 'postcategory')->orderBy($this->sortColumn, $this->sortDirection)
        ->search(trim($this->search)); //search menggunakan scopeSearch di model
    }

    public function getPostallProperty()
    {
        return $this->postallQuery->paginate($this->paginate);
    }

    public function updatedSelectPost($value)
    {
        if ($value) {
            $this->checked = $this->postall->pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
        $this->checked = $this->postallQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checked);
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
        } elseif($action == 'publish') {
            $this->changePublish();
        } elseif($action == 'inactiveh'){
            $this->changeHinactive();
        } elseif($action == 'activeh') {
            $this->changeHactive();
        } elseif($action == 'primary'){
            $this->changePrimary();
        } elseif($action == 'selection') {
            $this->changeSelection();
        }
    }

    public function changeHinactive()
    {
        $data = [];
        $data = array_merge($data, ['headline' => 0]);
        $post = Post::find($this->selectedItem);

        $post->update($data);
        session()->flash('success', 'Post Change to Headline non active was successfully');
        return redirect()->to('backend/allposts');
    }
    public function changeHactive()
    {
        $data = [];
        $data = array_merge($data, ['headline' => 1]);
        $post = Post::find($this->selectedItem);

        $post->update($data);
        session()->flash('success', 'Post Change to Headline active was successfully');
        return redirect()->to('backend/allposts');
    }
    public function changePrimary()
    {
        $data = [];
        $data = array_merge($data, ['selection' => 0]);
        $post = Post::find($this->selectedItem);

        $post->update($data);
        session()->flash('success', 'Post Change to Primary  was successfully');
        return redirect()->to('backend/allposts');
    }
    public function changeSelection()
    {
        $data = [];
        $data = array_merge($data, ['selection' => 1]);
        $post = Post::find($this->selectedItem);

        $post->update($data);
        session()->flash('success', 'Post Change to Selection active was successfully');
        return redirect()->to('backend/allposts');
    }

    public function changeDraft()
    {
        $data = [];
        $data = array_merge($data, ['status' => 0]);
        $post = Post::find($this->selectedItem);

        $post->update($data);
        session()->flash('success', 'Post Change to Draft was successfully');
        return redirect()->to('backend/allposts');
    }
    public function changePublish()
    {
        $data = [];
        $data = array_merge($data, ['status' => 1]);
        $post = Post::find($this->selectedItem);

        $post->update($data);
        session()->flash('success', 'Post Change to Publish was successfully');
        return redirect()->to('backend/allposts');
    }

    public function deleteRecords()
    {
        Post::whereKey($this->checked)->delete();

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
        $post = Post::find($this->selectedItem);

        Post::destroy($this->selectedItem);

        // Sweet alert
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => 'Success!',
            'timer' => 4000,
            'icon'  => 'success',
            'text'  => 'Post was send to trash',
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
        return view('livewire.template.backend.nusantara.post.postall',[
            'datapostall' => $this->postall,
        ]);
    }
}
