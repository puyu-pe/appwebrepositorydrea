'use strict';


$(function()
{
    $('#frmEditTestimony').formValidation(objectValidate(
        {
            txtfirstName:
                {
                    validators:
                        {
                            notEmpty:
                                {
                                    message: '<b style="color: red;">Este campo es requerido.</b>'
                                }
                        }
                },
            txtsurName:
                {
                    validators:
                        {
                            notEmpty:
                                {
                                    message: '<b style="color: red;">Este campo es requerido.</b>'
                                }
                        }
                },
            txtPlaceOrigin:
                {
                    validators:
                        {
                            notEmpty:
                                {
                                    message: '<b style="color: red;">Este campo es requerido.</b>'
                                }
                        }
                },
            txtDescription:
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

function sendEditFrmTestimony()
{
    var isValid=null;

    $('#frmEditTestimony').data('formValidation').resetForm();
    $('#frmEditTestimony').data('formValidation').validate();

    isValid=$('#frmEditTestimony').data('formValidation').isValid();

    if(!isValid)
    {
        incorrectNote();

        return;
    }

    confirmDialogSend('frmEditTestimony');
}
