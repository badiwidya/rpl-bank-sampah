<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $user = Auth::user();

        return [
            'nama_depan' => 'required|string|min:3|max:255',
            'nama_belakang' => 'required|string|min:3|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'no_telepon' => ['required', 'regex:/^08[0-9]{8,11}$/', Rule::unique('users', 'no_telepon')->ignore($user->id)],
            'metode_pembayaran_utama' => 'sometimes|nullable|string',
            'alamat' => 'sometimes|nullable|string',
            'avatar' => 'sometimes|nullable|mimes:jpg,jpeg,png|max:4096',
            'delete_avatar' => 'sometimes|nullable|boolean',
        ];
    }

    public function attributes()
    {
        // TODO TO ALL VALIDATION
        return [
            'nama_depan' => 'Nama depan',
            'nama_belakang' => 'Nama belakang',
            'email' => 'Email',
            'no_telepon' => 'Nomor telepon',
            'avatar' => 'Foto profil',
        ];
    }
}
