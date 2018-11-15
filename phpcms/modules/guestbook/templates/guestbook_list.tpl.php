<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-lr-10">
  <table width="100%" cellspacing="0" class="search-form">
    <tbody>
      <tr>
        <td><div class="explain-col"> <?php echo L('all_linktype')?>: &nbsp;&nbsp; <a href="?m=guestbook&c=guestbook"><?php echo L('all')?></a> &nbsp;&nbsp; <a href="?m=guestbook&c=guestbook&typeid=0">默认分类</a>&nbsp;
            <?php
	if(is_array($type_arr)){
	foreach($type_arr as $typeid => $type){
		?>
            <a href="?m=guestbook&c=guestbook&typeid=<?php echo $typeid;?>"><?php echo $type;?></a>&nbsp;
            <?php }}?>
          </div></td>
      </tr>
    </tbody>
  </table>
  <form name="myform" id="myform" action="?m=guestbook&c=guestbook&a=listorder" method="post" >
    <div class="table-list">
      <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('guestid[]');"></th>
            <th width="35" align="center"><?php echo L('listorder')?></th>
            <th align="center"><?php echo L('guestbook_name')?></th>
            <th align="center"><?php echo L('sex')?></th>
            <th align="center"><?php echo L('lxqq')?></th>
            <th align="center"><?php echo L('email')?></th>
            <th align="center"><?php echo L('shouji')?></th>
            <th align="center"><?php echo L('web_description')?></th>
            <th align="center"><?php echo L('typeid')?></th>
            <th align="center"><?php echo L('lytime')?></th>
            <th width="8%" align="center"><?php echo L('status')?></th>
            <th width="12%" align="center"><?php echo L('operations_manage')?></th>
          </tr>
        </thead>
        <tbody>
          <?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
          <tr>
            <td align="center" width="35"><input type="checkbox" name="guestid[]" value="<?php echo $info['guestid']?>"></td>
            <td align="center" width="35"><input name='listorders[<?php echo $info['linkid']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c"></td>
            <td align="center"><?php echo $info['name']?></td>
            <td align="center"><?php echo $info['sex']?></td>
            <td align="center"><?php echo $info['lxqq'];?></td>
            <td align="center" style="color:#004499"><?php echo $info['email'];?></td>
            <td align="center"><?php echo $info['shouji'];?></td>
            <td align="center" style="color:#004499"><?php echo str_cut($info['introduce'] ,'50');?></td>
            <td align="center"><?php if($info['typeid']==0){echo "默认分类";}else{echo $type_arr[$info['typeid']];}?></td>
            <td align="center"><?php echo date('Y-m-d H:i:s',$info['addtime']);?></td>
            <td width="8%" align="center"><?php if($info['passed']=='0'){?>
              <a
			href='?m=guestbook&c=guestbook&a=check&guestid=<?php echo $info['guestid']?>'
			onClick="return confirm('<?php echo L('pass_or_not')?>')"><font color=red><?php echo L('audit')?></font></a>
              <?php }else{echo L('passed');}?>
              <br>
              <?php if($info['reply']==''){ echo "<font color=red>【未回复】</font>";}else{echo "<font color=green>【已回复】</font>";}?>
              </td>
            <td align="center" width="12%"><a href="###"
			onclick="show(<?php echo $info['guestid']?>, '<?php echo new_addslashes($info['name'])?>')"
			title="<?php echo L('reply')?>"><?php echo L('reply')?></a> | <a
			href='?m=guestbook&c=guestbook&a=delete&guestid=<?php echo $info['guestid']?>'
			onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes($info['name'])))?>')"><?php echo L('delete')?></a></td>
          </tr>
          <?php
	}
}
?>
        </tbody>
      </table>
    </div>
    <div class="btn">
      <input name="dosubmit" type="submit" class="button"
	value="<?php echo L('listorder')?>">
      &nbsp;&nbsp;
      <input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?m=guestbook&c=guestbook&a=delete'" value="<?php echo L('delete')?>"/>
    </div>
    <div id="pages"><?php echo $pages?></div>
  </form>
</div>
<script type="text/javascript">

function show(id, name) {
	window.top.art.dialog({id:'show'}).close();
	window.top.art.dialog({title:'<?php echo L('show')?> '+name+' ',id:'show',iframe:'?m=guestbook&c=guestbook&a=show&guestid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'show'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'show'}).close()});
}
function checkuid() {
	var ids='';
	$("input[name='linkid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:"<?php echo L('before_select_operations')?>",lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}
//向下移动
function listorder_up(id) {
	$.get('?m=guestbook&c=guestbook&a=listorder_up&guestid='+id,null,function (msg) { 
	if (msg==1) { 
	//$("div [id=\'option"+id+"\']").remove(); 
		alert('<?php echo L('move_success')?>');
	} else {
	alert(msg); 
	} 
	}); 
} 
</script>
</body></html>