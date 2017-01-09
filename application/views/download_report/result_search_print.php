<script type="text/javascript">

function result_show(){
    
var ASSY_FROM_PDATE = $('#ASSY_FROM_PDATE').val();
var ASSY_TO_PDATE = $('#ASSY_FROM_PDATE').val();
var ASSY_SHIFTGRPNM = $('#ASSY_SHIFTGRPNM').val();
var INSP_FROM_PDATE = $('#INSP_FROM_PDATE').val();
var INSP_TO_PDATE = $('#INSP_TO_PDATE').val();
var INSP_SHIFTGRPNM = $('#INSP_SHIFTGRPNM').val();
var DESCRIPTION = $('#DESCRIPTION').val();
var KATASHIKI = $('#KATASHIKI').val();
var EXTCLR = $('#EXTCLR').val();
var VINNO = $('#VINNO').val();
var BODYNO = $('#BODYNO').val();
var stat_prob = $('#stat_prob').val();
var DFCT = $('#DFCT').val();
var RANK_NM = $('#RANK_NM').val();
var INSP_ITEM_FLG = $('#INSP_ITEM_FLG').val();
var QLTY_GT_ITEM = $('#QLTY_GT_ITEM').val();
var CTG_GRP_NM = $('#CTG_GRP_NM').val();
var CTG_NM = $('#CTG_NM').val();
var REPAIR_FLG = $('#REPAIR_FLG').val();
var Problem_Sheet = $('#Problem_Sheet').val();
var Status_Problem_Sheet = $('#Status_Problem_Sheet').val();


if (ASSY_FROM_PDATE !='' || ASSY_FROM_PDATE !='' || ASSY_SHIFTGRPNM !=''
||  INSP_FROM_PDATE !='' || INSP_TO_PDATE !='' || INSP_SHIFTGRPNM !='' 
||  DESCRIPTION !='' || KATASHIKI !='' || EXTCLR !='' || VINNO !='' || BODYNO !=''
||  stat_prob !='' || DFCT !='' || RANK_NM !='' || INSP_ITEM_FLG !='' || QLTY_GT_ITEM !=''
||  CTG_GRP_NM !='' || CTG_NM !='' || REPAIR_FLG !='' || Problem_Sheet !='' || Status_Problem_Sheet !='')

$('#advance_search').show();
else
$('#advance_search').hide();
         
}

function print(){

// set portrait orientation
   jsPrintSetup.setOption('orientation', jsPrintSetup.kLandscapeOrientation);
   
   // set scalling
   jsPrintSetup.setOption('scaling', 68);
   jsPrintSetup.setOption('shrinkToFit', false);
   
   // set top marginst in millimeters
   jsPrintSetup.setOption('marginTop', 15);
   jsPrintSetup.setOption('marginBottom', 15);
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
     // window.print();
		setTimeout('window.close()',3000);
    //    alert ("Print Document Succesful");

}



</script>


<div class="wrapper"  >
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
        <div style="margin-left:650px; margin-bottom: 35px;">
            <h1><span style="color:green;">Result Search SQA System</span></h1>
        </div>

        <div class="widgetentri">

    <?php foreach ($list_v_sqa_dfct as $l): ?>
            <?php endforeach;?>
            
            <section>
       <h4 style="margin:-1px; clear: both;">PARAMETER SEARCH</h4><hr>
                <!--start middlecontent -->
                <div id="middlecontent" style="font-size: 15px; font-family: calibri;">


 <input type="hidden" name="ASSY_FROM_PDATE" id="ASSY_FROM_PDATE" value="<?= $ASSY_FROM_PDATE ?>">
 <input type="hidden" name="ASSY_TO_PDATE" id="ASSY_TO_PDATE" value="<?= $ASSY_TO_PDATE ?>">
 <input type="hidden" name="ASSY_SHIFTGRPNM" id="ASSY_SHIFTGRPNM" value="<?= $ASSY_SHIFTGRPNM ?>">
 <input type="hidden" name="INSP_FROM_PDATE" id="INSP_FROM_PDATE" value="<?= $INSP_FROM_PDATE ?>">
 <input type="hidden" name="INSP_TO_PDATE " id="INSP_TO_PDATE" value="<?= $INSP_TO_PDATE ?>">
 <input type="hidden" name="INSP_SHIFTGRPNM" id="INSP_SHIFTGRPNM" value="<?= $INSP_SHIFTGRPNM ?>">
 
 <input type="hidden" name="DESCRIPTION" id="DESCRIPTION" value="<?= $DESCRIPTION ?>">
 <input type="hidden" name="KATASHIKI" id="KATASHIKI" value="<?= $KATASHIKI ?>">
 <input type="hidden" name="EXTCLR" id="EXTCLR" value="<?= $EXTCLR ?>">
 <input type="hidden" name="VINNO" id="VINNO" value="<?= $VINNO ?>">
 <input type="hidden" name="BODYNO " id="BODYNO" value="<?= $BODYNO ?>">
 
 <input type="hidden" name="stat_prob" id="stat_prob" value="<?= $stat_prob ?>">
 <input type="hidden" name="DFCT" id="DFCT" value="<?= $DFCT ?>">
 <input type="hidden" name="RANK_NM" id="RANK_NM" value="<?= $RANK_NM ?>">
 <input type="hidden" name="INSP_ITEM_FLG" id="INSP_ITEM_FLG" value="<?= $INSP_ITEM_FLG ?>">
 <input type="hidden" name="QLTY_GT_ITEM" id="QLTY_GT_ITEM" value="<?= $QLTY_GT_ITEM ?>">
 
 <input type="hidden" name="CTG_GRP_NM" id="CTG_GRP_NM" value="<?= $CTG_GRP_NM ?>">
 <input type="hidden" name="CTG_NM" id="CTG_NM" value="<?= $CTG_NM ?>">
 <input type="hidden" name="REPAIR_FLG" id="REPAIR_FLG" value="<?= $REPAIR_FLG ?>">
 <input type="hidden" name="Problem_Sheet" id="Problem_Sheet" value="<?= $Problem_Sheet ?>">
 <input type="hidden" name="Status_Problem_Sheet" id="Status_Problem_Sheet" value="<?= $Status_Problem_Sheet ?>">


 
               
<!------------------------------------------------------result SQA-------------------------------------------->               
        <div id="search">          
                    <table width="100%" border="0" style="font-size:15px; font-family: calibri;">
              <tr>
                <td height="20" width="120" colspan="2"><span class="title" style="margin-bottom:5px; font-weight:bold; text-decoration:underline;">SQA Date</span></td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td colspan="2" width="120">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td width="120">From</td>
                <td width="10">:</td>
                <td width="90"><?= $from ?></td>
                <td width="120">Shift</td>
                 <td width="10">:</td>
                <td width="100">
                  <?= ($sqa_shiftgrpnm =='0')? 'ALL' : $sqa_shiftgrpnm ?>                </td>
                <td width="120">Plant</td>
                <td width="10">:</td>
                <td>
                  <?= $plant_nm ?>                  </td>
                </tr>
              <tr>
                <td width="120">To</td>
                <td width="10">:</td>
                <td width="90"><?= $to ?></td>
                <td width="120">Shop</td>
                 <td width="10">:</td>
                <td width="100">
                  <?= ($SHOP_NM =='0')? 'ALL' : $SHOP_NM ?>                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            </table>
                          
            </div></div>
<!------------------------------------------------------End result SQA----------------------------------------> 

<!------------------------------------------------------result Advance Search---------------------------------> 
            <div id="advance_search" style="display: none;" >
             <br /><table width="100%" border="0" style="font-size:14px;">
              <tr>
                <td height="20" width="120" colspan="2"><span class="title" style="margin-bottom:5px; font-weight:bold; text-decoration:underline;">Production Date</span></td>
                <td>&nbsp;</td>
                <td height="20" width="120" colspan="2"><span class="title" style="margin-bottom:5px; font-weight:bold; text-decoration:underline;">Inspection Date</span></td>
                <td>&nbsp;</td>
                 <td height="20" width="120" colspan="2"><span class="title" style="margin-bottom:5px; font-weight:bold; text-decoration:underline;">Vehicle Data</span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td width="120">From</td>
                <td width="10">:</td>
                <td width="90">
                  <?= ($ASSY_FROM_PDATE =='') ? '-': $ASSY_FROM_PDATE ?>                </td>
                <td width="120">From</td>
                 <td width="10">:</td>
                <td width="100">
                  <?= ($INSP_FROM_PDATE =='') ? '-': $INSP_FROM_PDATE ?>               </td>
                <td width="120">Model Name</td>
                <td width="10">:</td>
                <td width="100"><?= ($DESCRIPTION =='')? '-': $DESCRIPTION ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>To</td>
                <td>:</td>
                <td>
                  <?= ($ASSY_TO_PDATE =='') ? '-': $ASSY_TO_PDATE ?>                </td>
                <td>To</td>
                <td>:</td>
                <td>
                  <?= ($INSP_TO_PDATE =='') ? '-': $INSP_TO_PDATE ?>                </td>
                <td width="120">Model Code</td>
                <td>:</td>
                <td width="100"><?= ($KATASHIKI =='')? '-': $KATASHIKI ?></td>
                <td width="70">Frame No</td>
                <td width="10">:</td>
                <td><?= ($VINNO =='')?'-' :$VINNO?></td>
              </tr>
              <tr>
                <td>Shift</td>
                <td>:</td>
                <td><?= ($ASSY_SHIFTGRPNM =='0')? 'ALL': $ASSY_SHIFTGRPNM ?></td>
                <td>Shift</td>
                <td>:</td>
                <td><?= ($INSP_SHIFTGRPNM =='0')? 'ALL': $INSP_SHIFTGRPNM ?></td>
                <td width="120">Color</td>
                <td>:</td>
                <td width="100"><?= ($EXTCLR =='')?'-' :$EXTCLR?></td>
                <td width="70">Body No</td>
                <td width="10">:</td>
                <td><?= ($BODYNO =='')?'-' :$BODYNO?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                
                 <td height="20" width="120"><span class="title" style="margin-bottom:5px; font-weight:bold; text-decoration:underline;">Defect Data</span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Vehicle Status</td>
                <td>:</td>
                <td>
                  <?php if($stat_prob =='0'){
                                echo 'ALL';} 
                                if($stat_prob =='1'){
                                echo 'Problem Sheet';}
                                if($stat_prob =='2'){
                                echo 'SQPR';}
                                if($stat_prob =='3'){
                                echo 'No Defect';}
                                if($stat_prob =='4'){
                                echo 'SQA Undercheck';}
                                if($stat_prob =='5'){
                                echo 'Under Investigation';}   
                                ?>                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Category Group</td>
                <td>:</td>
                <td>
                  <?= ($CTG_GRP_NM =='0')? "ALL" : $CTG_GRP_NM ?>                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Defect</td>
                <td>:</td>
                <td>
                  <?= ($DFCT =='')?'-' :$DFCT?>                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Category Name</td>
                <td>:</td>
                <td>
                  <?= ($CTG_NM =='0')? "ALL": $CTG_NM ?>                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Rank</td>
                <td>:</td>
                <td>
                  <?= ($RANK_NM =='0')? 'ALL': $RANK_NM ?>                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Inspection Item</td>
                <td>:</td>
                <td><?php if($INSP_ITEM_FLG ==''){
                                echo 'ALL';}
                                if($INSP_ITEM_FLG =='1'){
                                echo 'Yes';}
                                if($INSP_ITEM_FLG =='0'){
                                echo 'No';} 
                                ?>                </td>
                <td>Quality gate Item</td>
                <td>:</td>
                <td><?php if($QLTY_GT_ITEM ==''){
                                echo 'ALL';}
                                if($QLTY_GT_ITEM =='1'){
                                echo 'Yes';}
                                if($QLTY_GT_ITEM =='0'){
                                echo 'No';}
                            ?>                </td>
                <td>Hostory Repair P</td>
                <td>:</td>
                <td><?php if($REPAIR_FLG ==''){
                                echo 'ALL';}
                                if($REPAIR_FLG =='1'){
                                echo 'Yes';}
                                if($REPAIR_FLG =='0'){
                                echo 'No';}
                            ?>                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="20" width="120"><span class="title" style="margin-bottom:5px; font-weight:bold; text-decoration:underline;">Problem Sheet</span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>
                  PS / SQPR No</td>
                <td>:</td>
                <td colspan="3"><?= ($Problem_Sheet_a =='')?'-': $Problem_Sheet_a ?> / <?= ($Problem_Sheet_b =='')?'-': $Problem_Sheet_b ?> / SQA-QAD / <?= ($Problem_Sheet_c =='')?'-': $Problem_Sheet_c ?> / <?= ($Problem_Sheet_d =='')?'-': $Problem_Sheet_d ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="120">PS Status</td>
                <td width="10">:</td>
                <td>
                  <?php if($Status_Problem_Sheet =='') {
                                echo 'ALL'; }
                                if($Status_Problem_Sheet =='0') {
                                echo 'Open'; }
                                if($Status_Problem_Sheet =='1') {
                                echo 'Closed'; } 
                                if($Status_Problem_Sheet =='2') {
                                echo 'Replay'; } 
                                if($Status_Problem_Sheet =='3') {
                                echo 'Delay'; } 
                                ?>                </td>
                <td width="120">&nbsp;</td>
                <td width="10">&nbsp;</td>
               <td width="100">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            </table>               
            </div>            
         
            
<!------------------------------------------------------End Advance Search----------------------------------------> 
   <h4>I. GRAPH</h4><hr>    
    
    <div id="container" style="width:1450px;" align="center">
            
            <?= $charts; ?>
            
    </div>
    
           <!-- <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
                codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"
                width="950"
                height="300"
                id="Column2D" >

           <param name="movie" value="<?=base_url()?>assets/public/flash/Column2D.swf" />
           <param name="FlashVars" value="&dataXML= <chart caption='<?=$judul?>'
                            subcaption='Result Search SQA System'
                            xAxisName='Date'
                            yAxisName='Number'
                            useRoundEdges='5'
                            numberPrefix=''>
                        <?php if ($list_graph): foreach($list_graph as $a): ?>
                        <set label='<?=$a[0]?>' value='<?=$a[1]?>' />
                        <?php endforeach; endif;  ?>
                    </chart>">
           <param name="quality" value="high" />

           <embed src="<?=base_url()?>assets/public/flash/Column2D.swf"
                  flashVars="&dataXML=
                  <chart caption='<?=$judul?>'
                    subcaption='Result Search SQA System'
                    xAxisName='Date'
                    yAxisName='Number'
                    useRoundEdges='5'
                    numberPrefix=''>
                    <?php if ($list_graph): foreach($list_graph as $a): ?>
                    <set label='<?=$a[0]?>' value='<?=$a[1]?>' />
                    <?php endforeach; endif;  ?>
                </chart>"
                quality="high"
                width="950" height="300" name="Column2D"
                type="application/x-shockwave-flash"
                pluginspage="http://www.macromedia.com/go/getflashplayer" />
        </object> -->
       
        
       <h4>II. LIST SEARCH</h4>
       <table width="100%" style="font-size:14px; font-family: calibri; margin-bottom:5px; vertical-align:middle;">
        <tr>
       		
            <td width="1%" style="vertical-align:middle; text-align: left;">
            <img src="<?=base_url()?>assets/style/images/status_sqa_blank.gif" width="18" heigth="15" alt="status-ot" title=""/>           </td>
            <td width="6%" style="vertical-align:middle; text-align: left;">
            &nbsp; = Not Yet
            </td>
            <td width="1%" style="vertical-align:middle; text-align:left;;">
           <img src="<?=base_url()?>assets/style/images/nr.gif" width="18" heigth="15" alt="status-ot" title=""/>
           </td>
            <td width="12%" style="vertical-align:middle; text-align: left;">
            &nbsp; = Not Yet Approve
            </td>
            <td width="1%" style="vertical-align:middle; text-align:left;;">
            <img src="<?=base_url()?>assets/style/images/status_sqa_approve.gif" width="18" heigth="15" alt="status-ot" title=""/>
            </td>
            <td width="7%" style="vertical-align:middle; text-align: left;">
            &nbsp; = Approve 
             </td>
			 <td width="1%" style="vertical-align:middle; text-align:left;;">
            <img src="<?=base_url()?>assets/style/images/delay.gif" width="18" heigth="15" alt="status-ot" title=""/>
            </td>
            <td width="69%" style="vertical-align:middle; text-align: left;">
            &nbsp; = Delay 
             </td>
       </tr>
       </table> 
       <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#E1E1E1" class="data" style="font-size:13px; font-family: calibri;">
<thead>
                        <tr style="background:#E2E2E2;">
                            <th width="1%" rowspan="1" align="center" style="border:1px solid #888888;">No</th>
                            <th width="2%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;"><div align="center">Status P/S</div></th>
                            <th width="4%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;">Model</th>
                            <th width="2%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;">Rank</th>
                            <th width="10%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;">Defect</th>
                            
                            <th width="7%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;">Category</th>
                            <th width="4%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;">Shift</th>
                            
                            <th width="4%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;">Frame No</th>
                            <th width="3%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;">Body No</th>
                            <th width="1%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;">Color</th>
                            <th width="6%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;">PS No.</th>
                            <th width="6%" rowspan="1" style="vertical-align:middle; text-align: center;border:1px solid #888888;">SQPR No.</th>
                            <th width="5%" rowspan="1" style="vertical-align:middle; text-align: center; border:1px solid #888888;">SQA Date</th>
                            <th width="5%" rowspan="1" style="vertical-align:middle; text-align: center; border:1px solid #888888;">SQA Out Date</th>
                          
                            
                            
                        </tr>
                        
                  </thead>
                     <?php
            if ($list_v_sqa_dfct): $i = 1;
                foreach ($list_v_sqa_dfct as $l):

                    $c = ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"";
                    if (mssql_guid_string($l->PROBLEM_ID) == '$problem_id') {
                        $c = "class=\"active\"";
                    }

                    // keluarkan data reply
                    $img_ot = $img_of = $img_rt = $img_rf = '';
                    $ot_date = $of_date = $rt_date = $rf_date = '';

                    if (isset($list_dfct_reply[mssql_guid_string($l->PROBLEM_ID)])) {
                        $rep = $list_dfct_reply[mssql_guid_string($l->PROBLEM_ID)];
                        
                        
                        foreach ($rep as $r) {
                        $srt_due_date = date("Y-m-d",strtotime($r->DUE_DATE));
                        $srt_approve = date("Y-m-d",strtotime($r->APPROVE_SYSDATE));
                     
                        $due_date = explode('-', $srt_due_date);
                        $due_date2 = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
                        
                        $approve_sysdate = explode('-', $srt_approve);
                        $approve_sysdate2 = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
                        
                            
                            

                            if ($r->REPLY_TYPE == 'O' && $r->COUNTERMEASURE_TYPE == 'T') {  // jika OT
                            $reply_id_ot = mssql_guid_string($r->PROBLEM_REPLY_ID);
                            $approve_pdate_sqareply_ot = $r->APPROVE_PDATE;
                             $reply = $r->REPLY_SYSDATE;
                            $approve = $r->APPROVE_SYSDATE;
                            
                                $due_date_ot = $r->DUE_DATE;
              
                                 if ($approve == '') {
                                    $img_ot = 'status_sqa_blank.gif';
                                 } else if ($approve =='' && $reply != '') {
                                    $img_ot = 'nr.gif';
                                } else if ($approve_sysdate > $due_date) {
                                    $img_ot = 'delay.gif';
                                } else if ($approve_sysdate<= $due_date) {
                                    $img_ot = 'status_sqa_approve.gif';
                                }     
                                
                                $ot_date = $approve_pdate_sqareply_ot;                          
                            } else if ($r->REPLY_TYPE == 'O' && $r->COUNTERMEASURE_TYPE == 'F') { // JIKA OF
                                // cek jika sudah di komentari dan cek duedate nya
                                $reply_id_of = mssql_guid_string($r->PROBLEM_REPLY_ID);
                                $approve_pdate_sqareply_of = $r->APPROVE_PDATE;
                                 $due_date_of = $r->DUE_DATE;
                                 $reply = $r->REPLY_SYSDATE;
                            $approve = $r->APPROVE_SYSDATE;
                            
                                if ($reply == '') {
                                    $img_of = 'status_sqa_blank.gif';
                                   } else if ($approve =='' && $reply != '') {
                                    $img_of = 'nr.gif';    
                                } else if ($approve_sysdate > $due_date) {
                                    $img_of = 'delay.gif';
                                } else if ($approve_sysdate <= $due_date) {
                                    $img_of = 'status_sqa_approve.gif';
                                }
                                $of_date = $approve_pdate_sqareply_of;
                            } else if ($r->REPLY_TYPE == 'R' && $r->COUNTERMEASURE_TYPE == 'T') { // JIKA RT
                                 $reply_id_rt = mssql_guid_string($r->PROBLEM_REPLY_ID);
                                 $approve_pdate_sqareply_rt = $r->APPROVE_PDATE;
                                 $due_date_rt = $r->DUE_DATE;
                             $reply = $r->REPLY_SYSDATE;
                            $approve = $r->APPROVE_SYSDATE;
                            
                                 if ($reply == '') {
                                    $img_rt = 'status_sqa_blank.gif';
                                  } else if ($approve =='' && $reply != '') {
                                    $img_rt = 'nr.gif';
                                } else if ($approve_sysdate > $due_date) {
                                    $img_rt = 'delay.gif';
                                } else if ($approve_sysdate <= $due_date) {
                                    $img_rt = 'status_sqa_approve.gif';
                                }
                                $rt_date = $approve_pdate_sqareply_rt;
                            } else if ($r->REPLY_TYPE == 'R' && $r->COUNTERMEASURE_TYPE == 'F') { // JIKA RF
                                 $reply_id_rf = mssql_guid_string($r->PROBLEM_REPLY_ID);
                                 $approve_pdate_sqareply_rf = $r->APPROVE_PDATE;
                                 $due_date_rf = $r->DUE_DATE;
                            $reply = $r->REPLY_SYSDATE;
                            $approve = $r->APPROVE_SYSDATE;
                            
                                if ($reply == '') {
                                    $img_rf = 'status_sqa_blank.gif';
                                  } else if ($approve =='' && $reply != '') {
                                    $img_rf = 'nr.gif';
                                } else if ($approve_sysdate > $due_date) {
                                    $img_rf = 'delay.gif';
                                } else if ($approve_sysdate <= $due_date) {
                                    $img_rf = 'status_sqa_approve.gif';
                                }
                                $rf_date = $approve_pdate_sqareply_rf;
                            }
                        }
                    }

                    $img_ot = ($img_ot!='') ? '<img src="'.base_url().'assets/style/images/'.$img_ot.'" width="20" heigth="20" alt="status-ot" title=""/>' : '';
                    $img_of = ($img_of!='') ? '<img src="'.base_url().'assets/style/images/'.$img_of.'" width="20" heigth="20" alt="status-ot" title=""/>' : '';
                    $img_rt = ($img_rt!='') ? '<img src="'.base_url().'assets/style/images/'.$img_rt.'" width="20" heigth="20" alt="status-ot" title=""/>' : '';
                    $img_rf = ($img_rf!='') ? '<img src="'.base_url().'assets/style/images/'.$img_rf.'" width="20" heigth="20" alt="status-ot" title=""/>' : '';
                    ?>
                    <tbody>
                         <tr>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $i; ?>.</td>                      
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><span class=tool><?=$img_rf?></span></td> 
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $l->DESCRIPTION ?></td>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $l->RANK_NM2 ?></td>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $l->DFCT ?></td>
                            
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $l->CTG_NM ?></td>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $l->SQA_SHIFTGRPNM ?></td>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $l->VINNO ?></td>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $l->BODYNO ?></td>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $l->EXTCLR ?></td>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $l->PRB_SHEET_NUM ?></td>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= $l->SQPR_NUM ?></td>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><?= date('d M y', strtotime($l->SQA_PDATE)) ?> <?= date('H:i:A', strtotime($l->REG_IN)) ?></td>
                            <td style="vertical-align:middle; text-align: center;border:1px solid #888888;"><? if($l->REG_OUT !=''){ echo date('d-M-y H:i:A', strtotime($l->REG_OUT));} ?></td>    
                        </tr>
                    </tbody>
                     <?php $i++;
            endforeach;
        else: ?>
            <tr class="row-b">
                <td colspan="15">Data Is Empty</td>
            </tr>
<?php endif; ?>
                </table>
          </section>
        </div>


    </div></div></div></div>
   
 <!--<a href="" id="result_search_print" type="button" onclick='print()'>PRINT</a> 
    <input type="checkbox" checked="checked" id="result_search_print" onclick='print()' /> -->
 
     <script type="text/javascript">
             $(function(){  
                result_show('');
               //   print(''); 
               //  $('#result_search_print').click();
                });     
                var delay = setInterval(function(){
                print();
                }, 5000);
        </script>
