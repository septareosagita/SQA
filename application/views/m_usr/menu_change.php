<div class="columns">
    <div class="column grid_6 first">
        <br />
        <a class="tested" href="<?= site_url('master_usrauth/m_usr') ?>">User</a> | <a class="tested" href="<?=site_url('master_usrauth/grpauth')?>">Group Auth</a> | <strong>Application Menu</strong>
        <?php if ($err != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>

            <div class="widgetform">
                <header>
                    <h2>APPLICATION MENU &raquo; <?= ucwords($todo); ?></h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>
                        <fieldset>
                            <dl>
                                <dd>
                                    <label>Menu ID</label>
                                    <input type="text" name="MENU_ID" value="<?= $MENU_ID ?>" size="50" readonly="readonly"/>
                                </dd>
                                <dd>
                                    <label>Menu Name</label>
                                    <input type="text" name="MENU_NM" value="<?= $MENU_NM ?>" maxlength="50" size="50" />
                                </dd>
                                <dd>
                                    <label>Menu Controller</label>
                                    <input type="text" name="MENU_CTRL" value="<?= $MENU_CTRL ?>" maxlength="50" size="50" />
                                </dd>
                                <dd>
                                    <label>Menu Parent</label>
                                    <select name="MENU_PARENT">
                                        <option value="">-- No Parent --</option>
                                        <?php foreach ($list_parent as $l): ?>
                                        <option value="<?=$l->MENU_ID?>" <?=($MENU_PARENT == $l->MENU_ID)?'selected="selected"':''?>><?=$l->MENU_NM?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </dd>
                                <dd>
                                    <label>IS SHOW</label>
                                    <select name="IS_SHOW">
                                        <option value="1" <?=($IS_SHOW == '1')?'selected="selected"':''?>>Yes</option>
                                        <option value="0" <?=($IS_SHOW == '0')?'selected="selected"':''?>>No</option>
                                    </select>
                                </dd>
                                <dd>
                                    <label>IS Active</label>
                                    <select name="IS_ACTIVE">
                                        <option value="1" <?=($IS_ACTIVE == '1')?'selected="selected"':''?>>Yes</option>
                                        <option value="0" <?=($IS_ACTIVE == '0')?'selected="selected"':''?>>No</option>
                                    </select>
                                </dd>
                            </dl>
                        </fieldset>
                        <hr>
                        <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('master_usrauth/menu') ?>'"/>

                </form></section></div></div></div>