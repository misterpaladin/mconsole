<?php

namespace Milax\Mconsole\Http\Requests;

use App\Http\Requests\Request;

class UploadableRequest extends Request
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
            'uploadable.*.files.*' => 'image|presets_required|presets_extensions|presets_image_size',
        ];
    }
}
