<div class="columns">
    <div class="column grid_6 first">
        <br />
        <a class="tested" href="<?= site_url('master_usrauth/m_usr') ?>">User</a> | <a class="tested" href="<?=site_url('master_usrauth/grpauth')?>">Group Auth</a> | <strong>Application Menu</strong>
        <div class="widget">
            <header><h2>APPLICATION MENU &raquo; INQUIRY</h2></header>
            <section>
                <form name="fList" method="post" action="">
                    <p>Search:
                        <input type="text" name="searchkey" value="<?= $searchkey ?>" size="45"/>
                        <input type="submit" name="btnSubmitSearch" value="Search" class="button button-gray"/>
                        <input type="button" name="btnAdd" value="New Record" class="button button-gray" onclick="window.location='<?= site_url('master_usrauth/menu_change') ?>'"/>
                        <input type="button" name="btnAdd" value="Delete Selected" class="button button-gray" onclick="cekdulu(this.form);"/>
                    </p><br />

                    <?php if ($searchkey != ''): ?>
                        <p>Search Result for the <strong>"<?= $searchkey ?>"</strong>
                            (Found <?= count($list_menu) ?> Content) [<a href="<?= site_url('master_usrauth/menu'); ?>">Clear</a>] :
                        </p>
                    <?php endif; ?>
                        <table class="data" width="100%">
                            <tr>
                                <th width="5%" style="border-left: 1px solid #cccccc;"><!--input type="checkbox" name="cekall" onclick="cek(this.form);" id="cekall"/--></th>
                                <th width="5%">Action</th>
                                <th><a href="<?= site_url($browse_url . '11/' . $sorttype) ?>">Menu ID</a></th>
                                <th><a href="<?= site_url($browse_url . '12/' . $sorttype) ?>">Menu Name</a></th>
                                <th><a href="<?= site_url($browse_url . '13/' . $sorttype) ?>">Menu Controller</a></th>
                                <th><a href="<?= site_url($browse_url . '14/' . $sorttype) ?>">Menu Parent</a></th>
                                <th><a href="<?= site_url($browse_url . '15/' . $sorttype) ?>">Is Show</a></th>
                                <th><a href="<?= site_url($browse_url . '16/' . $sorttype) ?>">Is Active</a></th>
                            </tr>
                        <?php if ($list_menu): $i = 1; foreach ($list_menu as $l): ?>
                                <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
                                    <td style="text-align: center; border-left: 1px solid #cccccc;"><!--input type="checkbox" name="cek[]" value="<?= $l->MENU_ID ?>"/--></td>
                                    <td nowrap="nowrap" style="text-align: center;">
                                        <a href="<?= site_url('master_usrauth/menu_change/' . $l->MENU_ID) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Edit" title="Edit"/></a>
                                        <!--a href="javascript:;" onclick="cekgo('<?= site_url('master_usrauth/menu_erase/' . $l->MENU_ID) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a-->
                                    </td>
                                    <td style="text-align: center;"><?= $l->MENU_ID ?></td>
                                    <td><?= $l->MENU_NM ?></td>
                                    <td style="text-align: center;"><?= $l->MENU_CTRL ?></td>
                                    <td style="text-align: center;"><?= $l->MENU_PARENT ?></td>
                                    <td style="text-align: center;"><?= ($l->IS_SHOW=='1')?'Yes':'No' ?></td>
                                    <td style="text-align: center;"><?= ($l->IS_ACTIVE=='1')?'Yes':'No' ?></td>
                                </tr>
                        <?php $i++; endforeach; else: ?>
                            <tr class="row-b">
                                <td colspan="8">Data Is Empty</td>
                            </tr>
                        <?php endif; ?>
                        </table>
                        <div class="pagination"><p><?= ($pagination != '') ? "Page: " . $pagination . "<br /><br />" : '' ?></p></div>
                </form></section></div></div></div>