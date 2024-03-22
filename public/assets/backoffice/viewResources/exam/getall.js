'use strict';

$(function () {
    $('#divSearch').formValidation(objectValidate(
        {
            txtSearch:
                {
                    validators:
                        {
                            regexp:
                                {
                                    message: '<b style="color: red;">Solo se permite texto y números.</b>',
                                    regexp: /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚàèìòùÀÈÌÒÙ\s@\.\-_]*$/
                                }
                        }
                }
        })
    );

    $('input[type="checkbox"][name="result[]"]').change(function () {
        var selected = $('input[type="checkbox"][name="result[]"]:checked');
        if (selected.length >= 2) {
            $('#downloadBtn').show();
        } else {
            $('#downloadBtn').hide();
        }
    });

    $('#downloadBtn').click(function () {
        var selectedValues = $('input[type="checkbox"][name="result[]"]:checked').map(function () {
            return this.value;
        }).get();

        $.ajax({
            url: $("#downloadUrl").val(),
            type: "POST",
            data: {
                _token: $("#csrf_token").val(),
                ids: selectedValues
            },
            success: function (response) {
                console.log(response);
                window.open(response.downloadUrl, '_blank');
            }
        });
    });
});

function searchExam(text, url, event) {
    var evt = event || window.event;

    var code = evt.charCode || evt.keyCode || evt.which;

    if (code == 13) {
        var isValid = null;

        $('#divSearch').data('formValidation').resetForm();
        $('#divSearch').data('formValidation').validate();

        isValid = $('#divSearch').data('formValidation').isValid();

        if (!isValid) {
            incorrectNote();

            return;
        }

        $('#modalLoading').show();

        $('#txtSearch').attr('disabled', 'disabled');

        window.location.href = url + '?searchParameter=' + text;
    }
}


