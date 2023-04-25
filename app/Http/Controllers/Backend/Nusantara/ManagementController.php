<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;

class ManagementController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:management.index|management.create|management.edit|management.delete|management.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.management.index', [
            'title' => 'Struktur Management',
        ]);
    }
}
