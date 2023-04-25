<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;

class AgamaController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:religi.index|religi.create|religi.edit|religi.delete|religi.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.religi.index', [
            'title' => 'Agama',
        ]);
    }
}
