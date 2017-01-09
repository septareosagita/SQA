
<script type="text/javascript" src="<?php echo base_url();?>assets/public/javascript/FusionCharts.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/highcharts.src.js"></script>


<script type="text/javascript">
var belum = 0;

function result_show(){
    belum = 1;
    
    // set portrait orientation
   jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
   
   //jsPrintSetup.setOption('paperData', 8);
   jsPrintSetup.setPaperSizeData(8);
  // jsPrintSetup.setPaperSizeUnit('kPaperSizeMillimeters');
     
    // set scalling
   jsPrintSetup.setOption('scaling', 70);
   jsPrintSetup.setOption('shrinkToFit', false);
         
   // set top margins in millimeters
   jsPrintSetup.setOption('marginTop', 15);
   jsPrintSetup.setOption('marginBottom', 15);
   jsPrintSetup.setOption('marginLeft', 5);
   jsPrintSetup.setOption('marginRight', 5);
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
   window.close();
    
   
     //   window.print();
	 //	  setTimeout('window.close()',3000);
     //   alert ("Print Document Succesful");
}
</script>    
<style type="text/css">


.wrapper{
    font-family: arial;
}


</style>
<div class="wrapper" align="center">
<div class="columns" align="center">
     <div id="current_report">
    <div class="column grid_8 first">
    <div align="right" style="font-weight: bold;"><?= date('F d, Y', strtotime($date_daily_report)) ?></div>     
        <div class="judul" style=" border:1px solid #888888; color:#006600; font-weight:bold; padding:2px; margin-bottom:10px;">
            <span>DAILY TENDENCY OF SHIPPING QUALITY AUDIT</span><br />
           <?= $model ?> MODEL </div>

        <div class="widgetentri">    
          
                <!--start middlecontent -->
                <div id="middlecontent">

               
<!------------------------------------------------------daily 1-------------------------------------------->               
        <div id="daily_1">
        <div class="daily_1_left">  
               
               
                <table class="data" width="1450px" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-size:12px; border: 0px solid #000000;">
                  <tr>
                    <td colspan="1"> <div class="title" align="left" style="font-size:12px; margin-top:0px; border-bottom:1px solid #000000; margin-bottom:5px;">I. DAILY TENDENCY</div></td>
                    <td colspan="7"> <div class="title" align="left" style="font-size:12px; margin-top:0px; border-bottom:1px solid #000000; margin-bottom:5px;">II. DISTRIBUTED PROBLEM</div></td>
                  </tr>
                  <tr>
                    
                    <td rowspan="10" height="500"><div id="daily_1a2" style="width: 1050px; height: 500px; margin-right:10px; border-right:1px dotted #000000;">
					<?= $daily_2 ?></div></td>
                  </tr>
                  <tr>
                    <td  style="width:470px; height:250px;"><div id="daily_1b" style="width: 100%; height: 250px; margin:auto;" align="center"><?= $daily_3 ?></div></td>
                  </tr>
                  <tr>
                    <td><div class="title" align="left" style="border-bottom:1px solid #000000; font-size:14px;">III. DAILY RESULT ON
                      <?= date('F d, Y', strtotime($date_daily_report)) ?>
                    </div></td>
                   
                  </tr>
                  <tr>
                  <td height="220">
                 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="data2" style="text-align:center; vertical-align:middle;
                 font-size:13px; ">
                      <tr bgcolor="#EAEAEA">
                        <th width="50" rowspan="2" style="border:1px solid #888888;">&nbsp;</th>
                        <th width="70" rowspan="2" style="border:1px solid #888888;">TOTAL UNIT</th>
                        <th colspan="2" style="border:1px solid #888888;">RANK A</th>
                        <th colspan="2" style="border:1px solid #888888;">RANK B</th>
                        <th width="50" rowspan="2" style="border:1px solid #888888;">TOTAL D/U</th> 
                      </tr>
                      
                      <tr bgcolor="#EAEAEA">
                        <td width="20" style="border:1px solid #888888;" ><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="12" heigth="12" /></td>
                        <td width="20" style="border:1px solid #888888;"><img src="<?= base_url() ?>assets/style/images/box.gif" width="12" heigth="12" /></td>
                        <td width="20" style="border:1px solid #888888;"><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="12" heigth="12" /></td>
                        <td width="20" style="border:1px solid #888888;"><img src="<?= base_url() ?>assets/style/images/box.gif" width="12" heigth="12" /></td>
                       </tr>
                      <tr>
                      <?php foreach ($list_rank as $l):     
                     $rank_nm = $l->RANK_NM;
                     $rank_desc = $l->RANK_DESC;
                     $nilai = $l->DU_MDL_CTG_RANK_DAILY;
                     $dfct_ctg = $l->DFCT_CTG;
                     
                     //rank Assembly 
                      if($rank_nm =='Appearance A' && $dfct_ctg =='A')
                      {$rankA_A_App = $nilai;}
                        
                       if($rank_nm =='Function A' && $dfct_ctg =='A')
                      {$rankA_A_Func = $nilai;}                   
                       
                        if($rank_nm =='Appearance B' && $dfct_ctg =='A')
                      {$rankB_A_App = $nilai;}
                                            
                        if($rank_nm =='Function B' && $dfct_ctg =='A')
                      {$rankB_A_Func = $nilai;}
                                            
                       //rank Painting 
                      if($rank_nm =='Appearance A' && $dfct_ctg =='P')
                      {$rankA_P_App = $nilai;}
                                           
                       if($rank_nm =='Function A' && $dfct_ctg =='P')
                      {$rankA_P_Func = $nilai;}
                                            
                        if($rank_nm =='Appearance B' && $dfct_ctg =='P')
                      {$rankB_P_App = $nilai;}
                                             
                        if($rank_nm =='Function B' && $dfct_ctg =='P')
                      {$rankB_P_Func = $nilai;}
                                             
                       //rank Driving
                      if($rank_nm =='Appearance A' && $dfct_ctg =='D')
                      {$rankA_D_App = $nilai;}
                                           
                       if($rank_nm =='Function A' && $dfct_ctg =='D')
                      {$rankA_D_Func = $nilai;}
                      
                        if($rank_nm =='Appearance B' && $dfct_ctg =='D')
                      {$rankB_D_App = $nilai;}
                                            
                        if($rank_nm =='Function B' && $dfct_ctg =='D')
                      {$rankB_D_Func = $nilai;}  
                   endforeach ?>
                   
                    <?php foreach ($total_DU as $r): 
                        $dfct = $r->DFCT_CTG;
                        $Total_DU = $r->DU_MDL_CTG_RANK_DAILY;
                        if($dfct =='P'){
                          $DU_P = $Total_DU;}
                           
                           if($dfct =='A'){
                           $DU_A = $Total_DU;}
                           
                           if($dfct =='D'){
                          $DU_D = $Total_DU;}
                          
                    endforeach ?>
                    
                    <?php foreach ($cum_DU as $t): 
                        $rank_nm = $t->RANK_NM;
                        $rank_desc = $t->RANK_DESC;
                        $cum = $t->DU_MDL_CTG_RANK_MONTHLY;
                        if($rank_nm =='Function A' && $t->DFCT_CTG !='P' ){
                          $rank_montly_A_func += $cum;}                           
                           if($rank_nm =='Appearance A' ){
                           $rank_montly_A_app += $cum;}                           
                           if($rank_nm =='Function B' && $t->DFCT_CTG !='P' ){
                          $rank_montly_B_func += $cum;}
                           if($rank_nm =='Appearance B' ){
                          $rank_montly_B_app += $cum;}
                          
                    endforeach ?>
                    
                    <?php foreach ($total_DU_Mon as $d): 
                        $du_monthly = $d->DU_MONTHLY;
                        $rec_zero_dfct_day_num = $d->REC_ZERO_DFCT_DAY_NUM;
                        
                        if($du_monthly !=''){
                           $du_mon = $du_monthly;
                            }
                    endforeach ?>
                      
                        <td style="border:1px solid #888888;">ASSEMBLY</td>
                        <td rowspan="4" style="font-weight: bold; font-size: 30px; color: black; border:1px solid #888888;"">
                        <?php if($num_veh !=''){
                            echo $num_veh;}
                            else {
                                echo '0';
                            }              
                        ?></td>
                        <td style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;">
                          <?php if ($rankA_A_Func !=''){
                            echo $rankA_A_Func; }
                            else {
                                echo '0';
                            }
                         ?>
                       </td>
                        <td style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php if ($rankA_A_App !=''){
                            echo $rankA_A_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 20px; color: black;  border:1px solid #888888;">
                          <?php if ($rankB_A_Func !=''){
                            echo $rankB_A_Func; }
                            else {
                                echo '0';
                            }
                         ?>
                        </td>
                        <td style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php if ($rankB_A_App !=''){
                            echo $rankB_A_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><span style="font-weight: bold; font-size: 20px; color: black;">
                          <?php 
						$to_a = (($rankA_A_Func + $rankA_A_App + $rankB_A_Func + $rankB_A_App)/$num_veh);
						if ($to_a !=''){
                            echo number_format($to_a,2); }
                            else {
                                echo '0';
                            }
                         ?>
                        </span></td>
                      </tr>
                      <tr>
                        <td style="border:1px solid #888888;">PAINTING</td>
                        <td style="font-weight: bold; font-size: 15px; color: black; border:1px solid #888888;background-color: gray;">&nbsp;</td>
                        <td style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php if ($rankA_P_App !=''){
                            echo $rankA_P_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 15px; color: black; border:1px solid #888888;background-color: gray;">&nbsp;</td>
                        <td style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php if ($rankB_P_App !=''){
                            echo $rankB_P_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><span style="font-weight: bold; font-size: 20px; color: black;">
                          <?php 
						$to_p = (($rankA_P_App + $rankB_P_App)/$num_veh);
						if ($to_p !=''){
                            echo number_format($to_p,2); }
                            else {
                                echo '0';
                            }
                         ?>
                        </span></td>
                      </tr>
                      <tr>
                        <td style="border:1px solid #888888;">DRIVING</td>
                        <td style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php if ($rankA_D_Func !=''){
                            echo $rankA_D_Func; }
                            else {
                                echo '0';
                            }
                         ?> </td>
                        <td style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php if ($rankA_D_App !=''){
                            echo $rankA_D_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php if ($rankB_D_Func !=''){
                            echo $rankB_D_Func; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 20px; color: black;border:1px solid #888888;"><?php if ($rankB_D_App !=''){
                            echo $rankB_D_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 20px; color: black;border:1px solid #888888;"><span style="font-weight: bold; font-size: 20px; color: black;">
                          <?php 
						$to_d = (($rankA_D_Func + $rankA_D_App + $rankB_D_Func + $rankB_D_App)/$num_veh);
						if ($to_d !=''){
                            echo number_format($to_d,2); }
                            else {
                                echo '0';
                            }
                         ?>
                        </span></td>
                      </tr>
                      <tr>
                        <th bgcolor="#EAEAEA" style="border:1px solid #888888;">TOTAL</th>
                        <th bgcolor="#EAEAEA" style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php echo ($rankA_A_Func)+($rankA_D_Func)  ?></th>
                        <th bgcolor="#EAEAEA" style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php echo ($rankA_P_App)+($rankA_A_App)+($rankA_D_App)  ?></th>
                        <th bgcolor="#EAEAEA" style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php echo ($rankB_A_Func)+($rankB_D_Func)  ?></th>
                        <th bgcolor="#EAEAEA" style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><?php echo ($rankB_P_App)+($rankB_A_App)+($rankB_D_App)  ?></th>
                           <th bgcolor="#EAEAEA" style="font-weight: bold; font-size: 20px; color: black; border:1px solid #888888;"><span style="font-weight: bold; font-size: 20px; color: black;"><?php echo number_format(($to_a)+($to_p)+($to_d),2)  ?></span></th>
                      </tr>
                      <tr bgcolor="#EAEAEA">
                        <th style="border:1px solid #888888;">CUM</th>
                        <th style="font-weight: bold;color: black; font-size: 20px; border:1px solid #888888;">
                         <?php if ($total_unit !=''){
                          echo  $total_unit;}
                            else{
                                echo '0';
                            }                     
                        ?>                        </th>
                        <th style="font-weight: bold;color: black; font-size: 20px; border:1px solid #888888;">
                         <?php if ($rank_montly_A_func !=''){
                            echo $rank_montly_A_func;}
                            else{
                                echo '0';
                            }                     
                        ?>                        </th>
                        <th style="font-weight: bold;color: black; font-size: 20px; border:1px solid #888888;">
                         <?php if ($rank_montly_A_app !=''){
                            echo $rank_montly_A_app;}
                            else{
                                echo '0';
                            }                     
                        ?>                        </th>
                        <th style="font-weight: bold;color: black; font-size: 20px; border:1px solid #888888;">
                         <?php if ($rank_montly_B_func !=''){
                            echo $rank_montly_B_func;}
                            else{
                                echo '0';
                            }                     
                        ?>                        </th>
                        <th style="font-weight: bold;color: black; font-size: 20px; border:1px solid #888888;">
                          <?php if ($rank_montly_B_app !=''){
                            echo $rank_montly_B_app;}
                            else{
                                echo '0';
                            }                     
                        ?>                                            </th>
                        <th style="font-weight: bold;color: black; font-size: 25px; border:1px solid #888888;"><span style="font-weight: bold;color: black; font-size: 20px;">
                          <?php 
						$to_du = (($rank_montly_A_func + $rank_montly_A_app + $rank_montly_B_func + $rank_montly_B_app)/$total_unit);
						if ($to_du !=''){
                           echo number_format($to_du,2);}
                            else{
                                echo '0';
                            }                     
                        ?>
                        </span></th>
                      </tr>
                 </table>      
                  
                  </td>
                  
                  </tr>
                
              
                </table>


        </div>
      
<!------------------------------------------------------End daily 1----------------------------------------> 

<!------------------------------------------------------daily 2-------------------------------------------->

  <table width="1450px" height="400" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="data" style="font-size:12px; margin-top:10px; border: 0px solid #000000">
    <tr>
      <td colspan="5"><div align="left" style="font-size:12px; margin-top:0px; border-bottom:1px solid #000000">IV. PROBLEM SHEET</div></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td width="650px;" rowspan="6"><div id="Prob_sheet" style="width: 110%; height: 350px; ">
            <?= $daily_4 ?>
            </div></td>
      <th style="vertical-align: middle; text-align: center; color:#FFFFFF; border:1px solid #888888; margin-right:10px; height:50px; font-size:15px;" width="100px;" bgcolor="#000000">TOTAL</th>
      <td rowspan="5" width="450" height="270"><div id="Prob_sheet3" style="width: 95%; height: 250px;" align="center">
          <?= $daily_5 ?>
      </div></td>
    </tr>
    <tr>
      <td style="vertical-align: middle; text-align: center; border:1px solid #888888; margin-right:10px;">SEND</td>
    </tr>
    <tr>
      <td style="vertical-align: middle; text-align: center; font-weight: bold; height:90px; font-size:28px; border:1px solid #888888; margin-right:10px;">
	  <?= ($total_send !='')? $total_send:0 ?></td>
    </tr>
    <tr>
      <td style="vertical-align: middle; text-align: center; border:1px solid #888888; margin-right:10px;">REPLY</td>
    </tr>
    <tr>
      <td style="vertical-align: middle; text-align: center; font-weight: bold;  height:90px; font-size:28px; border:1px solid #888888; margin-right:10px;">
	 <?= ($total_reply !='')? $total_reply:0 ?></td>
    </tr>
    <tr>
      <td style="vertical-align: middle; text-align: center; height:45px; border:1px solid #888888; margin-right:10px;">P/S<br />
        NOT YET REPLY</td>
     <td style="text-align: center;">
        <div align="center">
        
        <img style="float:left; margin-top: 30px; margin-left: 5px;" src="<?= base_url() ?>assets/style/images/panah.gif" width="20" heigth="40" /> 
            
                 <table width="90%" height="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-size:9px; border:1 solid #000000; margin-left:5px; padding-left:15px; padding-right:15px;">
                   
        <tr>  <?php 
                            $CEK="";
                            $i=0;
                            foreach ($list_total_delay as $t): ?>  
                          <?php  $hsl=$t->SHOP_NM;  
                            $CEK."=".$hsl;                    
                            IF($CEK==$hsl)
                            { }
                            ELSE
                            {$CEK=$hsl;
                                $i++;?>
                             <td width="15%" height="30" style="vertical-align: middle; text-align: center; font-size:14px; font-weight: bold; border:1px solid #888888;"><?= $t->SHOP_NM ?></td>
                       <?php } endforeach; ?>
                   </tr>                                 
                   <tr>    <?php 
                            $CEK="";
                            $i=0;
                            foreach ($list_nilai_delay as $t): 
                            if($t->SUM_TYPE =='R')                    
                                {
                                $r = $t->NUM_PS_MONTHLY;
                                $rs = $t->SHOP_NM;
                                }
                                 if($t->SUM_TYPE =='S')
                                {
                                $s = $t->NUM_PS_MONTHLY;
                                $ss = $t->SHOP_NM;
                                }
                                
                              if($rs==$ss){
                                        $selisih = ($s-$r);
                                    }
                                   
                            ?>  
                          <?php  
                         
                           $hsl=$ss; 
                           $hsl2=$rs;
                            $CEK."=".$hsl;                    
                            IF($CEK==$hsl || $CEK==$hsl2)
                            { }
                            ELSE
                            {$CEK=$hsl;
                                $i++;?> 
                                                 
                        <td height="40" style="font-weight: bold; font-size: 14px; color: black; vertical-align: middle; text-align: center; font-weight: bold; border:1px solid #888888;">
                         <?php 
                         
                                 if ($t->NUM_PS_MONTHLY !='') {
                                    echo $selisih;
                                   }
                                   else {
                                       echo '0'; 
                                    }
                             
                            
                         ?>                       </td>
                      <?php } endforeach ?>
                   </tr>                   
                 </table>
          </div>      </td>
    </tr>
  </table>
</div></td>
       </tr>
</table>

               
            </div>
<!------------------------------------------------------End daily 2----------------------------------------> 

<!------------------------------------------------------daily 3-------------------------------------------->               
      
        <div class="daily_3a">
          <table width="100% "border="1" cellpadding="2" cellspacing="0" bordercolor="#000000" class="data2" style="font-size:10px;">
            <tr>
              <td colspan="52" style=" border-bottom:1px solid #000000;"><div align="left" style="margin-top:0px; margin-bottom:5px;">V. PROBLEM FOLLOW UP ON
                <?= date('F, Y', strtotime(get_date())) ?>
                &nbsp; &nbsp;  &nbsp; &nbsp; Note : 
                &nbsp; &nbsp;
                X = Problem Sheet Release
                &nbsp; &nbsp; <img src="<?= base_url() ?>assets/style/images/yellow.gif" width="13" heigth="13" /> = Problem Sheet Reply 
                &nbsp; &nbsp; <img src="<?= base_url() ?>assets/style/images/white.gif" width="13" heigth="13" /> = Problem Sheet Due Date
                &nbsp; &nbsp; <img src="<?= base_url() ?>assets/style/images/box.gif" width="13" heigth="13" /> = Apperance
                &nbsp; &nbsp; <img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="13" heigth="13" /> = Function 
                &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                Remark : 
                &nbsp; &nbsp; <img src="<?= base_url() ?>assets/style/images/blank.gif" width="13" heigth="13" /> = Not Yet Answered
                &nbsp; &nbsp; <img src="<?= base_url() ?>assets/style/images/black.gif" width="13" heigth="13" /> = fix C/Measure
                </div></td>
            </tr>
            <tr bgcolor="#EAEAEA">
              <th width="15" rowspan="2" style="border:1px solid #888888;">No.</th>
              <th width="250" rowspan="2" style="border:1px solid #888888;">Item Problem
                <?= $model ?></th>
              <th width="40" rowspan="2" style="border:1px solid #888888;">Rank</th>
              <th width="23" rowspan="2" style="border:1px solid #888888;">INSP</th>
              <th width="13" rowspan="2" style="border:1px solid #888888;">QUALITY GATE</th>
              <th width="30" rowspan="2" style="border:1px solid #888888;">Repair Hist</th>
              <th width="29" rowspan="2" style="border:1px solid #888888;">PROD SHIFT</th>
              <th width="29" rowspan="2" style="border:1px solid #888888;">INSP SHIFT</th>
              <?= list($thn,$bln,$tgl) = explode('-',$date_daily_report); ?>
              <th colspan="<?= $sparator ?>"><?= $kurangbulan = date("F y", mktime(0,0,0,$bln - 1,$tgl,$thn)); ?></th>
              <th colspan="<?= $sparator2 ?>"><?= date("F y",mktime(0,0,0,$bln,$tgl,$thn)); ?></th>
              <th style="border:1px solid #888888;" width="29" rowspan="2">Respon</th>
              <th style="border:1px solid #888888;" width="29" rowspan="2">PROD</th>
              <th style="border:1px solid #888888;" width="29" rowspan="2">INSP</th>
              <th style="border:1px solid #888888;" width="29" rowspan="2">Status</th>
            </tr>
            <tr bgcolor="#EAEAEA">
              
                      
              <?php foreach ($list_tanggal as $r): ?>
                        <th width="13"><?= $r ?></th>
                      <?php endforeach; ?>
                     </tr>
                     
                     <?php 
                            $cek = " ";
                            $i = 0;
                            $h = 0;
                            $cek_d_temp = '';
                            $tr_style = '';
                            foreach ($list_daily_report as $l): ?>  
                     <?php  $hsl = $l->PROBLEM_ID;  
                         //  echo $cek." = ".$hsl ."//";                    
                            if($cek == $hsl)
                            { }
                            else
                            {$cek = $hsl;
                                $i++;?>
                                
                                
                                <?php
                                $cek_d = $l->SQA_PDATE;                                
                                $cd = date('m', strtotime($cek_d));
                                if ($cd != $cek_d_temp) {
                                    $cek_d_temp = $cd;
                                    if ($h != 1) {
                                        $tr_style = 'style="border-top: 3px solid #000000"';    
                                    }
                                    $h = 1;
                                } else {
                                    $h++;
                                    $tr_style = '';
                                }                    
                            ?>
                     
                    <tr <?=$tr_style?>>
                        <td><?= $h; ?>.</td>
                        <td><?= $l->DFCT ?><?= $l->DESCRIPTION ?></td>
                        <td><?php
                                if($l->RANK_NM =='Function A' || $l->RANK_NM =='Function B'){
                            echo '<img src="'. base_url(). 'assets/style/images/box_putih.gif" width="12" heigth="12" />'; }
                            else if($l->RANK_NM =='Appearance A' || $l->RANK_NM =='Appearance B'){
                            echo '<img src="'. base_url(). 'assets/style/images/box.gif" width="12" heigth="12" />';}
                            ?>
                        <?php if($l->RANK_NM =='Function A' || $l->RANK_NM =='Appearance A'){
                            echo 'A'; }
                            else if($l->RANK_NM =='Function B' || $l->RANK_NM =='Appearance B'){
                            echo 'B';}
                        ?></td>
                        <td><?php if($l->INSP_ITEM_FLG =='0'){
                            echo 'No';}
                            else if($l->INSP_ITEM_FLG =='1'){
                            echo 'Yes';   
                            }
                        ?></td>  
                                
                       <td>
							<?php
                            if($l->SHOP_NM =='Chosagoumi'){
                                echo '-'; }
                                else {
                                  echo $l->SHOP_NM;  
                                } 
                            
                            ?>
                        </td>
                    
                        <td><?php if($l->REPAIR_FLG =='0'){
                            echo 'No';}
                            else if($l->REPAIR_FLG =='1') {
                            echo 'Yes';   
                            } ?></td>
                        <td><?php 
                        if($l->ASSY_SHIFTGRPNM =='1'){
                            echo 'R'; }
                        else if ($l->ASSY_SHIFTGRPNM =='2'){
                            echo 'W'; }
                        //else if ($l->ASSY_SHIFTGRPNM =='3'){
                        //    echo 'W'; }   
                        
                        ?></td>             
                        <td><?= substr($l->SQA_SHIFTGRPNM,0,1); ?></td>
                        <?php
                         
                        $tgl = 35;
                        for ($i=1;$i<=35;$i++){
                        //$timestamp2 = strtotime("-".$tgl." day");
                        //$minusfiveweek2 = date("d-m-Y",$timestamp2);                      
                        //$tanggal_daily2 = strtotime($minusfiveweek);
                        //$fiveweeks = strtotime('+1 day' , $tanggal_daily2);
                        //$now = date("Y-m-d",$fiveweeks);
                        //$tanggal[] = date('d', strtotime($now));
                        
                        list($thn,$bln,$tgl) = explode('-',$date_daily_report);
    		            $timestamp = mktime(0,0,0,$bln,$tgl-35,$thn);
                		$minusfiveweek = date("d-m-Y",$timestamp);
                        list($tgl,$bln,$thn) = explode('-',$minusfiveweek);
                        $now = date("Y-m-d", mktime(0,0,0,$bln,$tgl + $i,$thn));
                        $tanggal[] = date('d', strtotime($now));
                        //$tgl = 35-$i;
                        echo "<td>"; 
                                if($now == $l->APPROVE_PDATE){  
                                echo "x";}
                                if ($now == date("Y-m-d",strtotime($l->APPROVE_PDATE_REPLY))){
                                echo '<img src="'. base_url(). 'assets/style/images/yellow.gif" width="13" heigth="13" />';
                                }
                                if ($now == date("Y-m-d",strtotime($l->DUE_DATE))){
                                echo '<img src="'. base_url(). 'assets/style/images/white.gif" width="13" heigth="13" />';
                                }  
                        echo "</td>";
                        } ?>
                        <td><?= $l->SHOP_NM ?></td>
                        <td style="vertical-align:middle; text-align: center"><?= ($l->APPROVE_PDATE_REPLY !='' && $l->REPLY_TYPE =='R')?'<img src="'. base_url(). 'assets/style/images/black.gif" width="15" heigth="15" />':'<img src="'. base_url(). 'assets/style/images/blank.gif" width="15" heigth="15" />' ?></td>
                        <td style="vertical-align:middle; text-align: center"><?= ($l->APPROVE_PDATE_REPLY !='' && $l->REPLY_TYPE =='O')?'<img src="'. base_url(). 'assets/style/images/black.gif" width="15" heigth="15" />':'<img src="'. base_url(). 'assets/style/images/blank.gif" width="15" heigth="15" />' ?></td>
                        <td style="vertical-align:middle; text-align: center"><?= ($l->CLOSE_FLG =='0')?'Open':'Closed' ?></td>
                      
                     </tr>  
                     
                              
                           <?php } endforeach; ?>
                   
                  
                    </table>
        </div> 
                             
        </div> &nbsp;&nbsp;
<!------------------------------------------------------End daily 3----------------------------------------> 


<!------------------------------------------------------daily 4-------------------------------------------->               
       
             <div class="daily_4a">
                    <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#EAEAEA" class="data2" style="font-size:16px; margin: auto; border:1px solid #888888;">
                    <tr>
                      <th width="20%" rowspan="2" style="border:1px solid #888888; ">TOTAL ZERO DEFECT DAY <?= date('F', strtotime(get_date())) ?> : <?= ($zero_dfct_day_num !='')? $zero_dfct_day_num: 0; ?> DAYS<br />
                      TOTAL WORKING DAY ON <?= date('F', strtotime(get_date())) ?> : <?=$total_working_day ?> DAYS</th>
                      <th width="25%" rowspan="4" style="border:1px solid #888888">COUNTINOUS &quot;0&quot; DEFECT DAY : <?= ($count_zero_dfct_day_num !='')? $count_zero_dfct_day_num: 0; ?> DAYS</th>
                        <th colspan="2" style="border:1px solid #888888">CUM. F/YEAR 2010 - 2011</th>
                      </tr>
                    <tr>
                      <th style="border:1px solid #888888">TOTAL UNIT</th>
                       <th style="border:1px solid #888888"><?= ($total_unit_month !='')? $total_unit_month: 0; ?></th>
                    </tr>
                    <tr>
                      <th rowspan="2" style="border:1px solid #888888">PAST RECORD DAY (<?= ($total_defect !='')? date('F Y', strtotime($rec_zero_dfct_month_year)) : '-'; ?>) 
					  : <?= ($rec_zero_dfct_day_num !='')? $rec_zero_dfct_day_num: 0; ?> DAYS</th>
                     <th style="border:1px solid #888888">DEFECT</th>
                       <th style="border:1px solid #888888"><?= ($total_defect !='')? $total_defect: 0; ?></th>
                       
                    </tr>
                    <tr>
                      <th width="15%" style="border:1px solid #888888">DEFECT / UNIT</th>
                      <th width="15%"  style="border:1px solid #888888"><?= number_format(($total_defect/$total_unit_month),2) ?></th>
                      </tr>
                 </table>                  
        </div>
            <div class="daily_5">
              <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="data2" style="font-size:15px; margin: auto; border:1px solid #888888; text-align:center">
                <tr>
                  <th width="15%" bgcolor="#EAEAEA" style="border:1px solid #888888;">TOTAL CHECK INSPECTION</th>
                  <td width="5%" style="border:1px solid #888888;color: black; font-weight: bold;"><?= ($total_inspection_item!='')? $total_inspection_item : 0 ; ?></td>
                  <th width="15%" bgcolor="#EAEAEA" align="center" style="border:1px solid #888888;">REPAIR HISTORY</th>
                  <td width="5%" style="border:1px solid #888888; color: black; font-weight: bold;"><?= ($total_repair_flag!='')? $total_repair_flag : 0 ; ?></td>
                  <th width="15%" bgcolor="#EAEAEA" rowspan="2" align="center" style="border:1px solid #888888;">PROD SHIFT</th>
                  <th width="5%" bgcolor="#EAEAEA" style="border:1px solid #888888;">RED</th>
                  <td width="5%" style="border:1px solid #888888; color: black; font-weight: bold;"><?= ($total_prod_shift_red!='')? $total_prod_shift_red : 0 ; ?></td>
                  <td width="5%" style="border:1px solid #888888; color: black; font-weight: bold;"><?= $persentase_prod_shift_red ?>%</td>
                  <th width="15%" bgcolor="#EAEAEA" rowspan="2" style="border:1px solid #888888;">INSP SHIFT</th>
                  <th width="5%" bgcolor="#EAEAEA" style="border:1px solid #888888;">RED</th>
                  <td width="5%" style="border:1px solid #888888; color: black; font-weight: bold;"><?= ($total_insp_shift_red!='')? $total_insp_shift_red : 0 ; ?></td>
                  <td width="5%" style="border:1px solid #888888; color: black; font-weight: bold;"><?= number_format($persentase_insp_shift_red,2) ?>%</td>
                </tr>
                <tr>
                  <th bgcolor="#EAEAEA" style="border:1px solid #888888;">PERCENTAGE (%)</th>
                  <td style="border:1px solid #888888;"><?= $persentase_insp_item ?>%</td>
                  <th bgcolor="#EAEAEA" align="center" style="border:1px solid #888888;">PERCENTAGE (%)</th>
                  <td style="border:1px solid #888888;"><?=$persentase_reply_hist?>%</td>
                  <th bgcolor="#EAEAEA" style="border:1px solid #888888;">WHITE</th>
                  <td style="border:1px solid #888888; color: black; font-weight: bold;"><?= ($total_insp_prod_white!='')? $total_insp_prod_white : 0 ; ?></td>
                  <td width="5%" style="border:1px solid #888888; color: black; font-weight: bold;"><?= $persentase_prod_shift_white ?>%</td>
                  <th bgcolor="#EAEAEA" style="border:1px solid #888888;">WHITE</th>
                  <td style="border:1px solid #888888; color: black; font-weight: bold;"><?= ($total_insp_shift_white!='')? $total_insp_shift_white : 0 ; ?></td>
                  <td width="5%" style="border:1px solid #888888; color: black; font-weight: bold;"><?= number_format($persentase_insp_shift_white,2) ?>%</td>
                </tr>
              </table>
            </div>
            
<!------------------------------------------------------End daily 4----------------------------------------> 

</div></div></div></div>
 <script type="text/javascript">

            $(function(){
               // result_show('');
              
            });
             var delay = setInterval(function(){
                if (belum == 0) {
                    result_show();     
                }
            }, 5000);
        </script>
