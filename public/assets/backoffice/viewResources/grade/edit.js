'use strict';

  $('#frmEditGrade').formValidation(objectValidate(
    {
        txtDescriptionGrade:
        {
            validators:
            {
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
        },
        txtCodeGrade:
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
