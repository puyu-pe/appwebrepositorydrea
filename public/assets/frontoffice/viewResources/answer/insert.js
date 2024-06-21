'use strict';

$(function()
{
    $('#frmInsertAnswer').formValidation(objectValidate({
        txtFirstName:
            {
                validators:
                    {
                        notEmpty:
                            {
                                message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                            }
                    }
            },
        txtSurName:
            {
                validators:
                    {
                        notEmpty:
                            {
                                message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                            }
                    }
            },
        txtNumberDni:
            {
                validators:
                    {
                        regexp:
                            {
                                message: '<b style="color: red;">Ingrese los 8 dígitos del DNI.</b>',
                                regexp: /^[0-9]{8}$/
                            },
                    }
            }
    }));
});

function validateNotEmptyResponse() {
    let total_empty_response = 0;
    let status_response = false;
    $('#tblResponseExam > tbody > tr').each((index, element) => {
        let $inputOrSelect = $(element).find('> td > input[name="txtValueResponseExam[]"], > td > select[name="txtValueResponseExam[]"], > td > div > select[name="txtValueResponseExam[]"]');

        if ($inputOrSelect.length > 0) {
            if ($inputOrSelect.is('input')) {
                let value_description = $inputOrSelect.val();
                if (value_description === '') {
                    total_empty_response++;
                }
            } else if ($inputOrSelect.is('select')) {
                let selected_option = $inputOrSelect.find('option:selected').val();
                if (!selected_option || selected_option === '') {
                    total_empty_response++;
                }
            }
        }
    });

    if (total_empty_response > 0) {
        status_response = true;
        errorNote('No se pudo proceder', 'Se debe registrar todas las alternativas');
    }

    return status_response;
}

function sendInsertAnswer()
{
    var isValid=null;

    $('#frmInsertAnswer').data('formValidation').resetForm();
    $('#frmInsertAnswer').data('formValidation').validate();

    isValid=$('#frmInsertAnswer').data('formValidation').isValid();

    if(!isValid)
    {
        incorrectNote();

        return;
    }

    if (validateNotEmptyResponse()){
        return false;
    }

    confirmDialogSend('frmInsertAnswer');
}
