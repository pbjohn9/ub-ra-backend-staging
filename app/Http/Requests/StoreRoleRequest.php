<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(request()->isMethod('post')){
            return !Gate::denies('role_create');
        }

        return !Gate::denies('role_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            'permissions.*' => ['integer'],
            'permissions' => ['required','array'],
        ];
    }
}
