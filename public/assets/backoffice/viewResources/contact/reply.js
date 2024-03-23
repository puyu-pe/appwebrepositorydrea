'use strict';

$('#frmReplyContact').formValidation(objectValidate(
    {
        txtMessage:
            {
                validators:
                    {
                        notEmpty:
                            {
                                message: '<b style="color: red;">Este Campo es Obligatorio.</b>'
                            }
                    }
            }
    }));

function sendFrmReplyContact() {
    var isValid = null;

    $('#frmReplyContact').data('formValidation').resetForm();
    $('#frmReplyContact').data('formValidation').validate();

    isValid = $('#frmReplyContact').data('formValidation').isValid();

    if (!isValid) {
        incorrectNote();
        return;
    }

    confirmDialogSend('frmReplyContact');
}
