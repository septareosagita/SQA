<script type="text/javascript">
function monthly_report_print(){
        $('#monthly_report_print').hide();
        
           // set portrait orientation
   jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation );
   
   // set scalling
  
   jsPrintSetup.setOption('scaling', 76);
   jsPrintSetup.setOption('shrinkToFit', false);
   
   // set top margins in millimeters
   jsPrintSetup.setOption('marginTop', 20);
   jsPrintSetup.setOption('marginBottom', 5);
   jsPrintSetup.setOption('marginLeft', 10);
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
   jsPrintSetup.clearSilentPrint();
   // Suppress print dialog (for this context only)
  // jsPrintSetup.setOption('printSilent', 1);
   // Do Print 
   // When print is submitted it is executed asynchronous and
   // script flow continues after print independently of completetion of print process! 
   jsPrintSetup.print();
        
      //  window.print();
		setTimeout('window.close()',3000);
      //  alert ("Print Document Succesful");
}
</script> 

<div class="wrapper">
<div class="columns">
    <div id="current_report">
    <div class="column grid_8 first" width="100%">   
   
    <div class="dwnldlogo" style="margin:5px; width: 40%; float: left;">
            <img src="<?= base_url() ?>assets/img/toyota.png" alt="toyota-logo" width="70" height="45" style="float: left; margin-top: 5px; padding-right: 9px" />
            <h5 style="margin-top:0px;"><span style="color:red;">PT. TOYOTA MOTOR MFG INDONESIA</span><br>
                QAD - CUSTOMER QUALITY AUDIT<br>
                AUDIT SECTION
            </h5>
 </div>
 
        <div style="margin-left:450px; margin-bottom: 35px;">
            <h1><span style="color:green; font-size: 30px;">Summary Monthly Defect SQA</span></h1>
        </div>

 <div class="widgetentri">

            <section>
            <h4 style="margin:-1px; clear: both; text-align: right;">MONTH : <?= $bulan_tahun ?></h4>
 <div id="middlecontent" style="font-size: 13px; font-family: calibri;">
 
  <h3 style="margin:-1px; clear: both; text-align: left;">MODEL : <?= $model ?></h3><hr />
  
    <?php 
    if ($list_sqa_dfct): $i = 1;
    foreach ($list_sqa_dfct as $l): 
                
    
    
                        if (isset($list_dfct_reply[$l->PROBLEM_ID])) {
                        $rep = $list_dfct_reply[$l->PROBLEM_ID];
                                       
                        foreach ($rep as $r) {
  
                            if ($r->REPLY_TYPE == 'O' && $r->COUNTERMEASURE_TYPE == 'T') {  // jika OT
                            $reply_id_ot = $r->PROBLEM_REPLY_ID;
                            $comment_ot = $r->REPLY_COMMENT;
                                                                             
                            } else if ($r->REPLY_TYPE == 'O' && $r->COUNTERMEASURE_TYPE == 'F') { // JIKA OF
                            $reply_id_of = $r->PROBLEM_REPLY_ID;
                            $comment_of = $r->REPLY_COMMENT;
                                
                            } else if ($r->REPLY_TYPE == 'R' && $r->COUNTERMEASURE_TYPE == 'T') { // JIKA RT
                            $reply_id_rt = $r->PROBLEM_REPLY_ID;
                            $approve_pdate_sqareply_rt = $r->APPROVE_PDATE;
                            $comment_rt = $r->REPLY_COMMENT;
                                
                                
                            } else if ($r->REPLY_TYPE == 'R' && $r->COUNTERMEASURE_TYPE == 'F') { // JIKA RF
                            $reply_id_rf = $r->PROBLEM_REPLY_ID;
                            $approve_pdate_sqareply_rf = $r->APPROVE_PDATE;
                            $comment_rf = $r->REPLY_COMMENT;
                            }
                        }
                        
                    }
                    ?>
<table width="100%" class="data3" border="0" align="left" bordercolor="#000000"  style="border:1px solid #888888;">
  <tr style="background-color:#eaeaea">
    <th width="20" style="border:1px solid #888888;"><h3 align="center">NO</h3></th>
    <th colspan="3" style="border:1px solid #888888;"><div align="center"><h3>PROBLEM</h3></div></th>
    <th colspan="4" style="border:1px solid #888888;"><div align="center"><h3>SKETCH</h3></div></th>
    </tr>
  
  <tr>
    <td rowspan="23" style="border:1px solid #888888;"><?= $i; ?>.</td>
    <td width="160">PS NO.</td>
    <td width="10">:</td>
    <td width="250"> <?= $l->PRB_SHEET_NUM ?></td>
    <td width="255" rowspan="11" style="border:1px solid #888888;">
    <div style="width: 255px; height: 180px;">
     <img src="<? echo PATH_IMG_URL.$l->MAIN_IMG;?>" width="255" height="180" style="margin-left: 0px;" />
       
    </div>    </td>
    
    <td width="255" rowspan="11" style="border:1px solid #888888;">
    <div style="width: 250px; height: 180px;">
    <img src="<? echo PATH_IMG_URL.$l->PART_IMG;?>" width="250" height="180" style="margin-left: 0px;" />
    
    </div>    </td>
    </tr>
  <tr>
    <td>SQPR NO.</td>
    <td>:</td>
    <td><?= ($l->SQPR_NUM =='')?'-':$l->SQPR_NUM; ?></td>
    </tr>
  <tr>
   <tr>
    <td>PROBLEM</td>
    <td>:</td>
    <td><?= ($l->DFCT =='')?'-':$l->DFCT; ?></td>
    </tr>
  <tr>
    <td>ACTUAL</td>
     <td>:</td>
     <td><?= $l->MEASUREMENT ?></td>
    </tr>
    <tr>
    <td>STANDAR</td>
    <td>:</td>
    <td><?= $l->REFVAL;?></td>
    </tr>
    <tr>
    <td>RANK</td>
    <td>:</td>
    <td><?= $l->RANK_NM2 ?></td>
    </tr>
    <tr>
    <td>CATEGORY GROUP</td>
    <td>:</td>
    <td><?= $l->CTG_GRP_NM ?></td>
    </tr>
    <tr>
    <td>CATEGORY NAME</td>
    <td>:</td>
    <td><?= $l->CTG_NM ?></td>
    </tr>
    <tr>
    <td>INSPECTION ITEM</td>
    <td>:</td>
    <td>
	<?php if($l->INSP_ITEM_FLG =='1'){
	echo 'Yes';}
	else{
	echo 'No';
	} 
	?></td>
    </tr>
    <tr>
    <td>QLTY GATE ITEM</td>
    <td>:</td>
    <td>
    <?php if($l->QLTY_GT_ITEM =='1'){
	echo 'Yes';}
	else{
	echo 'No';
	} 
	?></td>
    </tr>
    <tr>
    <td style="border-bottom:1px solid #888888;">HISTORY REPAIR</td>
    <td style="border-bottom:1px solid #888888;">:</td>
    <td style="border-bottom:1px solid #888888;"><?php if($l->REPAIR_FLG=='1'){
	echo 'Yes';}
	else{
	echo 'No';
	} 
	?></td>
    <td style="border:1px solid #888888;"> <div align="center"> Main Image</div></td>
    <td style="border:1px solid #888888;"><div align="center">Part Image</div></td>
    </tr>

    <tr>
      <td colspan="5" style="text-decoration:underline; font-weight:bold;">INVESTIGATION RESULT</td>
      </tr>
    <tr>
      <td>1. Why Outflow</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td><span style="margin-left:20px;">a. Temporary Action</span></td>
      <td colspan="4">&nbsp;</td>
    </tr>
   <tr>
      <td colspan="5">                   
      	<textarea style="width:95%; margin-left:20px; border: 1px solid #888888;" readonly="" disabled='disabled'><?= $comment_ot?></textarea>      </tr>
 
    <tr>
      <td><span style="margin-left:20px;">b. Fix Action</span></td>
      <td colspan="4">&nbsp;</td>
    </tr>
   <tr>
      <td colspan="5">                   
      	<textarea style="width:95%; margin-left:20px; border: 1px solid #888888;" readonly="" disabled='disabled'><?= $comment_of ?></textarea>      </tr>
      
      <tr>
      <td>2. Why Occure</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td><span style="margin-left:20px;">a. Temporary Action</span></td>
      <td colspan="4">&nbsp;</td>
    </tr>
   <tr>
      <td colspan="5">                   
      	<textarea style="width:95%; margin-left:20px; border: 1px solid #888888;" readonly="" disabled='disabled' ><?=$comment_rt?></textarea>      </tr>
    <tr>
      <td><span style="margin-left:20px;">a. Fix Action</span></td>
      <td colspan="4">&nbsp;</td>
    </tr>
   <tr>
      <td colspan="5" style="border-bottom:1px solid #888888;">                   
      	<textarea style="width:95%; margin-left:20px; border: 1px solid #888888; margin-bottom:20px;" readonly="" disabled='disabled'><?=$comment_rt?></textarea>   </tr>
     <?php
                              $i++;
                          endforeach;
                      else:
                ?> 
                <tr class="row-b">
                              <td colspan="22" style="padding:5px;">Data Is Empty</td>
                          </tr>
                <?php endif; ?>
</table>


<div>&nbsp;</div>        
</div>
 </section>
        </div>


    </div></div></div></div>
    <div align="center" style="margin-bottom: 20px;"> 
    <button style="width: 200px; height: 40px; font-weight: bold; font-size: 15px;" class="button button-blue " id="monthly_report_print" type="button" onclick='monthly_report_print()'>PRINT</button>
    </div>