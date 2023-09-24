'use strict';

$('#frmLogin').formValidation(objectValidate(
    {
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
      passPassword:
      {
        validators:
        {
            notEmpty:
            {
                message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
            }
        }
      }
    }
  ));

  $(function()
  {
    $('*').on('keypress', function (e) {
      if (e.key === 'Enter' || e.keyCode === 13)
      {
        e.preventDefault();
      }
    });
  });

  function onKeyUpPassPassword(e)
  {
    if (keyUpEnter(e))
      {
        sendfrmLogin();
      }
  }

  function sendfrmLogin()
  {
    var isValid =null;

    $('#frmLogin').data('formValidation').resetForm();
    $('#frmLogin').data('formValidation').validate();

    isValid = $('#frmLogin').data('formValidation').isValid();

    if(!isValid)
    {
      incorrectNote();

      return;
    }

    $('#modalLoading').show();

    $('#frmLogin')[0].submit();
  }
