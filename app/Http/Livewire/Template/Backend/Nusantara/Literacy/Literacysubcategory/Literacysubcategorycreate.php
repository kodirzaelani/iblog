<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Literacy\Literacysubcategory;

use App\Models\Literacycategory;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Literacysubcategory;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;

class Literacysubcategorycreate extends Component
{
    use WithFileUploads;
    public $image;
    public $title;
    public $slug;
    public $literacycategory_id;



    public function store()
    {
        $validateData = [
            'title' => 'required|min:2|unique:literacysubcategories,title',
            'literacycategory_id' => 'required',
        ];

        // Validate image
        if (!empty($this->image)) {
            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
                'image' => 'image|max:1024'
            ]);
        }

        $this->validate($validateData);

        $data = [];

        // Default data
        $data = [
            'title'     => $this->title,
            'slug'      => Str::slug($this->title,),
            'literacycategory_id'     => $this->literacycategory_id,
        ];

        if (!empty($this->image)) {
            $imageHashName = $this->image->hashName();

            // Upload the main image
            $this->image->store('images/literacysubcategory/');

            // Create a thumbnail of the image using Intervention Image Library
            $manager = new ImageManager();
            $imagedata = $manager->make('uploads/images/literacysubcategory/'.$imageHashName)->resize(120, 100); // Jangan lupa sesauikan nama folder dengan public folder image
            $imagedata->save(public_path('uploads/images/literacysubcategory/images_thumb/'.$imageHashName)); // Jangan lupa buat folder sesuai dengan rencana penyimpanan

            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'image' => $imageHashName
            ]);

        }

        $literacysubcategory = Literacysubcategory::create($data);

        // even listener -> emit
        $this->emit('literacysubcategoryStored', $literacysubcategory);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title = null;
        $this->image = '';
        $this->literacycategory_id = '';
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.literacy.literacysubcategory.literacysubcategorycreate', [
            'literacycategories' => Literacycategory::orderBy('title', 'asc')->get(),
        ]);
    }
}
