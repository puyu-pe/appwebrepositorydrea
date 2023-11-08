'use strict';


$(function()
{
    $('#frmContact').formValidation(objectValidate(
        {
            txtFullName:
            {
                validators:
                {
                    notEmpty:
                    {
                        message: '<b style="color: red;">Este campo es requerido.</b>'
                    }
                }
            },
            txtEmail:
            {
                validators:
                {
                    notEmpty:
                    {
                        message: '<b style="color: red;">Este campo es requerido.</b>'
                    },
                    regexp:
                    {
                        message: '<b style="color: red;">Formato incorrecto. [Ejemplo: any@gmail.com].</b>',
                        regexp: /^[a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.[a-zA-Z]+(\.[a-zA-Z]+)?$/
                    }
                }
            },
            txtSubject:
            {
                validators:
                {
                    notEmpty:
                    {
                        message: '<b style="color: red;">Este campo es requerido.</b>'
                    }
                }
            },
            txtMessage:
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

function sendFrmContact()
{
	var isValid=null;

	$('#frmContact').data('formValidation').resetForm();
	$('#frmContact').data('formValidation').validate();

	isValid=$('#frmContact').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmContact');
}
