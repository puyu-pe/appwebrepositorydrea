'use strict';

  $('#frmEditSubject').formValidation(objectValidate(
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
        }
    }));

    function sendFrmEditSubject()
    {
        var isValid=null;

        $('#frmEditSubject').data('formValidation').resetForm();
        $('#frmEditSubject').data('formValidation').validate();

        isValid=$('#frmEditSubject').data('formValidation').isValid();

        if(!isValid)
        {
            incorrectNote();

            return;
        }

        confirmDialogSend('frmEditSubject');
    }
