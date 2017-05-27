var jumpHref = function(href, w) {
	if(href) {
		w = w || window;
		w.location.href = href;
	}
};