<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:tags.index|tags.create|tags.edit|tags.delete|tags.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.tag.index');
    }
}
