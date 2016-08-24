<?php
	//管理员
	class AdminAction extends Action{
		public function index(){
			$this->display();
		}
		//登录
		public function login(){
			$username=$_POST['username'];
			$pwd=$_POST['pwd'];
			$User=M('User');
			$admin=$User->where("uname='".$username."' and pwd='".$pwd."'")->find();
			if(!empty($admin)){
				$this->display("funlist");//功能列表
			}else{
				$this->msg='登录失败!';
				$this->display('index');
			}
		}
		//音像管理
		public function itemlist(){
			$ItemData=M('Item');//小说
			$this->items=$ItemData->limit(10)->order('id DESC')->select();
			$this->display();
		}
		//音像添加
		public function itemupdate(){
			$this->display();
		}
		
		public function saveitem(){
			 $Form = D('Item');
			if($Form->create()) {
				$result =   $Form->add();
			}
			$ItemData=M('Item');//小说
			$this->items=$ItemData->limit(10)->order('id DESC')->select();
			$this->display('itemlist');
		}
	}