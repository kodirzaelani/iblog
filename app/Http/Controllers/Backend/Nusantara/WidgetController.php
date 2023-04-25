<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Page;
use App\Models\Album;
use App\Models\Widget;
use Illuminate\Support\Str;
use App\Models\Postcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestWidgetStore;
use App\Http\Requests\RequestWidgetUpdate;

class WidgetController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:widgets.index|widgets.create|widgets.edit|widgets.delete|widgets.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryWidget'));
    }

    public function index()
    {
        return view('template.backend.nusantara.widget.index', [
            'title' => 'Widget'
        ]);
    }

    public function create()
    {
        return view('template.backend.nusantara.widget.create', [
            'title'        => 'Widget',
            'typelink'     => '3',
            'pages'        => Page::orderBy('created_at', 'desc')->where('status', 1)->get(),
            'albums'       => Album::orderBy('created_at', 'desc')->where('status', 1)->get(),
            'postcategory' => Postcategory::orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function store(RequestWidgetStore $request)
    {

        // Default data
        $data = [
            'title'      => $request->input('title'),
            'slug'       => Str::slug($request->input('title')),
            'typelink'   => $request->input('typelink'),
            'link'       => $request->input('link'),
            'targetview' => $request->input('targetview'),
            'position'   => $request->input('position'),
            'status'     => $request->input('status'),
            'author_id'  => Auth::id(),
        ];

        dd($data);

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(420, 320);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailwidget.width');
                $height = config('cms.image.thumbnailwidget.height');
                $extension = $image->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                Image::make($destination . '/' . $fileName)
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


        $widget = Widget::create($data);

        if ($widget) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.widgets.index')->with(['success' => 'Data Widget Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.widgets.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Widget $widget)
    {
        return view('template.backend.nusantara.widget.edit', [
            'widget'       => $widget,
            'title'        => 'Widget',
            'pages'        => Page::orderBy('created_at', 'desc')->where('status', 1)->get(),
            'albums'       => Album::orderBy('created_at', 'desc')->where('status', 1)->get(),
            'postcategory' => Postcategory::orderBy('created_at', 'desc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestWidgetUpdate $request, Widget $widget)
    {
        //cek gambar lama
        $oldImage = $widget->image;

        // Default data
        $data = [
            'title'      => $request->input('title'),
            'slug'       => Str::slug($request->input('title')),
            'typelink'   => $request->input('typelink'),
            'targetview' => $request->input('targetview'),
            'link'       => $request->input('link'),
            'position'   => $request->input('position'),
            'status'     => $request->input('status'),
            'updated_by' => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(420, 320);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailwidget.width');
                $height = config('cms.image.thumbnailwidget.height');
                $extension = $image->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                Image::make($destination . '/' . $fileName)
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



        $widget->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $widget->image) {
            $this->removeImage($oldImage);
        }

        if ($widget) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.widgets.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.widgets.index')->with(['error' => 'Data Gagal Diperbaharui!']);
        }
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
