<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Tag;
use App\Models\Literasicategory;
use Illuminate\Support\Str;
use App\Models\Postcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestPostStore;
use App\Http\Requests\RequestPostUpdate;

class LiteracycategoryController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:literacycategories.index|literacycategories.create|literacycategories.edit|literacycategories.delete|literacycategories.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryLiteracicategory'));
    }

    public function index()
    {
        return view('template.backend.nusantara.literacycategory.index');
    }

    public function create()
    {
        return view('template.backend.nusantara.literacycategory.create', [
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
                $width = config('cms.image.thumbnailliteracy.width');
                $height = config('cms.image.thumbnailliteracy.height');
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

        $literacycategory = Literasicategory::create($data);

        if ($literacycategory) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.literacycategories.index')->with(['success' => 'Data Literasicategory Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.literacycategories.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Literasicategory $literacycategory)
    {
        return view('template.backend.nusantara.literacycategory.edit', [
            'literacycategory' => $literacycategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestPostUpdate $request, Literasicategory $literacycategory)
    {
        //cek gambar lama
        $oldImage = $literacycategory->image;

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
                $width = config('cms.image.thumbnailliteracy.width');
                $height = config('cms.image.thumbnailliteracy.height');
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

        $literacycategory->update($data);
        //assign tags
        $literacycategory->tags()->sync($request->input('tags'));

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $literacycategory->image) {
            $this->removeImage($oldImage);
        }

        if ($literacycategory) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.literacycategories.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.literacycategories.index')->with(['error' => 'Data Gagal Diperbaharui!']);
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
