<?php
	class DBAction extends Action{
		public function index(){
			$ItemData=M('YunPath');//
			$item=$ItemData->field(array('id','file_name'=>'name','pid'=>'pId','open','url','target'))->select();
			$this->ajaxReturn($item,"JSON");
		}
		
	}