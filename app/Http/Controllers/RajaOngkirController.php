<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    /**
     * Cari lokasi tujuan (kecamatan/kota/provinsi sekaligus).
     * API Komerce: GET /destination/domestic-destination?search=
     */
    public function searchDestination(Request $request)
    {
        $keyword = $request->input('search');

        if (! $keyword || strlen($keyword) < 3) {
            return response()->json(['data' => []]);
        }

        $response = Http::withHeaders([
            'key' => config('services.rajaongkir.api_key'),
        ])->get(config('services.rajaongkir.base_url') . '/destination/domestic-destination', [
            'search' => $keyword,
            'limit'  => 20,
            'offset' => 0,
        ]);

        return response()->json($response->json());
    }

    /**
     * Hitung ongkos kirim dari toko (origin tetap, di .env) ke tujuan pembeli.
     * API Komerce: POST /calculate/domestic-cost
     */
    public function getCost(Request $request)
    {
        $request->validate([
            'destination' => 'required',
            'weight'      => 'required|numeric|min:1',
            'courier'     => 'required|string',
        ]);

        $response = Http::asForm()->withHeaders([
            'key' => config('services.rajaongkir.api_key'),
        ])->post(config('services.rajaongkir.base_url') . '/calculate/domestic-cost', [
            'origin'      => config('services.rajaongkir.origin'),
            'destination' => $request->input('destination'),
            'weight'      => $request->input('weight'),
            'courier'     => $request->input('courier'),
        ]);

        return response()->json($response->json());
    }
}
