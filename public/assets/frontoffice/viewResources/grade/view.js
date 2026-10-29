'use strict';
var inpSearchParameter,
    slcTypes,
    slcGrades,
    slcSubjects,
    slcYears;

var selectionStorageKey = '';
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


    _initElements();
});

function checkDownloadButtonVisibility() {
    var persistedState = getPersistedSelectionState();
    var selectedCount = persistedState.ids.length;

    if (selectionMode === 'all' || selectedCount >= 2) {
        $('#downloadBtn').show();
    } else {
        $('#downloadBtn').hide();
    }
}

function searchGradeExam() {
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

    loadExamList(_getUrlSearch());
}

function _getUrlSearch() {
    const searchParameter = inpSearchParameter.val();
    const typeExam = slcTypes.val();
    const grade = slcGrades.val();
    const subject = slcSubjects.val();
    const year = slcYears.val();
    const code = $('#hdCodeGrade').val();
    return `${window.location.origin}/grado/${encodeURIComponent(code)}/listar?searchParameter=${encodeURIComponent(searchParameter)}&type=${encodeURIComponent(typeExam)}&grade=${encodeURIComponent(grade)}&subject=${encodeURIComponent(subject)}&year=${encodeURIComponent(year)}`;
}

function _initElements() {
    inpSearchParameter = $('#txtSearch');
    slcTypes = $('#slcTypes');
    slcGrades = $('#slcGrades');
    slcSubjects = $('#slcSubjects');
    slcYears = $('#slcYears');
    selectionStorageKey = buildSelectionStorageKey();

    initializeSelectionEvents();
    _intiDefaultEvents();
    rehydrateSelections();
}

function _intiDefaultEvents() {
    inpSearchParameter.on("keypress", function (event) {
        if (event.key === "Enter") {
            searchGradeExam();
        }
    });

    $('#btnSearchGrade').on('click', function (){
        searchGradeExam();
    });

    $('#divAjaxExamList').on('click', 'a', function (event) {
        var href = $(this).attr('href');

        if (!href || href.indexOf('/grado/') === -1) {
            return;
        }

        event.preventDefault();
        loadExamList(href);
    });

    $(window).on('popstate', function () {
        restoreFiltersFromLocation();
        loadExamList(window.location.href, false);
    });
}

function loadExamList(url, updateHistory) {
    $('#modalLoading').show();

    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            $('#divAjaxExamList').html(response);
            if (updateHistory !== false) {
                window.history.pushState({}, '', url);
            }
            selectionStorageKey = buildSelectionStorageKey();
            initializeSelectionEvents();
            rehydrateSelections();
            $('#txtSearch').removeAttr('disabled');
            $('#modalLoading').hide();
        },
        error: function () {
            window.location.href = url;
        }
    });
}

function restoreFiltersFromLocation() {
    var parameters = new URLSearchParams(window.location.search);

    inpSearchParameter.val(parameters.get('searchParameter') || '');
    slcTypes.val(parameters.get('type') || 'all');
    slcGrades.val(parameters.get('grade') || 'all');
    slcSubjects.val(parameters.get('subject') || 'all');
    slcYears.val(parameters.get('year') || 'all');
}

function initializeSelectionEvents() {
    $('#selectAll').off('change').on('change', function () {
        var isChecked = $(this).prop('checked');
        $('input[type="checkbox"][name="result[]"]').prop('checked', isChecked);
        if (isChecked) {
            savePersistedSelectionState({mode: 'all', ids: []});
        } else {
            clearPersistedSelections();
        }

        selectionMode = isChecked ? 'all' : '';
        checkDownloadButtonVisibility();
    });

    $('input[type="checkbox"][name="result[]"]').off('change').on('change', function () {
        var persistedState = getPersistedSelectionState();

        $('#selectAll').prop('checked', false);
        if (persistedState.mode === 'all') {
            persistVisibleCheckedSelections();
        } else {
            syncSelection(this.value, $(this).prop('checked'));
        }

        selectionMode = resolveSelectionMode();
        checkDownloadButtonVisibility();
    });

    $('#downloadBtn').off('click').on('click', function () {
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
            selectedValues = getPersistedSelections();
        }

        $.ajax({
            url: $("#downloadUrl").val(),
            type: "POST",
            data: {
                _token: $("#csrf_token").val(),
                mode: selectionMode === 'all' ? 'all' : 'checked',
                ids: selectedValues
            },
            success: function (response) {
                window.open(response.downloadUrl, '_blank');
            }
        });
    });
}

function buildSelectionStorageKey() {
    var normalizedPath = window.location.pathname.replace(/\/+$/, '').replace(/\/\d+$/, '');
    return 'frontoffice-download-selection:' + normalizedPath + ':' + buildFilterContextKey();
}

function buildFilterContextKey() {
    return [
        normalizeFilterContextValue(inpSearchParameter.val()),
        normalizeFilterContextValue(slcTypes.val()),
        normalizeFilterContextValue(slcGrades.val()),
        normalizeFilterContextValue(slcSubjects.val()),
        normalizeFilterContextValue(slcYears.val())
    ].join('|');
}

function normalizeFilterContextValue(value) {
    if (value === undefined || value === null || value === '') {
        return 'all';
    }

    return String(value);
}

function getPersistedSelectionState() {
    try {
        var rawState = sessionStorage.getItem(selectionStorageKey);
        var parsedState = JSON.parse(rawState || '[]');

        if (Array.isArray(parsedState)) {
            var legacyIds = normalizeSelectionIds(parsedState);

            return {
                mode: legacyIds.length > 0 ? 'checked' : '',
                ids: legacyIds
            };
        }

        if (!parsedState || typeof parsedState !== 'object') {
            return {
                mode: '',
                ids: []
            };
        }

        var normalizedIds = normalizeSelectionIds(parsedState.ids);

        return {
            mode: parsedState.mode === 'all' ? 'all' : (normalizedIds.length > 0 ? 'checked' : ''),
            ids: normalizedIds
        };
    } catch (error) {
        return {
            mode: '',
            ids: []
        };
    }
}

function normalizeSelectionIds(selectionIds) {
    if (!Array.isArray(selectionIds)) {
        return [];
    }

    return selectionIds.map(function (item) {
        return String(item);
    }).filter(function (item, index, array) {
        return item !== '' && array.indexOf(item) === index;
    });
}

function getPersistedSelections() {
    return getPersistedSelectionState().ids;
}

function savePersistedSelectionState(state) {
    try {
        var normalizedIds = normalizeSelectionIds(state.ids);

        sessionStorage.setItem(selectionStorageKey, JSON.stringify({
            mode: state.mode === 'all' ? 'all' : (normalizedIds.length > 0 ? 'checked' : ''),
            ids: normalizedIds
        }));
    } catch (error) {
    }
}

function clearPersistedSelections() {
    savePersistedSelectionState({mode: '', ids: []});
}

function syncSelection(selectionId, isSelected) {
    var currentSelections = getPersistedSelections().slice();
    var normalizedSelectionId = String(selectionId);

    if (isSelected) {
        if (currentSelections.indexOf(normalizedSelectionId) === -1) {
            currentSelections.push(normalizedSelectionId);
        }
    } else {
        currentSelections = currentSelections.filter(function (item) {
            return item !== normalizedSelectionId;
        });
    }

    savePersistedSelectionState({
        mode: currentSelections.length > 0 ? 'checked' : '',
        ids: currentSelections
    });
}

function persistVisibleCheckedSelections() {
    var visibleSelections = [];

    $('input[type="checkbox"][name="result[]"]').each(function () {
        if ($(this).prop('checked')) {
            visibleSelections.push(this.value);
        }
    });

    savePersistedSelectionState({
        mode: visibleSelections.length > 0 ? 'checked' : '',
        ids: visibleSelections
    });
}

function resolveSelectionMode() {
    var persistedState = getPersistedSelectionState();

    return persistedState.mode === 'all' ? 'all' : (persistedState.ids.length > 0 ? 'checked' : '');
}

function rehydrateSelections() {
    var persistedState = getPersistedSelectionState();
    var persistedSelections = persistedState.ids;
    var isAllMode = persistedState.mode === 'all';

    $('input[type="checkbox"][name="result[]"]').each(function () {
        $(this).prop('checked', isAllMode || persistedSelections.indexOf(String(this.value)) !== -1);
    });

    $('#selectAll').prop('checked', isAllMode);
    selectionMode = resolveSelectionMode();
    checkDownloadButtonVisibility();
}
