<?php

namespace App\Http\Controllers\Backend\Nusantara;

use Illuminate\Support\Str;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestAdvertisementStore;
use App\Http\Requests\RequestAdvertisementUpdate;

class AdvertisementController extends Controller
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
        $this->middleware(['permission:advertisements.index|advertisements.create|advertisements.edit|advertisements.delete|advertisements.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryAdvertisements'));
    }

    public function index()
    {
        return view('template.backend.nusantara.advertisement.index', [
            'title' => 'List Advertisement'
        ]);
    }

    public function create()
    {
        return view('template.backend.nusantara.advertisement.create', [
            'title' => 'Create Advertisement'
        ]);
    }

    public function store(RequestAdvertisementStore $request)
    {

        // Default data
        $data = [
            'title'      => $request->input('title'),
            'slug'       => Str::slug($request->input('title')),
            'linkimage'  => $request->input('linkimage'),
            'scripthtml' => $request->input('scripthtml'),
            'position'   => $request->input('position'),
            'status'     => $request->input('status'),
            'author_id'  => Auth::id(),
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
                $width = config('cms.image.thumbnailadvertisement.width');
                $height = config('cms.image.thumbnailadvertisement.height');
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

        $advertisement = Advertisement::create($data);

        if ($advertisement) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.advertisements.index')->with(['success' => 'Data Advertisement Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.advertisements.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        return view('template.backend.nusantara.advertisement.edit', [
            'advertisement' => $advertisement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestAdvertisementUpdate $request, Advertisement $advertisement)
    {
        //cek gambar lama
        $oldImage = $advertisement->image;

        // Default data
        $data = [
            'title'      => $request->input('title'),
            'slug'       => Str::slug($request->input('title')),
            'linkimage'  => $request->input('linkimage'),
            'scripthtml' => $request->input('scripthtml'),
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

            $successUploaded = Image::make($image);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailadvertisement.width');
                $height = config('cms.image.thumbnailadvertisement.height');
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

        $advertisement->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $advertisement->image) {
            $this->removeImage($oldImage);
        }

        if ($advertisement) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.advertisements.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.advertisements.index')->with(['error' => 'Data Gagal Diperbaharui!']);
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
