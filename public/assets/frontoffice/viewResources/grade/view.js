'use strict';
var inpSearchParameter,
    slcTypes,
    slcGrades,
    slcSubjects,
    slcYears;

var selectionMode = '';
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
        }
    ));


    $('#selectAll').change(function () {
        var isChecked = $(this).prop('checked');
        $('input[type="checkbox"][name="result[]"]').prop('checked', isChecked);
        checkDownloadButtonVisibility();
        selectionMode = isChecked ? 'all' : '';
    });

    $('input[type="checkbox"][name="result[]"]').change(function () {
        $('#selectAll').prop('checked', false);
        checkDownloadButtonVisibility();
        selectionMode = 'checked';
    });

    $('#downloadBtn').click(function () {
        var selectedValues;
        if (selectionMode === 'all') {
            selectedValues = {
                search: inpSearchParameter.val(),
                type: slcTypes.val(),
                grade: slcGrades.val(),
                subject: slcSubjects.val(),
                year: slcYears.val()
            };
        } else {
            selectedValues = $('input[type="checkbox"][name="result[]"]:checked').map(function () {
                return this.value;
            }).get();
        }

        $.ajax({
            url: $("#downloadUrl").val(),
            type: "POST",
            data: {
                _token: $("#csrf_token").val(),
                mode: selectionMode,
                ids: selectedValues
            },
            success: function (response) {
                window.open(response.downloadUrl, '_blank');
            }
        });
    });

    _initElements();
});

function checkDownloadButtonVisibility() {
    var selected = $('input[type="checkbox"][name="result[]"]:checked');
    if (selected.length >= 2) {
        $('#downloadBtn').show();
    } else {
        $('#downloadBtn').hide();
    }
}

function searchTypeExam() {
    let isValid = null;

    $('#divSearch').data('formValidation').resetForm();
    $('#divSearch').data('formValidation').validate();

    isValid = $('#divSearch').data('formValidation').isValid();

    if (!isValid) {
        incorrectNote();

        return;
    }

    $('#modalLoading').show();

    $('#txtSearch').attr('disabled', 'disabled');

    window.location.href = _getUrlSearch();
}

function _getUrlSearch() {
    const searchParameter = inpSearchParameter.val();
    const typeExam = slcTypes.val();
    const grade = slcGrades.val();
    const subject = slcSubjects.val();
    const year = slcYears.val();
    const code = $('#hdCodeGrade').val();
    return `${window.location.origin}/grado/${code}/1?searchParameter=${searchParameter}&type=${typeExam}&grade=${grade}&subject=${subject}&year=${year}`;
}

function _initElements() {
    inpSearchParameter = $('#txtSearch');
    slcTypes = $('#slcTypes');
    slcGrades = $('#slcGrades');
    slcSubjects = $('#slcSubjects');
    slcYears = $('#slcYears');

    _intiDefaultEvents();
}

function _intiDefaultEvents() {
    inpSearchParameter.on("keypress", function (event) {
        if (event.key === "Enter") {
            searchTypeExam();
        }
    });

    $(slcTypes).on('change', function () {
        searchTypeExam();
    });
    $(slcGrades).on('change', function () {
        searchTypeExam();
    });

    $(slcSubjects).on('change', function () {
        searchTypeExam();
    });

    $(slcYears).on('change', function () {
        searchTypeExam();
    });
}
