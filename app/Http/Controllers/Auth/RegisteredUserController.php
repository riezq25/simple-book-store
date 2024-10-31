<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $data = [];
        $data['cities'] = City::orderBy('city_name', 'asc')
            ->get([
                'city_code',
                'city_name'
            ]);
        return view('auth.register', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number'  => [
                'required',
                'min:10',
                'max:15'
            ],
            'birth_date'    => [
                'required',
                'date'
            ],
            'city_code' => [
                'required',
                'exists:cities,city_code'
            ],
            'address'   => [
                'nullabled',
                'min:3'
            ]
        ];

        $atributes = [
            'name' => 'Nama',
            'phone_number'  => 'No HP',
            'email' => 'Email',
            'birth_date'    => 'Tanggal Lahir',
            'city_code' => 'Kota',
            'address'   => 'Alamat',
        ];
        $request->validate(
            $rules,
            [],
            $atributes
        );

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('customer');

            event(new Registered($user));

            $customer = Customer::create([
                'customer_name' => $request->name,
                'phone_number'  => $request->phone_number,
                'email'         => $request->email,
                'address'       => $request->address,
                'birth_date'    => $request->birth_date,
                'city_code'     => $request->city_code,
                'user_id'       => $user->id
            ]);

            Auth::login($user);

            DB::commit();
            return redirect(route('dashboard', absolute: false));
        } catch (\Throwable $th) {
            DB::rollBack();
            redirect()
                ->back()
                ->withErrors(['message' => $th->getMessage()]);
        }
    }
}
