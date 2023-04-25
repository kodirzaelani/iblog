<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Post;
use App\Models\User;
use App\Models\Agama;
use App\Models\Employe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\ImportEmploye;
use App\Imports\ImportJabatan;
use App\Models\Jenjangpendidikan;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class EmployeController extends Controller
{

    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:employes.index|employes.create|employes.edit|employes.delete|employes.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryUsers'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('template.backend.nusantara.employe.index', [
            'title' => 'List Officer',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('template.backend.nusantara.employe.create', [
            'religions' => Agama::orderBy('agamaid', 'asc')->get(),
            'educations' => Jenjangpendidikan::orderBy('sortid', 'asc')->get(),
            'title' => 'Officer',
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'agama_id'                     => 'required',
            'gender'                     => 'required',
            'name'                     => 'required|min:2',
            'email'                    => 'required|email|unique:employes,email',
            'nik'                      => 'required|min:16|unique:employes,nik',
            'celuller_no'              => 'required|min:11|unique:employes,celuller_no',
        ]);

        // Default data
        $data = [
            'name'                     => $request->input('name'),
            'email'                     => $request->input('email'),
            'slug'                     => Str::slug(time() . $request->input('name')),
            'nik'                      => $request->input('nik'),
            'gender'                   => $request->input('gender'),
            'celuller_no'                   => $request->input('celuller_no'),
            'agama_id'              => $request->input('agama_id'),
            'jenjangpendidikan_id'              => $request->input('jenjangpendidikan_id'),
            'department'              => $request->input('department'),
            'birth_place'              => $request->input('birth_place'),
            'birth_date'               => $request->input('birth_date'),
            'family'               => $request->input('family'),
            'phonefamily'               => $request->input('phonefamily'),
            'statusfamily'               => $request->input('statusfamily'),
            'address'               => $request->input('address'),
            'status'             => $request->input('status'),
        ];


        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(600, 600);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailuser.width');
                $height = config('cms.image.thumbnailuser.height');
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

        $employe = Employe::create($data);


        $user = User::create([
            'name'              => $request->input('name'),
            'slug'              => Str::slug(time() . $request->input('name')),
            'email'             => $request->input('email'),
            'username'          => $request->input('username'),
            'email_verified_at' => now(),
            'password'          => bcrypt('KaltimBerdaulat!'),
            'remember_token'    => Str::random(30),
            'employe_id'        => $employe->id,
            'celuller_no'        => $employe->celuller_no,
        ]);

        //assign role to employe
        $user->assignRole('officer');


        return redirect()->route('backend.employes.index')->with(['success' => 'Employe ' . $user['name'] . ' Berhasil Ditambahkan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employe $employe)
    {

        return view('template.backend.nusantara.employe.edit', [
            'religions' => Agama::orderBy('agamaid', 'asc')->get(),
            'educations' => Jenjangpendidikan::orderBy('sortid', 'asc')->get(),
            'posts' => Post::where('author_id', $employe->user->id)->published()->orderBy('created_at', 'desc')->take('3')->get(),

            'employe' => $employe,
            'title' => 'Officer',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employe $employe)
    {


        $oldImage = $employe->image;
        $oldName = $employe->name;

        $validateData = [];

        $validateData = array_merge($validateData, [
            'agama_id'                     => 'required',
            'gender'                     => 'required',
            'name'                  => 'required|min:2',
            'email'                 => 'required|email',
            'username'              => 'required|min:6',
            'phone'           => 'required|min:11|max:12',
        ]);

        // Default data
        $data = [
            'name'                     => $request->input('name'),
            'slug'                     => Str::slug(time() . $request->input('name')),
            'nik'                      => $request->input('nik'),
            'gender'                   => $request->input('gender'),
            'celuller_no'                   => $request->input('celuller_no'),
            'agama_id'              => $request->input('agama_id'),
            'jenjangpendidikan_id'              => $request->input('jenjangpendidikan_id'),
            'department'              => $request->input('department'),
            'birth_place'              => $request->input('birth_place'),
            'birth_date'               => $request->input('birth_date'),
            'family'               => $request->input('family'),
            'phonefamily'               => $request->input('phonefamily'),
            'statusfamily'               => $request->input('statusfamily'),
            'address'               => $request->input('address'),
        ];

        //upload image (cara kedua)
        if ($request->has('image')) {
            # upload with image
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded = Image::make($image)->resize(600, 600);
            $successUploaded->save($destination . $fileName, 80);

            if ($successUploaded) {
                # script dibawah koneksi ke file App\confog\cms.php
                $width = config('cms.image.thumbnailuser.width');
                $height = config('cms.image.thumbnailuser.height');
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

        $employe->update($data);

        // Jika gambar lama ada maka lakukan hapus gambar
        if ($oldImage !== $employe->image) {
            $this->removeImage($oldImage);
        }



        if ($oldName !== $employe->name) {

            $userId = User::where('employe_id', $employe->id)->first();

            if ($userId != null) {

                $datauser = [
                    'name'              => $request->input('name'),
                    'slug'              => Str::slug(time() . $request->input('name')),
                ];

                $userId->update($datauser);
            }
        }

        return redirect()->route('backend.employes.index')->with(['success' => 'Data Officer ' . $employe['name'] . ' Berhasil Diupdate!']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userprofile()
    {
        return view('template.backend.nusantara.employe.profile', [
            'title' => 'Dashboard'
        ]);
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

    public function importSaveJabatan(Request $request)
    {
        //VALIDASI DATA YANG DIKIRIM
        $this->validate(
            $request,
            [
                'file' => 'required|mimes:csv,xls,xlsx'
            ],
            [
                'file.required' => 'Pilih File untuk di Import',
                'file.mimes' => 'File Tidak Valid'
            ]
        );

        $employe_id = $request->input('employe_id');

        //JIKA FILE-NYA ADA
        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new ImportJabatan($employe_id), $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload data Jabatan Pegawai success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    public function importSave(Request $request)
    {
        //VALIDASI DATA YANG DIKIRIM
        $this->validate(
            $request,
            [
                'file' => 'required|mimes:csv,xls,xlsx'
            ],
            [
                'file.required' => 'Pilih File untuk di Import',
                'file.mimes' => 'File Tidak Valid'
            ]
        );

        // $sekolah_id = $request->input('sekolah_id');

        //JIKA FILE-NYA ADA
        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new ImportEmploye(), $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload data Pegawai success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
}
