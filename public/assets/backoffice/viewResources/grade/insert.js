'use strict';

  $('#frmInsertGrade').formValidation(objectValidate(
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

    function sendFrmInsertGrade()
    {
        var isValid=null;

        $('#frmInsertGrade').data('formValidation').resetForm();
        $('#frmInsertGrade').data('formValidation').validate();

        isValid=$('#frmInsertGrade').data('formValidation').isValid();

        if(!isValid)
        {
            incorrectNote();

            return;
        }

        confirmDialogSend('frmInsertGrade');
    }
