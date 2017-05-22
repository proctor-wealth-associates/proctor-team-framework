<?php

namespace App\Http\Controllers;

use App\User;
use App\Jobs\StoreAvatar;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('can:manage,user')->except('show');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('pages.user.show', compact('user'));
    }

    /**
     * Show the editing page for the specified user.
     */
    public function edit(User $user)
    {
        return view('pages.user.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'filled|max:255',
            'avatar' => 'filled|image|max:4000',
            'password' => 'filled|min:6|confirmed',
        ]);

        if ($request->hasFile('avatar')) {
            dispatch(new StoreAvatar($user, 'avatars', $request->file('avatar')));
        }

        if ($request->exists('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->update($request->all());

        session()->flash('success', 'Profile updated.');
        return redirect()->back();
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
