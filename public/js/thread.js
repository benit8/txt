let replyBox = $.qS('#replyBox');

// Reply ID clicking
let ids = $.qA('.reply > .infos > .id');
let ta = $.qS('#replyForm > [name=content]');
for (var i = 0; i < ids.length; i++) {
	ids[i].onclick = (e) => {
		e.preventDefault();

		replyBox.style.display = 'block';
		ta.value += `>>${e.target.innerText}\n`;
		ta.focus();
	};
}

// Hovering any quotelink
let quotelinks = $.qA('.quotelink');
for (var i = 0; i < quotelinks.length; i++) {
	quotelinks[i].onmouseover = (e) => {
		let href = e.target.getAttribute('href');
		if (href.match(/^#p([\d]+)$/))
			$.qS(href).classList.add('highlight');
	};

	quotelinks[i].onmouseout = (e) => {
		let href = e.target.getAttribute('href');
		if (href.match(/^#p([\d]+)$/))
			$.qS(href).classList.remove('highlight');
	};
}

// ReplyBox toggle button
$.qS('#RBToggler').onclick = (e) => {
	e.preventDefault();

	if (replyBox.style.display === 'none') {
		replyBox.style.display = 'block';
		e.target.innerText = 'Close';
	}
	else {
		replyBox.style.display = 'none';
		e.target.innerText = 'Reply';
	}
};

// ReplyBox close button
$.qS('#RBClose').onclick = (e) => {
	e.preventDefault();

	replyBox.style.display = 'none';
	$.qS('#RBToggler').innerText = 'Reply';
};

// ReplyBox dragging
$.qS('#replyBox > .header').onmousedown = (e) => {
	let saved = {};
	let pos = {x: 0, y: 0};

	let ondrag = (e) => {
		e.preventDefault();

		let diff = {
			x: pos.x - e.clientX,
			y: pos.y - e.clientY
		};

		replyBox.style.top = (replyBox.offsetTop - diff.y) + "px";
		replyBox.style.left = (replyBox.offsetLeft - diff.x) + "px";

		pos.x = e.clientX;
		pos.y = e.clientY;
	};

	let ondragend = () => {
		document.onmousemove = saved.onmousemove;
		document.onmouseup = saved.onmouseup;
	};

	e.preventDefault();

	pos.x = e.clientX;
	pos.y = e.clientY;

	saved.onmousemove = document.onmousemove;
	saved.onmouseup = document.onmouseup;
	document.onmousemove = ondrag;
	document.onmouseup = ondragend;
};

// ReplyForm handling
$.qS('#replyForm').onsubmit = (e) => {
	const processResponse = (raw) => {
		// Clear any previous error
		let controls = $.qA('#replyForm > [name]');
		for (let i = 0; i < controls.length; i++)
			controls[i].classList.remove('is-invalid');
		if ($.qS('#replyForm > .invalid-feedback'))
			$.qS('#replyForm > .invalid-feedback').remove();

		// Actual response processing
		let res = JSON.parse(raw);
		if (res.status == 'success') {
			document.location.reload();
		}

		// Create a feeback node
		let fb = document.createElement('div');
			fb.classList.add('invalid-feedback');
		$.qS('#replyForm').appendChild(fb);

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

	let content = $.qS('#replyForm > [name=content]').value;

	let data = new FormData();
	data.append('content', content);

	let xhr = new XMLHttpRequest();
	xhr.open('POST', '', true);
	xhr.onload = () => {
		if (xhr.readyState == 4 && xhr.status == 200)
			processResponse(xhr.responseText);
	};
	xhr.send(data);
};