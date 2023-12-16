<?php
namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class ExamValidation
{
    private $globalMessage=[];

    public function validationInsert($request)
    {
        $validator=Validator::make(
        [
            'idTypeExam' => $request->input('selectTypeExam'),
            'idGrade' => $request->input('selectGrade'),
            'idSubject' => $request->input('selectSubject'),
            'descriptionExam' => trim($request->input('txtDescriptionExam')),
            'totalPageExam' => $request->input('txtTotalPageExam'),
            'yearExam' => $request->input('txtYearExam'),
            'numberEvaluation' => $request->input('numberEvaluationExecute'),
            'keywordExam' => $request->input('selectKeywordExam'),
            'extensionExam' => $request->input('fileExamExtension')
        ],
        [
            'idTypeExam' => ['required'],
            'idGrade' => ['required'],
            'idSubject' => ['required'],
            'descriptionExam' => ['required'],
            'totalPageExam' => ['required', 'regex:/^[0-9]{1,3}$/'],
            'yearExam' => ['required', 'regex:/^[0-9]{4}$/'],
            'numberEvaluation' => ['required'],
            'keywordExam' => ['required'],
            'extensionExam.*' => ['required','mimes:pdf']
        ],
        [
            'idTypeExam.required' => 'El campo "idTypeExam" es requerido.',
            'idGrade.required' => 'El campo "idGrade" es requerido.',
            'idSubject.required' => 'El campo "idSubject" es requerido.',
            'descriptionExam.required' => 'El campo "descriptionExam" es requerido.',
            'totalPageExam.required' => 'El campo "totalPageExam" es requerido.',
            'totalPageExam.regex' => 'El campo "totalPageExam" no cumple con el formato correspondiente.',
            'yearExam.required' => 'El campo "yearExam" es requerido.',
            'yearExam.regex' => 'El campo "yearExam" no cumple con el formato correspondiente.',
            'numberEvaluation.required' => 'El campo "numberEvaluation" es requerido.',
            'keywordExam.required' => 'El campo "keywordExam" es requerido.',
            'extensionExam.required' => 'El campo "extensionExam" es requerido.',
            'extensionExam.mimes' => 'El archivo "extensionExam" no tiene un formato permitido.'
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
            'idTypeExam' => $request->input('selectTypeExam'),
            'idGrade' => $request->input('selectGrade'),
            'idSubject' => $request->input('selectSubject'),
            'descriptionExam' => trim($request->input('txtDescriptionExam')),
            'totalPageExam' => $request->input('txtTotalPageExam'),
            'yearExam' => $request->input('txtYearExam'),
            'numberEvaluation' => $request->input('numberEvaluationExecute'),
            'keywordExam' => $request->input('selectKeywordExam'),
            'extensionExam' => $request->input('fileExamExtension')
        ],
        [
            'idTypeExam' => ['required'],
            'idGrade' => ['required'],
            'idSubject' => ['required'],
            'descriptionExam' => ['required'],
            'totalPageExam' => ['required', 'regex:/^[0-9]{1,3}$/'],
            'yearExam' => ['required', 'regex:/^[0-9]{4}$/'],
            'numberEvaluation' => ['required'],
            'keywordExam' => ['required'],
            'extensionExam.*' => ['required','mimes:pdf']
        ],
        [
            'idTypeExam.required' => 'El campo "idTypeExam" es requerido.',
            'idGrade.required' => 'El campo "idGrade" es requerido.',
            'idSubject.required' => 'El campo "idSubject" es requerido.',
            'descriptionExam.required' => 'El campo "descriptionExam" es requerido.',
            'totalPageExam.required' => 'El campo "totalPageExam" es requerido.',
            'totalPageExam.regex' => 'El campo "totalPageExam" no cumple con el formato correspondiente.',
            'yearExam.required' => 'El campo "yearExam" es requerido.',
            'yearExam.regex' => 'El campo "yearExam" no cumple con el formato correspondiente.',
            'numberEvaluation.required' => 'El campo "numberEvaluation" es requerido.',
            'keywordExam.required' => 'El campo "keywordExam" es requerido.',
            'extensionExam.required' => 'El campo "extensionExam" es requerido.',
            'extensionExam.mimes' => 'El archivo "extensionExam" no tiene un formato permitido.'
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
