<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category_id',
        'author_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'canonical_url',
        'is_published',
        'published_at',
        'reading_time',
        'views_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'reading_time' => 'integer',
        'views_count'  => 'integer',
    ];

    // ─── Relationships ────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'blog_post_id', 'blog_tag_id');
    }

    // ─── Scopes ───────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeByCategory($query, string $slug)
    {
        return $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
    }

    public function scopeByTag($query, string $slug)
    {
        return $query->whereHas('tags', fn ($q) => $q->where('slug', $slug));
    }

    // ─── Accessors ────────────────────────────────────────────

    public function getReadingTimeAttribute(): int
    {
        if ($this->attributes['reading_time'] ?? null) {
            return (int) $this->attributes['reading_time'];
        }

        $wordCount = str_word_count(strip_tags($this->content ?? ''));

        return (int) max(1, ceil($wordCount / 200));
    }

    // ─── Helpers ──────────────────────────────────────────────

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
