<?php
	//�鿴��ѯ���
	class ShowItemAction extends Action{
		public function index(){
			$id=$_GET["id"];//idֵ
			$ItemData=M('Item');//С˵
			$this->item=$ItemData->find($id);//����
			$this->display();
		}
	}