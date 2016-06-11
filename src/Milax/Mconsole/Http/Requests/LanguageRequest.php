<?php

namespace Milax\Mconsole\Http\Requests;

use App\Http\Requests\Request;
use Milax\Mconsole\Contracts\Repositories\LanguagesRepository;

class LanguageRequest extends Request
{
    /**
     * Create new instance
     */
    public function __construct(LanguagesRepository $repository)
    {
        $this->repository = $repository;
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
        switch ($this->method) {
            case 'PUT':
                $language = $this->repository->find($this->route('languages'));
                return [
                    'name' => 'required',
                    'key' => 'required|unique:languages,key,' . $language->id,
                ];
                break;
            
            case 'POST':
                return [
                    'name' => 'required',
                    'key' => 'required|unique:languages',
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
        $validator->setAttributeNames(trans('mconsole::languages.form'));
        
        return $validator;
    }
}
