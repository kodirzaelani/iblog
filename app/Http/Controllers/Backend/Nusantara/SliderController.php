<?php

namespace App\Http\Controllers\Backend\Nusantara;


use App\Models\Page;
use App\Models\Slider;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestSliderStore;
use App\Http\Requests\RequestSliderUpdate;
use App\Models\Post;

class SliderController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:sliders.index|sliders.create|sliders.edit|sliders.delete|sliders.trash']);
        $this->uploadPath = public_path(config('cms.image.directorySliders'));
    }

    public function index()
    {
        return view('template.backend.nusantara.slider.index');
    }

    public function create()
    {
        return view('template.backend.nusantara.slider.create', [
            'posts' => Post::published()->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function store(RequestSliderStore $request)
    {

        // Default data
        $data = [
            'title'               => $request->input('title'),
            'slug'                => Str::slug($request->input('title')),
            'excerpt'             => $request->input('excerpt'),
            'status'              => $request->input('status'),
            'show_attribute'      => $request->input('show_attribute'),
            'statusbanner'        => $request->input('statusbanner'),
            'author_id'           => Auth::id(),
        ];


        if ($request->input('show_attribute') == 1) {
            $data = array_merge($data, [
                'post_id'              => $request->input('post_id'),
                'video'                => null,
            ]);
        } elseif ($request->input('show_attribute') == 2) {
            $data = array_merge($data, [
                'video'                => $request->input('video'),
                'post_id'              => null,
            ]);
        } elseif ($request->input('show_attribute') == 0) {
            $data = array_merge($data, [
                'video'                => null,
                'post_id'              => null,
            ]);
        }

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName    = time() . "_slider." . $extension;
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(1920, 1088);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailslider.width');
                $height = config('cms.image.thumbnailslider.height');

                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                image::make($destination . '/' . $fileName)
                    ->resize($width, $height)
                    ->save($destination . '/' . $thumbnail);
            }

            // Tampung isi image ke variable data
            $image_data = $fileName;
            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'image' => $image_data
            ]);
        }

        $slider = Slider::create($data);

        //redirect dengan pesan sukses
        return redirect()->route('backend.sliders.index')->with(['success' => 'Data Slider Berhasil Disimpan!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('template.backend.nusantara.slider.edit', [
            'pages' => Page::orderBy('title', 'asc')->where('status', 1)->get(),
            'posts' => Post::published()->orderBy('created_at', 'desc')->get(),
            'slider' => $slider,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestSliderUpdate $request, Slider $slider)
    {
        //cek gambar lama
        $oldImage = $slider->image;

        // Default data
        $data = [
            'title'             => $request->input('title'),
            'slug'              => Str::slug($request->input('title')),
            'excerpt'           => $request->input('excerpt'),
            'status'            => $request->input('status'),
            'show_attribute'    => $request->input('show_attribute'),
            'statusbanner'      => $request->input('statusbanner'),
            'video'             => $request->input('video'),
            'updated_by'        => Auth::id(),
        ];

        if ($request->input('show_attribute') == 1) {
            $data = array_merge($data, [
                'post_id'              => $request->input('post_id'),
                'video'                => null,
            ]);
        } elseif ($request->input('show_attribute') == 2) {
            $data = array_merge($data, [
                'video'                => $request->input('video'),
                'post_id'              => null,
            ]);
        } elseif ($request->input('show_attribute') == 0) {
            $data = array_merge($data, [
                'video'                => null,
                'post_id'              => null,
            ]);
        }


        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image       = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName    = time() . "_slider." . $extension;
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(1920, 1088);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width     = config('cms.image.thumbnailslider.width');
                $height    = config('cms.image.thumbnailslider.height');
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                image::make($destination . '/' . $fileName)
                    ->resize($width, $height)
                    ->save($destination . '/' . $thumbnail);
            }

            // Tampung isi image ke variable data
            $image_data = $fileName;
            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'image' => $image_data
            ]);
        }

        $slider->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $slider->image) {
            $this->removeImage($oldImage);
        }

        return redirect()->route('backend.sliders.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
    }

    // function remove image
    private function removeImage($image)
    {
        if (!empty($image)) {
            $imagePath     = $this->uploadPath . '/' . $image;
            $ext           = substr(strrchr($image, '.'), 1);
            $thumbnail     = str_replace(".{$ext}", "_thumb.{$ext}", $image);
            $thumbnailPath = $this->uploadPath . '/' . $thumbnail;

            if (file_exists($imagePath)) unlink($imagePath);
            if (file_exists($thumbnailPath)) unlink($thumbnailPath);
        }
    }
}
