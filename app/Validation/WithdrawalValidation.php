<?php
namespace App\Validation;
use Illuminate\Support\Facades\Validator;
class WithdrawalValidation
{
    private $globalMessage=[];

    public function validationInsert($request)
    {
        $validator=Validator::make(
        [
            'idUser' => $request->input('hdIdUser'),
            'amount' => $request->input('txtAmount'),
            'typePay' => $request->input('selectTypePay')
        ],
        [
            'idUser' => ['required'],
            'amount' =>  ['required', 'regex:/^([1-9]+([0-9]+)?(\.[0-9]{1,2})?)?$/'],
            'typePay' => ['required']
        ],
        [
            'idUser.required' => 'El campo "idUser" es requerido.',
            'amount.required' => 'El campo "amount" es requerido.',
            'amount.regex' => 'El campo "amount" no cumple con el formato correspondiente.',
            'typePay.required' => 'El campo "typePay" es requerido.'
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