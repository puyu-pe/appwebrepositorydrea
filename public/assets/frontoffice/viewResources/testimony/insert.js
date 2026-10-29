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

    $('#frmTestimony').off('submit.ajaxCrud').on('submit.ajaxCrud', function(event)
    {
        event.preventDefault();
        sendFrmTestimony();
    });
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

	ajaxCrudSubmitForm('frmTestimony', {
		onSuccess: function(response, form)
		{
			form[0].reset();
			form.find('input[type=text], textarea').val('');
			form.data('formValidation').resetForm();
		}
	});
}
