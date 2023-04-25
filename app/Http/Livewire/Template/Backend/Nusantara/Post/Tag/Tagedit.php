<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Post\Tag;

use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Str;

class Tagedit extends Component
{
    public $title;
    public $slug;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Tag::find($this->modelId);

        $this->title = $model->title;
        // $this->slug = $model->slug;
    }

    public function update()
    {
        $validateData = [
            'title' => 'required|min:2',
        ];

          // Default data
          $data = [
            'title' => $this->title,
            'slug'  => Str::slug($this->title,),
        ];

        $this->validate($validateData);

        $tag = Tag::find($this->modelId);

        $tag->update($data);

        // even listener -> emit
        $this->emit('tagUpdated', $tag);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title = null;
    }
    public function render()
    {
        return view('livewire.template.backend.nusantara.post.tag.tagedit');
    }
}
