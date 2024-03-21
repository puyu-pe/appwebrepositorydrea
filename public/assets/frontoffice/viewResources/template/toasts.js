function showToast(type, message) {
	const toast = drawToasts(type, message);
	const toastContainer = document.getElementById('notificationContainer');
	toastContainer.appendChild(toast);

	$(toast).toast('show');
}

function drawToasts(type, message) {
	const [color, title] = _getToastType(type);

	const toast = createElement("div", { class: 'toast hide mb-3', role: 'alert', 'aria-live': "assertive", 'aria-atomic': "true" });

	const header = createElement("div", { class: 'toast-header' });
	const span = createElement("span", { class: `btn btn-${color} ml-3 mr-3` });
	const toastTitle = createElement("strong", { class: 'mr-auto' });
	toastTitle.appendChild(document.createTextNode(title));

	header.appendChild(span);
	header.appendChild(toastTitle);

	const body = createElement("div", { class: "toast-body" });
	body.appendChild(document.createTextNode(message));

	toast.appendChild(header);
	toast.appendChild(body);

	return toast;
}

function _getToastType(type) {
	switch (type) {
		case "success":
			return ['success', 'CORRECTO'];
			break;

		case "warning":
			return ['warning', 'ADVERTENCIA'];
			break;

		case "error":
			return ['danger', 'ERROR'];
			break;

		default:
			return ['primary', 'MENSAJE'];
	}
}

const createElement = (tagName, attributes = {}) => {
	const element = document.createElement(tagName);
	Object.entries(attributes).forEach(([key, value]) => {
		element.setAttribute(key, value);
	});

	return element;
}