ratingStars = {};
ratingStars.qualified = false;

document.addEventListener('DOMContentLoaded', () => {
	ratingStars._initElements();
	ratingStars._initEvents();
});

ratingStars._initElements = () => {
	ratingStars.elements = document.querySelectorAll('.rate-start');
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

	ratingStars.qualified = false;
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
	ratingStars._getDefaultClases();
	const [selectedItems, unselectedItems] = ratingStars._getStarStates(value);

	selectedItems.forEach(selectedItem => {
		selectedItem.classList.value = 'fa-sharp fa-solid fa-star';
	});

	unselectedItems.forEach(unselectedItem => {
		unselectedItem.classList.value = 'fa-regular fa-star';
	});
}

ratingStars._setMouseOutStatusStar = () => {
	if (!ratingStars.qualified) {
		(ratingStars.elements).forEach((star, index) => {
			const defaultClass = (ratingStars.defaultClasses)[index];
			star.classList.value = defaultClass;
		});
	}
}

ratingStars._insertRating = async (element, value) => {
	const token = document.querySelector('input[name="_token"]').value;
	const starContainer = element.closest('.rate-start-container');

	const data = {
		idExam: starContainer.dataset.idExam,
		rating: value
	}

	try {
		const response = await fetch(`${window.location.origin}/examen/calificar`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': token
			},
			body: JSON.stringify(data)
		});

		if (!response.ok) {
			const errorMessage = (JSON.parse(await response.text())).message;
			throw new Error(errorMessage);
		}

		const responseData = await response.json();
		const rating = responseData.data.rating;

		ratingStars._updateRating(rating.avg, rating.count);
		successNote('Exito', responseData.message);
		ratingStars.qualified = true;
	} catch (error) {
		errorNote('Error', error.message);
	}

}

ratingStars._updateRating = (avg, count) => {
	(ratingStars.elements).forEach((star, index) => {
		const value = star.dataset.value;

		if (value <= parseFloat(avg)) {
			star.classList.value = "fa-sharp fa-solid fa-star rate-start";
		} else {
			star.classList.value = "fa-regular fa-star rate-start";
		}
	});

	const avgContainer = document.querySelector('.avgContainer');
	avgContainer.textContent = '';
	avgContainer.appendChild(document.createTextNode(`(${avg})`));

	const spanRatingCount = document.querySelector('.spanRatingCount');
	if (spanRatingCount) {
		spanRatingCount.textContent = '';
		spanRatingCount.appendChild(document.createTextNode(`${count} calificaciónes`));
	}
}