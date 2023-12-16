<?php
namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class TypeExamValidation
{
    private $globalMessage=[];

    public function validationInsert($request)
    {
        $validator=Validator::make(
        [
            'nameTypeExam' => trim($request->input('txtNameTypeExam')),
            'acronymTypeExam' => trim($request->input('txtAcronymTypeExam')),
            'descriptionTypeExam' => trim($request->input('txtDescriptionTypeExam')),
            'numberExecuteYear' => $request->input('numberExecute'),
            'extensionImageType' => $request->input('fileTypeExamLogo')
        ],
        [
            'nameTypeExam' => ['required'],
            'acronymTypeExam' => ['required'],
            'descriptionTypeExam' => ['required'],
            'numberExecuteYear' => ['required'],
            'extensionImageType.*' => ['required','mimes:jpg,png,jpeg','size:1024']
        ],
        [
            'nameTypeExam.required' => 'El campo "nameTypeExam" es requerido.',
            'acronymTypeExam.required' => 'El campo "acronymTypeExam" es requerido.',
            'descriptionTypeExam.required' => 'El campo "descriptionTypeExam" es requerido.',
            'numberExecuteYear.required' => 'El campo "numberExecuteYear" es requerido.',
            'extensionImageType.required' => 'El campo "extensionImageType" es requerido.',
            'extensionImageType.mimes' => 'El archivo "extensionImageType" no tiene un formato permitido.',
            'extensionImageType.size' => 'El campo "extensionImageType" excede el tamaño permitido.'
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
            'nameTypeExam' => trim($request->input('txtNameTypeExam')),
            'acronymTypeExam' => trim($request->input('txtAcronymTypeExam')),
            'descriptionTypeExam' => trim($request->input('txtDescriptionTypeExam')),
            'numberExecuteYear' => $request->input('numberExecute'),
            'extensionImageType' => $request->input('fileTypeExamLogo')
        ],
        [
            'nameTypeExam' => ['required'],
            'acronymTypeExam' => ['required'],
            'descriptionTypeExam' => ['required'],
            'numberExecuteYear' => ['required'],
            'extensionImageType.*' => ['required','mimes:jpg,png,jpeg','size:1024']
        ],
        [
            'nameTypeExam.required' => 'El campo "nameTypeExam" es requerido.',
            'acronymTypeExam.required' => 'El campo "acronymTypeExam" es requerido.',
            'descriptionTypeExam.required' => 'El campo "descriptionTypeExam" es requerido.',
            'numberExecuteYear.required' => 'El campo "numberExecuteYear" es requerido.',
            'extensionImageType.required' => 'El campo "extensionImageType" es requerido.',
            'extensionImageType.mimes' => 'El archivo "extensionImageType" no tiene un formato permitido.',
            'extensionImageType.size' => 'El campo "extensionImageType" excede el tamaño permitido.'
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
