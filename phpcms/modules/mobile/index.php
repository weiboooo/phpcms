<?php 
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global');
pc_base::load_sys_class('format', '', 0);
class index {
	function __construct() {		
		$this->db = pc_base::load_model('content_model');
		$this->cate_db = pc_base::load_model('mobile_cate_model');
		$this->siteid = isset($_GET['siteid']) && (intval($_GET['siteid']) > 0) ? intval(trim($_GET['siteid'])) : (param::get_cookie('siteid') ? param::get_cookie('siteid') : 1);
		$this->mobile_site = getcache('mobile_site','mobile');
		$this->cates = getcache('mobile_cate','mobile');
		$this->mobile = $this->mobile_site[$this->siteid];
		define('MOBILE_SITEURL', $this->mobile['domain'] ? $this->mobile['domain'].'index.php?m=mobile&siteid='.$this->siteid : APP_PATH.'index.php?m=mobile&siteid='.$this->siteid);
		if($this->mobile['status']!=1) exit(L('mobile_close_status'));
		$CATEGORYS = getcache('category_content_'.$this->siteid,'commons');
		foreach($CATEGORYS as $k=>$v){
			$CATEGORYS[$k]['url']=MOBILE_SITEURL.'&a=lists&c=index&catid='.$v['catid'];
			}
	    $this->categorys=$CATEGORYS;		
		
	}
	
	//展示首页
	public function init() {
		$CATEGORYS =$this->categorys;
		$mobile = $this->mobile;
		$cates=$this->cates;
		$GLOBALS['siteid'] = $siteid = max($this->siteid,1);
		include template('mobile', 'index');
	}
	
    //展示列表页
	public function lists() {
	    
		$cates=$this->cates;
		$mobile = $this->mobile;
		$GLOBALS['siteid'] = $siteid = max($this->siteid,1);
		$catid = intval($_GET['catid']);		
		if(!$catid) exit(L('parameter_error'));	
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = $this->categorys;
		if(!isset($CATEGORYS[$catid])) exit(L('parameter_error'));
		$CAT = $CATEGORYS[$catid];
		
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		extract($CAT);
		$setting=string2array($setting);
		
		$category_template=$setting['category_template'] ? $setting['category_template'] : 'category';
		$list_template=$setting['list_template'] ? $setting['list_template'] : 'list';
		
		foreach($cates as $_t) $parentids[] = $_t['parentid'];
		if($type==0){
		
		$template = $child ? $category_template: $list_template;
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$MODEL = getcache('model','commons');
		$modelid = $CAT['modelid'];
		$tablename = $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
		$total = $this->db->count(array('status'=>'99','catid'=>$catid));
		
		$pagesize =  10 ;
		$offset = ($page - 1) * $pagesize;
		$list = $this->db->select(array('status'=>'99','catid'=>$catid), '*', $offset.','.$pagesize,'inputtime DESC');
	    foreach($list as $k=>$v){
			
			$list[$k]['url']=show_url($v['catid'],$v['id']);
			}
		//构造mobile url规则
		define('URLRULE', 'index.php?m=mobile&c=index&a=lists&catid={$catid}~index.php?m=mobile&c=index&a=lists&catid={$catid}&page={$page}');
		$GLOBALS['URL_ARRAY'] = array('catid'=>$catid);
		
		$pages = wpa_pages($total, $page, $pagesize);
		
		include template('mobile', $template);
		}else{
			
			$page_template = $setting['page_template'] ? $setting['page_template'] : 'page';
			$page_template = $child ? 'page_list':$page_template;	
			$this->page_db = pc_base::load_model('page_model');
			$r = $this->page_db->get_one(array('catid'=>$catid));
			if($r) extract($r);
			include template('mobile', $page_template);
			
			}
	}
	
	
	
    //展示内容页
	public function show() {
		$mobile = $this->mobile;
		$cates=$this->cates;
		$GLOBALS['siteid'] = $siteid = max($this->siteid,1);
		$catid =intval($_GET['catid']);	
		$id = intval($_GET['id']);
		if(!$catid || !$id) exit(L('parameter_error'));
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS =$this->categorys;
		$page = intval($_GET['page']);
		$page = max($page,1);

		if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) exit(L('information_does_not_exist','','content'));
		$this->category = $CAT = $CATEGORYS[$catid];
		$this->category_setting = $CAT['setting'] = string2array($this->category['setting']);
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		$MODEL = getcache('model','commons');
		$modelid = $CAT['modelid'];
		$tablename = $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
		$r = $this->db->get_one(array('id'=>$id));
		if(!$r || $r['status'] != 99) showmessage(L('info_does_not_exists'),'blank');
		
		
		//上一页
		$previous_page = $this->db->get_one("`catid` = '$catid' AND `id`<'$id' AND `status`=99",'*','id DESC');
		if(empty($previous_page)) {
			$previous_page = array('title'=>'第一篇', 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\'最后一篇\');');
		}else{
		$previous_page['url']=show_url($catid,$previous_page['id']);
		}
		//下一页
		$next_page = $this->db->get_one("`catid`= '$catid' AND `id`>'$id' AND `status`=99",'*','id ASC');
        if(empty($next_page)) {
			$next_page = array('title'=>'最后一篇', 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\'第一篇\');');
		}else{
		$next_page['url']=show_url($catid,$next_page['id']);
		}
		
		
		$this->db->table_name = $tablename.'_data';
		$r2 = $this->db->get_one(array('id'=>$id));
		$rs = $r2 ? array_merge($r,$r2) : $r;

		//再次重新赋值，以数据库为准
		$catid = $CATEGORYS[$r['catid']]['catid'];
		$modelid = $CATEGORYS[$catid]['modelid'];
		
		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$content_output = new content_output($modelid,$catid,$CATEGORYS);
		$data = $content_output->get($rs);
		extract($data);
		
		$show_template = $template ? $template : $CAT['setting']['show_template'];
		if(!$show_template) $show_template = 'show';
		include template('mobile', $show_template);
	}
	
	
	//导航页
	function maps() {
		$CATEGORYS =$this->categorys;
		$mobile = $this->mobile;
		$cates=$this->cates;
		$GLOBALS['siteid'] = $siteid = max($this->siteid,1);
		include template('mobile', 'maps');
	}
	
	
}
?>