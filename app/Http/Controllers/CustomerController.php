<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    function index()
    {
        $data = [];

        // judul halaman
        $data['title'] = 'Data Customer';

        // mengambil data kota
        $data['cities'] = City::orderBy('city_name', 'asc')
            ->get([
                'city_code',
                'city_name'
            ]);

        // mengambil data customer dengan kondisi pencarian dan filter kota
        $customers = Customer::orderBy(request()->get('sort_column', 'customer_name'), request()->get('sort_direction', 'asc'))
            ->when(request()->search, function ($q) {
                $q->where(function ($q) {
                    $q->orWhere('customer_name', 'like', '%' . request()->search . '%')
                        ->orWhere('email', 'like', '%' . request()->search . '%')
                        ->orWhere('phone_number', 'like', '%' . request()->search . '%');
                });
            })
            ->when(request()->city && request()->city != 'all', function ($q) {
                $q->where('city_code', request()->city);
            })
            ->with(['city'])
            ->paginate(10)
            ->withQueryString();

        $data['customers'] = $customers;

        // sorted column
        $data['sortColumns'] = [
            'customer_name' => 'Nama',
            'birth_date'    => 'Tanggal Lahir',
            'email' => 'Email',
            'phone_number'  => 'No HP',
        ];

        // menampilkan ke view
        return view('dashboard.pengguna.customer.index', $data);
    }
}
