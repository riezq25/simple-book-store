@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">{{ $title }}</h5>

                    @include('layouts.partials.alert-message')

                    <form action="{{ route('admin.update', $user->id) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input required type="text" class="form-control" id="name" name="name"
                                        placeholder="Masukkan nama lengkap" value="{{ old('name', $user->name) }}">

                                    @error('name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input required type="email" class="form-control" id="email" name="email"
                                        placeholder="Masukkan email" value="{{ old('email', $user->email) }}">

                                    @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>

                                @error('password')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control"
                                        name="password_confirmation" aria-describedby="password_confirmation" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save fa-fw me-2"></i>
                            <span>Simpan</span>
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
