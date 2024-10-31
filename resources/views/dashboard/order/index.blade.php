@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            <form class="mb-4" action="{{ route('order.index') }}">
                <h6>Filter</h6>
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Masukkan kata kunci pencarian..." value="{{ request()->search }}">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="mb-3">
                            <input type="date" class="form-control" id="order_date" name="order_date"
                                value="{{ request()->order_date }}">
                        </div>
                    </div>
                </div>

                <h6>Sort</h6>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="mb-3">
                            <select id="sort_column" name="sort_column" class="form-select">
                                @foreach ($sortColumns as $i => $column)
                                    <option @selected(request()->sort_column == $i) value="{{ $i }}">{{ $column }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="mb-3">
                            <select id="sort_direction" name="sort_direction" class="form-select">
                                <option @selected(request()->sort_direction == 'asc') value="asc">Ascending</option>
                                <option @selected(request()->sort_direction == 'desc') value="desc">Descending</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <button class="btn btn-primary me-2">
                            <i class="fas fa-search fa-fw me-2"></i>
                            <span>Tampilkan</span>
                        </button>
                    </div>
                </div>

            </form>

            <div class="table-responsive">
                <a href="{{ route('order.create') }}" role="button" class="btn btn-primary mb-4">
                    <i class="fas fa-plus fa-fw me-2"></i>
                    <span>Tambah Buku</span>
                </a>

                @include('layouts.partials.alert-message')

                <table class="table table-hover mb-4">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $index => $order)
                            <tr>
                                <th scope="row">{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</th>
                                <td>{{ $order->invoice_number }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->customer->customer_name }}</td>
                                <td>Rp {{ $order->total }}</td>
                                <td>
                                    <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                        <a role="button" href="{{ route('order.show', $order->id) }}" type="button"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-eye fa-fw me-2"></i>
                                            <span>Detail</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- paginasi --}}
                {{ $orders->links('pagination::bootstrap-5') }}

            </div>
        </div>
    </div>
@endsection
