'use strict';

var selectionMode = '';
$(function () {
    initExamListValidation();
    initExamListActions();
    if (typeof ajaxCrudBindPagination === 'function') {
        ajaxCrudBindPagination('divAjaxCrudList', function () {
            initExamListValidation();
            initExamListActions();
        });
    }
});

function initExamListValidation() {
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
}

function initExamListActions() {
    $('input[type="checkbox"][name="result[]"]').off('change.examList').on('change.examList', function () {
        var selected = $('input[type="checkbox"][name="result[]"]:checked');
        if (selected.length >= 2) {
            $('#downloadBtn').show();
        } else {
            $('#downloadBtn').hide();
        }
    });

    $('#downloadBtn').off('click.examList').on('click.examList', function () {
        var selectedValues = $('input[type="checkbox"][name="result[]"]:checked').map(function () {
            return this.value;
        }).get();

        $.ajax({
            url: $("#downloadUrl").val(),
            type: "POST",
            data: {
                _token: $("#csrf_token").val(),
                mode: 'checked',
                ids: selectedValues
            },
            success: function (response) {
                window.open(response.downloadUrl, '_blank');
            }
        });
    });
}

function initExamListAfterAjaxReload() {
    initExamListValidation();
    initExamListActions();
}

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

        if (typeof ajaxCrudLoadList === 'function') {
            ajaxCrudLoadList(url + '?searchParameter=' + encodeURIComponent(text), 'divAjaxCrudList', function () {
                initExamListValidation();
                initExamListActions();
            });

            return;
        }

        window.location.href = url + '?searchParameter=' + encodeURIComponent(text);
    }
}
