<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Models\Postcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestPostStore;
use App\Http\Requests\RequestPostUpdate;
use App\Models\Postsubcategory;

class PostController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:posts.index|posts.create|posts.edit|posts.delete|posts.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryPosts'));
    }

    public function index()
    {
        return view('template.backend.nusantara.post.index');
    }

    public function create()
    {
        return view('template.backend.nusantara.post.create', [
            'postcatagories' => Postcategory::orderBy('title', 'asc')->get(),
            'postsubcatagories' => Postsubcategory::orderBy('title', 'asc')->get(),
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
            'statuspost'         => $request->input('statuspost'),
            'published_at'       => $request->input('published_at'),
            'author_id'          => Auth::id(),
        ];

        // dd($data);

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            // $filenameWithoutEx = Str::slug($request->title) . '_' . time(); //GENERATE NAMA FILE SLUG DARI TITLE TANPA EXTENSION
            // $fileName = $filenameWithoutEx . '_' . $image->getClientOriginalName(); //GENERATE NAMA FILE DENGAN EXTENSION
            $extension = $image->getClientOriginalExtension();
            $fileName    = time() . "_post." . $extension;
            $destination = $this->uploadPath;

            $imageUploaded = Image::make($image)->resize(1024, 768);
            $imageUploaded->save($destination . $fileName, 80);

            if ($imageUploaded) {
                $extension = $image->getClientOriginalExtension();

                //KEMUDIAN KITA SISIPKAN WATERMARK DENGAN TEXT LAMAN KREASI
                //X = 200, Y = 150. SILAHKAN DISESUAIKAN UNTUK POSISINYA
                $imageUploaded->text('Property Islamic Center Kaltim', 300, 150, function ($font) {
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
                $width = config('cms.image.thumbnailpost.width');
                $height = config('cms.image.thumbnailpost.height');
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

        $post = Post::create($data);
        $post->tags()->attach($request->input('tags'));

        if ($post) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.posts.index')->with(['success' => 'Data Post Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.posts.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        return view('template.backend.nusantara.post.edit', [
            'postcatagories'    => Postcategory::orderBy('title', 'asc')->get(),
            'post'              => $post,
            'postsubcatagories' => Postsubcategory::orderBy('title', 'asc')->get(),
            'tags'              => Tag::orderBy('title', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestPostUpdate $request, Post $post)
    {
        //cek gambar lama
        $oldImage = $post->image;

        $oldPostsubcategory = $post->postsubcategory;

        // Default data
        $data = [
            'title'           => $request->input('title'),
            'postcategory_id' => $request->input('postcategory_id'),
            'slug'            => Str::slug($request->input('title')),
            'headline'        => $request->input('headline'),
            'selection'       => $request->input('selection'),
            'content'         => $request->input('content'),
            'excerpt'         => Str::limit($request->input('content'), 100),
            'video'           => $request->input('video'),
            'caption_video'   => $request->input('caption_video'),
            'caption_image'   => $request->input('caption_image'),
            'status'          => $request->input('status'),
            'comment_status'  => $request->input('comment_status'),
            'statuspost'      => $request->input('statuspost'),
            'published_at'    => $request->input('published_at'),
            'updated_by'      => Auth::id(),
        ];

        if (!empty($request->has('postsubcategory_id'))) {
            $data = array_merge($data, [
                'postsubcategory_id'    => $request->input('postsubcategory_id'),
            ]);
        }

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName    = time() . "_post." . $extension;
            // $filenameWithoutEx = Str::slug($request->title) . '_' . time(); //GENERATE NAMA FILE SLUG DARI TITLE TANPA EXTENSION
            // $fileName = $filenameWithoutEx . '_' . $image->getClientOriginalName(); //GENERATE NAMA FILE DENGAN EXTENSION
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
                $width = config('cms.image.thumbnailpost.width');
                $height = config('cms.image.thumbnailpost.height');
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

        $post->update($data);
        //assign tags
        $post->tags()->sync($request->input('tags'));

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $post->image) {
            $this->removeImage($oldImage);
        }

        if ($post) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.posts.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.posts.index')->with(['error' => 'Data Gagal Diperbaharui!']);
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

            $watermark     = str_replace(".{$ext}", "_watermark.{$ext}", $image);
            $watermarkPath = $this->uploadPath . '/' . $watermark;

            if (file_exists($imagePath)) unlink($imagePath);
            if (file_exists($thumbnailPath)) unlink($thumbnailPath);
            if (file_exists($watermarkPath)) unlink($watermarkPath);
        }
    }

    /**
     * Get Sub Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function getsubcategorypost($postcategory_id)
    {
        // menampilkan data menggynakan Query builder buka elequent
        // $subcategory = DB::table('postsubcategories')->where('postcategory_id', $postcategory_id)->get();
        $subcategory = Postsubcategory::where('postcategory_id', $postcategory_id)->get();
        return response()->json($subcategory);
    }
}
