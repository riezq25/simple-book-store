@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            <form class="mb-4" action="{{ route('supplier.index') }}" method="get">
                <h6>Filter</h6>
                <div class="row mb-4">
                    <div class="col-sm-12 col-md-8">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Masukkan nama, email atau no HP" value='{{ request()->search }}'>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="mb-3">
                            <select id="city" name="city" class="form-select">
                                <option selected value="all">Semua Kota</option>
                                @foreach ($cities as $city)
                                    <option @selected(request()->city == $city->city_code) value="{{ $city->city_code }}">
                                        {{ $city->city_name }}</option>
                                @endforeach
                            </select>
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

            <a href="{{ route('supplier.create') }}" role="button" class="btn btn-primary mb-4">
                <i class="fas fa-plus fa-fw me-2"></i>
                <span>Tambah Supplier</span>
            </a>

            @include('layouts.partials.alert-message')

            <div class="table-responsive mb-4">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama Supplier</th>
                            <th>Nama Kontak</th>
                            <th>Kota</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($suppliers as $i => $supplier)
                            <tr>
                                <td>{{ ($suppliers->currentPage() - 1) * $suppliers->perPage() + $i + 1 }}</td>
                                <td>{{ $supplier->supplier_name }}</td>
                                <td>{{ $supplier->contact_name }}</td>
                                <td>{{ $supplier->city->city_name }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>{{ $supplier->phone_number }}</td>
                                <td>
                                    <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                        <a href="{{ route('supplier.edit', $supplier->supplier_id) }}" type="button"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit fa-fw me-2"></i>
                                            <span>Ubah</span>
                                        </a>
                                        <button
                                            onclick="deleteData('{{ route('supplier.destroy', $supplier->supplier_id) }}')"
                                            type="button" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash fa-fw me-2"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{ $suppliers->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
