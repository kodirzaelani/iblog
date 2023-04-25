<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Pengajian\Pengajiancategory;

use App\Models\Pengajiancategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;


class Pengajiancategorycreate extends Component
{
    use WithFileUploads;
    public $image;
    public $title;
    public $slug;



    public function store()
    {
        $validateData = [
            'title' => 'required|min:2|unique:pengajiancategories,title',
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
            'author_id'          => Auth::id(),
        ];

        if (!empty($this->image)) {
            $imageHashName = $this->image->hashName();

            // Upload the main image
            $this->image->store('images/pengajiancategory/');

            // Create a thumbnail of the image using Intervention Image Library
            $manager = new ImageManager();
            $imagedata = $manager->make('uploads/images/pengajiancategory/'.$imageHashName)->resize(120, 100); // Jangan lupa sesauikan nama folder dengan public folder image
            $imagedata->save(public_path('uploads/images/pengajiancategory/images_thumb/'.$imageHashName)); // Jangan lupa buat folder sesuai dengan rencana penyimpanan

            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'image' => $imageHashName
            ]);

        }

        $pengajiancategory = Pengajiancategory::create($data);

        // even listener -> emit
        $this->emit('pengajiancategoryStored', $pengajiancategory);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title = null;
        $this->image = '';
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.pengajian.pengajiancategory.pengajiancategorycreate',[
            'title' => 'Create Pengajian',
        ]);
    }
}
