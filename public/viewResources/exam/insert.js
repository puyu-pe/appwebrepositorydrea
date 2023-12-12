'use strict';


$(function()
{
    $('#frmInsertExam').formValidation(objectValidate(
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
                },
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

    $('#dvExamResponse').formValidation(objectValidate(
    {
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

    var rowNumber=$('#tblResponseExam > tbody > tr').length+1;

    var htmlTemp=`<tr>
        <td class="text-center tblNumber">Pregunta `+rowNumber+`</td>
        <td>
            <input type="text" id="txtValueResponseExam`+rowNumber+`" name="txtValueResponseExam[]" value="`+$('#txtDescriptionResponse').val()+`" class="form-control" readonly>
        </td>
        <td class="text-center">
            <span class="btn btn-default btn-sm glyphicon glyphicon-remove" data-toggle="tooltip" title="Quitar" data-placement="left" onclick="removeTableRowResponse(this);"></span>
        </td>
    </tr>`;

    $('#tblResponseExam > tbody').append(htmlTemp);

    $('#txtDescriptionResponse').val('');

    $('[data-toggle="tooltip"]').tooltip();
}

function removeTableRowResponse(component)
{
    $(component).parent().parent().remove();

    $('#tblResponseExam > tbody > tr').each((index, element) =>
    {
        $($(element).find('> .tblNumber')[0]).text('Pregunta '+(index+1));
        $($(element).find('> td > input[name="txtValueResponseExam[]"]')[0]).attr('id', 'txtValueResponseExam'+(index+1));
    });
}

function confirmExam()
{
    var rowNumber=$('#tblResponseExam > tbody > tr').length;

    var result=false;

    if(rowNumber<1)
    {
      $('#dvExamExits').show();

      result=true;
    }
    else
    {
      $('#dvExamExits').hide();

      result=false;
    }

    return result;
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

    confirmDialogSend('frmInsertExam');
}
