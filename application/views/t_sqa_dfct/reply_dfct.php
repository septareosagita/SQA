<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
    function msg_err(err) {
    	var html = '<div id="awal" class="message warning"><blockquote id="block_msg"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + err + '</p></blockquote></div>';
    	$('#widget_main').html(html);
    	javascript:scroll(0,0);
    }

    function msg_del() {
	   $('#widget_main').html('');
    }
</script>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SQA PROBLEM SHEET</title>

</head>

<body>

<input type="hidden" id="app_pdate" name="app_pdate" value="<?= $app_pdate; //T-SQA_DFCT ?>"> 
<input type="hidden" id="reply_pdate_ot" name="reply_pdate_ot" value="<?= $reply_pdate;?>">
<input type="hidden" id="reply_userid_ot" name="reply_userid_ot" value="<?= $pln_user;?>">
<input type="hidden" id="reply_pdate_of" name="reply_pdate_of" value="<?= $reply_pdate;?>">
<input type="hidden" id="reply_userid_of" name="reply_userid_of" value="<?= $pln_user;?>">
<input type="hidden" id="reply_pdate_rt" name="reply_pdate_rt" value="<?= $reply_pdate;?>">
<input type="hidden" id="reply_userid_rt" name="reply_userid_rt" value="<?= $pln_user;?>">
<input type="hidden" id="reply_pdate_rf" name="reply_pdate_rf" value="<?= $reply_pdate;?>">
<input type="hidden" id="reply_userid_rf" name="reply_userid_rf" value="<?= $pln_user;?>">


<? 
foreach($list_reply as $ii): 
if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') 
{ 
$reply_id_ot=$ii->PROBLEM_REPLY_ID;
$app_pdate_reply_ot=$ii->APPROVE_PDATE;
$reply_type_ot='O';$countermeasure_type_ot='T';
} 
elseif ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') 
{ 
$reply_id_of=$ii->PROBLEM_REPLY_ID;
$app_pdate_reply_of=$ii->APPROVE_PDATE;
$reply_type_of='O';$countermeasure_type_of='F';
} 
elseif ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') 
{ 
$reply_id_rt=$ii->PROBLEM_REPLY_ID;
$app_pdate_reply_rt=$ii->APPROVE_PDATE;
$reply_type_rt='R';$countermeasure_type_rt='T';
} 
elseif ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') 
{ 
$reply_id_rf=$ii->PROBLEM_REPLY_ID;
$app_pdate_reply_rf=$ii->APPROVE_PDATE;
$reply_type_rf='R';$countermeasure_type_rf='F';
} 
endforeach;
?>
<input type="hidden" id="problem_reply_id_ot" name="problem_reply_id_ot" value="<?= $reply_id_ot;?>">
<input type="hidden" id="problem_reply_id_of" name="problem_reply_id_of" value="<?= $reply_id_of;?>">
<input type="hidden" id="problem_reply_id_rt" name="problem_reply_id_rt" value="<?= $reply_id_rt;?>">
<input type="hidden" id="problem_reply_id_rf" name="problem_reply_id_rf" value="<?= $reply_id_rf;?>">

<input type="hidden" id="reply_type_ot" name="reply_type_ot" value="<?= $reply_type_ot;?>">
<input type="hidden" id="reply_type_of" name="reply_type_of" value="<?= $reply_type_of;?>">
<input type="hidden" id="reply_type_rt" name="reply_type_rt" value="<?= $reply_type_rt;?>">
<input type="hidden" id="reply_type_rf" name="reply_type_rf" value="<?= $reply_type_rf;?>">

<input type="hidden" id="countermeasure_type_ot" name="countermeasure_type_ot" value="<?= $countermeasure_type_ot;?>">
<input type="hidden" id="countermeasure_type_of" name="countermeasure_type_of" value="<?= $countermeasure_type_of;?>">
<input type="hidden" id="countermeasure_type_rt" name="countermeasure_type_rt" value="<?= $countermeasure_type_rt;?>">
<input type="hidden" id="countermeasure_type_rf" name="countermeasure_type_rf" value="<?= $countermeasure_type_rf;?>">

<div class="widget">
	<span id="widget_main"></span>

<? if ($err != "") {
            echo "<div id+'awal' class='message warning'><blockquote id='block_msg'><p>" . $err . "</p></blockquote></div>";
			echo "<script type='text/javascript'>	javascript:scroll(0,0)</script>";

								}?> 
       <div style="margin-left:5px;margin-top:105px; position: absolute; border-bottom:1px solid #CCCCCC; border-left:1px solid #CCCCCC;border-top:1px solid #CCCCCC; width:261px; height:230px">&nbsp;SKETCH :<br /><img src="<? echo PATH_IMG_URL.$main_img;?>" height="180" width="250" style="margin-left:5px"/><div align="center">Main Image</div></div>
<div style="margin-top:105px; margin-left:264px; position: absolute; border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;border-top:1px solid #CCCCCC;height:230px"><br /><img src="<? echo PATH_IMG_URL.$part_img;?>" height="180" width="250" style="margin-right:5px"/><div align="center">Part Image</div></div>
<div style="margin-top:5px; width:1160px">
<table width="990px" border="0" align="left">
  <tr>
    <td height="30" colspan="10" align="center"><header><h2>SQA PROBLEM SHEET</h2></header></td>
  </tr>
  <tr>
    <td width="77" nowrap="nowrap"><span class="style1">&nbsp;PS NO.</span></td>
    <td width="3">:</td>
    <td colspan="3">&nbsp;<?= $prb_sheet_num ?></td> 	 
    <td width="54" nowrap="nowrap"><span class="style1">Model.</span></td>
    <td width="200" nowrap="nowrap">: <span class="style1">
      <?= $katashiki;?>
    </span></td>
    <td width="78" nowrap="nowrap" ><span class="style1">Issue Date.</span></td>
    <td width="17" nowrap="nowrap">:&nbsp;</td>
    <td width="104"><span class="style1">
      <?= ($assy_pdate !='')? date('d M Y', strtotime($assy_pdate)) : '-'; ?>
    </span></td>
  </tr>
  <tr>
    <td nowrap="nowrap"><span class="style1">&nbsp;SQPR NO.</span></td>
    <td>:</td>
    <td colspan="3">&nbsp;<?= $sqpr_num?></td>
    <td width="54" nowrap="nowrap"><span class="style1">Shift.</span></td>
    <td>:<span class="style1">
      <?= $sqa_shiftgrpnm;?>
      - Day</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap"><span class="style1">&nbsp;PROBLEM</span></td>
    <td>:</td>
    <td colspan="3">&nbsp;<span style="font-size:14px; font-weight:bold"><?= $dfct_desc;?></span></td>
    <td colspan="5" nowrap="nowrap"><span class="style1">Responsible Shop :&nbsp;
          <?= $shop_nm;?>
    </span></td>
  </tr>
</table></div><br/>
<div style="margin-left:539px; width:750px">
 <table width="526" border="0" align="left">
   <tr>
    <td width="111" align="left" valign="top" nowrap="nowrap"><p class="style1">Auditor 1<br />
        Auditor 2<br />
        Plant<br />
        Stall<br /></p>
        <span class="style5" style="text-decoration:underline";><b>VEHICLE DATA</b></span><br />
        Body No.<br />
        Frame No.<br />
        Suffix No.<br />
        Seq Body No.<br />
        Seq Assy No.<br />
        Model code.<br />
        Inspection  Date.<br />
        Production  Date.<br />
        Color<br />
        </p></td>
    <td colspan="2" valign="top" ><span class="style1">:&nbsp;<?=$auditor1;?>
      <br />:&nbsp;<?= $auditor2;?>
    <br />
    :</span><span class="style1">&nbsp;<?= $plant_nm;?>
    </span><br />
    <span class="style1">:</span>&nbsp;<?= $dfct_stall . ' ' . $dfct_stall_desc;?><br />
    &nbsp;<br />
    <span class="style1">:&nbsp;<?= $bodyno;?>
    <br />
    :</span>
    <?= $frame_no;?>
    <br />
    <span class="style1">:</span>
    <?= $suffix;?>
    <br />
    <span class="style1">:</span>
    <?= $bd_seq;?>
    <br />
    <span class="style1">:</span>
    <?= $assy_seq;?>
    <br />
    <span class="style1">:</span>
    <?= $katashiki;?>
    <br />
    <span class="style1">:</span>
    <?= ($insp_pdate !='')? date('d M Y', strtotime($insp_pdate)) : '-'; ?>
    <br />
    <span class="style1">:
    <?= ($assy_pdate !='')? date('d M Y', strtotime($assy_pdate)) : '-'; ?>
    <br />
    :
    <?= $color;?>
    </span></td>
    <td width="79" valign="top" nowrap="nowrap"><span class="style1">Checked By</span><br />
    <span class="style1">Approve  By </span>
    <!--Update by Ipan 20111216 1652 -->
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    (<?= $description; ?>)
    <!--  -->
    </td>
    <td width="10" valign="top" nowrap="nowrap"><span class="style1">:<br />
    </span>:</td>
    <td width="186" valign="top"><span class="style1">
      <?=$checked_by;?>
      <br />
      <?=$approved_by;?>
    </span>  
    </td>
  </tr>
 </table>
</div>
<div style="margin-top:340px;width:160px;background:#CCCCCC; font-weight:bold"><center>DETAIL PROBLEM</center></div>
    <div style="height:100px; border:1px solid #CCCCCC">
        <div style="margin-left:5px;width:100px;float:left">Actual</div>
        <div style="width:300px;float:left">:&nbsp;<?= $measurement;?></div>
        <div style="width:135px;float:left">Inspection Item</div>
        <div style="width:442px;float:left">:&nbsp;<?= $insp_item_flg;?></div>
       <? /* <div style="width:20px;float:left">&nbsp;<? if($attach_doc<> ""){?><img src="<?= base_url().'assets/img/attach.png';?>" onclick="window.location='<?= site_url('t_sqa_dfct/dl') ?>'" /><? };?></a></div>*/?>
        <div style="margin-left:5px;width:100px;float:left">Standard</div>
        <div style="width:300px;float:left">:&nbsp;<?= $refval;?></div>
        <div style="width:135px;float:left">Quality Gate Item</div>
        <div style="width:440px;float:left">:&nbsp;<?= $qlty_gt_item;?></div>
        <div style="margin-left:5px;width:100px;float:left">Rank</div>
        <div style="width:300px;float:left">:&nbsp;<?=$rank_nm . ' ' . $rank_nm2; ?></div>
        <div style="width:135px;float:left">History Repair Process</div>
        <div style="width:440px;float:left">:&nbsp;<?=$repair_flg;?></div>
        <div style="margin-left:5px;width:100px;float:left">Category Group</div>
        <div style="width:300px;float:left">:&nbsp;<?=$ctg_grp_nm; ?></div>
        <div style="width:135px;float:left">Confirmed by QCD</div>
        <div style="width:220px;float:left">:&nbsp;<? $confby='';foreach($list_dfct_conf as $i): if ($i->CONF_TYPE=='0') $confby=$confby.','.$i->CONF_BY; endforeach; 
		echo substr($confby,1.200);?></div>
        <div style="width:75px;float:left">Related Div</div>
        <div style="width:100px;float:left">:&nbsp;<? $confby='';foreach($list_dfct_conf as $i): if ($i->CONF_TYPE=='1') $confby=$confby.','.$i->CONF_BY; endforeach;
		echo substr($confby,1.200);?></div>
        <div style="margin-left:5px;width:100px;float:left">Category Name</div>
        <div style="width:600px;float:left">:&nbsp;<?= $ctg_nm;?></div>
  </div>

</div>
</body>
</html>

<script type="text/javascript">

    $(function(){                
        var max_size = 250;
        $(".mustresize").each(function(i) {
              if ($(this).height() > $(this).width()) {
                var h = max_size;
                var w = Math.ceil($(this).width() / $(this).height() * max_size);
              } else {
                var w = max_size;
                var h = Math.ceil($(this).height() / $(this).width() * max_size);
              }
              $(this).css({ height: h, width: w });
        });
    });
</script>