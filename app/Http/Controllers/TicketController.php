<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct()
    {
        // Pastikan user sudah login
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Role-based fetching
        if ($user->hasRole('superadmin')) {
            $tickets = Ticket::all();
        } elseif ($user->hasRole('admin unit')) {
            $tickets = Ticket::where('unit_id', $user->unit_id)->get();
        } elseif ($user->hasRole('agent')) {
            $tickets = Ticket::where('assigned_to', $user->id)->get();
        } else { // User biasa
            $tickets = Ticket::where('created_by', $user->id)->get();
        }

        return inertia('Tickets/Index', ['tickets' => $tickets]);
    }

    public function create()
    {
        return inertia('Tickets/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::id(), // pastikan field di DB 'created_by'
            'status' => 'open',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket created.');
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        return inertia('Tickets/Show', ['ticket' => $ticket]);
    }

    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        return inertia('Tickets/Edit', ['ticket' => $ticket]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->update($request->only(['status', 'title', 'description']));
        return redirect()->route('tickets.index')->with('success', 'Ticket updated.');
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $user = auth()->user();
        if ($user->hasRole('superadmin')) {
            $ticket->delete();
            return redirect()->route('tickets.index')->with('success', 'Ticket deleted.');
        }

        abort(403);
    }
}
