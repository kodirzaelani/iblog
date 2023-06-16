<div>
    <h3 class="sidebar-title py-3"><i class="bi bi-folder"></i> {{ $titlecategory }}</h3>

    <div class="sidebar-item categories">
        <div class="list-group">
            @foreach ($postcategories as $item)
                @if ($item->posts->where('status', 1)->count() > 0)
                    <a href="{{ route('post.category', $item->slug) }}"
                        class="list-group-item list-group-item-action border-0 shadow-sm mb-2 rounded">{{ $item->title }}</a>
                @endif
            @endforeach
        </div>
    </div>
</div>
