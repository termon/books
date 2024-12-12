<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Book::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'unique:books,title'],
            'year' => ['required', 'numeric'],
            'category_id' => ['required'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'description' => ['min:0', 'max:800'],
            'image' => ['nullable', File::types(['png', 'jpg', 'jpeg', 'webp'])->max(1024)],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id' => 'The category field is required'
        ];
    }

    /**
     * Run after validation.
     *
     * @return void
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->hasFile('image')) {
                    //$base64 = base64_encode(file_get_contents($this->image));
                    //$validator->setValue('image', "data:{$this->image->getMimeType()};base64,{$base64}");
                    $path = $this->image->store('books', 'public');
                    $validator->setValue('image', $path);
                }
            }
        ];
    }
}
