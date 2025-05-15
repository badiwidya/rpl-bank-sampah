<?php

namespace Tests\Feature\Admin;

use App\Models\Sampah;
use App\Models\TransaksiPenukaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SetorSampahTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $nasabah;
    protected Sampah $sampah1;
    protected Sampah $sampah2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->nasabah = User::factory()->create(['no_telepon' => '081234567890']);
        $this->sampah1 = Sampah::factory()->create(['harga_per_kg' => 5000]);
        $this->sampah2 = Sampah::factory()->create(['harga_per_kg' => 3000]);
    }

    #[Test]
    public function admin_dapat_mengakses_endpoint_utama(): void
    {
        $response = $this->actingAs($this->admin)
            ->getJson('/admin/setor-sampah');

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'endpoints']);
    }

    #[Test]
    public function admin_dapat_mencari_nasabah(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson('/admin/setor-sampah/cari-nasabah', [
                'no_telepon' => '081234567890'
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => ['id' => $this->nasabah->id]
            ]);
    }

    #[Test]
    public function form_setor_menampilkan_data_nasabah_dan_sampah(): void
    {
        $response = $this->actingAs($this->admin)
            ->getJson("/admin/setor-sampah/{$this->nasabah->id}/form");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'nasabah' => ['id', 'nama'],
                'sampahs' => [['id', 'nama', 'harga_per_kg']]
            ]);
    }

    #[Test]
    public function admin_dapat_menambahkan_sampah_ke_transaksi(): void
    {
        $transaksi = TransaksiPenukaran::factory()->create(['user_id' => $this->nasabah->id]);

        $response = $this->actingAs($this->admin)
            ->postJson("/admin/setor-sampah/{$transaksi->id}/tambah-sampah", [
                'sampah_id' => $this->sampah1->id,
                'berat' => 2.5
            ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);
    }

    #[Test]
    public function simpan_transaksi_berhasil(): void
    {
        $transaksi = TransaksiPenukaran::factory()->create(['user_id' => $this->nasabah->id]);

        
        // Simulasikan data di session dengan harga_subtotal
        Session::put("transaksi_{$transaksi->id}", [
            $this->sampah1->id => [
                'berat' => 2,
                'harga_subtotal' => 10000 // Sesuai dengan nama kolom
            ],
            $this->sampah2->id => [
                'berat' => 3,
                'harga_subtotal' => 9000 // Sesuai dengan nama kolom
            ]
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson("/admin/setor-sampah/{$transaksi->id}/simpan");

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);
    }

    #[Test]
    public function konfirmasi_transaksi_berhasil(): void
    {
        $transaksi = TransaksiPenukaran::factory()->create([
            'user_id' => $this->nasabah->id,
            'total_berat' => 5,
            'total_harga' => 19000
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson("/admin/setor-sampah/{$transaksi->id}/konfirmasi");

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);
    }
    #[Test]
    public function tambah_sampah_gagal_jika_berat_tidak_valid()
    {
        $transaksi = TransaksiPenukaran::factory()->create([
            'user_id' => $this->nasabah->id
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson("/admin/setor-sampah/{$transaksi->id}/tambah-sampah", [
                'sampah_id' => $this->sampah1->id,
                'berat' => 0 // Berat tidak valid
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['berat']);
    }

    #[Test]
    public function simpan_transaksi_gagal_jika_tidak_ada_sampah()
    {
        $transaksi = TransaksiPenukaran::factory()->create([
            'user_id' => $this->nasabah->id
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson("/admin/setor-sampah/{$transaksi->id}/simpan");

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'error',
                'message' => 'Tidak ada sampah yang ditambahkan'
            ]);
    }
}

