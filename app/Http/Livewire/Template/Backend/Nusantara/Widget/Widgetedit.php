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

class Widgetedit extends Component
{
    use WithFileUploads;
    public $title;
    public $status;
    public $link;
    public $prevlink;
    public $menu;
    public $typelink;
    public $prevtypelink;
    public $targetview;
    public $image ;
    public $previmage ;
    public $prevscripthtml ;
    public $position;
    public $description;
    public $typecontent;
    public $scripthtml;
    public $typewidget;
    public $statustitle;
    public $uploadPath= 'uploads/images/widget';

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Widget::find($this->modelId);

        $this->title          = $model->title;
        $this->typewidget     = $model->typewidget;
        $this->link           = $model->link;
        $this->typelink       = $model->typelink;
        $this->prevtypelink   = $model->typelink;
        $this->position       = $model->position;
        $this->typecontent    = $model->typecontent;
        $this->description    = $model->description;
        $this->prevlink       = $model->link;
        $this->previmage      = $model->image;
        $this->prevscripthtml = $model->scripthtml;
        $this->statustitle    = $model->statustitle;
        $this->targetview     = $model->targetview;
    }

    public function update()
    {
        $validateData = [];
        $oldImage  = $this->previmage;

        $validateData = [
            'title'       => 'required|min:5',
            'description' => 'required',
            'typewidget'  => 'required',
            'statustitle' => 'required',
            'position'    => 'required',
        ];

        $data = [];
        // Default data
        $data = [
            'title'       => $this->title,
            'slug'        => Str::slug($this->title),
            'description' => $this->description,
            'typewidget'  => $this->typewidget,
            'typelink'    => $this->typelink,
            'targetview'  => $this->targetview,
            'position'    => $this->position,
            'link'        => $this->link,
            'typecontent' => $this->typecontent,
            'statustitle' => $this->statustitle,
            'updated_by'  => Auth::id(),
        ];


        if ($this->typecontent == 1) {
            // Validate image
            if (!empty($this->image)) {
                // Append to the validation if image is not empty
                $validateData = array_merge($validateData, [
                    'image'      => 'image|mimes:jpeg,jpg,png|max:1000',
                ]);
            }

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
                    'image'      => $imageHashName,
                    'scripthtml' => null,
                ]);

            }
        } else {
            // Validate scripthtml
            if (!empty($this->scripthtml)) {
                // Append to the validation if scripthtml is not empty
                $validateData = array_merge($validateData, [
                    'scripthtml'  => 'min:10',
                    'statustitle' => 'required'
                ]);
            }

            if (!empty($this->scripthtml)) {
                // This is to save the filename of the image in the database
                $data = array_merge($data, [
                    'scripthtml'  => $this->scripthtml
                ]);
            }
            if (!empty($this->statustitle)) {
                // This is to save the filename of the image in the database
                $data = array_merge($data, [
                    'statustitle' => $this->statustitle
                ]);
            }
        }
        if ($this->typewidget == 3 || $this->typewidget == 4) {
            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
                'link'       => 'required',
                'targetview' => 'required',
            ]);
        }
        if ($this->typewidget == 4) {
            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
                'image'       => 'required|max:512',
            ]);
        }

        $this->validate($validateData);

        $widget = Widget::find($this->modelId);

        $widget->update($data);

        // Jika scripthtml isi maka lakukan hapus gambar
        if (!empty($widget->scripthtml)) {
            $this->removeImage($oldImage);
        }

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $widget->image) {
            $this->removeImage($oldImage);
        }

        // This is to reset our public variables
        $this->cleanVars();

        // even listener -> emit
        $this->emit('widgetUpdated', $widget);


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
        $this->image       = null;
        $this->previmage   = null;
        $this->typewidget  = null;
        $this->description = null;
    }

    public function resetLink()
    {
        $this->link = null;
    }

    public function resetTypecontent()
    {
        $this->scripthtml = null;
        $this->image = null;
    }

    public function selectCancel($action)
    {
        if ($action == 'cancel') {
            $this->emit('widgeteditCancel');
            $this->cleanVars();
            $this->resetErrorBag();
            $this->resetValidation();
        }
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
        return view('livewire.template.backend.nusantara.widget.widgetedit', [
            'pages' => Page::orderBy('created_at', 'desc')->where('status', 1)->get(),
            'albums' => Album::orderBy('created_at', 'desc')->where('status', 1)->get(),
            'postcategory' => Postcategory::orderBy('created_at', 'desc')->get(),
        ]);
    }
}
