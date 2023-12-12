<?php
namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class DirectionValidation
{
    private $globalMessage=[];

    public function validationInsert($request)
    {
        $validator=Validator::make(
        [
            'namecompleteDirection' => trim($request->input('txtNameComplete')),
            'namesortDirection' => trim($request->input('txtNameSort')),
            'nameRegion' => trim($request->input('txtNameRegion')),
            'logoExtension' => $request->input('fileLogoExtension')
        ],
        [
            'namecompleteDirection' => ['required'],
            'namesortDirection' => ['required'],
            'nameRegion' => ['required'],
            'logoExtension.*' => ['mimes:jpg,png,jpeg','size:512']
        ],
        [
            'namecompleteDirection.required' => 'El campo "namecompleteDirection" es requerido.',
            'namesortDirection.required' => 'El campo "namesortDirection" es requerido.',
            'nameRegion.required' => 'El campo "nameRegion" es requerido.',
            'logoExtension.mimes' => 'El archivo "logoExtension" no tiene un formato permitido.',
            'logoExtension.size' => 'El campo "logoExtension" excede el tamaño permitido.'
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
            'namecompleteDirection' => trim($request->input('txtNameComplete')),
            'namesortDirection' => trim($request->input('txtNameSort')),
            'nameRegion' => trim($request->input('txtNameRegion')),
            'logoExtension' => $request->input('fileLogoExtension')
        ],
        [
            'namecompleteDirection' => ['required'],
            'namesortDirection' => ['required'],
            'nameRegion' => ['required'],
            'logoExtension.*' => ['mimes:jpg,png,jpeg','size:512']
        ],
        [
            'namecompleteDirection.required' => 'El campo "namecompleteDirection" es requerido.',
            'namesortDirection.required' => 'El campo "namesortDirection" es requerido.',
            'nameRegion.required' => 'El campo "nameRegion" es requerido.',
            'logoExtension.mimes' => 'El archivo "logoExtension" no tiene un formato permitido.',
            'logoExtension.size' => 'El campo "logoExtension" excede el tamaño permitido.'
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
