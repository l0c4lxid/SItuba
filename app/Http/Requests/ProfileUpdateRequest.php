<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $detailId = optional($this->user()->detail)->id;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'max:25',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'organization' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'nik' => ['nullable', 'string', 'max:30'],
        ];

        if ($this->user()?->role === UserRole::Pasien) {
            $rules['nik'] = ['required', 'string', 'max:30', Rule::unique('user_details', 'nik')->ignore($detailId)];
        }

        return $rules;
    }
}
