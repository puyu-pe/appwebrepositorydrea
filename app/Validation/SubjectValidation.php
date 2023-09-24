<?php
namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class SubjectValidation
{
    private $globalMessage=[];

    public function validationInsert($request)
    {
        $validator=Validator::make(
        [
            'nameSubject' => trim($request->input('txtNameSubject'))
        ],
        [
            'nameSubject' => ['required']
        ],
        [
            'nameSubject.required' => 'El campo "nameTypeExam" es requerido.'
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
            'nameSubject' => trim($request->input('txtNameSubject'))
        ],
        [
            'nameSubject' => ['required']
        ],
        [
            'nameSubject.required' => 'El campo "nameTypeExam" es requerido.'
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
