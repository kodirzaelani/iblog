<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Widget;

use App\Models\Page;
use App\Models\Album;
use App\Models\Widget;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Postcategory;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use phpDocumentor\Reflection\Types\Nullable;

class Create extends Component
{
    use WithFileUploads;
    public $title;
    public $status;
    public $link = '';
    public $menu;
    public $typelink;
    public $targetview;
    public $image;
    public $position;
    public $description;
    public $typecontent;
    public $scripthtml;
    public $typewidget;
    public $positionaction;
    public $statustitle;



    public function store()
    {
        $validateData = [
            'title'       => 'required|min:5',
            'description' => 'required',
            'typewidget'  => 'required',
            'statustitle' => 'required',
            'position'    => 'required',
        ];

        // Validate scripthtml
        if (!empty($this->scripthtml)) {
            // Append to the validation if scripthtml is not empty
            $validateData = array_merge($validateData, [
                'scripthtml' => 'min:10'
            ]);
        }

        // Validate image
        if ($this->typewidget == 4) {
            if (!empty($this->image)) {
                // Append to the validation if image is not empty
                $validateData = array_merge($validateData, [
                    'image' => 'image|max:500',
                ]);
            }
        } else {
            if (!empty($this->image)) {
                // Append to the validation if image is not empty
                $validateData = array_merge($validateData, [
                    'image' => 'image|max:1024',
                ]);
            }
        }



        if ($this->typewidget == 1) {
            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
                'typelink'  => 'required',
                'typecontent' => 'required',
            ]);
        }
        if ($this->typewidget == 2) {
            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
                'typecontent' => 'required',
            ]);
        }

        if ($this->typecontent == 1) {
            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
                'targetview'  => 'required',
            ]);
        }

        if ($this->typewidget == 3 || $this->typewidget == 4) {
            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
                'link'       => 'required',
                'targetview' => 'required',
            ]);
        }


        $data = [];
        // Default data
        $data = [
            'title'       => $this->title,
            'slug'        => Str::slug($this->title),
            'description' => $this->description,
            'typewidget'  => $this->typewidget,
            'typelink'    => $this->typelink,
            'typecontent' => $this->typecontent,
            'targetview'  => $this->targetview,
            'position'    => $this->position,
            'link'        => $this->link,
            'author_id'   => Auth::id(),
            'status'      => 1,
        ];

        // Validate image
        if ($this->typewidget == 4) {
            if (!empty($this->image)) {
                $imageHashName = $this->image->hashName();

                // Upload the main image
                $this->image->store('images/widget/');

                // Create a thumbnail of the image using Intervention Image Library
                $manager = new ImageManager();
                $imagedata = $manager->make('uploads/images/widget/'.$imageHashName)->resize(320, 100); // Jangan lupa sesauikan nama folder dengan public folder image
                $imagedata->save(public_path('uploads/images/widget/images_thumb/'.$imageHashName)); // Jangan lupa buat folder sesuai dengan rencana penyimpanan

                // This is to save the filename of the image in the database
                $data = array_merge($data, [
                    'image' => $imageHashName
                ]);

            }
        } else {
            if (!empty($this->image)) {
                $imageHashName = $this->image->hashName();

                // Upload the main image
                $this->image->store('images/widget/');

                // Create a thumbnail of the image using Intervention Image Library
                $manager = new ImageManager();
                $imagedata = $manager->make('uploads/images/widget/'.$imageHashName)->resize(220, 120); // Jangan lupa sesauikan nama folder dengan public folder image
                $imagedata->save(public_path('uploads/images/widget/images_thumb/'.$imageHashName)); // Jangan lupa buat folder sesuai dengan rencana penyimpanan

                // This is to save the filename of the image in the database
                $data = array_merge($data, [
                    'image' => $imageHashName
                ]);

            }
        }


        if (!empty($this->scripthtml)) {
            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'scripthtml' => $this->scripthtml
            ]);
        }
        if (!empty($this->statustitle)) {
            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'statustitle' => $this->statustitle
            ]);
        }

        $this->validate($validateData);

        $widget = Widget::create($data);

        // even listener -> emit
        $this->emit('widgetStored', $widget);

        // This is to reset our public variables
        $this->cleanVars();
    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title       = null;
        $this->link        = null;
        $this->menu        = null;
        $this->typelink    = null;
        $this->targetview  = null;
        $this->position    = null;
        $this->typecontent = null;
        $this->image       = null;
        $this->typewidget  = null;
        $this->description = null;
        $this->statustitle = null;
    }

    public function resetLink()
    {
        $this->link = null;
        $this->emit('refreshParent');
    }
    public function selectPostion($positionaction)
    {
        if ($positionaction == 'fitur') {
            // This will show the modal in the frontend
            $this->typecontent = 1;
        }
    }

    public function resetTypecontent()
    {
        $this->scripthtml = null;
        $this->image = null;
        $this->emit('refreshParent');
    }

    public function selectCancel($action)
    {
        if ($action == 'cancel') {
            $this->emit('widgetCancel');
            $this->cleanVars();
            $this->resetErrorBag();
            $this->resetValidation();
        }
    }
    public function render()
    {
        return view('livewire.template.backend.nusantara.widget.create', [
            'pages' => Page::orderBy('created_at', 'desc')->where('status', 1)->get(),
            'albums' => Album::orderBy('created_at', 'desc')->where('status', 1)->get(),
            'postcategory' => Postcategory::orderBy('created_at', 'desc')->get(),
        ]);
    }

}
