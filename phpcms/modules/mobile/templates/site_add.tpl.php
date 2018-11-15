<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-10">
<form action="?m=mobile&c=mobile&a=add" name="myform" method="post" id="myform">
<input type="hidden" value='<?php echo $siteid?>' name="siteid">
<fieldset>
	<legend><?php echo L('basic_config')?></legend>
	<table width="100%"  class="table_form">
    <tr>
    <th width="120"><?php echo L('mobile_sel_site')?></th>
    <td class="y-bg"><?php echo form::select($sitelist,self::get_siteid(),'name="siteid"')?></td>
    </tr>
    <tr>
    <th width="120"><?php echo L('mobile_sitename')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="sitename" id="sitename" size="30" value=""/></td>
    </tr>
  
    <tr>
    <th width="120"><?php echo L('mobile_logo')?></th>
    <td class="y-bg"><?php echo form::images('logo', 'logo', '', 'mobile')?></td>
    </tr>
    <tr>
    <th width="120"><?php echo L('mobile_domain')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="domain" id="domain" size="30" value=""/> </td>
    </tr>
     <tr>
    <th width="120"><?php echo L('mobile_keywords')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="keywords" id="keywords" size="60" value=""/></td>
    </tr>
     <tr>
    <th width="120"><?php echo L('mobile_description')?></th>
    <td class="y-bg">
    <textarea style="height: 100px; width: 430px; resize:none;"  cols="20" rows="2" name="description"></textarea>
    </td>
    </tr>      
    </table> 
  </fieldset>
 
<input type="submit" id="dosubmit" name="dosubmit" class="dialog" value="<?php echo L('submit')?>" />

</form>
</div>
</body>
</html>