<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;

class PeriodeController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:periode.index|periode.create|periode.edit|periode.delete|periode.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.periode.index', [
            'title' => 'Periode Pengurus',
        ]);
    }
}
