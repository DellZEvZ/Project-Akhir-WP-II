<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerApiController extends Controller
{
    private function payload(Customer $customer, string $token): array
    {
        return [
            'token'    => $token,
            'customer' => [
                'id'    => $customer->id,
                'nama'  => $customer->nama,
                'email' => $customer->email,
                'no_hp' => $customer->no_hp,
            ],
        ];
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required|min:6',
        ]);

        $customer = Customer::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $customer->createToken('mobile')->plainTextToken;

        return response()->json([
            'success' => true,
            'data'    => $this->payload($customer, $token),
            'message' => 'Registrasi berhasil',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !$customer->password || !Hash::check($request->password, $customer->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $token = $customer->createToken('mobile')->plainTextToken;

        return response()->json([
            'success' => true,
            'data'    => $this->payload($customer, $token),
            'message' => 'Login berhasil',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'Logout berhasil']);
    }

    public function me(Request $request)
    {
        $c = $request->user();
        return response()->json([
            'success' => true,
            'data'    => [
                'id'     => $c->id,
                'nama'   => $c->nama,
                'email'  => $c->email,
                'no_hp'  => $c->no_hp,
                'alamat' => $c->alamat,
            ],
        ]);
    }
}
