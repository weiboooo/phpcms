<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'mobile', 'parentid'=>29, 'm'=>'mobile', 'c'=>'mobile', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'mobile_add', 'parentid'=>$parentid, 'm'=>'mobile', 'c'=>'mobile', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'mobile_edit', 'parentid'=>$parentid, 'm'=>'mobile', 'c'=>'mobile', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'mobile_delete', 'parentid'=>$parentid, 'm'=>'mobile', 'c'=>'mobile', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'cate_manage', 'parentid'=>$parentid, 'm'=>'mobile', 'c'=>'mobile', 'a'=>'cate_manage', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$language = array('mobile'=>'手机模块','mobile_add'=>'添加','mobile_edit'=>'修改','mobile_delete'=>'删除','cate_manage'=>'分类管理');
?>