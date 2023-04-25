<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Structuroganization;

use App\Models\Pergub;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Structuroganization;
use Illuminate\Support\Facades\Auth;

class Structuroganizationcreate extends Component
{
    public $pergub_id;
    public $slug;
    public $department;
    public $title;
    public $sort;
    public $parent_id;



    public function store()
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
            'author_id'     => Auth::id(),
        ];

        $structuroganization = Structuroganization::create($data);

        $this->emit('structuroganizationStored', $structuroganization);
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
        return view('livewire.template.backend.nusantara.structuroganization.structuroganizationcreate',[
            'pergubs' => Pergub::orderBy('year', 'asc')->get(),
            'strukturorganisasi' => Structuroganization::orderBy('sort', 'asc')->get(),
        ]);
    }
}
