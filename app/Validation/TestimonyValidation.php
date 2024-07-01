<?php
namespace App\Validation;
use Illuminate\Support\Facades\Validator;
class TestimonyValidation
{
    private $globalMessage=[];

    public function validationInsert($request)
    {
        $validator=Validator::make(
        [
            'description' => trim($request->input('txtDescription')),
            'firstName' => $request->input('txtfirstName'),
            'surName' => $request->input('txtsurName'),
            'place_origin' => $request->input('txtPlaceOrigin')
        ],
        [
            'description' => ['required'],
            'firstName' => ['required'],
            'surName' => ['required'],
            'place_origin' => ['required']
        ],
        [
            'description.required' => 'El campo "description" es requerido.',
            'firstName.required' => 'El campo "firstName" es requerido.',
            'surName.required' => 'El campo "surName" es requerido.',
            'place_origin.required' => 'El campo "place_origin" es requerido.'
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
                'description' => trim($request->input('txtDescription')),
                'firstName' => $request->input('txtfirstName'),
                'surName' => $request->input('txtsurName'),
                'place_origin' => $request->input('txtPlaceOrigin')
            ],
            [
                'description' => ['required'],
                'firstName' => ['required'],
                'surName' => ['required'],
                'place_origin' => ['required']
            ],
            [
                'description.required' => 'El campo "description" es requerido.',
                'firstName.required' => 'El campo "firstName" es requerido.',
                'surName.required' => 'El campo "surName" es requerido.',
                'place_origin.required' => 'El campo "place_origin" es requerido.'
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
