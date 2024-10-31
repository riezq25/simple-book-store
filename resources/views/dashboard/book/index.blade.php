@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            <form class="mb-4" action="{{ route('book.index') }}">
                <h6>Filter</h6>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Masukkan kata kunci pencarian..." value="{{ request()->search }}">
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
                <a href="{{ route('book.create') }}" role="button" class="btn btn-primary mb-4">
                    <i class="fas fa-plus fa-fw me-2"></i>
                    <span>Tambah Buku</span>
                </a>

                @include('layouts.partials.alert-message')

                <table class="table table-hover mb-4">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Penulis</th>
                            <th scope="col" width="20%">Tahun</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Action</th>
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
                                <td>
                                    <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit fa-fw me-2"></i>
                                            <span>Edit</span>
                                        </button>

                                        <button onclick="deleteData('{{ route('book.destroy', $book->id) }}')"
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

                {{-- paginasi --}}
                {{ $books->links('pagination::bootstrap-5') }}

            </div>
        </div>
    </div>
@endsection
