<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PhotoSession;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $clientsCount = Client::count();
            $sessionsCount = PhotoSession::count();
            $managersCount = User::role('manager')->count();
            $upcomingSessions = PhotoSession::where('session_date', '>=', now())
                ->orderBy('session_date')
                ->limit(5)
                ->get();
        } else {
            $clientsCount = Client::where('assigned_manager_id', $user->id)->count();
            $sessionsCount = PhotoSession::where('manager_id', $user->id)->count();
            $managersCount = 1;
            $upcomingSessions = PhotoSession::where('manager_id', $user->id)
                ->where('session_date', '>=', now())
                ->orderBy('session_date')
                ->limit(5)
                ->get();
        }

        return view('dashboard', compact(
            'clientsCount',
            'sessionsCount',
            'managersCount',
            'upcomingSessions'
        ));
    }
}

