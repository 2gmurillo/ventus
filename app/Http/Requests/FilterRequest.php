<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'category' => ['nullable', 'exists:categories,id'],
            'order_by' => ['nullable', Rule::in(['new', 'old', 'asc', 'desc'])],
            'search' => ['nullable', 'max:80'],
        ];
    }
}
