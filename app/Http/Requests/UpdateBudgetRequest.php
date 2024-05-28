<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBudgetRequest extends FormRequest
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
            'annee' => ['required', 'numeric'],
            'montant_prevue' => ['required', 'numeric'],
            'montant_depose' => ['required', 'numeric'],
            'id_rubric' => ['required', 'integer', 'exists:rubric,id'],
        ];
    }
}
