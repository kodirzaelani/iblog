<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestDownloadStore;
use App\Http\Requests\RequestDownloadUpdate;
use App\Models\Download;
use App\Models\Downloadcategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'permission:downloadcategories.index|downloadcategories.create|downloadcategories.edit|downloadcategories.delete|downloadcategories.trash
            downloadfiles.index|downloadfiles.create|downloadfiles.edit|downloadfiles.delete|downloadfiles.trash'
        ]);
        $this->uploadPath = public_path(config('cms.image.directoryDownloads'));
    }

    public function categoryindex()
    {
        return view('template.backend.nusantara.download.categoryindex', [
            'title' => 'List Download Categories'
        ]);
    }
    public function downloadindex()
    {
        return view('template.backend.nusantara.download.downloadindex', [
            'title' => 'List Download'
        ]);
    }
    public function create()
    {
        return view('template.backend.nusantara.download.downloadcreate', [
            'downloadcategories' => Downloadcategory::orderBy('title', 'asc')->get(),
            'title' => 'Create Download',
        ]);
    }

    public function store(RequestDownloadStore $request)
    {
        // Default data
        $data = [
            'title'               => $request->input('title'),
            'slug'                => Str::slug($request->input('title')),
            'downloadcategory_id' => $request->input('downloadcategory_id'),
            'description'         => $request->input('description'),
            'urlcontent'          => $request->input('urlcontent'),
            'linkdownload'        => $request->input('linkdownload'),
            'author_id'           => Auth::id(),
        ];


        //upload image (cara kedua)
        if ($request->has('attach')) {
            # upload with attach
            $attach = $request->file('attach');
            $fileName = time() . $attach->getClientOriginalName();
            // upload file attach
            $attach->move($this->uploadPath, $fileName);

            // Tampung isi image ke variable data
            $dataattach = $fileName;

            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'attach' => $dataattach
            ]);
        }

        $download = Download::create($data);


        return redirect()->route('backend.download.downloadindex')->with(['success' => 'Data Download Berhasil Disimpan!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Download $download)
    {
        return view('template.backend.nusantara.download.downloadedit', [
            'download' => $download,
            'downloadcategories' => Downloadcategory::orderBy('title', 'asc')->get(),
            'title' => 'Edit Download '
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestDownloadUpdate $request, Download $download)
    {
        //cek gambar lama
        $oldImage = $download->image;
        $oldAttach = $download->attach;

        // Default data
        $data = [
            'title'               => $request->input('title'),
            'slug'                => Str::slug($request->input('title')),
            'downloadcategory_id' => $request->input('downloadcategory_id'),
            'description'         => $request->input('description'),
            'urlcontent'          => $request->input('urlcontent'),
            'linkdownload'        => $request->input('linkdownload'),
            'updated_by'  => Auth::id(),
        ];


        //upload image (cara kedua)
        if ($request->has('attach')) {
            # upload with attach
            $attach = $request->file('attach');
            $fileName = time() . $attach->getClientOriginalName();
            // upload file attach
            $attach->move($this->uploadPath, $fileName);

            // Tampung isi image ke variable data
            $dataattach = $fileName;

            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'attach' => $dataattach
            ]);
        }


        $download->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldAttach !== $download->attach) {
            $this->removeAttach($oldAttach);
        }


        //redirect dengan pesan sukses
        return redirect()->route('backend.download.downloadindex')->with(['success' => 'Data Berhasil Diperbaharui!']);
    }

    // function remove attach
    private function removeAttach($attach)
    {
        if (!empty($attach)) {
            $attachPath     = $this->uploadPath . $attach;
            $ext           = substr(strrchr($attach, '.'), 1);

            if (file_exists($attachPath)) unlink($attachPath);
        }
    }
}
