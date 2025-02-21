<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'details.product'])
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'details.product']);
        DebugBar::info('Order Data:');
        DebugBar::info($order);
        return view('user.orders.show', compact('order'));
    }

    public function download(Order $order)
    {
        $order->load(['customer', 'details.product']);

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'tempDir' => storage_path('app/mpdf'),
            'fontDir' => [base_path('resources/fonts/dejavu')],
            'fontdata' => [
                'dejavu' => [
                    'R' => 'DejaVuSans.ttf',
                    'B' => 'DejaVuSans-Bold.ttf',
                ]
            ]
        ]);

        $html = view('exports.orderPdf', compact('order'))->render();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('don-hang-' . $order->id . '.pdf', 'D');
    }
}
