<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'guestbook', 'parentid'=>29, 'm'=>'guestbook', 'c'=>'guestbook', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'add_guestbook', 'parentid'=>$parentid, 'm'=>'guestbook', 'c'=>'guestbook', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_guestbook', 'parentid'=>$parentid, 'm'=>'guestbook', 'c'=>'guestbook', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'delete_guestbook', 'parentid'=>$parentid, 'm'=>'guestbook', 'c'=>'guestbook', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'guestbook_setting', 'parentid'=>$parentid, 'm'=>'guestbook', 'c'=>'guestbook', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'add_type', 'parentid'=>$parentid, 'm'=>'guestbook', 'c'=>'guestbook', 'a'=>'add_type', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'list_type', 'parentid'=>$parentid, 'm'=>'guestbook', 'c'=>'guestbook', 'a'=>'list_type', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'check_register', 'parentid'=>$parentid, 'm'=>'guestbook', 'c'=>'guestbook', 'a'=>'check_register', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'show_guestbook', 'parentid'=>$parentid, 'm'=>'guestbook', 'c'=>'guestbook', 'a'=>'show', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'check_guestbook', 'parentid'=>$parentid, 'm'=>'guestbook', 'c'=>'guestbook', 'a'=>'check', 'data'=>'', 'listorder'=>0, 'display'=>'0'));


$language = array('guestbook'=>'留言板', 'edit_guestbook'=>'编辑留言板', 'delete_guestbook'=>'删除留言板', 'guestbook_setting'=>'模块配置', 'add_type'=>'添加类别', 'list_type'=>'分类管理', 'check_register'=>'审核申请');
?>