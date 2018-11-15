<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class MY_index extends index {
    public function __construct() {
        if(empty($_SESSION['right_enter'])) {
            header('location:./');exit;
        }
        parent::__construct();
    }
    public function public_logout() {
        $_SESSION['right_enter'] = 0;
        parent::public_logout();
    }
}