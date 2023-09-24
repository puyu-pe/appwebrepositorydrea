<?php
namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class GradeValidation
{
    private $globalMessage=[];

    public function validationInsert($request)
    {
        $validator=Validator::make(
        [
            'nameGrade' => $request->input('selectNameGrade'),
            'numberGrade' => $request->input('txtNumberGrade')
        ],
        [
            'nameGrade' => ['required'],
            'numberGrade' => ['required','regex:/^[1-6]{1}$/']
        ],
        [
            'nameGrade.required' => 'El campo "nameGrade" es requerido.',
            'numberGrade.required' => 'El campo "numberGrade" es requerido.',
            'numberGrade.regex' => 'El campo "numberGrade" no cumple con el formato correspondiente.'
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

    public function validationEdit($request)
    {
        $validator=Validator::make(
        [
            'nameGrade' => $request->input('selectNameGrade'),
            'numberGrade' => $request->input('txtNumberGrade')
        ],
        [
            'nameGrade' => ['required'],
            'numberGrade' => ['required','regex:/^[1-6]{1}$/']
        ],
        [
            'nameGrade.required' => 'El campo "nameGrade" es requerido.',
            'numberGrade.required' => 'El campo "numberGrade" es requerido.',
            'numberGrade.regex' => 'El campo "numberGrade" no cumple con el formato correspondiente.'
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

?>
