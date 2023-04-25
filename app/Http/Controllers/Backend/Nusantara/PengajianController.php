<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Pengajian;
use App\Models\Pengajiancategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestPengajianStore;
use App\Http\Requests\RequestPengajianUpdate;

class PengajianController extends Controller
{
    //
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:pengajian.index|pengajian.create|pengajian.edit|pengajian.delete|pengajian.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryPengajian'));
    }

    public function index()
    {
        return view('template.backend.nusantara.pengajian.index', [
            'title' => 'Pengajian'
        ]);
    }

    public function create()
    {
        return view('template.backend.nusantara.pengajian.create', [
            'pengajiancatagories' => Pengajiancategory::orderBy('title', 'asc')->get(),
            'title' => 'Pengajian'
        ]);
    }

    public function store(RequestPengajianStore $request)
    {


        // Default data
        $data = [
            'title'       => $request->input('title'),
            'slug'        => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'startdate'   => $request->input('startdate'),
            'pengajiancategory_id'   => $request->input('pengajiancategory_id'),
            'periode'     => $request->input('periode'),
            'video'      => $request->input('video'),
            'status'      => $request->input('status'),
            'author_id'   => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailpengajian.width');
                $height = config('cms.image.thumbnailpengajian.height');
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



        $pengajian = Pengajian::create($data);


        return redirect()->route('backend.pengajian.index')->with(['success' => 'Data Pengajian Berhasil Disimpan!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengajian $pengajian)
    {
        return view('template.backend.nusantara.pengajian.edit', [
            'pengajiancatagories' => Pengajiancategory::orderBy('title', 'asc')->get(),
            'pengajian' => $pengajian,
            'title' => 'Pengajian'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestPengajianUpdate $request, Pengajian $pengajian)
    {
        //cek gambar lama
        $oldImage = $pengajian->image;

        // Default data
        $data = [
            'title'       => $request->input('title'),
            'slug'        => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'startdate'   => $request->input('startdate'),
            'pengajiancategory_id'   => $request->input('pengajiancategory_id'),
            'periode'     => $request->input('periode'),
            'video'    => $request->input('video'),
            'status'      => $request->input('status'),
            'updated_by'  => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailpengajian.width');
                $height = config('cms.image.thumbnailpengajian.height');
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



        $pengajian->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $pengajian->image) {
            $this->removeImage($oldImage);
        }



        return redirect()->route('backend.pengajian.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
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
