<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Download;

use Livewire\Component;

class Downloadindex extends Component
{
    public $statusView  = 0;
    public $action;
    public $title = 'Download All';

    public function selectItem($action)
    {
        $this->statusView = 0;

        if ($action == 'all') {
            $this->statusView = 0;
            $this->title = 'Download All';
        } elseif ($action == 'published') {
            $this->statusView = 1;
            $this->title = 'Download Published';
        } elseif ($action == 'draft') {
            $this->statusView = 2;
            $this->title = 'Download Draft';
        } elseif ($action == 'trash') {
            $this->statusView = 3;
            $this->title = 'Download Trashed';
        } else {
            $this->statusView = 4;
            $this->title = 'Download Own';
        }
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.download.downloadindex');
    }
}
