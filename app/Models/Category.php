<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'text_color',
        'bg_color',
        'is_active'
    ];


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
