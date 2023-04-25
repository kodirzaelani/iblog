<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:permissions.index|permissions.create|permissions.edit|permissions.delete|permissions.trash']);
    }

    public function index()
    {
        return view('template.backend.nusantara.permission.index', [
            'title' => 'Permissions'
        ]);
    }
}
