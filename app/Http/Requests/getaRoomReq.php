<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;



class getaRoomReq extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
					'datumPrihod' => 'required',
					'datumOdhod' => 'required',
					'soba' => 'required|string|max:50',
				  'ImePriimek' => 'required|string|max:50',
				  'email' => 'required|email',
				  'telNumber' => 'required|integer|min:2|digits_between:0,9',
				  'opomba' => 'nullable|string|max:550'
				];
    }



	


	 
}
