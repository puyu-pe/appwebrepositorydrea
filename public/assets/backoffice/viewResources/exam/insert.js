'use strict';


$(function()
{
    $('#frmInsertExam').formValidation(objectValidate({
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
        "selectKeywordExam[]":
        {
            validators:
            {
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
        fileExamExtension:
        {
            validators:
            {
                file:
                {
                    message: '<b style="color: red;">Solo se permite formato "pdf".</b>',
                    extension: 'pdf'
                },
                notEmpty:
                {
                    message:'<b style="color: red;">Este Campo es Obligatorio.</b>'
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
        }
    }));

    $('#dvExamResponse').formValidation(objectValidate(
    {
        numberResponse:
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
                    message: '<b style="color: red;">Este campo es requerido.</b>'
                }
            }
        },
        txtDescriptionResponse:
        {
            validators:
            {
                notEmpty:
                {
                    message: '<b style="color: red;">Este campo es requerido.</b>'
                }
            }
        }
    }));

    $('.select2TypeExam').select2();
    $('.select2DirectionExam').select2();
    $('.select2Subject').select2();
    $('.select2Grade').select2();
    $('.select2ExamKeyword').select2(
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
    });
});

function addElementConcept()
{
    var isValid=null;

    $('#dvExamResponse').data('formValidation').resetForm();
    $('#dvExamResponse').data('formValidation').validate();

    isValid=$('#dvExamResponse').data('formValidation').isValid();

    if(!isValid)
    {
        return;
    }

    if (confirmExam($('#numberResponse').val())){
        return false;
    }

    if (validateTotalResponse()){
        return false;
    }

    var rowNumber=$('#tblResponseExam > tbody > tr').length+1;
    let number_question = parseInt($('#numberResponse').val());

    var htmlTemp=
    `<tr>
        <td class="text-center tblNumber">
            <input type="number" id="numberValueExam`+rowNumber+`" name="numberValueExam[]" min="1" value="`+number_question+`" class="form-control" form="frmInsertExam" readonly>
        </td>
        <td>
            <input type="text" id="txtValueResponseExam`+rowNumber+`" name="txtValueResponseExam[]" value="`+$('#txtDescriptionResponse').val()+`" class="form-control" form="frmInsertExam">
        </td>
        <td class="text-center">
            <span class="btn btn-default btn-sm glyphicon glyphicon-remove" data-toggle="tooltip" title="Quitar" data-placement="left" onclick="removeTableRowResponse(this);"></span>
        </td>
    </tr>`;

    $('#tblResponseExam > tbody').append(htmlTemp);

    $('#numberResponse').val(number_question + 1);
    $('#txtDescriptionResponse').val('');

    $('[data-toggle="tooltip"]').tooltip();
}

function removeTableRowResponse(component)
{
    $(component).parent().parent().remove();

    $('#tblResponseExam > tbody > tr').each((index, element) =>
    {
        $($(element).find('> td > input[name="numberValueExam[]"]')[0]).attr('id', 'numberValueExam'+(index+1));
        $($(element).find('> td > input[name="txtValueResponseExam[]"]')[0]).attr('id', 'txtValueResponseExam'+(index+1));
    });
}

function confirmExam(number)
{
    let status = false;
    $('#tblResponseExam > tbody > tr').each((index, element) =>
    {
        let number_exists = $($(element).find('> td > input[name="numberValueExam[]"]')[0]).val();

        if (number === number_exists){
            errorNote('Error', 'Ingrese un n° de pregunta que no esté en los registros');
            status = true;
        }
    });

    return status;
}

function validateTotalResponse()
{
    let status = false;
    let total = parseInt($('#txtResponseExamPermit').val());
    let rowNumber=$('#tblResponseExam > tbody > tr').length+1;

    if (rowNumber>total){
        errorNote('Error', 'Solo se permite ingresar un total de ' + total + (total> 1 ? ' respuestas' : ' respuesta'));
        status = true;
    }
    return status;
}

function showButtonResponse(value)
{
    if (value === '1'){
        $('#txtResponseExamPermit').prop('readonly', false);
        $('#txtResponseExamPermit').val('');
        $('#btnModalResponse').show();
    }else{
        resetQuestion();
        $('#txtResponseExamPermit').prop('readonly', true);
        $('#txtResponseExamPermit').val('');
        $('#btnModalResponse').hide();
    }
}

function resetQuestion(){
    $('table#tblResponseExam tbody').empty();
    $('#numberResponse').val(1);
    $('#txtDescriptionResponse').val('');
}

function openModal(){
    if ($('#txtResponseExamPermit').val() !== '')
    {
        $('#txtResponseExamPermit').prop('readonly', true);
        $('#modalAccess').modal('show');
    }else {
        warningNote('Advertencia', 'Ingrese la cantidad de preguntas de la evaluación');
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

function validateNotEmptyResponse(){
    let status = false;
    $('#tblResponseExam > tbody > tr').each((index, element) =>
    {
        let number_response = $($(element).find('> td > input[name="numberValueExam[]"]')[0]).val();
        let value_description = $($(element).find('> td > input[name="txtValueResponseExam[]"]')[0]).val();

        if (number_response === '' || value_description === ''){
            status = true;
        }
    });

    if (status)
        errorNote('No se pudo proceder', 'No pueden estar las respuestas en vacio');

    return status;
}

function sendInsertExam()
{
    var isValid=null;

    $('#frmInsertExam').data('formValidation').resetForm();
    $('#frmInsertExam').data('formValidation').validate();

    isValid=$('#frmInsertExam').data('formValidation').isValid();

    if(!isValid)
    {
        incorrectNote();

        return;
    }

    if(validRegister()){
        return;
    }

    if (validateNotEmptyResponse()){
        return;
    }

    confirmDialogSend('frmInsertExam');
}
