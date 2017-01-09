<div class="columns">
    <div class="column grid_x first">
        <div class="widget">
            <header>
                <h2><?= $grpauth->GRPAUTH_NM ?> &raquo; <?=$todo?></h2>
            </header>
            <section>
                <form name="fList" method="post" action="">
                    <table width="100%">
                        <tr>
                            <td>Group Auth</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="GROUPAUTH_NM" value="<?= $grpauth->GRPAUTH_NM ?>" size="50" readonly="readonly"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Shop Id</td>
                            <td>:</td>
                            <td>                                
                                <select name="SHOP_ID" <?=($this->uri->segment(4)!='')?'disabled="disabled"':''?>>
                                    <?php foreach($list_shop as $l): ?>
                                    <option value="<?=$l->SHOP_ID?>" <?=($this->uri->segment(4)==$l->SHOP_ID)?'selected="selected"':''?>><?=$l->SHOP_NM?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br/>
                    <table class="data" width="100%">
                        <tr>

                            <th style="border-left: 1px solid #cccccc;"><input type="checkbox" name="cekall" onclick="cek(this.form);" id="cekall"/></th>
                            <!--th>Hak Akses</th-->
                            <th width="30%">Menu Name</th>
                            <th>Menu Controller</th>
                        </tr>
                        <?php if (count($list_menu) > 0): $i = 1; foreach ($list_menu as $l): ?>
                                <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >

                                    <?php
                                        $sel_menu = $sel_menu_1 = '';
                                        $sel_menu_2 = 'checked="checked"';
                                        if (isset($arr_menu[$l->MENU_ID])) {
                                            $sel_menu = 'checked="checked"';
                                            if ($arr_menu[$l->MENU_ID] == '1') {
                                                $sel_menu_1 = 'checked="checked"';
                                                $sel_menu_2 = '';
                                            } else {
                                                $sel_menu_1 = '';
                                                $sel_menu_2 = 'checked="checked"';
                                            }
                                        }
                                    ?>

                                    <td style="border-left: 1px solid #cccccc; text-align: center;">
                                        <input type="checkbox" name="cek[]" value="<?= $l->MENU_ID ?>" <?=$sel_menu?>/>
                                        <input type="hidden" value="0" name="USR_AUTH<?=$l->MENU_ID?>" id="USR_AUTH<?=$l->MENU_ID?>" />
                                    </td>
                                    <!--td>
                                        <input type="radio" value="1" name="USRAUTH<?=$l->MENU_ID?>" id="1<?=$l->MENU_ID?>" onclick="$('#USR_AUTH<?=$l->MENU_ID?>').val(1)" <?=$sel_menu_1?>/><label for="1<?=$l->MENU_ID?>" style="cursor: pointer">Read Write</label>
                                        <input type="radio" value="0" name="USRAUTH<?=$l->MENU_ID?>" id="0<?=$l->MENU_ID?>" onclick="$('#USR_AUTH<?=$l->MENU_ID?>').val(0)" <?=$sel_menu_2?>/><label for="0<?=$l->MENU_ID?>" style="cursor: pointer">Read Only</label>                                        
                                    </td-->
                                    <td><?=$l->MENU_NM?></td>
                                    <td><?=$l->MENU_CTRL?></td>
                                </tr>
                        <?php $i++; endforeach; else: ?>
                            <tr class="row-b">
                                <td colspan="4">Data Is Empty</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                    <br/>                   
                                <input type="submit" class="button button-gray" name="btnSaveUsrAuth" value="Save" />
                                <input type="button" class="button button-gray" name="btnCancelUsrAuth" value="Cancel" onclick="window.location='<?=site_url('master_usrauth/grpmenu/' . $this->uri->segment(3))?>'" />
                   
                </form></section></div></div></div>