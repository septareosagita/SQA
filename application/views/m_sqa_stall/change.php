<div class="columns">
    <div class="column grid_6 first">

        <?php if ($err != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>

            <div class="widgetform">
                <header>
                    <h2>STALL &raquo; <?= ucwords($todo); ?></h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>

                        <fieldset>
                            <dl>
                                <dd>
                                    <label>Plant Code</label>
                               
                                    <select name="PLANT_CD" <?= ($todo == 'EDIT') ? 'readonly ="readonly"' : '' ?>>                                        
                                    <?php if (count($list_plant)): foreach ($list_plant as $l): ?>
                                            <option value="<?= $l->PLANT_CD ?>" <?= ($l->PLANT_CD == $PLANT_CD) ? 'selected = "selected"' : '' ?>><?= $l->PLANT_DESC ?></option>
                                    <?php endforeach;
                                        endif; ?>
                                    </select>
                                    </dd>
                                <dd>
                                    <label>Stall Number</label>
                                    <input type="text" name="STALL_NO" value="<?= $STALL_NO ?>" maxlength="2" size="5" <?= ($todo == "EDIT") ? 'readonly="readonly"' : '' ?> />
                                </dd>
                                <dd>
                                    <label>Stall Description</label>
                                    <input type="text" name="STALL_DESC" value="<?= $STALL_DESC ?>" maxlength="50" size="50" />
                                </dd>
                                <dd>
                                    <label>Stall Status</label>
                                    <select name="STALL_STS">
                                        <option value="0" <?=($STALL_STS=='0')?'selected="selected"':''?>>Available</option>
                                        <option value="1" <?=($STALL_STS=='1')?'selected="selected"':''?>>Used</option>
                                    </select>
                                </dd>
                                <dd>
                                    <label>SHOP</label>
                                    <select name="SHOP_ID">
                                        <?php foreach($list_shop_show as $l): ?>
                                        <option value="<?=$l->SHOP_ID?>" <?=($SHOP_ID==$l->SHOP_ID)?'selected="selected"':''?>><?=$l->SHOP_NM?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </dd>
                            </dl>
                        </fieldset>
                        <hr>
                        <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_stall/browse') ?>'"/>

                </form></section></div></div></div>