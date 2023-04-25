<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;

class PergubController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:peraturans.index|peraturans.create|peraturans.edit|peraturans.delete|peraturans.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.pergub.index', [
            'title' => 'Peraturan',
        ]);
    }
}
