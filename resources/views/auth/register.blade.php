@extends('layouts.auth')

@section('content')
    <h4 class="mb-1">Adventure starts here 🚀</h4>
    <p class="mb-6">Make your app management easy and fun!</p>

    @include('layouts.partials.error-message')

    <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-6">
            <label for="name" class="form-label">Nama</label>
            <input required type="text" class="form-control" id="name" name="name" placeholder="Enter your name" autofocus
                value="{{ old('name') }}" />

            @error('name')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-6">
            <label for="birth_date" class="form-label">Tanggal Lahir</label>
            <input required type="date" class="form-control" id="birth_date" name="birth_date"
                placeholder="Masukkan tanggal lahir" value="{{ old('birth_date') }}">

            @error('birth_date')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-6">
            <label for="email" class="form-label">Email</label>
            <input required type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                autofocus value="{{ old('email') }}" />

            @error('email')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="phone_number" class="form-label">Phone</label>
            <input required type="text" class="form-control" id="phone_number" name="phone_number"
                placeholder="Example: 08512345678" autofocus value="{{ old('phone_number') }}" />

            @error('phone_number')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-6">
            <label for="city_code" class="form-label">Kota</label>
            <select required id="city_code" name="city_code" class="form-select">
                <option selected disabled">Pilih Kota</option>
                @foreach ($cities as $city)
                    <option @selected(old('city_code') == $city->city_code) value="{{ $city->city_code }}">
                        {{ $city->city_name }}</option>
                @endforeach
            </select>

            @error('city_code')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-sm-12">
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control" id="address" rows="3">{{ old('address') }}</textarea>

                @error('address')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
                <input required type="password" id="password" class="form-control" name="password" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
            <div class="input-group input-group-merge">
                <input required type="password" id="password_confirmation" class="form-control"
                    name="password_confirmation" aria-describedby="password_confirmation" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>

        <button class="btn btn-primary d-grid w-100">Sign up</button>
    </form>

    <p class="text-center">
        <span>Already have an account?</span>
        <a href="{{ route('login') }}">
            <span>Sign in instead</span>
        </a>
    </p>
@endsection
