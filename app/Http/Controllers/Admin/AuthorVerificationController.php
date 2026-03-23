<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuthorVerificationController extends Controller
{
    use AuthorizesRequests;

    protected UserServiceInterface $userService;

    /**
     * AuthorVerificationController constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of authors pending verification.
     * @return Response
     */
    public function index(): Response
    {
        $this->authorize('verify authors');

        return Inertia::render('Admin/VerifyAuthors', [
            'authors' => $this->userService->getAuthorsForVerification()
        ]);
    }

    /**
     * Verify the specified author.
     * @param User $user
     * @return RedirectResponse
     */
    public function verify(User $user): RedirectResponse
    {
        $this->authorize('verify authors');

        $this->userService->verifyAuthor($user);

        return redirect()->back()->with('message', "Autorius {$user->{User::COL_NAME}} sėkmingai patvirtintas.");
    }
}
