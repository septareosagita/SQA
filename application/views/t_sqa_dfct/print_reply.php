
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SQA PROBLEM SHEET</title>

<script type="text/javascript">
function loadawal(){
var check_pdate =  $('#check_pdate').val();
var approve_pdate =  $('#approve_pdate').val();
var sqpr_num =  $('#sqpr_num').val();
var close_flg =  $('#close_flg').val();
var is_deleted =  $('#is_deleted').val();

var approve_pdate_sqareply_ot =$('#approve_pdate_sqareply_ot').val();
var approve_pdate_sqareply_of =$('#approve_pdate_sqareply_of').val();
var approve_pdate_sqareply_rt =$('#approve_pdate_sqareply_rt').val();
var approve_pdate_sqareply_rf =$('#approve_pdate_sqareply_rf').val();

if (close_flg =='1' || is_deleted =='1'){
            $('#checked').attr("disabled","disabled");
            $('#unchecked').attr("disabled","disabled");
			$('#approve').attr("disabled","disabled");
            $('#unapprove').attr("disabled","disabled");
			$('#ps_closed').attr("disabled","disabled");
            $('#reply').attr("disabled","disabled");
			$('#print').attr("disabled","disabled");
            $('#unsqpr').attr("disabled","disabled");
			$('#sqpr').attr("disabled","disabled");
			$('#download').attr("disabled","disabled");
			
			if(check_pdate !='') {
					$('#unchecked').show();
					$('#checked').hide();
				}
				else {
					$('#unchecked').hide();
					$('#checked').show();
				}	
			
				if(approve_pdate !='') {
					$('#approve').hide();
					$('#unapprove').show();    
					
					}
				else {
					
					$('#approve').show();
					$('#unapprove').hide();
				}	
	
				if(sqpr_num!='') {
					$('#unsqpr').show();
					$('#sqpr').hide();
					}
				else {
					$('#sqpr').show();
					$('#unsqpr').hide();
				}	
				
			}
            else {
			$('#checked').removeAttr('disabled');
            $('#unchecked').removeAttr('disabled');
			$('#approve').removeAttr('disabled');
            $('#unapprove').removeAttr('disabled');
			$('#ps_closed').removeAttr('disabled');
            $('#reply').removeAttr('disabled');
			$('#print').removeAttr('disabled');
            $('#unsqpr').removeAttr('disabled');
			$('#sqpr').removeAttr('disabled');
			$('#download').removeAttr('disabled');
			
				if(check_pdate !='') {
					$('#unchecked').show();
					$('#approve').removeAttr('disabled');
					$('#ps_closed').removeAttr('disabled');
					$('#unsqpr').removeAttr('disabled');
					$('#checked').hide();
				}
				else {
					$('#unchecked').hide();
					$('#checked').show();
					$('#approve').attr("disabled","disabled");	
				}	
			
				if(approve_pdate !='') {
					$('#approve').hide();
					$('#unapprove').show();    
					$('#reply').removeAttr('disabled');
					$('#ps_closed').attr("disabled","disabled");	
					}
				else {
					$('#approve').show();
					$('#unapprove').hide();
					$('#reply').attr("disabled","disabled");
					$('#ps_closed').attr("disabled","disabled");	
					$('#sqpr').attr("disabled","disabled");	
				
				}	
	
				if(sqpr_num!='') {
					$('#unsqpr').show();
					$('#sqpr').hide();
					$('#ps_closed').removeAttr('disabled');
					}
				else {
					$('#sqpr').show();
					$('#unsqpr').hide();
					$('#ps_closed').attr("disabled","disabled");	
				}	
				
		}
        
        /*
		          // set portrait orientation
   jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
   // set scalling
   jsPrintSetup.setOption('scaling', 70);
   
   // set top margins in millimeters
   jsPrintSetup.setOption('marginTop', 10);
   jsPrintSetup.setOption('marginBottom', 15);
   jsPrintSetup.setOption('marginLeft', 5);
   jsPrintSetup.setOption('marginRight', 10);
   // set page header
   jsPrintSetup.setOption('headerStrLeft', '&T');
   jsPrintSetup.setOption('headerStrCenter', '');
   jsPrintSetup.setOption('headerStrRight', '&PT');
   // set empty page footer
   jsPrintSetup.setOption('footerStrLeft', '');
   jsPrintSetup.setOption('footerStrCenter', '');
   jsPrintSetup.setOption('footerStrRight', '');
   // clears user preferences always silent print value
   // to enable using 'printSilent' option
   //jsPrintSetup.clearSilentPrint();
   // Suppress print dialog (for this context only)
   //jsPrintSetup.setOption('printSilent', 1);
   // Do Print 
   // When print is submitted it is executed asynchronous and
   // script flow continues after print independently of completetion of print process! 
   jsPrintSetup.print();
   */
        window.print();
		//setTimeout('window.close()',3000);
        //alert ("Print Document Succesful");
  }	
		
</script>

</head>
<? 
foreach($list_reply as $ii): 
if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') 
{ 
$reply_id_ot=$ii->PROBLEM_REPLY_ID;
$approve_pdate_sqareply_ot=$ii->APPROVE_PDATE;
} 
elseif ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') 
{ 
$reply_id_of=$ii->PROBLEM_REPLY_ID;
$approve_pdate_sqareply_of=$ii->APPROVE_PDATE;
} 
elseif ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') 
{ 
$reply_id_rt=$ii->PROBLEM_REPLY_ID;
$approve_pdate_sqareply_rt=$ii->APPROVE_PDATE;
} 
elseif ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') 
{ 
$reply_id_rf=$ii->PROBLEM_REPLY_ID;
$approve_pdate_sqareply_rf=$ii->APPROVE_PDATE;
} 
endforeach;

?>
<input type="hidden" value="<?=$check_pdate;?>" id="check_pdate"/>
<input type="hidden" value="<?=$app_pdate;?>" id="approve_pdate"/>
<input type="hidden" value="<?=$sqpr_num;?>" id="sqpr_num"/>
<input type="hidden" value="<?=$close_flg;?>" id="close_flg"/>
<input type="hidden" value="<?=$is_deleted;?>" id="is_deleted"/>
<input type="hidden" value="<?=$vinno;?>" id="vinno"/>
<input type="hidden" value="<?=$problem_id;?>" id="problem_id"/>
<input type="hidden" value="<?=$reply_pdate;?>" id="prdt_pdate"/>


<input type="hidden" value="<?=$approve_pdate_sqareply_ot;?>" id="approve_pdate_sqareply_ot"/>
<input type="hidden" value="<?=$approve_pdate_sqareply_of;?>" id="approve_pdate_sqareply_of"/>
<input type="hidden" value="<?=$approve_pdate_sqareply_rt;?>" id="approve_pdate_sqareply_rt"/>
<input type="hidden" value="<?=$approve_pdate_sqareply_rf;?>" id="approve_pdate_sqareply_rf"/>


<body >
<div class="widget" >
<div style="margin-left:5px;margin-top:175px; position: absolute; border-bottom:double; border-left:double;border-top:double; width:261px; height:230px">SKETCH :<br /><img src="<? echo PATH_IMG_URL.$main_img;?>" height="180" width="250" /><div align="center">Main Image</div></div>
<div style="margin-top:175px; margin-left:264px; position: absolute; border-bottom:double; border-right:double;border-top:double;height:230px"><br /><img src="<? echo PATH_IMG_URL.$part_img;?>" height="180" width="250" /><div align="center">Part Image</div></div>


<div style="margin-top:5px; width:100%">
<table width="100%" border="0" align="left">
  <tr>
    <td height="30" colspan="10" align="center"><header><H2>SQA PROBLEM SHEET</H2></header></td>
  </tr>
  <tr>
    <td width="77" nowrap="nowrap"><span class="style1">&nbsp;PS NO.</span></td>
    <td width="3">:</td>
    <td colspan="3">&nbsp;<?= $prb_sheet_num ?></td>
    <td width="69" nowrap="nowrap"><span class="style1">Model.</span></td>
    <td width="204" nowrap="nowrap">: <span class="style1">
      <?= $katashiki;?>
    </span></td>
    <td width="68" nowrap="nowrap" ><span class="style1">Issue Date.</span></td>
    <td width="7" nowrap="nowrap">:&nbsp;</td>
    <td width="92" align="right"><span class="style1">      
      <?= ($assy_pdate !='')? date('d M Y', strtotime($assy_pdate)) : '-'; ?>
    </span></td>
  </tr>
  <tr>
    <td nowrap="nowrap"><span class="style1">&nbsp;SQPR NO.</span></td>
    <td>:</td>
    <td colspan="3">&nbsp;<?= $sqpr_num?></td>
    <td width="69" nowrap="nowrap"><span class="style1">Shift.</span></td>
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
    <td colspan="3">&nbsp;
        <?= $dfct_desc;?></td>
    <td colspan="5" nowrap="nowrap"><span class="style1">Responsible Shop :&nbsp;
          <?= $shop_nm;?>
    </span></td>
  </tr>
</table></div><br/>
<div style="margin-left:520px; width:750px; margin-top:10px">
 <table width="526" border="0" align="left">
   <tr>
    <td width="120" align="left" valign="top" nowrap="nowrap"><p>Auditor 1<br />
        Auditor 2<br />
        Plant<br />
        Stall<br /></p>
        <span class="style5">VEHICLE DATA</span><br />
        Body No.<br />
        Frame No.<br />
        Suffix No.<br />
        Seq Body No.<br />
        Seq Assy No.<br />
        Model code.<br />
        Inspection  Date.<br />
        Production  Date.<br />
        Color<br /></p>
        </td>
    <td colspan="2" valign="top"><p><span class="style1">:&nbsp;<?=$auditor1;?>
      <br />:&nbsp;<?= $auditor2;?>
    <br />
    :</span><span class="style1">&nbsp;<?= $plant_nm;?>
    </span><br />
    <span class="style1">:</span>&nbsp;<?= $dfct_stall . ' ' . $dfct_stall_desc; ?><br />
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
    </span></p></td>
    <td width="79" valign="top" nowrap="nowrap"><p><span class="style1">
      Checked By</span><br />
    <span class="style1">Approve  By </span></p>
    <!--Update by Ipan 20111216 1652 -->
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    (<?= $description; ?>)
    <!--  -->
    </td>
    <td width="10" valign="top" nowrap="nowrap"> <p span class="style1">
      :<br />
    </span>:</td>
    <td width="85" valign="top"><p><span class="style1">
      
      <?=$checked_by;?>
      <br />
      <?=$approved_by;?>
    </span><br /></p></td>
  </tr>
 </table>
</div>
<div style="margin-top:340px;width:250px;background:#CCCCCC; font-weight:bold;"><left>DETAIL PROBLEM</left></div>
    <div style="height:100px; border:solid; width:1000px;">
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
<div style="margin-top:5px;width:250px;background:#CCCCCC; font-weight:bold"><left>INVESTIGATION RESULT</left></div>
    <div style="height:660px; border:solid; width:1000px ">

        <div style="margin-left:5px;width:900px;float:left">1. Why Outflow</div>
        <div style="margin-left:18px;width:200px;float:left">a. Temporary Action</div>
        <div style="width:250px;float:left">Due Date :&nbsp;<? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') { date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></div>
        <div style="width:190px;float:left">Status :&nbsp;<? 
		foreach($list_reply as $ii):
		 if($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') 
		 {
		 	if ($ii->APPROVE_SYSDATE=='') {echo "Not Yet Reply";}
			elseif ($ii->APPROVE_SYSDATE > $ii->DUE_DATE) {echo "Delay";} 
			elseif ($ii->APPROVE_SYSDATE <= $ii->DUE_DATE) { echo "On Time";}
		} 
		endforeach;?>
	  </div><br/>
        <table width="100%" border="0" style="margin-left:12px">
        <form  style="margin-left:12px" name="why_outflow" method="post" action="">
        <tr>
          <td colspan="12"><label>
           <div style="border:solid; width:965px"><textarea rows="4" cols="120" id="reply_comment_ot"><? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') { echo $ii->REPLY_COMMENT;} endforeach;?></textarea></div>
          &nbsp;<a href= <img src="<?= base_url().'assets/img/attach.png';?>"/></label></td>
        </tr>
        <tr>
          <td width="20" nowrap style="margin-left:25px">&nbsp;</td>
          <td width="105" nowrap="nowrap" style="margin-left:25px">Created by <br />
          Last Edited by<br /></td>
          <td width="7">:&nbsp;<br />
            :&nbsp;</td>
          <td width="225" nowrap="nowrap"><? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->REPLY_SYSDATE!='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?>
            <br />
          <? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->updatedt!='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
          <td width="96" nowrap>Approved by</td>
          <td width="7" nowrap="nowrap">:&nbsp;</td>
          <td width="208"><? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
          <div class="buttonreg">
          <td align="right" width="98"> <input disabled='disabled' class="button button-gray" type ='hidden' name='edit' id='edit' value='         Edit        ' onclick="btn_edit_ot()">          </td>
          <td align="right" width="105">
            <input disabled='disabled' class="button button-gray" type="hidden" name="approved" id="approved" value="Approved" >
          <td align="right" width="101"><input disabled='disabled'  class="button button-gray" type="hidden" name="edit3" id="edit3" value="        Save        "></td>
          <td align="right" width="111"><input disabled='disabled' class="button button-gray" type="hidden" name="edit5" id="edit5" value="Upload Attach" /></td>
          <td width="73">&nbsp;</td>
          </div>
        </tr>
        </form>
      </table>
<br/>
		<div style="margin-left:18px;width:200px;float:left;">b. Fix Action</div>
        <div style="width:250px;float:left">Due Date :&nbsp;<? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></div>
        <div style="width:190px;float:left">Status :&nbsp;
        <? 
		foreach($list_reply as $ii):
		 if($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') 
		 {
		 	if ($ii->APPROVE_SYSDATE=='') {echo "Not Yet Reply";}
			elseif ($ii->APPROVE_SYSDATE > $ii->DUE_DATE) {echo "Delay";} 
			elseif ($ii->APPROVE_SYSDATE <= $ii->DUE_DATE) { echo "On Time";}
		} 
		endforeach;?></div>
      <table width="100%" border="0" style="margin-left:12px">
        <form  style="margin-left:12px" name="form1" method="post" action="">
        <tr>
          <td colspan="12"><label>
            <div style="border:solid; width:965px"><textarea rows="4" cols="120" ><? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') { echo $ii->REPLY_COMMENT;} endforeach;?> </textarea></div>
          </label></td>
        </tr>
        <tr>
          <td width="21" nowrap style="margin-left:25px">&nbsp;</td>
          <td width="105" nowrap="nowrap" style="margin-left:25px">Created by <br />
          Last Edited by<br /></td>
          <td width="7">:&nbsp;<br />
          :&nbsp;</td>
          <td width="225" nowrap="nowrap"><? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->REPLY_SYSDATE !='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?>
            <br />
          <? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
          <td width="96" nowrap>Approved by</td>
          <td width="7">:&nbsp;</td>
          <td width="208"><? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
          <div class="buttonreg">
          <td align="right" width="98"><input disabled='disabled' class="button button-gray" type ='hidden'  name='edit' id='edit' value='         Edit        ' onclick=""> </td>
          <td align="right" width="105"><input disabled='disabled' class="button button-gray" type="hidden"  name="edit2" id="edit2" value="     Approved    " onclick=""></td>
          <td align="right" width="101"><input disabled='disabled' class="button button-gray" type="hidden" name="edit3" id="edit3" value="        Save        " onclick=""></td>
          <td align="right" width="111"><input disabled='disabled' class="button button-gray" type="hidden" name="edit4" id="edit4" value="Upload Attach"></td>
          <td align="right" width="73">&nbsp;</td>
          </div>
        </tr>
        </form>
      </table>
      <br />
      <div style="margin-left:5px;width:900px;float:left">2. Why Occure</div>
      <div style="margin-left:18px;width:200px;float:left">a. Temporary Action</div>
        <div style="width:250px;float:left">Due Date :&nbsp;<? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></div>
        <div style="width:230px;float:left">Status :&nbsp;
        <? 
		foreach($list_reply as $ii):
		 if($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') 
		 {
		 	if ($ii->APPROVE_SYSDATE=='') {echo "Not Yet Reply";}
			elseif ($ii->APPROVE_SYSDATE > $ii->DUE_DATE) {echo "Delay";} 
			elseif ($ii->APPROVE_SYSDATE <= $ii->DUE_DATE) { echo "On Time";}
		} 
		endforeach;?></div>
      <table width="100%" border="0" style="margin-left:12px">
        <form  style="margin-left:12px" name="why_outflow" method="post" action="">
        <tr>
          <td colspan="12"><label>
            <div style="border:solid; width:965px"><textarea rows="4" cols="120"  name="temp_action" id="temp_action" ><? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') { echo $ii->REPLY_COMMENT;} endforeach;?></textarea></div>
          </label></td>
        </tr>
        <tr>
          <td width="21" nowrap style="margin-left:25px">&nbsp;</td>
          <td width="105" nowrap="nowrap" style="margin-left:25px">Created by <br />
          Last Edited by<br /></td>
          <td width="7">:&nbsp;<br />
          :&nbsp;</td>
          <td width="225" nowrap="nowrap"><? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->REPLY_SYSDATE !='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?>
            <br />
          <? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
          <td width="96" nowrap>Approved by</td>
          <td width="7">:&nbsp;</td>
          <td width="208"><? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
          <div class="buttonreg">
          <td align="right" width="98"><input disabled='disabled' class="button button-gray" type ='hidden'  name='edit' id='edit' value='         Edit        '>          </td>
          <td align="right" width="104"><input disabled='disabled' class="button button-gray" type="hidden"  name="edit2" id="edit2" value="     Approved    "></td>
          <td align="right" width="100"><input disabled='disabled' class="button button-gray" type="hidden"   name="edit3" id="edit3" value="        Save        "></td>
          <td align="right" width="110"><input disabled='disabled' class="button button-gray" type="hidden" name="edit6" id="edit6" value="Upload Attach" /></td>
          <td align="right" width="73">&nbsp;</td>
          </div>
        </tr>
        </form>
      </table>
<br/>
		<div style="margin-left:18px;width:200px;float:left;">b. Fix Action</div>
        <div style="width:250px;float:left">Due Date :&nbsp;<? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></div>
        <div style="width:190px;float:left">Status :&nbsp;
        <? 
		foreach($list_reply as $ii):
		 if($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') 
		 {
		 	if ($ii->APPROVE_SYSDATE=='') {echo "Not Yet Reply";}
			elseif ($ii->APPROVE_SYSDATE > $ii->DUE_DATE) {echo "Delay";} 
			elseif ($ii->APPROVE_SYSDATE <= $ii->DUE_DATE) { echo "On Time";}
		} 
		endforeach;?></div>
      <table width="100%" border="0" style="margin-left:12px">
        <form  style="margin-left:12px" name="form1" method="post" action="">
        <tr>
          <td colspan="11"><label>
            <div style="border:solid; width:965px"><textarea rows="4" cols="120"  ><? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') { echo $ii->REPLY_COMMENT;} endforeach;?> </textarea>
          </label></td>
        </tr>
        <tr>
          <td width="21" nowrap style="margin-left:25px">&nbsp;</td>
          <td width="105" nowrap="nowrap" style="margin-left:25px">Created by <br />
          Last Edited by<br /></td>
          <td width="5">:&nbsp;<br />
          :&nbsp;</td>
          <td width="225px" nowrap="nowrap"><? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->REPLY_SYSDATE!='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?>
            <br />
          <? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
          <td width="96" nowrap>Approved by</td>
          <td width="4">:&nbsp;</td>
          <td width="215"><? 
			foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->APPROVE_SYSDATE!='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
          <div class="buttonreg">
          <td align="right" width="98"><input disabled='disabled' class="button button-gray" type ='hidden'  name='edit' id='edit' value='         Edit        '>          </td>
          <td align="right" width="105"><input disabled='disabled' class="button button-gray" type="hidden"  name="edit2" id="edit2" value="     Approved    "></td>
          <td align="right" width="108"><input disabled='disabled' class="button button-gray" type="hidden"  name="edit3" id="edit3" value="        Save        "></td>
          <td align="right" width="116"><input disabled='disabled' class="button button-gray" type="hidden"  name="edit4" id="edit4" value="  Upload Attach  "></td>
          </div>
        </tr>
        </form>
      </table>
  </div>
  <div style="margin-left:5; margin-top:5px" class="form">
  <table width="84%" border="0">
  <tr>
    <td><div align="left" style="margin-left:5px">Attachment :</div></td>
  </tr>
  </table>
  <table border="1" width="99%">
  <tr>
    <th width="16%" height="30">SQA Problem Sheet</td>
    <th width="16%">Temp. Out Flow</td>
    <th width="16%">Fix Out Flow</td>
    <th width="27%">Temporary Countermeasure (Responsible/Occure)</td>
    <th width="25%">Fix Countermeasure (Responsible/Occure)</td>
  </tr>
  <tr>
    <td><? foreach($list_sqa as $ii):?>
<a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($ii->ATTACH_NAME.';'.PATH_ATTCH . $ii->ATTACH_DOC)))?>"><? echo $ii->ATTACH_NAME."</a><br>";
		endforeach;
		 ?></td>
    <td><? foreach($list_rep_att as $i):
		if($i->REPLY_TYPE=='O' AND $i->COUNTERMEASURE_TYPE=='T'){ ?>
		<a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";}
		endforeach;
		 ?></td>
    <td><? foreach($list_rep_att as $i):
		if($i->REPLY_TYPE=='O' AND $i->COUNTERMEASURE_TYPE=='F'){ ?>
		<a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";}
		endforeach;
		 ?></td>
    <td><? foreach($list_rep_att as $i):
		if($i->REPLY_TYPE=='R' AND $i->COUNTERMEASURE_TYPE=='T'){ ?>
		<a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";}
		endforeach;
		 ?></td>
    <td><? foreach($list_rep_att as $i):
		if($i->REPLY_TYPE=='R' AND $i->COUNTERMEASURE_TYPE=='F'){ ?>
		<a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";}
		endforeach;
		 ?></td>
  </tr>
  </table>
  </div>
  </div>

</body>
</html>
<script type="text/javascript">
    $(function(){
        loadawal();
        
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