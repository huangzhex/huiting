<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 新 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<!-- 可选的Bootstrap主题文件（一般不用引入） -->
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <title>慧听网</title>
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style type="text/css">
		body{
			background-color:#e7e8eb;
			font-family: "Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei",Arial,sans-serif;
		}
		.container{
			background-color:white;
			padding-bottom: 100px;
			border: 1px solid #d9dadc;
			border-top-width: 0;
			padding: 20px;
			min-height: 500px
		}
		h2{
			border-bottom: 1px solid #e7e7eb;
			margin-bottom: 14px;
			padding-bottom: 10px;
		}
		small{
			color:#8c8c8c;.
			
		}
		.media{
			margin-bottom: 18px;
			line-height: 20px;
			font-size: 15px;
		}
		.context{
			border-width: 1px;
			border-top-style: solid;
			border-left-style: solid;
			border-right-style: solid;
			border-bottom-style: solid;
			border-color: rgb(255, 153, 0);
			color: rgb(68, 68, 68);
			padding:10px;
			margin:1px;
			margin-bottom:5px;
		}
		.context .row{
			margin-bottom:10px;
		}
		.down{
			margin:5px;
			font-size: 15px;
			font-weight:500;
		}
		img{
			padding-left:20px;
			max-width:250px;
			max-height:250px;
			min-width:200px;
			mi-height-200px;
		}
	</style>
  </head>
  <body>
	<div class="container">
		<h2><?php echo ($item["title"]); ?></h2>
		<div class="row media">
			<div class="col-md-12">
				<?php echo (date("Y-m-d",strtotime($item["createtime"]))); ?>&nbsp;&nbsp;&nbsp;&nbsp;<font color="DodgerBlue">慧听网</font>
			</div>
		</div>
		<div class="row context">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<img src="<?php echo ($item["img_url"]); ?>" alt="<?php echo ($item["title"]); ?>"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php echo ($item["context"]); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="down">分享连接:<a href="<?php echo ($item["baidu_url"]); ?>"><?php echo ($item["baidu_url"]); ?></a><div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="down">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:<?php echo ($item["pwd"]); ?><div>
			</div>
		</div>
	<div>
  </body>
</html>