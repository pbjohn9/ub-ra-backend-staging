<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(request()->isMethod('post')){
            return !Gate::denies('user_create');
        }

        return !Gate::denies('user_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'name' => ['required'],
            'email' => ['required','unique:users'],
            'password' => ['required'],
            'roles.*' => ['integer'],
            'roles' => ['required','array'],
        ],$this->method()=="PATCH"?[
            'password' => ['nullable'],
            'email' => ['required','unique:users,email,'.request()->route('user')->id]
        ]:[]);
    }
}
