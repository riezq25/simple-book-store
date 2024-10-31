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
        // order by title asc
        // limit 10 offset 0
        $books = Book::orderBy(request()->get('sort_column', 'title'), request()->get('sort_direction', 'asc'))
            ->when(request()->search, function ($query) {
                $query->where(function ($query) {
                    $query->orWhere('title', 'like', '%' . request()->search . '%')
                        ->orWhere('author', 'like', '%' . request()->search . '%')
                        ->orWhere('year', 'like', '%' . request()->search . '%');
                });
            })
            ->paginate(10)
            ->withQueryString();

        $sortColumns = [
            'title' => 'Judul',
            'author'    => 'Penulis',
            'year'  => 'Tahun Penulisan',
            'price' => 'Harga'
        ];

        $data = compact('books', 'title', 'sortColumns');
        return view('dashboard.book.index', $data);
    }

    // Menampilkan detail buku (opsional)
    function show($id) {}

    // Menampilkan halaman tambah buku
    function create()
    {
        $title = 'Tambah Buku';
        $data = compact('title');
        return view('dashboard.book.create', $data);
    }

    // Menyimpan buku baru
    function store(Request $request)
    {
        try {
            // validasi
            $rules = [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255'
                ],
                'author' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255'
                ],
                'year' => [
                    'required',
                    'min_digits:4',
                    'max_digits:4',
                ],
                'price' => [
                    'required',
                    'numeric',
                    'min:1000'
                ],
            ];

            $attributes = [
                'title' => 'Judul Buku',
                'author' => 'Penulis Buku',
                'year' => 'Tahun Penulisan Buku',
                'price' => 'Harga Buku',
            ];

            $validated = $request
                ->validate(
                    $rules,
                    [],
                    $attributes
                );

            // ambil data
            // $request == request()
            // dd($request->post());

            // simpan data
            // INSERT into books (title, author, year, price) values ('judul buku', 'Ari', '2020', 10000)
            // $book = Book::create([
            //     'title' => $request->title,
            //     'author' => $request->author,
            //     'year' => $request->year,
            //     'price' => $request->price,
            // ]);

            // $book = new Book;
            // $book->title = $request->title;
            // $book->author = $request->author;
            // $book->year = $request->year;
            // $book->price = $request->price;
            // $book->save();

            DB::beginTransaction();
            $book = Book::create($validated);

            DB::commit();
            return redirect(route('book.index'))
                ->with([
                    'success'   => 'Berhasil menambahkan buku baru dengan judul ' . $book->title
                ]);
            // redirect
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors([
                    ['error'   => $th->getMessage()]
                ]);
        }
    }

    // Menampikan halaman ubah buku
    function edit($id) {}

    // Menyimpan perubahan buku
    function update(Request $request, $id) {}

    // Menghapus buku
    function destroy($id)
    {
        try {
            // mencari data
            // SELECT * from books b
            // where b.id = '1' limit 1

            // $book = Book::where('id', $id)
            //     ->firstOrFail();

            DB::beginTransaction();
            $book = Book::findOrFail($id);
            // menghapus
            // delete from books where id = '1'
            $book->delete();

            DB::commit();
            return redirect(route('book.index'))
                ->with([
                    'success'   => 'Berhasil menghapus buku dengan judul ' . $book->title
                ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors([
                    ['error'   => $th->getMessage()]
                ]);
        }
    }
}
