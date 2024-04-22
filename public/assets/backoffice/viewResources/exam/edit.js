'use strict';

$('#frmEditExam').formValidation(objectValidate(
    {
        txtDescriptionExam:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        txtYearExam:
        {
            validators:
            {
                regexp:
                {
                    message: '<b style="color: red;">Ingrese un valor válido.</b>',
                    regexp: /^[0-9]{4}$/
                },
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        numberEvaluationExecute:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        selectTypeExam:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        selectDirectionExam:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        selectSubject:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        selectGrade:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        fileExamExtension:
        {
            validators:
            {
                file:
                {
                    message: '<b style="color: red;">Solo se permite formato "pdf".</b>',
                    extension: 'pdf'
                }
            }
        },
        fileTableResource:
        {
            validators:
            {
                file:
                {
                    message: '<b style="color: red;">Solo se permite formato "pdf".</b>',
                    extension: 'pdf'
                }
            }
        },
        txtTotalPageExam:
        {
            validators:
            {
                regexp:
                {
                    message: '<b style="color: red;">Ingrese un valor válido.</b>',
                    regexp: /^[0-9]{1,3}$/
                },
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        selectRegisterAnswer:
        {
            validators:
            {
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
                }
            }
        },
        "selectKeywordExam[]":
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

    $($('.select2TypeExam').select2());
    $($('.select2DirectionExam').select2());
    $($('.select2Subject').select2());
    $($('.select2Grade').select2());
    $($('.select2ExamKeyword').select2(
        {
            tags: true,
            language:
            {
                noResults : function()
                {
                    return 'No se encontraron resultados.';
                },
                searching : function()
                {
                    return 'Buscando...';
                },
                inputTooShort : function()
                {
                    return 'Por favor ingrese 3 o más caracteres';
                }
            },
            placeholder: 'Agregar datos...'
        }));


    function showButtonResponse(value)
    {
        if (value === '1'){
            $('#txtResponseExamPermit').prop('readonly', false);
            $('#txtResponseExamPermit').val('');
        }else{
            $('#txtResponseExamPermit').prop('readonly', true);
            $('#txtResponseExamPermit').val('');
        }
    }

    function validRegister()
    {
        let status = false;
        let status_register_answer = $('#selectRegisterAnswer').val();
        let value_number_response = $('#txtResponseExamPermit').val();

        if(status_register_answer === '1' && value_number_response === ''){
            errorNote('Error', 'Ingrese la cantidad de preguntas para la evaluación.');
            status = true;
        }
        return status;
    }

    function sendFrmEditExam()
    {
        var isValid=null;

        $('#frmEditExam').data('formValidation').resetForm();
        $('#frmEditExam').data('formValidation').validate();

        isValid=$('#frmEditExam').data('formValidation').isValid();

        if(!isValid)
        {
            incorrectNote();

            return;
        }

        if(validRegister()){
            return;
        }

        confirmDialogSend('frmEditExam');
    }
