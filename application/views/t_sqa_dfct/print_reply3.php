<?php 
    $reply_id_ot = '';
    $approve_pdate_sqareply_ot = '';
    $reply_id_of = '';
    $approve_pdate_sqareply_of = '';
    $reply_id_rt = '';
    $approve_pdate_sqareply_rt = '';
    $reply_id_rf = '';
    $approve_pdate_sqareply_rf = '';
    foreach($list_reply as $ii):
        if ($ii->REPLY_TYPE =='O' && $ii->COUNTERMEASURE_TYPE =='T') { 
            $reply_id_ot = $ii->PROBLEM_REPLY_ID;
            $approve_pdate_sqareply_ot = $ii->APPROVE_PDATE;
        } elseif ($ii->REPLY_TYPE =='O' && $ii->COUNTERMEASURE_TYPE =='F') { 
            $reply_id_of = $ii->PROBLEM_REPLY_ID;
            $approve_pdate_sqareply_of = $ii->APPROVE_PDATE;
        } elseif ($ii->REPLY_TYPE =='R' && $ii->COUNTERMEASURE_TYPE =='T') {
            $reply_id_rt = $ii->PROBLEM_REPLY_ID;
            $approve_pdate_sqareply_rt = $ii->APPROVE_PDATE;
        } elseif ($ii->REPLY_TYPE =='R' && $ii->COUNTERMEASURE_TYPE =='F') { 
            $reply_id_rf = $ii->PROBLEM_REPLY_ID;
            $approve_pdate_sqareply_rf = $ii->APPROVE_PDATE;
            $shop_defect = $ii->SHOP_ID;
        } 
    endforeach;
?>

    <style>
            * {font-size: 10px; font-family: Arial;}            
        </style>

    <table width="100%" border="0" style="padding-left: 10px; margin-top: -10px;">      
        <tr>
            <td colspan="9" style="text-align: center;"><h2 style="font-size: 16px;">SQA PROBLEM SHEET</h2></td>
        </tr>  
        <tr>
            <td width="10%">PS NO.</td>
            <td width="1%">:</td>
            <td width="45%"><?= $prb_sheet_num ?></td>
            
            <td>Model</td>
            <td width="1%">:</td>
            <td width="20%"><?= $katashiki;?></td>
            
            <td width="10%">Issue Date</td>
            <td width="1%">:</td>
            <td><?= ($app_pdate !='')? date('d M Y', strtotime($app_pdate)) : '-'; ?></td>
        </tr>
        <tr>
            <td>SQPR NO.</td>
            <td>:</td>
            <td><?= $sqpr_num?></td>
            
            <td>Shift</td>
            <td>:</td>
            <td colspan="4"><?= $sqa_shiftgrpnm;?> - Day</td>
        </tr>
        <tr>
            <td>PROBLEM</td>
            <td>:</td>
            <td><?= $dfct_desc;?></td>
            
            <td colspan="6">Responsible Shop : <?= $shop_nm;?></td>            
        </tr>        
        <tr>
            <td colspan="3" style="font-weight: bold;">SKETCH</td>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: left; vertical-align: top;" nowrap="nowrap">                
                <table style="border: 1px solid #000000;" width="98%">
                    <tr>
                        <td height="135" style="text-align: center; vertical-align: middle;">&nbsp;<br />                        
                            <?php if (file_exists(PATH_IMG.$main_img)): ?>
                            &nbsp;<img src="<? echo PATH_IMG_URL.$main_img;?>" width="200" height="130" alt="Can't Load" />
                            <?php endif; ?>
                            <br />Main Image
                        </td>
                        <td style="text-align: center; vertical-align: middle">&nbsp;<br />
                            <?php if (file_exists(PATH_IMG.$part_img)): ?>
                            &nbsp;<img src="<? echo PATH_IMG_URL.$part_img;?>" width="200" height="130" alt="Can't Load"  />
                            &nbsp;
                            <?php endif; ?>
                            <br />Part Image
                        </td>
                    </tr>
                </table> 
            </td>
            <td colspan="6" style="vertical-align: top;">
                
                <table>
                    <tr>
                        <td width="25%" style="vertical-align: top;">Auditor 1</td>
                        <td width="1%">:</td>
                        <td width="30%"><?=$auditor1;?></td>
                        
                        <td>Checked By</td>
                        <td width="1%">:</td>
                        <td style="text-align: left;"><?=$checked_by;?></td>
                    </tr>
                    <tr>
                        <td>Auditor 2</td>
                        <td>:</td>
                        <td><?=$auditor2;?></td>
                        
                        <td>Approved By</td>
                        <td>:</td>
                        <td style="text-align: left;"><?=$approved_by;?></td>
                    </tr>
                    <tr>
                        <td>Plant</td>
                        <td>:</td>
                        <td colspan="4"><?= $plant_nm;?></td>
                    </tr>
                    <tr>
                        <td>Stall</td>
                        <td>:</td>
                        <td colspan="4"><?= $dfct_stall . ' ' . $dfct_stall_desc; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="font-weight: bold; text-decoration: underline;">VEHICLE DATA</td>            
                    </tr>
                    <tr>
                        <td>Body No</td>
                        <td>:</td>
                        <td colspan="4"><?= $bodyno;?></td>
                    </tr>
                    <tr>
                        <td>Frame No.</td>
                        <td>:</td>
                        <td colspan="4"><?= $frame_no;?></td>
                    </tr>
                    <tr>
                        <td>Suffix No.</td>
                        <td>:</td>
                        <td colspan="4"><?= $suffix;?></td>
                    </tr>
                    <tr>
                        <td>Seq Body No.</td>
                        <td>:</td>
                        <td colspan="4"><?= $bd_seq;?></td>
                    </tr>
                    <tr>
                        <td>Seq Assy No.</td>
                        <td>:</td>
                        <td colspan="4"><?= $assy_seq;?></td>
                    </tr>
                    <tr>
                        <td>Model Code</td>
                        <td>:</td>
                        <td><?= $katashiki;?></td>
                        <!-- update by Ipan 20111216 1709 -->
                        <td colspan="3">(<?= $description; ?>)</td>
                    </tr>
                    <tr>
                        <td>Inspection Date</td>
                        <td>:</td>
                        <td colspan="4"><?= ($insp_pdate !='')? date('d M Y', strtotime($insp_pdate)) : '-'; ?></td>
                    </tr>
                    <tr>
                        <td>Production Date</td>
                        <td>:</td>
                        <td colspan="4"><?= ($assy_pdate !='')? date('d M Y', strtotime($assy_pdate)) : '-'; ?></td>
                    </tr>
                    <tr>
                        <td>Color</td>
                        <td>:</td>
                        <td colspan="4"><?= $color;?></td>
                    </tr>
                </table>
            </td>
        </tr>        
        <tr>
            <td colspan="9">
                <div style="font-weight: bold; width: 180px; border: 1px solid #000000; background-color: #000000; padding: 5px 0 5px 5px; background: black; color: white;">
                DETAIL PROBLEM 
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="9" width="100%" style="border: 1px solid #000000; padding: 5px 0 5px 5px;">
                <table width="100%" border="0" >
                    <tr>
                        <td width="15%">Actual</td>
                        <td width="1%">:</td>
                        <td width="30%"><?= $measurement;?></td>
                        
                        <td width="20%">Inspection Item</td>
                        <td width="1%">:</td>
                        <td><?= $insp_item_flg;?></td>
                    </tr>
                    <tr>
                        <td>Standar</td>
                        <td>:</td>
                        <td><?= $refval;?></td>
                        
                        <td>Quality Gate Item</td>
                        <td>:</td>
                        <td><?= $qlty_gt_item;?></td>
                    </tr>
                    <tr>
                        <td>Rank</td>
                        <td>:</td>
                        <!--td><?=$rank_nm . ' ' . $rank_nm2; ?></td-->
                        <td><?= $rank_nm2; ?></td>
                        
                        <td>History Repair Process</td>
                        <td>:</td>
                        <td><?=$repair_flg;?></td>
                    </tr>
                    <tr>
                        <td>Category Group</td>
                        <td>:</td>
                        <td><?=$ctg_grp_nm; ?></td>
                        
                        <td>Confirmed By QCD</td>
                        <td>:</td>
                        <td><? $confby='';foreach($list_dfct_conf as $i): if ($i->CONF_TYPE=='0') $confby=$confby.','.$i->CONF_BY; endforeach; echo substr($confby,1.200);?></td>
                    </tr>
                    <tr>
                        <td>Category Name</td>
                        <td>:</td>
                        <td><?= $ctg_nm;?></td>
                        
                        <td>Related Div</td>
                        <td>:</td>
                        <td><? $confby='';foreach($list_dfct_conf as $i): if ($i->CONF_TYPE=='1') $confby=$confby.','.$i->CONF_BY; endforeach; echo substr($confby,1.200);?></td>
                    </tr>
                </table>
            </td>            
        </tr>        
        <tr>
            <td colspan="9">
            <div style="font-weight: bold; width: 180px; border: 1px solid #000000; background-color: #000000; padding: 5px 0 5px 5px; background: black; color: white;">
                INVESTIGATION RESULT
            </div>
            </td>
        </tr>
        <tr>
            <td colspan="9" width="100%" style="border: 1px solid #000000;">
                <table width="98%">
                    <tr>
                        <td colspan="4"><strong>&nbsp;1. Why Outflow</strong></td>                        
                    </tr>                    
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="30%"><strong>a. Temporary Action</strong></td>                         
                        <td width="30%">Due Date: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></td>
                        <td>Status: <?php 
                    		foreach($list_reply as $ii):
                    		 if($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') 
                    		 {
                    		 	if ($ii->APPROVE_SYSDATE=='') {echo "Not Yet Reply";}
                    			elseif ($ii->APPROVE_SYSDATE > $ii->DUE_DATE) {echo "Delay";} 
                    			elseif ($ii->APPROVE_SYSDATE <= $ii->DUE_DATE) { echo "On Time";}
                    		} 
                    		endforeach;?>
                        </td>
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td colspan="3" height="50" style="vertical-align: top; border: 1px solid #000000; padding: 5px;"><?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td height="20">&nbsp;</td>
                        <td style="vertical-align: top;">Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->REPLY_SYSDATE!='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td style="vertical-align: top;">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->updatedt!='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                        <td style="vertical-align: top;">Approved By:<?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><strong>b. Fix Action</strong></td>                         
                        <td>Due Date: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></td>
                        <td>Status: <?php 
                    		foreach($list_reply as $ii):
                    		 if($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') 
                    		 {
                    		 	if ($ii->APPROVE_SYSDATE=='') {echo "Not Yet Reply";}
                    			elseif ($ii->APPROVE_SYSDATE > $ii->DUE_DATE) {echo "Delay";} 
                    			elseif ($ii->APPROVE_SYSDATE <= $ii->DUE_DATE) { echo "On Time";}
                    		} 
                    		endforeach;?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3" height="50" style="vertical-align: top; border: 1px solid #000000; padding: 5px;"><? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td height="20">&nbsp;</td>
                        <td style="vertical-align: top;">Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->REPLY_SYSDATE !='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td style="vertical-align: top;">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>                        
                        <td style="vertical-align: top;">Approved By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>&nbsp;2. Why Occure</strong></td>                        
                    </tr>                    
                    <tr>
                        <td>&nbsp;</td>
                        <td><strong>a. Temporary Action</strong></td>                         
                        <td>Due Date: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></td>
                        <td>Status: <?php 
                    		foreach($list_reply as $ii):
                    		 if($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') 
                    		 {
                    		 	if ($ii->APPROVE_SYSDATE=='') {echo "Not Yet Reply";}
                    			elseif ($ii->APPROVE_SYSDATE > $ii->DUE_DATE) {echo "Delay";} 
                    			elseif ($ii->APPROVE_SYSDATE <= $ii->DUE_DATE) { echo "On Time";}
                    		} 
                    		endforeach;?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3" height="50" style="vertical-align: top; border: 1px solid #000000; padding: 5px;"><? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td height="20">&nbsp;</td>
                        <td style="vertical-align: top;">Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->REPLY_SYSDATE !='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td style="vertical-align: top;">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                        <td style="vertical-align: top;">Approved By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><strong>b. Fix Action</strong></td>                         
                        <td>Due Date: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></td>
                        <td>Status: <?php 
                    		foreach($list_reply as $ii):
                    		 if($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') 
                    		 {
                    		 	if ($ii->APPROVE_SYSDATE=='') {echo "Not Yet Reply";}
                    			elseif ($ii->APPROVE_SYSDATE > $ii->DUE_DATE) {echo "Delay";} 
                    			elseif ($ii->APPROVE_SYSDATE <= $ii->DUE_DATE) { echo "On Time";}
                    		} 
                    		endforeach;?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3" height="50" style="vertical-align: top; border: 1px solid #000000; padding: 5px;"><? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td height="20">&nbsp;</td>
                        <td style="vertical-align: top;">Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->REPLY_SYSDATE!='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td style="vertical-align: top;">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                        <td style="vertical-align: top;">Approved By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->APPROVE_SYSDATE!='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
                    </tr>
                </table>
            </td>            
        </tr>        
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>        
        <tr>
            <td colspan="9" style="font-weight: bold;">ATTACHMENT</td>
        </tr>
        <tr>
            <td colspan="9">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="border: 1px solid;" >SQA Problem Sheet</th>
                        <th style="border: 1px solid;" >Temp.Out Flow</th>
                        <th style="border: 1px solid;" >Fix Out Flow</th>
                        <th style="border: 1px solid;" >Temporary Countermeasure<br />(Responsible Occure)</th>
                        <th style="border: 1px solid;" >Fix Countermeasure<br />(Responsible Occure)</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid;text-align: center;"><?php foreach($list_sqa as $ii):?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($ii->ATTACH_NAME.';'.PATH_ATTCH . $ii->ATTACH_DOC)))?>"><? echo $ii->ATTACH_NAME."</a><br>"; endforeach;?></td>
                        <td style="border: 1px solid;text-align: center;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='O' AND $i->COUNTERMEASURE_TYPE=='T'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                        <td style="border: 1px solid;text-align: center;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='O' AND $i->COUNTERMEASURE_TYPE=='F'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                        <td style="border: 1px solid;text-align: center;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='R' AND $i->COUNTERMEASURE_TYPE=='T'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                        <td style="border: 1px solid;text-align: center;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='R' AND $i->COUNTERMEASURE_TYPE=='F'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                    </tr>
                </table>
            </td>
        </tr>    
    </table>
    
<script type="text/javascript">
    $(function(){
        jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
       // set scalling
       jsPrintSetup.setOption('scaling', 70);
       jsPrintSetup.setOption('shrinkToFit', false);
       
       // set top margins in millimeters
       jsPrintSetup.setOption('marginTop', 0);
       jsPrintSetup.setOption('marginBottom', 0);
       jsPrintSetup.setOption('marginLeft', 0);
       jsPrintSetup.setOption('marginRight', 10);
       // set page header
       jsPrintSetup.setOption('headerStrLeft', '&T');
       jsPrintSetup.setOption('headerStrCenter', '');
       jsPrintSetup.setOption('headerStrRight', '&PT');
       // set empty page footer
       jsPrintSetup.setOption('footerStrLeft', '');
       jsPrintSetup.setOption('footerStrCenter', '');
       jsPrintSetup.setOption('footerStrRight', '');    
       jsPrintSetup.print();
       
       setTimeout('window.close()',3000);
                        
    });
</script>