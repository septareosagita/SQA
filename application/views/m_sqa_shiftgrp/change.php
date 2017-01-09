<div class="columns">
    <div class="column grid_6 first">
        <?php if ($err != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widgetform">
                <header>
                    <h2>SHIFT GROUP &raquo; <?= ucwords($todo); ?></h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>

                        <fieldset>
                            <dl>
                                <dd>
                                    <label>Plant Code</label>
                                    <select name="PLANT_CD" <?= ($todo == "EDIT") ? 'readonly="readonly"' : '' ?>>
                                    <?php if (count($list_plant)): foreach ($list_plant as $l): ?>
                                            <option value="<?= $l->PLANT_CD ?>" <?= ($l->PLANT_CD == $PLANT_CD) ? 'selected = "selected"' : '' ?>><?= $l->PLANT_DESC ?></option>
                                    <?php endforeach;
                                        endif; ?>
                                    </select>
                                </dd>
                                <dd>
                                    <label>Shift Group ID</label>
                                    <input type="text" name="SHIFTGRP_ID" value="<?= $SHIFTGRP_ID ?>" maxlength="1" size="3" <?= ($todo == "EDIT") ? 'readonly="readonly"' : '' ?>/>
                                </dd>
                                <dd>
                                    <label>Shift Group Name</label>
                                    <input type="text" name="SHIFTTGRP_NM" value="<?= $SHIFTTGRP_NM ?>" maxlength="5" size="50" />
                                </dd>
                            </dl>
                        </fieldset>
                        <hr>
                        <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_shiftgrp/browse') ?>'"/>

                </form></section></div></div></div>