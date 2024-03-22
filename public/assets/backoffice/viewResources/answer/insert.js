'use strict';

$(function()
{
    $('#dvRegisterData').formValidation(objectValidate(
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
});

function addElementConcept()
{
    var isValid=null;

    $('#dvRegisterData').data('formValidation').resetForm();
    $('#dvRegisterData').data('formValidation').validate();

    isValid=$('#dvRegisterData').data('formValidation').isValid();

    if(!isValid) {
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
            <input type="hidden" id="hdIdAnswer`+rowNumber+`" name="hdIdAnswer[]">
            <td class="text-center">
                <input type="number" id="numberValueExam`+rowNumber+`" name="numberValueExam[]" min="1" value="`+number_question+`" class="form-control" readonly>
            </td>
            <td>
                <input type="text" id="txtValueResponseExam`+rowNumber+`" name="txtValueResponseExam[]" value="`+$('#txtDescriptionResponse').val()+`" class="form-control">
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

function removeTableRowResponse(component) {
    $(component).parent().parent().remove();

    $('#tblResponseExam > tbody > tr').each((index, element) =>
    {
        $($(element).find('> td > input[name="numberValueExam[]"]')[0]).attr('id', 'numberValueExam'+(index+1));
        $($(element).find('> td > input[name="txtValueResponseExam[]"]')[0]).attr('id', 'txtValueResponseExam'+(index+1));
        $($(element).find('> input[name="hdIdAnswer[]"]')([0])).attr('id', 'hdIdAnswer'+(index+1));
    });
}

function confirmExam(number) {
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

function validateTotalResponse() {
    let status = false;
    let total = parseInt($('#hdTotalAnswer').val());
    let rowNumber=$('#tblResponseExam > tbody > tr').length+1;

    if (rowNumber>total){
        errorNote('Error', 'Solo se permite ingresar un total de ' + total + (total> 1 ? ' respuestas' : ' respuesta'));
        status = true;
    }
    return status;
}

function validateRegisterResponse(){
    let status = false;
    let rowNumber=$('#tblResponseExam > tbody > tr').length;

    if (rowNumber <= 0){
        errorNote('No se pudo proceder', 'Debe registrar al menos 1 respuesta');
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

function sendInsertAnswer()
{
    if(validateRegisterResponse()){
        return;
    }

    if (validateNotEmptyResponse()){
        return;
    }

    confirmDialogSend('frmInsertAnswer');
}
