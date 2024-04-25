'use strict';

function validateNotEmptyResponse(){
    let total_not_empty_response = 0;
    let status_response = false;

    $('#tblResponseExam > tbody > tr').each((index, element) =>
    {
        let value_description = $($(element).find('> td > input[name="txtValueResponseExam[]"]')[0]).val();

        if (value_description !== '')
            total_not_empty_response++;
    });

    if (total_not_empty_response === 0)
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
