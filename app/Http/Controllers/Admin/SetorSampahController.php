<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sampah;
use App\Models\TransaksiPenukaran;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class SetorSampahController extends Controller
{
    // (1) Endpoint utama
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'API Setor Sampah Admin',
            'endpoints' => [
                'cari_nasabah' => route('admin.setor-sampah.cari-nasabah'),
                'form_setor' => url('/admin/setor-sampah/{user}/form'),
            ]
        ]);
    }

    // (2) Cari nasabah by nomor telepon
    public function cariNasabah(Request $request): JsonResponse
    {
        try {
            $request->validate(['no_telepon' => 'required|exists:users,no_telepon']);

            $nasabah = User::where('no_telepon', $request->no_telepon)
                ->firstOrFail();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $nasabah->id,
                    'nama' => $nasabah->name,
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nasabah tidak ditemukan'
            ], 404);
        }
    }

    // (3) Ambil data form setor
    public function formSetor(User $user): JsonResponse
    {
        $sampahs = Sampah::all(['id', 'nama', 'harga_per_kg']);

        return response()->json([
            'status' => 'success',
            'nasabah' => [
                'id' => $user->id,
                'nama' => $user->name,
            ],
            'sampahs' => $sampahs
        ]);
    }

    // (4) Tambah sampah ke transaksi (simpan di Session)
    public function tambahSampah(Request $request, TransaksiPenukaran $transaksi): JsonResponse
    {
        try {
            $request->validate([
                'sampah_id' => 'required|exists:sampah,id',
                'berat' => 'required|numeric|min:0.01',
            ]);

            $sampah = Sampah::findOrFail($request->sampah_id);
            $harga_subtotal = $sampah->harga_per_kg * $request->berat;

            $dataSampah = [
                'id' => $sampah->id,
                'nama' => $sampah->nama,
                'berat' => $request->berat,
                'harga_per_kg' => $sampah->harga_per_kg,
                'harga_subtotal' => $harga_subtotal, // Diubah ke harga_subtotal
            ];

            $sessionKey = 'transaksi_' . $transaksi->id;
            $currentData = Session::get($sessionKey, []);
            $currentData[$sampah->id] = $dataSampah;
            Session::put($sessionKey, $currentData);

            return response()->json([
                'status' => 'success',
                'data' => $dataSampah
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        }
    }
     // (5) Simpan transaksi ke database
    public function simpanSetoran(TransaksiPenukaran $transaksi): JsonResponse
    {
        $sessionKey = 'transaksi_' . $transaksi->id;
        $items = Session::get($sessionKey, []);

        if (empty($items)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada sampah yang ditambahkan'
            ], 400);
        }

        DB::transaction(function () use ($transaksi, $items, $sessionKey) {
            $totalBerat = collect($items)->sum('berat');
            $totalHarga = collect($items)->sum('harga_subtotal'); // Diubah ke harga_subtotal

            $transaksi->update([
                'total_berat' => $totalBerat,
                'total_harga' => $totalHarga,
            ]);

            foreach ($items as $sampahId => $item) {
                $transaksi->sampah()->attach($sampahId, [
                    'berat' => $item['berat'],
                    'harga_subtotal' => $item['harga_subtotal']
                ]);
            }

            Session::forget($sessionKey);
        });

        return response()->json([
            'status' => 'success',
            'transaksi_id' => $transaksi->id,
            'total_berat' => $transaksi->total_berat,
            'total_harga' => $transaksi->total_harga,
        ]);
    }

    // (6) Konfirmasi transaksi
    public function konfirmasiSetoran(TransaksiPenukaran $transaksi): JsonResponse
    {
        $transaksi->update([
            'status' => 'selesai',
            'tanggal_penukaran' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil dikonfirmasi',
        ]);
    }
}