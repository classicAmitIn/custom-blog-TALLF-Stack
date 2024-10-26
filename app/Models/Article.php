<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Tags\HasTags;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;
    use SoftDeletes;
    use HasTags;


    protected $fillable = [
        'user_id',
        'category_id',
        'slug',
        'title',
        'summary',
        'body',
        'published_at',
        'featured_image',
        'featured_image_caption',
        'is_featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeFeatured($query)
    {
        $query->where('is_featured', true);
    }

    public function scopeWithCategory($query, string $category)
    {
        $query->whereHas('category', function ($query) use ($category) {
            $query->where('slug', $category);
        });
    }

    public function scopeSearch($query, string $search = '')
    {
        $query->where('title', 'like', "%{$search}%");
    }

    public function scopePopular($query)
    {
        $query->withCount('likes')->orderBy("likes_count", 'desc');
    }

     public function getReadingTime()
    {
        $mins = round(str_word_count($this->body) / 250);

        return ($mins < 1) ? 1 : $mins;
    }

    public function getSummary()
    {
        return Str::limit(strip_tags($this->summary), 156);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getFeaturedImageUrl()
    {
        $isUrl = str_contains($this->featured_image, 'http');

        return ($isUrl) ? $this->featured_image : Storage::disk('public')->url($this->featured_image);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'article_like')->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
