//目录树折叠按钮
function setTreeStyle(obj) {
	var objStyle = obj.children("b");
	var objList = obj.siblings("ul");
	if(objList.length == 1) {
		var style = objStyle.attr("class");
		objStyle.attr("class", "On2Off");
		setTimeout(
			function() {
				if(style == "Off") {
					objList.parent().siblings("li").children("span").children(".On").each(function() {
						setTreeStyle($(this).parent());
					});
					var H = objList.innerHeight()
					objList.css({
						display: "block",
						height: "0"
					});
					objList.animate({
						height: H
					}, 300, function() {
						$(this).css({
							height: "auto"
						});
					});
					objStyle.attr("class", "On");
				} else if(style == "On") {
					var H = objList.innerHeight()
					objList.animate({
						height: 0
					}, 300, function() {
						$(this).css({
							height: "auto",
							display: "none"
						})
					});
					objStyle.attr("class", "Off");
				}
			},
			40
		);
	}
}

//初始化时间
function initTimeWidget(obj) {
	var timestamp = (Date.parse(new Date())).toString();
	var timeInt = parseInt(timestamp.substring(0, 10));
	var i = 0;
	setSystemTime();
	setInterval(setSystemTime, 1000);

	function setSystemTime() {
		i++;
		obj.html(new Date((timeInt + i) * 1000).toString());
	}
}