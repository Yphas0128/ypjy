<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserRequest
 * @package App\Http\Requests
 * 用户 认证
 */
class UserRequest extends FormRequest
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
            'name' => 'required|regex:/^[a-zA-Z0-9]{4,14}$/',
            'password'  => 'required|regex:/^[a-zA-Z0-9]{4,14}$/'
        ];
    }

    public function messages()
    {
         return [
             'name.required' => '请输入用户名！',
             'name.regex' => '用户名必须4到14位的数字或字母！',
             'password.required' => '请输入密码！',
             'password.regex' => '密码必须4到14位的数字或字母！',
         ];
    }
}
