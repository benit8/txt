(function(){

	// Hovering any quotelink
	$.qA('.quotelink').forEach(function(quotelink) {
		quotelink.onmouseover = function(e) {
			let href = e.target.getAttribute('href');
			if (href.match(/^#p([\d]+)$/))
				$.qS(href).classList.add('highlight');
		};

		quotelink.onmouseout = function(e) {
			let href = e.target.getAttribute('href');
			if (href.match(/^#p([\d]+)$/))
				$.qS(href).classList.remove('highlight');
		};
	});

})();