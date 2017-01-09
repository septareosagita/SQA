<div class="columns">
    <div class="column grid_6 first">
        <?php if ($err != ''): ?>
            <div class="message error"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widgetform">
                <header>
                    <h2>RESPONSIBLE &raquo <?= ucwords($todo); ?></h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>
                        <fieldset>
                            <dl>
                                <dd>
                                    <label>Plant </label>
                                    <select name="PLANT_CD" <?= ($todo == 'edit') ? 'readonly="1"' : '' ?>>                                        
                                    <?php if (count($list_plant)): foreach ($list_plant as $l): ?>
                                            <option value="<?= $l->PLANT_CD ?>" <?= ($l->PLANT_CD == $PLANT_CD) ? 'selected="selected"' : '' ?>><?= $l->PLANT_CD ?> - <?= $l->PLANT_DESC ?></option>
                                    <?php endforeach;
                                        endif; ?>
                                    </select>
                                </dd>
                                <dd>
                                    <label>Shop ID</label>
                                    <input type="text" name="SHOP_ID" value="<?= $SHOP_ID ?>" maxlength="2" size="5"  <?= ($todo == 'EDIT') ? 'readonly="readonly"' : '' ?> />
                                </dd>
                                <dd>
                                    <label>Shop Name</label>
                                    <input type="text" name="SHOP_NM" value="<?= $SHOP_NM ?>" maxlength="30" size="50" />
                                </dd>
                                <dd>
                                    <label>Shop Show</label>
                                    <input type="checkbox" name="SHOP_SHOW" value="1" <?=($SHOP_SHOW=='1')?'checked="checked"':''?> />
                                </dd>
                            </dl>
                        </fieldset>
                        <hr>
                        <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_shop/browse') ?>'"/>

                </form></section></div></div></div>