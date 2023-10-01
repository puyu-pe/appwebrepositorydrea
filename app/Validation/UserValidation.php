<?php
namespace App\Validation;
use Illuminate\Support\Facades\Validator;
class UserValidation
{
    private $globalMessage=[];

    public function validationLogin($request)
    {
        $validator=Validator::make(
        [
            'email' => $request->input('txtEmail'),
            'password' => $request->input('passPassword')
        ],
        [
            'email' => ['required','regex:/^([a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.[a-zA-Z]+(\.[a-zA-Z]+)?)?$/'],
            'password' => ['required']
        ],
        [
            'email.required' => 'El campo "email" es requerido',
            'email.regex' => 'El campo "email" no cumple con el formato correspondiente',
            'password.required' => 'El campo "password" es requerido'
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

    public function validationRegister($request)
    {
        $validator=Validator::make(
        [
            'email' => trim($request->input('txtEmail')),
            'password' => trim($request->input('passPasswordUser')),
            'numberDni' => $request->input('txtNumberDni'),
            'firstName' => trim($request->input('txtFirstName')),
            'surName' => trim($request->input('txtSurName'))
        ],
        [
            'email' => ['required','regex:/^([a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.[a-zA-Z]+(\.[a-zA-Z]+)?)?$/'],
            'password' => ['required'],
            'numberDni' => ['required','regex:/^[0-9]{8}$/'],
            'firstName' => ['required'],
            'surName' => ['required']
        ],
        [
            'email.required' => 'El campo "email" es requerido.',
            'email.regex' => 'El campo "email" no cumple con el formato correspondiente.',
            'password.required' => 'El campo "password" es requerido.',
            'numberDni.required' => 'El campo "numberDni" es requerido.',
            'numberDni.regex' => 'El campo "numberDni" no cumple con el formato correspondiente.',
            'firstName.required' => 'El campo "firstName" es requerido.',
            'surName.required' => 'El campo "surName" es requerido.'
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

    public function validationEdit($request)
    {
        $validator=Validator::make(
        [
            'firstName' => trim($request->input('txtFirstNameUser')),
            'surName' => trim($request->input('txtSurNameUser')),
            'numberDni' => $request->input('txtDniUser'),
            'avatarExtension' => $request->input('fileAvatarExtension')
        ],
        [
            'firstName' => ['required'],
            'surName' => ['required'],
            'numberDni' => ['required','regex:/^[0-9]{8}$/'],
            'avatarExtension.*' => ['mimes:jpg,png,jpeg','size:4096']
        ],
        [
            'firstName.required' => 'El campo "firstName" es requerido.',
            'surName.required' => 'El campo "surName" es requerido.',
            'numberDni.required' => 'El campo "numberDni" es requerido.',
            'numberDni.regex' => 'El campo "numberDni" no cumple con el formato correspondiente.',
            'avatarExtension.mimes' => 'El archivo "avatarExtension" no tiene un formato permitido.',
            'avatarExtension.size' => 'El campo "avatarExtension" excede el tamaño permitido.'
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

    public function validationChange($request)
    {
        $validator=Validator::make(
        [
            'email' => trim($request->input('txtEmailUser')),
        ],
        [
            'email' => ['required','regex:/^([a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.[a-zA-Z]+(\.[a-zA-Z]+)?)?$/'],
        ],
        [
            'email.required' => 'El campo "email" es requerido.',
            'email.regex' => 'El campo "email" no cumple con el formato correspondiente.',
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
?>
