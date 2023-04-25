<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;

class CategoryVideoController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:videocategories.index|videocategories.create|videocategories.edit|videocategories.delete|videocategories.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.videocategories.index', [
            'title' => 'List Video Category',
        ]);
    }
}
