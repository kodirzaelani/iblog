<?php

use App\Http\Livewire\Template\Frontend\Terasblue\Main\Index;
use App\Http\Livewire\Template\Frontend\Terasblue\Main\Maincontact;
use App\Http\Livewire\Template\Frontend\Terasblue\Page\Fpagedetail;
use App\Http\Livewire\Template\Frontend\Terasblue\Post\Fpostall;
use App\Http\Livewire\Template\Frontend\Terasblue\Post\Fpostdetail;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)->name('root');
Route::get('/postdetail', Fpostdetail::class)->name('frontend.post.detail');
Route::get('/postall', Fpostall::class)->name('frontend.post.all');
Route::get('/pagedetail', Fpagedetail::class)->name('frontend.page.detail');
Route::get('/contact', Maincontact::class)->name('frontend.contact.detail');
