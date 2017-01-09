<script type="text/javascript">
    function on_load_dfct() {
        $('#id_dfct').val('');
        $('#detail_dfct').val('');
        $("#content_dfct").html("<img src='<?= base_url() ?>assets/style/images/loading-gif.gif' />");
        $.post(
            '<?=site_url('m_sqa_dfct/load_dfct')?>', 
            {
                s: $('#searchkey').val(), 
                ctg_grp_id_head : $('#ctg_grp_id_head').val(),
                ctg_grp_id : $('#ctg_grp_id').val(),
                ctg_id: $('#ctg_id').val()
            }, 
            function(html){
                $('#content_dfct').html(html);
                $('#btnEdit').attr('disabled', 'disabled');
                $('#btnAdd').attr('disabled', 'disabled');
            }
        );
    }
    
    function change_ctg_grp_head(ctg_grp_id, ctg_id_display) {        
        
        if ($('#ctg_grp_id_head').val() != '0') {
			$("#ctg_grp_id_panel").html("<img src='<?= base_url() ?>assets/style/images/loading-gif2.gif' />");
            $.post('<?=site_url('m_sqa_dfct/get_ctg_grp')?>',
                {
                    ctg_grp_id_head: $('#ctg_grp_id_head').val(),
                    ctg_grp_id: ctg_grp_id                    
                },
                function(html) {
                    $('#ctg_grp_id_panel').html(html);
                                        
                    if (ctg_id_display != '0' && ctg_id_display != '') {
                        change_ctg_grp(ctg_id_display);                        
                    } else {
                        $('#id_dfct').val('');
                        $('#detail_dfct').val('');
                        $('#btnEdit').attr('disabled', 'disabled');
                        
                        var html = "<select id='ctg_id' name='ctg_id'><option value='0'>-- All --</option></select>";
                        $('#ctg_id_panel').html(html);    
                    }                                        
                }
            );
        } else {
            var html = "<select id='ctg_grp_id' name='ctg_grp_id'><option value='0'>-- All --</option></select>";
            $('#ctg_grp_id_panel').html(html);
            var html = "<select id='ctg_id' name='ctg_id'><option value='0'>-- All --</option></select>";
            $('#ctg_id_panel').html(html);
        }
    }

    function change_ctg_grp(ctg_id, ctg_display) {
        
        if ($('#ctg_grp_id').val() != '0') {
			$("#ctg_id_panel").html("<img src='<?= base_url() ?>assets/style/images/loading-gif2.gif' />");
            $.post('<?= site_url('m_sqa_dfct/get_ctg') ?>', {ctg_grp_id:$('#ctg_grp_id').val(),ctg_id:ctg_id}, function(html){                
                $('#ctg_id_panel').html(html);
                
                if (ctg_display != '0' && ctg_display != '') {
                    // do nothin
                } else {
                    $('#id_dfct').val('');
                    $('#detail_dfct').val('');
                    $('#btnEdit').attr('disabled', 'disabled');
                    
                }
                
            });
        } else {
            var html = "<select id='ctg_id' name='ctg_id'><option value='0'>-- All --</option></select>";
            $('#ctg_id_panel').html(html);
        }
        check_btn_add();
    }

    function pick_to_list(dfct_id, dfctnm, ctg_grp_id, ctg_id, ctg_grp_nm) {
        var ctg_grp_id_head = ctg_grp_nm.substring(0,2);
        $('#ctg_grp_id_head').val(ctg_grp_id_head);
        change_ctg_grp_head(ctg_grp_id, ctg_id);
                
        $('#id_dfct').val(dfct_id);
        $('#detail_dfct').val(dfctnm);

        $('#btnEdit').removeAttr('disabled');
        $('#btnAdd').attr('disabled', 'disabled');
    }
    
    function check_btn_add() {
        if ($('#ctg_grp_id').val() != '0' && $('#ctg_id').val() != '0' && $('#detail_dfct').val() != '' && $('#id_dfct').val() == '') {
            $('#btnAdd').removeAttr('disabled');
        } else {
            $('#btnAdd').attr('disabled', 'disabled');
        }
    }
    
    function on_edit_dfct () {
        var id_dfct = $('#id_dfct').val();
        var detail_dfct = $('#detail_dfct').val();
        
        if (id_dfct != '' && detail_dfct != '') {
            $.post('<?=site_url('m_sqa_dfct/edit_dfct')?>', {id_dfct: id_dfct, detail_dfct: detail_dfct}, function(html){
                parent.pick_dfct(id_dfct);
            });
        }
    }
    
    function on_add_dfct() {
        if ($('#ctg_grp_id').val() != '0' && $('#ctg_id').val() != '0' && $('#detail_dfct').val() != '' && $('#id_dfct').val() == '') {
            $.post('<?=site_url('m_sqa_dfct/add_dfct')?>', 
                {                   
                   ctg_id : $('#ctg_id').val(), 
                   dfctnm : $('#detail_dfct').val(),
                   ctg_grp_id : $('#ctg_grp_id').val()
                },                 
                function(html){
                parent.pick_dfct(html);
            });
        }
    }
</script>
<div class="columns">
    <div class="column grid_8 first" style="width: 965px;">
            <div class="widget">
                <header>
                    <h2>DEFECT &raquo; INQUIRY</h2>                    
                </header>
                <section>
                    <table width="100%">
                        <tr>
                            <td width="18%" height="32">Category Group</td>
                            <td width="1%">:</td>
                            <td width="73%">
                                <?php 
                                    
                                    $arr_g = array();
                                    foreach ($list_ctg_grp_header as $l) {
                                        array_push($arr_g, str_replace('.','',$l->grp_head));
                                    }
                                    natsort($arr_g);
                                    
                                ?>
                            
                                <select name="ctg_grp_id_head" id="ctg_grp_id_head" onchange="change_ctg_grp_head(0)">
                                    <option value="0">-- All --</option>
                                    <?php
                                    
                                    foreach ($arr_g as $l): ?>
                                    <option value="<?=$l?>"><?=$l?></option>
                                    <?php endforeach; ?>
                                </select>
                                
                                <span id="ctg_grp_id_panel">
                                <select name="ctg_grp_id" id="ctg_grp_id" onchange="change_ctg_grp(0)">
                                    <option value="0">-- All --</option>
                                </select>
                                </span>                        
                            </td>
                            <td width="8%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="32">Category Name</td>
                            <td>:</td>
                            <td id="ctg_id_panel">
                                <select name="ctg_id" id="ctg_id">
                                    <option value="0">-- All --</option>
                                </select>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Keyword</td>
                            <td>:</td>
                            <td><input type="text" name="searchkey" value="" size="70" id="searchkey" />
                                <input type="button" name="button" id="button" value="Search" class="button button-gray" onclick="on_load_dfct()"/></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                    <br/>
                    <table class="data" width="100%">                        
                        <tr>
                            <th width="40">&nbsp;</th>
                            <th width="50">ID</th>
                            <th width="300">Defect Name</th>
                            <th width="220">Category Group</th>
                            <th>Category</th>
                        </tr>
                    </table>
                    <div id="content_dfct" style="height: 200px; width: auto; overflow: scroll">

                    </div>
                    <table width="100%">
                        <tr>
                            <td>Select Defect</td>
                        </tr>
                        <tr>
                            <td>                                
                                <input type="text" name="id_dfct" id="id_dfct" value="" size="3" />
                                <input type="text" name="detail_dfct" id="detail_dfct" value="" size="50" maxlength="100" onkeyup="check_btn_add()" />
                                <input type="button" name="btnEdit" id="btnEdit" value="Edit" class="button button-gray" onclick="on_edit_dfct()"/>
                                <input type="button" name="btnAdd" id="btnAdd" value="Add" class="button button-gray" onclick="on_add_dfct()"/>
                            </td>
                        </tr>
                    </table>
                </section>  
            </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#searchkey').focus();
        $('#searchkey').val(parent.get_dfct_val());
        on_load_dfct();        
    });
</script>
