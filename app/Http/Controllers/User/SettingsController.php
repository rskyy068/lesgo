<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Show user settings page.
     */
    public function index()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }
}
