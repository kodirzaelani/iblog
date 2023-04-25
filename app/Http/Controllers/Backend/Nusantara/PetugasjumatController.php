<?php

namespace App\Http\Controllers\Backend\Nusantara;

use Illuminate\Support\Str;
use App\Models\Petugasjumat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestPetugasjumatStore;
use App\Http\Requests\RequestPetugasjumatUpdate;

class PetugasjumatController extends Controller
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
        $this->middleware(['permission:petugasjumat.index|petugasjumat.create|petugasjumat.edit|petugasjumat.delete|petugasjumat.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryPengajian'));
    }

    public function index()
    {
        return view('template.backend.nusantara.petugasjumat.index', [
            'title' => 'Petugas Jumat'
        ]);
    }

    public function create()
    {
        return view('template.backend.nusantara.petugasjumat.create', [
            'title' => 'Petugas Jumat'
        ]);
    }

    public function store(RequestPetugasjumatStore $request)
    {


        // Default data
        $data = [
            'title'       => $request->input('title'),
            'title_khotib'       => $request->input('title_khotib'),
            'title_imam'       => $request->input('title_imam'),
            'title_muadzin'       => $request->input('title_muadzin'),
            'slug'        => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'startdate'   => $request->input('startdate'),
            'periode'   => $request->input('periode'),
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

        Petugasjumat::create($data);

        return redirect()->route('backend.petugasjumat.index')->with(['success' => 'Data  Berhasil Disimpan!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Petugasjumat $petugasjumat)
    {
        return view('template.backend.nusantara.petugasjumat.edit', [
            'petugasjumat' => $petugasjumat,
            'title' => 'Petugas Jumat'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestPetugasjumatUpdate $request, Petugasjumat $petugasjumat)
    {
        //cek gambar lama
        $oldImage = $petugasjumat->image;

        // Default data
        $data = [
            'title'       => $request->input('title'),
            'title_khotib'       => $request->input('title_khotib'),
            'title_imam'       => $request->input('title_imam'),
            'title_muadzin'       => $request->input('title_muadzin'),
            'slug'        => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'startdate'   => $request->input('startdate'),
            'periode'   => $request->input('periode'),
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

        $petugasjumat->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $petugasjumat->image) {
            $this->removeImage($oldImage);
        }

        return redirect()->route('backend.petugasjumat.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
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
