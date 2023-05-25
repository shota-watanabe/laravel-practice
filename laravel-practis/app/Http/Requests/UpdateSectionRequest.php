<?php

namespace App\Http\Requests;

use App\Rules\UniqueSectionName;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        /** @var Section $section */
        $section = $this->route('section');

        return [
            'name' => ['required', 'string', 'max:255', new UniqueSectionName($section, null)]
        ];
    }
}
