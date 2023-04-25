<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Otheractivity;

use App\Models\Employe;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Otheractivity;
use Illuminate\Support\Facades\Auth;

class Otheractivitycreate extends Component
{
    public $title;
    public $employe_id;
    public $jobtitle;

    public $modelId;

    protected $listeners = [
        'getEmployeId',
    ];

    public function getEmployeId($modelId)
    {
        $this->modelId = $modelId;

    }

    public function store()
    {
        $validateData = [
            'title' => 'required',
            'jobtitle'  => 'required',
        ];

        $this->validate($validateData);

        // dd($this->modelId);

        $data = [];

        $data = [
            'employe_id'=> $this->modelId,
            'title'     => $this->title,
            'slug'      => Str::slug(time().$this->title),
            'jobtitle' => $this->jobtitle,
            'author_id' => Auth::id(),
        ];

        $otheractivity = Otheractivity::create($data);

        $this->emit('otheractivityStored', $otheractivity);
        $this->cleanVars();

    }

    private function cleanVars()
    {
        $this->title = null;
        $this->employe_id = null;
        $this->jobtitle = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.otheractivity.otheractivitycreate');
    }
}
