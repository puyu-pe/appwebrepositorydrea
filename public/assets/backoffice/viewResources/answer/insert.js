'use strict';

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

function sendInsertAnswer()
{
    if (validateNotEmptyResponse()){
        return;
    }

    confirmDialogSend('frmInsertAnswer');
}
