<?php

namespace App\Livewire\Admin;

use App\Mail\SetoranBaru;
use App\Models\Sampah;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class CreateSetoran extends Component
{
    public $searchUser = '';
    public $selectedUser;
    public $isUserSelected = false;

    public $searchsampah = '';

    public $selectedSampah = [];

    public function selectSampah($id, $nama, $gambar, $harga)
    {
        if (!array_key_exists($id, $this->selectedSampah)) {
            $this->selectedSampah[$id] = [
                'nama' => $nama,
                'gambar' => $gambar,
                'harga_per_kg' => $harga,
                'berat' => ''
            ];
        }
    }

    public function removeSampah($id)
    {
        unset($this->selectedSampah[$id]);
    }

    public function store()
    {
        try {

            $this->validate([
                'selectedSampah.*.berat' => 'required|numeric|min:0.01|max:2000'
            ], [], [
                'selectedSampah.*.berat' => 'Berat sampah'
            ]);


            if (!$this->selectedUser) {
                throw new \Exception('Tolong pilih nasabah terlebih dahulu.');
            }

            if (!$this->selectedSampah) {
                throw new \Exception('Sampah tidak boleh kosong.');
            }

            $transaksi = DB::transaction(function () {
                $transaksi = $this->selectedUser->transaksiPenukaran()->create();

                $hargaTotal = 0;
                $beratTotal = 0;

                foreach ($this->selectedSampah as $id => $data) {
                    $hargaSub = $data['berat'] * $data['harga_per_kg'];
                    $hargaTotal += $hargaSub;
                    $beratTotal += $data['berat'];
                    $transaksi->sampah()->attach($id, [
                        'berat' => $data['berat'],
                        'harga_subtotal' => $hargaSub
                    ]);
                }

                $transaksi->update([
                    'total_harga' => $hargaTotal,
                    'total_berat' => $beratTotal
                ]);

                $this->selectedUser->profile()->increment('saldo', $hargaTotal);

                return $transaksi;
            });

            Mail::to($this->selectedUser)->send(new SetoranBaru($this->selectedUser, $transaksi));

            return Redirect::route('admin.dashboard.setoran')->success('Setoran baru berhasil dibuat!');
        } catch (\Throwable $e) {
            if ($e instanceof ValidationException) {
                Toaster::error('Harap lengkapi berat sampah.');
            } else if ($e instanceof \Exception) {
                Toaster::error($e->getMessage());
            } else {
                Toaster::error('Terjadi kesalahan saat membuat setoran baru.');
            }
        }
    }

    public function selectUser($phone)
    {
        $this->searchUser = $phone;

        $this->selectedUser = User::where('no_telepon', $this->searchUser)->first();
        $this->isUserSelected = true;
    }

    public function updatedSearchUser()
    {
        if ($this->searchUser === '') {
            $this->isUserSelected = false;
        }
    }

    public function filteredUsers()
    {
        if (strlen($this->searchUser) < 2) {
            return collect();
        }

        $keywords = explode(' ', $this->searchUser);

        return User::where('role', 'nasabah')
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('no_telepon', 'like', '%' . $keyword . '%')
                            ->orWhere('nama_depan', 'like', '%' . $keyword . '%')
                            ->orWhere('nama_belakang', 'like', '%' . $keyword . '%');
                    });
                }
            })
            ->orderBy('nama_depan')
            ->limit(10)
            ->get();
    }

    #[Layout('components.layouts.dashboard')]
    #[Title('Buat Setoran Baru - Bank Sampah')]
    public function render()
    {
        $query = Sampah::query();

        if ($this->searchsampah) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->searchsampah . '%')
                    ->orWhere('harga_per_kg', 'like', '%' . $this->searchsampah . '%');
            });
        }

        $allSampah = $query->get();

        return view('livewire.admin.create-setoran', compact('allSampah'));
    }
}
