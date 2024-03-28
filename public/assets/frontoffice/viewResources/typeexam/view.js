'use strict';
let inpSearchParameter,
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
                search: inpSearchParameter.value,
                type: slcTypes.value,
                grade: slcGrades.value,
                subject: slcSubjects.value,
                year: slcYears.value
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
                console.log(response);
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

function _getUrlSearch(url) {
    const searchParameter = inpSearchParameter.value;
    const typeExam = slcTypes.value;
    const grade = slcGrades.value;
    const subject = slcSubjects.value;
    const year = slcYears.value;
    return `${window.location.origin}/examen/buscar/1?searchParameter=${searchParameter}&type=${typeExam}&grade=${grade}&subject=${subject}&year=${year}`;
}

function _initElements() {
    inpSearchParameter = document.getElementById('txtSearch');
    slcTypes = document.getElementById('slcTypes');
    slcGrades = document.getElementById('slcGrades');
    slcSubjects = document.getElementById('slcSubjects');
    slcYears = document.getElementById('slcYears');

    _intiDefaultEvents();
}

function _intiDefaultEvents() {
    inpSearchParameter.addEventListener("keypress", function (event) {
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
