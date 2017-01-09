<script type="text/javascript">

$(function(){
         var afunc = $('#rank_a_func').val();
		 var bfunc = $('#rank_b_func').val();
		 var unit_veh = $('#unit_veh').val();
         var hasil_plus = parseInt(afunc) + parseInt(bfunc);
		 var hasil_du_func = parseInt(hasil_plus) / parseInt(unit_veh);
         var result = hasil_du_func.toFixed(2);
         if(hasil_plus ==''){
          $("#hasil").html('0.00');       
         }
         else{
         $("#hasil").html(result);
         }
		// alert (hasil_du_func);
         });
        
function monthly_print(){
        $('#monthly_print').hide();
        
        // set portrait orientation
   jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
   
   // set scalling
   jsPrintSetup.setOption('scaling', 70);
   jsPrintSetup.setOption('shrinkToFit', false);
   
   // set top margins in millimeters
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
        <div style="margin-left:500px; margin-bottom: 30px;">
            <h1><span style="color:green; font-size: 30px;">Summary Monthly Data SQA</span></h1>
        </div>

        <div class="widgetentri">

            <section>
            <h4 style="margin:-1px; clear: both; text-align: right;">MONTH : <?= $bulankurangsatu_tahun ?></h4>
                <!--start middlecontent -->
                <div id="middlecontent" style="font-size: 13px; font-family: calibri;">
                <h4 style="margin:-1px; clear: both;">I. Model <?=$model ?></h4><hr>
                <div style="font-weight:bold">A. TOTAL VEHICLE CHECK : <?= ($total_unit_month !='')? $total_unit_month: 0; ?></div>
                <div style="font-weight:bold">B. AUDIT RESULT  </div>
                <table width="50%" class="data2" border="1" cellpadding="0" cellspacing="0" style="text-align:center; margin:10px;">
  <tr>
  
    <?php foreach ($list_rank as $l):     
                     $rank_nm = $l->RANK_NM;
                     $rank_desc = $l->RANK_DESC;
                     $nilai = $l->DU_MDL_CTG_RANK_MONTHLY;
                     $dfct_ctg = $l->DFCT_CTG;
                     
                     //rank Assembly 
                      if($rank_nm =='Appearance A' && $dfct_ctg =='A')
                      {$rankA_A_App += $nilai;}
                        
                       if($rank_nm =='Function A' && $dfct_ctg =='A')
                      {$rankA_A_Func += $nilai;}                   
                       
                        if($rank_nm =='Appearance B' && $dfct_ctg =='A')
                      {$rankB_A_App += $nilai;}
                                            
                        if($rank_nm =='Function B' && $dfct_ctg =='A')
                      {$rankB_A_Func = $nilai;}
                                            
                       //rank Painting 
                      if($rank_nm =='Appearance A' && $dfct_ctg =='P')
                      {$rankA_P_App += $nilai;}
                                           
                       if($rank_nm =='Function A' && $dfct_ctg =='P')
                      {$rankA_P_Func += $nilai;}
                                            
                        if($rank_nm =='Appearance B' && $dfct_ctg =='P')
                      {$rankB_P_App += $nilai;}
                                             
                        if($rank_nm =='Function B' && $dfct_ctg =='P')
                      {$rankB_P_Func += $nilai;}
                                             
                       //rank Driving
                      if($rank_nm =='Appearance A' && $dfct_ctg =='D')
                      {$rankA_D_App += $nilai;}
                                           
                       if($rank_nm =='Function A' && $dfct_ctg =='D')
                      {$rankA_D_Func += $nilai;}
                      
                        if($rank_nm =='Appearance B' && $dfct_ctg =='D')
                      {$rankB_D_App += $nilai;}
                                            
                        if($rank_nm =='Function B' && $dfct_ctg =='D')
                      {$rankB_D_Func += $nilai;}   
                   endforeach ?>
                   
    <th rowspan="2" style="background-color:#EAEAEA;">ITEM</th>
    <th colspan="2" style="background-color:#EAEAEA;">Rank A</th>
    <th colspan="2" style="background-color:#EAEAEA;">RANK B</th>
    <th rowspan="2" style="background-color:#EAEAEA;">TOTAL RANK</th>
  </tr>
  <tr>
    <td style="text-align:center; background-color:#EAEAEA;"><img src="<?= base_url() ?>assets/style/images/box.gif" width="12" heigth="12" /></td>
    <td style="text-align:center;background-color:#EAEAEA;"><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="12" heigth="12" /></td>
    <td style="text-align:center;background-color:#EAEAEA;"><img src="<?= base_url() ?>assets/style/images/box.gif" width="12" heigth="12" /></td>
    <td style="text-align:center;background-color:#EAEAEA;"><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="12" heigth="12" /></td>
    </tr>
 
  <tr>
    <th style="background-color:#EAEAEA;">ASSEMBLY</th>
    <td><?php if ($rankA_A_Func !=''){
                            echo $rankA_A_Func; }
                            else {
                                echo '0';
                            }
                         ?></td>
    <td><?php if ($rankA_A_App !=''){
                            echo $rankA_A_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
    <td><?php if ($rankB_A_Func !=''){
                            echo $rankB_A_Func; }
                            else {
                                echo '0';
                            }
                         ?></td>
    <td><?php if ($rankB_A_App !=''){
                            echo $rankB_A_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
    <td><?php echo $ta = number_format((($rankA_A_Func)+($rankA_A_App)+($rankB_A_Func)+($rankB_A_App))/$total_unit_month,2)?></td>
  </tr>
   <tr>
    <th style="background-color:#EAEAEA;">PAINTING</th>
    <td style="background-color:#CCCCCC"></td>
    <td><?php if ($rankA_P_App !=''){
                            echo $rankA_P_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
    <td style="background-color:#CCCCCC"></td>
    <td><?php if ($rankB_P_App !=''){
                            echo $rankB_P_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
    <td><?php echo $tp = number_format((($rankA_P_App)+($rankB_P_App))/$total_unit_month,2)?></td>
  </tr>
  <tr>
    <th style="background-color:#EAEAEA;">DRIVING</th>
    <td><?php if ($rankA_D_Func !=''){
                            echo $rankA_D_Func; }
                            else {
                                echo '0';
                            }
                         ?></td>
    <td><?php if ($rankA_D_App !=''){
                            echo $rankA_D_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
    <td><?php if ($rankB_D_Func !=''){
                            echo $rankB_D_Func; }
                            else {
                                echo '0';
                            }
                         ?></td>
    <td><?php if ($rankB_D_App !=''){
                            echo $rankB_D_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
    <td><?php echo $td = number_format((($rankA_D_Func)+($rankA_D_App)+($rankB_D_Func)+($rankB_D_App))/$total_unit_month,2)?></td>
  </tr>
  <tr>
    <th style="background-color:#EAEAEA;">TOTAL</th>
    <td><?php echo ($rankA_A_Func)+($rankA_D_Func)?></td>
    <td><?php echo $ap = ($rankA_P_App)+($rankA_A_App)+($rankA_D_App)?></td>
    <td><?php echo $bf = ($rankB_A_Func)+($rankB_D_Func)?></td>
    <td><?php echo $bp = ($rankB_P_App)+($rankB_A_App)+($rankB_D_App)?></td>
    <td><?php echo ($ta + $tp + $td) ?></td>
  </tr>
</table>

<div style="font-weight:bold">DISTRIBUTION D/U BY RANK</div>
<table width="98%" class="data2" border="1" cellpadding="0" cellspacing="0" style="text-align:center; margin:10px;">
  <tr style="background-color:#EAEAEA;">
    <th>&nbsp;</th>
    <th style="text-align:center;">MONTH</th>
    <?php foreach ($bulan_fiscal as $l): ?>
    <th><?= $l ?></th>
    <?php endforeach ?>
    <th>TOTAL</th>
    <th colspan="2" style="text-align:center;">AVG</th>
    </tr>
  <tr>
    <td rowspan="5" style="text-align:center;">RANK</td>
     
    <td style="text-align:center;"><img src="<?= base_url() ?>assets/style/images/box.gif" width="12" heigth="12" /> A</td>
     <?php 
     $bulan_max_fiscal; 
     $bulan_min_fiscal;
      
       // menhitung selisih bulan 
        //exlplode 1
        $pecah1 = explode("-", $bulan_max_fiscal);
        $date1 = $pecah1[0];
        $month1 = $pecah1[1];
        $year1 = $pecah1[2];
        //exlplode 2
        $pecah2 = explode("-", $bulan_min_fiscal);
        $date2 = $pecah2[0];
        $month2 = $pecah2[1];
        $year2 = $pecah2[2];
       
      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $rankA_func = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
           // $pdate_krg_satu = date("n", mktime(0, 0, 0, date("n"), date("d"), date("Y")));
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_dfct = $l->NUM_DFCT;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
           // $datenow = date("m", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal) && ($rank_nm =='Function A')){                               
                $rankA_func += $num_dfct ;
            }
        endforeach;
        echo $tes = $rankA_func;                          
                                            
     echo "</td>";
     $total_rankA_func += $rankA_func; 
     } ?>                
	<input type="hidden" id="rank_a_func" value="<?=$total_rankA_func ?>"/>	
    <td><?=number_format($total_rankA_func,2) ?></td>
    <td><?= number_format($total_rankA_func/$count_m_pdate,2) ?></td>
    <td style="text-align:center;">D/U FUNC</td>
  </tr>
  <tr>
    <td style="text-align:center;"><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="12" heigth="12" /> A</td>
     <?php 
     $bulan_max_fiscal; 
     $bulan_min_fiscal;
      
       // menhitung selisih bulan 
        //exlplode 1
        $pecah1 = explode("-", $bulan_max_fiscal);
        $date1 = $pecah1[0];
        $month1 = $pecah1[1];
        $year1 = $pecah1[2];
        //exlplode 2
        $pecah2 = explode("-", $bulan_min_fiscal);
        $date2 = $pecah2[0];
        $month2 = $pecah2[1];
        $year2 = $pecah2[2];
       
      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $rankA_App = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_dfct = $l->NUM_DFCT;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal) && ($rank_nm =='Appearance A')){                               
                $rankA_App += $num_dfct ;
            }
          
        endforeach;
        echo $rankA_App;                          
                                            
     echo "</td>";
      $total_rankA_App += $rankA_App;
     } ?>  
     <td><?=number_format($total_rankA_App,2) ?></td>   
    <td><?= number_format($total_rankA_App/$count_m_pdate,2) ?></td>
    <td rowspan="4"><div id="hasil">&nbsp;</div></td>
  </tr>
  <tr>
    <td style="text-align:center;"><img src="<?= base_url() ?>assets/style/images/box.gif" width="12" heigth="12" /> B</td>
    <?php 

      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $rankB_func = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_dfct = $l->NUM_DFCT;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal) && ($rank_nm =='Function B')){                               
                $rankB_func += $num_dfct ;
            }
             
        endforeach;
        echo $rankB_func;                          
                                            
     echo "</td>";
     $total_rankB_func += $rankB_func;
     } ?> 
     <input type="hidden" id="rank_b_func" value="<?=$total_rankB_func ?>"/>
    <td><?=number_format($total_rankB_func,2) ?></td>
    <td><?= number_format($total_rankB_func/$count_m_pdate,2) ?></td>
    </tr>
  <tr>
    <td style="text-align:center;"><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="12" heigth="12" /> B</td>
    <?php 

      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $rankB_App = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_dfct = $l->NUM_DFCT;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal) && ($rank_nm =='Appearance B')){                               
                $rankB_App += $num_dfct ;
            }
            
        endforeach;
        echo $rankB_App;                          
                                            
     echo "</td>";
      $total_rankB_App += $rankB_App;
     } ?>  
    <td><?=number_format($total_rankB_App,2) ?></td>
    <td><?= number_format($total_rankB_App/$count_m_pdate,2) ?></td>
    </tr>
  
  <tr style="background-color:#EAEAEA;">
    <td style="text-align:center;">TOT DEFECT</td>
     <?php 

      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $tot_rank = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_dfct = $l->NUM_DFCT;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal)){ 
                                
                $tot_rank += $num_dfct ;
            }
            
        endforeach;
        echo $tot_rank;                          
                                            
     echo "</td>";
      
     } ?> 
    <th><?= $total_unit_veh = number_format(($total_rankA_func+$total_rankA_App+$total_rankB_func+$total_rankB_App),2) ?></th>
    <th><?= number_format((($total_rankA_func/$count_m_pdate)+($total_rankA_App/$count_m_pdate)+
            ($total_rankB_func/$count_m_pdate)+($total_rankB_App/$count_m_pdate)),2) ?></th>
    </tr>
  <tr style="background-color:#EAEAEA;">
    <th colspan="2">UNIT VEHICLE</th>
    <?php 

      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<th>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $tot_veh = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_veh = $l->NUM_VEH;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal)){                               
                $tot_veh = $num_veh ;
            }
            
        endforeach;
		
        echo $tot_veh;                          
                                            
     echo "</th>";
      $total_tot_veh += $tot_veh;
     } ?>
     <input type="hidden" id="unit_veh" value="<?=$unit_veh=$total_tot_veh?>"/>
     <th><?=$unit_veh=$total_tot_veh?></th> 
    <th><?= number_format($total_tot_veh/$count_m_pdate,2) ?></th>
    <th>&nbsp;</th>
  </tr>
  <tr>
    <td rowspan="5" style="text-align:center;">D/U</td>
    <td style="text-align:center;"><img src="<?= base_url() ?>assets/style/images/box.gif" width="12" heigth="12" /> A</td>
     <?php 

      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $rankA_func = $tot_veh = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_veh = $l->NUM_VEH;
			 $num_dfct = $l->NUM_DFCT;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal)){                               
                $tot_veh += $num_veh ;
            }
			
			 if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal) && ($rank_nm =='Function A')){                               
                $rankA_func += $num_dfct ;
            }
            
        endforeach;
		if ($rankA_func/$tot_veh !=''){
        echo number_format(($rankA_func/$tot_veh),2);                          
        }
		else {
		echo '';
		}                                    
     echo "</td>";
      $total_tot_veh += $tot_veh;
     } ?>
    <td><?= number_format($total_rankA_func/$unit_veh,2)?></td>
    <td><?= number_format(($total_rankA_func/$unit_veh)/$count_m_pdate,2) ?></td>
    <td style="text-align:center;">D/U APP</td>
  </tr>
  <tr>
    <td style="text-align:center;"><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="12" heigth="12" /> A</td>
   <?php 

      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $rankA_App = $tot_veh = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_veh = $l->NUM_VEH;
			 $num_dfct = $l->NUM_DFCT;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal)){                               
                $tot_veh += $num_veh ;
            }
			
			if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal) && ($rank_nm =='Appearance A')){                               
                $rankA_App += $num_dfct ;
            }
            
        endforeach;
		if ($rankA_App/$tot_veh !=''){
        echo number_format(($rankA_App/$tot_veh),2);                          
        }
		else {
		echo '';
		}                                    
     echo "</td>";
      $total_tot_veh += $tot_veh;
     } ?>
    <td><?= number_format($total_rankA_App/$unit_veh,2) ?></td>
    <td><?= number_format(($total_rankA_App/$unit_veh)/$count_m_pdate,2) ?></td>
    <td rowspan="4"><?= number_format(($total_rankA_App+total_rankB_App)/$unit_veh,2) ?></td>
  </tr>
  <tr>
    <td style="text-align:center;"><img src="<?= base_url() ?>assets/style/images/box.gif" width="12" heigth="12" /> B</td>
     <?php 

      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $rankB_func = $tot_veh = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_veh = $l->NUM_VEH;
			 $num_dfct = $l->NUM_DFCT;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal)){                               
                $tot_veh += $num_veh ;
            }
			
			if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal) && ($rank_nm =='Function B')){                               
                $rankB_func += $num_dfct ;
            }
            
        endforeach;
		if ($rankB_func/$tot_veh !=''){
        echo number_format(($rankB_func/$tot_veh),2);                          
        }
		else {
		echo '';
		}                                    
     echo "</td>";
      $total_tot_veh += $tot_veh;
     } ?> 
    <td><?= number_format($total_rankB_func/$unit_veh,2) ?></td>
    <td><?= number_format(($total_rankB_func/$unit_veh)/$count_m_pdate,2) ?></td>
    </tr>
  <tr>
    <td style="text-align:center;"><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="12" heigth="12" /> B</td>
   <?php 

      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $rankB_App = $tot_veh = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_veh = $l->NUM_VEH;
			 $num_dfct = $l->NUM_DFCT;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal)){                               
                $tot_veh += $num_veh ;
            }
			
			 if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal) && ($rank_nm =='Appearance B')){                               
                $rankB_App += $num_dfct ;
            }
            
        endforeach;
		if ($rankB_App/$tot_veh !=''){
        echo number_format(($rankB_App/$tot_veh),2);                          
        }
		else {
		echo '';
		}                                    
     echo "</td>";
      $total_tot_veh += $tot_veh;
     } ?>
    <td><?= number_format($total_rankB_App/$unit_veh,2) ?></td>
    <td><?= number_format(($total_rankB_App/$unit_veh)/$count_m_pdate,2) ?></td>
    </tr>
  <tr style="background-color:#EAEAEA;">
    <td style="text-align:center;">TOTAL</td>
     <?php 

      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $tot_rank = $tot_veh = '';
        //debug_array($list_rank_DU);
        foreach ($list_rank_DU as $l):
           // $dfct_ctg = $l->DFCT_CTG;
            $rank_desc = $l->RANK_DESC;
            $rank_nm = $l->RANK_NM;
            $num_veh = $l->NUM_VEH;
			 $num_dfct = $l->NUM_DFCT;
            $pdate = $l->M_PDATE;
            $fiscal_year = $l->FISCAL_YEAR; 
            
            //echo $pdate.".".$fiscal_year.".".$rank_desc.".".$rank_nm." = ".$num_dfct ."<br/>";
                       
            //rank A func
            if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal)){                               
                $tot_veh += $num_veh ;
            }
			
			 if (($pdate_fiscal == $pdate) && ($fiscal_year == $year_fiscal)){                               
                $tot_rank += $num_dfct ;
            }
            
        endforeach;
		if ($tot_rank/$tot_veh !=''){
        echo number_format(($tot_rank/$tot_veh),2);                          
        }
		else {
		echo '';
		}                                    
     echo "</td>";
      $total_tot_veh += $tot_veh;
     } ?>
    <th><?= number_format(($total_unit_veh/$unit_veh),2) ?></th>
    <th><?= number_format(($total_unit_veh/$unit_veh)/$count_m_pdate,2) ?></th>
    </tr>
</table>
<div style="font-weight:bold">C. TREND D/U  </div>

                   
<table width="98%" class="data2" border="1" cellpadding="0" cellspacing="0" style="text-align:center; margin:10px;">
  <tr style="background-color:#EAEAEA;">
    <th>MONTH</th>
   <?php foreach ($bulan_fiscal as $l): ?>
    <th><?= $l ?></th>
    <?php endforeach ?>
  </tr>
  
  <tr>
    <th>ASSEMBLY</th>
   
     <?php 
        $bulankurangsatu;
      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

      $rankB_A_Func_du = $rankB_A_App_du = $rankA_A_Func_du = $rankA_A_App_du = $ta_du = '-';
        //debug_array($list_rank_DU);
        foreach ($list_rank_du as $l):
                     $rank_nm = $l->RANK_NM;
                     $rank_desc = $l->RANK_DESC;
                     $nilai = $l->DU_MDL_CTG_RANK_MONTHLY;
                     $dfct_ctg = $l->DFCT_CTG;
                     $pdate = date("n",strtotime($l->PDATE));
                     $fiscal_year = date("Y",strtotime($l->FISCAL_YEAR));
                     
                      //rank Assembly 
                      if($rank_nm =='Appearance A' && $dfct_ctg =='A' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {  $rankA_A_App_du += $nilai;}
            
                       if($rank_nm =='Function A' && $dfct_ctg =='A' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      { $rankA_A_Func_du += $nilai;}                   
                       
                        if($rank_nm =='Appearance B' && $dfct_ctg =='A' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      { $rankB_A_App_du += $nilai;}
                                            
                        if($rank_nm =='Function B' && $dfct_ctg =='A' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      { $rankB_A_Func_du += $nilai;}
                        
                        
                        endforeach;
           // echo $rankA_P_App_du.".".$rankA_P_Func_du.".".$rankB_P_App_du.".".$rankB_P_Func_du." = ".$num_dfct ."<br/>";
           foreach ($total_unit_month2 as $r):
                $fiscal_year2 = date("Y",strtotime($r->FISCAL_YEAR));
                $pdate2 = $r->PDATE;
                
        if (($pdate_fiscal == $pdate2) && ($fiscal_year2 == $year_fiscal)){
                $total_num_veh = $r->TOTAL_NUM_VEH;
                $total_num_veh;   
            $ta_du = number_format((($rankA_A_App_du)+($rankA_A_Func_du)+($rankB_A_App_du)+($rankB_A_Func_du))/$total_num_veh,2);
             }     
            
                                         
                
            
        endforeach;
        
        
        echo $nilai_ta_du = $ta_du;  
                    
                                            
     echo "</td>";
     
     } ?>  
  </tr>
  <tr>
    <th>PAINTING</th>
     <?php 
    
      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

      $rankA_P_App_du = $rankA_P_Func_du = $rankB_P_App_du = $rankB_P_Func_du = $tp_du = '-';
        //debug_array($list_rank_DU);
       foreach ($list_rank_du as $l):     
                     $rank_nm = $l->RANK_NM;
                     $rank_desc = $l->RANK_DESC;
                     $nilai = $l->DU_MDL_CTG_RANK_MONTHLY;
                     $dfct_ctg = $l->DFCT_CTG;
                     $pdate = date("n",strtotime($l->PDATE));
                     $fiscal_year = date("Y",strtotime($l->FISCAL_YEAR)); 
                     
                      //rank Painting 
                      if($rank_nm =='Appearance A' && $dfct_ctg =='P' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankA_P_App_du += $nilai;}
                                           
                       if($rank_nm =='Function A' && $dfct_ctg =='P' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankA_P_Func_du += $nilai;}
                                            
                        if($rank_nm =='Appearance B' && $dfct_ctg =='P' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankB_P_App_du += $nilai;}
                                             
                        if($rank_nm =='Function B' && $dfct_ctg =='P' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankB_P_Func_du += $nilai;}
            
           // echo $rankA_P_App_du.".".$rankA_P_Func_du.".".$rankB_P_App_du.".".$rankB_P_Func_du." = ".$num_dfct ."<br/>";
                     endforeach;
           // echo $rankA_P_App_du.".".$rankA_P_Func_du.".".$rankB_P_App_du.".".$rankB_P_Func_du." = ".$num_dfct ."<br/>";
           foreach ($total_unit_month2 as $r):
                $fiscal_year2 = date("Y",strtotime($r->FISCAL_YEAR));
                $pdate2 = $r->PDATE;
                
        if (($pdate_fiscal == $pdate2) && ($fiscal_year2 == $year_fiscal)){
                $total_num_veh = $r->TOTAL_NUM_VEH;
                $total_num_veh;   
             $tp_du = number_format((($rankA_P_App_du)+($rankA_P_Func_du)+($rankB_P_App_du)+($rankB_P_Func_du))/$total_num_veh,2);
             }         
            
                                         
                
            
          
        endforeach;
        echo $nilai_tp_du = $tp_du;                          
                                            
     echo "</td>";
     
     } ?> 
   
  </tr>
  <tr>
    <th>DRIVING</th>
      <?php 
    
      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

      $rankA_D_App_du = $rankA_D_Func_du = $rankB_D_App_du = $rankB_D_Func_du = $td_du = '-';
        //debug_array($list_rank_DU);
      foreach ($list_rank_du as $l):  
                     $pdate_fiscal;   
                     $rank_nm = $l->RANK_NM;
                     $rank_desc = $l->RANK_DESC;
                     $nilai = $l->DU_MDL_CTG_RANK_MONTHLY;
                     $dfct_ctg = $l->DFCT_CTG;
                     $pdate = date("n",strtotime($l->PDATE));
                     $fiscal_year = date("Y",strtotime($l->FISCAL_YEAR)); 
                     
                       //rank Driving
                      if($rank_nm =='Appearance A' && $dfct_ctg =='D' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankA_D_App_du += $nilai;}
                                           
                       if($rank_nm =='Function A' && $dfct_ctg =='D' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankA_D_Func_du += $nilai;}
                      
                        if($rank_nm =='Appearance B' && $dfct_ctg =='D' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankB_D_App_du += $nilai;}
                                            
                        if($rank_nm =='Function B' && $dfct_ctg =='D' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankB_D_Func_du += $nilai;}
            
           // echo $rankA_P_App_du.".".$rankA_P_Func_du.".".$rankB_P_App_du.".".$rankB_P_Func_du." = ".$num_dfct ."<br/>";
                      endforeach;
           // echo $rankA_P_App_du.".".$rankA_P_Func_du.".".$rankB_P_App_du.".".$rankB_P_Func_du." = ".$num_dfct ."<br/>";
           foreach ($total_unit_month2 as $r):
                $fiscal_year2 = date("Y",strtotime($r->FISCAL_YEAR));
                $pdate2 = $r->PDATE;
                
        if (($pdate_fiscal == $pdate2) && ($fiscal_year2 == $year_fiscal)){
                $total_num_veh = $r->TOTAL_NUM_VEH;
                $total_num_veh;   
            $td_du = number_format((($rankA_D_App_du)+($rankA_D_Func_du)+($rankB_D_App_du)+($rankB_D_Func_du))/$total_num_veh,2);
             }              
            
                                        
                  
            
          
        endforeach;
        echo $nilai_td_du = $td_du;                          
                                          
     echo "</td>";
     
     } ?> 
  
  </tr>
  <tr style="background-color:#EAEAEA;">
  <td>&nbsp;</td>
    
   <?php 
      $bulankurangsatu;
      for ($i = 0; $i <= 11; $i++){ 
      $pdate_fiscal = date("n", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      $year_fiscal = date("Y", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));
      ?>

      <?php
     echo "<td>"; 
        
       // echo $pdate_fiscal.".".$year_fiscal."<br>";

        $total_du_rank = '-';
        //debug_array($list_rank_DU);
        foreach ($list_rank_du as $l):
                     $rank_nm = $l->RANK_NM;
                     $rank_desc = $l->RANK_DESC;
                     $nilai = $l->DU_MDL_CTG_RANK_MONTHLY;
                     $dfct_ctg = $l->DFCT_CTG;
                     $pdate = date("n",strtotime($l->PDATE));
                     $fiscal_year = date("Y",strtotime($l->FISCAL_YEAR));
                     
                      //rank Assembly 
                      if($rank_nm =='Appearance A' && $dfct_ctg =='A' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {  $rankA_A_App_du += $nilai;}
            
                       if($rank_nm =='Function A' && $dfct_ctg =='A' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      { $rankA_A_Func_du += $nilai;}                   
                       
                        if($rank_nm =='Appearance B' && $dfct_ctg =='A' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      { $rankB_A_App_du += $nilai;}
                                            
                        if($rank_nm =='Function B' && $dfct_ctg =='A' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      { $rankB_A_Func_du += $nilai;}
                      
                      //rank Painting 
                      if($rank_nm =='Appearance A' && $dfct_ctg =='P' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankA_P_App_du += $nilai;}
                                           
                       if($rank_nm =='Function A' && $dfct_ctg =='P' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankA_P_Func_du += $nilai;}
                                            
                        if($rank_nm =='Appearance B' && $dfct_ctg =='P' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankB_P_App_du += $nilai;}
                                             
                        if($rank_nm =='Function B' && $dfct_ctg =='P' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankB_P_Func_du += $nilai;}
                      
                       //rank Driving
                      if($rank_nm =='Appearance A' && $dfct_ctg =='D' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankA_D_App_du += $nilai;}
                                           
                       if($rank_nm =='Function A' && $dfct_ctg =='D' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankA_D_Func_du += $nilai;}
                      
                        if($rank_nm =='Appearance B' && $dfct_ctg =='D' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankB_D_App_du += $nilai;}
                                            
                        if($rank_nm =='Function B' && $dfct_ctg =='D' && $pdate_fiscal == $pdate && $fiscal_year == $year_fiscal)
                      {$rankB_D_Func_du += $nilai;}
                        
                        
                        endforeach;
                        
           // echo $rankA_P_App_du.".".$rankA_P_Func_du.".".$rankB_P_App_du.".".$rankB_P_Func_du." = ".$num_dfct ."<br/>";
           foreach ($total_unit_month2 as $r):
                $fiscal_year2 = date("Y",strtotime($r->FISCAL_YEAR));
                $pdate2 = $r->PDATE;
                
        if (($pdate_fiscal == $pdate2) && ($fiscal_year2 == $year_fiscal)){
                $total_num_veh = $r->TOTAL_NUM_VEH;
                $total_num_veh;   
                $ta_du = number_format((($rankA_A_App_du)+($rankA_A_Func_du)+($rankB_A_App_du)+($rankB_A_Func_du))/$total_num_veh,2);
                $tp_du = number_format((($rankA_P_App_du)+($rankA_P_Func_du)+($rankB_P_App_du)+($rankB_P_Func_du))/$total_num_veh,2);
                $td_du = number_format((($rankA_D_App_du)+($rankA_D_Func_du)+($rankB_D_App_du)+($rankB_D_Func_du))/$total_num_veh,2);
                echo $total_du_rank = number_format(($ta_du+$tp_du+$td_du),2);
             }     
            
                                         
                
            
        endforeach;   
                                                          
     echo "</td>";
     
     } ?>     
    
  </tr>
</table>
<div style="font-weight:bold">C. TREND BY DEFECT CATEGORY</div>

<div style="font-weight:bold; margin-left:10px; margin-top:5px;">1. ASSEMBLY</div>
<table width="98%" class="data2" border="1" cellpadding="0" cellspacing="0" style="text-align:center; margin-left:10px;">
  <tr style="background-color:#EAEAEA;">
    <th colspan="2" width="70%">CATEGORY</th>
    <th>TOTAL</th>
    <th>D/U</th>
  </tr>
    
  <?php 
   $model;
   $bulankurangsatu;  
  
                         //   $cek = " ";
                         
                            foreach ($cate_a as $l):  
                         //   $hsl = $l->CTG_NM;  
                         //  echo $cek." = ".$hsl ."//";                    
                         //   if($cek == $hsl)
                         //   { }
                         //   else
                          //  {$cek = $hsl;
                               
  
   $sqa_pdate = $l->SQA_PDATE;
   $description = $l->DESCRIPTION;
   
  ?>

  <tr>
    <td width="20%" ><?= substr($l->CTG_GRP_NM,0,3) ?></td>
    <td style="text-align: left; margin-left: 10px;"><?= $l->CTG_NM ?></td>
    
    <td>
    <?php if($description == $model && $sqa_pdate == $bulankurangsatu){
      echo $l->JML;
      $total_du_a += $l->JML; 
    } ?></td>
     
    <td>&nbsp;</td>
    
  </tr>
  <?php  endforeach ?>
  
  
  <tr>
    <td colspan="2" style="text-align:center">TOTAL</td>
    <td><?= $total_du_a ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<div style="font-weight:bold; margin-left:10px;">2. PAINTING</div>
<table width="98%" class="data2" border="1" cellpadding="0" cellspacing="0" style="text-align:center; margin-left:10px;">
  <tr style="background-color:#EAEAEA;">
    <th colspan="3" width="70%">CATEGORY</th>
    <th>TOTAL</th>
    <th>D/U</th>
  </tr>
  
  <?php 
   $model;
   $bulankurangsatu;  
  
                           // $cek = " ";
                            foreach ($cate_p as $l):  
                           // $hsl = $l->CTG_NM;  
                         //  echo $cek." = ".$hsl ."//";                    
                           // if($cek == $hsl)
                          //  { }
                          //  else
                          //  {$cek = $hsl;
                               
  
   $sqa_pdate = $l->SQA_PDATE;
   $description = $l->DESCRIPTION;
   
  ?>
 
  
  <tr>
    <td width="5%"><?= substr($l->CTG_GRP_NM,0,2) ?></td>
    <td width="20%"><?= substr($l->CTG_GRP_NM,2,50) ?></td>
    <td style="text-align: left;"><?= $l->CTG_NM ?></td>
    <td> <?php if($description == $model && $sqa_pdate == $bulankurangsatu){
      echo $l->JML; 
      $total_du_p += $l->JML;
    } 
    
    ?></td>
    <td>&nbsp;</td>
    
    <?php   endforeach ?>
  </tr>
 <tr>
    <td colspan="3" style="text-align:center">TOTAL</td>
    <td><?= $total_du_p ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<div style="font-weight:bold; margin-left:10px; margin-top:5px;">3. DRIVING</div>
<table width="98%" class="data2" border="1" cellpadding="0" cellspacing="0" style="text-align:center; margin-left:10px;">
  <tr style="background-color:#EAEAEA;">
    <th width="70%">CATEGORY</th>
    <th>TOTAL</th>
    <th>D/U</th>
  </tr>
   <?php 
   $model;
   $bulankurangsatu;  
  
                          //  $cek = " ";
                            foreach ($cate_d as $l):  
                          //  $hsl = $l->CTG_NM;  
                         //  echo $cek." = ".$hsl ."//";                    
                          //  if($cek == $hsl)
                          //  { }
                          //  else
                          //  {$cek = $hsl;
                               
  
   $sqa_pdate = $l->SQA_PDATE;
   $description = $l->DESCRIPTION;
   
  ?>
  
  <tr>
    <td style="text-align:center">
      <?= $l->CTG_GRP_NM ?> - <?= $l->CTG_NM ?></td>
     
    
    <td><?php if($description == $model && $sqa_pdate == '$bulankurangsatu'){
      echo $l->JML; 
      $total_du_d += $l->JML;
    } ?></td>
    
    <td> </td>
    
  </tr>

  <?php  endforeach ?>
  
 
  <tr>
    <td style="text-align:center">TOTAL</td>
    <td><?= $total_du_d ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<div style="font-weight:bold; margin-top:5px">D. DEFECT DISTRIBUTION / RESPONSIBLE SHOP</div>

<table width="50%" class="data2" border="1" cellpadding="0" cellspacing="0" style="text-align:center; margin:10px;">

  <tr style="background-color:#EAEAEA;">
    <th>NO.</th>
    <th>SHOP</th>
    <th>DEFECT</th>
    <th>%</th>
  </tr>
 <?php 
   $h=1;      
   foreach ($list_defect as $l):   
   $defect += $l->NUM_DFCT;
   $persen = ($l->NUM_DFCT/$sum_defect)*100;
   $total_persen += $persen; 
   ?> 
  <tr>
   
    <td width="5%"><?= $h++; ?>.</td>
    <td style="text-align:center"><?= $l->SHOP_NM ?></td>
    <td style="text-align:center"><?= $l->NUM_DFCT ?></td>
    <td><?= number_format($persen,2) ?></td>  
  </tr>
  <?php  endforeach ?>
  <tr>
    <td colspan="2" style="text-align:center">TOTAL</td>
    <td><?= $sum_defect ?></td>
    <td><?= number_format($total_persen,2) ?></td>
  </tr>

</table>        
                </div>
  
          </section>
        </div>


    </div></div></div></div>
    
   <div align="center" style="margin-bottom: 20px;"> 
    <button style="width: 200px; height: 40px; font-weight: bold; font-size: 15px;" class="button button-blue " id="monthly_print" type="button" onclick='monthly_print()'>PRINT</button>
    </div>