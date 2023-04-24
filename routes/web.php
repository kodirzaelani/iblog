<?php

use App\Http\Livewire\Template\Frontend\Terasblue\Main\Index;
use App\Http\Livewire\Template\Frontend\Terasblue\Post\Fpostdetail;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)->name('root');
Route::get('/poestdetail', Fpostdetail::class)->name('frontend.post.detail');
