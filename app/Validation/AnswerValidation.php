<?php
namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class AnswerValidation
{
    private $globalMessage=[];

    public function validationInsert($request)
    {
        $validator=Validator::make(
            [
                'dni' => $request->input('txtNumberDni'),
                'firstName' => $request->input('txtFirstName'),
                'surName' => $request->input('txtSurName'),
            ],
            [
                'dni' => ['regex:/^[0-9]{8}$/'],
                'firstName' => ['required'],
                'surName' => ['required'],
            ],
            [
                'dni.regex' => 'El campo "dni" no cumple con el formato correspondiente.',
                'firstName.required' => 'El campo "firstName" es requerido.',
                'surName.required' => 'El campo "surName" es requerido.',
            ]);

        if($validator->fails())
        {
            $errors=$validator->errors()->all();

            foreach ($errors as $value)
            {
                $this->globalMessage[]=$value;
            }
        }

        return $this->globalMessage;
    }
}
