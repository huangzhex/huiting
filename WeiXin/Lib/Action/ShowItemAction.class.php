<?php
	//查看查询结果
	class ShowItemAction extends Action{
		public function index(){
			$id=$_GET["id"];//id值
			$ItemData=M('Item');//小说
			$this->item=$ItemData->find($id);//返回
			$this->display();
		}
	}