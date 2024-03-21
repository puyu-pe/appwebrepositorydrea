ratingStars = {};

document.addEventListener('DOMContentLoaded', () => {
	ratingStars._initElements();
	ratingStars._initEvents();
});

ratingStars._initElements = () => {
	ratingStars.elements = document.querySelectorAll('.rate-start');
	ratingStars._getDefaultClases();
}

ratingStars._initEvents = () => {
	(ratingStars.elements).forEach(star => {
		star.addEventListener('mouseover', function () {
			const value = this.dataset.value;
			ratingStars._setMouseOverStatusStar(value);
		});

		star.addEventListener('mouseout', ratingStars._setMouseOutStatusStar);

		star.addEventListener('click', function () {
			const value = this.dataset.value;
			ratingStars._insertRating(this, value);
		});
	});
}

ratingStars._getDefaultClases = () => {
	ratingStars.defaultClasses = [];

	(ratingStars.elements).forEach(star => {
		(ratingStars.defaultClasses).push(star.classList.value);
	});
}

ratingStars._getStarStates = (value) => {
	const selectedItems = [];
	const unselectedItems = [];

	(ratingStars.elements).forEach(star => {
		if (star.dataset.value <= value) {
			selectedItems.push(star);
		} else {
			unselectedItems.push(star);
		}
	});

	return [selectedItems, unselectedItems];
}

ratingStars._setMouseOverStatusStar = (value) => {
	const [selectedItems, unselectedItems] = ratingStars._getStarStates(value);

	selectedItems.forEach(selectedItem => {
		selectedItem.classList.value = 'fa-sharp fa-solid fa-star';
	});

	unselectedItems.forEach(unselectedItem => {
		unselectedItem.classList.value = 'fa-regular fa-star';
	});
}

ratingStars._setMouseOutStatusStar = () => {
	(ratingStars.elements).forEach((star, index) => {
		const defaultClass = (ratingStars.defaultClasses)[index];
		star.classList.value = defaultClass;
	});
}

ratingStars._insertRating = async (element, value) => {
	const token = document.querySelector('input[name="_token"]').value;
	const starContainer = element.closest('.rate-start-container');

	const data = {
		idExam: starContainer.dataset.idExam,
		rating: value
	}

	try {
		const promise = new Promise(function (resolve, reject) {
			fetch(`${window.location.origin}/examen/calificar`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': token
				},
				body: JSON.stringify(data)
			}).then(response => {
				if (!response.ok) { throw new Error('Error en la petición'); }
				return response.json();
			}).then(data => {
				resolve(data);
			}).catch(error => {
				reject(error);
			});
		});

		const response = await promise;
		debugger
	} catch (error) {
		debugger
	}
}