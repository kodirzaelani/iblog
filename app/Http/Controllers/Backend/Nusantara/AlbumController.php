<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Album;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestAlbumStore;
use App\Http\Requests\RequestAlbumUpdate;

class AlbumController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:albums.index|albums.create|albums.edit|albums.delete|albums.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryAlbums'));
    }

    public function index()
    {
        return view('template.backend.nusantara.album.index');
    }

    public function create()
    {
        return view('template.backend.nusantara.album.create', [
            'title' => 'Create Album'
        ]);
    }

    public function store(RequestAlbumStore $request)
    {
        // Default data
        $data = [
            'title'              => $request->input('title'),
            'slug'               => Str::slug($request->input('title')),
            'excerpt'            => $request->input('excerpt'),
            'status'             => $request->input('status'),
            'author_id'          => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName    = time() . "_album." . $extension;
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(600, 400);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailalbum.width');
                $height = config('cms.image.thumbnailalbum.height');
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

        $album = Album::create($data);

        if ($album) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.albums.index')->with(['success' => 'Data Album Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.albums.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        return view('template.backend.nusantara.album.edit', [
            'album' => $album,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestAlbumUpdate $request, Album $album)
    {
        //cek gambar lama
        $oldImage = $album->image;

        // Default data
        $data = [
            'title'              => $request->input('title'),
            'excerpt'            => $request->input('excerpt'),
            'status'             => $request->input('status'),
            'author_id'          => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName    = time() . "_album." . $extension;
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(600, 400);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailalbum.width');
                $height = config('cms.image.thumbnailalbum.height');
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

        $album->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $album->image) {
            $this->removeImage($oldImage);
        }

        if ($album) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.albums.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.albums.index')->with(['error' => 'Data Gagal Diperbaharui!']);
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
