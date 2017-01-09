<html>    
    <head>
        <style>
            body {font-size: 70%;}            
        </style>
    </head>
    <body>
    
        <table width="100%" border="0">
        <tr>
            <td colspan="9" style="text-align: center;"><h2>SQA PROBLEM SHEET</h2></td>
        </tr>
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
            <td>PS NO.</td>
            <td width="1%">:</td>
            <td width="40%"><?= $prb_sheet_num ?></td>
            
            <td>Model</td>
            <td width="1%">:</td>
            <td width="20%"><?= $katashiki;?></td>
            
            <td>Issue Date</td>
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
            <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold;">SKETCH</td>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: left;">                
                <table border="1">
                    <tr>
                        <td height="500" style="text-align: center; vertical-align: middle;">&nbsp;<br />
                        <?php if (file_exists(PATH_IMG.$main_img)): ?>
                        <img src="<? echo PATH_IMG_URL.$main_img;?>" width="500" height="400" />
                        <?php endif; ?>
                        <br />Main Image</td>
                        <td style="text-align: center; vertical-align: middle">&nbsp;<br />
                        <?php if (file_exists(PATH_IMG.$part_img)): ?>
                        <img src="<? echo PATH_IMG_URL.$part_img;?>" width="500" height="400" />
                        <?php endif; ?>
                        <br />Part Image</td>
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
                        <td colspan="6" style="font-weight: bold;">VEHICLE DATA</td>            
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
                        <!-- update by Ipan 20111216 1546 -->
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
            <td colspan="9" style="font-weight: bold;">DETAIL PROBLEM</td>
        </tr>
        <tr>
            <td colspan="9" width="100%" style="border-style: solid solid solid solid;">
                <table width="100%" border="0">
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
            <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="9" style="font-weight: bold;">INVESTIGATION RESULT</td>
        </tr>
        <tr>
            <td colspan="9" width="100%" style="border-style: solid solid solid solid;">
                <table border="0" width="100%">
                    <tr>
                        <td colspan="3">1. Why Outflow</td>                        
                    </tr>                    
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="30%">a. Temporary Action</td>                         
                        <td width="30%">Due Date: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></td>
                        <td width="38%">Status: <?php 
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
                        <td width="96%" colspan="3" height="150" style="border-style: solid solid solid solid;">&nbsp;&nbsp;<?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="30%">Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->REPLY_SYSDATE!='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td width="68%">Approved By:<?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="98%">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->updatedt!='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="30%">b. Fix Action</td>                         
                        <td width="30%">Due Date: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></td>
                        <td width="38%">Status: <?php 
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
                        <td width="2%">&nbsp;</td>
                        <td width="96%" colspan="3" height="150" style="border-style: solid solid solid solid;">&nbsp;&nbsp;<? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="30%">Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->REPLY_SYSDATE !='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td width="68%">Approved By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="98%">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3">2. Why Occure</td>                        
                    </tr>                    
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="30%">a. Temporary Action</td>                         
                        <td width="30%">Due Date: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></td>
                        <td width="38%">Status: <?php 
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
                        <td width="2%">&nbsp;</td>
                        <td width="96%" colspan="3" height="150" style="border-style: solid solid solid solid;">&nbsp;&nbsp;<? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="30%">Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->REPLY_SYSDATE !='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td width="68%">Approved By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="98%">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="30%">b. Fix Action</td>                         
                        <td width="30%">Due Date: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') { echo date('d-M-Y', strtotime($ii->DUE_DATE));} endforeach;?></td>
                        <td width="38%">Status: <?php 
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
                        <td width="2%">&nbsp;</td>
                        <td width="96%" colspan="3" height="150" style="border-style: solid solid solid solid;">&nbsp;&nbsp;<? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="30%">Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->REPLY_SYSDATE!='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td width="68%">Approved By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->APPROVE_SYSDATE!='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="98%">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                    </tr>
                    
                </table>
                <br />
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
                <table border="1">
                    <tr>
                        <td style="text-align: center; font-weight: bold;">SQA Problem Sheet</td>
                        <td style="text-align: center; font-weight: bold;">Temp.Out Flow</td>
                        <td style="text-align: center; font-weight: bold;">Fix Out Flow</td>
                        <td style="text-align: center; font-weight: bold;">Temporary Countermeasure<br />(Responsible Occure)</td>
                        <td style="text-align: center; font-weight: bold;">Fix Countermeasure<br />(Responsible Occure)</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><?php foreach($list_sqa as $ii):?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($ii->ATTACH_NAME.';'.PATH_ATTCH . $ii->ATTACH_DOC)))?>"><? echo $ii->ATTACH_NAME."</a><br>"; endforeach;?></td>
                        <td style="text-align: center;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='O' AND $i->COUNTERMEASURE_TYPE=='T'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                        <td style="text-align: center;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='O' AND $i->COUNTERMEASURE_TYPE=='F'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                        <td style="text-align: center;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='R' AND $i->COUNTERMEASURE_TYPE=='T'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                        <td style="text-align: center;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='R' AND $i->COUNTERMEASURE_TYPE=='F'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    
    </table>
    
    </body>
</html>