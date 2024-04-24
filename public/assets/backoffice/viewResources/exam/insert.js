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

function addElementConcept(number)
{
    var htmlTemp=
    `<tr>
        <td class="text-center tblNumber">
            <div>`+number+`</div>
        </td>
        <td>
            <input type="text" id="txtValueResponseExam`+number+`" name="txtValueResponseExam[]" class="form-control" value="" form="frmInsertExam">
        </td>
    </tr>`;

    $('#tblResponseExam > tbody').append(htmlTemp);
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

function generateQuestion(total){
    let total_answer = parseInt(total);
    let total_answer_table =  parseInt($('#tblResponseExam > tbody > tr').length);

    if (total_answer !== total_answer_table){
        for (let i= 0; i< total_answer ; i++){
            addElementConcept(i+1);
        }
    }
}

function resetQuestion(){
    $('table#tblResponseExam tbody').empty();
}

function openModal(){
    let total_answer_permit = parseInt($('input#txtResponseExamPermit').val());

    if ($('#txtResponseExamPermit').val() !== '' && total_answer_permit>0)
    {
        let total_answer = $('input#txtResponseExamPermit').val();
        generateQuestion(total_answer);

        $('#txtResponseExamPermit').prop('readonly', true);
        $('#modalAccess').modal('show');
    }else {
        warningNote('Advertencia', 'Ingrese un valor correcto para el n° de preguntas de la evaluación');
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
    let total_empty_response = 0;
    let status_response = false;
    let total_answer_table =  parseInt($('#tblResponseExam > tbody > tr').length);

    $('#tblResponseExam > tbody > tr').each((index, element) =>
    {
        let value_description = $($(element).find('> td > input[name="txtValueResponseExam[]"]')[0]).val();

        if (value_description !== '')
            total_empty_response++;
    });

    if (total_empty_response === total_answer_table)
        status_response = true;

    if (status_response)
        errorNote('No se pudo proceder', 'Registre al menos 1 respuesta en el cuestionario');

    return status_response;
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
