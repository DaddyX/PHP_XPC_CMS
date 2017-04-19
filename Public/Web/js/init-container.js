var jumpHref = function(href, w) {
	if(href) {
		w = w || window;
		w.location.href = href;
	}
};

var showLayerMsg = function(content, settings) {
	content = content || '';
	var options = {
		shift: 5,
		time: 2000,
	};
	if(settings) {
		$.extend(options, settings);
	}
	if(options.topLayer == true && parent) {
		parent.layer.msg(content, options, function() {
			if(options.end) {
				options.end();
			}
		});
	} else {
		layer.msg(content, options, function() {
			if(options.end) {
				options.end();
			}
		});
	}
};