<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Pergub;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Pergub;
use Illuminate\Support\Facades\Auth;

class Pergubcreate extends Component
{
    public $title;
    public $slug;
    public $pergubnum;
    public $year;
    public $about;



    public function store()
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
            'slug'      => Str::slug(time().$this->title),
            'pergubnum'     => $this->pergubnum,
            'year'     => $this->year,
            'about'     => $this->about,
            'author_id'           => Auth::id(),
        ];

        $pergub = Pergub::create($data);

        $this->emit('pergubStored', $pergub);
        $this->cleanVars();

    }


    private function cleanVars()
    {
        $this->title = null;
        $this->pergubnum = null;
        $this->year = null;
        $this->about = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.pergub.pergubcreate');
    }
}
