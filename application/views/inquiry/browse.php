<style>

.fakeContainer { /* The parent container */
    margin: 15px;
    padding: 0px;
    border: none;
    width: 940px; /* Required to set */
    height: 320px; /* Required to set */
    overflow: hidden; /* Required to set */
}
</style>

<script type="text/javascript">
    
     //fungsi untuk mengambil problem_id dan variabel lainnya dari checkbox
    function on_check(problem_id,show_flag,approve_pdate,reg_in,check_pdate,sqpr_num,description,shop_nm,body_no,insp_item_flg
    ,ot_date,of_date,rt_date,rf_date,user,dfct,shop_defect) {

        $('.data tr').removeClass("active");
        if(problem_id !=''){
        $('#dfct_' + problem_id).addClass("active");
        }
        else{
        $('#dfct_' + problem_id).removeClass("active");   
        }
        
        $('#problem_id').val(problem_id);
        $('#show_flag').val(show_flag);
        $('#approve_pdate').val(approve_pdate);
        $('#check_pdate').val(check_pdate);
        $('#sqpr_num').val(sqpr_num);
        $('#description').val(description);
        $('#shop_nm').val(shop_nm);
        $('#body_no').val(body_no);
        $('#insp_item_flg').val(insp_item_flg);
        $('#ot_date').val(ot_date);
        $('#of_date').val(of_date);
        $('#rt_date').val(rt_date);
        $('#rf_date').val(rf_date);
        $('#user').val(user);
		$('#dfct').val(dfct);
           
        //administrator=================================================================
        if(user =='09'){
        $('#btnapproved').show();
        $('#reply').show();
        $('#Show').show();
        $('#psclosed').show();
        $('#btnSQPR').show();  
        $('#reply').show(); 
        $('#btncek').hide(); 
		
		
            
        //checked akan menjadi Unchecked  
        if(reg_in !='' && check_pdate !='' && approve_pdate ==''){
            $('#btnUncek').removeAttr('disabled');
            $('#btnapproved').removeAttr('disabled');
            $('#Show').attr('disabled','disabled');
            $('#btnSQPR').attr('disabled','disabled');
            $('#btnUncek').show();
            $('#btncek').hide();            
        }

        else {
           // $('#btncek').removeAttr('disabled');
            $('#btnapproved').attr('disabled','disabled');
            $('#Show').attr('disabled','disabled');
            $('#btnSQPR').attr('disabled','disabled');
            $('#btncek').show();
            $('#btnUncek').hide();            
        }
        //end checked akan menjadi Unchecked  
        
        // Approved and cancel approve
        if(approve_pdate !=''){
            $('#btnUnapproved').removeAttr('disabled')
            $('#btnUnapproved').show();
            $('#btnapproved').hide();
            $('#Show').removeAttr('disabled');
            $('#Show').removeAttr('disabled');
            $('#UnShow').removeAttr('disabled');
            $('#btnSQPR').removeAttr('disabled'); 
            }
        else {           
            $('#btnapproved').show();
            $('#btnUnapproved').hide();
        }
        // end Approved and cancel approve
        
        // set SQPR
        if(sqpr_num !=''){
            $('#btnSQPRcanc').removeAttr('disabled');
            $('#btnSQPRcanc').show();
            $('#btnSQPR').hide();
        }   
        else {    
            $('#btnSQPR').show();
            $('#btnSQPRcanc').hide();
        }
        // end set SQPR
     
        // set show flag
        if(show_flag =='1'){   
            $('#UnShow').show();
            $('#Show').hide();
        }
        else {           
            $('#Show').show();
            $('#UnShow').hide();
        }
        // end set show flag
        
        // reply
        if(approve_pdate !=''){
            // $('#psclosed').removeAttr('disabled');
             $('#reply').removeAttr('disabled');
             $('#btncek').attr('disabled', 'disabled');           
        }
        else {
             //$('#psclosed').attr('disabled', 'disabled');
            $('#reply').attr('disabled', 'disabled');  
        }
        // end reply
        
        
        
        // ps closed
        if(insp_item_flg =='1' && ot_date !='' && of_date !='' && rt_date!='' && rf_date!=''){
            $('#psclosed').removeAttr('disabled');
        }
        else if(insp_item_flg =='0' && rt_date!='' && rf_date!=''){
            $('#psclosed').removeAttr('disabled');
        }    
        else{
             $('#psclosed').attr('disabled', 'disabled');
        }
        // end ps closed
}
        
 
    //user 05 sqa GH/LH
    if(user =='05'){
        
        // set show flag
        if(approve_pdate ==''){
            $('#Show').attr('disabled','disabled');
            $('#UnShow').attr('disabled','disabled');   
        } else { 
            $('#UnShow').removeAttr('disabled');
            $('#Show').removeAttr('disabled');           
        }
       
        if(show_flag =='1'){   
            $('#UnShow').show();
            $('#Show').hide();
        } else {           
            $('#Show').show();
            $('#UnShow').hide();
        }
        // end set show flag
         
        // ps closed
        if(insp_item_flg =='1' && ot_date !='' && of_date !='' && rt_date!='' && rf_date!=''){
            $('#psclosed').removeAttr('disabled');
        } else if(insp_item_flg =='0' && rt_date!='' && rf_date!=''){
            $('#psclosed').removeAttr('disabled');
        } else{
             $('#psclosed').attr('disabled', 'disabled');
        }
        // end ps closed        
        
        
        $('#btnapproved').attr('disabled', 'disabled');
        $('#reply').attr('disabled', 'disabled');
        //$('#Show').attr('disabled', 'disabled');
        //$('#psclosed').attr('disabled', 'disabled');
        $('#btnSQPR').attr('disabled', 'disabled'); 
        
        if(user =='05' && dfct =='' && approve_pdate ==''){
            $('#btncek').attr('disabled','disabled');
            $('#btnUncek').attr('disabled','disabled');
        } else if(user =='05' && check_pdate =='' && approve_pdate ==''){
        	$('#btncek').removeAttr('disabled');
            $('#btncek').show();
            $('#btnUncek').hide();
        } else if(user =='05' && approve_pdate !=''){
			$('#btncek').attr('disabled','disabled');
            $('#btnUncek').attr('disabled','disabled');               
        } else {
			//	$('#btncek').removeAttr('disabled');
            $('#btnUncek').removeAttr('disabled');
            $('#btnUncek').show();
            $('#btncek').hide();
                
        }
    } else {            
        if(user =='09' && dfct !=''){
            $('#btncek').removeAttr('disabled');
            $('#btnUncek').removeAttr('disabled');
        }else {                                  
            $('#btncek').attr('disabled','disabled');
            $('#btnUncek').attr('disabled','disabled');
        }
    }
    //end user 05 sqa GH/LH   
                
    //user 06 SQA-SH (sqa section head)
    if(user =='06' ){
        $('#reply').attr('disabled', 'disabled');
        $('#btncek').attr('disabled', 'disabled');
        $('#Show').attr('disabled', 'disabled');
        
        
        //$('#psclosed').attr('disabled', 'disabled'); 
        /* edited 20111017 - SQA-SH boleh ps closed jika kondisi semua terpenuhi */
        // ps closed
        if(insp_item_flg =='1' && ot_date !='' && of_date !='' && rt_date!='' && rf_date!=''){
            $('#psclosed').removeAttr('disabled');
        } else if(insp_item_flg =='0' && rt_date!='' && rf_date!=''){
            $('#psclosed').removeAttr('disabled');
        } else{
             $('#psclosed').attr('disabled', 'disabled');
        }
        // end ps closed
        
        
        
        $('#btnSQPR').attr('disabled', 'disabled');
    }
                    
    if(user =='06' && check_pdate !=''){
                       
        if(user =='06' && approve_pdate !=''  ){
            //$('#btncek').removeAttr('disabled');
            $('#btnUnapproved').removeAttr('disabled');
            $('#btnUnapproved').show();
            $('#btnapproved').hide();
        } else {
            $('#btnapproved').removeAttr('disabled');
            $('#btnapproved').show();
            $('#btnUnapproved').hide();
        }
    }
    //end user 06 sqa section head
    
   
    //user 01 responsible
    if(user =='01' || user =='02' || user =='03'){
        $('#btnapproved').attr('disabled', 'disabled');
        $('#btncek').attr('disabled', 'disabled');
        $('#Show').attr('disabled', 'disabled');
        $('#psclosed').attr('disabled', 'disabled');
        $('#btnSQPR').attr('disabled', 'disabled');
        
        var shop_id = '<?=get_user_info($this, 'SHOP_ID')?>';   
        //var shop_defect = shop_nm.substring(0,1);
        //alert(shop_id + ' == ' + shop_defect);
        
        if((user =='01' || user =='02' || user =='03') && approve_pdate !='' && shop_id == shop_defect || (shop_id =='IN' && insp_item_flg =='1')){
                        
		        $('#reply').removeAttr('disabled');
        } else{
                $('#reply').attr('disabled', 'disabled');
        }
    } else {
        if(user =='09'){
            if(approve_pdate !=''){
                // $('#psclosed').removeAttr('disabled');
                 $('#reply').removeAttr('disabled');
                 $('#btncek').attr('disabled', 'disabled');
            } else {
                //$('#psclosed').attr('disabled', 'disabled');
                $('#reply').attr('disabled', 'disabled');           
            }
        }
    }
     
    //user 04 sqa-officer
    if(user == '04'){
        $('#btnapproved').attr('disabled', 'disabled');
        $('#btncek').attr('disabled', 'disabled');
        $('#Show').attr('disabled', 'disabled');
        $('#reply').attr('disabled', 'disabled');
        $('#psclosed').attr('disabled', 'disabled');
        $('#btnSQPR').attr('disabled', 'disabled');
        
        /*
            20111017 - ps closed tidak berlaku untuk sqa-officer - by irfan&ryan.. notes dr catatan pak gun
        
        if(user =='04' && insp_item_flg =='1' && ot_date !='' && of_date !='' && rt_date!='' && rf_date!=''){            
            $('#psclosed').removeAttr('disabled');
        } else if(insp_item_flg =='0' && rt_date!='' && rf_date!='') {
            $('#psclosed').removeAttr('disabled');
        } else{
             $('#psclosed').attr('disabled', 'disabled');
        }
        */
    } else {
        if(user =='09'){
            if(insp_item_flg =='1' && ot_date !='' && of_date !='' && rt_date!='' && rf_date!=''){
                $('#psclosed').removeAttr('disabled');
            } else if(insp_item_flg =='0' && rt_date!='' && rf_date!='') {
                $('#psclosed').removeAttr('disabled');
            } else{
                $('#psclosed').attr('disabled', 'disabled');
            }
        }
     }     
     //end user 04 sqa-officer
     
     //user 07 sqa manager
    if(user =='07' ) {
        $('#btnapproved').attr('disabled', 'disabled');
        $('#btncek').attr('disabled', 'disabled');
        $('#Show').attr('disabled', 'disabled');
        $('#reply').attr('disabled', 'disabled');
        $('#psclosed').attr('disabled', 'disabled');
       // $('#btnSQPR').hide();
    }
    if(user =='07' && approve_pdate !=''){
        if(user =='07' && sqpr_num !=''){
            $('#btnSQPRcanc').removeAttr('disabled');                    
            $('#btnSQPRcanc').show();
            $('#btnSQPR').hide();
        } else {
            $('#btnSQPR').removeAttr('disabled');
            $('#btnSQPR').show();
            $('#btnSQPRcanc').hide();
        }
    } else {
        if(user =='09'){
            if(sqpr_num ==''){
                $('#btnSQPR').show();
                $('#btnSQPRcanc').hide();
            } else {
                $('#btnSQPRcanc').removeAttr('disabled');
                $('#btnSQPRcanc').show();
                $('#btnSQPR').hide();           
            }
        }
    }
    //end user 07 sqa manager
}
        
    $(function(){
        $("#SQA_FROM_PDATE").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true});
        $("#SQA_TO_PDATE").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true});
        $("#ASSY_FROM_PDATE").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true});
        $("#ASSY_TO_PDATE").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true});
        $("#ASSY_PDATE").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true});
        $("#INSP_FROM_PDATE").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true});
        $("#INSP_TO_PDATE").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true});
        $("#inspection_to").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true});
    });

    $(function() {
        $(".download_report").fancybox({
            'width'         : '60%',
            'height'        : '60%',
            'autoScale'     : false,
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic',
            'type'          : 'iframe',
            'onComplete' : function(){$('.closer').click(function(){parent.$.fancybox.close()})}
        });
    });
   
    // fungsi toogle advance search
    var t_dfct = 0;
    function toogle_advance_search(){
    $('#advance_button').attr('disabled', 'disabled');
        if (t_dfct == 0) {
            $('#middlecontent').show();
             $('#title2').html('- ADVANCE SEARCH');
             $('#advance_button').attr('disabled', 'disabled');             
             $('#advance_button').removeAttr('disabled');
             $('#search').attr('disabled', 'disabled');                        
        }
        else {
            $('#middlecontent').hide();
            $('#title2').html('+ ADVANCE SEARCH');              
            $('#advance_button').attr('disabled', 'disabled');
            $('#search').removeAttr('disabled');        
            $('#ASSY_FROM_PDATE').val('');
            $('#ASSY_TO_PDATE').val('');
            $('#ASSY_SHIFTGRPNM').val('0');
            $('#INSP_FROM_PDATE').val('');
            $('#INSP_TO_PDATE').val('');
            $('#INSP_SHIFTGRPNM').val('0');
            $('#DESCRIPTION').val('');
            $('#KATASHIKI').val('');
            $('#EXTCLR').val('');
            $('#VINNO').val('');
            $('#BODYNO').val('');
            $('#INSP_SHIFTGRPNM').val('');
            $('#stat_prob_b').removeAttr('checked');
            $('#stat_prob_c').removeAttr('checked');
            $('#stat_prob_d').removeAttr('checked');
            $('#stat_prob_e').removeAttr('checked');
            $('#stat_prob_f').removeAttr('checked');
            $('#stat_prob_a').attr('checked', 'checked');
            $('#stat_prob').val('0');
            $('#DFCT').val('');
            $('#RANK_NM').val('0');
            $('#CTG_GRP_NM').val('0');
            $('#CTG_NM').val('0');
            $('#INSP_ITEM_FLG_1').removeAttr('checked');
            $('#INSP_ITEM_FLG_0').removeAttr('checked');
            $('#INSP_ITEM_FLG_2').attr('checked', 'checked');
            $('#INSP_ITEM_FLG').val('');
            $('#QLTY_GT_ITEM_1').removeAttr('checked');
            $('#QLTY_GT_ITEM_0').removeAttr('checked');
            $('#QLTY_GT_ITEM_2').attr('checked', 'checked');
            $('#QLTY_GT_ITEM').val('');
            $('#REPAIR_FLG_1').removeAttr('checked');
            $('#REPAIR_FLG_0').removeAttr('checked');
            $('#REPAIR_FLG_2').attr('checked', 'checked');
            $('#REPAIR_FLG').val('');
            $('#Status_Problem_Sheet_0').removeAttr('checked');
            $('#Status_Proble0Sheet_1').removeAttr('checked');
            $('#Status_Problem_Sheet_2').removeAttr('checked');
            $('#Status_Problem_Sheet_3').removeAttr('checked');
            $('#Status_Problem_Sheet_4').attr('checked', 'checked');
            $('#Status_Problem_Sheet').val('');
            $('#SHOW_FLG_0').removeAttr('checked');
            $('#SHOW_FLG_1').removeAttr('checked');
            $('#SHOW_FLG_2').attr('checked', 'checked');
            $('#SHOW_FLG').val('');
            $('#Problem_Sheet_a').val('');
            $('#Problem_Sheet_b').val('');
            $('#Problem_Sheet_c').val('');
            $('#Problem_Sheet_d').val('');
            $("#list_vinf").html("<img src='<?=base_url()?>assets/style/images/loading-gif.gif' />");
            status_vehicle_all();
            search();
        }
        t_dfct = !t_dfct;
    }

    function toogle_SQA(){
        $('#SQA').toggle('slow');
    }

    function clear_hidden_field() {
        $('#problem_id').val('');
        $('#show_flag').val('');
        $('#approve_pdate').val('');
        $('#check_pdate').val('');
        $('#description').val('');
        $('#shop_nm').val('');
        $('#body_no').val('');
        $('#insp_item_flg').val('');
        $('#ot_date').val('');
        $('#of_date').val('');
        $('#rt_date').val('');
        $('#rf_date').val('');
        $('#user').val('');
    }
    
    //button search
    function search_button(){                      
        $("#list_vinf").ajaxStart(function(){
            $(this).html("<img src='<?=base_url()?>assets/style/images/loading-gif.gif' />");
        });        
        search();
    }
    
    //button adavance search
    function advance_search_button(){        
        clear_hidden_field();        
        $("#list_vinf").ajaxStart(function(){
            $(this).html("<img src='<?=base_url()?>assets/style/images/loading-gif.gif' />");
        });
        advance_search();       
    }

    // fungsi untuk SEARCH
    function search() {        
        clear_hidden_field();        
        var button_id = ["register", "download","btnapproved","btnUnapproved",
         "Show","UnShow","psclosed","btncek","btnUncek","btnSQPR","btnSQPRcanc"
         ,"reply"]; 
        disabled_button(button_id,'disable');
       
        var from = $('#SQA_FROM_PDATE').val();
        var to = $('#SQA_TO_PDATE').val();
        var sqa_shiftgrpnm = $('#SQA_SHIFTGRPNM').val();
        var plant_nm = $('#PLANT_NM').val();
        var SHOP_NM = $('#SHOP_NM').val();
        
        //=============================================sqa date===================================      
        // tanggal from
        var strDate_from = $('#SQA_FROM_PDATE').val();;       
        var dateParts = strDate_from.split("-");        
        var currentTime = new Date(dateParts[2], (dateParts[1])-1, dateParts[0]);
        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var tgl_from = (month + "/" + day + "/" + year)
        
        // tanggal to
        var strDate_to = $('#SQA_TO_PDATE').val();;       
        var dateParts = strDate_to.split("-");        
        var currentTime = new Date(dateParts[2], (dateParts[1])-1, dateParts[0]);

        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var tgl_to = (month + "/" + day + "/" + year)
        
        var re=/^(\d{1,2})-(\d{1,2})-(\d{4})/;
        
         if(!strDate_from.match(re)){
            alert ('Please enter date from as either dd-mm-yyyy');
            return false;            
         } 
         
         if(!strDate_to.match(re)){
            alert ('Please enter date to as either dd-mm-yyyy');
            return false;            
         }  
        //=============================================sqa date=======================================       
        
        // membandingkan tanggal from dan to
        if(Date.parse(tgl_from) > Date.parse(tgl_to))
        {
            alert("SQA Date from greater than date to !");
        }
       
        else {
                 
        param = from + ';;' + to + ';;' + sqa_shiftgrpnm + ';;' + plant_nm + ';;' + SHOP_NM ;
        <?php if ($this->uri->segment(3)!=''&$this->uri->segment(4)!=''):?>        
        $.post('<?=site_url('inquiry/search/' . $this->uri->segment(3) . '/' . $this->uri->segment(4))?>',
        <?php else: ?>
        $.post('<?=site_url('inquiry/search/')?>',
        <?php endif; ?>
        {
            param: param
        },
        function(html){
            
            $('#list_vinf').html(html);
            $('#btnapproved').attr('disabled','disabled');
            $('#btnUnapproved').attr('disabled','disabled');
            $('#btnSQPR').attr('disabled','disabled');
            $('#Show').attr('disabled','disabled');
            $('#btncek').attr('disabled','disabled');
            $('#psclosed').attr('disabled','disabled');
            $('#reply').attr('disabled','disabled');
            $('#UnShow').attr('disabled','disabled');            
            $('#btnUncek').attr('disabled','disabled');
            $('#btnSQPRcanc').attr('disabled','disabled');
            $('#register').removeAttr('disabled');
            $('#download').removeAttr('disabled');
            $('#search').removeAttr('disabled');
        })
        }
        
    }

    // fungsi untuk Advance_SEARCH
    function advance_search() {
         var button_id = ["register", "download","btnapproved","btnUnapproved",
         "Show","UnShow","psclosed","btncek","btnUncek","btnSQPR","btnSQPRcanc"
         ,"reply"];
        disabled_button(button_id,'disable');
     //   $("#list_vinf").html("<img src='<?=base_url()?>assets/style/images/loading-gif.gif' />");

        var from = $('#SQA_FROM_PDATE').val();
        var to = $('#SQA_TO_PDATE').val();
        var sqa_shiftgrpnm = $('#SQA_SHIFTGRPNM').val();
        var plant_nm = $('#PLANT_NM').val();
        var SHOP_NM = $('#SHOP_NM').val();
        var ASSY_FROM_PDATE = $('#ASSY_FROM_PDATE').val();
        var ASSY_TO_PDATE = $('#ASSY_TO_PDATE').val();
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
        var CTG_GRP_NM = $('#CTG_GRP_NM').val();
        var CTG_NM = $('#CTG_NM').val();
        var INSP_ITEM_FLG = $('#INSP_ITEM_FLG').val();
        var QLTY_GT_ITEM = $('#QLTY_GT_ITEM').val();
        var REPAIR_FLG = $('#REPAIR_FLG').val();
        var Problem_Sheet_a = $('#Problem_Sheet_a').val();
		var Problem_Sheet_b = $('#Problem_Sheet_b').val();
		var Problem_Sheet_c = $('#Problem_Sheet_c').val();
		var Problem_Sheet_d = $('#Problem_Sheet_d').val();
        var Status_Problem_Sheet = $('#Status_Problem_Sheet').val();
        var SHOW_FLG = $('#SHOW_FLG').val();              		
        
         //=============================================sqa date=======================================       
        // tanggal from
        var strDate_from = $('#SQA_FROM_PDATE').val();;       
        var dateParts = strDate_from.split("-");        
        var currentTime = new Date(dateParts[2], (dateParts[1])-1, dateParts[0]);

        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var tgl_from = (month + "/" + day + "/" + year)
        
        // tanggal to
        var strDate_to = $('#SQA_TO_PDATE').val();;       
        var dateParts = strDate_to.split("-");        
        var currentTime = new Date(dateParts[2], (dateParts[1])-1, dateParts[0]);

        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var tgl_to = (month + "/" + day + "/" + year)
        
        var re=/^(\d{1,2})-(\d{1,2})-(\d{4})/;
        
         if(!strDate_from.match(re)){
            alert ('Please enter SQA date form as either dd-mm-yyyy');
            return false;            
         } 
         
         if(!strDate_to.match(re)){
            alert ('Please enter SQA date to as either dd-mm-yyyy');
            return false;            
         }  
 
        //=============================================end sqa date=======================================  
       
        //=========================================prod_date=================================    
        // tanggal from
        var strDate_prod_from = $('#ASSY_FROM_PDATE').val();;       
        var dateParts = strDate_prod_from.split("-");        
        var currentTime = new Date(dateParts[2], (dateParts[1])-1, dateParts[0]);

        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var tgl_from_prod_from = (month + "/" + day + "/" + year)
        
        // tanggal to
        var strDate_prod_to = $('#ASSY_TO_PDATE').val();       
        var dateParts = strDate_prod_to.split("-");        
        var currentTime = new Date(dateParts[2], (dateParts[1])-1, dateParts[0]);
        
        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var tgl_to_prod_to = (month + "/" + day + "/" + year)
        
        var re=/^(\d{1,2})-(\d{1,2})-(\d{4})/;
         
         if(strDate_prod_from == ''){
            var strDate_prod_from = '';        
         }
         else if(!strDate_prod_from.match(re)){
            alert ('Please enter Production Date from as either dd-mm-yyyy');
            return false;
            }                    
                        
         if(strDate_prod_to == ''){
            var strDate_prod_to = '';
            } 
                    
         else if(!strDate_prod_to.match(re)){
            alert ('Please enter Production Date to as either dd-mm-yyyy');
            return false; 
           
            }           
        //=========================================end prod_date================================= 
  
        //=========================================insp date=================================    
        // tanggal from
        var strDate_insp_from = $('#INSP_FROM_PDATE').val();;       
        var dateParts = strDate_insp_from.split("-");        
        var currentTime = new Date(dateParts[2], (dateParts[1])-1, dateParts[0]);

        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var tgl_from_insp_from = (month + "/" + day + "/" + year)
        
        // tanggal to
        var strDate_insp_to = $('#INSP_TO_PDATE').val();;       
        var dateParts = strDate_insp_to.split("-");        
        var currentTime = new Date(dateParts[2], (dateParts[1])-1, dateParts[0]);

        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var tgl_to_insp_to = (month + "/" + day + "/" + year)
       
        var re=/^(\d{1,2})-(\d{1,2})-(\d{4})/;
                
         if(strDate_insp_from == ''){
            var strDate_insp_from = '';  
            }
          
         else if(!strDate_insp_from.match(re)){
            alert ('Please enter Inspection Date from as either dd-mm-yyyy');
            return false;           
            }
         if(strDate_insp_to == ''){
            var strDate_insp_to = '';  
            }           
         else if(!strDate_insp_to.match(re)){
            alert ('Please enter Inspection Date to as either dd-mm-yyyy');
            return false;
            }
       //=========================================end insp date=================================  
          
        // membandingkan tanggal from dan to
        if(Date.parse(tgl_from) > Date.parse(tgl_to))
        {
        alert("SQA Date form greater than date to !");
        return false;
        }
        else if(Date.parse(tgl_from_prod_from) > Date.parse(tgl_to_prod_to))
        {
        alert("Production Date form greater than date to !");
         return false;
        }
        else if (Date.parse(tgl_from_insp_from) > Date.parse(tgl_to_insp_to))
        {
        alert("Inspection Date form greater than date to !");
         return false;
        }
        else {    
        param = from + ';;' + to + ';;' + sqa_shiftgrpnm + ';;' + plant_nm + ';;' + SHOP_NM + ';;' + ASSY_FROM_PDATE + ';;' + ASSY_TO_PDATE + ';;' + ASSY_SHIFTGRPNM
            + ';;' + INSP_FROM_PDATE + ';;' + INSP_TO_PDATE + ';;' + INSP_SHIFTGRPNM
            + ';;' + DESCRIPTION  + ';;' + KATASHIKI + ';;' + EXTCLR + ';;' + VINNO + ';;' + BODYNO
            + ';;' + stat_prob + ';;' + DFCT + ';;' + RANK_NM + ';;' + CTG_GRP_NM + ';;' + CTG_NM + ';;' + INSP_ITEM_FLG
            + ';;' + QLTY_GT_ITEM  + ';;' + REPAIR_FLG  + ';;' + Problem_Sheet_a + ';;' + Problem_Sheet_b 
            + ';;' + Problem_Sheet_c + ';;' + Problem_Sheet_d + ';;' + Status_Problem_Sheet + ';;' + SHOW_FLG
            ;
            
        <?php if ($this->uri->segment(3)!=''):?>
        $.post('<?=site_url('inquiry/advance_search/' . $this->uri->segment(3))?>',
        <?php else: ?>
        $.post('<?=site_url('inquiry/advance_search/')?>',
        <?php endif; ?>
        {
            param: param
        },
        function(html){            
           // $('#search').removeAttr('disabled');
            $('#download').removeAttr('disabled');
            $('#list_vinf').html(html);  
                                  
            
            var problem_id = $('#problem_id').val();
            var show_flag = $('#show_flag').val();
            var approve_pdate = $('#approve_pdate').val();
            var reg_in = $('#reg_in').val();
            var check_pdate = $('#check_pdate').val();
            var sqpr_num = $('#sqpr_num').val();
            var description = $('#description').val();
            var shop_nm = $('#shop_nm').val();
            var body_no = $('#body_no').val();
            var insp_item_flg = $('#insp_item_flg').val();
      
            var ot_date = $('#ot_date').val();
            var of_date = $('#of_date').val();
            var rt_date = $('#rt_date').val();
            var rf_date = $('#rf_date').val();
            var user = $('#user').val();
            var dfct = $('#dfct').val();            
                        
            on_check(problem_id,show_flag,approve_pdate,reg_in,check_pdate,sqpr_num,description,shop_nm,body_no,insp_item_flg
            ,ot_date,of_date,rt_date,rf_date,user,dfct);
        });
        }
    }


    // fungsi untuk vehicle status ALL
    function status_vehicle_all(){
        
        $('#DFCT').attr('disabled',true).css({'background':' url("<?=base_url()?>assets/images/bg_ip.png") repeat-x'});
        $('#RANK_NM').attr('disabled',true).css({'background':' url("<?=base_url()?>assets/images/bg_ip.png") repeat-x'});
        $('#CTG_GRP_NM').attr('disabled',true).css({'background':' url("<?=base_url()?>assets/images/bg_ip.png") repeat-x'});
        $('#CTG_NM').attr('disabled',true).css({'background':' url("<?=base_url()?>assets/images/bg_ip.png") repeat-x'});
    }

    // fungsi untuk vehicle status PROBLEM SHEET
    function status_vehicle_probsheet(){
        $('#DFCT').attr('disabled',false).removeAttr('style').css({'width':'430px'});
        $('#RANK_NM').attr('disabled',false).css({'background':' #ffffff url("<?=base_url()?>assets/style/images/bg_ip.png") repeat-x'});
        $('#CTG_GRP_NM').attr('disabled',false).css({'background':' #ffffff url("<?=base_url()?>assets/style/images/bg_ip.png") repeat-x'});
        $('#CTG_NM').attr('disabled',false).css({'background':' #ffffff url("<?=base_url()?>assets/style/images/bg_ip.png") repeat-x'});
    }

    // fungsi untuk vehicle status SQPR
    function status_vehicle_sqpr(){
        $('#DFCT').attr('disabled',false).removeAttr('style').css({'width':'430px'});
        $('#RANK_NM').attr('disabled',false).css({'background':' #ffffff url("<?=base_url()?>assets/style/images/bg_ip.png") repeat-x'});
        $('#CTG_GRP_NM').attr('disabled',false).css({'background':' #ffffff url("<?=base_url()?>assets/style/images/bg_ip.png") repeat-x'});
        $('#CTG_NM').attr('disabled',false).css({'background':' #ffffff url("<?=base_url()?>assets/style/images/bg_ip.png") repeat-x'});
    }

    // fungsi untuk vehicle status NO DEFECT
    function status_vehicle_nodfct(){
        $('#DFCT').attr('disabled',true).css({'background':' url("<?=base_url()?>assets/images/bg_ip.png") repeat-x'});
        $('#RANK_NM').attr('disabled',true).css({'background':' url("<?=base_url()?>assets/images/bg_ip.png") repeat-x'});
        $('#CTG_GRP_NM').attr('disabled',true).css({'background':' url("<?=base_url()?>assets/images/bg_ip.png") repeat-x'});
        $('#CTG_NM').attr('disabled',true).css({'background':' url("<?=base_url()?>assets/images/bg_ip.png") repeat-x'});
    }

    // fungsi untuk CHECKED status SQA
    function cek(){
        var problem_id = $('#problem_id').val();
        var body_no = $('#body_no').val();
         var button_id = ["register", "download","btnapproved","btnUnapproved",
         "Show","UnShow","psclosed","btncek","btnUncek","btnSQPR","btnSQPRcanc"
         ,"reply"];
        disabled_button(button_id,'disable');
        var cek = confirm('Are your sure to Check [' + body_no + '] Defect ?');
        if(cek){            
            $.post(
            '<?=site_url('inquiry/cek')?>',
            {
                problem_id: problem_id
            },
            function(html){
                 if(html != ''){
                    if (html == "Another user already checked this defect") {
                        alert('Another user already checked this defect');
                    }                                                           
                } else {
                    alert ('Checked Body No [' + body_no + '] ');
                }
                advance_search();                            
            });         
        }
    }

    // fungsi untuk UNCHECKED status SQA
    function UnCek(){
        var problem_id = $('#problem_id').val();
        var body_no = $('#body_no').val();
         var button_id = ["register", "download","btnapproved","btnUnapproved",
         "Show","UnShow","psclosed","btncek","btnUncek","btnSQPR","btnSQPRcanc"
         ,"reply"];
        disabled_button(button_id,'disable');
        var cek = confirm('Are your sure to UnCheck [' + body_no + '] Defect ?');
        if(cek){
            $('#list_vinf').html("<img src='<?=base_url()?>assets/style/images/loading-gif.gif' /><br/>Please wait. uncheck process...");
            $.post(
            '<?=site_url('inquiry/Uncek')?>',
            {
                problem_id: problem_id
            },
            function(html){
                advance_search();
                 if(html !=''){
                    if (html == 'Another user already Uncheck this defect') {
                        alert('Another user already Uncheck this defect');
                    }                    
                } else {
                    alert ('UnChecked Body No [' + body_no + '] ');    
                }                                    
            });        
        }    
    }

    function approved(){
        var problem_id = $('#problem_id').val();
        var body_no = $('#body_no').val();      
        var shop_nm = $('#shop_nm').val();
        if (shop_nm =='Chosagoumi'){
            alert ('DEFECT Chosagoumi !')
            return false;
        }
        var cek = confirm('Are your sure to Approve [' + body_no + '] Defect ?');        
        if(cek){
            var button_id = ["register", "download","btnapproved","btnUnapproved",
         "Show","UnShow","psclosed","btncek","btnUncek","btnSQPR","btnSQPRcanc"
         ,"reply"];
        disabled_button(button_id,'disable');
            $('#list_vinf').html("<img src='<?=base_url()?>assets/style/images/loading-gif.gif' /><br/>Please wait. approving process...");
            $.post(
            '<?=site_url('inquiry/approved')?>',
            {
                problem_id: problem_id
            },
            function(html){
                if(html !=''){
                    if (html == 'DEFECT STATUS MUST BE CHECK FIRST !' ||
                        html == 'DEFECT CHOSAGOUMI !' ||
                        html == 'Another User already Approved this defect'
                    ){
                        alert (html);    
                    }
                    
               } else {
                    alert ('Approved Body No [' + body_no + '] ');
               } 
               advance_search();                                                           
            }) ;          
        }       
    }

    // fungsi untuk UNAPPROVED status SQA
    function Unapproved(){
        var problem_id = $('#problem_id').val();
        var body_no = $('#body_no').val();
        var cek = confirm('Are your sure to UnApprove [' + body_no + '] Defect ?');        
        if(cek){
             var button_id = ["register", "download","btnapproved","btnUnapproved",
         "Show","UnShow","psclosed","btncek","btnUncek","btnSQPR","btnSQPRcanc"
         ,"reply"];
        disabled_button(button_id,'disable');
            $('#list_vinf').html("<img src='<?=base_url()?>assets/style/images/loading-gif.gif' /><br/>Please wait. cancel approved process...");          
            $.post(
            '<?=site_url('inquiry/Unapproved')?>',
            {
                problem_id: problem_id
            },
            function(html){
                if(html !=''){
                    if (html == 'RELATED USERS MUST BE UNAPPROVE STATUS REPLY COMMENT' ||
                        html == 'Another user had to cancel this defect'
                    ) {
                        alert (html);    
                    }
                    
                } else {
                    alert ('Cancel Approved Body No [' + body_no + '] ');    
                }
                advance_search();                            
            });                           
        }
    }
    
    // fungsi SQPR
    function setSQPR(){
        var problem_id = $('#problem_id').val();
        var body_no = $('#body_no').val();
        var approve_pdate = $('#approve_pdate').val();
        var cek = confirm('Are your sure to setSQPR [' + body_no + '] Defect ?');

        if(cek){ 
            var button_id = ["register", "download","btnapproved","btnUnapproved",
             "Show","UnShow","psclosed","btncek","btnUncek","btnSQPR","btnSQPRcanc"
             ,"reply","search"];
            disabled_button(button_id,'disable');
            $.post(
            '<?=site_url('inquiry/setSQPR')?>',
            {
                problem_id: problem_id
            },
            function(html){
                if(html !=''){
                    if (html == 'DEFECT STATUS MUST BE APPROVE FIRST !' ||
                        html == 'Another user already given a SQPR Sign'
                    ) {
                        alert (html);    
                    }
                    
                } else {
                    alert ('Set SQPR Body No [' + body_no + '] ');    
                }
                advance_search();
                
            });         
        }
    }
    
    // cancel sqpr
    function SQPRcanc(){
        var problem_id = $('#problem_id').val();
        var body_no = $('#body_no').val();       
        var cek = confirm('Are your sure to Cancel [' + body_no + '] SQPR ?');
        if(cek){
            $.post(
            '<?=site_url('inquiry/SQPRcanc')?>',
            {
                problem_id: problem_id
            },
            function(html){
                if(html !=''){
                    if (html == 'Cancel SQPR already done by another User') {
                        alert (html);    
                    }
                } else {
                    alert ('Cancel SQPR Body No [' + body_no + '] ');    
                }
                advance_search();
                
             });
         }  
    }
    
    // ps closed
    function PSclosed(problem_id,approve_pdate){
        var problem_id = $('#problem_id').val();
        var approve_pdate = $('#approve_pdate').val();
        var body_no = $('#body_no').val();        
        var cek = confirm('Are your sure to Cancel [' + body_no + '] Problem Sheet ?');
         if(cek){
            $.post(
            '<?=site_url('inquiry/PSclosed')?>',
            {
                problem_id: problem_id
            },
            function(html){
                if(html !=''){
                    if (html == 'DEFECT STATUS IS NOT HAVE APPROVE SQA & APRPOVE REPLY !' ||
                        html == 'PS/Closed Already done by another User'
                    ) {
                        alert (html);    
                    }
                    
                } else {
                    alert ('P/S Closed Body No [' + body_no + '] ');    
                } 
                advance_search();
            
           });                     
        }
    }


    // fungsi untuk merubah status SHOW FLAG
    function show_flag() {        
        var problem_id = $('#problem_id').val();
        var show_flag = $('#show_flag').val();
        var approve_pdate = $('#approve_pdate').val();
        var body_no = $('#body_no').val();
        var cek = confirm('Are your sure to Show [' + body_no + '] ?');                
        var description = $('#description').val();
       
        if(cek){
        $.post('<?=site_url('inquiry/show_flag')?>',
        {
            problem_id: problem_id,
            show_flag: show_flag,
            description:description
        },
        function(html){           
           if(html !=''){
                if (html == 'Another user already Flag as Show' ||
                    html == description + ' Maximum show up 5 defect'
                ) {
                    alert (html);        
                }
            
            //return false;
           } else {
            alert ('Show Body No [' + body_no + '] ');
           }
            advance_search();
            
        });
        }
    }

    // fungsi untuk merubah status UNSHOW FLAG
    function Unshow_flag() {
        var problem_id = $('#problem_id').val();
        var show_flag = $('#show_flag').val();
        var approve_pdate = $('#approve_pdate').val();
        var body_no = $('#body_no').val();
        var cek = confirm('Are your sure to Cancel Show [' + body_no + '] ?');

        if(cek){
            $.post(
            '<?=site_url('inquiry/Unshow_flag')?>',
            {
                problem_id: problem_id,
                show_flag: show_flag
            },
            function(html){
                if(html !=''){
                    if (html == 'Another user already flag this vehicle as unshow') {
                        alert (html);    
                    }
                } else {
                    alert ('UnShow Body No [' + body_no + '] ');    
                }
                advance_search();
                
            });                  
       }
    }

    function msg_err(err)
    {       
        var html = '<div id="awal" class="message warning "><blockquote id="block_msg"><p><div>' + err + '</div></p></blockquote></div>';
        $('#widget_main').html(html);
        javascript:scroll(0,0);
    }

    function report() {
        $.post('<?=site_url('inquiry/result_search')?>',
        {
            param: param
        },
        function(html){
            $('#list_vinf').html(html);   
        });
    }
    
    function reply_sqa_inquiry(){
        var problem_id = $('#problem_id').val();
        window.location = '<?=site_url('t_sqa_dfct/reply_sqa')?>' + '/' + parent.$('#problem_id').val() + '/m';          
    }
    
     function change_ctg_grp(ctg_nm, ctg_dis) {
        if ($('#CTG_GRP_NM').val() != '0') {
			$("#ctg_id_panel").html("<img src='<?= base_url() ?>assets/style/images/loading-gif2.gif' />");
            $.post('<?= site_url('inquiry/get_ctg') ?>', {
                ctg_grp_id:$('#CTG_GRP_NM').val(),
                ctg_nm:ctg_nm},
                function(html){
                    
                $('#ctg_id_panel').html(html);
                if (ctg_dis == 1) {
                    $('#ctg_nm').attr('disabled', 'disabled');
                }
                
                advance_search();
            });
        }
    }        

</script>

<div class="columns">
    <div class="column grid_8 first" width="100%">
    <span id="widget_main" onclick="hide_message_error()"></span>
            <?

if ($err != "")
{
    echo "<div id+'awal' class='message warning'><blockquote id='block_msg'><p><div>" .
        $err . "</div></p></blockquote></div>";
    echo "<script type='text/javascript'>	javascript:scroll(0,0)</script>";
}

?>
        <div class="widget">
            
            <header>
                <h2 onclick='toogle_SQA()' style="cursor:pointer;">SQA</h2>
            </header>
            <section id="SQA">
                <form name="fInput" method="post" action="" id="fInput">
	
        <input type="hidden" value="" id="problem_id" name="problem_id" />
        <input type="hidden" value="" id="show_flag" name="show_flag" />
        <input type="hidden" value="" id="approve_pdate" name="approve_pdate" />
        <input type="hidden" value="" id="check_pdate" name="check_pdate" />
        <input type="hidden" value="" id="sqpr_num" name="sqpr_num" />
        <input type="hidden" value="" id="shop_id" name="shop_id" />
        <input type="hidden" value="" id="description" name="description" />
        <input type="hidden" value="" id="insp_item_flg" name="insp_item_flg" />
        <input type="hidden" value="" id="shop_nm" name="shop_nm" />
        <input type="hidden" value="" id="body_no" name="body_no" />
		<input type="hidden" value="" id="ot_date"/>
        <input type="hidden" value="" id="of_date"/>
        <input type="hidden" value="" id="rt_date"/>
        <input type="hidden" value="" id="rf_date"/>
        <input type="hidden" value="" id="user"/>
		<input type="hidden" value="" id="dfct" name="dfct" />
                 
      
                    <div class="defectleft">
                        <div class="formreg">
                            <div style="width:80px; float:left;"><label>From</label></div>
                            <b>:</b> &nbsp;<input id="SQA_FROM_PDATE" name="SQA_FROM_PDATE" value="<?=get_date3()?>" type="text" style="width:140px;" maxlength="10">
                            <p>

                            <div style="width:80px; float:left;"><label>To</label></div>
                            <b>:</b> &nbsp;<input id="SQA_TO_PDATE" name="SQA_TO_PDATE" value="<?=get_date2()?>"type="text" style="width:140px;" maxlength="10">
                        </div>
                        <div class="formreg">
                            <div style="width:70px; float:left;"><label>Shift</label></div>
                            <b>:</b> &nbsp;<select name="SQA_SHIFTGRPNM" id="SQA_SHIFTGRPNM" style="width:150px; ">
                                    <option value="0">-- ALL --</option>
                                <?php if (count($list_shift)):foreach ($list_shift as $l):?>
                                        <option value="<?=$l->SHIFTTGRP_NM?>"><?=$l->SHIFTTGRP_NM?></option>
                                <?php endforeach; endif; ?>
                                </select>
                                <p>

                                <div style="width:70px; float:left; "><label>Shop</label></div>
                                <b>:</b> &nbsp;<select name="SHOP_NM" id="SHOP_NM" style="width:150px; ">
                                    <option value="0">-- ALL --</option>
                                <?php foreach ($list_sqa_shop as $l):if ($l->SHOP_NM != 'All'):?>
                                            <option value="<?=$l->SHOP_NM?>"><?=$l->SHOP_NM?></option>
                               <?php endif; endforeach;?>
                                    <option value="Chosagoumi">Chosagoumi</option>
                                    </select><p>
                                </div>
                                <div class="formreg">
                                    <div style="width:70px; float:left;"><label>Plant</label></div>
                                    <b>:</b> &nbsp;<select name="PLANT_NM" id="PLANT_NM" style="width:150px; ">
                                     <option value="<?=$list_plant?>"><?=$list_plant?></option>                                  
                                <?php foreach ($list_plant_select as $l):if ($l->PLANT_NM != $list_plant):?>
                                                <option value="<?=$l->PLANT_NM?>"><?=$l->PLANT_NM?></option>
                                <?php endif; endforeach; ?>
                                 <option value="0">-- ALL --</option>
                                        </select>
                                        
                                        <p>
                                    </div>
                                </div>
                                <div class="buttonreg" align="center">

                                    <button class="button button-gray" id="search" type="button" onclick='search_button()'>Search</button>
                                   <!--<button class="button button-gray" id="register" type="button" onclick="window.location='<?=site_url('t_sqa_dfct/change')?>'">Register</button> -->
                                   <?php $condition = (isset($condition)) ? $condition : ''; ?>
                                    <a href="<?=site_url('inquiry/dwnld_report/' . AsciiToHex(base64_encode($condition)))?>" class="download_report">
                                        <button class="button button-gray" id="download" type="button" onclick="">Download Rpt</button><br /><br />
                                    </a>
                                </div>
                            </form></section></div>

                    <div class="widget">

                        <header>
                            <h2 id="title2" onclick="toogle_advance_search()" style="cursor:pointer">
                                + ADVANCE SEARCH
                            </h2></header>
                        <div>
                            <section>
                                <form name="fInput" method="post" action="" id="fInput">
                                    <!--start middlecontent -->
                                    <div id="middlecontent" style="display:none;">
                                        <div id="submiddle">
                                            <div class="title">Production Date</div><p>
                                            <div style="width:45px; float:left;"><label>From</label></div>
                                            <b>:</b> &nbsp;<input id="ASSY_FROM_PDATE" name="ASSY_FROM_PDATE" type="text"  style="width:110px; " maxlength="10"/><p/>
                                            <div style="width:45px; float:left;"><label>To</label></div>
                                            <b>:</b> &nbsp;<input id="ASSY_TO_PDATE" name="ASSY_TO_PDATE" type="text"  style="width:110px; " maxlength="10"/><p/>
                                            <div style="width:45px; float:left;"><label>Shift:</label></div>
                                            <b>:</b> &nbsp;<select name="ASSY_SHIFTGRPNM" id="ASSY_SHIFTGRPNM" style="width:120px; ">
                                                <option value="0">-- ALL --</option>
                                    <?php if (count($list_m_sqa_shiftgrp)): foreach ($list_m_sqa_shiftgrp as $l):?>
                                                    <option value="<?=$l->SHIFTGRP_ID?>">Production Shift  <?=$l->SHIFTGRP_ID?></option>
                                    <?php endforeach; endif;?>
                                            </select></p>
                                        </div>

                                        <div id="submiddle">
                                            <div class="title">Inspection Date</div><p>
                                            <div style="width:45px; float:left;"><label>From</label></div>
                                            <b>:</b> &nbsp;<input id="INSP_FROM_PDATE" name="INSP_FROM_PDATE"  type="text" style="width:110px;" maxlength="10"/><p>
                                            <div style="width:45px; float:left;"><label>To</label></div>
                                            <b>:</b> &nbsp;<input id="INSP_TO_PDATE" name="INSP_TO_PDATE" type="text" style="width:110px;" maxlength="10"/><p/>
                                            <div style="width:45px; float:left;"><label>Shift:</label></div>
                                            <b>:</b> &nbsp;<select name="INSP_SHIFTGRPNM" id="INSP_SHIFTGRPNM" style="width:120px;"/>
                                                <option value="0">-- ALL --</option>
                                    <?php if (count($list_m_sqa_shiftgrp)):foreach ($list_m_sqa_shiftgrp as $l):?>
                                                        <option value="<?=$l->SHIFTGRP_ID?>"><?=$l->SHIFTTGRP_NM?></option>
                                    <?php endforeach; endif; ?>
                                                </select><p/>
                                            </div>

                                            <div id="submiddle_2">
                                                <div class="title">Vehicle Data</div><p>
                                                <div style="width:100px; float:left;"><label>Model Name</label></div>
                                                <b>:</b> &nbsp;<input id="DESCRIPTION" name="DESCRIPTION" type="text" style="width:110px; "/><br /><p></p>
                                                <div style="width:100px; float:left;"><label>Model Code</label></div>
                                                <b>:</b> &nbsp;<input id="KATASHIKI" name="KATASHIKI" type="text" style="width:110px; "/><br /><p></p>
                                                <div style="width:100px; float:left;"><label>Color</label></div>
                                                <b>:</b> &nbsp;<input id="EXTCLR" name="EXTCLR" type="text" style="width:110px; "/><br /><p></p>
                                            </div>

                                            <div id="submiddle">
                                                <div style="margin-top:30px;"></div><p><p>
                                                <div style="width:65px; float:left;"><label>Frame No</label></div>
                                                <b>:</b> &nbsp;<input id="VINNO" name="VINNO" type="text" style="width:110px;"/><br /><p></p>
                                                <div style="width:65px; float:left;"><label>Body No</label></div>
                                                <b>:</b> &nbsp;<input id="BODYNO" name="BODYNO" type="text" style="width:110px;"/><br /><p></p>
                                            </div>
                                            <hr style="clear:both;">

                                            <div class="title" style="margin-top:-5px;">Defect Data</div>
                                            <div id="defectdataleft" style="width:600px;margin-bottom: 10px;">
                                                <div style="position:relative; top:-5px;">
                                                    <label>Vehicle Status</label>

                                                    &nbsp; <b>:</b> &nbsp;
                                                    <input type="hidden" name="Status_Vehicle" id="stat_prob" value="" />
                                                    <input type="radio" name="Status_Vehicle" value="" id="stat_prob_a" onClick="status_vehicle_all(); $('#stat_prob').val(0);" checked="checked" style="margin:5px;"/>
                                                    <label>All</label>
                
                                                    <input type="radio" name="Status_Vehicle" value="1" id="stat_prob_b" onClick="$('#stat_prob').val(1); status_vehicle_probsheet();" style="margin:5px;"/>
                                                    <label>Problem Sheet</label>
                
                                                    <input type="radio" name="Status_Vehicle" value="2" id="stat_prob_c" onClick="$('#stat_prob').val(2); status_vehicle_sqpr();" style="margin:5px;"/>
                                                    <label>SQPR</label>

                                                    <input type="radio" name="Status_Vehicle" value="3" id="stat_prob_d" onClick="$('#stat_prob').val(3); status_vehicle_nodfct();" style="margin:5px;"/>
                                                    <label>No Defect</label>
                                                    <input type="radio" name="Status_Vehicle" value="3" id="stat_prob_e" onClick="$('#stat_prob').val(4); status_vehicle_nodfct();" style="margin:5px;"/>
                                                    <label>Under SQA Check</label>
                                                    <input type="radio" name="Status_Vehicle" value="3" id="stat_prob_f" onClick="$('#stat_prob').val(5); status_vehicle_nodfct();" style="margin:5px;"/>
                                                    <label>Under Investigation</label>
                                                </div>
                                                
                                                <div style="width:65px; float:left;"><label>Defect</label></div>
                                                <b>:</b> &nbsp;<input type="text" id="DFCT" name="DFCT" style="width:430px;"/><br /><p></p>
                                                <div ><label style="width:65px; float:left;">Rank</label></div>
                                                <b>:</b> &nbsp;<select name="RANK_NM" id="RANK_NM" style="width:120px; height:26px;">
                                                    <option value="0">-- ALL --</option>
                                                    <?php foreach ($list_rank_model as $r):?>
                                                        <option><?=$r->RANK_NM ?></option>
                                                    <?php endforeach ?>
                                                    </select>
                                                    <label class="labeltop" style="margin-left:12px; margin-right:12px;">Category Group</label>
                                                    <b>:</b> &nbsp;<select name="CTG_GRP_NM" onchange="change_ctg_grp(0,0)" id="CTG_GRP_NM" style="width:180px; height:26px;">
                                                        <option value="0">-- ALL --</option>
                                                    <?php foreach ($list_sqa_ctg_grp_model as $r): ?>
                                                    <option value="<?= $r->CTG_GRP_NM ?>"  title="<?= $r->CTG_GRP_NM ?>"><?=$r->CTG_GRP_NM?></option>
                                                    <?php endforeach ?>
                                                        </select><br /><p></p>
                                                        <label class="labeltop" style="margin-left:210px; margin-right:13px;">Category Name</label>

                                                        <b>:</b> &nbsp;
                                                        <span id="ctg_id_panel"><span><sup> select category group first</sup></span></span>
                                                         <input type="hidden" name="CTG_NM" id="CTG_NM" value="0" />
                                                        
                            </div>

                            <div id="defectdataright">
                                <div><label class="defecttitle" style="margin-left:120px;">All&nbsp; Yes&nbsp; No</label></div>
                                <div style="width:120px; float:left;"><label>Inspection Item</label></div>
                                <input type="hidden" name="INSP_ITEM_FLG" id="INSP_ITEM_FLG" value="" />
                                <input type="radio" name="INSP_ITEM_FLG_r" id="INSP_ITEM_FLG_2" value="All" onclick="$('#INSP_ITEM_FLG').val('')" checked="checked" >&nbsp;&nbsp;
                                <input type="radio" name="INSP_ITEM_FLG_r" id="INSP_ITEM_FLG_1" value="Yes" onclick="$('#INSP_ITEM_FLG').val(1)" >&nbsp;&nbsp;
                                <input type="radio" name="INSP_ITEM_FLG_r" id="INSP_ITEM_FLG_0" value="No" onclick="$('#INSP_ITEM_FLG').val(0)" ><br /><p></p>
                                <div style="width:120px; float:left;"><label>Quality Gate Item</label></div>
                                <input type="hidden" name="QLTY_GT_ITEM" id="QLTY_GT_ITEM" value="" />
                                <input type="radio" name="QLTY_GT_ITEM_r" id="QLTY_GT_ITEM_2" value="All" onclick="$('#QLTY_GT_ITEM').val('')" checked="checked" >&nbsp;&nbsp;
                                <input type="radio" name="QLTY_GT_ITEM_r" id="QLTY_GT_ITEM_1" value="Yes" onclick="$('#QLTY_GT_ITEM').val(1)" >&nbsp;&nbsp;
                                <input type="radio" name="QLTY_GT_ITEM_r" id="QLTY_GT_ITEM_0" value="No" onclick="$('#QLTY_GT_ITEM').val(0)" ><br /><p></p>
                                <div style="width:120px; float:left;"><label>History Repair Proses</label></div>
                                <input type="hidden" name="REPAIR_FLG" id="REPAIR_FLG" value="" />
                                <input type="radio" name="REPAIR_FLG_r" id="REPAIR_FLG_2" value="All" onclick="$('#REPAIR_FLG').val('')" checked="checked" >&nbsp;&nbsp;
                                <input type="radio" name="REPAIR_FLG_r" id="REPAIR_FLG_1" value="Yes" onclick="$('#REPAIR_FLG').val(1)" >&nbsp;&nbsp;
                                <input type="radio" name="REPAIR_FLG_r" id="REPAIR_FLG_0" value="No" onclick="$('#REPAIR_FLG').val(0)" ><br /><p></p><br /><p></p>
                            </div>

                            <hr style="clear:both;">
                            <div style="clear:both;"></div>
                            <label class="title" style="margin-bottom: 30px;">Problem Sheet / SQPR</label>
                            <input type="hidden" name="Problem_Sheet" id="Problem_Sheet" value="" />
                            <label class="title" style="margin-left:195px; margin-bottoms: 30px;">Status Problem Sheet</label>
                            <input type="hidden" name="Status_Problem_Sheet" id="Status_Problem_Sheet" value="" />
                            <label class="title" style="margin-left:145px; margin-bottom: 30px;">Show Status</label>
                            <input type="hidden" name="SHOW_FLG" id="SHOW_FLG" value="" />

                            <div id="subproblem" style="margin-top:5px;">
                                <input type="text" name="Problem_Sheet" id="Problem_Sheet_a" style="width:40px;" maxlength="3" />
                                / <input type="text" name="Problem_Sheet" id="Problem_Sheet_b" style="width:40px;" maxlength="4" />
                                / SQA-QAD
                                / <input type="text" name="Problem_Sheet" id="Problem_Sheet_c" style="width:50px;" maxlength="2" />
                                / <input type="text" name="Problem_Sheet" id="Problem_Sheet_d" style="width:50px; maxlength="4" />

                                <input type="radio" name="Status_Problem_Sheet" id="Status_Problem_Sheet_4" value="All" onclick="$('#Status_Problem_Sheet').val('')" checked="checked" style="margin-left:30px; margin-right: 5px;" />All
                                <input type="radio" name="Status_Problem_Sheet" id="Status_Problem_Sheet_3" value="Open" onclick="$('#Status_Problem_Sheet').val(0)" style="margin-left:5px; margin-right: 5px;"  />Open
                                <input type="radio" name="Status_Problem_Sheet" id="Status_Problem_Sheet_2" value="Closed" onclick="$('#Status_Problem_Sheet').val(1)" style="margin-left:5px; margin-right: 5px;"  />Closed
                                <input type="radio" name="Status_Problem_Sheet" id="Status_Problem_Sheet_1" value="Replay" onclick="$('#Status_Problem_Sheet').val(2)" style="margin-left:5px; margin-right: 5px;" />Replay
                                <input type="radio" name="Status_Problem_Sheet" id="Status_Problem_Sheet_0" value="Delay" onclick="$('#Status_Problem_Sheet').val(3)" style="margin-left:5px; margin-right: 5px;"  />Delay

                                <input type="radio" name="SHOW_FLG_r" id="SHOW_FLG_2" value="All" onclick="$('#SHOW_FLG').val('')" checked="checked" style="margin-left:30px; margin-right: 5px;" />All
                                <input type="radio" name="SHOW_FLG_r" id="SHOW_FLG_1" value="Yes" onclick="$('#SHOW_FLG').val(1)" style="margin-left:5px; margin-right: 5px;" />Yes
                                <input type="radio" name="SHOW_FLG_r" id="SHOW_FLG_0" value="No" onclick="$('#SHOW_FLG').val(0)" style="margin-left:5px; margin-right: 5px;" />No

                            </div>
                        </div><hr/>
                        <!--finish middlecontent -->

                        <input type="button" name="" id="advance_button" value="Advance Search" class="button button-gray" style="width:120px; margin-top: -5px;" onclick="advance_search_button();" disabled="">
                        <div id="reportbtn2">
                            <input type="button" name="btnapproved" id="btnapproved" value="Approved" class="button button-gray" style="width:100px;" onclick="approved();">
                            <input type="button" name="btnUnapproved" id="btnUnapproved" value="Cancel Approved" class="button button-gray" style="width:120px;display: none" onclick="Unapproved();">
                            <input type="button" name="Show" id="Show" value="Show" class="button button-gray" style="width:100px;" onclick="show_flag();">
                            <input type="button" name="UnShow" id="UnShow" value="UnShow" class="button button-gray" style="width:100px;display: none" onclick="Unshow_flag();">
                            <input type="button" name="psclosed" id="psclosed" value="P/S Closed" class="button button-gray" style="width:100px;" onclick="PSclosed()">
                            <input type="button" name="Checked" id="btncek" value="Checked" class="button button-gray" style="width:100px;" onclick="cek();">
                            <input type="button" name="UnChecked" id="btnUncek" value="UnChecked" class="button button-gray" style="width:100px;display: none" onclick="UnCek();">
                           <!-- <input type="button" name="btnSQPR" id="btnSQPR" value="SQPR" class="button button-gray" style="width:100px;" onclick="setSQPR();">
                            <input type="button" name="btnSQPRcanc" id="btnSQPRcanc" value="Cancel SQPR" class="button button-gray" style="display: none" onclick="SQPRcanc();">
                           --> <input type="button" name="reply" id="reply" value="Reply" class="button button-gray" style="width:100px;" onclick="reply_sqa_inquiry();">
                            </section></div></div></div>
                    </form>
                   
            </div>
            
            <div class="widgetentri">
              <div style="float: left; margin-bottom: 5px; font-size: 9px; vertical-align: middle; margin-left: 20px;
              margin-top: 10px;">
        <span style="font-weight: bold;">Status P/S Reply :</span> 
        &nbsp;
         <img src="<?=base_url()?>assets/style/images/status_sqa_blank.gif" width="15" heigth="15" alt="status-ot" title=""/> =  Not Yet 
        &nbsp;
        <img src="<?=base_url()?>assets/style/images/nr.gif" width="15" heigth="15" alt="status-ot" title=""/> =   Not Yet Approve
        &nbsp; 
		<img src="<?=base_url()?>assets/style/images/status_sqa_approve.gif" width="15" heigth="15" alt="status-ot" title=""/> =  Approve 
        &nbsp; 
         <img src="<?=base_url()?>assets/style/images/delay.gif" width="15" heigth="15" alt="status-ot" title=""/> = Delay
        &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 
         <span style="font-weight: bold;">Status SQA :</span> 
        &nbsp;
         <img src="<?=base_url()?>assets/style/images/sqa_blank.gif" width="15" heigth="15" alt="status-ot" title=""/> =  Not yet check
        &nbsp; 
        <img src="<?=base_url()?>assets/style/images/checked.gif" width="15" heigth="15" alt="status-ot" title=""/> = Check
        &nbsp; 
        <img src="<?=base_url()?>assets/style/images/approved.gif" width="15" heigth="15" alt="status-ot" title=""/> = Approve 
        &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 
         <span style="font-weight: bold;">Status Show :</span> 
        &nbsp;
         <img src="<?=base_url()?>assets/style/images/show.gif" width="15" heigth="15" alt="status-ot" title=""/> =  Show 
        </div>
                <section>
                    <div id="list_vinf" align="center" class="fakeContainer">
                     
                    </div>          
                </section>
            </div>
        </div>
<script type="text/javascript">
            $(function(){
                search_button('');
                status_vehicle_all('');
               // change_ctg_grp('');
                
            });
</script>