'use strict';

$(function()
{
    $('#divSearch').formValidation(objectValidate(
        {
            txtSearch:
            {
                validators:
                {
                    regexp:
                    {
                        message: '<b style="color: red;">Solo se permite texto y números.</b>',
                        regexp: /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚàèìòùÀÈÌÒÙ\s@\.\-_]*$/
                    }
                }
            }
        }));
});

function searchExam(text, url, event)
{
    var evt=event || window.event;

    var code= evt.charCode || evt.keyCode || evt.which;

    if(code==13)
    {
        var isValid=null;

        $('#divSearch').data('formValidation').resetForm();
        $('#divSearch').data('formValidation').validate();

        isValid=$('#divSearch').data('formValidation').isValid();

        if(!isValid)
        {
            incorrectNote();

            return;
        }

        $('#modalLoading').show();

        $('#txtSearch').attr('disabled', 'disabled');

        window.location.href=url+'?searchParameter='+text;
    }
}
