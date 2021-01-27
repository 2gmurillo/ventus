<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Verify if user can view any user in admin panel.
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);
        return view('admin.users.index', [
            'users' => User::latest()->paginate(8),
        ]);
    }

    /**
     * Verify if user can create a user.
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:80'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_verified_at' => ['null'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'remember_token' => ['null'],
        ]);
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($validatedData['password']),
            'remember_token' => Str::random(10),
        ]);
        Alert::success(__('admin.users.created'));
        return redirect()->route('admin.users.index');
    }

    /**
     * Verify if user can update a user.
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit(User $user): View
    {
        $this->authorize('update', User::class);
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Verify if user can update a user.
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', User::class);
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:80'],
        ]);
        $user->update([
            'name' => $validatedData['name'],
        ]);
        Alert::success(__('admin.users.updated'));
        return redirect()->route('admin.users.index');
    }

    /**
     * Verify if user can delete a user.
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);
        $user->delete();
        Alert::success(__('admin.users.deleted'));
        return back();
    }

    /**
     * Verify if user can change the user status.
     * Change the specified user status.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function changeUserStatus(User $user): RedirectResponse
    {
        $this->authorize('changeUserStatus', $user);
        $user->update(['disabled_at' => $user->disabled_at ? null : now()]);
        return back();
    }
}
