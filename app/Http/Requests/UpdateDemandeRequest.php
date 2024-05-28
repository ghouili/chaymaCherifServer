<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDemandeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'annee' => ['required', 'string'],
            'status' => ['required', 'string'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string'],
            'montant' => ['required', 'numeric'],
            'id_budget' => ['required', 'integer', 'exists:budget,id'],
            'id_user' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
