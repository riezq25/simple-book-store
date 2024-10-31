@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>
            @include('layouts.partials.alert-message')
            {{-- form --}}
            <form action="{{ route('book.update', $book->id) }}" method="post">
                @csrf
                @method('put')

                <div class="row">
                    {{-- title --}}
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Buku</label>
                            <input required type="text" class="form-control" id="title" name="title"
                                placeholder="Judul buku..." value="{{ old('title', $book->title) }}">
                            @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- author --}}
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="author" class="form-label">Nama Penulis</label>
                            <input required type="text" class="form-control" id="author" name="author"
                                placeholder="Nama penulis buku..." value="{{ old('author', $book->author) }}">
                            @error('author')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- year --}}
                    <div class="col-sm-12 col-md-6">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="year" class="form-label">Tahun Penulisan</label>
                                <input required minlength="4" maxlength="4" type="number" class="form-control"
                                    id="year" name="year" placeholder="Tahun Penulisan buku..."
                                    value="{{ old('year', $book->year) }}">
                                @error('year')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- price --}}
                    <div class="col-sm-12 col-md-6">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input required min="1000" type="number" class="form-control" id="price"
                                    name="price" placeholder="Harga buku..." value="{{ old('price', $book->price) }}">
                                @error('price')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
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
