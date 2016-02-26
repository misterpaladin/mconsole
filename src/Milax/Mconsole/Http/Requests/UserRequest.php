<?php

namespace Milax\Mconsole\Http\Requests;

use App\Http\Requests\Request;
use App\User;

class UserRequest extends Request
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
        $user = User::find($this->users);
        
        switch ($this->method) {
            case 'PUT':
            case 'UPDATE':
                return [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                ];
                break;
            
            default:
                return [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6',
                ];
        }
    }
}
