<?php

namespace App\Http\Requests;

use App\Rules\WorkingUrl;
use Illuminate\Foundation\Http\FormRequest;

class CreateLinksRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {        
        if (!$this->has(0)) {
            $this->replace([$this->all()]);
        }
    }

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
            '*.long_url' => ['required', 'url', 'max:2048', new WorkingUrl],
            '*.title' => 'max:255',
            '*.tags.*' => 'max:255|regex:@[a-z0-9_]+@i'
        ];
    }
}
