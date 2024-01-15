'use strict';

  $('#frmEditGrade').formValidation(objectValidate(
    {
        txtNumberGrade:
        {
            validators:
            {
                regexp:
                {
                    message: '<b style="color: red;">Ingrese solo del 1 al 6.</b>',
                    regexp: /^[1-6]{1}$/
                },
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        selectNameGrade:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        }
    }));

    function sendFrmEditGrade()
    {
        var isValid=null;

        $('#frmEditGrade').data('formValidation').resetForm();
        $('#frmEditGrade').data('formValidation').validate();

        isValid=$('#frmEditGrade').data('formValidation').isValid();

        if(!isValid)
        {
            incorrectNote();

            return;
        }

        confirmDialogSend('frmEditGrade');
    }
