<?php

namespace Milax\Mconsole\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Milax\Mconsole\Models\Tag;

class TagRequest extends FormRequest
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
        $tag = Tag::find($this->tag);
        
        switch ($this->method()) {
            case 'PUT':
            case 'UPDATE':
                return [
                    'name' => 'required|unique:tags,name,' . $tag->id,
                    'color' => 'required',
                ];
                break;
            
            default:
                return [
                    'name' => 'required|unique:tags',
                    'color' => 'required',
                ];
        }
    }
    
    /**
     * Set custom validator attribute names
     *
     * @return Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        $validator->setAttributeNames(trans('mconsole::tags.form'));
        
        return $validator;
    }
}
