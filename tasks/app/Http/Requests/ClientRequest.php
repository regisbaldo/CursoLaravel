<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Dash;

class ClientRequest extends FormRequest
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

      $this->sanitize();

        return [
          'name' => ['required', 'max:100', 'min:3', new Dash],
          'email' => ['required', 'email', 'unique:clients'],
          'age' => ['required', 'integer'],
          'photo' => ['required', 'mimes:jpeg,bmp,png']
        ];
    }

    //regra para acrescentar ao validator algumas validações
    //depois das rules

    // public function withValidator($validador){
    //   $validador->after(function($validador){
    //     if(strpos($this->name, '-')){
    //       $validador->errors()->add('name', 'O campo nome
    //       não pode ter -');
    //     }
    //   });
    // }

    public function messages(){
      return [
        'name.required' => "O campo nome do
        cliente deve ser preenchido"
      ];


    }
//trocando espaços por algo, que no caso é nada
    public function sanitize(){
      $data = $this->all();

      $data['name'] =str_replace('-', '', $data['name']);
      $this->replace($data);
    }
}
