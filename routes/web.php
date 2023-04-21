<?php

use App\Http\Livewire\Template\Frontend\Terasblue\Main\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)->name('root');
