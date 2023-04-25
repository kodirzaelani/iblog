<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;

class StructuroganizationController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:structuroganization.index|structuroganization.create|structuroganization.edit|structuroganization.delete|structuroganization.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.structuroganization.index', [
            'title' => 'Struktur Jabatan',
        ]);
    }
}
