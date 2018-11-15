<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html>
<head>
<title>后台管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<meta name="author" content="muntime.com" />
<link href="<?php echo CSS_PATH?>muntime/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>muntime/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH?>muntime/styles1.css" title="styles1" media="screen" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo CSS_PATH?>muntime/styles2.css" title="styles2" media="screen" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo CSS_PATH?>muntime/styles3.css" title="styles3" media="screen" />

<script type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>styleswitch.js"></script>
<script type="text/javascript" src="<?php echo CSS_PATH?>muntime/Particleground.js"></script>

<style type="text/css">html,body{height: 100%;position: relative;}</style>
<script language="JavaScript">
<!--
	if(top!=self)
	if(self!=top) top.location=self.location;
//-->
</script>

<script>
$(document).ready(function() {
  $('body').particleground({
    dotColor: 'rgba(255,255,255,0.2)',
    lineColor: 'rgba(255,255,255,0.2)'
  });
});
</script>

</head>
<body onload="javascript:document.myform.username.focus();" id="canvas">
  <div class="admin_login">
    <form action="index.php?m=admin&c=index&a=login&dosubmit=1" method="post" name="myform">
    <div class="admin_title">
       <strong>站点后台管理系统</strong>
       <em>Management System</em>
    </div>
    <div class="admin_user">
       <input type="text" name="username" placeholder="账号" class="login_txt">
    </div>
    <div class="admin_pwd">
       <input type="password" name="password" placeholder="密码" class="login_txt">
    </div>
    <div class="admin_val">
       <input type="text" name="code" placeholder="验证码" maxlength="4" class="login_txt left">
       <div id="yzm" class="right"><?php echo form::checkcode('code_img')?></div>
    </div>
    <div class="admin_sub">
        <input type="submit" value="立即登陆" class="submit_btn">
    </div>

    </form>   
  </div>
</body>
</html>