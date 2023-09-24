'use strict';

$('#frmRecuperate').formValidation(objectValidate(
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
        sendFrmRecuperate();
      }
  }

  function sendFrmRecuperate()
  {
    var isValid =null;

    $('#frmRecuperate').data('formValidation').resetForm();
    $('#frmRecuperate').data('formValidation').validate();

    isValid = $('#frmRecuperate').data('formValidation').isValid();

    if(!isValid)
    {
      incorrectNote();

      return;
    }

    $('#modalLoading').show();

    $('#frmRecuperate')[0].submit();
  }
