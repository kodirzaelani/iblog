<div>
    <div class="sidebar-item recent-posts mt-4">
        <h3 class="sidebar-title"><i class="bi bi-book-half"></i> {{ $titlepopular }} </h3>

        <div class="mt-3">
            @foreach ($post_popular as $item)
                <div class="post-item mt-3">
                    <img src="{{ $item->imageThumbUrl ? $item->imageThumbUrl : '/uploads/default/logobpic_thumb.png' }}"
                        alt="" class="flex-shrink-0" title="{{ $item->title }}" style="cursor: pointer">
                    <div>
                        <h4><a href="{{ route('post.detail', $item->slug) }}"
                                title="{{ $item->title }}">{{ Str::limit($item->title, 40) }}</a></h4>
                        <time datetime="2023-01-10">{{ TanggalID('j M Y', $item->published_at) }}</time>
                    </div>
                </div><!-- End recent post item-->
            @endforeach
        </div>

    </div><!-- End sidebar recent posts-->

</div>
