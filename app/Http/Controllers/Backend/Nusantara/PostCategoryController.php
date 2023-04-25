<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;

class PostCategoryController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:categoryposts.index|categoryposts.create|categoryposts.edit|categoryposts.delete|categoryposts.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.postcategory.index');
    }
}
