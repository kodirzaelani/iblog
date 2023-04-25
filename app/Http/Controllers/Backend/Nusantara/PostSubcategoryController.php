<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostSubcategoryController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:postsubcategory.index|postsubcategory.create|postsubcategory.edit|postsubcategory.delete|postsubcategory.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.postsubcategory.index');
    }
}
