<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:menu.index|menu.create|menu.edit|menu.delete|menu.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.menu.index');
    }
    public function menuitem()
    {
        return view('template.backend.nusantara.menu.menuitem');
    }
    public function structure()
    {
        return view('template.backend.nusantara.menu.menuitemstructur');
    }
}
