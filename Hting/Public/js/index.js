$(document).ready(function(){
    if($(".fixedMenu")!=null){
		$(".fixedMenu").smartFloat();
	}
	//去除顶级菜单右侧的竖线
	$('.ht_menu_right .line').last().remove();
	panelBox();
});
//右侧导航菜单
function panelBox(){
	var Top=$('.p_backtop');
	$(window).scroll(function(){
		if($(window).scrollTop()>100){
			Top.fadeIn();
		}else{
			Top.fadeOut();
		}
	});
	Top.click(function(){
		$('html,body').animate({scrollTop:0},600);
	});
	$('.pl_weixin').hover(function(){
		$(this).find(".plewm_box").show();
	},
	function(){
		$(this).find(".plewm_box").hide();
	});
}
function index(){
	//调用轮播图片
     $(".banner").luara({width:"680",height:"278",interval:4500,selected:"seleted",deriction:"left"});
	 //公告
	 $(".newtitle1").mousemove(function(){
		$(this).addClass("news_active");
		$(".newtitle2").removeClass("news_active");
		$(".newone").css("display","block");
		$(".newtwo").css("display","none");
	});
	$(".newtitle2").mousemove(function(){
		$(this).addClass("news_active");
		$(".newtitle1").removeClass("news_active");
		$(".newone").css("display","none");
		$(".newtwo").css("display","block");
	});
	 //首菜单选中状态
	$('.nav_list a:first').addClass("active");
}

/***列表页面**/
//切换视图模式
function convertView(btn){
	$(btn).toggleClass("view");//background-image
	$("[name='context']").slideToggle(1000)//.toggleClass("hide");
	$(".name").toggleClass("hideName");
	var descShow=Cookies.get('descShow');
	if(descShow=="hide"){
		Cookies.set('descShow', 'show');
	}else{
		Cookies.set('descShow', 'hide');
	}
}
//初始化
function initDesc(){
	//视图显示模式
	var descShow=Cookies.get('descShow');
	if(descShow=="hide"){
		if($("#view")!=null){
			$("#view").toggleClass("view");
			$("[name='context']").toggleClass("hide");
			$(".name").toggleClass("hideName");
		}
	}
}
//滚动固定
$.fn.smartFloat = function() { 
    var position = function(element) { 
        var top = element.position().top; //当前元素对象element距离浏览器上边缘的距离 
        var pos = element.css("position"); //当前元素距离页面document顶部的距离 
        $(window).scroll(function() { //侦听滚动时 
            var scrolls = $(this).scrollTop(); 
            if (scrolls > top) { //如果滚动到页面超出了当前元素element的相对页面顶部的高度 
                if (window.XMLHttpRequest) { //如果不是ie6 
                    element.css({ //设置css 
                        position: "fixed", //固定定位,即不再跟随滚动 
                        top: 0 //距离页面顶部为0 
                    }).addClass("shadow"); //加上阴影样式.shadow 
                } else { //如果是ie6 
                    element.css({ 
                        top: scrolls  //与页面顶部距离 
                    });     
                } 
            }else { 
                element.css({ //如果当前元素element未滚动到浏览器上边缘，则使用默认样式 
                    position: pos, 
                    top: top
                }).removeClass("shadow");//移除阴影样式.shadow 
            } 
        }); 
    }; 
    return $(this).each(function() { 
        position($(this));                          
    }); 
}; 
//左边菜单是否显示
function infoTwoHide(infoTwoId,spanCon){
	$("[name='infotwo"+infoTwoId+"']").toggle();
	if($(spanCon).text()=='[-]')
		$(spanCon).text('[+]');
	else
		$(spanCon).text('[-]');
}