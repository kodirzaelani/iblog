<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Greeting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestGreetingStore;
use App\Http\Requests\RequestGreetingUpdate;

class GreetingController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:greetings.index|greetings.create|greetings.edit|greetings.delete|greetings.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryGreetings'));
    }

    public function index()
    {
        return view('template.backend.nusantara.greeting.index');
    }

    public function create()
    {
        return view('template.backend.nusantara.greeting.create');
    }

    public function store(RequestGreetingStore $request)
    {
        // Default data
        $data = [
            'title'              => $request->input('title'),
            'slug'               => Str::slug($request->input('title')),
            'content'            => $request->input('content'),
            'excerpt'            => Str::limit($request->input('content'), 800),
            'caption_image'      => $request->input('caption_image'),
            'video'              => $request->input('video'),
            'caption_video'      => $request->input('caption_video'),
            'status'             => $request->input('status'),
            'published_at'       => $request->input('published_at'),
            'author_id'          => Auth::id(),
        ];

        // dd($data);

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $filenameWithoutEx = Str::slug($request->title) . '_' . time(); //GENERATE NAMA FILE SLUG DARI TITLE TANPA EXTENSION
            $fileName = $filenameWithoutEx . '_' . $image->getClientOriginalName(); //GENERATE NAMA FILE DENGAN EXTENSION
            $destination = $this->uploadPath;

            $imageUploaded = Image::make($image)->resize(1024, 768);
            $imageUploaded->save($destination . $fileName, 80);

            if ($imageUploaded) {
                $extension = $image->getClientOriginalExtension();

                //KEMUDIAN KITA SISIPKAN WATERMARK DENGAN TEXT LAMAN KREASI
                //X = 200, Y = 150. SILAHKAN DISESUAIKAN UNTUK POSISINYA
                $imageUploaded->text('Islamic Center Kaltim', 300, 150, function ($font) {
                    // $font->file(public_path('fonts/milkyroad.ttf'));   //LOAD FONT-NYA JIKA ADA, SILAHKAN DOWNLOAD SENDIRI
                    $font->file(public_path('uploads/fonts/amandasignature.ttf'));   //LOAD FONT-NYA JIKA ADA, SILAHKAN DOWNLOAD SENDIRI
                    $font->size(30);
                    $font->color('#f5f0e6');
                    $font->align('center');
                    $font->valign('top');
                    $font->angle(0);
                });

                // Watermark
                $filenameWatermark = str_replace(".{$extension}", "_watermark.{$extension}", $fileName);

                // Save watermark
                $imageUploaded->resize(1024, 768)
                    ->save($destination . '/' . $filenameWatermark, 80); //SIMPAN FILE ORIGINAL YANG BERISI WATERMARK

                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailgreeting.width');
                $height = config('cms.image.thumbnailgreeting.height');
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                $imageUploaded->resize($width, $height)
                    ->save($destination . '/' . $thumbnail); //SIMPAN FILE THUMBNAIL YANG BERISI WATERMARK

            }

            // Tampung isi image ke variable data
            $image_data = $fileName;
            $image_watermark = $filenameWatermark;
            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'image' => $image_data,
            ]);

            $data = array_merge($data, [
                'image_watermark' => $image_watermark,
            ]);
        }

        $greeting = Greeting::create($data);


        return redirect()->route('backend.greetings.index')->with(['success' => 'Data Greeting Berhasil Disimpan!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Greeting $greeting)
    {

        return view('template.backend.nusantara.greeting.edit', [
            'greeting'             => $greeting,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestGreetingUpdate $request, Greeting $greeting)
    {
        //cek gambar lama
        $oldImage = $greeting->image;


        // Default data
        $data = [
            'title'           => $request->input('title'),
            'slug'            => Str::slug($request->input('title')),
            'content'         => $request->input('content'),
            'excerpt'         => Str::limit($request->input('content'), 100),
            'video'           => $request->input('video'),
            'caption_video'   => $request->input('caption_video'),
            'caption_image'   => $request->input('caption_image'),
            'status'          => $request->input('status'),
            'published_at'    => $request->input('published_at'),
            'updated_by'      => Auth::id(),
        ];

        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $filenameWithoutEx = Str::slug($request->title) . '_' . time(); //GENERATE NAMA FILE SLUG DARI TITLE TANPA EXTENSION
            $fileName = $filenameWithoutEx . '_' . $image->getClientOriginalName(); //GENERATE NAMA FILE DENGAN EXTENSION
            $destination = $this->uploadPath;

            $imageUploaded = Image::make($image)->resize(1024, 768);
            $imageUploaded->save($destination . $fileName, 80); //SIMPAN FILE ORIGINAL YANG BELUM BERISI WATERMARK

            if ($imageUploaded) {
                $extension = $image->getClientOriginalExtension();

                //KEMUDIAN KITA SISIPKAN WATERMARK DENGAN TEXT LAMAN KREASI
                //X = 200, Y = 150. SILAHKAN DISESUAIKAN UNTUK POSISINYA
                $imageUploaded->text('Islamic Center Kaltim', 300, 150, function ($font) {
                    // $font->file(public_path('fonts/milkyroad.ttf'));   //LOAD FONT-NYA JIKA ADA, SILAHKAN DOWNLOAD SENDIRI
                    $font->file(public_path('uploads/fonts/amandasignature.ttf'));   //LOAD FONT-NYA JIKA ADA, SILAHKAN DOWNLOAD SENDIRI
                    $font->size(30);
                    $font->color('#f5f0e6');
                    $font->align('center');
                    $font->valign('top');
                    $font->angle(0);
                });

                // Watermark
                $filenameWatermark = str_replace(".{$extension}", "_watermark.{$extension}", $fileName);

                // Save watermark
                $imageUploaded->resize(1024, 768)
                    ->save($destination . '/' . $filenameWatermark, 80); //SIMPAN FILE ORIGINAL YANG BERISI WATERMARK

                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailgreeting.width');
                $height = config('cms.image.thumbnailgreeting.height');
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                $imageUploaded->resize($width, $height)
                    ->save($destination . '/' . $thumbnail); //SIMPAN FILE THUMBNAIL YANG BERISI WATERMARK

            }

            // Tampung isi image ke variable data
            $image_data = $fileName;
            $image_watermark = $filenameWatermark;
            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'image' => $image_data,
            ]);

            $data = array_merge($data, [
                'image_watermark' => $image_watermark,
            ]);
        }

        $greeting->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $greeting->image) {
            $this->removeImage($oldImage);
        }


        return redirect()->route('backend.greetings.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
    }

    // function remove image
    private function removeImage($image)
    {
        if (!empty($image)) {
            $imagePath     = $this->uploadPath . '/' . $image;

            $ext           = substr(strrchr($image, '.'), 1);

            $thumbnail     = str_replace(".{$ext}", "_thumb.{$ext}", $image);
            $thumbnailPath = $this->uploadPath . '/' . $thumbnail;

            $watermark     = str_replace(".{$ext}", "_watermark.{$ext}", $image);
            $watermarkPath = $this->uploadPath . '/' . $watermark;

            if (file_exists($imagePath)) unlink($imagePath);
            if (file_exists($thumbnailPath)) unlink($thumbnailPath);
            if (file_exists($watermarkPath)) unlink($watermarkPath);
        }
    }
}
