<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Anyone who is authenticated can view tickets list (filtered by role).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * User can view their own tickets. Admin can view all.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $ticket->user_id === $user->id;
    }

    /**
     * Any authenticated user (masyarakat) can create tickets.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only admin can update ticket details (status, assignment).
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin();
    }

    /**
     * Only super admin can delete tickets.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * User can message on their own tickets. Admin can message on any.
     */
    public function message(User $user, Ticket $ticket): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $ticket->user_id === $user->id;
    }

    /**
     * Only admin can assign tickets.
     */
    public function assign(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin();
    }

    /**
     * Only admin can change status.
     */
    public function changeStatus(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin();
    }
}
