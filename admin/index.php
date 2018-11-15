<?php
define('PHPCMS_PATH', realpath(dirname(__FILE__) . '/..') . '/');
include PHPCMS_PATH . '/phpcms/base.php';
pc_base::creat_app();
$session_storage = 'session_' . pc_base :: load_config('system', 'session_storage');
pc_base :: load_sys_class($session_storage);
session_start(); $_SESSION['right_enter'] = 1;
unset($session_storage);
header('location:../index.php?m=admin');