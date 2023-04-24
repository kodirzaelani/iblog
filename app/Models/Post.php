<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;
    protected $table      = 'posts';
    protected $primaryKey = 'id';
    protected $guarded    = [];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $createdAt  = ['created_at'];
    protected $updatedAt  = ['updated_at'];


    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function sliders()
    {
        return $this->hasMany(Slider::class, 'post_id');
    }

    public function postcategory()
    {
        return $this->belongsTo(Postcategory::class, 'postcategory_id');
    }

    public function postsubcategory()
    {
        return $this->belongsTo(Postsubcategory::class, 'postsubcategory_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getTagsHtmlAttribute()
    {
        $anchors = [];
        foreach ($this->tags as $tag) {
            // $anchors[] = '<a href="#">' . $tag->title . '</a>';
            // $anchors[] = '<span ><a href="' .route('post.tag', $tag->slug) . '" > ' . $tag->title . '</a></span>';
            $anchors[] = '<li ><a href="' . route('post.tag', $tag->slug) . '" > ' . $tag->title . '</a></li>';
        }
        return implode(", ", $anchors);
    }

    public function getTagsHtmlbackAttribute()
    {
        $anchors = [];
        foreach ($this->tags as $tag) {
            $anchors[] = '<small><span><a href="' . route('post.tag', $tag->slug) . '" > ' . $tag->title . '</a></span></small>';
        }
        return implode(", ", $anchors);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($q) use ($term) {
            $q->whereHas('author', function ($qr) use ($term) {
                $qr->where('name', 'LIKE', $term);
            });
            $q->orWhereHas('postcategory', function ($qr) use ($term) {
                $qr->where('title', 'LIKE', $term);
            });
            $q->orWhereHas('postsubcategory', function ($qr) use ($term) {
                $qr->where('title', 'LIKE', $term);
            });
            $q->orWhereHas('tags', function ($qr) use ($term) {
                $qr->where('title', 'LIKE', $term);
            });
            $q->orWhereRaw('LOWER(title) LIKE ?', [$term]);
            $q->orWhereRaw('LOWER(content) LIKE ?', [$term]);
        });
    }

    public function scopeFilter($query, $filter)
    {
        if (isset($filter['month']) && $month = $filter['month']) {
            if (env('DB_CONNECTION') == 'pgsql') {
                $query->whereRaw('extract(month from created_at) = ?', [$month]);
            } else {
                $query->whereRaw('month(created_at) = ?', [$month]);
            }
        }

        if (isset($filter['year']) && $year = $filter['year']) {
            if (env('DB_CONNECTION') == 'pgsql') {
                $query->whereRaw('extract(year from created_at) = ?', [$year]);
            } else {
                $query->whereRaw('year(created_at) = ?', [$year]);
            }
        }

        // check if any term entered
        if (isset($filter['term']) && $term = strtolower($filter['term'])) {
            $query->where(function ($q) use ($term) {
                $q->whereHas('author', function ($qr) use ($term) {
                    $qr->where('name', 'LIKE', "%{$term}%");
                });
                $q->orWhereHas('postcategory', function ($qr) use ($term) {
                    $qr->where('title', 'LIKE', "%{$term}%");
                });
                $q->orWhereHas('postsubcategory', function ($qr) use ($term) {
                    $qr->where('title', 'LIKE', "%{$term}%");
                });
                $q->orWhereHas('tags', function ($qr) use ($term) {
                    $qr->where('title', 'LIKE', "%{$term}%");
                });
                $q->orWhereRaw('LOWER(title) LIKE ?', ["%{$term}%"]);
                $q->orWhereRaw('LOWER(content) LIKE ?', ["%{$term}%"]);
            });
        }
    }

    public function getImageUrlAttribute($value)
    {
        $imageUrl = "";

        if (!is_null($this->image)) {
            $directory = config('cms.image.directoryPosts');
            $imagePath = public_path() . "/{$directory}" . $this->image;
            if (file_exists($imagePath)) $imageUrl = asset("/{$directory}" . $this->image);
        }

        return $imageUrl;
    }

    public function getImageThumbUrlAttribute($value)
    {
        $imageThumbUrl = "";

        if (!is_null($this->image)) {
            $directory = config('cms.image.directoryPosts');
            $ext       = substr(strrchr($this->image, '.'), 1);
            $thumbnail = str_replace(".{$ext}", "_thumb.{$ext}", $this->image);
            $imagePath = public_path() . "/{$directory}" . $thumbnail;
            if (file_exists($imagePath)) $imageThumbUrl = asset("/$directory" . $thumbnail);
        }

        return $imageThumbUrl;
    }


    public function getStatusLabelAttribute()
    {
        //ADAPUN VALUENYA AKAN MENCETAK HTML BERDASARKAN VALUE DARI FIELD STATUS
        if ($this->status == 0) {
            return '<span class="badge badge-primary">Draft</span>';
        }
        return '<span class="badge badge-success">Published</span>';
    }

    // fungsi scope untuk manampilkan yang status headline
    public function scopeHeadline($query)
    {
        return $query->where("headline", "=", 1);
    }
    // fungsi scope untuk manampilkan yang status selection
    public function scopeSelection($query)
    {
        return $query->where("selection", "=", 1);
    }
    // fungsi scope untuk manampilkan yang status selection
    public function scopeBlog($query)
    {
        return $query->where("statusblog", "=", 1);
    }
    // fungsi scope untuk manampilkan yang status Comment
    public function scopeCommentstatus($query)
    {
        return $query->where("comment_status", "=", 1);
    }
    // fungsi scope untuk manampilkan yang status publish
    public function scopePublished($query)
    {
        return $query->where("status", "=", 1);
    }
    // fungsi scope untuk manampilkan yang status publish
    public function scopeDraft($query)
    {
        return $query->where("status", "=", 0);
    }
    // fungsi scope untuk manampilkan yang status pilihan
    public function scopeFeatured($query)
    {
        return $query->where("selection", "=", 0);
    }

    // fungsi scope untuk mengurutkan tulisan popular
    public function scopePopular($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    public static function archives()
    {
        if (env('DB_CONNECTION') == 'pgsql') {
            return static::selectRaw('count(id) as post_count, extract(year from published_at) as year, extract(month from published_at) as month')
                ->published()
                ->groupBy('year', 'month')
                ->orderByRaw('min(published_at) desc')
                ->get();
        } else {
            return static::selectRaw('count(id) as post_count, year(published_at) year, month(published_at) month')
                ->published()
                ->groupBy('year', 'month')
                ->orderByRaw('min(published_at) desc')
                ->get();
        }
    }
}
