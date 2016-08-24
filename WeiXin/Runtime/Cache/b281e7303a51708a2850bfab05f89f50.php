<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1 user-scalable=no"/>
	<link rel="stylesheet" href="/WeiXin/Public/css/index.css">
	<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#now').css('display','block');
			$('.nav a').click(function(){
				$('.active').removeClass('active');
				$(this).siblings("span").addClass('active');
				$('section').css('display','none');
				$('#'+$(this).attr('rel')).css('display','block');
			});
		});
	</script>
</head>
<body>
	<header class="page_header">
		<h1>慧听网</h1>
	</header>
	<div class="nav">
		<div >
			<a  href="#" rel="now">最新</a>
			<span class="active"></span>
		</div>
		<div>
			<a href="#" rel="class">分类</a>
			<span></span>
		</div>
		<div>
			<a href="#" rel="order">排行</a>
			<span></span>
		</div>
		<div>
			<a href="#" rel="user">会员</a>
			<span></span>
		</div>
		
	</div>
	<section id="now" class="section_list">
		<ul>
			<?php if(is_array($items)): $i = 0; $__LIST__ = $items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li>
				<div class="name"><?php echo ($item["title"]); ?><span class="r"><?php echo (date("y-m-d",strtotime($item["createtime"]))); ?></span></div>
				<div class="context">
					<span>作者: <?php echo ($item["author"]); ?></span>
					<span class="r">演播: <?php echo ($item["reader"]); ?></span>
				</div>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</section>
	<section id="class" class="section_list">
		<ul>
			<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; if(($mod) == "0"): ?><li><?php endif; ?>
				<div><span><?php echo ($info["name"]); ?></span></div>
			<?php if(($mod) == "1"): ?></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</section>
	<section id="order" class="section_list">
		<ul>
			<?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li>
				<div class="name">
					<strong><?php echo ($item["title"]); ?></strong><strong class="r"><?php echo (date("y-m-d",strtotime($item["createtime"]))); ?></strong>
				</div>
				<div class="context">
					<span>作者: <?php echo ($item["author"]); ?></span>
					<span class="r">演播: <?php echo ($item["reader"]); ?></span>
				</div>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</section>
	<section id="user" class="section_list">
		<ul>
			<li>
				<img src=""></img>
				<div class="context">
					<a href="#">功能</a>
				</div>
			</li>
			<li>
				<img src=""></img>
				<div class="context">
					<a href="#">功能</a>
				</div>
			</li>
			<li>
				<img src=""></img>
				<div class="context">
					<a href="#">功能</a>
				</div>
			</li>
		</ul>
	</section>
</body>
</html>