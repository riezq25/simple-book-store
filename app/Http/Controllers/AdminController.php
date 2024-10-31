<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    function index()
    {
        $data = [];

        // judul halaman
        $data['title'] = 'Data Admin';

        // mengambil data kota
        $data['cities'] = City::orderBy('city_name', 'asc')
            ->get([
                'city_code',
                'city_name'
            ]);

        // mengambil data customer dengan kondisi pencarian dan filter kota
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })
            ->orderBy(request()->get('sort_column', 'name'), request()->get('sort_direction', 'asc'))
            ->when(request()->search, function ($q) {
                $q->where(function ($q) {
                    $q->orWhere('name', 'like', '%' . request()->search . '%')
                        ->orWhere('email', 'like', '%' . request()->search . '%');
                });
            })
            ->paginate(10)
            ->withQueryString();

        $data['users'] = $users;

        // sorted column
        $data['sortColumns'] = [
            'name' => 'Nama',
            'email' => 'Email',
        ];

        // menampilkan ke view
        return view('dashboard.pengguna.admin.index', $data);
    }

    function create()
    {
        $data = [];
        // judul halaman
        $data['title'] = 'Tambah Admin';

        // menampilkan ke view
        return view('dashboard.pengguna.admin.create', $data);
    }

    function store(Request $request)
    {
        // membuat rule validasi
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];

        // menvalidasi input
        $validated = $request->validate(
            $rules
        );

        // transaction
        DB::beginTransaction();

        // insert ke user
        $user = User::create([
            'name'  => $request['name'],
            'email' => $request['email'],
            'password'  => Hash::make($request['password'])
        ]);

        // tandai email sebagai teverifikasi
        $user->markEmailAsVerified();

        $user->assignRole('admin');

        DB::commit();
        return redirect(route('admin.index'))
            ->with([
                'success'  => 'Berhasil menambahkan ' . $user->name . ' (' . $user->email . ')'
            ]);
    }

    function edit($id)
    {
        // mengambil data berdasarkan id
        $user = User::findOrFail($id);

        $data = [];
        // judul halaman
        $data['title'] = 'Ubah Admin';

        $data['user'] = $user;

        // menampilkan ke view
        return view('dashboard.pengguna.admin.edit', $data);
    }

    function update(Request $request, $id)
    {
        // mengambil data berdasarkan id
        $user = User::findOrFail($id);

        // membuat rule validasi
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email,' . $user->id
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];

        // menvalidasi input
        $validated = $request->validate(
            $rules
        );

        // transaction
        DB::beginTransaction();

        // update user
        $updateData = [
            'name'  => $request['name'],
            'email' => $request['email']
        ];

        if ($validated['password']) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        DB::commit();
        return redirect(route('admin.index'))
            ->with([
                'success'  => 'Berhasil mengubah ' . $user->name . ' (' . $user->email . ')'
            ]);
    }

    function destroy($id)
    {
        // mengambil data berdasarkan id
        $user = User::findOrFail($id);

        DB::beginTransaction();

        // menghapus data
        $user->delete();

        DB::commit();
        return redirect(route('admin.index'))
            ->with([
                'success'  => 'Berhasil menghapus ' . $user->name . ' (' . $user->email . ')'
            ]);
    }
}
