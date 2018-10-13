(function() {

	let replyBox = $.qS('#replyBox');
	if (!replyBox)
		return;

	let textarea = $.qS('#replyForm > [name=content]');
	let rbToggler = $.qS('#RBToggler');
	let rbClose = $.qS('#RBClose');

	// Reply ID clicking
	$.qA('.reply > .infos > .id').forEach(function(id) {
		id.onclick = function(e) {
			e.preventDefault();

			replyBox.style.display = 'block';
			textarea.value += `>>${e.target.innerText}\n`;
			textarea.focus();
		};
	});

	// ReplyBox toggle button
	rbToggler.onclick = function(e) {
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
	rbClose.onclick = function(e) {
		e.preventDefault();

		replyBox.style.display = 'none';
		textarea.value = '';
		rbToggler.innerText = 'Reply';
	};

	// ReplyBox dragging
	$.qS('#replyBox > .header').onmousedown = function(e) {
		let saved = {};
		let pos = {x: 0, y: 0};

		let ondrag = function(e) {
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

		let ondragend = function() {
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
	$.qS('#replyForm').onsubmit = function(e) {
		const processResponse = function(raw) {
			// Clear any previous error
			$.qA('#replyForm > [name]').forEach(function(control) {
				control.classList.remove('is-invalid');
			});

			let feedback = $.qS('#replyForm > .invalid-feedback');
			if (feedback)
				feedback.remove();

			// Actual response processing
			let res = JSON.parse(raw);
			if (res.status == 'success') {
				document.location.reload();
			}

			// Create a feeback node
			let feebackNode = document.createElement('div');
				feebackNode.classList.add('invalid-feedback');
			$.qS('#replyForm').appendChild(feebackNode);

			// a list node for the feeback
			let ul = document.createElement('ul');
			feebackNode.appendChild(ul);

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

		let data = new FormData();
		data.append('content', textarea.value);

		let xhr = new XMLHttpRequest();
		xhr.open('POST', '', true);
		xhr.onload = function() {
			if (xhr.readyState == 4 && xhr.status == 200)
				processResponse(xhr.responseText);
		};
		xhr.send(data);
	};

})();