<?php

namespace App\Http\Requests;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class updateCompanyRequest extends FormRequest
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
        $id = $this->request->get('id');
        
        return [
            'name' => 'required',
            'email'  =>  'required|unique:companies,email,'.$id,
        ];
    }
}
