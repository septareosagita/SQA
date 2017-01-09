<div class="columns">
    <div class="column grid_x first">
        <div class="widget">
            <header>
                <h2><?= $grpauth->GRPAUTH_NM ?> &raquo; MENU AUTH INQUIRY</h2>
            </header>
            <section>
                <form name="fList" method="post" action="">
                    <p>
                        <input type="button" name="btnAdd" value="New Authority Access" class="button button-gray" onclick="window.location='<?= site_url('master_usrauth/grpmenu_change/' . $this->uri->segment(3)) ?>'"/>
                    </p><br />
                    <table class="data" width="100%">
                        <tr>
                            <th width="5%" style="border-left: 1px solid #cccccc;">Action</th>
                            <th width="30%">Group Auth</th>
                            <th>Shop Name</th>
                        </tr>
                        <?php if (count($grpmenus) > 0): $i = 1; foreach ($grpmenus as $l): ?>
                                <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
                                    <td nowrap="nowrap" style="border-left: 1px solid #cccccc;">
                                        <a href="<?= site_url('master_usrauth/grpmenu_change/' . $this->uri->segment(3) . '/' . $l->SHOP_ID) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Edit" title="Edit"/></a>
                                        <a href="javascript:;" onclick="cekgo('<?= site_url('master_usrauth/grpmenu_erase/' . $this->uri->segment(3) . '/' . $l->SHOP_ID) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a>
                                    </td>                                    
                                    <td><?= $l->GRPAUTH_ID ?> - <?= $l->GRPAUTH_NM ?></td>
                                    <td><?= $l->SHOP_NM ?></td>                                    
                                </tr>
                        <?php $i++; endforeach; else: ?>
                            <tr class="row-b">
                                <td colspan="4">Data Is Empty</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </form></section></div></div></div>