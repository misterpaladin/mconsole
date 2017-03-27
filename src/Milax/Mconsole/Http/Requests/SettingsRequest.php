<?php

namespace Milax\Mconsole\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milax\Mconsole\Models\MconsoleOption;

class SettingsRequest extends FormRequest
{
    protected $options;
    protected $rules = [];
    
    public function __construct()
    {
        $this->options = MconsoleOption::all();
        $this->options->each(function ($option) {
            if ($option->rules && count($option->rules) > 0) {
                $this->rules[$option->key] = implode('|', $option->rules);
            }
        });
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
        return $this->rules;
    }
}
