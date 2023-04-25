<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Literacy\Literacysubcategory;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Literacycategory;
use App\Models\Literacysubcategory;
use Intervention\Image\ImageManager;

class Literacysubcategoryedit extends Component
{
    use WithFileUploads;
    public $title;
    public $slug;
    public $image;
    public $prevImage;
    public $modelId;
    public $uploadPath= 'uploads/images/literacysubcategory';

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Literacysubcategory::find($this->modelId);

        $this->title     = $model->title;
        $this->literacycategory_id     = $model->literacycategory_id;
        $this->prevImage = $model->image;
    }

    public function update()
    {
        $validateData = [
            'title' => 'required|min:2',
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
            'literacycategory_id'     => $this->literacycategory_id,
            'slug'      => Str::slug($this->title,),
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



        $literacysubcategory = Literacysubcategory::find($this->modelId);

        $literacysubcategory->update($data);

        $oldImage = $this->prevImage;
        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $literacysubcategory->image) {
            $this->removeImage($oldImage);
        }

        // even listener -> emit
        $this->emit('literacysubcategoryUpdated', $literacysubcategory);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title = null;
        $this->image = null;
        $this->literacycategory_id = null;
    }

    private function removeImage($oldImage)
    {
        if ( ! empty($oldImage) )
        {
            $imagePath     = $this->uploadPath . '/' . $oldImage;
            $thumbnailPath = $this->uploadPath . '/images_thumb/' . $oldImage;

            if ( file_exists($imagePath) ) unlink($imagePath);
            if ( file_exists($thumbnailPath) ) unlink($thumbnailPath);
        }
    }
    public function render()
    {
        return view('livewire.template.backend.nusantara.literacy.literacysubcategory.literacysubcategoryedit', [
            'literacycategories' => Literacycategory::orderBy('title', 'asc')->get(),
        ]);
    }
}
