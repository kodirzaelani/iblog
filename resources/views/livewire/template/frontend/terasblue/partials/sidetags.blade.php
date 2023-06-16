<div>
    <h3 class="sidebar-title py-3"><i class="bi bi-tags"></i>{{ $titletags }}</h3>
    <div class="sidebar-item tags">
        <ul>
            @foreach ($posttags as $item)
                @if ($item->posts->where('status', 1)->count() > 0)
                    <li><a href="{{ route('post.tag', $item->slug) }}">{{ $item->title }}</a></li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
