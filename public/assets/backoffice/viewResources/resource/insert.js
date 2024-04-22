'use strict';

$(function()
{
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

function deleteResource(component, url)
{
    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            successNote('Correcto', response.message);
            removeTableRowResource(component);
        }
    });
}

function removeTableRowResource(component) {
    $(component).parent().parent().remove();

    $('#tblResponseResource > tbody > tr').each((index, element) =>
    {
        $($(element).find('> .number')[0]).attr('text', (index+1));
    });
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

    confirmDialogSend('frmInsertResource');
}
