<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function index()
    {
        $title = 'Riwayat Transaksi';
        $orders = Order::orderBy(request()->get('sort_column', 'order_date'), request()->get('sort_direction', 'desc'))
            ->when(auth()->user()->isCustomer(), function ($query) {
                $query->where([
                    'customer_id',
                    auth()->user()->id
                ]);
            })
            ->when(request()->search, function ($query) {
                $query->where(function ($query) {
                    $query->orWhere('invoice_number', 'like', '%' . request()->search . '%')
                        ->orWhereHas('customer', function ($query) {
                            $query->where('customer_name', 'like', '%' . request()->search . '%');
                        });
                });
            })
            ->when(request()->order_date, function ($query) {
                $query->where('order_date', request()->order_date);
            })
            ->with([
                'customer'
            ])
            ->paginate(10)
            ->withQueryString();

        $sortColumns = [
            'invoice_number' => 'Invoice',
            'order_date'    => 'Tanggal Transaksi',
        ];

        $data = compact('title', 'orders', 'sortColumns');

        return view('dashboard.order.index', $data);
    }

    function show() {}

    function create() {}

    function store() {}
}
