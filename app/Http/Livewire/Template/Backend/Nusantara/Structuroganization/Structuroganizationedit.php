<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Structuroganization;

use App\Models\Pergub;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Structuroganization;
use Illuminate\Support\Facades\Auth;

class Structuroganizationedit extends Component
{
    public $pergub_id;
    public $slug;
    public $department;
    public $title;
    public $parent_id;
    public $sort;
    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Structuroganization::find($this->modelId);

        $this->pergub_id     = $model->pergub_id;
        $this->department     = $model->department;
        $this->title     = $model->title;
        $this->parent_id     = $model->parent_id;
        $this->sort     = $model->sort;
    }

    public function update()
    {
        $validateData = [
            'pergub_id' => 'required',
            'sort' => 'required',
            'department'     => 'required|min:4',
            'title'     => 'required|min:4',
        ];

        $this->validate($validateData);

        $data = [];

        $data = [
            'pergub_id'     => $this->pergub_id,
            'department'     => $this->department,
            'slug'      => Str::slug(time().$this->department),
            'title'     => $this->title,
            'parent_id'     => $this->parent_id,
            'sort'     => $this->sort,
            'updated_by'     => Auth::id(),
        ];

        $structuroganization = Structuroganization::find($this->modelId);

        $structuroganization->update($data);

        $this->emit('structuroganizationUpdated', $structuroganization);
        $this->cleanVars();

    }


    private function cleanVars()
    {
        $this->pergub_id = null;
        $this->department = null;
        $this->title = null;
        $this->parent_id = null;
        $this->sort = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.structuroganization.structuroganizationedit',[
            'pergubs' => Pergub::orderBy('year', 'asc')->get(),
            'strukturorganisasi' => Structuroganization::orderBy('sort', 'asc')->get(),
        ]);
    }
}
