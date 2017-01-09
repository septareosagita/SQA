<script type="text/javascript">
    function cek_grp_shop() {
        if ($('#GRPAUTH_ID').val() == '01' || $('#GRPAUTH_ID').val() == '02' || $('#GRPAUTH_ID').val() == '03') {            
            var isi = '<?php if (count($list_shop)): foreach ($list_shop as $l): ?><?php if ($l->SHOP_SHOW == '1'): ?><option value="<?= $l->SHOP_ID ?>" <?= ($l->SHOP_ID == $SHOP_ID) ? 'selected="selected"' : '' ?>><?= $l->SHOP_NM ?></option><?php endif; ?><?php endforeach; endif; ?>';
        } else {            
            var isi = '<?php if (count($list_shop)): foreach ($list_shop as $l): ?><?php if ($l->SHOP_SHOW == '0'): ?><option value="<?= $l->SHOP_ID ?>" <?= ($l->SHOP_ID == $SHOP_ID) ? 'selected="selected"' : '' ?>><?= $l->SHOP_NM ?></option><?php endif; ?><?php endforeach; endif; ?>';
        }
        $('#SHOP_ID').html(isi);
    }

	function on_register_user() {
		$.post(
			'<?=site_url('master_usrauth/cek_grp_shop')?>',
			{
				grpauth_id: $('#GRPAUTH_ID').val(),
				shop_id: $('#SHOP_ID').val()
			},
			function (html) {
				if (html == 0) {
					alert("Application Menu doesn't exist for GroupAuth and SHOP choosen");
				} else {
					$('#fInput').submit();
				}
			}
		);	
	
	}
</script>
<div class="columns">
    <div class="column grid_6 first">
        <br />
        <strong>User</strong> | <a class="tested" href="<?=site_url('master_usrauth/grpauth')?>">Group Auth</a> | <a class="tested" href="<?=site_url('master_usrauth/menu')?>">Application Menu</a>
        <?php if ($err != ''): ?>
        <div class="message error"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>

        <div class="widgetform">
            <header>
                <h2>USER &raquo;<?= ucwords($todo); ?></h2>
            </header>
            <section>
                <form name="fInput" id="fInput" method="post" action="" class="form">
                    <input type="hidden" name="todo" value="<?= $todo ?>"/>
                    <?php if ($todo == 'EDIT'): ?>
                    <!--input type="hidden" name="GRPAUTH_ID" value="<?=$GRPAUTH_ID?>" />
                    <input type="hidden" name="SHIFTGRP_ID" value="<?=$SHIFTGRP_ID?>" />
                    <input type="hidden" name="SHOP_ID" value="<?=$SHOP_ID?>" /-->
                    <?php endif; ?>

                    <fieldset>
                        <dl>
                            <dd>
                                <label>User Id</label>
                                <input type="text" name="USER_ID" value="<?= $USER_ID ?>" maxlength="20" size="21"  <?= ($todo == 'EDIT') ? 'readonly="readonly"' : '' ?> />
                            </dd>
                            <dd>
                                <label>User Name</label>
                                <input type="text" name="USER_NM" value="<?= $USER_NM ?>" maxlength="20" size="50" />
                            </dd>
                            <dd>
                                <label>GROUP AUTH</label>
                                <select id="GRPAUTH_ID" name="GRPAUTH_ID"  onchange="cek_grp_shop();">
                                    <?php foreach ($list_grpauth as $l): ?>
                                    <option value="<?=$l->GRPAUTH_ID?>" <?=($l->GRPAUTH_ID == $GRPAUTH_ID)?'selected="selected"':''?>><?=$l->GRPAUTH_NM?></option>
                                    <?php endforeach; ?>
                                </select>                                
                            </dd>
                            <dd>
                                <label>SHOP</label>
                                <select id="SHOP_ID" name="SHOP_ID" >
                                
                                </select>                                                                
                            </dd>
                            <dd>
                                <label>SHIFT GROUP</label>
                                <select name="SHIFTGRP_ID">
                                <?php if (count($list_shiftgrp)): foreach ($list_shiftgrp as $l): ?>
                                    <option value="<?= $l->SHIFTGRP_ID ?>" <?= ($l->SHIFTGRP_ID==$SHIFTGRP_ID) ? 'selected="selected"' : '' ?>><?= $l->SHIFTTGRP_NM ?></option>
                                <?php endforeach; endif; ?>
                                </select>
                            </dd>                            
                            <dd>
                                <label>Description</label>
                                <input type="text" name="DESCRIPTION" value="<?= $DESCRIPTION ?>" maxlength="30" size="50" />
                            </dd>
                            <dd>
                                <label>Email</label>
                                <input type="text" name="EMAIL" value="<?=$EMAIL?>" maxlength="255" size="50" />
                            </dd>
                            <dd>
                                <label>Password
                                <?php if ($todo == 'EDIT'): ?>
                                <br /><sup>* Leave Empty if you don't wish to update the password</sup>
                                <?php endif; ?>
                                </label>
                                <input type="password" name="PASS" value="" maxlength="50" size="50" />
                                
                            </dd>
                        </dl>
                        </fieldset>
                        <hr>
                        <input type="button" onclick="on_register_user();" name="btnSubmit" value="Save" class="button button-gray"/>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('master_usrauth/m_usr') ?>'"/>
            </form></section></div></div></div>
<script type="text/javascript">
    $(function(){
       cek_grp_shop(); 
    });
</script>            