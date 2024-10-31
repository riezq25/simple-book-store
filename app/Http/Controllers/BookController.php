<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    // Menampilkan daftar buku
    function index()
    {
        // menampilkan list buku dari database
        // select * from books
        // order by title asc
        // 1. ORM (Eloquent)
        // $books = Book::orderBy('title', 'asc')
        //     ->get();

        // 2. Query Builder
        // $books = DB::table('books')
        //     ->orderBy('title', 'asc')
        //     ->get();

        // 3. Raw Query
        // $books = DB::select('SELECT * FROM books ORDER BY title ASC');

        $title = 'Daftar Buku';

        // paginasi 10 data
        // select
        // 	*
        // from
        // 	books
        // where author like '%Irma%'
        // or title like '%Irma%'
        // or year like '%2010%'
        // limit 10 offset 0
        $books = Book::orderBy('title', 'asc')
            ->when(request()->search, function ($query) {
                $query->where(function ($query) {
                    $query->orWhere('title', 'like', '%' . request()->search . '%')
                        ->orWhere('author', 'like', '%' . request()->search . '%')
                        ->orWhere('year', 'like', '%' . request()->search . '%');
                });
            })
            ->paginate(10)
            ->withQueryString();

        $data = compact('books', 'title');
        return view('dashboard.book.index', $data);
    }


    // Menampilkan detail buku (opsional)
    // Menampilkan halaman tambah buku
    // Menyimpan buku baru
    // Menampikan halaman ubah buku
    // Menyimpan perubahan buku
    // Menghapus buku
}
