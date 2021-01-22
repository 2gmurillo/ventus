<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::latest()->paginate(8),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
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
        Alert::success('Success Title', __('admin.users.created'));
        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
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
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        Alert::success(__('admin.users.deleted'));
        return back();
    }

    /**
     * Change the specified user status.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function changeUserStatus(User $user): RedirectResponse
    {
        $user->update(['disabled_at' => $user->disabled_at ? null : now()]);
        return back();
    }
}
