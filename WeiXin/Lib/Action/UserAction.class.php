<?php
	//会员入口
	class UserAction extends Action{
		public function index(){
			$this->assign('items',M('Item')->field(array('left(title,25)'=>'title','author','reader','createtime'))->order('createtime desc')->limit(20)->select());
			$this->assign('orders',M('Item')->field(array('left(title,25)'=>'title','author','reader','createtime'))->order('order_index desc')->limit(20)->select());
			$where=array('float'=>'info2');
			$this->assign('types',M('Menu')->field('id,name')->where($where)->order('order_index')->select());
			$this->display();
		}
	}
?>