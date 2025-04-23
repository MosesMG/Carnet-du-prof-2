<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Mail\AdminToUserMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class UsersController extends Controller
{
    public function indexUsers(): View
    {
        return view('users.index', [
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function showUser(string $user): View
    {
        $user = User::find($user);
        
        return view('users.show', [
            'user' => $user,
        ]);
    }

    public function messageUser(string $user, Request $request): RedirectResponse
    {
        $user = User::find($user);

        Mail::send(new AdminToUserMail($user, $request->message));

        return back()->with('message', 'Message envoyé avec succès !');
    }

    public function blockUser(string $user)
    {
        $user = User::find($user);
        
        $user->is_active = 0;
        $user->save();

        return redirect()->route('admin.user.show', $user)->with(
            'message', "Utilisateur bloqué !",
        );
    }

    public function freeUser(string $user): RedirectResponse
    {
        $user = User::find($user);
        
        $user->is_active = 1;
        $user->save();

        return redirect()->route('admin.user.show', $user)->with(
            'message', "Utilisateur débloqué !",
        );
    }

    public function deleteUser(string $user): RedirectResponse
    {
        $user = User::find($user);
        $user->delete();

        return redirect()->route('admin.users.index')->with(
            'message', 'Utilisateur supprimé !'
        );
    }
}
