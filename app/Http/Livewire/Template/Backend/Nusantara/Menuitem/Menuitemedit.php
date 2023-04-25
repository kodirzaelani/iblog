<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Menuitem;

use App\Models\Page;
use App\Models\Album;
use Livewire\Component;
use App\Models\Menufrontend;
use App\Models\Postcategory;
use App\Models\Itemmenufrontend;
use App\Models\Structuroganization;

class Menuitemedit extends Component
{
    public $label;
    public $link;
    public $menu;
    public $typemenu;
    public $linkid;
    public $prevlink;
    public $target;

    public $urlnow;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Itemmenufrontend::find($this->modelId);

        $this->label      = $model->label;
        $this->link       = $model->link;
        $this->menu       = $model->menu;
        $this->typemenu   = $model->typemenu;
        $this->prevlink = $model->link;
        $this->target = $model->target;
    }

    public function update()
    {
        $validateData = [
            'label'      => 'required|min:2',
            'typemenu'   => 'required',
            'menu'       => 'required',
        ];

        $data = [];
        // Default data
        $data = [
            'label'      => $this->label,
            'typemenu'   => $this->typemenu,
            'menu'       => $this->menu,
            'target'     => $this->target,
        ];

        $this->urlnow = config('app.url');

        if ($this->link == '/') {
            $basicurl = $this->urlnow;
        } else {
            $basicurl = $this->urlnow.'/'.$this->link;
        }

        if ($this->typemenu == 9) {
            $blink   = $this->link;
            $data = array_merge($data, [
                'link'   => $blink,
            ]);
        } else {
            $blink   = $basicurl;
            $data = array_merge($data, [
                'link'   => $blink,
            ]);
        }

        // if ($this->typemenu == 1) {
        //     $blink   = $basicurl;
        //     $data = array_merge($data, [
        //         'link'   => $blink,
        //     ]);
        // } elseif ($this->typemenu == 9) {
        //     $blink   = $this->link;
        //     $data = array_merge($data, [
        //         'link'   => $blink,
        //     ]);
        // } else{
        //     $blink   = $basicurl;
        //     $data = array_merge($data, [
        //         'link'   => $blink,
        //     ]);
        // }

        // Just add validation if there are any changes in the fields
        $this->validate($validateData);

        $menuitem = Itemmenufrontend::find($this->modelId);

        $menuitem->update($data);

        // even listener -> emit
        $this->emit('menuitemUpdated', $menuitem);
        // This is to reset our public variables
        $this->cleanVars();

    }

    private function cleanVars()
    {
        // Kosongkan field input
        $this->label      = null;
        $this->link       = null;
        $this->menu       = null;
        $this->typemenu   = null;
        $this->linkid     = null;
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
        return view('livewire.template.backend.nusantara.menuitem.menuitemedit', [
            'menus' => Menufrontend::orderBy('name', 'asc')->where('status', '1')->get(),
            'pages' => Page::orderBy('title', 'asc')->where('status', 1)->get(),
            'albums' => Album::orderBy('title', 'asc')->where('status', 1)->get(),
            'postcategory' => Postcategory::orderBy('title', 'asc')->get(),
            'structuroganizations' => Structuroganization::where('status', 1)->get(),
        ]);
    }
}
