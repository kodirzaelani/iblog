<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Main;

use App\Models\Page;
use App\Models\Post;
use App\Models\Album;
use App\Models\Video;
use Livewire\Component;
use App\Models\Download;
use App\Models\Greeting;
use App\Models\Pengajian;

class Homeindex extends Component
{
    public function render()
    {
        return view('livewire.template.backend.nusantara.main.homeindex',[
            'pages'      => Page::published()->get(),
            'posts'      => Post::published()->get(),
            'downloads'  => Download::published()->get(),
            'videos'     => Video::published()->take(3)->get(),
            'albums'     => Album::published()->take(3)->get(),
            'greetings'     => Greeting::published()->take(3)->get(),
            'pengajians'     => Pengajian::published()->take(3)->get(),
        ]);
    }
}
