<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug'
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'category_posts');
    }

    public function publishedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'category_posts')->where('active', '=', true)
            ->whereDate('published_at', '<', Carbon::now());
    }
}
