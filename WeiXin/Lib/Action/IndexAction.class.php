<?php
	//微信接口
	define("TOKEN", "huitingweb");//密钥
	class IndexAction extends Action{
		private $_msg;//发送的消息
		public function index()
		{
			if($this->checkSignature()){//如果使用调试页面时关闭验证
				if (IS_GET) {
					//微信验证有效性
					$echoStr = $_GET["echostr"];
					echo $echoStr;
					exit;
				}else{
					$this->getRev();//接收数据
				}
			}else{
				exit;//验证失败
			}
		}
		//解析消息
		private function readMsg($_receive){
			$content=$_receive['Content'];//文本消息内容
			if($content=='首页'){
				$this->home($_receive);
			}else if($content=='管理'){
				$this->sendImg($_receive,'网站管理','管理员登录页面!','http://www.huitingweb.top/WeiXin/Public/images/login.jpg','http://www.huitingweb.top/WeiXin/index.php/Admin/');
			}else if($content=='帮助'||$content=='help'){
				$this->help($_receive);
			}else{
				//TODO:查询数据库比较是否存在关键字
				$ItemData=M('Item');//小说
				$item=$ItemData->where("title like '%".$content."%'")->find();
				if(!empty($item)){
					$this->sendImg($_receive,$item['title'],$item['context'],$item['img_url'],'http://www.huitingweb.top/WeiXin/index.php/ShowItem?id='.$item['id']);
				}else{
					$this->help($_receive);
				}
			}
		}
		//解析事件
		private function readEvent($_receive){
			//Event事件类型，subscribe(订阅)、unsubscribe(取消订阅)  
			//自定义菜单事件 Event:CLICK EventKey:事件KEY值，与自定义菜单接口中KEY值对应
			//点击菜单跳转链接时的事件推送 Event:VIEW EventKey:事件KEY值，设置的跳转URL
			$event=$_receive['Event'];
			switch($event){
				case 'subscribe'://订阅
					$this->home($_receive);//TODO:将订阅人保存到数据库中
					exit;
					break;
				case 'unsubscribe'://取消订阅 //TODO:将取消订阅人删除数据库
					break;
				case 'CLICK':
					break;
				case 'VIEW':
					break;
				default:
					break;
			}
		}
		//帮助
		private function help($_receive){
			$this->text("可输入作品进行查询！如：三国演义",$_receive);
		}
		//首页
		private function home($_receive){
			$newData=array(
					0=>array(
						'Title'=>'慧听网',
						'Description'=>'本站主要提供有声小说下载，为全国的盲童和视力障碍者及小说爱好者做一点儿公益奉献，如本站资源涉及版权问题,请告知！',
						'PicUrl'=>'http://www.huitingweb.top/WeiXin/Public/images/0.jpg',
						'Url'=>'http://www.huitingweb.top/WeiXin/index.php/User/'
					)
				);
				$this->news($newData,$_receive);
		}
		//发送图文消息
		private function sendImg($_receive,$title,$des,$picUrl,$url){
			$newData=array(
					0=>array(
						'Title'=>$title,
						'Description'=>$des,
						'PicUrl'=>$picUrl,
						'Url'=>$url
					)
				);
				$this->news($newData,$_receive);
		}
		
		//微信验证接口
		private function checkSignature()
		{
			$signature = $_GET["signature"];
			$timestamp = $_GET["timestamp"];
			$nonce = $_GET["nonce"];
					
			$token = TOKEN;
			$tmpArr = array($token, $timestamp, $nonce);
			sort($tmpArr, SORT_STRING);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );
			if( $tmpStr == $signature ){
				return true;
			}else{
				return false;
			}
		}
		//接收数据
		private function getRev(){
			$postStr = file_get_contents("php://input");
			$this->log($postStr);//接收到的数据
			if (!empty($postStr)) {
				$_receive = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//接收数据生成数组
				$msgType=$_receive['MsgType'];//消息类型
				$msgId=$_receive['MsgId'];//消息id
				switch($msgType) {
					case 'text'://文本消息
						$this->readMsg($_receive);
						exit;
						break;
					case 'event'://事件消息
						$this->readEvent($_receive);
						exit;
						break;
					default://默认回复
						$this->text("请输入帮助/help!")->reply();
				}
			}
		}
		/**
		 * 设置回复图文
		 * @param array $newsData 
		 * 数组结构:
			 $newData=array(
				0=>array(
					'Title'=>'回复消息',
					'Description'=>'简介',
					'PicUrl'=>'http://htingt.hostoi.com/Hting/Public/images/4.jpg',
					'Url'=>'http://htingt.hostoi.com'
				)
			);
		 */
		public function news($newsData=array(),$_receive)
		{
			$count = count($newsData);
			$toUserName=$_receive['ToUserName'];//开发者微信号
			$fromUserName=$_receive['FromUserName'];//发送方帐号
			$msg = array(
				'ToUserName' =>$fromUserName,
				'FromUserName'=>$toUserName,
				'MsgType'=>'news',
				'CreateTime'=>time(),
				'ArticleCount'=>$count,
				'Articles'=>$newsData
			);
			$this->Message($msg);
			return $this;
		}
		//生成日志
		private function log($log){
    		Log::record($log, Log::DEBUG);
		}
		//设置回复消息
		private function text($text='',$_receive){
			$this->log($text);
			$toUserName=$_receive['ToUserName'];//开发者微信号
			$fromUserName=$_receive['FromUserName'];//发送方帐号
			$msg = array(
			'ToUserName' => $fromUserName,
			'FromUserName'=>$toUserName,
			'MsgType'=>'text',
			'Content'=>$text,
			'CreateTime'=>time()
			);
			$this->Message($msg);
		}
		
		/**
		 * 设置发送消息
		 * @param array $msg 消息数组
		 * @param bool $append 是否在原消息数组追加
		 */
		public function Message($msg = '',$append = false){
			if (is_null($msg)) {
				$this->_msg =array();
			}elseif (is_array($msg)) {
				if ($append)
					$this->_msg = array_merge($this->_msg,$msg);
				else
					$this->_msg = $msg;
				$this->_msg;
			} else {
				$this->_msg;
			}
			$this->reply($this->_msg);
		}
		/**
		 * 
		 * 回复微信服务器, 此函数支持炼师操作
		 * Example: $this->text('msg tips')->reply();
		 * @param string $msg 要发送的信息, 默认取$this->_msg
		 * @param bool $return 是否返回信息而不抛出到浏览器 默认:否
		 */
		public function reply($msg=array(),$return = false)
		{
			if (empty($msg)) 
				$msg = $this->_msg;
			$xmldata=  $this->xml_encode($msg);
			$this->log($xmldata);
			if ($return)
				return $xmldata;
			else
				echo $xmldata;
		}
		
		/**
		 * XML编码
		 * @param mixed $data 数据
		 * @param string $root 根节点名
		 * @param string $item 数字索引的子节点名
		 * @param string $attr 根节点属性
		 * @param string $id   数字索引子节点key转换的属性名
		 * @param string $encoding 数据编码
		 * @return string
		*/
		public function xml_encode($data, $root='xml', $item='item', $attr='', $id='id', $encoding='utf-8') {
			if(is_array($attr)){
				$_attr = array();
				foreach ($attr as $key => $value) {
					$_attr[] = "{$key}=\"{$value}\"";
				}
				$attr = implode(' ', $_attr);
			}
			$attr=trim($attr);
			$attr=empty($attr) ? '' : " {$attr}";
			$xml= "<{$root}{$attr}>";
			$xml.= self::data_to_xml($data, $item, $id);
			$xml.= "</{$root}>";
			return $xml;
		}
		//格式化xml
		public static function data_to_xml($data) {
			$xml = '';
			foreach ($data as $key => $val) {
				is_numeric($key) && $key = "item id=\"$key\"";
				$xml.="<$key>";
				$xml.=( is_array($val) || is_object($val)) ? self::data_to_xml($val)  : self::xmlSafeStr($val);
				list($key, ) = explode(' ', $key);
				$xml.="</$key>";
			}
			return $xml;
		}
		//过滤信息
		public static function xmlSafeStr($str)
		{   
			return '<![CDATA['.preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/",'',$str).']]>';   
		} 
	}
?>