<?php

namespace App\Http\Controllers\Backend\Nusantara;

use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\OrganizationStoreRequest;
use App\Http\Requests\OrganizationUpdateRequest;
use App\Models\Pergub;

class OrganizationController extends Controller
{
    protected $uploadPath;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:organizations.index|organizations.create|organizations.edit|organizations.delete|organizations.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryLogo'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('template.backend.nusantara.organization.index', [
            'title' => 'Organisasi'
        ]);
    }

    public function create()
    {
        return view('template.backend.nusantara.organization.create', [
            'strukturorganisasi' => Organization::orderBy('urut', 'asc')->get(),
            'pergubs' => Pergub::orderBy('year', 'asc')->get(),
            'title' => 'Organisasi'
        ]);
    }



    public function store(OrganizationStoreRequest $request)
    {

        // Default data
        $data = [
            'title'           => $request->input('title'),
            'parent_id' => $request->input('parent_id'),
            'pergub_id' => $request->input('pergub_id'),
            'slug'            => Str::slug($request->input('title')),
            'description'        => $request->input('description'),
            'singkatan' => $request->input('singkatan'),
            'video'            => $request->input('video'),
            'urut'            => $request->input('urut'),
            'status'          => $request->input('status'),
            'author_id'          => Auth::id(),
        ];

        //upload logo (cara kedua)
        if ($request->has('logo')) {
            # upload with logo
            $logo = $request->file('logo');
            $fileName = 'logo_' . time() . $logo->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($logo);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnaillogo.width');
                $height = config('cms.image.thumbnaillogo.height');
                $extension = $logo->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                Image::make($destination . '/' . $fileName)
                    ->resize($width, $height)
                    ->save($destination . '/' . $thumbnail);
            }

            // Tampung isi image ke variable data
            $image_data = $fileName;
            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'logo' => $image_data
            ]);
        }


        Organization::create($data);


        return redirect()->route('backend.organizations.index')->with(['success' => 'Data Setting Berhasil Disimpan!']);
    }

    public function edit(Organization $organization)
    {
        return view('template.backend.nusantara.organization.edit', [
            'strukturorganisasi' => Organization::orderBy('urut', 'asc')->get(),
            'pergubs' => Pergub::orderBy('year', 'asc')->get(),
            'title' => 'Organisasi',
            'organization' => $organization,
        ]);
    }

    public function update(OrganizationUpdateRequest $request, Organization $organization)
    {
        //cek gambar lama
        $oldLogo        = $organization->logo;

        // Default data
        $data = [
            'title'           => $request->input('title'),
            'parent_id' => $request->input('parent_id'),
            'pergub_id' => $request->input('pergub_id'),
            'slug'            => Str::slug($request->input('title')),
            'description'        => $request->input('description'),
            'singkatan' => $request->input('singkatan'),
            'video'            => $request->input('video'),
            'urut'            => $request->input('urut'),
            'status'          => $request->input('status'),
            'updated_by'          => Auth::id(),
        ];

        //upload logo (cara kedua)
        if ($request->has('logo')) {
            # upload with logo
            $logo = $request->file('logo');
            $fileName = 'logo_' . time() . $logo->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($logo);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnaillogo.width');
                $height = config('cms.image.thumbnaillogo.height');
                $extension = $logo->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                Image::make($destination . '/' . $fileName)
                    ->resize($width, $height)
                    ->save($destination . '/' . $thumbnail);
            }

            // Tampung isi image ke variable data
            $image_data = $fileName;
            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'logo' => $image_data
            ]);
        }

        $organization->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldLogo !== $organization->logo) {
            $this->removeLogo($oldLogo);
        }

        //redirect dengan pesan sukses
        return redirect()->route('backend.organizations.index')->with(['success' => 'Data Setting Berhasil Diupdate!']);
    }

    // function remove image
    private function removeLogo($logo)
    {
        if (!empty($logo)) {
            $imagePath     = $this->uploadPath . '/' . $logo;
            $ext           = substr(strrchr($logo, '.'), 1);
            $thumbnail     = str_replace(".{$ext}", "_thumb.{$ext}", $logo);
            $thumbnailPath = $this->uploadPath . '/' . $thumbnail;

            if (file_exists($imagePath)) unlink($imagePath);
            if (file_exists($thumbnailPath)) unlink($thumbnailPath);
        }
    }
}
