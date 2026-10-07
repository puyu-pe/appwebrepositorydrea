'use strict';

$(function()
{
    initGradeListValidation();
    ajaxCrudBindPagination('divAjaxCrudList', initGradeListValidation);
});

function initGradeListValidation()
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
}

function searchGrade(text, url, event)
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

		ajaxCrudLoadList(url+'?searchParameter='+encodeURIComponent(text), 'divAjaxCrudList', initGradeListValidation);
	}
}
