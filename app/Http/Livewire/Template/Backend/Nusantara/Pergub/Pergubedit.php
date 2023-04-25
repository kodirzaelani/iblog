<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Pergub;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Pergub;
use Livewire\WithFileUploads;

class Pergubedit extends Component
{
    use WithFileUploads;
    public $title;
    public $slug;
    public $pergubnum;
    public $year;
    public $about;
    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Pergub::find($this->modelId);

        $this->title     = $model->title;
        $this->pergubnum     = $model->pergubnum;
        $this->year     = $model->year;
        $this->about     = $model->about;
    }

    public function update()
    {
        $validateData = [
            'title' => 'required|min:2',
            'about' => 'required|min:20',
            'pergubnum'     => 'required|min:1',
            'year'     => 'required|min:4|numeric',
        ];

        $this->validate($validateData);

        $data = [];

        $data = [
            'title'     => $this->title,
            'slug'      => Str::slug(time().$this->title,),
            'pergubnum'     => $this->pergubnum,
            'about'     => $this->about,
            'year'     => $this->year,
        ];

        $pergub = Pergub::find($this->modelId);

        $pergub->update($data);

        $this->emit('pergubUpdated', $pergub);
        $this->cleanVars();

    }


    private function cleanVars()
    {
        $this->title = null;
        $this->pergubnum = null;
        $this->year = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.pergub.pergubedit');
    }
}
