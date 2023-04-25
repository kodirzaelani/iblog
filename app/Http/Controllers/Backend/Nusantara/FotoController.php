<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Foto;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestFotoStore;
use App\Http\Requests\RequestFotoUpdate;
use App\Models\Album;

class FotoController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:photos.index|photos.create|photos.edit|photos.delete|photos.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryFoto'));
    }

    public function index()
    {
        return view('template.backend.nusantara.foto.index');
    }

    public function create()
    {
        return view('template.backend.nusantara.foto.create', [
            'albums' => Album::where('status', '1')->orderBy('title', 'asc')->get(),
        ]);
    }

    public function store(RequestFotoStore $request)
    {
        // Default data
        $data = [
            'title'              => $request->input('title'),
            'slug'               => Str::slug($request->input('title')),
            'excerpt'            => $request->input('excerpt'),
            'album_id'           => $request->input('album_id'),
            'status'             => $request->input('status'),
            'author_id'          => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName    = time() . "_foto." . $extension;
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(600, 400);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailfoto.width');
                $height = config('cms.image.thumbnailfoto.height');
                $extension = $image->getClientOriginalExtension();
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

        $foto = Foto::create($data);


        return redirect()->route('backend.fotos.index')->with(['success' => 'Data Foto Berhasil Disimpan!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Foto $foto)
    {
        return view('template.backend.nusantara.foto.edit', [
            'foto' => $foto,
            'albums' => Album::where('status', '1')->orderBy('title', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestFotoUpdate $request, Foto $foto)
    {
        //cek gambar lama
        $oldImage = $foto->image;

        // Default data
        $data = [
            'title'              => $request->input('title'),
            'excerpt'            => $request->input('excerpt'),
            'album_id'           => $request->input('album_id'),
            'status'             => $request->input('status'),
            'author_id'          => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName    = time() . "_foto." . $extension;
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(600, 400);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailfoto.width');
                $height = config('cms.image.thumbnailfoto.height');
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

        $foto->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $foto->image) {
            $this->removeImage($oldImage);
        }


        return redirect()->route('backend.fotos.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
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
