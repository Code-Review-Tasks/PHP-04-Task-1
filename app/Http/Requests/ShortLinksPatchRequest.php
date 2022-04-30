<?php

namespace App\Http\Requests;

use App\Traits\Validation\ValidationErrorsToJson;
use Illuminate\Foundation\Http\FormRequest;

class ShortLinksPatchRequest extends FormRequest
{
    use ValidationErrorsToJson;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'long_url' => 'required|url',
            'title' => 'max:255',
            'tags' => 'array',
            'tags.*' => 'max:255',
        ];
    }
}
