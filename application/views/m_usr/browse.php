<div class="columns">
    <div class="column grid_6 first">
        <br />
        <strong>User</strong> | <a class="tested" href="<?=site_url('master_usrauth/grpauth')?>">Group Auth</a> | <a class="tested" href="<?=site_url('master_usrauth/menu')?>">Application Menu</a>
     <div class="widget">
         <header><h2>USER &raquo; INQUIRY</h2></header>
            <section>
            <form name="fList" method="post" action="">
            <p>Search:
            <input type="text" name="searchkey" value="<?= $searchkey ?>" size="45"/>
            <input type="submit" name="btnSubmitSearch" value="Search" class="button button-gray"/>
            <input type="button" name="btnAdd" value="New Record" class="button button-gray" onclick="window.location='<?= site_url('master_usrauth/m_usr_change') ?>'"/>
            <input type="button" name="btnAdd" value="Delete Selected" class="button button-gray" onclick="cekdulu(this.form);"/>
            </p><br>

    <?php if ($searchkey != ''): ?>
        <p>Search Result for the <strong>"<?= $searchkey ?>"</strong>
            (Found <?= count($list_usr) ?> Content) [<a href="<?= site_url('master_usrauth/m_usr'); ?>">Clear</a>] :
        </p>
    <?php endif; ?>

    <table class="data" width="100%">
        <tr>
            <th width="5%" style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cekall" onclick="cek(this.form);" id="cekall"/></th>
            <th width="5%">Action</th>
            <th><a href="<?= site_url($browse_url . '1/' . $sorttype) ?>">User ID/Name</a></th>
            <th><a href="<?= site_url($browse_url . '5/' . $sorttype) ?>">Description</a></th>
            <th><a href="<?= site_url($browse_url . '2/' . $sorttype) ?>">Group Auth</a></th>
            <th><a href="<?= site_url($browse_url . '4/' . $sorttype) ?>">Shop</a></th>
            <th><a href="<?= site_url($browse_url . '3/' . $sorttype) ?>">Shift Group</a></th>            
        </tr>
        <?php if ($list_usr): $i = 1; foreach ($list_usr as $l):
        ?>
        <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
            <td style="text-align: center; vertical-align: middle; border-left: 1px solid #cccccc;">                
                <?php if (str_replace(' ', '', $l->USER_ID) != get_user_info($this, 'USER_ID')): ?>
                <input type="checkbox" name="cek[]" value="<?= $l->USER_ID ?>"/>
                <?php endif; ?>
            </td>
            <td style="text-align: center;" nowrap="nowrap">
                <a href="<?= site_url('master_usrauth/m_usr_change/' . $l->USER_ID) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Change" title="Change"/></a>
                <?php if (str_replace(' ', '', $l->USER_ID) != get_user_info($this, 'USER_ID')): ?>
                <a href="javascript:;" onclick="cekgo('<?= site_url('master_usrauth/m_usr_erase/' . $l->USER_ID) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a>
                <?php endif; ?>
            </td>            
            <td>
                <?= $l->USER_ID ?> - <?= $l->USER_NM ?>                
            </td>
            <td><?= $l->DESCRIPTION ?></td>
            <td style="text-align: center;"><?= $l->GRPAUTH_NM ?></td>
            <td style="text-align: center;"><?= $l->SHOP_NM ?></td>
            <td style="text-align: center;"><?= $l->SHIFTTGRP_NM ?></td>            
        </tr>
        <?php $i++; endforeach; else: ?>
        <tr class="row-b">
            <td colspan="10">Data Is Empty</td>
        </tr>
        <?php endif; ?>
    </table>
    <div class="pagination"><p><?= ($pagination != '') ? "Page: " . $pagination . "<br /><br />" : '' ?></p></div>
</form></section></div></div></div>