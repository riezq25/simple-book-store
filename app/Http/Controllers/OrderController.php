<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function index()
    {
        $title = 'Riwayat Transaksi';
        $orders = Order::orderBy(request()->get('sort_column', 'order_date'), request()->get('sort_direction', 'desc'))
            ->when(auth()->user()->isCustomer(), function ($query) {
                $query->where('customer_id',
                    auth()->user()->id);
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

    function show($id)
    {
        $order = Order::findOrFail($id);
        $order->load([
            'customer',
            'details.book'
        ]);
        $title = 'Detail Transaksi - ' . $order->invoice_number;
        $data = compact('title', 'order');
        return view('dashboard.order.show', $data);
    }

    function create()
    {
        $title = 'Transaksi Baru';
        $customers = Customer::orderBy('customer_name', 'asc')
            ->get([
                'customer_id',
                'customer_name',
            ]);
        $books = Book::orderBy('title')
            ->where('stock', '>=', 0)
            ->get();

        $data = compact('customers', 'books', 'title');
        return view('dashboard.order.create', $data);
    }

    function store(Request $request)
    {
        try {
            // validasi
            $rules = [
                'customer_id' => [
                    'required',
                    'exists:customers,customer_id'
                ],
                'order_date' => [
                    'required',
                    'date'
                ],
                'details' => [
                    'required'
                ],
            ];

            $attributes = [
                'customer_id' => 'Pelanggan',
                'order_date' => 'Tanggal Transaksi',
                'details' => 'Details',
            ];

            $validated = $request
                ->validate(
                    $rules,
                    [],
                    $attributes
                );

            // $result = DB::select("CALL CreateOrder(?, ?, ?)", [
            //     $validated['customer_id'],
            //     $validated['order_date'],
            //     json_encode(json_decode($validated['details'])),
            // ]);

            $result = DB::select("CALL CreateOrder(?, ?, ?)", [
                $validated['customer_id'],
                $validated['order_date'],
                $validated['details']
            ]);
            return redirect(route('order.index'))
                ->with([
                    'success'   => 'Berhasil menyimpan data transaksi'
                ]);
            // redirect
        } catch (\Throwable $th) {
            return response()
                ->json([
                    'message' => $th->getMessage()
                ], 500);
        }
    }
}
