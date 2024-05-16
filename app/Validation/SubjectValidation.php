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
            'nameSubject' => trim($request->input('txtNameSubject')),
            'codeSubject' => trim($request->input('txtCodeSubject'))
        ],
        [
            'nameSubject' => ['required'],
            'codeSubject' => ['required']
        ],
        [
            'nameSubject.required' => 'El campo "nameSubject" es requerido.',
            'codeSubject.required' => 'El campo "codeSubject" es requerido.'
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
            'nameSubject' => trim($request->input('txtNameSubject')),
            'codeSubject' => trim($request->input('txtCodeSubject'))
        ],
        [
            'nameSubject' => ['required'],
            'codeSubject' => ['required']
        ],
        [
            'nameSubject.required' => 'El campo "nameSubject" es requerido.',
            'codeSubject.required' => 'El campo "codeSubject" es requerido.'
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
