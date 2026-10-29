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

    $('#frmContact').off('submit.ajaxCrud').on('submit.ajaxCrud', function(event)
    {
        event.preventDefault();
        sendFrmContact($(this));
    });
});

function sendFrmContact(form)
{
	var isValid=null;

	form.data('formValidation').resetForm();
	form.data('formValidation').validate();

	isValid=form.data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	ajaxCrudSubmitForm('frmContact', {
		onBeforeSend: function(form)
		{
			setContactFormPending(form, true);
		},
		onSuccess: function(response, form)
		{
			form[0].reset();
			form.find('input[type=text], input[type=email], textarea').val('');
			form.data('formValidation').resetForm();
		},
		onComplete: function(form)
		{
			setContactFormPending(form, false);
		}
	});
}

function setContactFormPending(form, pending)
{
	var controls=form.find('input:not([type=hidden]):not([readonly]), textarea, select, button');
	var submitButton=form.find('button[type=submit], input[type=submit]')
		.not('.fv-hidden-submit')
		.filter(':visible')
		.first();

	form.attr('aria-busy', pending ? 'true' : 'false');

	controls.each(function()
	{
		var control=$(this);

		if(pending)
		{
			control.data('ajaxCrudWasDisabled', control.prop('disabled'));
			control.prop('disabled', true);

			return;
		}

		control.prop('disabled', control.data('ajaxCrudWasDisabled'));
		control.removeData('ajaxCrudWasDisabled');
	});

	if(!submitButton.length)
	{
		return;
	}

	if(pending)
	{
		submitButton.data('contactOriginalHtml', submitButton.html());
		submitButton.data('contactHadStyle', submitButton.is('[style]'));
		submitButton.data('contactOriginalStyle', submitButton.attr('style'));
		submitButton.data('contactHadAriaDisabled', submitButton.is('[aria-disabled]'));
		submitButton.data('contactOriginalAriaDisabled', submitButton.attr('aria-disabled'));
		submitButton.css('min-width', submitButton.outerWidth()+'px');
		submitButton.prop('disabled', true);
		submitButton.attr('aria-disabled', 'true');
		submitButton.html('Enviando...');

		return;
	}

	submitButton.html(submitButton.data('contactOriginalHtml'));
	submitButton.prop('disabled', false);

	if(submitButton.data('contactHadAriaDisabled'))
	{
		submitButton.attr('aria-disabled', submitButton.data('contactOriginalAriaDisabled'));
	}
	else
	{
		submitButton.removeAttr('aria-disabled');
	}

	if(submitButton.data('contactHadStyle'))
	{
		submitButton.attr('style', submitButton.data('contactOriginalStyle'));
	}
	else
	{
		submitButton.removeAttr('style');
	}

	submitButton.removeData('contactOriginalHtml');
	submitButton.removeData('contactHadStyle');
	submitButton.removeData('contactOriginalStyle');
	submitButton.removeData('contactHadAriaDisabled');
	submitButton.removeData('contactOriginalAriaDisabled');
}
