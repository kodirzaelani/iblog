<?php

use App\Models\Option;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Template\Frontend\Terasblue\Main\Index;
use App\Http\Livewire\Template\Frontend\Terasblue\Post\Fpostall;
use App\Http\Livewire\Template\Frontend\Terasblue\Main\Maincontact;
use App\Http\Livewire\Template\Frontend\Terasblue\Page\Fpagedetail;
use App\Http\Livewire\Template\Frontend\Terasblue\Post\Fpostdetail;

Route::get('/', Index::class)->name('root');
Route::get('/postdetail', Fpostdetail::class)->name('frontend.post.detail');
Route::get('/postall', Fpostall::class)->name('frontend.post.all');
Route::get('/pagedetail', Fpagedetail::class)->name('frontend.page.detail');
Route::get('/contact', Maincontact::class)->name('frontend.contact.detail');

// Auth::routes(['register' => false]);
Auth::routes();
Route::middleware(['auth', 'web'])->group(function () {

    // Dashboard
    Route::get('backend/admin/home', [App\Http\Controllers\Backend\Nusantara\BackendController::class, 'index'])->name('backend.dashboard');

    // Setting
    Route::get('backend/settings', [App\Http\Controllers\Backend\Nusantara\BackendController::class, 'setting'])->name('backend.settings');
    Route::post('backend/settings/create', [App\Http\Controllers\Backend\Nusantara\BackendController::class, 'createsetting'])->name('backend.settings.create');
    Route::post('backend/settings/store', [App\Http\Controllers\Backend\Nusantara\BackendController::class, 'storesetting'])->name('backend.settings.store');
    Route::get('backend/settings/{option}/edit', [App\Http\Controllers\Backend\Nusantara\BackendController::class, 'editsetting'])->name('backend.settings.edit');
    Route::put('backend/settings/{option}/update', [App\Http\Controllers\Backend\Nusantara\BackendController::class, 'updatesetting'])->name('backend.settings.update');

    // Setting Web Modul
    Route::get('backend/settings/webmoduls', [App\Http\Controllers\Backend\Nusantara\BackendController::class, 'webmodul'])->name('backend.settings.webmoduls');

    // Permission
    Route::get('backend/permissions/index', [App\Http\Controllers\Backend\Nusantara\PermissionController::class, 'index'])->name('backend.permissions.index');

    // Role
    Route::get('backend/roles/index', [App\Http\Controllers\Backend\Nusantara\RoleController::class, 'index'])->name('backend.roles.index');
    Route::get('backend/roles/create', [App\Http\Controllers\Backend\Nusantara\RoleController::class, 'create'])->name('backend.roles.create');
    Route::post('backend/roles/store', [App\Http\Controllers\Backend\Nusantara\RoleController::class, 'store'])->name('backend.roles.store');
    Route::get('backend/roles/{role}/edit', [App\Http\Controllers\Backend\Nusantara\RoleController::class, 'edit'])->name('backend.roles.edit');
    Route::put('backend/roles/{role}/update', [App\Http\Controllers\Backend\Nusantara\RoleController::class, 'update'])->name('backend.roles.update');

    // User
    Route::get('backend/users/index', [App\Http\Controllers\Backend\Nusantara\UserController::class, 'index'])->name('backend.users.index');
    Route::get('backend/users/create', [App\Http\Controllers\Backend\Nusantara\UserController::class, 'create'])->name('backend.users.create');
    Route::post('backend/users/store', [App\Http\Controllers\Backend\Nusantara\UserController::class, 'store'])->name('backend.users.store');
    Route::get('backend/users/{user}/edit', [App\Http\Controllers\Backend\Nusantara\UserController::class, 'edit'])->name('backend.users.edit');
    Route::put('backend/users/{user}/update', [App\Http\Controllers\Backend\Nusantara\UserController::class, 'update'])->name('backend.users.update');
    Route::get('backend/admin/profile', [App\Http\Controllers\Backend\Nusantara\BackendController::class, 'userprofile'])->name('backend.userprofile');

    // Employe
    Route::get('backend/employes/index', [App\Http\Controllers\Backend\Nusantara\EmployeController::class, 'index'])->name('backend.employes.index');
    Route::get('backend/employes/create', [App\Http\Controllers\Backend\Nusantara\EmployeController::class, 'create'])->name('backend.employes.create');
    Route::post('backend/employes/store', [App\Http\Controllers\Backend\Nusantara\EmployeController::class, 'store'])->name('backend.employes.store');
    Route::get('backend/employes/{employe}/edit', [App\Http\Controllers\Backend\Nusantara\EmployeController::class, 'edit'])->name('backend.employes.edit');
    Route::put('backend/employes/{employe}/update', [App\Http\Controllers\Backend\Nusantara\EmployeController::class, 'update'])->name('backend.employes.update');
    Route::get('backend/employes/profile', [App\Http\Controllers\Backend\Nusantara\BackendController::class, 'employeprofile'])->name('backend.employes.profile');
    Route::post('backend/employes/importSave', [App\Http\Controllers\Backend\Nusantara\EmployeController::class, 'importSave'])->name('backend.employes.importSave');
    Route::post('backend/employes/importSaveJabatan', [App\Http\Controllers\Backend\Nusantara\EmployeController::class, 'importSaveJabatan'])->name('backend.employes.importSaveJabatan');

    // Greetings
    Route::get('backend/greetings', [App\Http\Controllers\Backend\Nusantara\GreetingController::class, 'index'])->name('backend.greetings.index');
    Route::get('backend/greetings/create', [App\Http\Controllers\Backend\Nusantara\GreetingController::class, 'create'])->name('backend.greetings.create');
    Route::post('backend/greetings/store', [App\Http\Controllers\Backend\Nusantara\GreetingController::class, 'store'])->name('backend.greetings.store');
    Route::get('backend/greetings/{greeting}/edit', [App\Http\Controllers\Backend\Nusantara\GreetingController::class, 'edit'])->name('backend.greetings.edit');
    Route::put('backend/greetings/{greeting}/update', [App\Http\Controllers\Backend\Nusantara\GreetingController::class, 'update'])->name('backend.greetings.update');

    // Pagecategory
    Route::get('backend/pagecategories', [App\Http\Controllers\Backend\Nusantara\PageCategoryController::class, 'index'])->name('backend.pagecategories.index');

    // Pages
    Route::get('backend/pages', [App\Http\Controllers\Backend\Nusantara\PageController::class, 'index'])->name('backend.pages.index');
    Route::get('backend/pages/create', [App\Http\Controllers\Backend\Nusantara\PageController::class, 'create'])->name('backend.pages.create');
    Route::post('backend/pages/store', [App\Http\Controllers\Backend\Nusantara\PageController::class, 'store'])->name('backend.pages.store');
    Route::get('backend/pages/{page}/edit', [App\Http\Controllers\Backend\Nusantara\PageController::class, 'edit'])->name('backend.pages.edit');
    Route::put('backend/pages/{page}/update', [App\Http\Controllers\Backend\Nusantara\PageController::class, 'update'])->name('backend.pages.update');


    // Pengajiancategory
    Route::get('backend/pengajiancategories', [App\Http\Controllers\Backend\Nusantara\PengajianCategoryController::class, 'index'])->name('backend.pengajiancategories.index');

    // Pengajian
    Route::get('backend/pengajian', [App\Http\Controllers\Backend\Nusantara\PengajianController::class, 'index'])->name('backend.pengajian.index');
    Route::get('backend/pengajian/create', [App\Http\Controllers\Backend\Nusantara\PengajianController::class, 'create'])->name('backend.pengajian.create');
    Route::post('backend/pengajian/store', [App\Http\Controllers\Backend\Nusantara\PengajianController::class, 'store'])->name('backend.pengajian.store');
    Route::get('backend/pengajian/{pengajian}/edit', [App\Http\Controllers\Backend\Nusantara\PengajianController::class, 'edit'])->name('backend.pengajian.edit');
    Route::put('backend/pengajian/{pengajian}/update', [App\Http\Controllers\Backend\Nusantara\PengajianController::class, 'update'])->name('backend.pengajian.update');

    // Petugas Jumat
    Route::get('backend/petugasjumat', [App\Http\Controllers\Backend\Nusantara\PetugasjumatController::class, 'index'])->name('backend.petugasjumat.index');
    Route::get('backend/petugasjumat/create', [App\Http\Controllers\Backend\Nusantara\PetugasjumatController::class, 'create'])->name('backend.petugasjumat.create');
    Route::post('backend/petugasjumat/store', [App\Http\Controllers\Backend\Nusantara\PetugasjumatController::class, 'store'])->name('backend.petugasjumat.store');
    Route::get('backend/petugasjumat/{petugasjumat}/edit', [App\Http\Controllers\Backend\Nusantara\PetugasjumatController::class, 'edit'])->name('backend.petugasjumat.edit');
    Route::put('backend/petugasjumat/{petugasjumat}/update', [App\Http\Controllers\Backend\Nusantara\PetugasjumatController::class, 'update'])->name('backend.petugasjumat.update');

    // Peraturan
    Route::get('backend/peraturan', [App\Http\Controllers\Backend\Nusantara\PergubController::class, 'index'])->name('backend.peraturan.index');

    // Jenjang Pendidikan
    Route::get('backend/jenjangpendidikan', [App\Http\Controllers\Backend\Nusantara\JenjangpendidikanController::class, 'index'])->name('backend.jenjangpendidikan.index');

    // Periode
    Route::get('backend/periode', [App\Http\Controllers\Backend\Nusantara\PeriodeController::class, 'index'])->name('backend.periode.index');

    // Structuroganization
    Route::get('backend/structuroganization', [App\Http\Controllers\Backend\Nusantara\StructuroganizationController::class, 'index'])->name('backend.structuroganization.index');

    // Management
    Route::get('backend/management', [App\Http\Controllers\Backend\Nusantara\ManagementController::class, 'index'])->name('backend.management.index');

    // Organization
    Route::get('backend/organization', [App\Http\Controllers\Backend\Nusantara\OrganizationController::class, 'index'])->name('backend.organizations.index');
    Route::get('backend/organization/create', [App\Http\Controllers\Backend\Nusantara\OrganizationController::class, 'create'])->name('backend.organizations.create');
    Route::post('backend/organization/store', [App\Http\Controllers\Backend\Nusantara\OrganizationController::class, 'store'])->name('backend.organizations.store');
    Route::get('backend/organization/{organization}/edit', [App\Http\Controllers\Backend\Nusantara\OrganizationController::class, 'edit'])->name('backend.organizations.edit');
    Route::put('backend/organization/{organization}/update', [App\Http\Controllers\Backend\Nusantara\OrganizationController::class, 'update'])->name('backend.organizations.update');

    // Agama
    Route::get('backend/religi', [App\Http\Controllers\Backend\Nusantara\AgamaController::class, 'index'])->name('backend.religi.index');

    // PostCategory
    Route::get('backend/postcategories', [App\Http\Controllers\Backend\Nusantara\PostCategoryController::class, 'index'])->name('backend.postscategories.index');

    // PostSubcategory
    Route::get('backend/postsubcategories', [App\Http\Controllers\Backend\Nusantara\PostSubcategoryController::class, 'index'])->name('backend.postssubcategories.index');

    // Tag
    Route::get('backend/tags', [App\Http\Controllers\Backend\Nusantara\TagController::class, 'index'])->name('backend.tags.index');

    // Post
    Route::get('backend/allposts', [App\Http\Controllers\Backend\Nusantara\PostController::class, 'index'])->name('backend.posts.index');
    Route::get('backend/posts/create', [App\Http\Controllers\Backend\Nusantara\PostController::class, 'create'])->name('backend.posts.create');
    Route::post('backend/posts/store', [App\Http\Controllers\Backend\Nusantara\PostController::class, 'store'])->name('backend.posts.store');
    Route::get('backend/posts/{post}/edit', [App\Http\Controllers\Backend\Nusantara\PostController::class, 'edit'])->name('backend.posts.edit');
    Route::put('backend/posts/{post}/update', [App\Http\Controllers\Backend\Nusantara\PostController::class, 'update'])->name('backend.posts.update');

    // Json Data for Category and District
    Route::get('backend/get/postsubcategory/{postcategory_id}', [App\Http\Controllers\Backend\Nusantara\PostController::class, 'getsubcategorypost'])->name('backend.posts.getsubcategorypost');

    // Literacycategory
    Route::get('backend/allliteracycategories', [App\Http\Controllers\Backend\Nusantara\LiteracycategoryController::class, 'index'])->name('backend.literacycategories.index');
    Route::get('backend/literacycategories/create', [App\Http\Controllers\Backend\Nusantara\LiteracycategoryController::class, 'create'])->name('backend.literacycategories.create');
    Route::post('backend/literacycategories/store', [App\Http\Controllers\Backend\Nusantara\LiteracycategoryController::class, 'store'])->name('backend.literacycategories.store');
    Route::get('backend/literacycategories/{literacycategory}/edit', [App\Http\Controllers\Backend\Nusantara\LiteracycategoryController::class, 'edit'])->name('backend.literacycategories.edit');
    Route::put('backend/literacycategories/{literacycategory}/update', [App\Http\Controllers\Backend\Nusantara\LiteracycategoryController::class, 'update'])->name('backend.literacycategories.update');

    // Literacysubcategory
    Route::get('backenda/allliteracysubcategories', [App\Http\Controllers\Backend\Nusantara\LiteracysubcategoryController::class, 'index'])->name('backend.literacysubcategories.index');
    Route::get('backend/literacysubcategories/create', [App\Http\Controllers\Backend\Nusantara\LiteracysubcategoryController::class, 'create'])->name('backend.literacysubcategories.create');
    Route::post('backend/literacysubcategories/store', [App\Http\Controllers\Backend\Nusantara\LiteracysubcategoryController::class, 'store'])->name('backend.literacysubcategories.store');
    Route::get('backend/literacysubcategories/{literacysubcategory}/edit', [App\Http\Controllers\Backend\Nusantara\LiteracysubcategoryController::class, 'edit'])->name('backend.literacysubcategories.edit');
    Route::put('backend/literacysubcategories/{literacysubcategory}/update', [App\Http\Controllers\Backend\Nusantara\LiteracysubcategoryController::class, 'update'])->name('backend.literacysubcategories.update');

    // Literacy
    Route::get('backend/allliteracies', [App\Http\Controllers\Backend\Nusantara\LiteracyController::class, 'index'])->name('backend.literacies.index');
    Route::get('backend/literacies/create', [App\Http\Controllers\Backend\Nusantara\LiteracyController::class, 'create'])->name('backend.literacies.create');
    Route::post('backend/literacies/store', [App\Http\Controllers\Backend\Nusantara\LiteracyController::class, 'store'])->name('backend.literacies.store');
    Route::get('backend/literacies/{literacy}/edit', [App\Http\Controllers\Backend\Nusantara\LiteracyController::class, 'edit'])->name('backend.literacies.edit');
    Route::put('backend/literacies/{literacy}/update', [App\Http\Controllers\Backend\Nusantara\LiteracyController::class, 'update'])->name('backend.literacies.update');

    // Json Data for Literacy Category
    Route::get('backend/get/literacysubcategory/{literacycategory_id}', [App\Http\Controllers\Backend\Nusantara\LiteracyController::class, 'getliteracysubcategory'])->name('backend.literacies.getliteracysubcategory');

    // Slider
    Route::get('backend/allsliders', [App\Http\Controllers\Backend\Nusantara\SliderController::class, 'index'])->name('backend.sliders.index');
    Route::get('backend/sliders/create', [App\Http\Controllers\Backend\Nusantara\SliderController::class, 'create'])->name('backend.sliders.create');
    Route::post('backend/sliders/store', [App\Http\Controllers\Backend\Nusantara\SliderController::class, 'store'])->name('backend.sliders.store');
    Route::get('backend/sliders/{slider}/edit', [App\Http\Controllers\Backend\Nusantara\SliderController::class, 'edit'])->name('backend.sliders.edit');
    Route::put('backend/sliders/{slider}/update', [App\Http\Controllers\Backend\Nusantara\SliderController::class, 'update'])->name('backend.sliders.update');

    // Album
    Route::get('backend/allalbums', [App\Http\Controllers\Backend\Nusantara\AlbumController::class, 'index'])->name('backend.albums.index');
    Route::get('backend/albums/create', [App\Http\Controllers\Backend\Nusantara\AlbumController::class, 'create'])->name('backend.albums.create');
    Route::post('backend/albums/store', [App\Http\Controllers\Backend\Nusantara\AlbumController::class, 'store'])->name('backend.albums.store');
    Route::get('backend/albums/{album}/edit', [App\Http\Controllers\Backend\Nusantara\AlbumController::class, 'edit'])->name('backend.albums.edit');
    Route::put('backend/albums/{album}/update', [App\Http\Controllers\Backend\Nusantara\AlbumController::class, 'update'])->name('backend.albums.update');

    // VideoCategory
    Route::get('backend/videocategories', [App\Http\Controllers\Backend\Nusantara\CategoryVideoController::class, 'index'])->name('backend.videoscategories.index');

    // Video
    Route::get('backend/allvideo', [App\Http\Controllers\Backend\Nusantara\VideoController::class, 'index'])->name('backend.video.index');
    Route::get('backend/video/create', [App\Http\Controllers\Backend\Nusantara\VideoController::class, 'create'])->name('backend.video.create');
    Route::post('backend/video/store', [App\Http\Controllers\Backend\Nusantara\VideoController::class, 'store'])->name('backend.video.store');
    Route::get('backend/video/{video}/edit', [App\Http\Controllers\Backend\Nusantara\VideoController::class, 'edit'])->name('backend.video.edit');
    Route::put('backend/video/{video}/update', [App\Http\Controllers\Backend\Nusantara\VideoController::class, 'update'])->name('backend.video.update');

    // Foto
    Route::get('backend/allfotos', [App\Http\Controllers\Backend\Nusantara\FotoController::class, 'index'])->name('backend.fotos.index');
    Route::get('backend/fotos/create', [App\Http\Controllers\Backend\Nusantara\FotoController::class, 'create'])->name('backend.fotos.create');
    Route::post('backend/fotos/store', [App\Http\Controllers\Backend\Nusantara\FotoController::class, 'store'])->name('backend.fotos.store');
    Route::get('backend/fotos/{foto}/edit', [App\Http\Controllers\Backend\Nusantara\FotoController::class, 'edit'])->name('backend.fotos.edit');
    Route::put('backend/fotos/{foto}/update', [App\Http\Controllers\Backend\Nusantara\FotoController::class, 'update'])->name('backend.fotos.update');

    // Advertisement
    Route::get('backend/alladvertisements', [App\Http\Controllers\Backend\Nusantara\AdvertisementController::class, 'index'])->name('backend.advertisements.index');
    Route::get('backend/advertisements/create', [App\Http\Controllers\Backend\Nusantara\AdvertisementController::class, 'create'])->name('backend.advertisements.create');
    Route::post('backend/advertisements/store', [App\Http\Controllers\Backend\Nusantara\AdvertisementController::class, 'store'])->name('backend.advertisements.store');
    Route::get('backend/advertisements/{advertisement}/edit', [App\Http\Controllers\Backend\Nusantara\AdvertisementController::class, 'edit'])->name('backend.advertisements.edit');
    Route::put('backend/advertisements/{advertisement}/update', [App\Http\Controllers\Backend\Nusantara\AdvertisementController::class, 'update'])->name('backend.advertisements.update');

    // Agenda
    Route::get('backend/allagenda', [App\Http\Controllers\Backend\Nusantara\AgendaController::class, 'index'])->name('backend.agendas.index');
    Route::get('backend/agendas/create', [App\Http\Controllers\Backend\Nusantara\AgendaController::class, 'create'])->name('backend.agendas.create');
    Route::post('backend/agendas/store', [App\Http\Controllers\Backend\Nusantara\AgendaController::class, 'store'])->name('backend.agendas.store');
    Route::get('backend/agendas/{agenda}/edit', [App\Http\Controllers\Backend\Nusantara\AgendaController::class, 'edit'])->name('backend.agendas.edit');
    Route::put('backend/agendas/{agenda}/update', [App\Http\Controllers\Backend\Nusantara\AgendaController::class, 'update'])->name('backend.agendas.update');

    // Widget
    Route::get('backend/allwidget', [App\Http\Controllers\Backend\Nusantara\WidgetController::class, 'index'])->name('backend.widgets.index');
    Route::get('backend/widgets/create', [App\Http\Controllers\Backend\Nusantara\WidgetController::class, 'create'])->name('backend.widgets.create');
    Route::post('backend/widgets/store', [App\Http\Controllers\Backend\Nusantara\WidgetController::class, 'store'])->name('backend.widgets.store');
    Route::get('backend/widgets/{widget}/edit', [App\Http\Controllers\Backend\Nusantara\WidgetController::class, 'edit'])->name('backend.widgets.edit');
    Route::put('backend/widgets/{widget}/update', [App\Http\Controllers\Backend\Nusantara\WidgetController::class, 'update'])->name('backend.widgets.update');

    // Menu
    Route::get('backend/categorymenu', [App\Http\Controllers\Backend\Nusantara\MenuController::class, 'index'])->name('backend.menu.index');
    Route::get('backend/menuitem', [App\Http\Controllers\Backend\Nusantara\MenuController::class, 'menuitem'])->name('backend.menuitem.index');
    Route::get('backend/menuitem/structure', [App\Http\Controllers\Backend\Nusantara\MenuController::class, 'structure'])->name('backend.menuitem.structure');

    // Download
    Route::get('backend/dldcategory', [App\Http\Controllers\Backend\Nusantara\DownloadController::class, 'categoryindex'])->name('backend.download.categoryindex');
    Route::get('backend/download', [App\Http\Controllers\Backend\Nusantara\DownloadController::class, 'downloadindex'])->name('backend.download.downloadindex');
    Route::get('backend/download/create', [App\Http\Controllers\Backend\Nusantara\DownloadController::class, 'create'])->name('backend.download.create');
    Route::post('backend/download/store', [App\Http\Controllers\Backend\Nusantara\DownloadController::class, 'store'])->name('backend.download.store');
    Route::get('backend/download/{download}/edit', [App\Http\Controllers\Backend\Nusantara\DownloadController::class, 'edit'])->name('backend.download.edit');
    Route::put('backend/download/{download}/update', [App\Http\Controllers\Backend\Nusantara\DownloadController::class, 'update'])->name('backend.download.update');

    // Default Home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


View::composer('*', function ($view) {
    $global_option = Option::first();
    if (!empty($global_option)) {
        $view->with('global_option', $global_option);
    } else {
        $view->with('global_option', '0');
    }
});
