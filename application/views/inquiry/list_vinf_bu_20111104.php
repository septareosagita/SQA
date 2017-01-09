<script type="text/javascript">
   
    //FUNGSI MASSAGE BOX
<?php if ($err != ''): ?>
                $(function(){
                    msg_err('<?= $err ?>');
                });

<?php endif; ?>

    </script>
    
    
   
    	<input type="hidden" name="condition" id="condition" value="<?= $condition ?>">
        <input type="hidden" name="param" id="param" value="<?= $param ?>">        
       
            <table id="demoTable" class="data" width="250%">
               
                     <tr style="background:#dadada;">
                        <th width="2%" align="center">No</th>
                        <!--th colspan="4" align="center"><div align="center">Status P/S</div></th--!>
                        <th width="2%" style="vertical-align:middle; text-align: center">Outflow <br>Temp</th>
                        <th width="2%" style="vertical-align:middle; text-align: center">Outflow <br>Fix</th>
                        <th width="2%" style="vertical-align:middle; text-align: center">Problem <br>Temp</th>
                        <th width="2%" style="vertical-align:middle; text-align: center">Problem <br>Fix</th>
                        <th width="3%"  style="vertical-align:middle; text-align: center">Responsible</th>
                        <th width="4%"  style="vertical-align:middle; text-align: center">Model</th>
                        <th width="3%"  style="vertical-align:middle; text-align: center">Body No</th>
                        <th width="7%"  style="vertical-align:middle; text-align: center">Frame No</th>
                        <th width="4%"  style="vertical-align:middle; text-align: center">Rank</th>
                        <th width="10%"  style="vertical-align:middle; text-align: center">Defect</th> 
                        <th width="9%"  style="vertical-align:middle; text-align: center">Category</th>                      
                        <th width="3%"  style="vertical-align:middle; text-align: center">SQA<br />Shift</th>
						<th width="3%"  style="vertical-align:middle; text-align: center">Prod<br />Shift</th>
						<th width="3%"  style="vertical-align:middle; text-align: center">Insp<br />Shift</th> 
						 
                        <th width="2%"  style="vertical-align:middle; text-align: center">Color</th>
                        <th width="11%"  style="vertical-align:middle; text-align: center">Problem Sheet No</th>
                        <th width="12%"  style="vertical-align:middle; text-align: center">SQPR No</th>
                        <th width="6%"  style="vertical-align:middle; text-align: center">SQA Date</th>
                        <th width="7%"  style="vertical-align:middle; text-align: center">SQA OUT</th>                   
                        <th width="5%"  style="vertical-align:middle; text-align: center">Auditor1</th>
                        <th width="5%"  style="vertical-align:middle; text-align: center">Auditor2</th>
                        <th width="1%"  style="vertical-align:middle; text-align: center">Status<br/>SQA</th>
                        <th width="1%"  style="vertical-align:middle; text-align: center">Status<br/>Show</th>
                    </tr>
                    <!--tr style="background:#dadada;">
                        <th colspan="2" style="vertical-align:middle; text-align: center">Out Flow</th>
                        <th colspan="2" style="vertical-align:middle; text-align: center">Problem</th>
                    </tr>
                    <tr style="background:#dadada;">
                        <th width="2%" style="vertical-align:middle; text-align: center">Temp</th>
                        <th width="2%" style="vertical-align:middle; text-align: center">Fix</th>
                        <th width="2%" style="vertical-align:middle; text-align: center">Temp</th>
                        <th width="2%" style="vertical-align:middle; text-align: center">Fix</th>
                    </tr--!>
             

            <?php
            if ($list_v_sqa_dfct): $i = 1;
                foreach ($list_v_sqa_dfct as $l):

                    $c = ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"";
                    if ($l->PROBLEM_ID == '$problem_id') {
                        $c = "class=\"active\"";
                    }

                    // keluarkan data reply
                    $img_ot = $img_of = $img_rt = $img_rf = '';
                    $ot_date = $of_date = $rt_date = $rf_date = '';

                    if (isset($list_dfct_reply[$l->PROBLEM_ID])) {
                        $rep = $list_dfct_reply[$l->PROBLEM_ID];
                        
                        
                        foreach ($rep as $r) {
                        $srt_due_date = date("Y-m-d",strtotime($r->DUE_DATE));
                        $srt_approve = date("Y-m-d",strtotime($r->APPROVE_SYSDATE));
                     
                        $due_date = explode('-', $srt_due_date);
                        $due_date2 = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
                        
                        $approve_sysdate = explode('-', $srt_approve);
                        $approve_sysdate2 = $explode[2] . "-" . $explode[1] . "-" . $explode[0];

                            if ($r->REPLY_TYPE == 'O' && $r->COUNTERMEASURE_TYPE == 'T') {  // jika OT
                            $reply_id_ot = $r->PROBLEM_REPLY_ID;
                            $approve_pdate_sqareply_ot = $r->APPROVE_PDATE;
                             $reply = $r->REPLY_SYSDATE;
                            $approve = $r->APPROVE_SYSDATE;
                            
                                $due_date_ot = $r->DUE_DATE;
              
                                 if ($reply == '') {
                                    $img_ot = 'status_sqa_blank.gif';
                                   } else if ($approve =='' && $reply != '') {
                                    $img_ot = 'nr.gif';    
                                } else if ($approve_sysdate > $due_date) {
                                    $img_ot = 'delay.gif';
                                } else if ($approve_sysdate <= $due_date) {
                                    $img_ot = 'status_sqa_approve.gif';
                                }    
                                
                                $ot_date = $approve_pdate_sqareply_ot;                          
                            } else if ($r->REPLY_TYPE == 'O' && $r->COUNTERMEASURE_TYPE == 'F') { // JIKA OF
                                // cek jika sudah di komentari dan cek duedate nya
                                $reply_id_of = $r->PROBLEM_REPLY_ID;
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
                                 $reply_id_rt = $r->PROBLEM_REPLY_ID;
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
                                 $reply_id_rf = $r->PROBLEM_REPLY_ID;
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
                    
                     $user = get_user_info($this, 'GRPAUTH_ID');
                    
                    
                    ?>
                    
                    

                      
                        <input type="hidden" id="SHOW_FLG<?= $l->PROBLEM_ID ?>" value="<?= $l->SHOW_FLG ?>" />                    
                        <input type="hidden" id="APPROVE_PDATE<?= $l->PROBLEM_ID ?>" value="<?= $l->APPROVE_PDATE ?>" />
                        <input type="hidden" id="REG_IN<?= $l->PROBLEM_ID ?>" value="<?= $l->REG_IN ?>" />
                        <input type="hidden" id="CHECK_PDATE<?= $l->PROBLEM_ID ?>" value="<?= $l->CHECK_PDATE ?>" />
                        <input type="hidden" id="SQPR_NUM<?= $l->PROBLEM_ID ?>" value="<?= $l->SQPR_NUM ?>" />
                        <input type="hidden" id="DESCRIPTION<?= $l->PROBLEM_ID ?>" value="<?= $l->DESCRIPTION ?>" />
                        <input type="hidden" id="SHOP_NM<?= $l->PROBLEM_ID ?>" value="<?= $l->SHOP_NM ?>" />
                        <input type="hidden" id="BODYNO<?= $l->PROBLEM_ID ?>" value="<?= $l->BODYNO ?>" />
                        <input type="hidden" id="INSP_ITEM_FLG<?= $l->PROBLEM_ID ?>" value="<?= $l->INSP_ITEM_FLG ?>" />
                        <input type="hidden" id="ot_date<?= $l->PROBLEM_ID ?>" value="<?= $ot_date ?>" />
                        <input type="hidden" id="of_date<?= $l->PROBLEM_ID ?>" value="<?= $of_date ?>" />
                        <input type="hidden" id="rt_date<?= $l->PROBLEM_ID ?>" value="<?= $rt_date ?>" />
                        <input type="hidden" id="rf_date<?= $l->PROBLEM_ID ?>" value="<?= $rf_date ?>" />
                        <input type="hidden" id="user<?= $l->PROBLEM_ID ?>" value="<?= $user ?>" />
						<input type="hidden" id="user<?= $l->PROBLEM_ID ?>" value="<?= $l->DFCT?>" />
                    
                         <tr <?= $c ?> id="dfct_<?= $l->PROBLEM_ID ?>" value="<?= $l->PROBLEM_ID ?>"
                                      onclick="on_check('<?= $l->PROBLEM_ID ?>',
                                          '<?= $l->SHOW_FLG ?>',
                                  '<?= $l->APPROVE_PDATE ?>',
                                  '<?= $l->REG_IN ?>',
                                  '<?= $l->CHECK_PDATE ?>',
                                  '<?= $l->SQPR_NUM ?>',
                                  '<?= $l->DESCRIPTION ?>',
                                  '<?= $l->SHOP_NM ?>',
                                  '<?= $l->BODYNO ?>',
                                  '<?= $l->INSP_ITEM_FLG ?>',
                                  '<?= $ot_date ?>',
                                  '<?= $of_date ?>',
                                  '<?= $rt_date ?>',
                                  '<?= $rf_date ?>',
                                  '<?= $user ?>',
								  '<?= $l->DFCT ?>',
                                  '<?= $l->SHOP_ID?>');" style="cursor:pointer;">
                              <td align="center" style="text-align: center;"><?= $i; ?>.</td>
                              <td style="vertical-align:middle; text-align: center">
                              <span class=tool><?=$img_ot?><span class="tip">DUE DATE <br /><?= date('d-M-y', strtotime($due_date_ot)) ?></span></span>                              
                              </td>
                               <td style="vertical-align:middle; text-align: center">
                                <span class=tool><?=$img_of?><span class="tip">DUE DATE  <br /><?= date('d-M-y', strtotime($due_date_of)) ?></span></span>  
                              </td>
                              <td style="vertical-align:middle; text-align: center">
                               <span class=tool><?=$img_rt?><span class="tip">DUE DATE  <br /><?= date('d-M-y', strtotime($due_date_rt)) ?></span></span>  
                              </td>
                              <td style="vertical-align:middle; text-align: center">
                               <span class=tool><?=$img_rf?><span class="tip">DUE DATE  <br /><?= date('d-M-y', strtotime($due_date_rf)) ?></span></span>  
                              </td>
                              <td style="vertical-align:middle; text-align: center"><? if ($l->SHOP_NM ==''){
                                echo '-'; }
                                else {
                                   echo $l->SHOP_NM; 
                                }
                               ?></td>
                              <td style="vertical-align:middle; text-align: center"><?= $l->DESCRIPTION ?></td>
                              <td style="vertical-align:middle; text-align: center"><?= $l->BODYNO ?></td>
                                <td style="vertical-align:middle; text-align: center">
                              <?= ($l->DFCT !='' && $l->PROBLEM_ID != '')? 
                              '<a href="'. site_url('t_sqa_dfct/report_sqa/'.$l->PROBLEM_ID.'/m/') .'"><label style="color:red;cursor: pointer;"> '.$l->VINNO.'</label>
                                  </a>'
                                 : $l->VINNO ?>
                              </td> 
                              
							<td style="vertical-align:middle; text-align: center">
                            <? if ($l->RANK_NM2 ==''){
                                echo '-'; }
                                else {
                                   echo $l->RANK_NM2; 
                                }
                               ?></td>
                              <td style="vertical-align:middle; text-align: center">
                                <?php 
                                    if ($l->DFCT == 'UNDER SQA CHECK') {
                                        echo '<span style="color:red; font-weight:bold;">UNDER SQA CHECK </span>';    
                                    } else {
								
                                        if ($l->DFCT == '') {
                                           if ($user != '1' && $user != '2' && $user != '3' ){ 
											echo '<span style="color:red; font-weight:bold;">No Defect</span>'; 
											}
										   else {
											echo '<span style="color:red; font-weight:bold;">UNDER SQA CHECK</span>';
										   }
                                        } else {
                                            echo $l->DFCT;
                                        }
                                    }
                                ?>                                                            
                            </td>
                              
                              <td style="vertical-align:middle; text-align: center"><?= $l->CTG_GRP_NM ?></td>
                              <td style="vertical-align:middle; text-align: center">
                              
                              <?php
                                    /** edited: 20110922 - no defect tetap di tampilkan dari ASSY_SHIFTGRPNM nya **/
                                    if ($l->DFCT == '') {
                                               
                                        echo $l->AUDIT_SHIFTGRPNM;
        			
                                    } else {
                                        echo $l->SQA_SHIFTGRPNM;
                                    }
                                ?>                                
                              </td>
							  <td style="vertical-align:middle; text-align: center"><?php 
                              
                              /** edited: 20110922 - menampilkan langsung dari assy_shiftgrpnm nya saja **/
                              /** 
							  if ($l->ASSY_SHIFTGRPNM =='1'){
								  echo 'NON'; }
								   if ($l->ASSY_SHIFTGRPNM =='2'){
								  echo 'RED'; }
								   if ($l->ASSY_SHIFTGRPNM =='3'){
								  echo 'WHITE'; }
                                  
                              **/
                              echo $l->ASSY_SHIFTGRPNM;							  
							  ?>                              
                                                            
                              </td>
							  <td style="vertical-align:middle; text-align: center"><?php  
							  if ($l->INSP_SHIFTGRPNM =='1'){
								  echo 'NON'; }
								   if ($l->INSP_SHIFTGRPNM =='2'){
								  echo 'RED'; }
								   if ($l->INSP_SHIFTGRPNM =='3'){
								  echo 'WHITE'; }							  
							  ?></td>

                              <td style="vertical-align:middle; text-align: center"><?= $l->EXTCLR ?></td>
                              <td style="vertical-align:middle; text-align: center"><?= $l->PRB_SHEET_NUM ?></td>
                              <td style="vertical-align:middle; text-align: center"><?= $l->SQPR_NUM ?></td>
                               <td style="vertical-align:middle; text-align: center"><?= ($l->AUDIT_PDATE !='')? date('d-M-y', strtotime($l->AUDIT_PDATE)). "&nbsp;" . date('H:i:s', strtotime($l->REG_IN)): '-' ?>
                              </td>
                              <td style="vertical-align:middle; text-align: center"><? if($l->REG_OUT !=''){ echo date('d-M-Y H:i:s', strtotime($l->REG_OUT));} ?>
                              </td>

                              <td style="vertical-align:middle; text-align: center"><?= $l->AUDITOR_NM_1 ?></td>
                              <td style="vertical-align:middle; text-align: center"><?= $l->AUDITOR_NM_2 ?></td>
                              <td style="vertical-align:middle; text-align: center">
                                       
                              <span class=tool><?= ($l->REG_IN != '' && $l->CHECK_PDATE == '') ? '<img src="' . base_url(). 'assets/style/images/sqa_blank.gif" width="20" heigth="15"/>' : '' ?><span class="tip">NOT YET <br/>CHECKED</span></span>
                              <span class=tool> <?= ($l->REG_IN != '' && $l->CHECK_PDATE != '' && $l->APPROVE_PDATE == '') ? '<img src="' . base_url(). 'assets/style/images/checked.gif" width="20" heigth="20"/>' : '' ?><span class="tip">CHECKED</span></span>
                              <span class=tool><?= ($l->APPROVE_PDATE != '') ? '<img src="' . base_url(). 'assets/style/images/approved.gif" width="20" heigth="20" />' : '' ?><span class="tip">APPROVE <br/>/ <?= date("d-M-y",strtotime($l->APPROVE_PDATE)) ?></span></span>
                              </td>

                              <td style="vertical-align:middle; text-align: center">      
                             <?= ($l->APPROVE_PDATE != '' && $l->SHOW_FLG == '1') ? ' <span class=tool><img src="' . base_url(). 'assets/style/images/show.gif" width="20" heigth="20"/><span class="tip"> '. $l->DESCRIPTION .' </span></span>  ' : '' ?>
                              </td>
                          </tr>
                <?php
                              $i++;
                          endforeach;
                      else:
                ?>
                          <tr class="row-b">
                              <td colspan="35" style="padding:5px;">Data Is Empty</td>
                          </tr>
                <?php endif; ?>
                     
                  </table>
                    


<script type="text/javascript">    
    $(function(){
        if ($('#problem_id').val()!='') {
            var problem_id = $('#problem_id').val();
            on_check(
                problem_id,
                $('#SHOW_FLG' + problem_id).val(),
                $('#APPROVE_PDATE' + problem_id).val(),
                $('#REG_IN' + problem_id).val(),
                $('#CHECK_PDATE' + problem_id).val(),
                $('#SQPR_NUM' + problem_id).val(),
                $('#DESCRIPTION' + problem_id).val(),
                $('#SHOP_NM' + problem_id).val(),
                $('#BODYNO' + problem_id).val(),
                $('#INSP_ITEM_FLG' + problem_id).val(),
                $('#ot_date' + problem_id).val(),
                $('#of_date' + problem_id).val(),
                $('#rt_date' + problem_id).val(),
                $('#rf_date' + problem_id).val(),
                $('#user' + problem_id).val()                                
            );
        } 
        
        // isi dari search kondisi sesuai searching /session
        $('#SQA_FROM_PDATE').val('<?=date('d-m-Y', strtotime($audit_pdate_1))?>');
        $('#SQA_TO_PDATE').val('<?=date('d-m-Y', strtotime($audit_pdate_2))?>');
        $('#SQA_SHIFTGRPNM').val('<?=$shift_nm_?>');
        $('#SHOP_NM').val('<?=$shop_nm_?>');
        $('#PLANT_NM').val('<?=$plant_nm_?>');
        
    });
    
</script>

<script type="text/javascript">


(function() {
	var mySt = new superTable("demoTable", {
		cssSkin : "sDefault",
		fixedCols : 0,
		headerRows : 1,
		onStart : function () {
			this.start = new Date();
		},
		onFinish : function () {
			document.getElementById("testDiv").innerHTML += "Finished...<br>" + ((new Date()) - this.start) + "ms.<br>";
		}
	});
})();

</script>