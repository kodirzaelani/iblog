<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageCategoryController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:pagecategories.index|pagecategories.create|pagecategories.edit|pagecategories.delete|pagecategories.trash']);
        $this->uploadPath = public_path(config('cms.image.directoryPosts'));
    }

    public function index()
    {
        return view('template.backend.nusantara.pagecategory.index', [
            'title' => 'Page Category'
        ]);
    }
}
