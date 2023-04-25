<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Literacy;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestLiteracyUpdate;
use App\Http\Requests\RequestLiteracyStore;
use App\Models\Literacycategory;
use App\Models\Literacysubcategory;

class LiteracyController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:literacies.index|literacies.create|literacies.edit|literacies.delete|literacies.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryLiteracy'));
    }

    public function index()
    {
        return view('template.backend.nusantara.literacy.index');
    }

    public function create()
    {
        return view('template.backend.nusantara.literacy.create', [
            'literacycatagories' => Literacycategory::orderBy('title', 'asc')->get(),
            'literacysubcatagories' => Literacysubcategory::orderBy('title', 'asc')->get(),
        ]);
    }

    public function store(RequestLiteracyStore $request)
    {
        // Default data
        $data = [
            'title'              => $request->input('title'),
            'literacycategory_id'    => $request->input('literacycategory_id'),
            'literacysubcategory_id' => $request->input('literacysubcategory_id'),
            'slug'               => Str::slug($request->input('title')),
            'content'            => $request->input('content'),
            'excerpt'            => Str::limit($request->input('content'), 100),
            'urlcontent'              => $request->input('urlcontent'),
            'caption_image'      => $request->input('caption_image'),
            'linkdownload'      => $request->input('linkdownload'),
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

            $successUploaded = Image::make($image)->resize(350, 600);
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

        $literacy = Literacy::create($data);

        if ($literacy) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.literacies.index')->with(['success' => 'Data Literacy Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.literacies.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Literacy $literacy)
    {
        return view('template.backend.nusantara.literacy.edit', [
            'literacy' => $literacy,
            'literacycategories' => Literacycategory::orderBy('title', 'asc')->get(),
            'literacysubcategories' => Literacysubcategory::orderBy('title', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestLiteracyUpdate $request, Literacy $literacy)
    {
        //cek gambar lama
        $oldImage = $literacy->image;

        // Default data
        $data = [
            'title'               => $request->input('title'),
            'literacycategory_id' => $request->input('literacycategory_id'),
            'slug'                => Str::slug($request->input('title')),
            'content'             => $request->input('content'),
            'excerpt'             => Str::limit($request->input('content'), 100),
            'urlcontent'          => $request->input('urlcontent'),
            'caption_image'       => $request->input('caption_image'),
            'status'              => $request->input('status'),
            'linkdownload'      => $request->input('linkdownload'),
            'comment_status'      => $request->input('comment_status'),
            'updated_by'          => Auth::id(),
        ];

        if (!empty($request->has('literacysubcategory_id'))) {
            $data = array_merge($data, [
                'literacysubcategory_id' => $request->input('literacysubcategory_id'),
            ]);
        }

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(350, 600);
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

        $literacy->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $literacy->image) {
            $this->removeImage($oldImage);
        }

        if ($literacy) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.literacies.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.literacies.index')->with(['error' => 'Data Gagal Diperbaharui!']);
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

    /**
     * Get Sub Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function getliteracysubcategory($literacycategory_id)
    {
        // menampilkan data menggynakan Query builder
        // $subcategory = DB::table('postsubcategories')->where('literacycategory_id', $literacycategory_id)->get();
        // menampilkan data menggynakan elequent
        $subcategory = Literacysubcategory::where('literacycategory_id', $literacycategory_id)->get();
        return response()->json($subcategory);
    }
}
