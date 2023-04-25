<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;

class JenjangpendidikanController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:jenjangpendidikan.index|jenjangpendidikan.create|jenjangpendidikan.edit|jenjangpendidikan.delete|jenjangpendidikan.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.jenjangpendidikan.index', [
            'title' => 'Jenjang Pendidikan',
        ]);
    }
}
