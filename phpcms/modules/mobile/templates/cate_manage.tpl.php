<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-lr-10">
<div class="table-list">
<form name="myform" action="?m=mobile&c=mobile&a=cate_listorder" method="post" >
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
           <th width="10%"  align="center"><?php echo L('listorder')?></th>
            <th width="10%" align='center'>类型ID</th>
            <th width="40%" align="left"><?php echo L('mobile_cate_name')?></th>
            <th width="20%"><?php echo L('status')?></th>
            </tr>
        </thead>
        <tbody>  
         <?php
if(is_array($tree)){
	foreach($tree as $v){
		?>
	<tr>
		<td align="center" ><input name='listorders[<?php echo $v['catid']?>]' type='text' size='3' value='<?php echo $v['listorder']?>' class="input-text-c"></td>
		<td align="center"><?php echo $v['catid']; ?></td>
		<td align="left" ><a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['level'];?><?php echo $v['catname'];?></a></td>
		<td align="center"><a href="?m=mobile&c=mobile&a=cate_status&catid=<?php echo $v['catid']?>&status=<?php echo $v['status'];?>"><?php if($v['status']==1){ echo "显示";}else{ echo "隐藏";} ?></a></td>
		
	</tr>
	<?php
	}
}
?>
        </tbody>

    </table>

    <div class="btn">
    <input type="submit" class="button" name="dosubmit" value="排序"  />
   </div> 
</form>
 </div>
</div>
</div>
</body>
</html>
<script type="text/javascript">
	
	function confirm_delete(){
		if(confirm('<?php echo L('confirm_delete');?>')) $('#myform').submit();
	}	
</script>