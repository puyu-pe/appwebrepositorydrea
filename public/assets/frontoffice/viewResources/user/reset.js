'use strict';

$(function()
{
    $('*').on('keypress', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13){
            e.preventDefault();
        }
    });

    $('#frmReset').formValidation(objectValidate({
        passPasswordUser:
        {
            validators:
            {
                notEmpty:
                {
                    message: '<b style="color: red;">Este campo es requerido.</b>'
                },
                identical:
                {
                    message: '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
                    field: 'passPasswordRetypeUser'
                }
            }
        },
        passPasswordRetypeUser:
        {
            validators:
            {
                identical:
                {
                    message: '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
                    field: 'passPasswordUser'
                }
            }
        }
    }));
});

function sendfrmReset()
{
    var isValid =null;

    $('#frmReset').data('formValidation').resetForm();
    $('#frmReset').data('formValidation').validate();

    isValid = $('#frmReset').data('formValidation').isValid();

    if(!isValid)
    {
      incorrectNote();

      return;
    }

    confirmDialogSend('frmReset');
}
