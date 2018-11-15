<?php 
defined('IN_PHPCMS') or exit('No permission resources.'); 
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form', '', 0);
class mobile extends admin {
	private $db,$cate_db;
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->siteid = $this->get_siteid();
		$this->sites = pc_base::load_app_class('sites','admin');
		$this->db = pc_base::load_model('mobile_model');
		$this->cate_db = pc_base::load_model('mobile_cate_model');
	}
	
	private function cate_cache($siteid) {
		$siteid = intval($siteid);
		$a = $this->cate_db->select(array('type'=>0,'status'=>1,'siteid'=>$siteid),'*',10000,'listorder ASC');
		$b = $this->cate_db->select(array('type'=>1,'status'=>1,'siteid'=>$siteid),'*',10000,'listorder ASC');
		$datas = array_merge($a,$b);
		$array = array();
		foreach ($datas as $r) {
			$array[$r['catid']] = $r;
		}
		setcache('mobile_cate', $array,'mobile');		
	}


	public function mobile_update(){

		$db = pc_base::load_model('category_model');
		$a=$db->select(array('module'=>'content','type'=>1,'siteid'=>$this->siteid));
		$b=$db->select(array('module'=>'content','type'=>0,'siteid'=>$this->siteid));
		$c=array_merge($a,$b);
		foreach($c as $k=>$v){
			$data['catid']=$v['catid'];
			$data['parentid']=$v['parentid'];
			$data['catname']=$v['catname'];
			$data['siteid']=$v['siteid'];
			$data['listorder']=$v['listorder'];
			$data['type']=$v['type'];
			$data['child']=$v['child'];
			$data['url']=APP_PATH.'index.php?m=mobile&c=index&a=lists&catid='.$v['catid'].'&siteid='.$v['siteid'];
			$check=$this->cate_db->get_one(array('catid'=>$v['catid']));
			if($check){
				$this->cate_db->update($data,array('catid'=>$v['catid']));
			}else{
				$this->cate_db->insert($data,true);
			}
		}
		$m_a = $this->cate_db->select(array('type'=>0,'status'=>1,'siteid'=>$this->siteid),'*',10000,'listorder ASC');
		$m_b = $this->cate_db->select(array('type'=>1,'status'=>1,'siteid'=>$this->siteid),'*',10000,'listorder ASC');
		$datas = array_merge($m_a,$m_b);
		foreach($datas as $k=>$v){
			$check=$db->get_one(array('catid'=>$v['catid']));
			if(!$check){
				$this->cate_db->delete(array('catid'=>$v['catid']));
			}
		}
	}
		
	public function init() {
		
		$this->mobile_update();
		$this->cate_cache($this->siteid);
		$this->mobile_site_cache();
		$infos = $this->db->select();
		$show_dialog = true;
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=mobile&c=mobile&a=add\', title:\''.L('add_site').'\', width:\'800\', height:\'400\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('mobile_add_site'));		
		include $this->admin_tpl('site_list');
	}
	
	public function edit() {
		if($_POST['dosubmit']) {
			$siteid = intval($_POST['siteid']) ? intval($_POST['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
			$sitename = trim(new_addslashes($_POST['sitename']));
			$logo = trim($_POST['logo']);
			$domain = trim($_POST['domain']);
			$this->db->update(array('sitename'=>$sitename,'description'=>$_POST['description'],'keywords'=>$_POST['keywords'],'logo'=>$logo,'domain'=>$domain), array('siteid'=>$siteid));
			$this->mobile_site_cache();
			showmessage(L('operation_success'), '', '', 'edit');
		} else {
			$siteid = intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
			$sitelist = $this->sites->get_list();
			$info = $this->db->get_one(array('siteid'=>$siteid));
			if($info) {
				extract($info);		
			}
			$show_header = true;
			include $this->admin_tpl('site_edit');			
		}
	}
	
	public function add() {
		if($_POST['dosubmit']) {
			$siteid = intval($_POST['siteid']) ? intval($_POST['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
			if($this->db->get_one(array('siteid'=>$siteid))) {
				showmessage(L('mobile_add_samesite_error'),HTTP_REFERER);
			}
			$sitename = trim(new_addslashes($_POST['sitename']));
			$logo = trim($_POST['logo']);
			$keywords = trim($_POST['keywords']);
			$description = trim($_POST['description']);
			$domain = trim($_POST['domain']);
			$return_id = $this->db->insert(array('siteid'=>$siteid,'keywords'=>$keywords,'description'=>$description,'sitename'=>$sitename,'logo'=>$logo,'domain'=>$domain),'1');
			$this->mobile_site_cache();
			//更新附件状态
			if(pc_base::load_config('system','attachment_stat') & $_POST['logo']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['logo'],'mobile-'.$return_id,1);
			}
			showmessage(L('operation_success'), '', '', 'add');
		} else {
			$sitelists = array();
			$current_siteid = $this->siteid;
			$sitelists = $this->sites->get_list();
			if($_SESSION['roleid'] == '1') {
				foreach($sitelists as $key=>$v) $sitelist[$key] = $v['name'];
			} else {
				$sitelist[$current_siteid] = $sitelists[$current_siteid]['name'];
			}			
			$show_validator = $show_scroll = $show_header = true;
			include $this->admin_tpl('site_add');			
		}		
	}
	
	public function delete() {
		$siteid = intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
		if($siteid == 1) showmessage(L('mobile_permission_denied_del'),HTTP_REFERER);
		$this->db->delete(array('siteid'=>$siteid));
		$this->cate_db->delete(array('siteid'=>$siteid));
		$this->mobile_site_cache();
		showmessage(L('mobile_del_succ'),HTTP_REFERER);
	}
	
	public function public_status() {
		 $status = intval($_GET['status']) && intval($_GET['status'])== 1 ? '1' : '0';
		 $siteid = intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
		 $this->db->update(array('status'=>$status), array('siteid'=>$siteid));
		 $this->mobile_site_cache();
		 showmessage(L('mobile_change_status'),HTTP_REFERER);
	}
	
	
	public function cate_manage() {
		
			$cate_list=$this->cate_db->select(array('siteid'=>$this->siteid),'*','','listorder DESC');
			$tree=$this->_tree($cate_list);
			include $this->admin_tpl('cate_manage');
				
	}
	
	
	private function mobile_site_cache() {
		$datas = $this->db->select();
		$array = array();
		foreach ($datas as $r) {
			$array[$r['siteid']] = $r;
		}
		setcache('mobile_site', $array,'mobile');		
	}

	
	
	 protected function _tree($arr,$pid = 0,$level = 0){
		static $tree = array(); 
		foreach ($arr as $v) {
			if ($v['parentid'] == $pid){
				$v['level'] = str_repeat("&nbsp;&nbsp;&nbsp;└─ ", $level);
				$tree[] = $v;
				$this->_tree($arr,$v['catid'],$level + 1);
			}
		}

		return $tree;
	}
	
	 public function cate_status() {
		 $status = intval($_GET['status']) && intval($_GET['status'])== 1 ? '0' : '1';
		 $catid = intval($_GET['catid']) ? intval($_GET['catid']) : showmessage(L('parameter_error'),HTTP_REFERER);
		 $this->cate_db->update(array('status'=>$status), array('catid'=>$catid));
		 $this->cate_cache($this->siteid);
		 showmessage(L('operation_success'),HTTP_REFERER);
	}
	
	 //更新排序
 	public function cate_listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $k => $v) {
				$k = intval($k);
				$this->cate_db->update(array('listorder'=>$v),array('catid'=>$k));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}
}
?>