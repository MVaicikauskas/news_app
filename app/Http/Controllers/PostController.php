<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    use AuthorizesRequests;

    protected PostServiceInterface $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $userId = null;
        if ($request->user() && $request->user()->hasRole(\App\Enums\UserRole::AUTHOR->value) && !$request->user()->hasRole(\App\Enums\UserRole::ADMIN->value)) {
            $userId = $request->user()->{User::COL_ID};
        }

        $trashed = $request->boolean('trashed');

        return Inertia::render('Posts/Index', [
            'posts' => $this->postService->getAllPosts(10, $userId, $trashed),
            'filters' => [
                'trashed' => $trashed
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     * @param PostRequest $request
     * @return RedirectResponse
     */
    public function store(PostRequest $request): RedirectResponse
    {
        $this->postService->createPost($request->validated(), $request->user(), $request->file('image'));

        return redirect()->route('posts.index')
            ->with('message', 'Įrašas sėkmingai sukurtas.');
    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function show(Request $request, Post $post): Response
    {
        return Inertia::render('Posts/Show', [
            'post' => $this->postService->getPost($post),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'can' => [
                'update_post' => $request->user()?->can('update', $post) ?? false,
                'delete_post' => $request->user()?->can('delete', $post) ?? false,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Post $post
     * @return Response
     */
    public function edit(Post $post): Response
    {
        $this->authorize('update', $post);

        return Inertia::render('Posts/Edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param PostRequest $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $this->postService->updatePost($post, $request->validated(), $request->file('image'));

        return redirect()->route('posts.index')
            ->with('message', 'Įrašas sėkmingai atnaujintas.');
    }

    /**
     * Remove the specified resource from storage.
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $this->postService->deletePost($post);

        return redirect()->route('posts.index')
            ->with('message', 'Įrašas sėkmingai ištrintas.');
    }

    /**
     * Restore the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function restore(int $id): RedirectResponse
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('restore', $post);

        $this->postService->restorePost($id);

        return redirect()->route('posts.index', ['trashed' => true])
            ->with('message', 'Įrašas sėkmingai atkurtas.');
    }

    /**
     * Permanently remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $post);

        $this->postService->forceDeletePost($id);

        return redirect()->route('posts.index', ['trashed' => true])
            ->with('message', 'Įrašas ištrintas visam laikui.');
    }
}
