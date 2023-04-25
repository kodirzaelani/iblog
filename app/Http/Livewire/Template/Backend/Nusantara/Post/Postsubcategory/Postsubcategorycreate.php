<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Post\Postsubcategory;

use App\Models\Postcategory;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Postsubcategory;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;

class Postsubcategorycreate extends Component
{
    use WithFileUploads;
    public $image;
    public $title;
    public $slug;
    public $postcategory_id;



    public function store()
    {
        $validateData = [
            'title'          => 'required|min:2|unique:postsubcategories,title',
            'postcategory_id' => 'required',
        ];

        // Validate image
        if (!empty($this->image)) {
            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
                'image' => 'image|max:1024|mimes:jpeg,jpg,png'
            ]);
        }

        $this->validate($validateData);

        $data = [];

        // Default data
        $data = [
            'title'          => $this->title,
            'slug'           => Str::slug($this->title,),
            'postcategory_id' => $this->postcategory_id,
        ];

        if (!empty($this->image)) {
            $imageHashName = $this->image->hashName();

            // Upload the main image
            $this->image->store('images/postsubcategory/');

            // Create a thumbnail of the image using Intervention Image Library
            $manager = new ImageManager();
            $imagedata = $manager->make('uploads/images/postsubcategory/'.$imageHashName)->resize(120, 100); // Jangan lupa sesauikan nama folder dengan public folder image
            $imagedata->save(public_path('uploads/images/postsubcategory/images_thumb/'.$imageHashName)); // Jangan lupa buat folder sesuai dengan rencana penyimpanan

            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'image' => $imageHashName
            ]);

        }

        $postsubcategory = Postsubcategory::create($data);

        // even listener -> emit
        $this->emit('postsubcategoryStored', $postsubcategory);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title          = null;
        $this->postcategory_id = null;
        $this->image          = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.post.postsubcategory.postsubcategorycreate', [
            'postcategories' => Postcategory::orderBy('title', 'asc')->get(),
        ]);
    }
}
