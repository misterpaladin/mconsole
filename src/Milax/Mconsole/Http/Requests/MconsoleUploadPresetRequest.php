<?php

namespace Milax\Mconsole\Http\Requests;

use App\Http\Requests\Request;

class MconsoleUploadPresetRequest extends Request
{
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
            'name' => 'required',
            'path' => 'required|string',
            'extensions' => 'required',
            'min_width' => 'integer',
            'min_height' => 'integer',
            'operations' => 'json',
        ];
    }
    
    /**
     * Set custom validator attribute names
     *
     * @return Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        $validator->setAttributeNames(trans('mconsole::presets.form'));
        
        return $validator;
    }
}
