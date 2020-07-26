<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;



class roomIdReq extends FormRequest
{
     public function rules()
    {
        return [
            'id' => 'required|integer', // << url parameter
        ];
    }

    public function all($all = null)
    {
        $data = parent::all();
        $data['id'] = $this->route('id');

        return $data;
    }

    public function authorize()
    {
        return true;
    }

	


	 
}
