<?php

namespace Database\Factories;

use App\Models\Sampah;
use App\Models\TransaksiPenukaran;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiPenukaranFactory extends Factory
{
    protected $model = TransaksiPenukaran::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'total_berat' => 0,
            'total_harga' => 0,
        ];
    }

    public function denganSampah()
    {
        return $this->afterCreating(function (TransaksiPenukaran $transaksi) {
            $sampah1 = Sampah::factory()->create(['harga_per_kg' => 5000]);
            $sampah2 = Sampah::factory()->create(['harga_per_kg' => 3000]);
        
            // Sesuaikan dengan nama kolom pivot yang benar (harga_subtotal)
            $transaksi->sampah()->attach([
                $sampah1->id => [
                    'berat' => 2, 
                    'harga_subtotal' => 10000 // Ganti menjadi harga_subtotal
                ],
                $sampah2->id => [
                    'berat' => 3, 
                    'harga_subtotal' => 9000 // Ganti menjadi harga_subtotal
                ]
            ]);
        
            $transaksi->update([
                'total_berat' => 5,
                'total_harga' => 19000,
                'status' => 'selesai'
            ]);
        });
    }
}