<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;

class PostObserver
{
    /**
     * Handle the Post "saving" event.
     * @param Post $post
     * @return void
     */
    public function saving(Post $post): void
    {
        if (empty($post->{Post::COL_SLUG}) || $post->isDirty(Post::COL_TITLE)) {
            $post->{Post::COL_SLUG} = Str::slug($post->{Post::COL_TITLE}) . '-' . Str::random(5);
        }
    }

    /**
     * Handle the Post "created" event.
     * @param Post $post
     * @return void
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     * @param Post $post
     * @return void
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     * @param Post $post
     * @return void
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     * @param Post $post
     * @return void
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     * @param Post $post
     * @return void
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
