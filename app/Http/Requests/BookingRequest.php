<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'first_name'      => 'required|max:255',
            'last_name'       => 'required|max:255',
            'email'           => 'required|max:255|email|unique:users',
            'password'        => 'required|min:8',
            'phone'           => 'required',
            'address'         => 'required',
            'city'            => 'required',
            'zip'             => 'required',
            'payment_country' => 'required',
            'birthday_day'    => 'required',
            'birthday_month'  => 'required',
            'birthday_year'   => 'required',
            'gdpr'   => 'required',
        ];
    }


      /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name'     => trans('messages.login.first_name'),
            'last_name'      => trans('messages.login.last_name'),
            'email'          => trans('messages.login.email_address'),
            'password'       => trans('messages.login.password'),
            'birthday_month' => trans('messages.login.birthday') . ' ' . trans('messages.header.month'),
            'birthday_day'   => trans('messages.login.birthday') . ' ' . trans('messages.header.day'),
            'birthday_year'  => trans('messages.login.birthday') . ' ' . trans('messages.header.year'),
            'first_name'     => trans('messages.login.first_name'),

        ];
    }


}
