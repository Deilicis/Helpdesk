<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

use App\Models\User;

class UsersController 
{
    public function index(): View
    {
        $users = User::paginate(15);
        return view('dash.users', compact('users'));
    }
    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Lietotājs izdzēsts!');
    }
}