<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Video;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Videocategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestVideoStore;
use App\Http\Requests\RequestVideoUpdate;

class VideoController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:video.index|video.create|video.edit|video.delete|video.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryVideos'));
    }

    public function index()
    {
        return view('template.backend.nusantara.video.index', [
            'title' => 'List Video'
        ]);
    }

    public function create()
    {
        return view('template.backend.nusantara.video.create', [
            'videocatagories'    => Videocategory::orderBy('title', 'asc')->get(),
            'title' => 'Create Video',
        ]);
    }

    public function store(RequestVideoStore $request)
    {
        // Default data
        $data = [
            'title'       => $request->input('title'),
            'slug'        => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'videocategory_id' => $request->input('videocategory_id'),
            'status'      => $request->input('status'),
            'video'       => $request->input('video'),
            'author_id'   => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(600, 400);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailvideo.width');
                $height = config('cms.image.thumbnailvideo.height');
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

        $video = Video::create($data);

        if ($video) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.video.index')->with(['success' => 'Data Video Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.video.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('template.backend.nusantara.video.edit', [
            'videocatagories'    => Videocategory::orderBy('title', 'asc')->get(),
            'video' => $video,
            'title' => 'Edit Video'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestVideoUpdate $request, Video $video)
    {
        //cek gambar lama
        $oldImage = $video->image;

        // Default data
        $data = [
            'title'       => $request->input('title'),
            'slug'        => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'videocategory_id' => $request->input('videocategory_id'),
            'status'      => $request->input('status'),
            'video'       => $request->input('video'),
            'updated_by'   => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(600, 400);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailvideo.width');
                $height = config('cms.image.thumbnailvideo.height');
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

        $video->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $video->image) {
            $this->removeImage($oldImage);
        }

        if ($video) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.video.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.video.index')->with(['error' => 'Data Gagal Diperbaharui!']);
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
