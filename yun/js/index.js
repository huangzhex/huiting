
var setting = {
	data: {
		simpleData: {
			enable: true
		}
	},
	async: {
		enable: true,
		url:"http://www.huitingweb.top/WeiXin/index.php/DB"
	}
};
$(document).ready(function(){
	$.fn.zTree.init($("#fileTree"), setting);
});