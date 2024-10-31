@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            @include('layouts.partials.alert-message')

            <form action="{{ route('supplier.update', $supplier->supplier_id) }}" method="post">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Nama Supplier</label>
                            <input required type="text" class="form-control" id="supplier_name" name="supplier_name"
                                placeholder="Masukkan nama supplier"
                                value="{{ old('supplier_name', $supplier->supplier_name) }}">

                            @error('supplier_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="contact_name" class="form-label">Nama Kontak</label>
                            <input required type="text" class="form-control" id="contact_name" name="contact_name"
                                placeholder="Masukkan nama kontak"
                                value="{{ old('contact_name', $supplier->contact_name) }}">

                            @error('contact_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input required type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan Email" value="{{ old('email', $supplier->email) }}">

                            @error('email')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">No HP</label>
                            <input required type="text" class="form-control" id="phone_number" name="phone_number"
                                placeholder="Contoh: 0812345678" value="{{ old('phone_number', $supplier->phone_number) }}">

                            @error('phone_number')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="city_code" class="form-label">Kota</label>
                            <select id="city_code" name="city_code" class="form-select">
                                <option selected value="all">Semua Kota</option>
                                @foreach ($cities as $city)
                                    <option @selected(old('city_code', $supplier->city_code) == $city->city_code) value="{{ $city->city_code }}">
                                        {{ $city->city_name }}</option>
                                @endforeach
                            </select>

                            @error('city_code')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>

                            @error('address')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save fa-fw me-2"></i>
                    <span>Simpan</span>
                </button>

            </form>

        </div>
    </div>
@endsection
