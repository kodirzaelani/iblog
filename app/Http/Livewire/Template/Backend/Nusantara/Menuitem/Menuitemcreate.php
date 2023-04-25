<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Menuitem;

use App\Models\Page;
use App\Models\Album;
use Livewire\Component;
use App\Models\Postcategory;
use App\Models\Itemmenufrontend;
use NguyenHuy\Menu\Models\Menus;
use App\Models\Structuroganization;

class Menuitemcreate extends Component
{
    public $label;
    public $status;
    public $link;
    public $menu;
    public $typemenu;
    public $linkid;
    public $target;
    public $urlnow;



    public function store()
    {
        $validateData = [
            'label'    => 'required|min:2',
            'menu'     => 'required',
            'typemenu' => 'required',
            'target'   => 'required',
            // 'link'     => 'required',
        ];

        $this->urlnow = config('app.url');


        if ($this->link == '/') {
            $basicurl = $this->urlnow;
        } else {
            $basicurl = $this->urlnow.'/'.$this->link;
        }

        if ($this->typemenu == 9) {
            $blink   = $this->link;
        } else {
            $blink   = $basicurl;
        }


         // Default data
         $data = [
            'label'    => $this->label,
            'menu'     => $this->menu,
            'typemenu' => $this->typemenu,
            'target'   => $this->target,
            'link'     => $blink,
            'status'   => 1,
        ];

        $this->validate($validateData);
        $menuitem = Itemmenufrontend::create($data);

        // even listener -> emit
        $this->emit('menuitemStored', $menuitem);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->label = null;
        $this->link = null;
        $this->menu = null;
        $this->typemenu = null;
        $this->linkid = null;
        $this->target = null;
    }
    public function selectCancel($action)
    {
        if ($action == 'cancel') {
            $this->emit('menuitemCancel');
            $this->cleanVars();
            $this->resetErrorBag();
            $this->resetValidation();
        }
    }
    public function render()
    {
        return view('livewire.template.backend.nusantara.menuitem.menuitemcreate', [
            'menus' => Menus::orderBy('name', 'asc')->where('status', 1)->get(),
            'pages' => Page::orderBy('title', 'asc')->where('status', 1)->get(),
            'albums' => Album::orderBy('title', 'asc')->where('status', 1)->get(),
            'postcategory' => Postcategory::orderBy('title', 'asc')->get(),
            'postcategory' => Postcategory::orderBy('title', 'asc')->get(),
            'structuroganizations' => Structuroganization::where('status', 1)->get(),
        ]);
    }
}
