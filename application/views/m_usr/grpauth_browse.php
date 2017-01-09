<script type="text/javascript">
    $(function() {
        $(".view_detail").fancybox({
            'width'         : '75%',
            'height'        : '75%',
            'autoScale'     : false,
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic',
            'type'          : 'iframe'
        });
    });
</script>
<div class="columns">
    <div class="column grid_6 first">
        <br />
        <a class="tested" href="<?=site_url('master_usrauth/m_usr')?>">User</a> | <strong>Group Auth</strong> | <a class="tested" href="<?=site_url('master_usrauth/menu')?>">Application Menu</a>
     <div class="widget">
         <header><h2>GROUP AUTH &raquo; INQUIRY</h2></header>
            <section>
            <form name="fList" method="post" action="">
            <p>Search:
            <input type="text" name="searchkey" value="<?= $searchkey ?>" size="45"/>
            <input type="submit" name="btnSubmitSearch" value="Search" class="button button-gray"/>
            <input type="button" name="btnAdd" value="New Record" class="button button-gray" onclick="window.location='<?= site_url('master_usrauth/grpauth_change') ?>'"/>
            <input type="button" name="btnAdd" value="Delete Selected" class="button button-gray" onclick="cekdulu(this.form);"/>
            </p><br>

    <?php if ($searchkey != ''): ?>
        <p>Search Result for the <strong>"<?= $searchkey ?>"</strong>
            (Found <?= count($list_usr) ?> Content) [<a href="<?= site_url('master_usrauth/grpauth'); ?>">Clear</a>] :
        </p>
    <?php endif; ?>

    <table class="data" width="100%">
        <tr>
            <th width="5%" style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cekall" onclick="cek(this.form);" id="cekall"/></th>
            <th width="5%">Action</th>
            <th width="5%"><a href="<?= site_url($browse_url . '9/' . $sorttype) ?>">Group Auth ID</a></th>
            <th><a href="<?= site_url($browse_url . '10/' . $sorttype) ?>">Group Auth Name</a></th>
            <th>Group Auth Menu</th>
        </tr>
        <?php if ($list_usr): $i = 1; foreach ($list_usr as $l):
        ?>
        <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
            <td style="text-align: center; border-left: 1px solid #cccccc;"><!--input type="checkbox" name="cek[]" value="<?= $l->GRPAUTH_ID ?>"/--></td>
            <td nowrap="nowrap" style="text-align: center; border-left: 1px solid #cccccc;">
                <a href="<?= site_url('master_usrauth/grpauth_change/' . $l->GRPAUTH_ID) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Change" title="Change"/></a>
            <!--a href="javascript:;" onclick="cekgo('<?= site_url('master_usrauth/grpauth_erase/' . $l->GRPAUTH_ID) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a-->
            </td>            
            <td style="text-align: center;"><?= $l->GRPAUTH_ID ?></td>
            <td style="text-align: center;">
                <?= $l->GRPAUTH_NM ?>
                <?php if ($l->GRPAUTH_IS_AUDITOR == '1') : ?>
                <sup style="color: #cccccc;">*Auditor</sup>
                <?php endif; ?>    
            </td>
            <td style="text-align: center;">
                [ <a class="view_detail tested" href="<?=site_url('master_usrauth/grpmenu/'.$l->GRPAUTH_ID)?>">Configure</a> ]
            </td>
        </tr>
        <?php $i++; endforeach; else: ?>
        <tr class="row-b">
            <td colspan="5">Data Is Empty</td>
        </tr>
        <?php endif; ?>
    </table>
    <div class="pagination"><p><?= ($pagination != '') ? "Page: " . $pagination . "<br /><br />" : '' ?></p></div>
</form></section></div></div></div>