<?php
include $this->admin_tpl('header','admin');
?>

<script type="text/javascript">
    <!--
    $(function(){
        $.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});

        $("#guestbook_name").formValidator({onshow:"<?php echo L("input").L('guestbook_name')?>",onfocus:"<?php echo L("input").L('guestbook_name')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('guestbook_name')?>"}).ajaxValidator({type : "get",url : "",data :"m=guestbook&c=guestbook&a=public_name&guestid=<?php echo $guestid;?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('guestbook_name').L('exists')?>",onwait : "<?php echo L('connecting')?>"}).defaultPassed();



    })
    //-->
</script>
<link href="/statics/css/default_blue.css" rel="stylesheet" type="text/css" />
<div class="pad_10">
    <form action="?m=comment&c=comment_admin&a=reply&id=<?php echo $id; ?>&commentid=<?php echo $commentid;?>" method="post" name="myform" id="myform">
        <div class="comment">
            <h5 class="title fn"> <font color="#FF0000"><?php echo date("Y-m-d H:i:s",$data['creat_at'])?></font> <?php echo get_memberinfo($data['userid'],'nickname');?>(<?php echo $data['username']?>) </h5>
            <div class="content">
                <?php echo $data['content'];?>
            </div>
            <div class="bk30 hr mb8"></div>
        </div>
        <h5><strong>回复内容</strong></h5>
        <textarea rows="8" cols="80" name="content"></textarea>
        <table cellpadding="2" cellspacing="1" class="table_form" width="100%">
            <tr>
                <th></th>
                <td><input type="hidden" name="forward" value="?m=comment&c=comment_admin&a=reply"> <input
                        type="submit" name="dosubmit" id="dosubmit" class="dialog"
                        value=" <?php echo L('submit')?> "></td>
            </tr>

        </table>
    </form>
</div>
</body>
</html>

