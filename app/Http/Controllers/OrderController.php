<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function print(Order $order)
    {
        $order->update(['status' => 'DIPRINT']);
        $pdf = Pdf::loadView('invoices.invoice', compact('order'));
        return $pdf->stream('invoice-'.$order->id.'.pdf');
    }

    public function download(Order $order)
    {
        $pdf = Pdf::loadView('invoices.invoice', compact('order'));
        return $pdf->download('invoice-'.$order->id.'.pdf');
    }
}
