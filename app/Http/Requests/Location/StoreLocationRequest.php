<?php

namespace App\Http\Requests\$(echo ${FILE_PATH} | sed 's/\//\\/g');

use Illuminate\Foundation\Http\FormRequest;

class $(basename ${FILE_PATH}) extends FormRequest
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
        return ${RULES};
    }
}
