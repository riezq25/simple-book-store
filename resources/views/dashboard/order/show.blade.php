@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            <table class="mb-4 table table-sm table-borderless ">
                <tbody>
                    <tr>
                        <td width="20%">Invoice Number</td>
                        <td width="1%">:</td>
                        <td>#{{ $order->invoice_number }}</td>
                    </tr>

                    <tr>
                        <td width="20%">Tanggal Transaksi</td>
                        <td width="1%">:</td>
                        <td>{{ $order->order_date }}</td>
                    </tr>

                    <tr>
                        <td width="20%">Nama Pelanggan</td>
                        <td width="1%">:</td>
                        <td>{{ $order->customer->customer_name }}</td>
                    </tr>

                    <tr>
                        <td width="20%">Total Transaksi</td>
                        <td width="1%">:</td>
                        <td>Rp {{ $order->total }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="table-responsive">
                <h6 class="mb-4">Detail Transaksi</h6>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td width="5%">#</td>
                            <td>Judul</td>
                            <td>Penulis</td>
                            <td>Tahun</td>
                            <td>Harga</td>
                            <td>Jumlah</td>
                            <td>Subtotal</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($order->details as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->book->title }}</td>
                                <td>{{ $detail->book->author }}</td>
                                <td>{{ $detail->book->year }}</td>
                                <td>{{ $detail->unit_price }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>Rp {{ $detail->subtotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
