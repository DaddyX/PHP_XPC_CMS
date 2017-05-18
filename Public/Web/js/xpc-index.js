
/**
 * 初始化时间
 */
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