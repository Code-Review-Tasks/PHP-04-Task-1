<?php

namespace App\Http\Requests;

use App\Rules\WorkingUrl;
use Illuminate\Foundation\Http\FormRequest;

class PatchLinkRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

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
            'long_url' => ['required', 'url', 'max:2048', new WorkingUrl],
            'title' => 'max:255',
            'tags.*' => 'max:255|distinct|regex:@[a-z0-9_]+@i'
        ];
    }
}
