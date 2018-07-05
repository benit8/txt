let rows = $.qA('tr[href]');
for (let i = 0; i < rows.length; i++) {
	rows[i].onclick = (e) => {
		let el = e.target;
		while (el.tagName !== 'TR')
			el = el.parentNode;

		document.location = el.getAttribute('href');
	};
}

$.qS('#threadFormToggler').onclick = (e) => {
	e.preventDefault();

	let container = $.qS('#threadFormContainer');
	if (container.style.display === "none") {
		container.style.display = "block";
		$.qS('#threadFormToggler').innerText = "Close";
	}
	else {
		container.style.display = "none";
		$.qS('#threadFormToggler').innerText = "Start a new thread";
	}
};

$.qS('#threadForm').onsubmit = (e) => {
	const processResponse = (raw) => {
		// Clear any previous error
		let controls = $.qA('#threadForm > [name]');
		for (let i = 0; i < controls.length; i++)
			controls[i].classList.remove('is-invalid');
		if ($.qS('#threadForm > div.invalid-feedback'))
			$.qS('#threadForm > div.invalid-feedback').remove();

		// Actual response processing
		let res = JSON.parse(raw);
		if (res.status == 'success')
			document.location.reload();

		// Create a feeback node
		let fb = document.createElement('div');
			fb.classList.add('invalid-feedback');
		$.qS('#threadForm').appendChild(fb);

		// a list node for the feeback
		let ul = document.createElement('ul');
		fb.appendChild(ul);

		// for each fields that has errors
		for (let e in res.errors) {
			// highlight it
			if (e !== '')
				$.qS(`[name=${e}]`).classList.add('is-invalid');

			// add the error string to the feedback
			let li = document.createElement('li');
				li.innerText = res.errors[e];
			ul.appendChild(li);
		}
	};


	e.preventDefault();

	let subject = $.qS('#threadForm > input[name=subject]').value;
	let content = $.qS('#threadForm > textarea[name=content]').value;

	let data = new FormData();
	data.append('subject', subject);
	data.append('content', content);

	let xhr = new XMLHttpRequest();
	xhr.open('POST', '', true);
	xhr.onload = () => {
		if (xhr.readyState == 4 && xhr.status == 200)
			processResponse(xhr.responseText);
	};
	xhr.send(data);
};