'use strict';

  $('#frmInsertSubject').formValidation(objectValidate(
    {
        txtNameSubject:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        txtCodeSubject:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        }
    }));

    function sendFrmInsertSubject()
    {
        var isValid=null;

        $('#frmInsertSubject').data('formValidation').resetForm();
        $('#frmInsertSubject').data('formValidation').validate();

        isValid=$('#frmInsertSubject').data('formValidation').isValid();

        if(!isValid)
        {
            incorrectNote();

            return;
        }

		ajaxCrudSubmitForm('frmInsertSubject', {reloadUrl: window.codideepBackofficeInsertReloadUrl, ajaxContainerId: 'divAjaxCrudList', postReload: initSubjectListValidation});
	}
