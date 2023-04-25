<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Download;

use Livewire\Component;
use App\Models\Download;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Downloadcategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class Downloadedit extends Component
{
    use WithFileUploads;
    public $title;
    public $slug;
    public $image;
    public $attach;
    public $urlcontent;
    public $description;
    public $linkdownload;
    public $downloadcategory_id;
    public $prevAttach;
    public $modelId;
    public $original_filename;
    public $uploadPath= 'downloads/files';

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Download::find($this->modelId);

        $this->title               = $model->title;
        $this->downloadcategory_id = $model->downloadcategory_id;
        $this->urlcontent          = $model->urlcontent;
        $this->linkdownload        = $model->linkdownload;
        $this->description         = $model->description;
        $this->prevAttach           = $model->attach;
    }

    public function update()
    {
        $oldAttach = $this->prevAttach;

        $validateData = [
            'title'        => 'required|min:2',
            'description'  => 'required',
            // 'urlcontent'   => 'required',
            // 'linkdownload' => 'required',
        ];

        // Validate image
        if (!empty($this->attach)) {
            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
            'attach'              => 'required|mimes:pdf',
            ]);
        }

        $this->validate($validateData);

        $data = [];

        // Default data
        $data = [
            'title'               => $this->title,
            'slug'                => Str::slug($this->title),
            'downloadcategory_id' => $this->downloadcategory_id,
            'description'         => $this->description,
            'urlcontent'          => $this->urlcontent,
            'linkdownload'        => $this->linkdownload,
            'slug'                => Str::slug($this->title,),
        ];


        if (!empty($this->attach)) {
            $this->original_filename = $this->attach->getClientOriginalName();

            // Upload file
             $this->attach->store('downloads/files', 'public');

            $filename =  $this->attach;
            // This is to save the filename of the attach in the database
            $data = array_merge($data, [
                'attach' => $filename
            ]);

        }

        $download = Download::find($this->modelId);

        $download->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldAttach !== $download->attach) {
            $this->removeAttach($oldAttach);
        }

        // even listener -> emit
        $this->emit('downloadUpdated', $download);
        // This is to reset our public variables
        $this->cleanVars();

    }

    private function removeAttach($oldAttach)
    {
        if ( !empty($oldAttach) )
        {
            $imagePath     = $this->uploadPath . '/' . $oldAttach;

            if ( file_exists($imagePath) ) unlink($imagePath);
        }
    }

    private function cleanVars()
    {
        // Kosongkan field input
        $this->title = null;
        $this->image = null;
        $this->downloadcategory_id = null;
    }


    public function render()
    {
        return view('livewire.template.backend.nusantara.download.downloadedit', [
            'downloadcategories' => Downloadcategory::orderBy('title', 'asc')->get(),
        ]);
    }
}
