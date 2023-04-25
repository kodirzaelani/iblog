<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;

class PengajianCategoryController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:pengajiancategories.index|pengajiancategories.create|pengajiancategories.edit|pengajiancategories.delete|pengajiancategories.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.pengajiancategory.index');
    }
}
