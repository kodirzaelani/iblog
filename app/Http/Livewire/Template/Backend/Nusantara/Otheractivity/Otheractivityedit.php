<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Otheractivity;

use App\Models\Employe;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Otheractivity;
use Illuminate\Support\Facades\Auth;

class Otheractivityedit extends Component
{
    public $title;
    public $employe_id;
    public $jobtitle;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Otheractivity::find($this->modelId);

        $this->employe_id     = $model->employe_id;
        $this->title     = $model->title;
        $this->jobtitle     = $model->jobtitle;
    }

    public function update()
    {
        $validateData = [
            'employe_id' => 'required',
            'title'     => 'required',
            'jobtitle' => 'required',
        ];

        $this->validate($validateData);

        $data = [];

        $data = [
            // 'employe_id' => $this->employe_id,
            'title'     => $this->title,
            'slug'      => Str::slug(time().$this->title),
            'jobtitle' => $this->jobtitle,
            'updated_by'=> Auth::id(),
        ];

        $otheractivity = Otheractivity::find($this->modelId);
        $otheractivity->update($data);

        $this->emit('historypositionUpdated', $otheractivity);
        $this->cleanVars();
    }

    private function cleanVars()
    {
        $this->employe_id = null;
        $this->title = null;
        $this->jobtitle = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.otheractivity.historypositionedit');
    }
}
