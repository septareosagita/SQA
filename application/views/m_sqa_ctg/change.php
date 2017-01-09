<div class="columns">
    <div class="column grid_6 first">


        <?php if (isset($err) != ''): ?>
            <blockquote><p><?= $err ?></p></blockquote>
        <?php endif; ?>

            <div class="widgetform">
                <header>
                   <h2><?=$ctg_grp->CTG_GRP_NM?> &raquo; <?= ucwords($todo); ?> CATEGORY</h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>
                        <input type="hidden" name="Updateby" value="<?= $Updateby ?>" />
                        <input type="hidden" name="Updatedt" value="<?= $Updatedt ?>" />
                        <input type="hidden" name="CTG_GRP_ID" value="<?=$CTG_GRP_ID?>" readonly="readonly" />
                        <input type="hidden" name="CTG_ID" value="<?= $CTG_ID ?>" size="50" readonly="readonly"/>
                        <fieldset>
                            <dl>
                                <dd>
                                    <label>Category Group</label>
                                     <?=$ctg_grp->CTG_GRP_NM?>
                                    </select>
                                </dd>
                                <dd>
                                    <label>Category Name</label>
                                    <input type="text" name="CTG_NM" value="<?= $CTG_NM ?>" maxlength="100" size="50" />
                                </dd>
                                <dd>
                                    <label>Category Description</label>
                                    <textarea cols="50" rows="5" name="CTG_DESC"><?=$CTG_DESC?></textarea>                                    
                                </dd>
                                <dd>
                                    <label>Valid From</label>
                                    <input type="text" name="VALID_FROM" id="VALID_FROM" value="<?= conv_date(2, $VALID_FROM) ?>" size="8" />
                                    <label>Valid To</label>
                                    <input type="text" name="VALID_TO" id="VALID_TO" value="<?= conv_date(2, $VALID_TO) ?>" size="8" />
                                </dd>                                
                            </dl>
                        </fieldset>
                        <hr>
                        <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_ctg/browse/' . $CTG_GRP_ID) ?>'"/>

                </form></section></div></div></div>

<script type="text/javascript">
    $(function(){
        $("#VALID_FROM").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
        $("#VALID_TO").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
    });
</script>