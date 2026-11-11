<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Mengambil semua data user
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan (bisa pilih role admin/vendor dari form)
        $request->validate([...]);
        User::create($request->all());
        return redirect()->route('admin.users.index');
    }

    // Tambahkan method edit, update, destroy sesuai kebutuhan CRUD standar
}