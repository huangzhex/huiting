<?php
class JsonAction extends Action {
    public function index(){
		//$data=M('item')->where('createtime>=date_add(now(), interval -3 day)')->field(array('id','title','left(context,100)'=>'context','author','reader','img_url','order_index','createtime','isend'))->order('createtime desc')->select();
		$data['a']=13;
		$data['info']="中文";
		$this->ajaxReturn($data,'JSON');
    }
	/**
	* 得到每日更新作品
	**/
	public function getItemDay(){
		$pageNum=$_GET['pagenum'];
		$data=M('item')->field(array('id','title',"left(REPLACE(context,'&#160;',''),100)"=>'context','author','reader','img_url','order_index'))->order('id desc')->limit($pageNum*20,20)->select();
		$this->ajaxReturn($data,'JSON');
	}
	/**
	* 作品分类
	**/
	public function getLables(){
		$data=M('lable')->field(array('id','name'))->order('info_id')->select();
		$this->ajaxReturn($data,'JSON');
	}
	/**
	* 根据类别得到作品集
	**/
	public function getItems(){
		$lableId=$_GET['lableId'];
		$pageNum=$_GET['pagenum'];
		$filter['lable_id']=$lableId;
		$data=M('item')->where($filter)->field(array('id','title','left(context,100)'=>'context','author','reader','img_url','order_index'))->order('id desc')->limit($pageNum*20,20)->select();
		$this->ajaxReturn($data,'JSON');
	}
	/**
	* 作品
	**/
	public function getItem(){
		$itemId=$_GET['itemId'];
		$filter['id']=$itemId;
		$data=M('item')->where($filter)->limit(1)->select();
		$this->ajaxReturn($data,'JSON');
	}
	/**
	* 下载地址
	**/
	public function getDownload(){
		$itemId=$_GET['itemId'];
		$item=M('item')->find($itemId);
		if(!empty($item['title'])){
			$filter['title']=array('LIKE','%'.$item['title'].'%');
			$data=M('itemSet')->where($filter)->order('index_no')->select();
			$this->ajaxReturn($data,'JSON');
		}
	}
}