'use strict';
var inpSearchParameter,
    slcTypes,
    slcGrades,
    slcSubjects,
    slcYears;

var selectionStorageKey = '';
var selectionMode = '';
var downloadPreparationInFlight = false;
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

    setDownloadButtonBusyState(downloadPreparationInFlight);
}

function setDownloadButtonBusyState(isBusy) {
    var $button = $('#downloadBtn');

    $button.prop('disabled', isBusy);
    $button.attr('aria-busy', isBusy ? 'true' : 'false');
    $button.find('.download-label').text(isBusy ? 'Descargando archivos' : 'Descargar archivos');
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

    loadExamList(_getUrlSearch());
}

function _getUrlSearch() {
    const searchParameter = inpSearchParameter.val();
    const typeExam = slcTypes.val();
    const grade = slcGrades.val();
    const subject = slcSubjects.val();
    const year = slcYears.val();
    const acronym = $('#hdAcronymExam').val();
    return `${window.location.origin}/tipoexamen/${encodeURIComponent(acronym)}/listar?searchParameter=${encodeURIComponent(searchParameter)}&type=${encodeURIComponent(typeExam)}&grade=${encodeURIComponent(grade)}&subject=${encodeURIComponent(subject)}&year=${encodeURIComponent(year)}`;
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
            searchTypeExam();
        }
    });

    $('#btnSearchType').on('click', function (){
        searchTypeExam();
    });

    $('#divAjaxExamList').on('click', 'a', function (event) {
        var href = $(this).attr('href');

        if (!href || href.indexOf('/tipoexamen/') === -1) {
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
    $('.js-exam-select-all').off('change').on('change', function () {
        var isChecked = $(this).prop('checked');
        $('.js-exam-select').prop('checked', isChecked);
        if (isChecked) {
            savePersistedSelectionState({mode: 'all', ids: []});
        } else {
            clearPersistedSelections();
        }

        selectionMode = isChecked ? 'all' : '';
        checkDownloadButtonVisibility();
    });

    $('.js-exam-select').off('change').on('change', function () {
        var persistedState = getPersistedSelectionState();

        $('.js-exam-select-all').prop('checked', false);
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
        var originatingSelectionMode;
        var originatingSelectionStorageKey;

        if (downloadPreparationInFlight) {
            return;
        }

        originatingSelectionMode = selectionMode;
        originatingSelectionStorageKey = selectionStorageKey;

        if (originatingSelectionMode === 'all') {
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

        downloadPreparationInFlight = true;
        setDownloadButtonBusyState(true);
        requestAnimationFrame(function () {
            setTimeout(function () {
                prepareDownload(originatingSelectionMode, originatingSelectionStorageKey, selectedValues);
            }, 0);
        });
    });
}

function prepareDownload(originatingSelectionMode, originatingSelectionStorageKey, selectedValues) {
    $.ajax({
            url: $("#downloadUrl").val(),
            type: "POST",
            data: {
                _token: $("#csrf_token").val(),
                mode: originatingSelectionMode === 'all' ? 'all' : 'checked',
                ids: selectedValues
            },
            success: function (response) {
                if (!initiateDownload(response.downloadUrl)) {
                    return;
                }

                clearPersistedSelections(originatingSelectionStorageKey);
                if (selectionStorageKey === originatingSelectionStorageKey) {
                    rehydrateSelections();
                }
            },
            error: function () {
                restoreDownloadButtonState(originatingSelectionStorageKey);
            },
            complete: function () {
                restoreDownloadButtonState(originatingSelectionStorageKey);
            }
    });
}

function initiateDownload(downloadUrl) {
    var iframe;

    if (!downloadUrl) {
        return false;
    }

    try {
        iframe = document.createElement('iframe');
        iframe.name = 'frontoffice-download-frame';
        iframe.style.display = 'none';
        iframe.src = downloadUrl;
        document.body.appendChild(iframe);
        window.setTimeout(function () {
            if (iframe.parentNode) {
                iframe.parentNode.removeChild(iframe);
            }
        }, 300000);
        return true;
    } catch (error) {
        return false;
    }
}

function restoreDownloadButtonState(originatingSelectionStorageKey) {
    downloadPreparationInFlight = false;
    if (selectionStorageKey === originatingSelectionStorageKey) {
        rehydrateSelections();
    } else {
        setDownloadButtonBusyState(false);
    }
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

function clearPersistedSelections(storageKey) {
    try {
        sessionStorage.setItem(storageKey || selectionStorageKey, JSON.stringify({mode: '', ids: []}));
    } catch (error) {
    }
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

    $('.js-exam-select').each(function () {
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

    $('.js-exam-select').each(function () {
        $(this).prop('checked', isAllMode || persistedSelections.indexOf(String(this.value)) !== -1);
    });

    $('.js-exam-select-all').prop('checked', isAllMode);
    selectionMode = resolveSelectionMode();
    checkDownloadButtonVisibility();
}
