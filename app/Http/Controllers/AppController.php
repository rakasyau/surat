<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Response; // Pastikan model ini ada
use Illuminate\Support\Facades\Session;

class AppController extends Controller
{
    public function index() {
        return view('pages.home');
    }

    public function checkName(Request $request) {
        $name = strtolower(trim($request->name));
        if($name === 'hasna') {
            Session::put('visitor', 'Hasna');
            return redirect()->route('story');
        }
        return back()->with('error', 'Bukan lu orangnya');
    }

    public function story() {
        if(!Session::has('visitor')) return redirect()->route('home');
        return view('pages.story');
    }

    public function choice() {
        if(!Session::has('visitor')) return redirect()->route('home');
        return view('pages.choice');
    }

    public function saveDecision(Request $request) {
        // Simpan ke database
        Response::create([
            'visitor_name' => 'Hasna',
            'choice' => $request->choice,
            'goodbye_attempts' => $request->attempts,
            'ip_address' => $request->ip()
        ]);

        // Redirect ke ending dengan status
        return redirect()->route('ending', ['status' => $request->choice]);
    }

    public function ending(Request $request) {
        if(!Session::has('visitor')) return redirect()->route('home');
        $status = $request->query('status', 'welcome');
        return view('pages.ending', compact('status'));
    }
}