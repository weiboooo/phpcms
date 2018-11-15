<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'cm_conf', 'parentid'=>975, 'm'=>'customfield', 'c'=>'customfield', 'a'=>'manage_list', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'cm_conf', 'parentid'=>$parentid, 'm'=>'customfield', 'c'=>'customfield', 'a'=>'manage_list', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'cm_cate', 'parentid'=>$parentid, 'm'=>'customfield', 'c'=>'customfield', 'a'=>'category_list', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'customfiled', 'parentid'=>821, 'm'=>'customfield', 'c'=>'customfield', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$language = array('cm_conf'=>'字段设置','cm_cate'=>'分类管理','customfiled'=>'字段管理');
?>

