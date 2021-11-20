<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'employee' => Employee::count(),
            'position' => Position::count(),
            'presence' => Presence::count(),
            'user' => User::count()
        ]);
    }

    public function setting()
    {
        $user = Auth::user();
        return view('setting.index', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'nullable|min:6',
            'konfirmasi_password' => 'nullable|same:password'
        ]);

        $user = Auth::user();

        $password = !empty($request->password) ? bcrypt($request->password):$user->password;

        $user->update([
            'password' => $password
        ]);

        return redirect('/setting')->with(['sukses' => 'Data berhasil diubah!']);
    }
}
