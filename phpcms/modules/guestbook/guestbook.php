<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class guestbook extends admin {
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('guestbook', 'commons'));
		$this->db = pc_base::load_model('guestbook_model');
		$this->db2 = pc_base::load_model('type_model');
	}

	public function init() {
		if($_GET['typeid']!=''){
			$where = array('typeid'=>$_GET['typeid'],'siteid'=>$this->get_siteid());
		}else{
			$where = array('siteid'=>$this->get_siteid());
		}
 		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'listorder DESC,guestid DESC',$page, $pages = '9');
		$pages = $this->db->pages;
		$types = $this->db2->listinfo(array('module'=>ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'typeid DESC');
		$types = new_html_special_chars($types);
 		$type_arr = array ();
 		foreach($types as $typeid=>$type){
			$type_arr[$type['typeid']] = $type['name'];
		}
		include $this->admin_tpl('guestbook_list');
	}

	 
	 
	//添加分类时，验证分类名是否已存在
	public function public_check_name() {
		$type_name = isset($_GET['type_name']) && trim($_GET['type_name']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['type_name'])) : trim($_GET['type_name'])) : exit('0');
 		$typeid = isset($_GET['typeid']) && intval($_GET['typeid']) ? intval($_GET['typeid']) : '';
 		$data = array();
		if ($typeid) {
 			$data = $this->db2->get_one(array('typeid'=>$typeid), 'name');
			if (!empty($data) && $data['name'] == $type_name) {
				exit('1');
			}
		}
		if ($this->db2->get_one(array('name'=>$type_name), 'typeid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	 
	    
	/**
	 * 说明:异步更新排序 
	 * @param  $optionid
	 */
	public function listorder_up() {
		$result = $this->db->update(array('listorder'=>'+=1'),array('guestid'=>$_GET['guestid']));
		if($result){
			echo 1;
		} else {
			echo 0;
		}
	}
	
	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $guestid => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('guestid'=>$guestid));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}
	
	//添加留言板分类
 	public function add_type() {
		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['type']['name'])) {
				showmessage(L('typename_noempty'),HTTP_REFERER);
			}
			$_POST['type']['siteid'] = $this->get_siteid(); 
			$_POST['type']['module'] = ROUTE_M;
 			$this->db2 = pc_base::load_model('type_model');
			$typeid = $this->db2->insert($_POST['type'],true);
			if(!$typeid) return FALSE;
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$show_validator = $show_scroll = true; 
 			include $this->admin_tpl('guestbook_type_add');
		}

	}
	
	/**
	 * 删除分类
	 */
	public function delete_type() {
		if((!isset($_GET['typeid']) || empty($_GET['typeid'])) && (!isset($_POST['typeid']) || empty($_POST['typeid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['typeid'])){
				foreach($_POST['typeid'] as $typeid_arr) {
 					$this->db2->delete(array('typeid'=>$typeid_arr));
				}
				showmessage(L('operation_success'),HTTP_REFERER);
			}else{
				$typeid = intval($_GET['typeid']);
				if($typeid < 1) return false;
				$result = $this->db2->delete(array('typeid'=>$typeid));
				if($result)
				{
					showmessage(L('operation_success'),HTTP_REFERER);
				}else {
					showmessage(L("operation_failure"),HTTP_REFERER);
				}
			}
		}
	}
	
	//:分类管理
 	public function list_type() {
		$this->db2 = pc_base::load_model('type_model');
		$infos = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'listorder DESC',$page, $pages = '10');
		include $this->admin_tpl('guestbook_list_type');
	}
 
	public function show() {
		if(isset($_POST['dosubmit'])){
 			$guestid = intval($_GET['guestid']);
			if($guestid < 1) return false;
			
			$this->db->update($_POST['guestbook'],array('guestid'=>$guestid));
			
			showmessage(L('operation_success'),'?m=guestbook&c=guestbook&a=show','', 'show');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			$types = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'typeid DESC',$page, $pages = '10');
 			$type_arr = array ();
			foreach($types as $typeid=>$type){
				$type_arr[$type['typeid']] = $type['name'];
			}
			//解出链接内容
			$info = $this->db->get_one(array('guestid'=>$_GET['guestid']));
			if(!$info) showmessage(L('guestbook_exit'));
			extract($info); 
 			include $this->admin_tpl('guestbook_show');
		}

	}
	
	/**
	 * 修改留言板 分类
	 */
	public function edit_type() {
		if(isset($_POST['dosubmit'])){ 
			$typeid = intval($_GET['typeid']); 
			if($typeid < 1) return false;
			if(!is_array($_POST['type']) || empty($_POST['type'])) return false;
			if((!$_POST['type']['name']) || empty($_POST['type']['name'])) return false;
			$this->db2->update($_POST['type'],array('typeid'=>$typeid));
			showmessage(L('operation_success'),'?m=link&c=link&a=list_type','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			//解出分类内容
			$info = $this->db2->get_one(array('typeid'=>$_GET['typeid']));
			if(!$info) showmessage(L('linktype_exit'));
			extract($info);
			include $this->admin_tpl('link_type_edit');
		}

	}

	/**
	 * 删除留言板  
	 * @param	intval	$sid	留言板ID，递归删除
	 */
	public function delete() {
  		if((!isset($_GET['guestid']) || empty($_GET['guestid'])) && (!isset($_POST['guestid']) || empty($_POST['guestid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['guestid'])){
				foreach($_POST['guestid'] as $guestid_arr) {
 					//批量删除留言板
					$this->db->delete(array('guestid'=>$guestid_arr));
					 
				}
				showmessage(L('operation_success'),'?m=guestbook&c=guestbook');
			}else{
				$guestid = intval($_GET['guestid']);
				if($guestid < 1) return false;
				//删除留言板
				$result = $this->db->delete(array('guestid'=>$guestid));
				 
				if($result){
					showmessage(L('operation_success'),'?m=guestbook&c=guestbook');
				}else {
					showmessage(L("operation_failure"),'?m=guestbook&c=guestbook');
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}
	 
	/**
	 * 留言板模块配置
	 */
	public function setting() {
		//读取配置文件
		$data = array();
 		$siteid = $this->get_siteid();//当前站点 
		//更新模型数据库,重设setting 数据. 
		$m_db = pc_base::load_model('module_model');
		$data = $m_db->select(array('module'=>'guestbook'));
		$setting = string2array($data[0]['setting']);
		$now_seting = $setting[$siteid]; //当前站点配置
		if(isset($_POST['dosubmit'])) {
			//多站点存储配置文件
 			$setting[$siteid] = $_POST['setting'];
  			setcache('guestbook', $setting, 'commons');  
			//更新模型数据库,重设setting 数据. 
  			$m_db = pc_base::load_model('module_model'); //调用模块数据模型
			$set = array2string($setting);
			$m_db->update(array('setting'=>$set), array('module'=>ROUTE_M));
			showmessage(L('setting_updates_successful'), '?m=guestbook&c=guestbook&a=init');
		} else {
			@extract($now_seting);
 			include $this->admin_tpl('setting');
		}
	}
	
  	//批量审核申请 ...
 	public function check_register(){
		if(isset($_POST['dosubmit'])) {
			if((!isset($_GET['guestid']) || empty($_GET['guestid'])) && (!isset($_POST['guestid']) || empty($_POST['guestid']))) {
				showmessage(L('illegal_parameters'), HTTP_REFERER);
			} else {
				if(is_array($_POST['guestid'])){//批量审核
					foreach($_POST['guestid'] as $guestid_arr) {
						$this->db->update(array('passed'=>1),array('guestid'=>$guestid_arr));
					}
					showmessage(L('operation_success'),'?m=guestbook&c=guestbook');
				}else{//单个审核
					$guestid = intval($_GET['guestid']);
					if($guestid < 1) return false;
					$result = $this->db->update(array('passed'=>1),array('guestid'=>$guestid));
					if($result){
						showmessage(L('operation_success'),'?m=guestbook&c=guestbook');
					}else {
						showmessage(L("operation_failure"),'?m=guestbook&c=guestbook');
					}
				}
			}
		}else {//读取未审核列表
			$where = array('siteid'=>$this->get_siteid(),'passed'=>0);
			$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
			$infos = $this->db->listinfo($where,'guestid DESC',$page, $pages = '9');
			$pages = $this->db->pages;
			include $this->admin_tpl('check_register_list');
		}
		
	}
	
 	//单个审核申请
 	public function check(){
		if((!isset($_GET['guestid']) || empty($_GET['guestid'])) && (!isset($_POST['guestid']) || empty($_POST['guestid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else { 
			$guestid = intval($_GET['guestid']);
			if($guestid < 1) return false;
			//删除留言板
			$result = $this->db->update(array('passed'=>1),array('guestid'=>$guestid));
			if($result){
				showmessage(L('operation_success'),'?m=guestbook&c=guestbook');
			}else {
				showmessage(L("operation_failure"),'?m=guestbook&c=guestbook');
			}
			 
		}
	}

    
	
	/**
	 * 说明:对字符串进行处理
	 * @param $string 待处理的字符串
	 * @param $isjs 是否生成JS代码
	 */
	function format_js($string, $isjs = 1){
		$string = addslashes(str_replace(array("\r", "\n"), array('', ''), $string));
		return $isjs ? 'document.write("'.$string.'");' : $string;
	}
 
 
	
}
?>