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
			font-family: "Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei",Arial,sans-serif;
		}
		.container{
			border-width: 1px;
			border-top-style: solid;
			border-left-style: solid;
			border-right-style: solid;
			border-bottom-style: solid;
			border-color: rgb(255, 153, 0);
			padding:20px;
		}
		img{
			width:100%;
			height:150px;
			margin-bottom:20px;
		}
		h2{
			border-bottom: 1px solid #e7e7eb;
			margin-bottom: 14px;
			padding-bottom: 10px;
		}
	</style>
  </head>
  <body>
	<div class="container">
		<h2>管理员登录</h2>
		<img  src="http://htingweb.hostoi.com/Weixin/Public/images/login.jpg" alt="登录"/>
		<form method="post" action="login">
		  <div class="form-group">
			<label >用户名</label>
			<input type="text" class="form-control" name="username" >
		  </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">密码</label>
			<input type="password" class="form-control" name="pwd">
		  </div>
		  <div class="form-group">
			<font color="red"><?php echo ($msg); ?></font>
		  </div>
		  <button type="submit" class="btn btn-primary">登录</button>
		</form>
	<div>
  </body>
</html>