<?php
namespace App\Validation;
use Illuminate\Support\Facades\Validator;
class ContactValidation
{
    private $globalMessage=[];

    public function validationInsert($request)
    {
        $validator=Validator::make(
        [
            'completeNameContact' => trim($request->input('txtFullName')),
            'emailContact' => trim($request->input('txtEmail')),
            'affairContact' => trim($request->input('txtSubject')),
            'messageContact' => trim($request->input('txtMessage'))
        ],
        [
            'completeNameContact' => ['required'],
            'emailContact' => ['required','regex:/^([a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.[a-zA-Z]+(\.[a-zA-Z]+)?)?$/'],
            'affairContact' => ['required'],
            'messageContact' => ['required']
        ],
        [
            'completeNameContact.required' => 'El campo "completeNameContact" es requerido.',
            'emailContact.required' => 'El campo "emailContact" es requerido.',
            'emailContact.regex' => 'El campo "emailContact" no cumple con el formato correspondiente.',
            'affairContact.required' => 'El campo "affairContact" es requerido.',
            'messageContact.required' => 'El campo "messageContact" es requerido.'
        ]);

        if($validator->fails())
        {
            $errors=$validator->errors()->all();

            foreach($errors as $value)
            {
                $this->globalMessage[]=$value;
            }
        }

        return $this->globalMessage;
    }
}
