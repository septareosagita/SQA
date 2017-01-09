<div id="investigasi" class="widgetentri">
    <script type="text/javascript">
        function on_close_reply() {
            <?php if ($this->uri->segment(4) == 'm'): ?>        
            window.location='<?= site_url('inquiry/browse/'.$this->uri->segment(3)) ?>';
            <?php else: ?>
            window.location='<?= site_url('t_sqa_dfct/change/'.$this->uri->segment(3)) ?>'
            <?php endif; ?>
        }
    
        function on_preview_report () {
            window.location = '<?=site_url('t_sqa_dfct/report_sqa/' . $this->uri->segment(3) . '/' . $this->uri->segment(4))?>';
        }
	
        function loadawal() {
    
        }

        //------------------------------load awal end-----------------------
        function trim(str){
            return str.replace(/^\s+|\s+$/g,'');
        }

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

        // fungsi message-box
        <?php if ($err != ''): ?>
            $(function(){
                msg_err('<?= $err ?>');
            });    	
        <?php endif; ?>

    function btn_attach_ot() {
        var problem_reply_id_ot=$('#problem_reply_id_ot').val();

        $.post(
            '<?= site_url('t_sqa_dfct/upload_attch/' . problem_reply_id_ot) ?>',
            {problem_reply_id_ot : problem_reply_id_ot},
            function(html){
                $('#view_detail').html(html);
        });
    }

    //FUNGSI UPDATE
    /* ---------------------------- OT --------------------------------- */ 
    function btn_edit_ot() {
        var app_pdate_ot= $('#app_pdate').val();
        var reply_comment_ot = $('#reply_comment_ot').val();
        var reply_pdate_ot=$('#reply_pdate_ot').val();
        var problem_reply_id_ot=$('#problem_reply_id_ot').val();
        var reply_userid_ot=$('#reply_userid_ot').val(); 	  
        var countermeasure_type_ot=$('#countermeasure_type_ot').val();
        var reply_type_ot=$('#reply_type_ot').val();
		var problem_id= $('#problem_id').val();
        
        //tombol
        var edit_ot=$('#edit_ot').val();

        if (trim(edit_ot)=='Save'){
            var cek = confirm('Are your sure to Save In this Reply Out Flow Temporary Action ?');
        } else {
            var cek = confirm('Are your sure to Edit In this Reply Out Flow Temporary Action ?'); 
        }
  
        if (cek) {
            $.post(
                '<?= site_url('t_sqa_dfct/update_ot') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
                {
                    reply_comment_ot : reply_comment_ot,
                    reply_pdate_ot : reply_pdate_ot,
                    problem_reply_id_ot : problem_reply_id_ot,
                    reply_userid_ot : reply_userid_ot,
                    countermeasure_type_ot : countermeasure_type_ot,
                    reply_type_ot :reply_type_ot,
                    app_pdate_ot : app_pdate_ot,
                    edit_ot : edit_ot,
                    problem_id: problem_id
                },
                function(html){
                    alert(html);
                    location.reload();
                    //$('#investigasi').html(html);
            });
        }
    }

    function btn_approve_ot() {
        var reply_pdate_ot=$('#reply_pdate_ot').val();
        var problem_reply_id_ot=$('#problem_reply_id_ot').val();
        var reply_userid_ot=$('#reply_userid_ot').val(); 	  
        var countermeasure_type_ot=$('#countermeasure_type_ot').val();
        var reply_type_ot=$('#reply_type_ot').val();
        var app_pdate_ot= $('#app_pdate').val();
		var problem_id= $('#problem_id').val();
        //tombol
        var approved_ot=$('#approved_ot').val();
        var cek = confirm('Are your sure to Approve In this Reply Out Flow Temporary Action ?');
        if (cek) {
            $.post(
            '<?= site_url('t_sqa_dfct/update_ot') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                problem_reply_id_ot : problem_reply_id_ot,
                reply_userid_ot : reply_userid_ot,
                countermeasure_type_ot : countermeasure_type_ot,
                reply_pdate_ot : reply_pdate_ot,
                approved_ot : approved_ot,
                app_pdate_ot : app_pdate_ot,
                reply_type_ot : reply_type_ot,
				problem_id : problem_id
            },
            function(html){
                alert(html);
                location.reload();
                //$('#investigasi').html(html);
            })
        }
    }

    function btn_unapprove_ot() { 
        var reply_pdate_ot=$('#reply_pdate_ot').val();
        var problem_reply_id_ot=$('#problem_reply_id_ot').val();
        var reply_userid_ot=$('#reply_userid_ot').val(); 	  
        var countermeasure_type_ot=$('#countermeasure_type_ot').val();
        var reply_type_ot=$('#reply_type_ot').val();
        var app_pdate_ot= $('#app_pdate').val();
        //tombol
        var unapproved_ot=$('#unapproved_ot').val();
		var problem_id= $('#problem_id').val();
        var cek = confirm('Are your sure to Cancel Approve In this Reply Out Flow Temporary Action ?');
        if (cek) {
            $.post(
            '<?= site_url('t_sqa_dfct/update_ot') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                problem_reply_id_ot : problem_reply_id_ot,
                reply_userid_ot : reply_userid_ot,
                countermeasure_type_ot : countermeasure_type_ot,
                reply_pdate_ot : reply_pdate_ot,
                unapproved_ot : unapproved_ot,
                app_pdate_ot : app_pdate_ot,
                reply_type_ot : reply_type_ot,
				problem_id  : problem_id
            },
            function(html){
                alert(html);
                location.reload();
                //$('#investigasi').html(html);
            })
	
        }
    }

    /* ---------------------------- OF --------------------------------- */ 

    function btn_edit_of() { 
        var app_pdate_of= $('#app_pdate').val();
        var reply_comment_of = $('#reply_comment_of').val();
        var reply_pdate_of=$('#reply_pdate_of').val();
        var problem_reply_id_of=$('#problem_reply_id_of').val();
        var reply_userid_of=$('#reply_userid_of').val(); 	  
        var countermeasure_type_of=$('#countermeasure_type_of').val();
        var reply_type_of=$('#reply_type_of').val();
		var problem_id=$('#problem_id').val();
        //tombol
        var edit_of=$('#edit_of').val();

        if (trim(edit_of)=='Save'){
            var cek = confirm('Are your sure to Save In this Reply Out Flow Fix Action ?');
        }
        else{
            var cek = confirm('Are your sure to Edit In this Reply Out Flow Fix Action ?'); 
        }

        if (cek) {

            $.post(
            '<?= site_url('t_sqa_dfct/update_of') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                reply_comment_of : reply_comment_of,
                reply_pdate_of : reply_pdate_of,
                problem_reply_id_of : problem_reply_id_of,
                reply_userid_of : reply_userid_of,
                countermeasure_type_of : countermeasure_type_of,
                reply_type_of :reply_type_of,
                app_pdate_of : app_pdate_of,
                edit_of : edit_of,
				problem_id:problem_id
            },
            function(html){
                alert(html);
                location.reload();
                //$('#investigasi').html(html);
            });
        }
    }

    function btn_approve_of() {
        var reply_pdate_of=$('#reply_pdate_of').val();
        var problem_reply_id_of=$('#problem_reply_id_of').val();
        var reply_userid_of=$('#reply_userid_of').val(); 	  
        var countermeasure_type_of=$('#countermeasure_type_of').val();
        var reply_type_of=$('#reply_type_of').val();
		var problem_id= $('#problem_id').val();
        var app_pdate_of= $('#app_pdate').val();
        //tombol
        var approved_of=$('#approved_of').val();
        var cek = confirm('Are your sure to Approve In this Reply Out Flow Fix Action ?');
        if (cek) {
            $.post(
            '<?= site_url('t_sqa_dfct/update_of') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                problem_reply_id_of : problem_reply_id_of,
                reply_userid_of : reply_userid_of,
                countermeasure_type_of : countermeasure_type_of,
                reply_pdate_of : reply_pdate_of,
                approved_of : approved_of,
                app_pdate_of : app_pdate_of,
                reply_type_of : reply_type_of,
				problem_id : problem_id
            },
            function(html){
                alert(html);
                location.reload();
                //$('#investigasi').html(html);
            });
        }
    }

    function btn_unapprove_of() { 
        var reply_pdate_of=$('#reply_pdate_of').val();
        var problem_reply_id_of=$('#problem_reply_id_of').val();
        var reply_userid_of=$('#reply_userid_of').val(); 	  
        var countermeasure_type_of=$('#countermeasure_type_of').val();
        var reply_type_of=$('#reply_type_of').val();
        var app_pdate_of= $('#app_pdate').val();
		var problem_id= $('#problem_id').val();
        //tombol
        var unapproved_of=$('#unapproved_of').val();
        var cek = confirm('Are your sure to Cancel Approve In this Reply Out Flow Fix Action ?');
        if (cek) {
            $.post(
            '<?= site_url('t_sqa_dfct/update_of') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                problem_reply_id_of : problem_reply_id_of,
                reply_userid_of : reply_userid_of,
                countermeasure_type_of : countermeasure_type_of,
                reply_pdate_of : reply_pdate_of,
                unapproved_of : unapproved_of,
                app_pdate_of : app_pdate_of,
                reply_type_of : reply_type_of,
				problem_id : problem_id
            },
            function(html){
                alert(html);
                location.reload();
                //$('#investigasi').html(html);
            });
        }
    }

    /* ---------------------------- RT --------------------------------- */
    
    function btn_edit_rt() { 
        var app_pdate_rt= $('#app_pdate').val();
        var reply_comment_rt = $('#reply_comment_rt').val();
        var reply_pdate_rt=$('#reply_pdate_rt').val();
        var problem_reply_id_rt=$('#problem_reply_id_rt').val();
        var reply_userid_rt=$('#reply_userid_rt').val(); 	  
        var countermeasure_type_rt=$('#countermeasure_type_rt').val();
        var reply_type_rt=$('#reply_type_rt').val();
		var problem_id=$('#problem_id').val();
        //tombol
        var edit_rt=$('#edit_rt').val();
        if (trim(edit_rt)=='Save'){
            var cek = confirm('Are your sure to Save In this Reply Occure Temporary Action ?');
        }
        else{
            var cek = confirm('Are your sure to Edit In this Reply Occure Temporary Action ?'); 
        }

        if (cek) {

            $.post(
            '<?= site_url('t_sqa_dfct/update_rt') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                reply_comment_rt : reply_comment_rt,
                reply_pdate_rt : reply_pdate_rt,
                problem_reply_id_rt : problem_reply_id_rt,
                reply_userid_rt : reply_userid_rt,
                countermeasure_type_rt : countermeasure_type_rt,
                reply_type_rt :reply_type_rt,
                app_pdate_rt : app_pdate_rt,
                edit_rt : edit_rt,
				problem_id: problem_id
            },
            function(html){  
                alert(html);
                location.reload();
                //$('#investigasi').html(html);                
            });
        }
    }

    function btn_approve_rt() { 
        var reply_pdate_rt=$('#reply_pdate_rt').val();
        var problem_reply_id_rt=$('#problem_reply_id_rt').val();
        var reply_userid_rt=$('#reply_userid_rt').val(); 	  
        var countermeasure_type_rt=$('#countermeasure_type_rt').val();
        var reply_type_rt=$('#reply_type_rt').val();
        var app_pdate_rt= $('#app_pdate').val();
		var problem_id= $('#problem_id').val();
        //tombol
        var approved_rt=$('#approved_rt').val();
        var cek = confirm('Are your sure to Approve In this Reply Occure Temporary Action ?');
        if (cek) {

            $.post(
            '<?= site_url('t_sqa_dfct/update_rt') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                problem_reply_id_rt : problem_reply_id_rt,
                reply_userid_rt : reply_userid_rt,
                countermeasure_type_rt : countermeasure_type_rt,
                reply_pdate_rt : reply_pdate_rt,
                approved_rt : approved_rt,
                app_pdate_rt : app_pdate_rt,
                reply_type_rt : reply_type_rt,
				problem_id  : problem_id
            },
            function(html){
                alert(html);
                location.reload();
                //$('#investigasi').html(html);
            });
        }
    }

    function btn_unapprove_rt() { 
        var reply_pdate_rt=$('#reply_pdate_rt').val();
        var problem_reply_id_rt=$('#problem_reply_id_rt').val();
        var reply_userid_rt=$('#reply_userid_rt').val(); 	  
        var countermeasure_type_rt=$('#countermeasure_type_rt').val();
        var reply_type_rt=$('#reply_type_rt').val();
        var app_pdate_rt= $('#app_pdate').val();
		var problem_id= $('#problem_id').val();
        //tombol
        var unapproved_rt=$('#unapproved_rt').val();
        var cek = confirm('Are your sure to Cancel Approve In this Reply Occure Temporary Action ?');
        if (cek) {

            $.post(
            '<?= site_url('t_sqa_dfct/update_rt') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                problem_reply_id_rt : problem_reply_id_rt,
                reply_userid_rt : reply_userid_rt,
                countermeasure_type_rt : countermeasure_type_rt,
                reply_pdate_rt : reply_pdate_rt,
                unapproved_rt : unapproved_rt,
                app_pdate_rt : app_pdate_rt,
                reply_type_rt : reply_type_rt,
				problem_id : problem_id
            },
            function(html){
                alert(html);
                location.reload();
                //$('#investigasi').html(html);
            })
        }
    }

    /* ---------------------------- RF --------------------------------- */
    function btn_edit_rf() { 
        var app_pdate_rf= $('#app_pdate').val();
        var reply_comment_rf = $('#reply_comment_rf').val();
        var reply_pdate_rf=$('#reply_pdate_rf').val();
        var problem_reply_id_rf=$('#problem_reply_id_rf').val();
        var reply_userid_rf=$('#reply_userid_rf').val(); 	  
        var countermeasure_type_rf=$('#countermeasure_type_rf').val();
        var reply_type_rf=$('#reply_type_rf').val();
		var problem_id=$('#problem_id').val();
        //tombol
        var edit_rf=$('#edit_rf').val();
        if (trim(edit_rf)=='Save'){
            var cek = confirm('Are your sure to Save In this Reply Occure Fix Action ?');
        }
        else{
            var cek = confirm('Are your sure to Edit In this Reply Occure Fix Action ?'); 
        }

        if (cek) {

            $.post(
            '<?= site_url('t_sqa_dfct/update_rf') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                reply_comment_rf : reply_comment_rf,
                reply_pdate_rf : reply_pdate_rf,
                problem_reply_id_rf : problem_reply_id_rf,
                reply_userid_rf : reply_userid_rf,
                countermeasure_type_rf : countermeasure_type_rf,
                reply_type_rf :reply_type_rf,
                app_pdate_rf : app_pdate_rf,
                edit_rf : edit_rf,
				problem_id: problem_id
            },
            function(html){
                alert(html);
                location.reload();
                //$('#investigasi').html(html);
            });
        }
    }

    function btn_approve_rf() { 
        var reply_pdate_rf=$('#reply_pdate_rf').val();
        var problem_reply_id_rf=$('#problem_reply_id_rf').val();
        var reply_userid_rf=$('#reply_userid_rf').val(); 	  
        var countermeasure_type_rf=$('#countermeasure_type_rf').val();
        var reply_type_rf=$('#reply_type_rf').val();
        var app_pdate_rf= $('#app_pdate').val();
		var problem_id= $('#problem_id').val();
        //tombol
        var approved_rf=$('#approved_rf').val();
        var cek = confirm('Are your sure to Approve In this Reply Occure Fix Action ?');
        if (cek) {

            $.post(
            '<?= site_url('t_sqa_dfct/update_rf') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                problem_reply_id_rf : problem_reply_id_rf,
                reply_userid_rf : reply_userid_rf,
                countermeasure_type_rf : countermeasure_type_rf,
                reply_pdate_rf : reply_pdate_rf,
                approved_rf : approved_rf,
                app_pdate_rf : app_pdate_rf,
                reply_type_rf : reply_type_rf,
				problem_id : problem_id
            },
            function(html){
                alert(html);
                location.reload();
                //$('#investigasi').html(html);
            });
        }
    }

    function btn_unapprove_rf() {
        var reply_pdate_rf=$('#reply_pdate_rf').val();
        var problem_reply_id_rf=$('#problem_reply_id_rf').val();
        var reply_userid_rf=$('#reply_userid_rf').val(); 	  
        var countermeasure_type_rf=$('#countermeasure_type_rf').val();
        var reply_type_rf=$('#reply_type_rf').val();
        var app_pdate_rf= $('#app_pdate').val();
		var problem_id= $('#problem_id').val();
        //tombol
        var unapproved_rf=$('#unapproved_rf').val();
        var cek = confirm('Are your sure to Cancel Approve In this Reply Occure Fix Action ?');
        if (cek) {

            $.post(
            '<?= site_url('t_sqa_dfct/update_rf') ?>' + '/' + problem_id + '/<?=$this->uri->segment(4)?>',
            {
                problem_reply_id_rf : problem_reply_id_rf,
                reply_userid_rf : reply_userid_rf,
                countermeasure_type_rf : countermeasure_type_rf,
                reply_pdate_rf : reply_pdate_rf,
                unapproved_rf : unapproved_rf,
                app_pdate_rf : app_pdate_rf,
                reply_type_rf : reply_type_rf,
				problem_id : problem_id
            },
            function(html){
                alert(html);
                location.reload();
                //$('#investigasi').html(html);
            });
        }
    }
</script>

    <input type="hidden" id="app_pdate" name="app_pdate" value="<?= $app_pdate; //T-SQA_DFCT  ?>" /> 
    <input type="hidden" id="reply_pdate_ot" name="reply_pdate_ot" value="<?= $reply_pdate; ?>" />
    <input type="hidden" id="problem_id" name="problem_id" value="<?= $problem_id; ?>" />
    <input type="hidden" id="reply_userid_ot" name="reply_userid_ot" value="<?= $pln_user; ?>" />
    <input type="hidden" id="reply_pdate_of" name="reply_pdate_of" value="<?= $reply_pdate; ?>" />
    <input type="hidden" id="reply_userid_of" name="reply_userid_of" value="<?= $pln_user; ?>" />
    <input type="hidden" id="reply_pdate_rt" name="reply_pdate_rt" value="<?= $reply_pdate; ?>">
    <input type="hidden" id="reply_userid_rt" name="reply_userid_rt" value="<?= $pln_user; ?>">
    <input type="hidden" id="reply_pdate_rf" name="reply_pdate_rf" value="<?= $reply_pdate; ?>">
    <input type="hidden" id="reply_userid_rf" name="reply_userid_rf" value="<?= $pln_user; ?>">

    <?php
    $shop_nm = $shop_defect;// substr($shop_nm, 0, 1);
    foreach ($list_reply as $ii): 
        if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'T') {
            $reply_id_ot = $ii->PROBLEM_REPLY_ID;
            $app_pdate_reply_ot = $ii->APPROVE_PDATE;
            $reply_type_ot = 'O';
            $countermeasure_type_ot = 'T';
            $shop_id_ot = $ii->SHOP_ID;
        } elseif ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'F') {
            $reply_id_of = $ii->PROBLEM_REPLY_ID;
            $app_pdate_reply_of = $ii->APPROVE_PDATE;
            $reply_type_of = 'O';
            $countermeasure_type_of = 'F';
            $shop_id_of = $ii->SHOP_ID;
        } elseif ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'T') {
            $reply_id_rt = $ii->PROBLEM_REPLY_ID;
            $app_pdate_reply_rt = $ii->APPROVE_PDATE;
            $reply_type_rt = 'R';
            $countermeasure_type_rt = 'T';
            $shop_id_rt = $ii->SHOP_ID;
        } elseif ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'F') {
            $reply_id_rf = $ii->PROBLEM_REPLY_ID;
            $app_pdate_reply_rf = $ii->APPROVE_PDATE;
            $reply_type_rf = 'R';
            $countermeasure_type_rf = 'F';
            $shop_id_rf = $ii->SHOP_ID;
            
        }
    endforeach;
    ?>
    <input type="hidden" id="problem_reply_id_ot" name="problem_reply_id_ot" value="<?= $reply_id_ot; ?>" />
    <input type="hidden" id="problem_reply_id_of" name="problem_reply_id_of" value="<?= $reply_id_of; ?>" />
    <input type="hidden" id="problem_reply_id_rt" name="problem_reply_id_rt" value="<?= $reply_id_rt; ?>" />
    <input type="hidden" id="problem_reply_id_rf" name="problem_reply_id_rf" value="<?= $reply_id_rf; ?>" />

    <input type="hidden" id="reply_type_ot" name="reply_type_ot" value="<?= $reply_type_ot; ?>" />
    <input type="hidden" id="reply_type_of" name="reply_type_of" value="<?= $reply_type_of; ?>" />
    <input type="hidden" id="reply_type_rt" name="reply_type_rt" value="<?= $reply_type_rt; ?>" />
    <input type="hidden" id="reply_type_rf" name="reply_type_rf" value="<?= $reply_type_rf; ?>" />

    <input type="hidden" id="countermeasure_type_ot" name="countermeasure_type_ot" value="<?= $countermeasure_type_ot; ?>" />
    <input type="hidden" id="countermeasure_type_of" name="countermeasure_type_of" value="<?= $countermeasure_type_of; ?>" />
    <input type="hidden" id="countermeasure_type_rt" name="countermeasure_type_rt" value="<?= $countermeasure_type_rt; ?>" />
    <input type="hidden" id="countermeasure_type_rf" name="countermeasure_type_rf" value="<?= $countermeasure_type_rf; ?>" />

    <div  style="margin-top:5px;width:170px;background:#CCCCCC; font-weight:bold">
        <center>INVESTIGATION RESULT</center>
    </div>
    
    <div style="height:570px; border:1px solid #CCCCCC ">
        <div id="OT">
            <div style="margin-left:5px;width:900px;float:left">1. Why Outflow</div>
            <div style="margin-left:18px;width:320px;float:left">a. Temporary Action</div>
            <div style="width:300px;float:left">Due Date :&nbsp;<?php foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'T') : echo date('d-M-Y', strtotime($ii->DUE_DATE)); endif; endforeach; ?></div>
            <div style="width:160px;float:left">Status :&nbsp;
                <?php
                foreach ($list_reply as $ii):
                    if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'T') {
                        if ($ii->APPROVE_SYSDATE == '') {
                            echo "Not Yet Reply";
                        } else {
                            $approve_sysdate = date('Y-m-d', strtotime($ii->APPROVE_SYSDATE));
                            $due_date = date('Y-m-d', strtotime($ii->DUE_DATE));
                    
                            if ($approve_sysdate > $due_date) {
                                echo "Delay";
                            } elseif ($approve_sysdate <= $due_date) {
                                echo "On Time";
                            }
                        }
                    }
                endforeach;
                ?>
            </div> 
            <table width="96%" border="0" style="margin-left:12px">
                <form  style="margin-left:12px" name="why_outflow" method="post" action="">
                    <tr>
                        <td colspan="10">
                            <label>
                                <?php
                                $reply_comm_ot = '';
                                foreach ($list_reply as $ii): 
                                    if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'T') {
                                        $reply_comm_ot = $ii->REPLY_COMMENT;                                        
                                    }
                                endforeach; ?>
                            
                                <textarea name="reply_comment_ot" cols="115" rows="2" id="reply_comment_ot"
                                    <?=($insp_item_flg_status=='0' || $close_flg == '1' || 
                                            $is_deleted == '1' || $app_pdate_reply_ot != '' || 
                                            ($shop_user != 'IN' && $shop_user != 'AL')
                                            )?'disabled="disabled"':'';?>
                                ><?=$reply_comm_ot?></textarea>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td width="19" nowrap="nowrap" style="margin-left:25px">&nbsp;</td>
                        <td width="101" nowrap="nowrap" style="margin-left:25px">
                            Created by <br />
                            Last Edited by<br />
                        </td>
                        <td width="0">:&nbsp;<br />
                            :&nbsp;</td>
                        <td width="223" nowrap="nowrap">
                            <?php foreach ($list_reply as $ii): 
                                    if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'T' && 
                                        $ii->REPLY_SYSDATE!='') {
                                        echo $ii->REPLY_USERID . ' - ' . date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));
                                } 
                            endforeach; ?>
                            <br />
                            <?php foreach ($list_reply as $ii): 
                                    if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'T' && $ii->updatedt !='') {
                                        echo $ii->Updateby . ' - ' . date('d/m/Y h:i A', strtotime($ii->updatedt));
                                    } 
                                endforeach; ?>
                            <br />
                        </td>
                        <td width="81" nowrap="nowrap">Approved by</td>
                        <td width="7">:&nbsp;</td>
                        <td width="372"><? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'T' && $ii->APPROVE_SYSDATE !='') {
                                    echo $ii->APPROVED_BY . ' - ' . date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));
                                } endforeach; ?></td>
                    <div class="buttonreg2">
                        <td width="105" align="right">
                            <input <? if ($insp_item_flg_status=='0'||$close_flg == '1' || $is_deleted == '1' || $app_pdate_reply_ot != '' || ($shop_user != 'IN' && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?> class="button button-gray" type ='button'  name='edit_ot' id='edit_ot' 
                            <? if ($reply_comm_ot == '') {
                                echo 'value="Save"';
                            } else {
                                echo 'value="Edit"';
                            } ?>  onclick="btn_edit_ot()" style="width: 120px;" /></td>
                        <td width="95" align="right">
                            <a href="<?= site_url('t_sqa_dfct/upload_attch_reply/' . $reply_id_ot) ?>" class="view_detail"> <input <? if ($insp_item_flg_status=='0'||$close_flg == '1' || $is_deleted == '1' || $app_pdate_reply_ot != '' || ($shop_user != 'IN' && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?> class="button button-gray" type="button" name="edit10" id="edit10" value="Upload Attach"  /></a><br />
                            			</td>
                        <td width="108" align="right">
                            <?php               
                            $btn_status = (
                                            $insp_item_flg_status != '0' && 
                                            $close_flg == '1' || 
                                            $is_deleted == '1' ||
                                            ($user_grpauth == '01' || $user_grpauth == '02' || $user_grpauth == '03') && 
                                            ($shop_user != 'AL')
                                        );
                            //echo $insp_item_flg_status . ',' . $close_flg . ',' . $is_deleted . ',' . $user_grpauth . ',' . $shop_user . ',' . $app_pdate_reply_ot;
                            if ($app_pdate_reply_ot == '') : ?>    
                                <input <?=(!$btn_status) ? '' : 'disabled'?> class="button button-gray" type="button"  name="approved_ot" id="approved_ot" value="Approved" onclick="btn_approve_ot()" style="width: 120px;" />
                            <?php elseif ($app_pdate_reply_ot != '') : ?>
                                <input <?=(!$btn_status) ? '' : 'disabled'?>  class="button button-gray" type="button"  name="unapproved_ot" id="unapproved_ot" value="Cancel Approved" onclick="btn_unapprove_ot()" style="width: 120px;" />
                            <?php endif;  ?>
                        </td>
                    </div>
                    </tr>
                </form>
            </table>
        </div>
        <br/>
        <div style="margin-left:18px;width:320px;float:left;">b. Fix Action</div>
        <div style="width:300px;float:left">Due Date :&nbsp;<? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'F') {
                    echo date('d-M-Y', strtotime($ii->DUE_DATE));
                } endforeach; ?></div>
        <div style="width:140px;float:left">Status :&nbsp;
<?
foreach ($list_reply as $ii):
    if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'F') {
        if ($ii->APPROVE_SYSDATE == '') {
            echo "Not Yet Reply";
        } else {
            $approve_sysdate = date('Y-m-d', strtotime($ii->APPROVE_SYSDATE));
            $due_date = date('Y-m-d', strtotime($ii->DUE_DATE));
            
            if ($approve_sysdate > $due_date) {
                echo "Delay";
            } elseif ($approve_sysdate <= $due_date) {
                echo "On Time";
            }
        }
    }
endforeach;
?></div>
        <table width="96%" border="0" style="margin-left:12px">
            <form  style="margin-left:12px" name="form1" method="post" action="">
                <tr>
                    <td colspan="10"><label>
                            <textarea <? if ($insp_item_flg_status=='0'||$close_flg == '1' || $is_deleted == '1' || $app_pdate_reply_of != '' || ($shop_user != 'IN' && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?> rows="2" cols="115" id="reply_comment_of"><? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'F') {
        $reply_comm_of = $ii->REPLY_COMMENT;
        echo $reply_comm_of;
    } endforeach; ?></textarea>
                        </label></td>
                </tr>
                <tr>
                    <td width="19" nowrap style="margin-left:25px">&nbsp;</td>
                    <td width="101" nowrap="nowrap" style="margin-left:25px">Created by <br />
                        Last Edited by<br /></td>
                    <td width="0">:&nbsp;<br />
                        :&nbsp;</td>
                    <td width="255" nowrap="nowrap"><? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'F' && $ii->REPLY_SYSDATE !='') {
                                echo $ii->REPLY_USERID . ' - ' . date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));
                            } endforeach; ?>
                        <br />
<? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'F' && $ii->updatedt != '') {
        echo $ii->Updateby . ' - ' . date('d/m/Y h:i A', strtotime($ii->updatedt));
    } endforeach; ?></td>
                    <td width="81" nowrap>Approved by</td>
                    <td width="7">:&nbsp;</td>
                    <td width="367"><? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'O' && $ii->COUNTERMEASURE_TYPE == 'F' && $ii->APPROVE_SYSDATE !='') {
        echo $ii->APPROVED_BY . ' - ' . date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));
    } endforeach; ?></td>
                <div class="buttonreg2">
                    <td align="right" width="105">
                        <input <? if ($insp_item_flg_status=='0'||$close_flg == '1' || $is_deleted == '1' || $app_pdate_reply_of != '' || ($shop_user != 'IN' && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?> class="button button-gray" type ='button'  name='edit_of' id='edit_of' <? if ($reply_comm_of == '') {
                            echo 'value="Save"';
                        } else {
                            echo 'value="Edit"';
                        } ?> onclick="btn_edit_of()" style="width: 120px;" />
                </td>
                    <td align="right" width="95"><a href="<?= site_url('t_sqa_dfct/upload_attch_reply/' . $reply_id_of) ?>" class="view_detail"> <input <? if ($insp_item_flg_status=='0'||$close_flg == '1' || $is_deleted == '1' || $app_pdate_reply_of != '' || ($shop_user != 'IN' && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?> class="button button-gray" type="button" name="edit10" id="edit10" value="Upload Attach"  /></a></td>
                    <td width="109" align="right">
                        <?php                        
                        $btn_status = (
                                            $insp_item_flg_status != '0' && 
                                            $close_flg == '1' || 
                                            $is_deleted == '1' || 
                                            ($user_grpauth == '01' || $user_grpauth == '02' || $user_grpauth == '03') && 
                                            ($shop_user != 'AL') 
                                        );
                                        
                        if ($app_pdate_reply_of == '') : ?>    
                            <input <?=(!$btn_status)?'':'disabled'?> class="button button-gray" type="button"  name="approved_of" id="approved_of" value="Approved" onclick="btn_approve_of()" style="width: 120px;" />
                        <?php elseif ($app_pdate_reply_of != '') : ?>
                            <input <?=(!$btn_status)?'':'disabled'?>  class="button button-gray" type="button"  name="unapproved_of" id="unapproved_of" value="Cancel Approved" onclick="btn_unapprove_of()" style="width: 120px;" />
                        <?php endif;  ?>
                    </td>
                </div>
                </tr>
            </form>
        </table>
        <br />
        <div style="margin-left:5px;width:1000px;float:left">2. Why Occure</div>
        <div style="margin-left:18px;width:320px;float:left">a. Temporary Action</div>
        <div style="width:300px;float:left">Due Date :&nbsp;<? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'T') {
                    echo date('d-M-Y', strtotime($ii->DUE_DATE));
                } endforeach; ?></div>
        <div style="width:140px;float:left">Status :&nbsp;
                        <?
                        foreach ($list_reply as $ii):
                            if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'T') {
                                if ($ii->APPROVE_SYSDATE == '') {
                                    echo "Not Yet Reply";
                                } else {
                                    $approve_sysdate = date('Y-m-d', strtotime($ii->APPROVE_SYSDATE));
                                    $due_date = date('Y-m-d', strtotime($ii->DUE_DATE));
                                    
                                    if ($approve_sysdate > $due_date) {
                                        echo "Delay";
                                    } elseif ($approve_sysdate <= $due_date) {
                                        echo "On Time";
                                    }
                                }
                            }
                        endforeach;
                        ?></div>
        <table width="96%" border="0" style="margin-left:12px">
            <form  style="margin-left:12px" name="why_outflow" method="post" action="">
                <tr>
                    <td colspan="10"><label>
                            <textarea <? if ($close_flg == '1' || $is_deleted == '1' || $app_pdate_reply_rt != '' || ($user_grpauth != '09' || $user_grpauth != '08' || $user_grpauth != '01') && ($shop_user != $shop_nm && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?> name="reply_comment_rt" cols="115" rows="2"  id="reply_comment_rt"><? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'T') {
                                $reply_comm_rt = $ii->REPLY_COMMENT;
                                echo $reply_comm_rt;
                            } endforeach; ?></textarea>
                        </label></td>
                </tr>
                <tr>
                    <td width="19" nowrap="nowrap" style="margin-left:25px">&nbsp;</td>
                    <td width="101" nowrap="nowrap" style="margin-left:25px">Created by <br />Last Edited by<br /></td>
                    <td width="0">:&nbsp;<br />:&nbsp;</td>
                    <td width="225" nowrap="nowrap"><? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'T' && $ii->REPLY_SYSDATE !='') {
                                echo $ii->REPLY_USERID . ' - ' . date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));
                            } endforeach; ?>
                        <br />
            <? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'T' && $ii->updatedt !='') {
                    echo $ii->Updateby . ' - ' . date('d/m/Y h:i A', strtotime($ii->updatedt));
                } endforeach; ?></td>
                    <td width="81" nowrap>Approved by</td>
                    <td width="7">:&nbsp;</td>
                    <td width="367"><? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'T' && $ii->APPROVE_SYSDATE !='') {
                    echo $ii->APPROVED_BY . ' - ' . date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));
                } endforeach; ?></td>
                <div class="buttonreg2">
                    <td align="right" width="105">
                        <?php 
                        $btn_ed_disable_if = ($close_flg == '1') || ($is_deleted == '1') || ($app_pdate_reply_rt != '') || ($user_grpauth != '09' || $user_grpauth != '08' || $user_grpauth != '01') && ($shop_user != $shop_nm && $shop_user != 'AL'); ?>
                        <input 
                            <?=($btn_ed_disable_if)?'disabled="disabled"':''?> 
                            class="button button-gray" 
                            type ="button" 
                            name="edit_rt" id="edit_rt"
                            value="<?=($reply_comm_rt=='')?'Save':'Edit'?>"
                            onclick="btn_edit_rt()"
                            style="width: 120px;" />
                    </td>
                    <td align="right" width="95">
                        <a href="<?= site_url('t_sqa_dfct/upload_attch_reply/' . $reply_id_rt) ?>" class="view_detail"> 
                            <input <?=($btn_ed_disable_if)?'disabled="disabled"':''?>
                            class="button button-gray" 
                            type="button" 
                            name="edit10" 
                            id="edit10" 
                            value="Upload Attach" 
                            style="width: 120px;" />
                        </a>
                    </td>
                    <td align="right" width="106">
                            <?php  $btn_disable_if = ($close_flg == '1') || ($is_deleted == '1') || ($user_grpauth != '02' && $user_grpauth != '03') || ($shop_user != $shop_nm) && $shop_user != 'AL'; ?>
                            <?php if ($app_pdate_reply_rt == '') : ?> 
                            <input <?=($btn_disable_if)?'disabled="disabled"':''?> class="button button-gray" type="button" name="approved_of" id="approved_rt" value="Approved" onclick="btn_approve_rt()" style="width: 120px;" />
                            <?php else: ?>
                            <input <?=($btn_disable_if)?'disabled="disabled"':''?> class="button button-gray" type="button"  name="unapproved_rt" id="unapproved_rt" value="Cancel Approved" onclick="btn_unapprove_rt()" style="width: 120px;"/> 
                            <?php endif; ?></td>
                </div>
                </tr>
            </form>
        </table>
        <br/>
        <div style="margin-left:18px;width:320px;float:left;">b. Fix Action</div>
        <div style="width:300px;float:left">Due Date :&nbsp;<? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'F') {
                                echo date('d-M-Y', strtotime($ii->DUE_DATE));
                            } endforeach; ?></div>
        <div style="width:140px;float:left">Status :&nbsp;
                        <?
                        foreach ($list_reply as $ii):
                            if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'F') {
                                if ($ii->APPROVE_SYSDATE == '') {
                                    echo "Not Yet Reply";
                                } else {
                                    $approve_sysdate = date('Y-m-d', strtotime($ii->APPROVE_SYSDATE));
                                    $due_date = date('Y-m-d', strtotime($ii->DUE_DATE));
                                    
                                    if ($approve_sysdate > $due_date) {
                                        echo "Delay";
                                    } elseif ($approve_sysdate <= $due_date) {
                                        echo "On Time";
                                    }
                                }
                            }
                        endforeach;
                        ?></div>
        <table width="96%" border="0" style="margin-left:12px">
            <form  style="margin-left:12px" name="form1" method="post" action="">
                <tr>
                    <td colspan="10"><label>
                            <textarea <? if ($close_flg == '1' || $is_deleted == '1' || $app_pdate_reply_rf != '' || ($user_grpauth != '09' || $user_grpauth != '08' || $user_grpauth != '01') && ($shop_user != $shop_nm && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?>rows="2" cols="115" id="reply_comment_rf"  ><? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'F') {
                                $reply_comm_rf = $ii->REPLY_COMMENT;
                                echo $reply_comm_rf;
                            } endforeach; ?></textarea>
                        </label></td>
                </tr>
                <tr>
                    <td width="19" nowrap style="margin-left:25px">&nbsp;</td>
                    <td width="101" nowrap="nowrap" style="margin-left:25px">Created by <br />
                        Last Edited by<br /></td>
                    <td width="0">:&nbsp;<br />
                        :&nbsp;</td>
                    <td width="225" nowrap="nowrap"><? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'F' && $ii->REPLY_SYSDATE!='') {
                                echo $ii->REPLY_USERID . ' - ' . date('d/m/Y h:i A', strtotime($ii->REPLY_SYSDATE));
                            } endforeach; ?>
                        <br />
<? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'F' && $ii->updatedt!='') {
        echo $ii->Updateby . ' - ' . date('d/m/Y h:i A', strtotime($ii->updatedt));
    } endforeach; ?></td>
                    <td width="81" nowrap>Approved by</td>
                    <td width="7">:&nbsp;</td>
                    <td width="367"><? foreach ($list_reply as $ii): if ($ii->REPLY_TYPE == 'R' && $ii->COUNTERMEASURE_TYPE == 'F' && $ii->APPROVE_SYSDATE!='') {
        echo $ii->APPROVED_BY . ' - ' . date('d/m/Y h:i A', strtotime($ii->APPROVE_SYSDATE));
    } endforeach; ?></td>
                <div class="buttonreg2">
                    <td width="105" align="right"><input <? if ($close_flg == '1' || $is_deleted == '1' || $app_pdate_reply_rf != '' || ($user_grpauth != '09' || $user_grpauth != '08' || $user_grpauth != '01') && ($shop_user != $shop_nm && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?> class="button button-gray" type ='button'  name='edit_rf' id='edit_rf' <? if ($reply_comm_rf == '') {
    echo 'value="Save"';
} else {
    echo 'value="Edit"';
} ?> onclick="btn_edit_rf()" style="width: 120px;"/></td>
                    <td align="right" width="95"><a href="<?= site_url('t_sqa_dfct/upload_attch_reply/' . $reply_id_rf) ?>" class="view_detail"> <input <? if ($close_flg == '1' || $is_deleted == '1' || $app_pdate_reply_rf != '' || ($user_grpauth != '09' || $user_grpauth != '08' || $user_grpauth != '01') && ($shop_user != $shop_nm && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?> class="button button-gray" type="button" name="edit10" id="edit10" value="Upload Attach" style="width: 120px;" /></a></td>
                    <td align="right" width="106">
                        <?php  $btn_disable_if = ($close_flg == '1') || ($is_deleted == '1') || ($user_grpauth != '02' && $user_grpauth != '03') || ($shop_user != $shop_nm) && $shop_user != 'AL'; ?>
                        <?php if ($app_pdate_reply_rf == '') : ?>
                            <!--input <? if (($close_flg == '1') || ($is_deleted == '1') || ($user_grpauth != '02' || $user_grpauth != '03') && ($shop_user != $shop_nm && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?> class="button button-gray" type="button"  name="approved_rf" id="approved_rf" value="     Approved    " onclick="btn_approve_rf()" /-->
                            <input <?=($btn_disable_if)?'disabled="disabled"':''?> class="button button-gray" type="button"  name="approved_rf" id="approved_rf" value="Approved" onclick="btn_approve_rf()" style="width: 120px;" /> 
                        <?php else : ?>                                                        
                            <!--input <? if (($close_flg == '1') || ($is_deleted == '1') || ($user_grpauth != '02' || $user_grpauth != '03') && ($shop_user != $shop_nm && $shop_user != 'AL')) { ?>disabled='disabled' <? } ?> class="button button-gray" type="button"  name="unapproved_rf" id="unapproved_rf" value=" Cancel Approved " onclick="btn_unapprove_rf()" /--> 
                            <input <?=($btn_disable_if)?'disabled="disabled"':''?> class="button button-gray" type="button"  name="unapproved_rf" id="unapproved_rf" value="Cancel Approved" onclick="btn_unapprove_rf()" style="width: 120px" />
                        <?php endif; ?>
                    </td>
                </div>
                </tr>
            </form>
        </table>
    </div>
    <div style="margin-left:729px; margin-top:9px; margin-bottom:5px">
    
        <form action="<?= site_url('t_sqa_dfct/report_sqa/'.$problem_id) ?>" method="post">
            <input type="hidden" id="problem_id" name="problem_id" value="<?= $problem_id; ?>" />
            <input type="hidden" id="vinno" name="vinno" value="<?= $vinno; ?>" />
            <div class="buttonreg2">
                <input type="button" class="button button-gray" onclick="on_close_reply();" name="clos" id="clos" value="Close" />
                <input <? if ($close_flg == '1' || $is_deleted == '1') { ?>disabled='disabled' <? } ?> type="button" class="button button-gray" name="preview_report" id="preview_report" value="Preview Full Report" onclick="on_preview_report();" />
            </div>
        </form><br />
    </div>

</div>

<script type="text/javascript">
    $(function(){
        loadawal();
     });
 </script>