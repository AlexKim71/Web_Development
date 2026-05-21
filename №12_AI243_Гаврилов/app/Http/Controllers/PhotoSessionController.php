<?php

namespace App\Http\Controllers;

use App\Models\PhotoSession;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhotoSessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $sessions = PhotoSession::with('client', 'manager')->paginate(10);
        } else {
            $sessions = PhotoSession::where('manager_id', $user->id)
                ->with('client', 'manager')
                ->paginate(10);
        }

        return view('photo-sessions.index', compact('sessions'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $clients = Client::all();
        $managers = User::role('manager')->get();

        return view('photo-sessions.create', compact('clients', 'managers'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'session_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'type' => 'required|in:весільна,сімейна,портретна,інші',
            'status' => 'required|in:нові,в процесі,завершено',
            'client_id' => 'required|exists:clients,id',
            'manager_id' => 'required|exists:users,id',
        ]);

        PhotoSession::create($validated);

        return redirect()->route('photo-sessions.index')->with('success', 'Фотоссесію успішно додано');
    }

    public function show(PhotoSession $photoSession)
    {
        $user = Auth::user();

        if (!$user->hasRole('admin') && $photoSession->manager_id !== $user->id) {
            abort(403);
        }

        return view('photo-sessions.show', compact('photoSession'));
    }

    public function edit(PhotoSession $photoSession)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $clients = Client::all();
        $managers = User::role('manager')->get();

        return view('photo-sessions.edit', compact('photoSession', 'clients', 'managers'));
    }

    public function update(Request $request, PhotoSession $photoSession)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'session_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'type' => 'required|in:весільна,сімейна,портретна,інші',
            'status' => 'required|in:нові,в процесі,завершено',
            'client_id' => 'required|exists:clients,id',
            'manager_id' => 'required|exists:users,id',
        ]);

        $photoSession->update($validated);

        return redirect()->route('photo-sessions.index')->with('success', 'Фотоссесію успішно оновлено');
    }

    public function destroy(PhotoSession $photoSession)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $photoSession->delete();

        return redirect()->route('photo-sessions.index')->with('success', 'Фотоссесію успішно видалено');
    }
}

