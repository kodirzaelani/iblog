<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Literacy;

use Livewire\Component;
use App\Models\Literacy;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Literacycategory;
use App\Models\Literacysubcategory;
use Intervention\Image\ImageManager;

class Literacycreate extends Component
{
    use WithFileUploads;
    public $image;
    public $title;
    public $slug;
    public $literacycategory_id;
    public $literacysubcategory_id;



    public function store()
    {
        $validateData = [
            'title' => 'required|min:2|unique:literacy,title',
            'literacycategory_id' => 'required',
            'literacysubcategory_id' => 'required',
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
            'literacysubcategory_id'     => $this->literacysubcategory_id,
        ];

        if (!empty($this->image)) {
            $imageHashName = $this->image->hashName();

            // Upload the main image
            $this->image->store('images/literacy/');

            // Create a thumbnail of the image using Intervention Image Library
            $manager = new ImageManager();
            $imagedata = $manager->make('uploads/images/literacy/'.$imageHashName)->resize(120, 100); // Jangan lupa sesauikan nama folder dengan public folder image
            $imagedata->save(public_path('uploads/images/literacy/images_thumb/'.$imageHashName)); // Jangan lupa buat folder sesuai dengan rencana penyimpanan

            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'image' => $imageHashName
            ]);

        }

        $literacy = Literacy::create($data);

        // even listener -> emit
        $this->emit('literacyStored', $literacy);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title = null;
        $this->image = '';
        $this->literacycategory_id = '';
        $this->literacysubcategory_id = '';
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.literacy.literacycreate', [
            'literacycategories' => Literacycategory::orderBy('title', 'asc')->get(),
            'literacysubcategories' => Literacysubcategory::orderBy('title', 'asc')->get(),
        ]);
    }
}
