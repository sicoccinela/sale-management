<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sales;
use App\Models\Order;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function verify(User $user, Order $order): bool
    {
        return $user instanceof User; // hanya admin
    }

    public function printInvoice(User $user, Order $order): bool
    {
        return $user instanceof User && $order->status === 'DIVERIFIKASI';
    }

    public function download(User|Sales $actor, Order $order): bool
    {
        return $order->status === 'DIPRINT';
    }
}
