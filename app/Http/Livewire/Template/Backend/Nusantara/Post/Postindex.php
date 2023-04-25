<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Post;

use Livewire\Component;

class Postindex extends Component
{
    public $statusView  = 0;
    public $action;
    public $title = 'Post All';

    public function selectItem($action)
    {
        $this->statusView = 0;

        if ($action == 'all') {
            $this->statusView = 0;
            $this->title = 'Post All';
        } elseif ($action == 'published') {
            $this->statusView = 1;
            $this->title = 'Post Published';
        } elseif ($action == 'draft') {
            $this->statusView = 2;
            $this->title = 'Post Draft';
        } elseif ($action == 'trash') {
            $this->statusView = 3;
            $this->title = 'Post Trashed';
        } else {
            $this->statusView = 4;
            $this->title = 'Post Own';
        }
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.post.postindex');
    }
}
