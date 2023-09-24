'use strict';

  $('#frmInsertTypeExam').formValidation(objectValidate(
    {
        txtNameTypeExam:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        txtAcronymTypeExam:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        fileTypeExamLogo:
        {
            validators:
            {
                file:
                {
                    message: '<b style="color: red;">Solo se permite formato "jpg, png y jpeg" y no más de 1MB.</b>',
                    extension: 'jpg,png,jpeg',
                    maxSize: 1048576
                },
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        txtDescriptionTypeExam:
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

    function sendFrmInsertTypeExam()
    {
        var isValid=null;

        $('#frmInsertTypeExam').data('formValidation').resetForm();
        $('#frmInsertTypeExam').data('formValidation').validate();

        isValid=$('#frmInsertTypeExam').data('formValidation').isValid();

        if(!isValid)
        {
            incorrectNote();

            return;
        }

        confirmDialogSend('frmInsertTypeExam');
    }
