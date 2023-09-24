'use strict';

$(function()
{
  $('*').on('keypress', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13)
    {
      e.preventDefault();
    }
  });
});

$('#frmRegister').formValidation(objectValidate(
    {
        txtNumberDni:
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
        txtFirstName:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        txtSurName:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        txtEmail:
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
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        passPasswordUser:
        {
            validators:
            {
                notEmpty:
                {
                    message: '<b style="color: red;">Este campo es requerido.</b>'
                },
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
        },
    }
  ));

function sendfrmRegister()
{
    var isValid =null;

    $('#frmRegister').data('formValidation').resetForm();
    $('#frmRegister').data('formValidation').validate();

    isValid = $('#frmRegister').data('formValidation').isValid();

    if(!isValid)
    {
      incorrectNote();

      return;
    }

    confirmDialogSend('frmRegister');
}
