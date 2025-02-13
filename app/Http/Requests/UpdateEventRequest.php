<?php

namespace App\Http\Requests;

use App\Traits\JsonErrors;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    use JsonErrors;
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
            'name'         => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'start_date'   => ['nullable', 'date_format:Y-m-d H:i:s'],
            'end_date'     => ['nullable', 'date_format:Y-m-d H:i:s', 'after:start_date'],
            'ticket_count' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
