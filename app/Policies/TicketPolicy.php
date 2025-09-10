<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    public function view(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id || $user->hasRole('Superadmin');
    }

    public function update(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id || $user->hasRole('Superadmin');
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id || $user->hasRole('Superadmin');
    }
}