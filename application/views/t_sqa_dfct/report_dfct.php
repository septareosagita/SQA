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
            //$shop_defect = $ii->SHOP_ID;
        } 
    endforeach;
?>
<input type="hidden" value="<?=$doc_att_sqpr;?>" id="doc_att_sqpr"/>
<input type="hidden" value="<?=$check_pdate;?>" id="check_pdate"/>
<input type="hidden" value="<?=$app_pdate;?>" id="approve_pdate"/>
<input type="hidden" value="<?=$sqpr_num;?>" id="sqpr_num"/>
<input type="hidden" value="<?=$close_flg;?>" id="close_flg"/>
<input type="hidden" value="<?=$is_deleted;?>" id="is_deleted"/>
<input type="hidden" value="<?=(isset($vinno)) ? $vinno : '';?>" id="vinno"/>
<input type="hidden" value="<?=$problem_id;?>" id="problem_id"/>
<input type="hidden" value="<?=$reply_pdate;?>" id="prdt_pdate"/>
<input type="hidden" value="1" id="nilai_i"/>
<input type="hidden" value="<?=$shop_nm;?>" id="shop_nm"/>
<input type="hidden" value="<?=$shop_defect;?>" id="shop_defect"/>
<input type="hidden" value="<?=$insp_item;?>" id="item_flg"/>
<input type="hidden" value="<?=$grpid;?>" id="grpid"/>

<input type="hidden" value="<?=$approve_pdate_sqareply_ot;?>" id="approve_pdate_sqareply_ot"/>
<input type="hidden" value="<?=$approve_pdate_sqareply_of;?>" id="approve_pdate_sqareply_of"/>
<input type="hidden" value="<?=$approve_pdate_sqareply_rt;?>" id="approve_pdate_sqareply_rt"/>
<input type="hidden" value="<?=$approve_pdate_sqareply_rf;?>" id="approve_pdate_sqareply_rf"/>

<script type="text/javascript">
    $(function() {
        $(".view_detail").fancybox({
            'width'         : '80%',
            'height'        : '95%',
            'autoScale'     : false,
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic',
            'type'          : 'iframe'
        });
    });
    
     $(function() {
        $(".att_sqpr").fancybox({
            'width'         : '80%',
            'height'        : '95%',
            'autoScale'     : false,
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic',
            'type'          : 'iframe',
            onClosed        : function(){
                location.reload();
            }
        });
    });
    
    function on_move_dfct() {
        var c = confirm('Are You Sure Want to Move This Defect to Nowhere ?');
        if (c) {
            var button_id = ["checked", "unchecked","approve","unapprove",
             "ps_closed","reply","print","unsqpr","att_sqpr","sqpr","download","move_dfct"]; 
            disabled_button(button_id,'disable');
            $('#move_dfct').attr('value', 'Please Wait. Now moving defect...');
            $.post('<?=site_url('t_sqa_dfct/move_dfct')?>',{problem_id: '<?=$problem_id?>'},function(html){
                alert('Defect Already Moved, Page Will Now Redirecting!');
                <?php if ($this->uri->segment(4)=='m'): ?>
                // back to monitoring
                window.location = '<?=site_url('inquiry/browse')?>';
                <?php else: ?>
                // back to audit registration
                window.location = '<?=site_url('t_sqa_dfct')?>';
                <?php endif; ?>
            });
        }
    }
    
    function on_close_report() {
        <?php if ($this->uri->segment(4) == 'm'): ?>
        window.location='<?= site_url('inquiry/browse/'.$this->uri->segment(3).'/'.$this->uri->segment(5)) ?>'
        <?php else: ?>
        window.location='<?= site_url('t_sqa_dfct/change/'.$this->uri->segment(3)) ?>'
        <?php endif; ?>
    }

    function printt(dl) {
        <?php $uri4 = ($this->uri->segment(4) != '') ? $this->uri->segment(4) : 'r'; ?>
        var problem_id =$('#problem_id').val();
        if (dl == '') {
            window.open('<?= site_url('t_sqa_dfct/report_sqa/' . $problem_id. '/'.$uri4.'/'.'1') ?>','printer')
        } else {
            window.open('<?= site_url('t_sqa_dfct/report_sqa/' . $problem_id. '/'.$uri4.'/'.'1/dl') ?>','printer1')
        }    
    }

    function pdf_dl() {
        var problem_id =$('#problem_id').val();
        window.open('<?= site_url('t_sqa_dfct/pdf_reply/' . $problem_id. '/') ?>','printer')
    }

    function fchecked() {
    	var check_pdate =  $('#check_pdate').val();
    	var approve_pdate =  $('#approve_pdate').val();
    	var vinno = $('#vinno').val();
    	var problem_id =$('#problem_id').val();
    	var prdt_pdate =$('#prdt_pdate').val();
    	
    	var cek_checked =confirm("Are you sure already Check this problem ?");
		if (cek_checked){
		  
			if(check_pdate!='')	{
			     alert("Problem sheet already CHECKED status");
			} else if(approve_pdate !=''){
			     alert("Related users must be Unapprove status problem sheet");
			} else { // update
				$.post('<?= site_url('inquiry/cek') ?>',
					{
						vinno : vinno,
						problem_id : problem_id,
						prdt_pdate  : prdt_pdate
					},
					function(html){
                        if(html !=''){
                            alert (html);
                            
                        } 
                        location.reload();    							
					}
			    );
			 }
		}
        
    }

    function funchecked() {
    	var check_pdate =  $('#check_pdate').val();
    	var approve_pdate =  $('#approve_pdate').val();
    	var vinno = $('#vinno').val();
    	var problem_id =$('#problem_id').val();
    	var prdt_pdate =$('#prdt_pdate').val();
	
        var cek_checked =confirm("Are you sure to Uncheck this problem ? ");
		if (cek_checked) {
			if(approve_pdate !=''){
    			alert("Related users must be Unapprove status problem sheet Status");
			} else { // update
				$.post('<?= site_url('inquiry/Uncek') ?>',
						{
    						vinno : vinno,
    						problem_id : problem_id						
						},
						function(html) {
                            if(html !=''){
                                alert (html);
                            }							 							 
							location.reload();
						}
					 );
			}
		}
    }

    /*APPROVE & UNAPPROVE */
    function approved(){
        var check_pdate = $('#check_pdate').val();
        var shop_nm = $('#shop_nm').val();
        if (shop_nm =='Chosagoumi'){
            alert ('DEFECT Chosagoumi !')
            return false;
        }
    	var cek_checked =confirm("Are you sure to Approved this problem ?");
    	if (cek_checked){
    	   if(check_pdate !='') {
                approved2();
           } else {
                alert('Related users must be checked status problem sheet');
           }		
    	}
    }

    // fungsi untuk APPROVED status SQA
    function approved2(problem_id,check_pdate,shop_nm){    
        var problem_id = $('#problem_id').val();    	
        $.post('<?= site_url('inquiry/approved') ?>',{problem_id: problem_id},function(html) { 
            if(html !=''){
                alert (html);
            } 
    		location.reload();
        });
    }
	
	// fungsi untuk UNAPPROVED status SQA
    function unapproved(){
        var problem_id = $('#problem_id').val();
		var approve_pdate =  $('#approve_pdate').val();
		var approve_pdate_sqareply_ot =$('#approve_pdate_sqareply_ot').val();
		var approve_pdate_sqareply_of =$('#approve_pdate_sqareply_of').val();
		var approve_pdate_sqareply_rt =$('#approve_pdate_sqareply_rt').val();
		var approve_pdate_sqareply_rf =$('#approve_pdate_sqareply_rf').val();

        var cek = confirm('Are you sure to Cancel Approved this problem ? ');
        if(cek){
			if(approve_pdate_sqareply_ot !='' || approve_pdate_sqareply_of !='' || approve_pdate_sqareply_rt !='' || approve_pdate_sqareply_rf !='') {
                alert('Related Users Must be Unapprove status Reply Comment or Problem Sheet already CLOSED or DELETED Status');
        	} else {
				$.post('<?= site_url('inquiry/Unapproved') ?>', {problem_id: problem_id},function(html){ 
                    if(html !=''){
                        alert (html);
                    }
                    location.reload();
                });
        	}
        }
    }

    /* END APPROVE & UNAPPROVE*/

    /* SQPR & UNSQPR */
    function setSQPR(){
        var problem_id = $('#problem_id').val();
        var approve_pdate = $('#approve_pdate').val();

        if (approve_pdate =='') {
            alert ('! Defect status must be approve First');
        } else {
            $.post('<?= site_url('inquiry/setSQPR') ?>',{problem_id: problem_id},function(html){
                if(html !=''){
                    alert (html);
                }
                location.reload();
            });
        }
    }

    function SQPRcanc(){
        var problem_id = $('#problem_id').val();
        $.post('<?= site_url('inquiry/SQPRcanc') ?>', {problem_id: problem_id}, function(html) { 
            if(html !=''){
                alert (html);
            }
            location.reload();
        });
    }
    /* END SQPR & UNSQPR*/

    /*PSCLOSED */
    function PSclosed(problem_id,approve_pdate){
        var problem_id = $('#problem_id').val();
        var approve_pdate = $('#approve_pdate').val();
		
		var approve_pdate_sqareply_ot =$('#approve_pdate_sqareply_ot').val();
		var approve_pdate_sqareply_of =$('#approve_pdate_sqareply_of').val();
		var approve_pdate_sqareply_rt =$('#approve_pdate_sqareply_rt').val();
		var approve_pdate_sqareply_rf =$('#approve_pdate_sqareply_rf').val();
		
		var cek = confirm('Are you sure to Closed this problem ? ');
        if(cek){
			if(approve_pdate ==''){
                alert ('Related Users Must be Approved status ');
			} else {
				if(approve_pdate_sqareply_ot =='' || approve_pdate_sqareply_of =='' || approve_pdate_sqareply_rt =='' || approve_pdate_sqareply_rf =='') {
				    alert('Related Users Must be Unapprove status Reply Comment or Problem Sheet already CLOSED or DELETED Status');
				} else { 
				    $.post('<?= site_url('inquiry/PSclosed') ?>',{problem_id: problem_id},function(html){ 
                        if(html !=''){
    					   alert (html);
                        } 
    					location.reload();
                    });
                }
			}
		}
	
	}
    /* ENDPSCLOSED */

    function loadawal(){
        var doc_att_sqpr =  $('#doc_att_sqpr').val();
        var check_pdate =  $('#check_pdate').val();
        var approve_pdate =  $('#approve_pdate').val();
        var sqpr_num =  $('#sqpr_num').val();
        var close_flg =  $('#close_flg').val();
        var is_deleted =  $('#is_deleted').val();
        var shop_nm = $('#shop_nm').val();
        var item_flg = $('#item_flg').val();
        var grpid = $('#grpid').val();
        
        var approve_pdate_sqareply_ot =$('#approve_pdate_sqareply_ot').val();
        var approve_pdate_sqareply_of =$('#approve_pdate_sqareply_of').val();
        var approve_pdate_sqareply_rt =$('#approve_pdate_sqareply_rt').val();
        var approve_pdate_sqareply_rf =$('#approve_pdate_sqareply_rf').val();
        
        $('#att_sqpr').attr("disabled","disabled");
        $('#sqpr').attr("disabled","disabled");
        
        if (close_flg =='1' || is_deleted =='1') {
            
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
    		} else {
    			$('#unchecked').hide();
    			$('#checked').show();
    		}	
    		
    		if(approve_pdate !='') {
        		$('#approve').hide();
        		$('#unapprove').show();
        	} else {
    			$('#approve').show();
    			$('#unapprove').hide();
    		}
    
    		if(sqpr_num!='') {
        		$('#unsqpr').show();
        		$('#sqpr').hide();
    		} else {
    			$('#sqpr').show();
    			$('#unsqpr').hide();
    		}
            
    	} else {            
    	   
            if (grpid =='05' || grpid =='09' || grpid == '08') {
    			$('#checked').removeAttr('disabled');
                $('#unchecked').removeAttr('disabled');                
            } else {
                $('#checked').attr("disabled","disabled");
                $('#unchecked').attr("disabled","disabled");                
            }
                
            if (grpid =='06' || grpid =='09' || grpid == '08') {
    			$('#approve').removeAttr('disabled');
                $('#unapprove').removeAttr('disabled');
                $('#att_sqpr').removeAttr('disabled');
            } else {
                $('#approve').attr("disabled","disabled");
                $('#unapprove').attr("disabled","disabled");
            }
            
            var shop_id = '<?=get_user_info($this, 'SHOP_ID')?>';   
            var shop_nm = '<?=$shop_nm?>';
            var shop_defect = '<?=$shop_defect?>';// shop_nm.substring(0,1);
            var insp_item = '<?=$insp_item?>';
    
            if (grpid =='09' || grpid == '08') {
                $('#reply').removeAttr('disabled');
                $('#print').removeAttr('disabled');
                $('#download').removeAttr('disabled');                
            } 
                            
            if ((grpid =='01' || grpid =='02' || grpid =='03' || grpid =='04' || grpid =='05' || grpid =='06' || grpid =='07') 
                && 
                (shop_id == shop_defect || (shop_id =='IN' && insp_item =='1'))) {
                 $('#reply').removeAttr('disabled');
            } else {                
                $('#reply').attr("disabled","disabled");
            }
            
            if (grpid =='07' || grpid =='09' || grpid == '08') {
                
                $('#att_sqpr').removeAttr('disabled');   
                if(doc_att_sqpr !=''){
                   $('#sqpr').removeAttr('disabled');  
                }
                
            } else {
               
                $('#sqpr').attr("disabled","disabled");
              //  $('#att_sqpr').attr("disabled","disabled");
                $('#unsqpr').attr("disabled","disabled");
            }
                
            $('#unsqpr').removeAttr('disabled');
            
    		if(check_pdate !='') {    		  
    			
                $('#unchecked').show();
                if(grpid =='06' || grpid =='09' || grpid == '08') {
        			$('#approve').removeAttr('disabled');
                    
                }
               
                // yg boleh ps_closed hanya SQA SH (06) dan SQA LH/GH (05) juga admin
                if (grpid == '06' || grpid == '05' || grpid == '09' || grpid == '08') {
                    $('#ps_closed').removeAttr('disabled');                                            
                }
                
                $('#unsqpr').removeAttr('disabled');
    			$('#checked').hide();
                
    		} else {
    			$('#unchecked').hide();
    			$('#checked').show();
    			$('#approve').attr("disabled","disabled");	
    		}
    			
    		if (approve_pdate !='') {
    			$('#approve').hide();
    			$('#unapprove').show(); 
                
                   
                if(grpid =='09' || grpid == '08') {
                    $('#reply').removeAttr('disabled');
                }
       
                // yg boleh ps_closed hanya SQA SH (06) dan SQA LH/GH (05) juga admin
                if (grpid == '06' || grpid == '05' || grpid == '09' || grpid == '08') {
                    $('#ps_closed').removeAttr("disabled")                    
                } else {
                    $('#ps_closed').attr("disabled","disabled");
                }
                	
    		} else {
    			$('#approve').show();
    			$('#unapprove').hide();
                if(grpid =='01' || grpid =='09' || grpid == '08') {
                    $('#reply').attr("disabled","disabled");
                }
    			$('#ps_closed').attr("disabled","disabled");	
    			$('#sqpr').attr("disabled","disabled");	
                $('#att_sqpr').attr("disabled","disabled");		
    		}
    	
    		if(sqpr_num!='') {
                $('#unsqpr').show();
    			$('#sqpr').hide();
                
    			// yg boleh ps_closed hanya SQA SH (06) dan SQA LH/GH (05) juga admin
                if (grpid == '06' || grpid == '05' || grpid == '09' || grpid == '08') {
                    $('#ps_closed').removeAttr('disabled');
                }
    		} else {
    			$('#sqpr').show();
    			$('#unsqpr').hide();
    			$('#ps_closed').attr("disabled","disabled");	
    		}
            
    		if(item_flg!='0') {
                // inspection item, cek ot of rt rf approve_pdate nya
                if (
                    approve_pdate_sqareply_ot != '' && approve_pdate_sqareply_of != '' &&
                    approve_pdate_sqareply_rt != '' && approve_pdate_sqareply_rf != ''
                    ) {
                    
                    // yg boleh ps_closed hanya SQA SH (06) dan SQA LH/GH (05) juga admin
                    if (grpid == '06' || grpid == '05' || grpid == '09' || grpid == '08') {
                        $('#ps_closed').removeAttr('disabled');
                    }
                            
                } else {
                    $('#ps_closed').attr("disabled", "disabled");
                }
                  
    			/*if(approve_pdate_sqareply_rf !=''){
                    if(grpid =='06') {
                        $('#ps_closed').attr("disabled","disabled");
                    } else{
                        $('#ps_closed').removeAttr('disabled');
                    }
                } else {
                    if(approve_pdate_sqareply_rf !='' && approve_pdate_sqareply_of !=''){
                        if(grpid =='06') {
                            $('#ps_closed').attr("disabled","disabled");
                        } else{
                            $('#ps_closed').removeAttr('disabled');
                        }          
                    }
    			}*/
                
    		} else {    		      
                // bukan inspection item, cek hanya rt & rf approve_pdatenya saja
                if (approve_pdate_sqareply_rt != '' && approve_pdate_sqareply_rf != '') {
                    // yg boleh ps_closed hanya SQA SH (06) dan SQA LH/GH (05) juga admin
                    if (grpid == '06' || grpid == '05' || grpid == '09' || grpid == '08') {
                        $('#ps_closed').removeAttr('disabled');
                    }
                } else {                    
                    $('#ps_closed').attr("disabled","disabled");
                }
    		}
            
            // cek Tombol Moved --> untuk SQA LH/GH 2, SQA Administrator & IS Administrator
            
            if (grpid =='11' || grpid =='09' || grpid == '08') {
    			$('#move_dfct_panel').show();                                
            } else {
                $('#move_dfct_panel').hide();
            }
            
    	}
    }
</script>

<div class="widget">
    <header><h2 style="text-align: center;">SQA PROBLEM SHEET</h2></header>
    <section>
    <table width="100%" border="0" style="padding-left: 10px; margin-top: -10px;">        
        <tr>
            <td colspan="9">&nbsp;</td>
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
            <td colspan="4"><?= $sqa_shiftgrpnm;?></td>
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
            <td colspan="3" style="text-align: left;" nowrap="nowrap">                
                <table style="border: 1px solid #CCCCCC;" width="98%">
                    <tr>
                        <td height="230" style="text-align: center; vertical-align: middle;">&nbsp;<br />                        
                            <?php if (file_exists(PATH_IMG.$main_img)): ?>
                            &nbsp;
                            <a id="single_image" href="<? echo PATH_IMG_URL.$main_img;?>">
                            <img src="<? echo PATH_IMG_URL.$main_img;?>" width="250" height="180" alt="Can't Load" />
                            </a>
                            <?php endif; ?>
                            <br />Main Image
                        </td>
                        <td style="text-align: center; vertical-align: middle">&nbsp;<br />
                            <?php if (file_exists(PATH_IMG.$part_img)): ?>
                            &nbsp;
                            <a id="single_image" href="<? echo PATH_IMG_URL.$part_img;?>">
                            <img src="<? echo PATH_IMG_URL.$part_img;?>" width="250" height="180" alt="Can't Load"  />
                            </a>
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
						<td width="1%">:</td>
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
                        <!-- update by Ipan 20111214 1239 -->
                        <td colspan="3">(<?= $description; ?>)</td>
                    </tr>
                    <tr>
                        <td>Inspection Date</td>
                        <td>:</td>
                        <td colspan="4">
						<?php //echo $insp_pdate; ?>
						<?= ($insp_pdate != '')? date('d M Y', strtotime($insp_pdate)) : '-'; ?>
						<?php //echo $insp_pdate;//(($insp_pdate !='')||$insp_pdate !=NULL)? date('d M Y', strtotime($insp_pdate)) : '-'; ?>
						</td>
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
                <div style="font-weight: bold; width: 180px; border: 1px solid #cacaca; background-color: #cacaca; padding: 5px 0 5px 5px;">
                DETAIL PROBLEM 
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="9" width="100%" style="border: 1px solid #cacaca; padding: 5px 0 5px 5px;">
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
            <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="9">
            <div style="font-weight: bold; width: 180px; border: 1px solid #cacaca; background-color: #cacaca; padding: 5px 0 5px 5px;">
                INVESTIGATION RESULT
            </div>
            </td>
        </tr>
        <tr>
            <td colspan="9" width="100%" style="border: 1px solid #cacaca;">
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
                        <td colspan="3" height="80" style="vertical-align: top; border: 1px solid #cacaca; padding: 5px;"><?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->REPLY_SYSDATE!='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td>Approved By:<?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->updatedt!='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
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
                        <td colspan="3" height="80" style="vertical-align: top; border: 1px solid #cacaca; padding: 5px;"><? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->REPLY_SYSDATE !='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td>Approved By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='O' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
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
                        <td colspan="3" height="80" style="vertical-align: top; border: 1px solid #cacaca; padding: 5px;"><? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->REPLY_SYSDATE !='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td>Approved By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->APPROVE_SYSDATE !='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='T' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
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
                        <td colspan="3" height="80" style="vertical-align: top; border: 1px solid #cacaca; padding: 5px;"><? foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F') { echo $ii->REPLY_COMMENT;} endforeach;?></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Created By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->REPLY_SYSDATE!='') { echo $ii->REPLY_USERID.' - '.date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));} endforeach;?></td>
                        <td>Approved By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->APPROVE_SYSDATE!='') { echo $ii->APPROVED_BY.' - '.date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));} endforeach;?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3">Last Edited By: <?php foreach($list_reply as $ii): if ($ii->REPLY_TYPE=='R' && $ii->COUNTERMEASURE_TYPE=='F' && $ii->updatedt !='') { echo $ii->Updateby.' - '.date('d/m/Y h:i A', strtotime($ii->updatedt));} endforeach;?></td>
                    </tr>
                    
                </table>
                <br />
            </td>            
        </tr>        
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center;">
                <input class="button button-gray" type="button" name="checked" id="checked" value=" Checked " onclick="fchecked()" />
                <input class="button button-gray" type="button" name="checked2" id="unchecked" value="Unhecked" onclick="funchecked()"/>
                <input class="button button-gray" type="button" name="approved" id="approve" value="   Approved   "  onclick="approved()"/>
                <input class="button button-gray" type="button" name="approved2" id="unapprove" value="Cancel Approved"  onclick="unapproved()"/>
                <input class="button button-gray" type="button" name="ps_closed" id="ps_closed" value="P/S Closed" onclick="PSclosed()"/>
                <input class="button button-gray" type="button" name="reply" id="reply" value="Reply" onclick="window.location='<?= site_url('t_sqa_dfct/reply_sqa/' . $problem_id . '/' . $this->uri->segment(4) . '/'. $frame_no) ?>'"/>
                <input class="button button-gray" type="button" name="print" id="print" value="Print" onclick="printt('')"/>
                <input class="button button-gray" type="button" name="sqprc" id="unsqpr" value="Cancel SQPR" onclick="SQPRcanc()" />
                <a href="<?=site_url('t_sqa_dfct/att_sqpr')?>" class="att_sqpr">
                <input class="button button-gray" type="button" name="att_sqpr" id="att_sqpr" value=" Attach SQPR " onclick="att_sqpr()"/>
                </a>
                <input class="button button-gray" type="button" name="sqprc2" id="sqpr" value=" Set SQPR " onclick="setSQPR()"/>
                <input class="button button-gray" type="button" name="download" id="download" value="Download Sheet" onclick="printt('dl')" />
                <input class="button button-gray" type="button" name="close" id="close" value=" Close " onclick="on_close_report()"/>
            </td>
        </tr>
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>
        <tr id="move_dfct_panel">
            <td colspan="9" style="text-align: center;">
                <input class="button button-orange" type="button" name="move_dfct" id="move_dfct" value="&mdash; Move This Defect To Nowhere &mdash;" onclick="on_move_dfct()"/>
            </td>
        </tr>        
        <tr>
            <td colspan="9" style="font-weight: bold;">ATTACHMENT</td>
        </tr>
        <tr>
            <td colspan="9">
                <table class="data" width="100%">
                    <tr>
                        <th>SQA Problem Sheet</th>
                        <th>Temp.Out Flow</th>
                        <th>Fix Out Flow</th>
                        <th>Temporary Countermeasure<br />(Responsible Occure)</th>
                        <th>Fix Countermeasure<br />(Responsible Occure)</th>
                    </tr>
                    <tr>
                        <td style="text-align: left;"><?php foreach($list_sqa as $ii):?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($ii->ATTACH_NAME.';'.PATH_ATTCH . $ii->ATTACH_DOC)))?>"><? echo $ii->ATTACH_NAME."</a><br>"; endforeach;?></td>
                        <td style="text-align: left;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='O' AND $i->COUNTERMEASURE_TYPE=='T'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                        <td style="text-align: left;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='O' AND $i->COUNTERMEASURE_TYPE=='F'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                        <td style="text-align: left;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='R' AND $i->COUNTERMEASURE_TYPE=='T'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                        <td style="text-align: left;"><?php foreach($list_rep_att as $i): if($i->REPLY_TYPE=='R' AND $i->COUNTERMEASURE_TYPE=='F'){ ?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($i->ATTACH_NAME.';'.PATH_ATTCH . $i->ATTACH_DOC)))?>"><? echo $i->ATTACH_NAME."</a><br>";} endforeach; ?></td>
                    </tr>
                </table>
            </td>
        </tr> 
        <tr>
            <td colspan="9">
                <table class="data" width="100%">
                    <tr>
                        <th>Attachment SQPR</th>
                       
                    </tr>
                    <tr>
                        <td style="text-align: left;"><?php foreach($list_att_sqpr as $ii):?><a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($ii->SQPR_NAME.';'.PATH_ATTCH . $ii->SQPR_DOC)))?>"><? echo $ii->SQPR_NAME."</a><br>"; endforeach;?></td>
                    </tr>
                </table>
            </td>
        </tr>    
    </table>
    </section>
</div>


<script type="text/javascript">
    $(function(){
        loadawal();                
    });
</script>