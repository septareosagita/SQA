<script type="text/javascript">
    function change_ctg_grp(ctg_id) {
        if ($('#ctg_grp_id').val() != '0') {
            $.post('<?= site_url('m_sqa_dfct/get_ctg') ?>', {ctg_grp_id:$('#ctg_grp_id').val(),ctg_id:ctg_id}, function(html){
                $('#ctg_id_panel').html(html);
            });
        } else {
            $('#ctg_id_panel').html('');
        }
    }
</script>

<div class="columns">
    <div class="column grid_6 first">
        <?php if ($err != ''): ?>
            <div class="message error"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widgetform">
                <header>    
                    <h2>DEFECT &raquo; <?= ucwords($todo); ?></h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>

                        <fieldset>
                            <dl>
                                <dd>
                                    <label>Defect ID</label>
                                    <input type="text" name="DFCT_ID" value="<?= $DFCT_ID ?>" size="5" <?= ($todo == 'EDIT') ? 'readonly="readonly"' : '' ?> />
                                </dd>
                                <dd>
                                    <label>Defect Name</label>
                                    <input type="text" name="DFCTNM" value="<?= $DFCTNM ?>" maxlength="100" size="50" />
                                </dd>                                
                                <dd>
                                    <label>Category</label>                                
                                    <select name="ctg_grp_id" onchange="change_ctg_grp(0)" id="ctg_grp_id" >
                                        <option value="0">-- Select Category Group --</option>
                                        <?php if (count($list_ctg_grp)): foreach ($list_ctg_grp as $l): ?>
                                        <option value="<?= $l->CTG_GRP_ID ?>" <?= ($l->CTG_GRP_ID == $CTG_GRP_ID) ? 'selected="selected"' : '' ?>><?= $l->CTG_GRP_NM ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </dd>
                                <dd id="ctg_id_panel"></dd>
                            </dl>
                            </fieldset>
                            <hr/>
                            <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                            <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_dfct/browse') ?>'"/>
                </form>
            </section></div></div></div>
<?php if ($todo=='EDIT'): ?>
<script type="text/javascript">
    $(function(){
        change_ctg_grp('<?=$CTG_ID?>');
    });
</script>
<?php endif; ?>