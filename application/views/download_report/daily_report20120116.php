
<script type="text/javascript" src="<?php echo base_url();?>assets/public/javascript/FusionCharts.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/highcharts.src.js"></script>

<script type="text/javascript">
function daily_report_print(){
    // window.print();
    var cek = confirm('Are your sure want to print ?');    
    if(cek){                                                            
    var report_url = '<?=site_url('download_report_print/daily_report')?>' + '/' + '<?= $this->uri->segment(3) ?>' + '/' + '<?= $this->uri->segment(4) ?>';
        window.open(report_url);
    }
}

</script>
                      
<div class="wrapper" align="center">
<div class="columns" align="center">
     <div id="current_report">
    <div class="column grid_8 first" width="100%">  
    <div align="right" style="font-weight: bold;"><?= date('F d, Y', strtotime($date_daily_report)) ?></div>   
        <div class="judul" style=" border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">
            <span>DAILY TENDENCY OF SHIPPING QUALITY AUDIT</span><br />
            <span style="text-decoration: none;"> <?= $model ?> MODEL<span>        </div>

        <div class="widgetentri">

                
            <section>

                <!--start middlecontent -->
                <div id="middlecontent">

               
<!------------------------------------------------------daily 1-------------------------------------------->               
        <div id="daily_1">
        <div class="daily_1_left">  
                <div class="title" align="left"> I. DAILY TENDENCY</div> <hr />      
               
               <div id="daily_1a2">
                <?= $daily_2 ?>
               </div>
        </div>
        <div id="daily_1_rigth">
        
               <div class="title" align="left">II. DISTRIBUTED PROBLEM</div><hr />
                <div id="daily_1b">
                         <?= $daily_3 ?>
                </div>
               <div class="title" align="left" style="font-size:12px;">III. DAILY RESULT ON <?= date('F d, Y', strtotime($date_daily_report)) ?></div> 
               <div class="daily_1c">
                     <table width="100%"class="data2" style="font-size: 8px;">
                      <tr>
                        <th width="50" rowspan="2">&nbsp;</th>
                        <th width="70" rowspan="2">TOTAL UNIT</th>
                        <th colspan="2">RANK A</th>
                        <th colspan="2">RANK B</th>
                        <th width="50" rowspan="2">TOTAL D/U</th> 
                      </tr>
                      
                      <tr>
                        <td width="20"><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="12" heigth="12" /></td>
                        <td width="20"><img src="<?= base_url() ?>assets/style/images/box.gif" width="12" heigth="12" /></td>
                        <td width="20"><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="12" heigth="12" /></td>
                        <td width="20"><img src="<?= base_url() ?>assets/style/images/box.gif" width="12" heigth="12" /></td>
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
                      
                        <td>ASSEMBLY</td>
                        <td rowspan="4" style="font-weight: bold; font-size: 20px; color: black;">
                        <?php if($num_veh !=''){
                            echo $num_veh;}
                            else {
                                echo '0';
                            }              
                        ?></td>
                        <td style="font-weight: bold; font-size: 12px; color: black; "><span style="font-weight: bold; font-size: 12px; color: black;">
                          <?php if ($rankA_A_Func !=''){
                            echo $rankA_A_Func; }
                            else {
                                echo '0';
                            }
                         ?>
                        </span></td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php if ($rankA_A_App !=''){
                            echo $rankA_A_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 12px; color: black; "><span style="font-weight: bold; font-size: 12px; color: black;">
                          <?php if ($rankB_A_Func !=''){
                            echo $rankB_A_Func; }
                            else {
                                echo '0';
                            }
                         ?>
                        </span></td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php if ($rankB_A_App !=''){
                            echo $rankB_A_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php 
						$to_a = (($rankA_A_Func + $rankA_A_App + $rankB_A_Func + $rankB_A_App)/$num_veh);
						if ($to_a !=''){
                            echo number_format($to_a,2); }
                            else {
                                echo '0';
                            }
                         ?></td>
                      </tr>
                      <tr>
                        <td>PAINTING</td>
                        <td style="font-weight: bold; font-size: 12px; color: black; background-color: gray;">&nbsp;</td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php if ($rankA_P_App !=''){
                            echo $rankA_P_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 12px; color: black; background-color: gray;">&nbsp;</td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php if ($rankB_P_App !=''){
                            echo $rankB_P_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php 
						$to_p = (($rankA_P_App + $rankB_P_App)/$num_veh);
						if ($to_p !=''){
                            echo number_format($to_p,2); }
                            else {
                                echo '0';
                            }
                         ?></td>
                      </tr>
                      <tr>
                        <td>DRIVING</td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php if ($rankA_D_Func !=''){
                            echo $rankA_D_Func; }
                            else {
                                echo '0';
                            }
                         ?> </td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php if ($rankA_D_App !=''){
                            echo $rankA_D_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php if ($rankB_D_Func !=''){
                            echo $rankB_D_Func; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php if ($rankB_D_App !=''){
                            echo $rankB_D_App; }
                            else {
                                echo '0';
                            }
                         ?></td>
                        <td style="font-weight: bold; font-size: 12px; color: black;"><?php 
						$to_d = (($rankA_D_Func + $rankA_D_App + $rankB_D_Func + $rankB_D_App)/$num_veh);
						if ($to_d !=''){
                            echo number_format($to_d,2); }
                            else {
                                echo '0';
                            }
                         ?></td>
                      </tr>
                      <tr>
                        <th>TOTAL</th>
                        <th style="font-weight: bold; font-size: 12px; color: black;"><?php echo ($rankA_A_Func)+($rankA_D_Func)  ?></th>
                        <th style="font-weight: bold; font-size: 12px; color: black;"><?php echo ($rankA_P_App)+($rankA_A_App)+($rankA_D_App)  ?></th>
                        <th style="font-weight: bold; font-size: 12px; color: black;"><?php echo ($rankB_A_Func)+($rankB_D_Func)  ?></th>
                        <th style="font-weight: bold; font-size: 12px; color: black;"><?php echo ($rankB_P_App)+($rankB_A_App)+($rankB_D_App)  ?></th>
                        <th style="font-weight: bold; font-size: 12px; color: black;"><?php echo number_format(($to_a)+($to_p)+($to_d),2)  ?></th>
                      </tr>
                      <tr>
                        <th>CUM</th>
                        <th style="font-weight: bold;color: black; font-size: 14px;">
                         <?php if ($total_unit !=''){
                          echo  $total_unit;}
                            else{
                                echo '0';
                            }                     
                        ?>                        </th>
                        <th style="font-weight: bold;color: black; font-size: 14px;">
                         <?php if ($rank_montly_A_func !=''){
                            echo $rank_montly_A_func;}
                            else{
                                echo '0';
                            }                     
                        ?>                        </th>
                        <th style="font-weight: bold;color: black; font-size: 14px;">
                         <?php if ($rank_montly_A_app !=''){
                            echo $rank_montly_A_app;}
                            else{
                                echo '0';
                            }                     
                        ?>                        </th>
                        <th style="font-weight: bold;color: black; font-size: 14px;">
                         <?php if ($rank_montly_B_func !=''){
                            echo $rank_montly_B_func;}
                            else{
                                echo '0';
                            }                     
                        ?>                        </th>
                        <th style="font-weight: bold;color: black; font-size: 14px;">
                          <?php if ($rank_montly_B_app !=''){
                            echo $rank_montly_B_app;}
                            else{
                                echo '0';
                            }                     
                        ?>
                                                </th>
                        <th style="font-weight: bold;color: black; font-size: 14px;"><?php 
						$to_du = (($rank_montly_A_func + $rank_montly_A_app + $rank_montly_B_func + $rank_montly_B_app)/$total_unit);
						if ($to_du !=''){
                           echo number_format($to_du,2);}
                            else{
                                echo '0';
                            }                     
                        ?></th>
                      </tr>
                 </table>        
          </div>  
         </div>                      
            </div>
<!------------------------------------------------------End daily 1----------------------------------------> 

<!------------------------------------------------------daily 2-------------------------------------------->               
        <div id="daily_2">
              <div class="title" align="left">IV. PROBLEM SHEET</div> <hr />
              <div id="Prob_sheet" style="width: 60%; height: 270px;">
                <?= $daily_4 ?>
               </div> 
               <div class="Prob_sheet2">
                    <table width="100%" height="102%" class="data2" style="font-size: 9px;">
                    <tr>
                        <th style="vertical-align: middle; text-align: center;">TOTAL</th>                        
                    </tr>
                    <tr>
                        <td height="25" style="vertical-align: middle; text-align: center; font-weight: bold;">SEND</td>                       
                    </tr>
                    <tr>
                        <td style="font-weight: bold; font-size: 20px; color: black;">  <?= ($total_send !='')? $total_send:0 ?></td>                       
                    </tr>
                    <tr>
                        <td height="25" style="vertical-align: middle; text-align: center; font-weight: bold;">REPLY</td>                       
                    </tr>
                    <tr>
                         <td style="font-weight: bold; font-size: 20px; color: black;"><?= ($total_reply !='')? $total_reply:0 ?></td>                        
                    </tr>
                    <tr>
                        <td height="45" style="vertical-align: middle; text-align: center; font-weight: bold;">P/S<br />
                      NOT YET REPLY</td>                       
                    </tr>
                    </table>
               </div>
              
               <div id="Prob_sheet3" style="width: 31%; height: 200px;">
                    <?= $daily_5 ?>
               </div> 
                              
               
              <img style="float:left; margin-top: 20px;" src="<?= base_url() ?>assets/style/images/panah.gif" width="25" heigth="40" /> 
               <div class="Prob_sheet3a">                    
                              
                   <table width="90%" height="100%" class="data2" style="font-size:9px;">
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
                             <td height="30%" width="15%" style="vertical-align: middle; text-align: center; ">
                             <?= $t->SHOP_NM ?>
                             </td>
                       <?php } endforeach; ?>
                       
                   </tr>                                 
                   <tr>   <?php 
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
                            IF(($CEK==$hsl || $CEK==$hsl2) )
                            { }
                            ELSE
                            {$CEK=$hsl;
                                $i++;?> 
                                   
                        <td style="font-weight: bold; font-size: 14px; color: black;">
                        <?php 
                         
                                 if ($t->NUM_PS_MONTHLY > 0) {
                                    echo $selisih;
                                   }
                                   else {
                                       echo '0'; 
                                    }
                             
                            
                         ?>             
                        </td>
                      <?php } endforeach ?>
                   </tr>                   
                  
				
                  </table>
                  
                                 
          </div>                         
            </div>
<!------------------------------------------------------End daily 2----------------------------------------> 

<!------------------------------------------------------daily 3-------------------------------------------->               
        <div id="daily_3">
        <div class="title" align="left">V. PROBLEM FOLLOW UP ON <?= date('F, Y', strtotime(get_date())) ?> 
        <hr /><div style="float: left; font-size: 12px;">Note : 
        &nbsp; &nbsp;
        X = Problem Sheet Release
        &nbsp; &nbsp;
        <img src="<?= base_url() ?>assets/style/images/yellow.gif" width="13" heigth="13" /> = Not Yet Reply Approve 
        &nbsp; &nbsp;
        <img src="<?= base_url() ?>assets/style/images/white.gif" width="13" heigth="13" /> = Problem Sheet Due Date
        &nbsp; &nbsp;
        <img src="<?= base_url() ?>assets/style/images/box.gif" width="13" heigth="13" /> = Appearance
         &nbsp; &nbsp;
        <img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="13" heigth="13" /> = Function
        &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
          Remark : &nbsp; &nbsp;
        <img src="<?= base_url() ?>assets/style/images/blank.gif" width="13" heigth="13" /> = Not Yet Answered
        &nbsp; &nbsp;
      
        <img src="<?= base_url() ?>assets/style/images/black.gif" width="13" heigth="13" /> = fix C/Measure
        </div></div>
               <div class="daily_3a">
                   <table width="100%" class="data2" style="font-size:8px; font-weight: bold;">
                    <tr>
                    
                      <th width="15" rowspan="2">No.</th>
                      <th width="250" rowspan="2">Item Problem <?= $model ?></th>
                      <th width="40" rowspan="2">Rank</th>
                      <th width="23" rowspan="2">INSP</th>
                      <th width="13" rowspan="2">QUALITY GATE</th>
                      <th width="30" rowspan="2">Repair Hist</th>
                      <th width="29" rowspan="2">PROD SHIFT</th>        
                      <th width="29" rowspan="2">INSP SHIFT</th>
                      <th colspan="<?= $sparator ?>"><?= $kurangbulan = date("F y", mktime(0,0,0,date("m")-1,date("d"),date("Y"))); ?></th>
                      <th colspan="<?= $sparator2 ?>"><?= date("F y"); ?></th>
                      <th width="29" rowspan="2">Respon</th>
                      <th width="29" rowspan="2">PROD</th>
                      <th width="29" rowspan="2">INSP</th>
                      <th width="29" rowspan="2">Status</th>
                     </tr>
                    <tr>
                    <?php foreach ($list_tanggal as $r): ?>
                        <th width="13"><?= $r ?></th>
                      <?php endforeach; ?>
                     </tr>
                     
                     <?php 
                            $cek = " ";
                            $i = 0;
                            $h = 1;
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
                        <td>
                            
                        
                         <?= $h; ?>.</td>
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
                            $timestamp2 = strtotime("-".$tgl." day");
                        $minusfiveweek2 = date("d-m-Y",$timestamp2);
                        $tanggal_daily2 = strtotime($minusfiveweek2);
                        $fiveweeks = strtotime('+1 day' , $tanggal_daily2);
                        $now = date("Y-m-d",$fiveweeks);
                        $tanggal[] = date('d', strtotime($now));
                        $tgl = 35-$i;
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
            <?php foreach ($t_sqa_du_summary_mdl as $l):
            $fiscal_year = $l->FISCAL_YEAR;
            $num_veh = $l->NUM_VEH;
            $num_dfct = $l->NUM_DFCT;
            
            
            
            endforeach ?> 
            <div class="daily_4a">
                    <table width="100%" class="data2" style="font-size:11px; margin: auto;">
                    <tr>
                      <th width="20%" rowspan="2">TOTAL ZERO DEFECT DAY <?= date('F', strtotime(get_date())) ?> : <?= ($zero_dfct_day_num !='')? $zero_dfct_day_num: 0; ?> DAYS<br />
                      TOTAL WORKING DAY ON <?= date('F', strtotime(get_date())) ?> : <?=$total_working_day ?> DAYS</th>
                      <th width="25%" rowspan="4">COUNTINOUS &quot;0&quot; DEFECT DAY :  <?= ($count_zero_dfct_day_num !='')? $count_zero_dfct_day_num: 0; ?> DAYS</th>
                        <th colspan="2">CUM. F/YEAR <?=$fiscal?></th>
                      </tr>
                    <tr>
                      <th>TOTAL UNIT</th>
                      <th><?= ($total_unit_month !='')? $total_unit_month: 0; ?></th>
                    </tr>
                    <tr>
                      <th rowspan="2">PAST RECORD DAY (<?= ($total_defect !='')? date('F Y', strtotime($rec_zero_dfct_month_year)) : '-'; ?>) 
					  : <?= ($rec_zero_dfct_day_num !='')? $rec_zero_dfct_day_num: 0; ?> DAYS</th>
                      <th>DEFECT</th>
                      <th><?= ($total_defect !='')? $total_defect: 0; ?></th>
                    </tr>
                    <tr>
                      <th width="15%">DEFECT / UNIT</th>
                      <th width="15%"><?= number_format(($total_defect/$total_unit_month),2) ?></th>
                      </tr>
                 </table>                  
            </div>
            <div class="daily_5">
            
                 <table width="100%" height="100%" class="data2" style="font-size:10px; margin: auto;">
                    <tr>
                        <th width="15%">TOTAL CHECK INSPECTION</th>
                        <td width="5%" style="color: black; font-weight: bold;"><?= ($total_inspection_item!='')? $total_inspection_item : 0 ; ?></td>
                        <th width="15%" align="center">REPAIR HISTORY</th>
                        <td width="5%" style="color: black; font-weight: bold;"><?= ($total_repair_flag!='')? $total_repair_flag : 0 ; ?></td>
                        <th width="15%" rowspan="2" align="center">PROD SHIFT</th>
                        <th width="5%">RED</th>
                        <td width="5%" style="color: black; font-weight: bold;"><?= ($total_prod_shift_red!='')? $total_prod_shift_red : 0 ; ?></td>
                        <td width="5%" style="color: black; font-weight: bold;"><?= $persentase_prod_shift_red ?>%</td>
                        <th width="15%" rowspan="2">INSP SHIFT</th>
                        <th width="5%">RED</th>
                        <td width="5%" style="color: black; font-weight: bold;"><?= ($total_insp_shift_red!='')? $total_insp_shift_red : 0 ; ?></td>
                        <td width="5%" style="color: black; font-weight: bold;"><?= number_format($persentase_insp_shift_red,2) ?>%</td>
                   </tr>
                    <tr>
                        <th>PERCENTAGE (%)</th>
                        <td style="color: black; font-weight: bold;"><?= $persentase_insp_item ?>%</td>
                        <th align="center">PERCENTAGE (%)</th>
                        <td style="color: black; font-weight: bold;"><?=$persentase_reply_hist?>%</td>
                        <th>WHITE</th>
                        <td width="5%" style="color: black; font-weight: bold;"><?= ($total_insp_prod_white!='')? $total_insp_prod_white : 0 ; ?></td>
                        <td style="color: black; font-weight: bold;"><?= $persentase_prod_shift_white ?>%</td>
                        <th>WHITE</th>
                        <td width="5%" style="color: black; font-weight: bold;"><?= ($total_insp_shift_white!='')? $total_insp_shift_white : 0 ; ?></td>
                        <td style="color: black; font-weight: bold;"><?= number_format($persentase_insp_shift_white,2) ?>%</td>
                    </tr>
                 </table>                     
            </div>
           
<!------------------------------------------------------End daily 4----------------------------------------> 

</div></div></div></div></div></div>
<div align="center" style="margin-bottom: 20px;"> 
    <button style="width: 200px; height: 40px; font-weight: bold; font-size: 15px;" class="button button-blue " id="result_search_print" type="button" onclick='daily_report_print()'>PRINT</button>
    </div>
  