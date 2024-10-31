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


        // paginasi 10 data
        $books = Book::orderBy('title', 'asc')
            ->paginate(10);

        $data = compact('books');
        return view('dashboard.book.index', $data);
    }


    // Menampilkan detail buku (opsional)
    // Menampilkan halaman tambah buku
    // Menyimpan buku baru
    // Menampikan halaman ubah buku
    // Menyimpan perubahan buku
    // Menghapus buku
}
