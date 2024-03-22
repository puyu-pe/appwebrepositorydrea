'use strict';
let inpSearchParameter,
	slcGrades,
	slcSubjects,
	slcYears;

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
	const typeExam = inpSearchParameter.dataset.typeexam;
	const searchParameter = inpSearchParameter.value;
	const grade = slcGrades.value;
	const subject = slcSubjects.value;
	const year = slcYears.value;
	return `${window.location.origin}/tipoexamen/${typeExam}/1?searchParameter=${searchParameter}&grade=${grade}&subject=${subject}&year=${year}`;
}

function _initElements() {
	inpSearchParameter = document.getElementById('txtSearch');
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
