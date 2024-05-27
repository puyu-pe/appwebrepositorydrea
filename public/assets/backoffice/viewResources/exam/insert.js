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

    $('select#selectTypeExam').on('change', function (e)
    {
        let selectedOption = $(this).find('option:selected');
        let acronym = selectedOption.attr('type_evaluation');

        showDivNameOtherExam(acronym);
    });

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
    $('.select2TypeAnswerExam').select2(
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
        placeholder: 'Agregue alternativas a usar...'
    });
});


function showDivNameOtherExam (acronym)
{
    if (acronym === 'other'){
        $('div#dvOther').show();
        $('input#txtDescriptionOtherEvaluation').val('');
    }else {
        $('div#dvOther').hide();
        $('input#txtDescriptionOtherEvaluation').val('');
    }
}

function addElementConcept(number, alternative) {
    var htmlTemp;

    if (alternative !== null) {
        // Crear el select con las opciones
        var selectOptions = '<option value="" disabled selected>Seleccione...</option>';
        for (var i = 0; i < alternative.length; i++) {
            selectOptions += '<option value="' + alternative[i] + '">' + alternative[i] + '</option>';
        }

        htmlTemp = `
            <tr>
                <td class="text-center tblNumber">
                    <div>${number}</div>
                </td>
                <td>
                    <select id="txtValueResponseExam${number}" name="txtValueResponseExam[]" class="form-control" form="frmInsertExam">
                        ${selectOptions}
                    </select>
                </td>
            </tr>
        `;
    } else {
        // Crear el input como en el código original
        htmlTemp = `
            <tr>
                <td class="text-center tblNumber">
                    <div>${number}</div>
                </td>
                <td>
                    <input type="text" id="txtValueResponseExam${number}" name="txtValueResponseExam[]" class="form-control" value="" form="frmInsertExam">
                </td>
            </tr>
        `;
    }

    $('#tblResponseExam > tbody').append(htmlTemp);
}

function showButtonResponse(value)
{
    if (value === '1'){
        $('#txtResponseExamPermit').prop('readonly', false);
        $('#selectTypeAnswerExam').prop('disabled', false);
        $('#txtResponseExamPermit').val('');
        $('#selectTypeAnswerExam').empty();
        $('#btnModalResponse').show();
    }else{
        resetQuestion();
        $('#txtResponseExamPermit').prop('readonly', true);
        $('#selectTypeAnswerExam').prop('disabled', true);
        $('#txtResponseExamPermit').val('');
        $('#selectTypeAnswerExam').empty();
        $('#btnModalResponse').hide();
    }
}

function generateQuestion(total, data){
    let total_answer = parseInt(total);
    let total_answer_table =  parseInt($('#tblResponseExam > tbody > tr').length);

    if (total_answer !== total_answer_table){
        for (let i= 0; i< total_answer ; i++){
            addElementConcept(i+1, data);
        }
    }
}

function resetQuestion(){
    $('table#tblResponseExam tbody').empty();
}

function openModal(){
    let total_answer_permit = parseInt($('input#txtResponseExamPermit').val());
    let value_answer = getSelectedValues();

    if (value_answer !== null && value_answer.length <= 1){
        warningNote('Advertencia', 'Ingrese al menos 2 alternativas');
        return false;
    }

    if ($('#txtResponseExamPermit').val() !== '' && total_answer_permit>0)
    {
        let total_answer = $('input#txtResponseExamPermit').val();
        generateQuestion(total_answer, value_answer);

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

function validateNotEmptyResponse() {
    let total_empty_response = 0;
    let status_response = false;
    $('#tblResponseExam > tbody > tr').each((index, element) => {
        let $inputOrSelect = $(element).find('> td > input[name="txtValueResponseExam[]"], > td > select[name="txtValueResponseExam[]"]');

        if ($inputOrSelect.length > 0) {
            if ($inputOrSelect.is('input')) {
                let value_description = $inputOrSelect.val();
                if (value_description === '') {
                    total_empty_response++;
                }
            } else if ($inputOrSelect.is('select')) {
                let selected_option = $inputOrSelect.find('option:selected').val();
                if (!selected_option || selected_option === '') {
                    total_empty_response++;
                }
            }
        }
    });

    if (total_empty_response > 0) {
        status_response = true;
        errorNote('No se pudo proceder', 'Se debe registrar todas las alternativas');
    }

    return status_response;
}

function verify_select_other()
{
    let acronym = $('select#selectTypeExam').find('option:selected').attr('type_evaluation');
    let name_other_exam = $('input#txtDescriptionOtherEvaluation').val();

    if (acronym === 'other' && name_other_exam === ''){
        errorNote('No se pudo proceder', 'Ingrese el nombre de la evaluación');
        return true;
    }

    return false;
}

function getSelectedValues() {
    const selectTypeAnswerExam = document.getElementById('selectTypeAnswerExam');
    const selectedValues = Array.from(selectTypeAnswerExam.selectedOptions).map(option => option.value);
    return selectedValues.length > 0 ? selectedValues : null;
}

function sendInsertExam()
{
    var isValid=null;

    $('#frmInsertExam').data('formValidation').resetForm();
    $('#frmInsertExam').data('formValidation').validate();

    isValid=$('#frmInsertExam').data('formValidation').isValid();

    if (verify_select_other())
        return;

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
