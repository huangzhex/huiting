$(document).ready(function(){
    if($(".fixedMenu")!=null){
		$(".fixedMenu").smartFloat();
	}
	//ȥ�������˵��Ҳ������
	$('.ht_menu_right .line').last().remove();
	panelBox();
});
//�Ҳർ���˵�
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
	//�����ֲ�ͼƬ
     $(".banner").luara({width:"680",height:"278",interval:4500,selected:"seleted",deriction:"left"});
	 //����
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
	 //�ײ˵�ѡ��״̬
	$('.nav_list a:first').addClass("active");
}

/***�б�ҳ��**/
//�л���ͼģʽ
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
//��ʼ��
function initDesc(){
	//��ͼ��ʾģʽ
	var descShow=Cookies.get('descShow');
	if(descShow=="hide"){
		if($("#view")!=null){
			$("#view").toggleClass("view");
			$("[name='context']").toggleClass("hide");
			$(".name").toggleClass("hideName");
		}
	}
}
//�����̶�
$.fn.smartFloat = function() { 
    var position = function(element) { 
        var top = element.position().top; //��ǰԪ�ض���element����������ϱ�Ե�ľ��� 
        var pos = element.css("position"); //��ǰԪ�ؾ���ҳ��document�����ľ��� 
        $(window).scroll(function() { //��������ʱ 
            var scrolls = $(this).scrollTop(); 
            if (scrolls > top) { //���������ҳ�泬���˵�ǰԪ��element�����ҳ�涥���ĸ߶� 
                if (window.XMLHttpRequest) { //�������ie6 
                    element.css({ //����css 
                        position: "fixed", //�̶���λ,�����ٸ������ 
                        top: 0 //����ҳ�涥��Ϊ0 
                    }).addClass("shadow"); //������Ӱ��ʽ.shadow 
                } else { //�����ie6 
                    element.css({ 
                        top: scrolls  //��ҳ�涥������ 
                    });     
                } 
            }else { 
                element.css({ //�����ǰԪ��elementδ������������ϱ�Ե����ʹ��Ĭ����ʽ 
                    position: pos, 
                    top: top
                }).removeClass("shadow");//�Ƴ���Ӱ��ʽ.shadow 
            } 
        }); 
    }; 
    return $(this).each(function() { 
        position($(this));                          
    }); 
}; 
//��߲˵��Ƿ���ʾ
function infoTwoHide(infoTwoId,spanCon){
	$("[name='infotwo"+infoTwoId+"']").toggle();
	if($(spanCon).text()=='[-]')
		$(spanCon).text('[+]');
	else
		$(spanCon).text('[-]');
}