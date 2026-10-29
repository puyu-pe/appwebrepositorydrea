'use strict';

$(function()
{
    $('#frmInsertResource').off('submit.ajaxCrud').on('submit.ajaxCrud', function(event)
    {
        event.preventDefault();
        sendInsertResource();
    });

    $('#frmInsertResource').formValidation(objectValidate(
        {
            "fileResource[]":
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

function deleteResource(component, url, token)
{
    ajaxCrudDelete(url, token, {
        onSuccess: function(response) {
            removeTableRowResource(component);
        }
    });
}

function removeTableRowResource(component) {
    $(component).parent().parent().remove();

    $('#tblResponseResource > tbody > tr').each((index, element) =>
    {
        $($(element).find('> .number > div')[0]).text(index+1);
    });

    if($('#tblResponseResource > tbody > tr').length===0)
    {
        $('#tblResponseResource').closest('.table-responsive').remove();
    }
}

function sendInsertResource()
{
    var isValid=null;

    $('#frmInsertResource').data('formValidation').resetForm();
    $('#frmInsertResource').data('formValidation').validate();

    isValid=$('#frmInsertResource').data('formValidation').isValid();

    if(!isValid)
    {
        incorrectNote();

        return;
    }

    ajaxCrudSubmitFormData('frmInsertResource', {
        onSuccess: function(response, form)
        {
            var reloadUrl=window.codideepBackofficeListUrl || response.redirectUrl || 'examen/listar';

            form.closest('.modal').modal('hide');

            if($('#divAjaxCrudList').length)
            {
                ajaxCrudLoadList(
                    reloadUrl,
                    'divAjaxCrudList',
                    typeof initExamListAfterAjaxReload == 'function' ? initExamListAfterAjaxReload : null
                );
            }
        }
    });
}
