'use strict';

$(function()
{
    $('#frmChangeUser').formValidation(objectValidate(
        {
            "selectRoleUser[]":
            {
                validators:
                {
                    notEmpty:
                    {
                        message: '<b style="color: red;">Este campo es requerido.</b>'
                    }
                }
            }
        }));
});

$($('.select2Role').select2());

function sendFrmChangeUser()
{
    var isValid=null;

    $('#frmChangeUser').data('formValidation').resetForm();
    $('#frmChangeUser').data('formValidation').validate();

    isValid=$('#frmChangeUser').data('formValidation').isValid();

    if(!isValid)
    {
        incorrectNote();

        return;
    }

    confirmDialogSend('frmChangeUser');
}
