<?php

namespace App\Models;

use App\Enums\MediaConversionType;
use App\Enums\VoteType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[Fillable([self::COL_TITLE, self::COL_SLUG, self::COL_EXCERPT, self::COL_CONTENT, self::COL_USER_ID])]
class Post extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    const string COL_ID = 'id';
    const string COL_TITLE = 'title';
    const string COL_SLUG = 'slug';
    const string COL_EXCERPT = 'excerpt';
    const string COL_CONTENT = 'content';
    const string COL_USER_ID = 'user_id';
    const string COL_CREATED_AT = 'created_at';
    const string COL_UPDATED_AT = 'updated_at';
    const string COL_DELETED_AT = 'deleted_at';

    const string REL_AUTHOR = 'author';
    const string REL_VOTES = 'votes';
    const string REL_MEDIA = 'media';

    const string MEDIA_COLLECTION_IMAGES = 'images';

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, self::COL_USER_ID);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion(MediaConversionType::THUMB->value)
            ->width(368)
            ->height(232)
            ->sharpen(10);

        $this->addMediaConversion(MediaConversionType::LARGE->value)
            ->width(800)
            ->height(600);
    }

    /**
     * Get all of the votes for the post.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, Vote::COL_POST_ID);
    }

    /**
     * Get the like count for the post.
     */
    public function getLikesCountAttribute(): int
    {
        return $this->votes()->where(Vote::COL_TYPE, VoteType::LIKE)->count();
    }

    /**
     * Get the dislike count for the post.
     */
    public function getDislikesCountAttribute(): int
    {
        return $this->votes()->where(Vote::COL_TYPE, VoteType::DISLIKE)->count();
    }
}
