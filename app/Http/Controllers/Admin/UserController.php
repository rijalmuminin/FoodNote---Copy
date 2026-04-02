<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::latest()->get();
        return view('admin.user.index', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'peran'  => 'required|in:admin,user',
        ]);

        User::findOrFail($id)->update([
            'peran'  => $request->peran,
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diperbarui');
    }
}
