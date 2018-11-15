<?php


function list_url($catid) {
    return MOBILE_SITEURL."&amp;a=lists&amp;catid=$catid";
}


function show_url($catid, $id) {
	
    return MOBILE_SITEURL."&amp;a=show&amp;catid=$catid&amp;id=$id";
}


function list_pos($catid, $symbol=' > '){
	$cate_arr = getcache('mobile_cate','mobile');
	if(!isset($cate_arr[$catid])) return '';
	$pos = '';
	if($cate_arr[$catid]['parentid']!=0) {
		$pos = '<a href="'.list_url($cate_arr[$catid]['parentid']).'">'.$cate_arr[$cate_arr[$catid]['parentid']]['catname'].'</a>'.$symbol;
	}
	$pos .= '<a href="'.list_url($catid).'">'.$cate_arr[$catid]['catname'].'</a>'.$symbol;
	$symbol_len = strlen($symbol);
	$pos_len = strlen($pos);
	return substr($pos,0,$pos_len-$symbol_len);
}



/**
 * 获取子分类
 */
function subcate($parentid = NULL, $siteid = '') {
	if (empty($siteid)) $siteid = $GLOBALS['siteid'];
	$cates = getcache('mobile_cate','mobile');
	foreach($cates as $id=>$cate) {
		if($cate['siteid'] == $siteid && ($parentid === NULL || $cate['parentid'] == $parentid)) {
			$subcate[$id] = $cate;
		}
	}
	$subcate = array_sort($subcate,'listorder');
	return $subcate;
}
function array_sort($array,$keys,$type='asc'){
//$array为要排序的数组,$keys为要用来排序的键名,$type默认为升序排序
	$keysvalue = $new_array = array();
	foreach ($array as $k=>$v){
		$keysvalue[$k] = $v[$keys];
	}
	if($type == 'asc'){
		asort($keysvalue);
	}else{
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k=>$v){
		$new_array[$k] = $array[$k];
	}
	return $new_array;
}


/**
 * 分页函数
 * 
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $perpage 每页显示数
 * @param $urlrule URL规则
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 分页
 */
function wpa_pages($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(),$setpages = 10) {
	if(defined('URLRULE')) {
		$urlrule = URLRULE;
		$array = $GLOBALS['URL_ARRAY'];
	} elseif($urlrule == '') {
		$urlrule = url_par('page={$page}');
	}
	$multipage = '';
	if($num > $perpage) {
		$page = $setpages+1;
		$offset = ceil($setpages/2-1);
		$pages = ceil($num / $perpage);
		if (defined('IN_ADMIN') && !defined('PAGES')) define('PAGES', $pages);
		$from = $curr_page - $offset;
		$to = $curr_page + $offset;
		$more = 0;
		if($page >= $pages) {
			$from = 2;
			$to = $pages-1;
		} else {
			if($from <= 1) {
				$to = $page-1;
				$from = 2;
			}  elseif($to >= $pages) { 
				$from = $pages-($page-2);  
				$to = $pages-1;  
			}
			$more = 1;
		} 
		$multipage .= $curr_page.'/'.$pages;
		if($curr_page>0) {
			$multipage .= ' <a href="'.pageurl($urlrule, $curr_page-1, $array).'">'.L('previous').'</a>';
		}
		if($curr_page==$pages) {
			$multipage .= ' <a href="'.pageurl($urlrule, $curr_page, $array).'">'.L('next').'</a>';
		} else {
			$multipage .= ' <a href="'.pageurl($urlrule, $curr_page+1, $array).'">'.L('next').'</a>';
		}
		
	}
	return $multipage;
}


?>