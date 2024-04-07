<?php
namespace App\Validation;
use Illuminate\Support\Facades\Validator;
class ContactReplyValidation
{
    private $globalMessage=[];

    public function validationInsert($request)
    {
        $validator=Validator::make(
        [
            'messageContact' => trim($request->input('txtMessage'))
        ],
        [
            'messageContact' => ['required']
        ],
        [
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
