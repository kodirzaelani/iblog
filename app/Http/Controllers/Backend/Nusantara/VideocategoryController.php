<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\Foto;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\RequestFotoStore;
use App\Http\Requests\RequestFotoUpdate;
use App\Models\Album;

class VideocategoryController extends Controller
{
    protected $uploadPath;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:videocategories.index|videocategories.create|videocategories.edit|videocategories.delete|videocategories.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryVideocategories'));
    }

    public function index()
    {
        return view('template.backend.nusantara.videocategories.index', [
            'title' => 'List Video Category',
        ]);
    }
}
