<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Tag;
use App\Models\Literacysubcategory;
use Illuminate\Support\Str;
use App\Models\Postcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestPostStore;
use App\Http\Requests\RequestPostUpdate;

class LiteracysubcategoryController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:literacysubcategories.index|literacysubcategories.create|literacysubcategories.edit|literacysubcategories.delete|literacysubcategories.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryLiteracysubcategory'));
    }

    public function index()
    {
        return view('template.backend.nusantara.literacysubcategory.index');
    }

    public function create()
    {
        return view('template.backend.nusantara.literacysubcategory.create', [
            'postcatagories' => Postcategory::orderBy('title', 'asc')->get(),
            'tags' => Tag::orderBy('title', 'asc')->get(),
        ]);
    }

    public function store(RequestPostStore $request)
    {
        // Default data
        $data = [
            'title'              => $request->input('title'),
            'postcategory_id'    => $request->input('postcategory_id'),
            'postsubcategory_id' => $request->input('postsubcategory_id'),
            'slug'               => Str::slug($request->input('title')),
            'headline'           => $request->input('headline'),
            'selection'          => $request->input('selection'),
            'content'            => $request->input('content'),
            'excerpt'            => Str::limit($request->input('content'), 100),
            'video'              => $request->input('video'),
            'caption_video'      => $request->input('caption_video'),
            'caption_image'      => $request->input('caption_image'),
            'status'             => $request->input('status'),
            'comment_status'     => $request->input('comment_status'),
            'author_id'          => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(600, 350);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailliteracysub.width');
                $height = config('cms.image.thumbnailliteracysub.height');
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

        $literacysubcategory = Literacysubcategory::create($data);

        if ($literacysubcategory) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.literacysubcategories.index')->with(['success' => 'Data Literacysubcategory Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.literacysubcategories.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Literacysubcategory $literacysubcategory)
    {
        return view('template.backend.nusantara.literacysubcategory.edit', [
            'literacysubcategory' => $literacysubcategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestPostUpdate $request, Literacysubcategory $literacysubcategory)
    {
        //cek gambar lama
        $oldImage = $literacysubcategory->image;

        // Default data
        $data = [
            'title'              => $request->input('title'),
            'postcategory_id'    => $request->input('postcategory_id'),
            'postsubcategory_id' => $request->input('postsubcategory_id'),
            'slug'               => Str::slug($request->input('title')),
            'headline'           => $request->input('headline'),
            'selection'          => $request->input('selection'),
            'content'            => $request->input('content'),
            'excerpt'            => Str::limit($request->input('content'), 100),
            'video'              => $request->input('video'),
            'caption_video'      => $request->input('caption_video'),
            'caption_image'      => $request->input('caption_image'),
            'status'             => $request->input('status'),
            'comment_status'     => $request->input('comment_status'),
            'author_id'          => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(600, 350);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailliteracysub.width');
                $height = config('cms.image.thumbnailliteracysub.height');
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

        $literacysubcategory->update($data);
        //assign tags
        $literacysubcategory->tags()->sync($request->input('tags'));

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $literacysubcategory->image) {
            $this->removeImage($oldImage);
        }

        if ($literacysubcategory) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.literacysubcategories.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.literacysubcategories.index')->with(['error' => 'Data Gagal Diperbaharui!']);
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
