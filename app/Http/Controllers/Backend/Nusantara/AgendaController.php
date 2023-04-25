<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Agenda;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestAgendaStore;
use App\Http\Requests\RequestAgendaUpdate;

class AgendaController extends Controller
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
        $this->middleware(['permission:agendas.index|agendas.create|agendas.edit|agendas.delete|agendas.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryAgenda'));
    }

    public function index()
    {
        return view('template.backend.nusantara.agenda.index', [
            'title' => 'Agenda'
        ]);
    }

    public function create()
    {
        return view('template.backend.nusantara.agenda.create', [
            'title' => 'Agenda'
        ]);
    }

    public function store(RequestAgendaStore $request)
    {

        // Default data
        $data = [
            'title'       => $request->input('title'),
            'slug'        => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'startdate'   => $request->input('startdate'),
            'enddate'     => $request->input('enddate'),
            'periode'     => $request->input('periode'),
            'endperiode'  => $request->input('endperiode'),
            'location'    => $request->input('location'),
            'status'      => $request->input('status'),
            'author_id'   => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName    = time() . "_agenda." . $extension;
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailagenda.width');
                $height = config('cms.image.thumbnailagenda.height');
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

        $agenda = Agenda::create($data);


        return redirect()->route('backend.agendas.index')->with(['success' => 'Data Agenda Berhasil Disimpan!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Agenda $agenda)
    {
        return view('template.backend.nusantara.agenda.edit', [
            'agenda' => $agenda,
            'title' => 'Agenda'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestAgendaUpdate $request, Agenda $agenda)
    {
        //cek gambar lama
        $oldImage = $agenda->image;
        $oldAttach = $agenda->attach;

        // Default data
        $data = [
            'title'       => $request->input('title'),
            'slug'        => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'startdate'   => $request->input('startdate'),
            'enddate'     => $request->input('enddate'),
            'periode'     => $request->input('periode'),
            'endperiode'  => $request->input('endperiode'),
            'location'    => $request->input('location'),
            'status'      => $request->input('status'),
            'updated_by'  => Auth::id(),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName    = time() . "_agenda." . $extension;
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailagenda.width');
                $height = config('cms.image.thumbnailagenda.height');
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


        $agenda->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $agenda->image) {
            $this->removeImage($oldImage);
        }
        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldAttach !== $agenda->attach) {
            $this->removeAttach($oldAttach);
        }

        if ($agenda) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.agendas.index')->with(['success' => 'Data Berhasil Diperbaharui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.agendas.index')->with(['error' => 'Data Gagal Diperbaharui!']);
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
