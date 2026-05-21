<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $clients = Client::with('assignedManager')->paginate(10);
        } else {
            $clients = Client::where('assigned_manager_id', $user->id)
                ->with('assignedManager')
                ->paginate(10);
        }

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        return view('clients.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:20',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Клієнта успішно додано');
    }

    public function show(Client $client)
    {
        $user = Auth::user();

        if (!$user->hasRole('admin') && $client->assigned_manager_id !== $user->id) {
            abort(403);
        }

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Клієнта успішно оновлено');
    }

    public function destroy(Client $client)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Клієнта успішно видалено');
    }
}

