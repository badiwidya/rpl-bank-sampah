<?php

namespace App\Livewire\Nasabah;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule as ValidationRule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class TarikSaldo extends Component
{
    public $user;

    public $paymentMethod;

    #[Validate]
    public $ewalletNumber;

    #[Validate]
    public $withdrawAmount;
    public $availableBalance;

    protected function rules()
    {
        return [
            'paymentMethod' => [
                'required',
                ValidationRule::in(['Gopay', 'Dana', 'OVO', 'LinkAja'])
            ],
            'withdrawAmount' => [
                'required',
                'numeric',
                'lte:' . $this->availableBalance,
                'gte:10000'
            ],
            'ewalletNumber' => [
                'required',
                'numeric',
                'digits_between:10,13'
            ]
        ];
    }

    protected function messages()
    {
        return [
            'withdrawAmount.lte' => 'Anda sudah memiliki permintaan yang pending, saldo Anda tidak mencukupi'
        ];
    }

    protected function validationAttributes()
    {
        return [
            'paymentMethod' => 'Metode pembayaran',
            'withdrawAmount' => 'Nominal',
            'ewalletNumber' => 'Nomor e-wallet'
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->paymentMethod = $this->user->profile
            ->metode_pembayaran_utama;

        $this->ewalletNumber = $this->user->no_telepon;

        $alreadyRequested = $this->user
            ->transaksiPenarikan()
            ->where('status', 'pending')
            ->sum('jumlah');

        $this->availableBalance = $this->user->profile
            ->saldo - $alreadyRequested;
    }

    public function action()
    {
        try {
            $this->validate();

            $alreadyRequested = $this->user
                ->transaksiPenarikan()
                ->where('status', 'pending')
                ->sum('jumlah');

            $this->availableBalance = $this->user->profile
                ->saldo - $alreadyRequested;

            if ($this->availableBalance < $this->withdrawAmount) {
                throw new \Exception('Saldo Anda tidak mencukupi!');
            }

            $this->user->transaksiPenarikan()->create([
                'jumlah' => $this->withdrawAmount,
                'metode_pembayaran' => $this->paymentMethod,
                'no_telepon' => $this->ewalletNumber,
            ]);

            $this->withdrawAmount = null;

            $this->paymentMethod = $this->user->profile->metode_pembayaran_utama;
            $this->ewalletNumber = $this->user->no_telepon;
            $alreadyRequested = $this->user
                ->transaksiPenarikan()
                ->where('status', 'pending')
                ->sum('jumlah');

            $this->availableBalance = $this->user->profile
                ->saldo - $alreadyRequested;

            $this->dispatch('tarik-success');
            Toaster::success('Berhasil membuat pengajuan penarikan saldo!');
        } catch (\Throwable $e) {
            Toaster::error($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.nasabah.tarik-saldo');
    }
}
