'use strict';

  $('#frmEditTypeExam').formValidation(objectValidate(
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
                }
            }
        },
        numberExecute:
        {
            validators:
            {
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

    function sendFrmEditTypeExam()
    {
        var isValid=null;

        $('#frmEditTypeExam').data('formValidation').resetForm();
        $('#frmEditTypeExam').data('formValidation').validate();

        isValid=$('#frmEditTypeExam').data('formValidation').isValid();

        if(!isValid)
        {
            incorrectNote();

            return;
        }

        confirmDialogSend('frmEditTypeExam');
    }
