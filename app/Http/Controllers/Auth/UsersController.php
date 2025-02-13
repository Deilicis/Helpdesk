<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UsersController 
{
    public function index(): View
    {
        $users = User::paginate(5);
        return view('dash.users', compact('users'));
    }
    public function destroy($id): RedirectResponse
    {
        // Only allow admins to delete users
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('users.index')->with('success', 'Lietotājs izdzēsts!');
    }
    
}
