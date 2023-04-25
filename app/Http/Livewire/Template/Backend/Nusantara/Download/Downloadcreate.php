<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Download;

use Livewire\Component;
use App\Models\Download;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Downloadcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Downloadcreate extends Component
{
    use WithFileUploads;

    public $image;
    public $title;
    public $slug;
    public $urlcontent;
    public $description;
    public $linkdownload;
    public $downloadcategory_id;
    public $attach;
    public $original_filename;

    // public $uploadPath= 'downloads/files';

    public function store()
    {
        $validateData = [
            'title'               => 'required|min:2|unique:downloads,title',
            'downloadcategory_id' => 'required',
            'description'         => 'required',
            // 'urlcontent'          => 'required',
            // 'linkdownload'        => 'required',
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
            'author_id'           => Auth::id(),
        ];



        if (!empty($this->attach)) {
            $cfilename = $this->attach->hashName();

            // This is to save the filename of the attach in the database
            $data = array_merge($data, [
                'attach' => $cfilename
            ]);
            // Upload file
            $this->attach->store('downloads/files');



        }

        $download = Download::create($data);

        // even listener -> emit
        $this->emit('downloadStored', $download);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title = null;
        $this->downloadcategory_id = '';
        $this->attach = '';
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.download.downloadcreate', [
            'downloadcategories' => Downloadcategory::orderBy('title', 'asc')->get(),
            'title' => 'List Download'
        ]);
    }
}
