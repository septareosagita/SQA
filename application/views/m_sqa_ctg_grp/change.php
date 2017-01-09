<div class="columns">
    <div class="column grid_6 first">
        <?php if ($err != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widgetform">
                <header>
                    <h2><?= ucwords($todo); ?> CATEGORY GROUP</h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>
                        <input type="hidden" name="Updateby" value="<?= $Updateby ?>" />
                        <input type="hidden" name="Updatedt" value="<?= $Updatedt ?>" />
                        <input type="hidden" name="CTG_GRP_ID" value="<?= $CTG_GRP_ID ?>" readonly="readonly" />
                        <fieldset>
                            <dl>
                                <dd>
                                    <label>Category Group Name</label>
                                    <input type="text" name="CTG_GRP_NM" value="<?= $CTG_GRP_NM ?>" maxlength="100" size="50" <?=($todo=='EDIT')?'readonly="readonly"':''?> />
                                </dd>
                                <dd>
                                    <label>Category Group Decription : </label>
                                    <textarea cols="50" rows="5" name="CTG_GRP_DESC"><?=$CTG_GRP_DESC?></textarea>                                    
                                </dd>
                                <dd>
                                    <label>Valid From</label>
                                    <input type="text" name="VALID_FROM" id="VALID_FROM" value="<?= conv_date(2, $VALID_FROM) ?>" size="8" />
                                    <label>Valid To</label>
                                    <input type="text" name="VALID_TO" id="VALID_TO" value="<?= conv_date(2, $VALID_TO) ?>" size="8" />
                                </dd>
                            </dl>
                        </fieldset>
                        <hr/>                        
                        <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_ctg_grp/browse') ?>'"/>
                        <?php if ($todo == 'ADD'): ?>
                        <!--input type="checkbox" name="check_insert" value="1" /> Insert Another Row-->
                        <?php endif; ?>
                </form></section></div></div></div>

<script type="text/javascript">
    $(function(){
        $("#VALID_FROM").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
        $("#VALID_TO").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
    });
</script>