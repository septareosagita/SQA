<div class="columns">
    <div class="column grid_6 first">
        <?php if (isset($err) != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widgetform">
                <header>
                    <h2>Master Rank &raquo; <?= ucwords($todo); ?></h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="Updateby" value="<?= $Updateby ?>" />
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>
                        <input type="hidden" name="Updatedt" value="<?= $Updatedt ?>"/>
                        <fieldset>
                            <dl>
                                <dd>
                                    <label>Rank ID</label>
                                    <input type="text" name="RANK_ID" value="<?= $RANK_ID ?>" size="50" readonly="readonly" />
                                </dd>
                                <dd>
                                    <label>Rank Name</label>
                                    <input type="text" name="RANK_NM" value="<?= $RANK_NM ?>" maxlength="20" size="50" />
                                </dd>
                                <dd>
                                    <label>Rank Description</label>
                                    <textarea cols="50" rows="5" name="RANK_DESC"><?=$RANK_DESC?></textarea>                                    
                                </dd>
                            </dl>
                        </fieldset>
                        <hr>
                        <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_rank/browse') ?>'"/>

                </form></section></div></div></div>