<style>
    .fakeContainer { /* The parent container */
        margin: 10px;
        padding: 0px;
        border: none;
        width: auto; /* Required to set */
        height: 320px; /* Required to set */
        overflow: hidden; /* Required to set */
    }
    
    .fakeContainer2 { /* The parent container */
        margin: 10px;
        padding: 0px;
        border: none;
        width: auto; /* Required to set */
        height: 200px; /* Required to set */
        overflow: hidden; /* Required to set */
    }
</style>
<script type="text/javascript">
    $(function() {
        $(".view_detail2").fancybox({
            'width'         : '80%',
            'height'        : '95%',
            'autoScale'     : false,
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic',
            'type'          : 'iframe'
        });
        $('#refval').specialedit([
                                '&diams;',
                                '&plusmn;', 
                                '&lt;',
                                '&gt;',
                                '&le;',
                                '&ge;',
                                '&Oslash;'
                                ]);
    });

    jQuery.fn.extend({
      scrollTo : function(speed, easing) {
        return this.each(function() {
          var targetOffset = $(this).offset().top;
          $('html,body').animate({scrollTop: targetOffset}, speed, easing);
        });
      }
    });

    var t_dfct = 0;
    var super_is_reg_out = true;
    function toggle_dfct() {
        if (t_dfct == 0) {
            var body_no = $('#body_no').val();
            if (body_no != '' /*&& !super_is_reg_out*/) {
                $('#dfct_panel').show();
                //$('#btnDefect').val('- Defect');
                $('#lblDefect').html('- DEFECT');
                $('#widget_dfct').scrollTo(300);
                $('#btnSelectDfct').focus();
                t_dfct = !t_dfct;   
            }
        } else {
            $('#dfct_panel').hide();
            //$('#btnDefect').val('+ Defect');
            $('#lblDefect').html('+ DEFECT');
            t_dfct = !t_dfct;
        }
    }

    function change_ctg_grp(ctg_nm, ctg_dis) {
        
        if ($('#ctg_grp_id').val() != '0') {
			$("#ctg_id_panel").html("<img src='<?= base_url() ?>assets/style/images/loading-gif2.gif' />");
            $.post('<?= site_url('t_sqa_dfct/get_ctg') ?>', {ctg_grp_id:$('#ctg_grp_id').val(), ctg_nm:ctg_nm}, function(html){
                $('#ctg_id_panel').html(html);
                if (ctg_dis == 1) {
                    $('#ctg_nm').attr('disabled', 'disabled');
                }
            });
        }
    }

    function cek_btn_defect(is_reg_out) {        
        var body_no = $('#body_no').val();
        var vinno = $('#vinno').val();
        var auditor_nm_1 = $('#auditor_nm_1').val();
        var auditor_nm_2 = $('#auditor_nm_2').val();

        // jika semuanya ada maka button defect harus aktif
        if (body_no != '' && vinno != '' && auditor_nm_1 != '' && auditor_nm_2 != '' && !is_reg_out) {
            $('#lblDefect').css('color', '#000000');
        } else {
            $('#dfct_panel').hide();
            t_dfct = 0;                        
            $('#lblDefect').html('+ DEFECT');
        }
        super_is_reg_out = is_reg_out;
    }

    function clear_vehicle() {
        $('#body_no').val('');
        $('#vinno').val('');
        $('#suffix').val('');
        $('#bd_seq').val('');
        $('#katashiki').val('');
        $('#assy_seq').val('');
        $('#insp_pdate').val('');
        $('#assy_pdate').val('');
        $('#extclr').val('');
        $('#idno').val('');
        $('#refno').val('');        

        // disabled all button reg
        $('#btnRegIn').attr('disabled', 'disabled');
        $('#btnRegOut').attr('disabled', 'disabled');
        // visible
        $('#btnRegIn').show();
        $('#btnRegOut').show();

        // disabled cancel button
        $('#btnRegInCancel').hide();
        $('#btnRegOutCancel').hide();

        // disabled print/cs
        $('#btnPrintCSRepair').attr('disabled', 'disabled');        
        $('#btnFinishAudit').attr('disabled', 'disabled');
    }

    function get_vehicle(by) {
        var vin_id = (by == 'body_no') ? $('#body_no').val() : $('#vinno').val();        

        $.post('<?= site_url('t_sqa_dfct/get_vinf') ?>',
        {
            by:by,
            vin_id: vin_id
        },
        function(html) {
            var is_reg_out = false;            
            if (html==0){
                
                var bodyno_temp = $('#body_no').val();
                var vinno_temp = $('#vinno').val();
                
                
                if (vin_id != '') {
                    alert('Vehicle Not Found in the Database');
                    $('#body_no').val(bodyno_temp);
                    $('#vinno').val(vinno_temp);    
                } else {
                    clear_vehicle();
                }
                
                $('#'+by).focus();                                
                $('#img_search_1').hide();
                $('#img_search_2').show();
                
                // clear checklist under sqa vin
                get_vinf_under_sqa(0);
            } else {
                // call clear untuk membersihkan defect yg sudah dibuka sebelumnya
                clear_defect();
                
                var vinf = JSON.parse(html);
                suffix = vinf[0];
                bd_seq = vinf[1];
                katashiki = vinf[2];//model code
                assy_seq = vinf[3];
                insp_date = vinf[4];
                assy_pdate = vinf[5];
                extclr = vinf[6];
                vinno = vinf[7];
                bodyno = vinf[8];
                reg_in = vinf[9];
                reg_out = vinf[10];
                idno = vinf[11];
                refno = vinf[12];
                insp_shiftgrpnm = vinf[13];
                assy_shiftgrpnm = vinf[14];
				audit_finish_pdate = vinf[15];
                auditor_nm_1 = vinf[16];
                auditor_nm_2 = vinf[17];

                $('#suffix').val(suffix);
                $('#bd_seq').val(bd_seq);
                $('#katashiki').val(katashiki);
                $('#assy_seq').val(assy_seq);
                $('#insp_pdate').val(insp_date + ' ' + insp_shiftgrpnm);
                $('#assy_pdate').val(assy_pdate + ' ' + assy_shiftgrpnm);
                $('#extclr').val(extclr);
                $('#vinno').val(vinno);
                $('#body_no').val(bodyno);
                $('#idno').val(idno);
                $('#refno').val(refno);

                // If data already Reg In status then [cancel] and [Reg Out] button will enable else [Reg In] button enable
                if (reg_in == '') {                    
                    $('#btnRegIn').removeAttr('disabled');
                    $('#btnRegOut').attr('disabled', 'disabled');
                    
                    // klo masih kosong reg_in nya jgn dulu boleh add defect
                    is_reg_out = true;
                    
                    // enable auditor & stall
                    $('#auditor_nm_2').removeAttr('disabled');
                    $('#stall_no').removeAttr('disabled');
                } else {
                    // sudah terregin
                    $('#btnRegInCancel').show();
                    $('#btnRegIn').hide();

                    $('#btnRegOut').removeAttr('disabled');
                    $('#btnRegOut').show();

                    // berikan checklist
                    get_vinf_under_sqa(bodyno);
                    get_dfct('<?=$problem_id?>');
                    
                    // disabled audiotr & stall
                    $('#auditor_nm_2').attr('disabled','disabled')
                    $('#stall_no').attr('disabled', 'disabled');
                }				

                // If data already Reg Out status
                // then [cancel] button will enable
                // else [Reg Out] and [Cancel Reg In] button enable
                if (reg_out == '') {
                    if (reg_in != '') {
                        $('#btnRegOut').removeAttr('disabled');
                        $('#btnRegOut').show();
                        $('#btnRegOutCancel').hide();
                    }

					// klo blm d regout boleh d fnish
					$('#btnFinishAudit').removeAttr('disabled');
                    $('#btnRegInCancel').removeAttr('disabled');                                        
                } else {
                    $('#btnRegInCancel').attr('disabled', 'disabled');
                    $('#btnRegInCancel').show();
                    $('#btnRegIn').hide();

                    $('#btnRegOutCancel').removeAttr('disabled');
                    $('#btnRegOutCancel').show();
                    $('#btnRegOut').hide();
                    
                    // nggak boleh tambahin defect
                    is_reg_out = true;

					// klo sdh d regout ga boleh finish
					$('#btnFinishAudit').attr('disabled', 'disabled');                    
                }
				
				// cek jika blm finish                
				
                /* Here */
                if (audit_finish_pdate == '') {
					$('#btnRegOut').attr('disabled', 'disabled');					
					$('#btnFinishAudit').removeAttr('disabled');
                    $('#btnAdd').removeAttr('disabled');
                    $('#btnClear').removeAttr('disabled');
                    $('#btnUploadImage').removeAttr('disabled');
                    $('#btnUploadAttch').removeAttr('disabled');
                    $('#btnRegInCancel').removeAttr('disabled');
				} else {				    
					$('#btnRegOut').removeAttr('disabled');
					$('#btnFinishAudit').attr('disabled', 'disabled');
                    $('#btnAdd').attr('disabled', 'disabled');
                    $('#btnClear').attr('disabled', 'disabled');
                    $('#btnUploadImage').attr('disabled', 'disabled');
                    $('#btnUploadAttch').attr('disabled', 'disabled');
                    $('#btnRegInCancel').attr('disabled', 'disabled');
				}
                
                
                // cek jika dia tidak berhak karena bukan auditor ybs nya
                var auditor_login = '<?=$auditor_nm_1?>';
                if (auditor_login == auditor_nm_1 || auditor_login == auditor_nm_2) {
                    // boleh manage defect
                } else {
                    // tdk boleh manage defect
                    $('#btnAdd').attr('disabled', 'disabled');
                    $('#btnClear').attr('disabled', 'disabled');
                    $('#btnUploadImage').attr('disabled', 'disabled');
                    $('#btnUploadAttch').attr('disabled', 'disabled');                    
                }

                // print c/s
                $('#btnPrintCSRepair').removeAttr('disabled');

                // tambahin bodyno untuk si print cs repair                
                var link_prevcs = '<?=site_url('t_sqa_dfct/print_cs')?>' + '/' +  bodyno;
                $('#link_print_cs').attr('href', link_prevcs);
                
                // ganti image search aktif
                $('#img_search_1').show();
                $('#img_search_2').hide();
                // tambahkan link href nya
                var href_vin = '<?=site_url('t_sqa_dfct/vin_history')?>' + '/' + bodyno;
                $('#href_vin_history').attr('href',href_vin);
            }
            // cek btn defect
            cek_btn_defect(is_reg_out);
        });
    }

    function on_reg_in() {
        var body_no = $('#body_no').val();
        var vinno = $('#vinno').val();

        if (body_no != '' && vinno != '') {
            if ($('#stall_no').val() == '0') {
                alert('Please select Available Stall first');
                $('#stall_no').focus();
            } else {
                var cek = confirm('Are you sure to Registration In this vehicle [' + body_no + ' / ' + vinno + '] ?');
                if (cek) {
                    // Update status REG_IN value with now(datetime) at T_SQA_VINF table
                    $.post('<?= site_url('t_sqa_dfct/reg_in') ?>',
                        {
                            bodyno: bodyno,
                            vinno: vinno,
                            auditor1 : $('#auditor_nm_1').val(),
                            auditor2 : $('#auditor_nm_2').val(),
                            stall_no : $('#stall_no').val()
                        },
                        function(html) {
                                                        
                            if (html == '1') {
                                get_vinf_under_sqa(bodyno);
                                // Show all detail information at '"Vehicle" and "Under SQA Check" form based on body or vin no your input
                                // Change "Cancel Reg IN" button caption and enable it
                                $('#btnRegInCancel').removeAttr('disabled');
                                $('#btnRegInCancel').show();
                                $('#btnRegIn').hide();
                                
                                // Change "Reg OUT" button caption and enable it
                                alert('Complete Update Reg In Status');
                                
                                // enablekan tombol add defect, karena sudah di regin
                                cek_btn_defect(false);
                                
                                // ulangi lagi refresh data
                                get_vehicle('body_no');                                                                
                            } else {
                                alert('selected stall already in use by another user. Stall now will be refresh');
                            }
                            
                            // load available stall again
                            load_stall();
                        }
                    );                
                } else {
                    $('#body_no').focus();
                    $('#body_no').select();
                }    
            }                        
        }
    }

    function on_reg_in_cancel() {
        
        //var c = confirm ('Are you sure want to Cancel Audit in This Vehicle ? ');
        //if (c) {
            var body_no = $('#body_no').val();
            var vinno = $('#vinno').val();
    
            if (body_no != '' && vinno != '') {
                var cek = confirm('Are you sure to Cancel Registration In this vehicle [' + body_no + ' / ' + vinno + '] ?');
                if (cek) {
                    // Update status REG_IN value with now(datetime) at T_SQA_VINF table
                    $.post('<?= site_url('t_sqa_dfct/reg_in_cancel') ?>',
                        {
                            bodyno: bodyno
                        },
                        function(html) {
                            get_vinf_under_sqa(0);
                            clear_vehicle();                        
                            $('#body_no').focus();
                            cek_btn_defect(true);
                            get_dfct(0);
                            alert('Complete Cancel Reg In Status');
                            load_stall();
                        }
                    );
                } else {
                    $('#body_no').focus();
                    $('#body_no').select();
                }
            }   
        //}                
    }

    function on_reg_out() {
        var body_no = $('#body_no').val();
        var vinno = $('#vinno').val();

        if (body_no != '' && vinno != '') {
            var cek = confirm('Are your sure to Registration Out this vehicle [' + body_no + ' / ' + vinno + '] ?');
            if (cek) {
                // Update status REG_IN value with now(datetime) at T_SQA_VINF table
                $.post('<?= site_url('t_sqa_dfct/reg_out') ?>',
                    {
                        bodyno: bodyno
                    },
                    function(html) {
                        get_vinf_under_sqa(bodyno);

                        $('#btnRegInCancel').attr('disabled', 'disabled');
                        $('#btnRegInCancel').show();
                        $('#btnRegOut').hide();
                        // Change "Reg OUT" button caption and enable it
                        $('#btnRegOutCancel').removeAttr('disabled');
                        $('#btnRegOutCancel').show();
                        alert('Complete Update Reg Out Status');
                        load_stall();
                    }
                );
            } else {
                $('#body_no').focus();
                $('#body_no').select();
            }
        }
    }

    function on_reg_out_cancel() {
        var body_no = $('#body_no').val();
        var vinno = $('#vinno').val();

        if (body_no != '' && vinno != '') {
            var cek = confirm('Are your sure to Cancel Registration Out this vehicle [' + body_no + ' / ' + vinno + '] ?');
            if (cek) {
                // Update status REG_IN value with now(datetime) at T_SQA_VINF table
                $.post('<?= site_url('t_sqa_dfct/reg_out_cancel') ?>',
                    {
                        bodyno: bodyno
                    },
                    function(html) {
                        get_vinf_under_sqa(bodyno);
                        get_vehicle('body_no');

                        $('#btnRegInCancel').removeAttr('disabled');
                        $('#btnRegInCancel').show();

                        //$('#btnRegOut').removeAttr('disabled');
						$('#btnRegOut').attr('disabled', 'disabled');
                        $('#btnRegOut').show();
                        // Change "Reg OUT" button caption and enable it
                        $('#btnRegOutCancel').hide();

						// finish d buka 
						$('#btnFinishAudit').removeAttr('disabled');

                        alert('Complete Cancel Reg Out Status');
                    }
                );
            } else {
                $('#body_no').focus();
                $('#body_no').select();
            }
        }
    }

    function get_vinf_under_sqa(bodyno) {
        $("#content_vinf").html("<center><img src='<?= base_url() ?>assets/style/images/loading-gif.gif' /><br/><sup>Refreshing list of vehicle under SQA...</sup></center>");
        $.post('<?= site_url('t_sqa_dfct/get_vinf_under_sqa') ?>',
            {
                bodyno: bodyno,
                pg: $('#page').val()
            },
            function(html) {
                $('#content_vinf').html(html);
                new superTable("demoTable", {
               	    cssSkin : "sDefault"                    
                });
            }
        );
    }

    function on_select_dfct() {
        var dfct = $('#dfct').val();
        if (dfct != '') {
            $.post('<?= site_url('t_sqa_dfct/search_dfct') ?>',
                {
                    dfct: dfct
                },
                function(html) {
                    if (html == 0) {
                        alert('Searching your defect data not found in system');
                    } else {

                    }
                }
            );
        }
    }

    function on_add(from_upload) {
        from_upload = (from_upload == null) ? '' : from_upload;
        
        var plant_nm = $('#plant_nm').val();
        var shftgrp_nm = $('#shftgrp_nm').val();
        var idno = $('#idno').val();
        var body_no = $('#body_no').val();
        var refno = $('#refno').val();
        var vinno = $('#vinno').val();

        var problem_id = $('#problem_id').val();
        var dfct_id = $('#dfct_id').val();
        var dfct = $('#dfct').val();
        var rank_nm = $('#rank_nm').val();
        var ctg_grp_id = $('#ctg_grp_id').val();
        // var ctg_nm = $('#<strong>ctg_nm</strong>').val();
		var ctg_nm = $('#ctg_nm').val();
        var shop_nm = $('#shop_nm').val();
        var measurement = $('#measurement').val();
        var refval = $('#refval').val();
        var conf_by_qcd = $('#conf_by_qcd').val();
        var conf_by_related = $('#conf_by_related').val();
        var insp_item_flag = $('#insp_item_flag').val();
        var qlty_gt_item = $('#qlty_gt_item').val();
        var repair_flg = $('#repair_flg').val();
        var auditor_nm_1 = $('#auditor_nm_1').val();
        var auditor_nm_2 = $('#auditor_nm_2').val();

        if (dfct != '' && ctg_nm != '') {
            // send to controller
            $.post('<?= site_url('t_sqa_dfct/add_dfct') ?>',
                {
                    plant_nm: plant_nm,
                    shftgrp_nm: shftgrp_nm,
                    idno: idno,
                    body_no: body_no,
                    refno: refno,
                    vinno: vinno,

                    problem_id: problem_id,
                    dfct_id: dfct_id,
                    dfct: dfct,
                    rank_nm: rank_nm,
                    ctg_grp_id: ctg_grp_id,
                    ctg_nm: ctg_nm,
                    shop_nm: shop_nm,
                    measurement: measurement,
                    refval: refval,
                    conf_by_qcd: conf_by_qcd,
                    conf_by_related: conf_by_related,
                    insp_item_flag: insp_item_flag,
                    qlty_gt_item: qlty_gt_item,
                    repair_flg: repair_flg,
                    auditor_nm_1: auditor_nm_1,
                    auditor_nm_2: auditor_nm_2
                },
                function(html) {
                    if (html == 2) {
                        alert('Update Defect information in Vehicle ['+ body_no +'] successful');
                        clear_defect();
                        get_dfct(0);                        
                    } else if (html != '') {
                        problem_id = html;
                                                
                        if (from_upload == '') {
                            alert('Add Defect information successful');    
                        }
                        clear_defect();
                        
                        $('#problem_id').val(problem_id);
                        get_dfct_by_problem_id();
                        get_dfct(problem_id);
                    }
                }
            );
        } else {
            alert('Please add defect');
        }        
    }

    function clear_defect() {
        <?php if ($this->uri->segment(3) == ''): ?>
        $('#problem_id').val('');
        <?php endif; ?>
        $('#dfct_id').val('');
        $('#dfct_id').removeAttr('disabled');
        $('#dfct').val('');
        $('#rank_nm').removeAttr('disabled');
        $('#ctg_grp_id').val(0);
        $('#ctg_grp_id').removeAttr('disabled');
        $('#shop_nm').val('0');
        $('#measurement').val('');
        $('#refval').val('');
        $('#conf_by_qcd').val('');
        $('#conf_by_related').val('');
        $('#insp_item_flag').val(0);
        $('#insp_item_flag_1').removeAttr('checked');
        $('#insp_item_flag_0').attr('checked', 'checked');
        $('#qlty_gt_item').val(0);
        $('#qlty_gt_item_1').removeAttr('checked');
        $('#qlty_gt_item_0').attr('checked', 'checked');
        $('#repair_flg').val(0);
        $('#repair_flg_1').removeAttr('checked');
        $('#repair_flg_0').attr('checked', 'checked');
        $('#ctg_id_panel').html('<sup>select category group first</sup>');
        $('input[name=checkonlyone_dfct]').removeAttr('checked');
        dfct_button_1();
        get_dfct(0);        
    }

    function get_dfct_val() {
        return $('#dfct').val();
    }

    function pick_dfct(dfct_id) {        
        $.fancybox.close();
        
        $.post('<?= site_url('m_sqa_dfct/get_dfct') ?>',
            {
                dfct_id: dfct_id
            },
            function(html) {
                //$dfct_id, $dfct, $rank_id, $rank_nm, $ctg_grp_id, $ctg_id, $ctg_nm
                var dfct = JSON.parse(html);
                var dfct_id = dfct[0];
                var dfct_nm = dfct[1];
                var rank_id = dfct[2];
                var rank_nm = dfct[3];
                var ctg_grp_id = dfct[4];
                var ctg_id = dfct[5];
                var ctg_nm = dfct[6];

                $('#dfct_id').val(dfct_id);
                //$('#dfct_id').attr('readonly', 'readonly');
                $('#dfct').val(dfct_nm);
                //$('#dfct').attr('readonly', 'readonly');
                $('#rank_nm').val(rank_nm);
                //$('#rank_nm').attr('disabled', 'disabled');
                $('#ctg_grp_id').val(ctg_grp_id);
                $('#ctg_grp_id').attr('disabled', 'disabled');
                change_ctg_grp(ctg_nm,1);
                $('#dfct').focus();
                
                // cek jika problem_id sudah ada, jika blm maka boleh input image  
                var cek = $('#btnAdd').attr('disabled'); 
                if (cek) {
                    $('#btnUploadImage').attr('disabled', 'disabled');
                } else {
                    $('#btnUploadImage').removeAttr('disabled');    
                }
            }
        );
    }

    function get_dfct(problem_id) {        
        $("#content_dfct").html("<center><img src='<?= base_url() ?>assets/style/images/loading-gif.gif' /><br/><sup>Getting list of Defect...</sup></center>");    
        var body_no = $('#body_no').val();
        $.post('<?=site_url('t_sqa_dfct/get_dfct')?>', {body_no: body_no,problem_id: problem_id}, function(html){
            $('#content_dfct').html(html);
            new superTable("demoTable2", {
           	    cssSkin : "sDefault"                    
            });
        });
    }

    function get_dfct_by_problem_id() {
        var problem_id = $('#problem_id').val();

        $.post('<?=site_url('t_sqa_dfct/get_dfct_by_problem_id')?>', {problem_id:problem_id}, function(html){
            if (html == 0) {
                // bersihkan defect
                //clear_defect();
                get_vehicle('body_no');
            } else {                
                $('#dfct_panel').show();                
                t_dfct = 1;

                // get the data from responses JSON
                var dfct_data = JSON.parse(html);
                var problem_id = dfct_data[0];
                var dfct = dfct_data[1];
                var rank_nm = dfct_data[2];
                var ctg_grp_id = dfct_data[3];
                var ctg_nm = dfct_data[4];                
                var measurement = dfct_data[5];
                var refval = dfct_data[6];
                var insp_item_flg = dfct_data[7];
                var qlty_gt_item = dfct_data[8];
                var repair_flg = dfct_data[9];
                var conf_by_qcd = dfct_data[10];
                var conf_by_related = dfct_data[11];
                var shop_nm = dfct_data[12];
                var reg_out = dfct_data[13];
                var audit_finish_pdate = dfct_data[14];
                var approve_sysdate = dfct_data[15];
                var auditor_nm_1 = dfct_data[16];
                var auditor_nm_2 = dfct_data[17];

                // bind it to the component
                $('#dfct').val(dfct);                
                $('#rank_nm').val(rank_nm);
                $('#ctg_grp_id').val(ctg_grp_id);                
                change_ctg_grp(ctg_nm, 1);
                $('#ctg_grp_id').attr('disabled', 'disabled');
                $('#measurement').val(measurement);
                $('#refval').val(refval);
                $('#insp_item_flag').val(insp_item_flg);
                $('#insp_item_flag_' + insp_item_flg).attr('checked', 'checked');
                $('#qlty_gt_item').val(qlty_gt_item)
                $('#qlty_gt_item_' + qlty_gt_item).attr('checked', 'checked');
                $('#repair_flg').val(repair_flg);
                $('#repair_flg_' + repair_flg).attr('checked', 'checked');
                $('#conf_by_qcd').val(conf_by_qcd);
                $('#conf_by_related').val(conf_by_related);
                $('#shop_nm').val(shop_nm);                
                $('#widget_dfct').scrollTo(300);
                $('#lblDefect').html('- DEFECT');
                
                /**
                --- pengecekan tombol 2 approval --
                0. awalnya kondisi button sesuai dfct_button_2 dulu
                1. cek dulu apakah user yg lagi login boleh manage defect ato nggak, 
                    = cek berdasarkan auditor & jika LH/GH (KODE GRPAUTH = 05)
                    -> klo nggak boleh, disable semua.
                    -> klo boleh, lanjut ke pengecekan berikutnya.
                    
                    1.2. cek apakah defect ybs boleh diedit ato nggak
                        -> boleh di edit jika
                            * belum finish, 
                            * belum regout, 
                            * dfct tsb belum d approve
                        -> tdk boleh diedit jika sebaliknya
                */
                dfct_button_2();
                var auditor_login = '<?=$auditor_nm_1?>';
                var auditor_groupauth = '<?=get_user_info($this, 'GRPAUTH_ID')?>';
                if (auditor_login == auditor_nm_1 || auditor_login == auditor_nm_2 || auditor_groupauth == '05') {
                    // boleh manage defect
                    if (
                            (reg_out == null || reg_out == '') &&
                            (approve_sysdate == null || approve_sysdate == '') &&
                            (audit_finish_pdate == null || audit_finish_pdate == '')                            
                        ) {                        
                        // boleh di edit. do nothin, stay with dfct_button_2();
                        
                    } else {
                        // tdk boleh di edit krn memenuhi kondisi diatas
                        $('#btnEdit').attr('disabled', 'disabled');
                        $('#btnDelete').attr('disabled', 'disabled');
                        $('#btnClear').attr('disabled', 'disabled');
                        $('#btnUploadImage').attr('disabled', 'disabled');
                        $('#btnUploadAttch').attr('disabled', 'disabled');
                    }
                } else {
                    // tdk boleh manage defect
                    $('#btnEdit').attr('disabled', 'disabled');
                    $('#btnDelete').attr('disabled', 'disabled');
                    $('#btnClear').attr('disabled', 'disabled');
                    $('#btnUploadImage').attr('disabled', 'disabled');
                    $('#btnUploadAttch').attr('disabled', 'disabled');                    
                }                                
            }
        });
    }

    function on_delete_dfct() {
        var problem_id = $('#problem_id').val();
        if (problem_id != '') {
            var cek = confirm('Are you sure to delete this defect ?');
            if (cek) {
                $.post('<?=site_url('t_sqa_dfct/delete_dfct')?>', {problem_id: problem_id}, function(html){
                    clear_defect();
                    $('#dfct_panel').hide();
                    //$('#btnDefect').val('+ Defect');
                    $('#lblDefect').html('+ DEFECT');
                    t_dfct = 0;
                    get_dfct(0);
                    $('#problem_id').val('0');
                    alert('Delete Defect information Successful');                    
                });
            }
        }
    }

    function dfct_button_1() {
        $('#btnAdd').removeAttr('disabled');
        $('#btnEdit').attr('disabled','disabled');
        $('#btnClear').attr('disabled','disabled');
        $('#btnDelete').attr('disabled','disabled');
        $('#btnUploadImage').attr('disabled','disabled');
        $('#btnPreview').attr('disabled','disabled');
        $('#btnUploadAttch').attr('disabled','disabled');        
    }

    function dfct_button_2() {
        $('#btnAdd').attr('disabled','disabled');
        $('#btnEdit').removeAttr('disabled');
        $('#btnClear').removeAttr('disabled');
        $('#btnDelete').removeAttr('disabled');
        $('#btnUploadImage').removeAttr('disabled');
        $('#btnPreview').removeAttr('disabled');
        $('#btnUploadAttch').removeAttr('disabled');        
    }

    function on_finish_audit() {
        var body_no = $('#body_no').val();
        if (body_no != '') {
            var c = confirm('Are you sure vehicle [' + body_no + '] already finish at SQA Check ?');
            if (c) {
                $.post('<?=site_url('t_sqa_dfct/finish_audit')?>',{body_no:body_no}, function(html){
                    if (html == 1) {
                        alert('Vehicle [' + body_no + '] Already Finish Checked at SQA'); 
                        get_vehicle('body_no');
                        //get_vinf_under_sqa(body_no);
						$('#btnRegOut').removeAttr('disabled');
                        load_stall();
                    } else if (html == 2) {
                        alert('Related Users Must be Cancel REG OUT status Unit');
                    }
                });
            }
        }
    }

	function preview_dfct() {
		var problem_id = $('#problem_id').val();
        if (problem_id != '') {
            window.location = '<?=site_url('t_sqa_dfct/report_sqa')?>' + '/' + problem_id + '/r';
        }
	}
    
    function load_stall() {
        $.post('<?=site_url('m_sqa_stall/load_stall')?>',{}, function(html){
            $('#stall_column').html(html);
        });
    }
</script>

<div class="columns">
    <div class="column grid_8 first">
        <div class="widget">
            <header>
                <h2 style="cursor: pointer" onclick="$('#widget_auditor').toggle()">AUDITOR</h2>
            </header>
            <section id="widget_auditor">

                <table width="100%" border="0">
                    <tr>
                        <td width="8%" height="29">Auditor 1</td>
                        <td width="1%">:</td>
                        <td width="18%"><input type="text" name="auditor_nm_1" id="auditor_nm_1" readonly="readonly" value="<?= $auditor_nm_1 ?>" /></td>
                        <td width="7%">Plant</td>
                        <td width="1%">:</td>
                        <td width="19%"><input type="text" name="plant_nm" id="plant_nm" readonly="readonly" value="<?=$plant_nm ?>" /></td>
                        <td width="8%">Shift</td>
                        <td width="1%">:</td>
                        <td width="20%"><input type="text" name="shftgrp_nm" id="shftgrp_nm" readonly="readonly" value="<?= $shiftgrp_nm ?>" /></td>
                        <td width="16%" rowspan="2" style="vertical-align:middle">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Auditor 2</td>
                        <td>:</td>
                        <td><select name="auditor_nm_2" id="auditor_nm_2" style="width: 157px;">
                                <option value="">-- NONE -- </option>
                                <?php foreach ($list_user as $l): ?>
                                    <option value="<?= $l->USER_NM ?>"><?= $l->USER_ID . ' &mdash; ' . $l->USER_NM ?></option>
                                <?php endforeach; ?>
                                </select></td>
                            <td>Stall</td>
                            <td>:</td>
                            <td id="stall_column">
                                    <select name="stall_no" id="stall_no" style="width: 157px;">
                                        <option value="0">-- Select --</option>
                                        <?php foreach ($list_stall as $l): ?>
                                        <option value="<?= $l->STALL_NO ?>"><?= $l->STALL_NO ?> <?= $l->STALL_DESC ?></option>
                                        <?php endforeach; ?>
                                    </select></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>

        </section>
                </div>


                <div class="widget">
                    <header>
                        <h2 style="cursor: pointer" onclick="$('#widget_vehicle').toggle()">VEHICLE</h2>
                        <input type="hidden" value="" id="idno" name="idno" />
                        <input type="hidden" value="" id="refno" name="reno" />
                    </header>
                    <section id="widget_vehicle">
                        <table width="100%" border="0">
                            <tr>
                                <td width="9%" height="29">Body No</td>
                                <td width="1%">:</td>
                                <td width="18%"><input type="text" name="body_no" id="body_no" onclick="this.select();" maxlength="5" /></td>
                                <td width="9%">Frame No</td>
                                <td width="1%">:</td>
                                <td width="19%"><input type="text" name="vinno" id="vinno" onclick="this.select();" maxlength="17" /></td>
                                <td width="12%">Inspection Date</td>
                                <td width="1%">:</td>
                                <td width="21%"><input type="text" name="insp_pdate" id="insp_pdate" readonly="readonly" /></td>
                                <td width="9%" style="vertical-align: middle; text-align: center;">
                                    <span id="img_search_1">
                                    <a href="<?=site_url('t_sqa_dfct/vin_history')?>" class="view_detail2" id="href_vin_history" >
                                        <img src="<?=base_url()?>assets/img/system_search32.png" alt="Search" title="Search Vehicle History" />                                        
                                    </a>                                    
                                    </span>
                                    <span id="img_search_2">
                                        <img src="<?=base_url()?>assets/img/system_search32_disabled.png" alt="Search" title="Search Vehicle History" />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td height="29">Suffix No</td>
                                <td>:</td>
                                <td><input type="text" name="suffix" id="suffix" readonly="readonly"></td>
                                <td>Model Code</td>
                                <td>:</td>
                                <td><input type="text" name="katashiki" id="katashiki" readonly="readonly"></td>
                                <td>Production Date</td>
                                <td>:</td>
                                <td><input type="text" name="assy_pdate" id="assy_pdate" readonly="readonly"></td>
                                <td>
                                <input type="button" name="btnRegIn" id="btnRegIn" value="Audit In" class="button button-gray" style="width:150px;" onclick="on_reg_in();" />
                                <input type="button" name="btnRegInCancel" id="btnRegInCancel" value="Cancel Audit In" class="button button-gray" style="width:150px;display: none" onclick="on_reg_in_cancel();" />
                                <input type="button" name="btnRegOutCancel" id="btnRegOutCancel" value="Cancel Audit Out" class="button button-gray" style="width:150px;display: none" onclick="on_reg_out_cancel();" />                                
                                </td>

                            </tr>
                            <tr>
                                <td>Seq Body No.</td>
                                <td>:</td>
                                <td><input type="text" name="bd_seq" id="bd_seq" readonly="readonly"></td>
                                <td>Seq Assy No</td>
                                <td>:</td>
                                <td><input type="text" name="assy_seq" id="assy_seq" readonly="readonly"></td>
                                <td>Color</td>
                                <td>:</td>
                                <td><input type="text" name="extclr" id="extclr" readonly="readonly"></td>
                                <td><input type="button" name="btnRegOut" id="btnRegOut" value="Audit Out" class="button button-gray" style="width:150px;" onclick="on_reg_out();" /></td>
                            </tr>
                        </table>
                    </section>
                </div>
                <div class="widget" id="widget_dfct">
                    <header>
                        <input type="hidden" name="problem_id" id="problem_id" value="" />
                        <h2 style="cursor: pointer;" id="lblDefect" onclick="toggle_dfct()">
                            + DEFECT
                            <!--input type="button" name="btnDefect" id="btnDefect" value="+ DEFECT" class="button button-gray" onclick="toggle_dfct();" style="width:100px;"/-->
                        </h2>
                    </header>
                    <section id="dfct_panel">
                        <table width="100%" border="0">
                            <tr>
                                <td width="14%" height="29">Defect</td>
                                <td width="1%">:</td>
                                <td colspan="7">
                                    <input name="dfct_id" type="hidden" id="dfct_id" size="5">
                                    <input name="dfct" type="text" id="dfct" size="70" readonly="readonly">
                                    <a href="<?=site_url('m_sqa_dfct/browse_pick')?>" class="view_detail2" id="open_dfct">
                                        <input type="button" id="btnSelectDfct" value="Select Defect" class="button button-gray" style="width:165px; " />                                        
                                    </a>
                                </td>
                                <td width="9%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="29">Rank</td>
                                <td>:</td>
                                <td width="29%">
                                    <select name="rank_nm" id="rank_nm" style="width: 215px">
                                    <?php foreach ($list_rank as $l): ?>
                                        <option value="<?= $l->RANK_ID ?>"><?= $l->RANK_ID ?> <?= $l->RANK_NM ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </td>
                                <td width="14%">Category Group</td>
                                <td width="1%">:</td>
                                <td colspan="4">
                                    <select name="ctg_grp_id" id="ctg_grp_id" onchange="change_ctg_grp(0,0)" style="width: 215px">
                                        <option value="0">-- select --</option>
                                        <?php foreach ($list_ctg_grp as $l): ?>
                                        <option value="<?= $l->CTG_GRP_ID ?>" title="<?= $l->CTG_GRP_NM ?>"><?= $l->CTG_GRP_NM ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="button" name="btnAdd" id="btnAdd" value="Add" class="button button-gray" style="width:130px;" onclick="on_add();">
                                </td>
                            </tr>
                            <tr>
                                <td height="29">Responsible Shop</td>
                                <td>&nbsp;</td>
                                <td>
                                    <select name="shop_nm" id="shop_nm">
                                        <option value="Chosagoumi">-- Chosagoumi --</option>
                                        <?php foreach ($list_shop as $l): if ($l->SHOP_NM != 'All'): ?>
                                        <option value="<?= $l->SHOP_NM ?>"><?= $l->SHOP_NM ?></option>
                                        <?php endif; endforeach; ?>
                                    </select>
                                </td>
                                <td>Category Name</td>
                                <td>:</td>
                                <td colspan="4" id="ctg_id_panel"><sup> select category group first</sup>
                                </td>
                                <td><input type="button" name="btnEdit" id="btnEdit" value="Edit" class="button button-gray" style="width:130px;" onclick="on_add();"/></td>
                            </tr>
                            <tr>
                                <td height="29">Measurement</td>
                                <td>:</td>
                                <td><input name="measurement" type="text" id="measurement" size="30" /></td>
                                <td>Reference Value</td>
                                <td>:</td>
                                <td colspan="4"><input name="refval" type="text" id="refval" size="30" /></td>
                                <td><input type="button" name="btnDelete" id="btnDelete" value="Delete" class="button button-gray" style="width:130px;" onclick="on_delete_dfct();" /></td>
                            </tr>
                    <tr>
                        <td height="29" colspan="3"><strong>Confirmation By</strong></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td width="3%">Yes</td>
                        <td width="8%">No</td>
                        <td width="1%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td><input type="button" name="btnClear" id="btnClear" value="Clear" class="button button-gray" style="width:130px;" onclick="clear_defect(); $('#dfct').focus()" /></td
                    ></tr>
                    <tr>
                        <td height="29">QCD</td>
                        <td>:</td>
                        <td><input name="conf_by_qcd" type="text" id="conf_by_qcd" size="30" /></td>
                        <td>
                            Inspection Item
                            <input type="hidden" name="insp_item_flag" id="insp_item_flag" value="0" />
                        </td>
                        <td>:</td>
                        <td><input type="radio" name="insp_item_flag_r" id="insp_item_flag_1" value="radio" onclick="$('#insp_item_flag').val(1)" /></td>
                        <td><input type="radio" name="insp_item_flag_r" id="insp_item_flag_0" value="radio" onclick="$('#insp_item_flag').val(0)" checked="checked" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>                            
                            <a href="<?=site_url('t_sqa_dfct/upload_img')?>" class="view_detail2">                                
                                <input type="button" id="btnUploadImage" value="Upload Image" onclick="" class="button button-gray" style="width:130px; " />
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td height="29">Related Div</td>
                        <td>:</td>
                        <td><input name="conf_by_related" type="text" id="conf_by_related" size="30" /></td>
                        <td>
                            Quality Gate Item
                            <input type="hidden" name="qlty_gt_item" id="qlty_gt_item" value="0" />
                        </td>
                        <td>:</td>
                        <td><input type="radio" name="qlty_gt_item_r" id="qlty_gt_item_1" value="radio" onclick="$('#qlty_gt_item').val(1)" /></td>
                        <td><input type="radio" name="qlty_gt_item_r" id="qlty_gt_item_0" value="radio" onclick="$('#qlty_gt_item').val(0)" checked="checked" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="button" name="btnPreview" id="btnPreview" value="Preview" class="button button-gray" style="width:130px;" onclick="preview_dfct();" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            History Repair Process
                            <input type="hidden" name="repair_flg" id="repair_flg" value="0" />
                        </td>
                        <td>:</td>
                        <td><input type="radio" name="repair_flg_r" id="repair_flg_1" value="radio" onclick="$('#repair_flg').val(1)" /></td>
                        <td><input type="radio" name="repair_flg_r" id="repair_flg_0" value="radio" onclick="$('#repair_flg').val(0)" checked="checked" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <a href="<?=site_url('t_sqa_dfct/upload_attch')?>" class="view_detail">
                                <!--button class="button button-gray" style="width:130px;" id="btnUploadAttch">Upload Attach</button-->
                                <input type="button" id="btnUploadAttch" value="Upload Attach" onclick="" class="button button-gray" style="width:130px; " />
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        </div>


        <table width="100%" border="0">
            <tr>
                <td align="left">&nbsp;</td>
                <td align="right">
                    <a href="<?=site_url('t_sqa_dfct/print_cs')?>" class="view_detail2" id="link_print_cs">
                    <input type="button" id="btnPrintCSRepair" value="Print C/S Repair" onclick="" class="button button-gray" style="width:150px; " />
                    </a>
                    <input type="button" id="btnFinishAudit" value="Finish Audit" onclick="on_finish_audit()" class="button button-gray" style="width:150px; " />
                </td>
            </tr>            
        </table>

        <input type="hidden" name="page" id="page" value="" />

        <div class="widget">
            <header>
                <h2 style="cursor: pointer" onclick="$('#content_vinf').toggle()">Under SQA Check</h2>
            </header>
            <div id="content_vinf" class="fakeContainer">
            
            </div>
        </div>

        <div class="widget">
            <header>
                <h2 style="cursor: pointer" onclick="$('#content_dfct').toggle()">List Problem</h2>
            </header>            
            <!--section id="content_dfct" style="height: 200px; overflow: scroll;">
                <center>- select vehicle to show defect list -</center>
            </section-->
            <div id="content_dfct" class="fakeContainer2">
            
            </div>
        </div>

    </div></div>

<!-- initiate button -->
<script type="text/javascript">
    $(function(){
        $('#body_no').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                if ($('#body_no').val().length == 5) {
                    
                    // trick 2 kali, bisa jadi lambat. tp ini the best solusi
                    var temp_bodyno = $('#body_no').val();
                    $('#body_no').val('');
                    get_vehicle('body_no');
                    $('#body_no').val(temp_bodyno);
                    get_vehicle('body_no');                      
                } else {
                    alert('Body length must be 5 digit');
                    $('#body_no').select();
                }
            } else if (keycode == '27') {
                // clear all and disabled reg in button
                $('#body_no').val('');
                get_vehicle('body_no');
            }
        });
        $('#vinno').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                if ($('#vinno').val().length == 17) {
                    
                    // trick 2 kali, bisa jadi lambat. tp ini the best solusi                    
                    $('#body_no').val('');
                    get_vehicle('body_no');
                    get_vehicle('vinno'); 
                    
                    get_vehicle('vinno');                      
                } else {
                    alert('Frame length must be 17 digit');
                    $('#vinno').select();
                }
            } else if (keycode == '27') {
                // clear all and disabled reg in button
                $('#body_no').val('');
                get_vehicle('body_no');                
            }
        });

        // clear vehicle
        clear_vehicle();

        $('#btnRegIn').attr('disabled', 'disabled');
        $('#btnRegOut').attr('disabled', 'disabled');
        //$('#btnDefect').attr('disabled', 'disabled');
        $('#img_search_1').hide();
        $('#img_search_2').show();

        // default table, get_vinf_under_sqa, all if tidak ada bodyno yg dikirim        
        <?php if ($body_no != ''): ?>
            $('#body_no').val('<?=$body_no?>');
            get_vehicle('body_no');
            $('#problem_id').val('<?=$problem_id?>');            
            get_dfct_by_problem_id();                        
        <?php else: ?>
            get_vinf_under_sqa(0);
        <?php endif; ?>

        dfct_button_1();

        // tombol yg di bawah terkait si vinf
        $('#btnPrintCSRepair').attr('disabled', 'disabled');        
        $('#btnFinishAudit').attr('disabled', 'disabled');
        
        $('#dfct_panel').hide();
        cek_btn_defect(true);
        
        <?php if ($problem_id != '' || $this->uri->segment(3)!=''): ?>
        $('#problem_id').val('<?=$problem_id?>');
        <?php endif; ?>
        
    });    
</script>
<br /><br /><br /><br />&nbsp;