<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Response; // Pastikan Model Response sudah ada
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // 1. Tampilkan Form Login
    public function loginForm() {
        if (Session::has('is_admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // 2. Proses Login (Password Sederhana)
    public function login(Request $request) {
        // GANTI PASSWORD DI SINI (Misal: 'kopi')
        $passwordBenar = 'kopi'; 

        if ($request->password === $passwordBenar) {
            Session::put('is_admin', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Password salah, Bro.');
    }

    // 3. Halaman Dashboard (Lihat Data)
    public function index() {
        if (!Session::has('is_admin')) {
            return redirect()->route('admin.login');
        }

        // Ambil data terbaru paling atas
        $responses = Response::latest()->get();
        
        return view('admin.dashboard', compact('responses'));
    }

    // 4. Logout
    public function logout() {
        Session::forget('is_admin');
        return redirect()->route('admin.login');
    }
}