'use strict';


$(function()
{
    $('#frmTestimony').formValidation(objectValidate(
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

function sendFrmTestimony()
{
	var isValid=null;

	$('#frmTestimony').data('formValidation').resetForm();
	$('#frmTestimony').data('formValidation').validate();

	isValid=$('#frmTestimony').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmTestimony');
}
