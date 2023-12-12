'use strict';

  $('#frmInsertDirection').formValidation(objectValidate(
    {
        txtNameComplete:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        txtNameSort:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        txtNameRegion:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        fileLogoExtension:
        {
            validators:
            {
                file:
                {
                    message: '<b style="color: red;">Solo se permite formato "jpg, png y jpeg" y no más de 0.5MB.</b>',
                    extension: 'jpg,png,jpeg',
                    maxSize: 524288
                }
            }
        }
    }));

    function sendFrmInsertDirection()
    {
        var isValid=null;

        $('#frmInsertDirection').data('formValidation').resetForm();
        $('#frmInsertDirection').data('formValidation').validate();

        isValid=$('#frmInsertDirection').data('formValidation').isValid();

        if(!isValid)
        {
            incorrectNote();

            return;
        }

        confirmDialogSend('frmInsertDirection');
    }
