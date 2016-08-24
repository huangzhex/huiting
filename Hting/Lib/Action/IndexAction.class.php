<?php
class IndexAction extends Action {
    public function index(){
		$this->create_menu('首页');
		//公告 
		$MsgData=M('Msg');
		$this->msg=$MsgData->order('createdate desc')->limit(4)->select();
		
		//轮播图片
		$SetData=M('Set');
		$imgCondition['type']='img';
		$this->img=$SetData->where($imgCondition)->order('order_index desc')->limit(4)->select();

		//栏目
		$InfoData=M('Menu');
		$LableData=M('Lable');//标签
		$ItemData=M('Item');//小说
		$ItemLableData=M('ItemLableView');//标签与小说对应关系表
		$condition['float']='info1';
		$parent_info=M('Menu')->where($condition)->order('order_index')->select();//一级菜单
		//得到对应的二级菜单
		$condition['float']='info2';
		foreach($parent_info as $n=>$val){
			$condition['parent_id']=$val['id'];
			//$parent_info[$n]['infotwo']=$InfoData->where($condition)->order('order_index')->select();//废弃 使用标签代替
			//加载标签
			$lableCondition['info_id']=$val['id'];
			$parent_info[$n]['lables']=$LableData->where($lableCondition)->order('order_index')->select();
			//加载对应小说
			$itemCondition['menu_id']=$val['id'];
			$parent_info[$n]['items']=$ItemData->where($itemCondition)->order('menu_order_index desc')->limit(7)->select();
			//加载排行榜 读取了视图 按order_index 最大排序
			$parent_info[$n]['orderItems']=$ItemLableData->where($lableCondition)->order('order_index desc')->limit(10)->select();
		}
		$this->infos=$parent_info;
		
		//今日更新
		$this->curUpdates=$ItemData->field('title,createtime')->order('createtime desc')->limit(4)->select();
		
		$this->display();
    }
	//列表
	public function desc(){
		$this->listItem('createtime',null);
		$this->display();
	}
	//小说详细
	public function page(){
		$id = $_GET['id'];//小说ID
		$this->create_menu('首页');
		$this->create_left_menu();
		//加载小说
		if(!empty($id)){
			$this->item=M('item')->find($id);
			if(!empty($this->item)){
				//更新热度
				$data['order_index']=$this->item['order_index']+1;
				M('item')->where('id='.$this->item['id'])->data($data)->save();
				$this->keywords=$this->item['title'];//关键字
				$this->lable=M('lable')->find($this->item['lable_id']);
				if(!empty($this->lable))
					$this->descTitle=$this->lable['name'];
				if(!empty($this->item['title'])){
					$filter['title']=array('LIKE','%'.$this->item['title'].'%');
					$this->itemSet=M('itemSet')->where($filter)->order('index_no')->select();
				}
			}
		}
		$this->display();
	}
	//每日更新
	public function newDay(){
		$this->create_left_menu();
		$this->create_menu('首页');
		$this->descTitle='排行榜';//关键字
		
		import('ORG.Util.Page');// 导入分页类
		$filter="createtime>=date_add(now(), interval -3 day)";
		$count=M('item')->where('createtime>=date_add(now(), interval -3 day)')->count();// 查询满足要求的总记录数
		$Page= new Page($count,20);// 实例化分页类 传入总记录数
		$nowPage = isset($_GET['p'])?$_GET['p']:1;
		$this->items=M('item')->where('createtime>=date_add(now(), interval -3 day)')->page($nowPage.','.$Page->listRows)->field(array('id','title','left(context,100)'=>'context','author','reader','img_url','order_index','createtime','isend'))->order('createtime desc')->select();
		$this->assign('page',$Page->show());// 赋值分页输出
		
		$this->display();
	}
	//排行榜
	public function orderItem(){
		$this->listItem('order_index',null);
		$this->descTitle='排行榜 ['.$this->descTitle."]";
		$this->display();
	}
	//消息列表
	public function msgList(){
		$this->create_left_menu();
		$this->create_menu('首页');
		$this->descTitle='通知公告';//关键字
		
		import('ORG.Util.Page');// 导入分页类
		$count=M('msg')->count();// 查询满足要求的总记录数
		$Page= new Page($count,20);// 实例化分页类 传入总记录数
		$nowPage = isset($_GET['p'])?$_GET['p']:1;
		$this->items=M('msg')->page($nowPage.','.$Page->listRows)->field(array('id','title','left(context,100)'=>'context','createdate'))->order('createdate desc')->select();
		$this->assign('page',$Page->show());// 赋值分页输出
		
		$this->display();
	}
	//消息
	public function msg(){
		$id = $_GET['id'];//小说ID
		$this->create_menu('首页');
		$this->create_left_menu();
		$this->descTitle='通知公告';
		//加载消息
		if(!empty($id)){
			$this->item=M('msg')->find($id);
		}
		$this->display();
	}
	//作者
	public function author(){
		$this->authorAsound('作者','author');
		$this->display();
	}
	//播音
	public function sound(){
		$this->authorAsound('播音','reader');
		$this->display();
	}
	private function authorAsound($title,$groupName){
		$this->create_left_menu();
		$this->create_menu('首页');
		$this->descTitle=$title;//关键字
		
		import('ORG.Util.Page');// 导入分页类
		$count=M('item')->table('(select '.$groupName.' from hting_item group by '.$groupName.') hting_item')->count();// 查询满足要求的总记录数
		$Page= new Page($count,20);// 实例化分页类 传入总记录数
		$nowPage = isset($_GET['p'])?$_GET['p']:1;
		$this->items=M('item')->page($nowPage.','.$Page->listRows)->field(array('max(id)'=>'id',$groupName,'count(id)'=>'scount'))->group($groupName)->order('scount desc')->select();
		$this->assign('page',$Page->show());// 赋值分页输出
	}
	//作者集
	public function itemAuthor(){
		$authorId=$_GET['authorid'];
		$Item=M('item')->find($authorId);
		$filter;
		if(!empty($Item))
			$filter['author']=$Item['author'];
		$this->listItem('order_index',$filter);
		$this->display('desc');
	}
	//播音集
	public function itemSound(){
		$soundid=$_GET['soundid'];
		$Item=M('item')->find($soundid);
		$filter;
		if(!empty($Item))
			$filter['reader']=$Item['reader'];
		$this->listItem('order_index',$filter);
		$this->display('desc');
	}
	//顶级菜单
	private function create_menu($menuSelect){
		//顶级菜单
		$MenuData=M('Menu');
		//得到左边菜单
		$condition['float']='left';
		$this->menu=$MenuData->where($condition)->order('order_index')->select();
		//得到右边菜单
		$condition['float']='right';
		$this->menu_right=$MenuData->where($condition)->select();
		//顶部公告
		$setCondition['type']='top_info';
		$this->topInfo=M('Set')->where($setCondition)->find();
		$this->menuSelect=$menuSelect;
	}
	//左边菜单
	private function create_left_menu(){
		$LableData=M('Lable');//标签
		$condition['float']='info1';
		$parent_info=M('Menu')->where($condition)->order('order_index')->select();//栏目
		//二级栏目
		$condition['float']='info2';
		//合并菜单和标签
		foreach($parent_info as $n=>$val){
			$lableCondition['info_id']=$val['id'];
			$parent_info[$n]['lables']=$LableData->where($lableCondition)->order('order_index')->select();
		}
		$this->infos=$parent_info;
	}
	//列表
	private function listItem($orderInfo,$filter){
		$id = $_GET['id'];//标签ID
		$menu=$_GET['menu'];//菜单ID
		$findInfo=$_POST['keyword'];//查询信息
		
		//$filter;//查询过滤条件
		$LableData=M('Lable');//标签
		$condition['float']='info1';
		$parent_info=M('Menu')->where($condition)->order('order_index')->select();//栏目
		$menuSelect='首页';//选择的菜单
		//二级栏目
		$condition['float']='info2';
		//合并菜单和标签
		foreach($parent_info as $n=>$val){
			$lableCondition['info_id']=$val['id'];
			$parent_info[$n]['lables']=$LableData->where($lableCondition)->order('order_index')->select();
			if($findInfo!=null){
				$this->descTitle='查询结果';
				if(empty($filter))
					$filter['title']=array('LIKE','%'.$findInfo.'%');
			}else if($menu==null&&$id==null&&$filter==null){
				$this->descTitle='全部';
				$filter['lable_id']=array('NEQ','NULL');
			}
			if($id==null){
				if($menu!=null&&$menu==$val['id']){//显示菜单下全部标签
					$this->descTitle=$val['name'];
					$lableItem;//标签集合
					foreach($parent_info[$n]['lables'] as $n=>$lableVal){
						$lableItem=$lableVal['id'];
					}
					if(empty($filter))
						$filter['lable_id']= array('in',$lableItem);
					$menuSelect=$val['name'];
				}
			}else{
				foreach($parent_info[$n]['lables'] as $n=>$lableVal){
					if($id==$lableVal['id']){
						$this->descTitle=$lableVal['name'];
						if(empty($filter))
							$filter['lable_id']= array('eq',$id);
						$menuSelect=$val['name'];
					}
				}
			}
		}
		//得到作品
		if(!empty($filter)){
			import('ORG.Util.Page');// 导入分页类
			$count=M('item')->where($filter)->count();// 查询满足要求的总记录数
			$Page= new Page($count,20);// 实例化分页类 传入总记录数
			$nowPage = isset($_GET['p'])?$_GET['p']:1;
			$this->items=M('item')->where($filter)->page($nowPage.','.$Page->listRows)->field(array('id','title','left(context,100)'=>'context','author','reader','img_url','order_index','createtime','isend'))->order($orderInfo.' desc')->select();
			$this->assign('page',$Page->show());// 赋值分页输出
		}
		$this->keywords=$this->descTitle;//关键字
		$this->create_menu($menuSelect);
		$this->infos=$parent_info;
	}
}