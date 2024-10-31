@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            <form action="">
                <h6>Filter</h6>
                <div class="mb-3">
                    <input type="text" class="form-control" id="search" name="search"
                        placeholder="Masukkan kata kunci pencarian..." value="{{ request()->search }}">
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover mb-4">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Penulis</th>
                            <th scope="col" width="20%">Tahun</th>
                            <th scope="col">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $index => $book)
                            <tr>
                                <th scope="row">{{ ($books->currentPage() - 1) * $books->perPage() + $index + 1 }}</th>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->year }}</td>
                                <td>Rp {{ $book->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- paginasi --}}
                {{ $books->links('pagination::bootstrap-5') }}

            </div>
        </div>
    </div>
@endsection
