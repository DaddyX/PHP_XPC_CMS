/**
 * 重写时间格式化方法
 */
Date.prototype.toString = function() {
	return this.getFullYear() +
		"-" + (this.getMonth() > 8 ? (this.getMonth() + 1) : "0" + (this.getMonth() + 1)) +
		"-" + (this.getDate() > 9 ? this.getDate() : "0" + this.getDate()) +
		" " + (this.getHours() > 9 ? this.getHours() : "0" + this.getHours()) +
		":" + (this.getMinutes() > 9 ? this.getMinutes() : "0" + this.getMinutes()) +
		":" + (this.getSeconds() > 9 ? this.getSeconds() : "0" + this.getSeconds());
}
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