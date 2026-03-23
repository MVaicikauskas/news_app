<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Enums\VoteType;
use App\Services\Interfaces\PostServiceInterface;

class VoteController extends Controller
{
    protected PostServiceInterface $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Handle the voting for a post.
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function vote(Request $request, Post $post): RedirectResponse
    {
        $request->validate([
            'type' => 'required|integer|in:1,-1',
        ]);

        $type = VoteType::from($request->type);
        $user = $request->user();

        $this->postService->votePost(
            $post,
            $user?->{User::COL_ID},
            $type,
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->back();
    }
}
