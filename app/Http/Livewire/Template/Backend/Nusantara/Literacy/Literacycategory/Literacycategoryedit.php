<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Literacy\Literacycategory;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Literacycategory;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;

class Literacycategoryedit extends Component
{
    use WithFileUploads;
    public $title;
    public $slug;
    public $image;
    public $prevImage;
    public $modelId;
    public $uploadPath= 'uploads/images/literacycategory';

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Literacycategory::find($this->modelId);

        $this->title     = $model->title;
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
            'slug'      => Str::slug($this->title,),
        ];

        if (!empty($this->image)) {
            $imageHashName = $this->image->hashName();

            // Upload the main image
            $this->image->store('images/literacycategory/');

            // Create a thumbnail of the image using Intervention Image Library
            $manager = new ImageManager();
            $imagedata = $manager->make('uploads/images/literacycategory/'.$imageHashName)->resize(120, 100); // Jangan lupa sesauikan nama folder dengan public folder image
            $imagedata->save(public_path('uploads/images/literacycategory/images_thumb/'.$imageHashName)); // Jangan lupa buat folder sesuai dengan rencana penyimpanan

            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'image' => $imageHashName
            ]);
        }



        $literacycategory = Literacycategory::find($this->modelId);

        $literacycategory->update($data);

        $oldImage = $this->prevImage;
        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $literacycategory->image) {
            $this->removeImage($oldImage);
        }

        // even listener -> emit
        $this->emit('literacycategoryUpdated', $literacycategory);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title = null;
        $this->image = null;
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
        return view('livewire.template.backend.nusantara.literacy.literacycategory.literacycategoryedit');
    }
}
