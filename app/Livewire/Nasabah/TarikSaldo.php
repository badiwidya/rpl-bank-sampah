<?php

namespace App\Livewire\Nasabah;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule as ValidationRule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TarikSaldo extends Component
{
    public $user;

    public $paymentMethod;

    #[Validate]
    public $ewalletNumber;

    #[Validate]
    public $withdrawAmount;

    protected function rules()
    {
        return [
            'paymentMethod' => ['required', ValidationRule::in(['Gopay', 'Dana', 'OVO', 'LinkAja'])],
            'withdrawAmount' => ['required', 'gte:10000'],
            'ewalletNumber' => ['required', 'numeric', 'digits_between:10,13']
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->paymentMethod = $this->user->profile->metode_pembayaran_utama;
        $this->ewalletNumber = $this->user->no_telepon;
    }

    public function render()
    {
        return view('livewire.nasabah.tarik-saldo');
    }
}
