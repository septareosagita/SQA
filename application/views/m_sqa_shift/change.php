<script type="text/javascript">
    $(function(){
       $('#TIME_FROM').timepicker({showSecond: true,timeFormat: 'hh:mm:ss'});
       $('#TIME_TO').timepicker({showSecond: true,timeFormat: 'hh:mm:ss'});
    });
</script>
<div class="columns">
    <div class="column grid_6 first">


        <?php if ($err != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widgetform">
                <header>
                    <h2>SHIFT &raquo; <?= ucwords($todo); ?></h2>
                </header>
                <section>
                          <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>
                        <fieldset>
                            <dl>
                                <dd>
                                    <label>Plant Code</label>

                                    <select name="PLANT_CD" <?= ($todo == 'edit') ? 'readonly="1"' : '' ?>>                                        
                                    <?php if (count($list_plant)): foreach ($list_plant as $l): ?>
                                            <option value="<?= $l->PLANT_CD ?>"<?= ($l->PLANT_CD == $PLANT_CD) ? 'selected="selected"' : '' ?>><?= $l->PLANT_DESC ?></option>
                                    <?php endforeach;
                                        endif; ?>
                                    </select>
                                </dd>
                                <dd>
                                    <label>Shift NO</label>

                                    <input type="text" name="SHIFTNO" value="<?=$SHIFTNO?>" maxlength="1" />
                                    </dd>
                                    <dd>
                                        <label>Time From</label>
                                        <input type="text" name="TIME_FROM" id="TIME_FROM" value="<?= $TIME_FROM ?>" size="7" />
                                    </dd>
                                    <dd>
                                        <label>Time To</label>
                                        <input type="text" name="TIME_TO" id="TIME_TO" value="<?= $TIME_TO ?>" size="7" />
                                    </dd>
                                    <dd>
                                        <label>Shift Description</label>
                                        <input type="text" name="DESCRIPTION" value="<?= $DESCRIPTION ?>" maxlength="15" size="50" />
                                    </dd>
                                </dl>
                            </fieldset>
                            <hr>
                            <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                            <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_shift/browse') ?>'"/>

                </form></section></div></div></div>