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
            'descriptionGrade' => $request->input('txtDescriptionGrade'),
            'codeGrade' => $request->input('txtCodeGrade')
        ],
        [
            'nameGrade' => ['required'],
            'descriptionGrade' => ['required'],
            'codeGrade' => ['required']
        ],
        [
            'nameGrade.required' => 'El campo "nameGrade" es requerido.',
            'descriptionGrade.required' => 'El campo "descriptionGrade" es requerido.',
            'codeGrade.required' => 'El campo "codeGrade" es requerido.'
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
            'descriptionGrade' => $request->input('txtDescriptionGrade'),
            'codeGrade' => $request->input('txtCodeGrade')
        ],
        [
            'nameGrade' => ['required'],
            'descriptionGrade' => ['required'],
            'codeGrade' => ['required']
        ],
        [
            'nameGrade.required' => 'El campo "nameGrade" es requerido.',
            'descriptionGrade.required' => 'El campo "descriptionGrade" es requerido.',
            'codeGrade.required' => 'El campo "codeGrade" es requerido.'
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
