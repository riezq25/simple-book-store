@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            {{-- form --}}
            <form action="{{ route('book.store') }}" method="post">
                @csrf

                <div class="row">
                    {{-- title --}}
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Buku</label>
                            <input required type="text" class="form-control" id="title" name="title"
                                placeholder="Judul buku...">
                        </div>
                    </div>

                    {{-- author --}}
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="author" class="form-label">Nama Penulis</label>
                            <input required type="text" class="form-control" id="author" name="author"
                                placeholder="Nama penulis buku...">
                        </div>
                    </div>

                    {{-- year --}}
                    <div class="col-sm-12 col-md-6">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="year" class="form-label">Tahun Penulisan</label>
                                <input required minlength="4" maxlength="4" type="number" class="form-control"
                                    id="year" name="year" placeholder="Tahun Penulisan buku...">
                            </div>
                        </div>
                    </div>

                    {{-- price --}}
                    <div class="col-sm-12 col-md-6">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input required min="1000" type="number" class="form-control" id="price"
                                    name="price" placeholder="Harga buku...">
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