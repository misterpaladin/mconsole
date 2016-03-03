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
            'width' => 'integer',
            'height' => 'integer',
            'quality' => 'integer',
            'extensions' => 'json',
            'min_width' => 'integer',
            'min_height' => 'integer',
        ];
    }
}
