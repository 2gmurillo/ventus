<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveProductRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:80'],
            'photo' => ['nullable', 'image'],
            'price' => ['required', 'numeric', 'min:10', 'max:500'],
            'category_id' => ['required', Rule::in(Category::pluck('id'))],
            'stock' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', Rule::in(Product::STATUSES)],
        ];
    }
}
