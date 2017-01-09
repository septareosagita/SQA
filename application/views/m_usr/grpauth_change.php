<div class="columns">
    <div class="column grid_6 first">
        <br />
        <a class="tested" href="<?=site_url('master_usrauth/m_usr')?>">User</a> | <strong>Group Auth</strong> | <a class="tested" href="<?=site_url('master_usrauth/menu')?>">Application Menu</a>
        <?php if ($err != ''): ?>
        <div class="message error"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>

        <div class="widgetform">
            <header>
                <h2>GROUP AUTH &raquo;<?= ucwords($todo); ?></h2>
            </header>
            <section>
                <form name="fInput" method="post" action="" class="form">
                    <input type="hidden" name="todo" value="<?= $todo ?>"/>

                    <fieldset>
                        <dl>
                            <dd>
                                <label>Group Auth Id</label>
                                <input type="text" name="GRPAUTH_ID" value="<?= $GRPAUTH_ID ?>" size="5" readonly="readonly" />
                            </dd>
                            <dd>
                                <label>Group Auth Name</label>
                                <input type="text" name="GRPAUTH_NM" value="<?= $GRPAUTH_NM ?>" maxlength="50" size="50" />
                            </dd>
                            <dd>
                                <label>Is Auditor</label>
                                <input type="checkbox" name="GRPAUTH_IS_AUDITOR" value="1" title="Check if this Group Auth Name is an Auditor" <?=($GRPAUTH_IS_AUDITOR == '1')?'checked="checked"' : ''?> />                                 
                            </dd>
                        </dl>
                        </fieldset>
                        <hr />
                        <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('master_usrauth/grpauth') ?>'"/>
            </form></section></div></div></div>