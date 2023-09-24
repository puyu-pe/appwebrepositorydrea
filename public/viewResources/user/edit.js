'use strict';

$(function()
{
    $('#frmEditUserProfile').formValidation(objectValidate(
        {
            txtFirstNameUser:
            {
                validators:
                {
                    notEmpty:
                    {
                        message: '<b style="color: red;">Este campo es requerido.</b>'
                    }
                }
            },
            txtSurNameUser:
            {
                validators:
                {
                    notEmpty:
                    {
                        message: '<b style="color: red;">Este campo es requerido.</b>'
                    }
                }
            },
            txtDniUser:
            {
                validators:
                {
                    regexp:
                    {
                      message: '<b style="color: red;">Ingrese los 8 dígitos del DNI.</b>',
                      regexp: /^[0-9]{8}$/

                    },
                    notEmpty:
                    {
                        message: '<b style="color: red;">Este campo es requerido.</b>'
                    }
                }
            },
            txtNumberPhone:
            {
                validators:
                {
                    regexp:
                    {
                      message: '<b style="color: red;">Ingrese los 9 dígitos del Celular.</b>',
                      regexp: /^[0-9]{9}$/

                    }
                }
            },
            fileAvatarExtension:
            {
                validators:
                {
                    file:
                    {
                        message: '<b style="color: red;">Solo se permite formato "jpg, png y jpeg" y no más de 4MB.</b>',
                        extension: 'jpg,png,jpeg',
                        maxSize: 4194304
                    }
                }
            }
        }));

    $('#frmEditUser').formValidation(objectValidate(
            {
                txtEmailUser:
                {
                    validators:
                    {
                        regexp:
                        {
                          message: '<b style="color: red;">Formato Incorrecto [Ejem:example.12@gmail.com].</b>',
                          regexp: /^[a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.[a-zA-Z]+(\.[a-zA-Z]+)?$/

                        },
                        notEmpty:
                        {
                            message: '<b style="color: red;">Este campo es requerido.</b>'
                        }
                    }
                },
                passPasswordUser:
                {
                    validators:
                    {
                        identical:
                        {
                            message: '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
                            field: 'passPasswordRetypeUser'
                        }
                    }
                },
                passPasswordRetypeUser:
                {
                    validators:
                    {
                        identical:
                        {
                            message: '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
                            field: 'passPasswordUser'
                        }
                    }
                }
            }));
});

function sendFrmEditUserProfile()
{
    var isValid=null;

    $('#frmEditUserProfile').data('formValidation').resetForm();
    $('#frmEditUserProfile').data('formValidation').validate();

    isValid=$('#frmEditUserProfile').data('formValidation').isValid();

    if(!isValid)
    {
        incorrectNote();

        return;
    }

    confirmDialogSend('frmEditUserProfile');
}

function sendFrmEditUser()
{
    var isValid=null;

    $('#frmEditUser').data('formValidation').resetForm();
    $('#frmEditUser').data('formValidation').validate();

    isValid=$('#frmEditUser').data('formValidation').isValid();

    if(!isValid)
    {
        incorrectNote();

        return;
    }

    confirmDialogSend('frmEditUser');
}
