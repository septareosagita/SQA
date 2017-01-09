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
<?php if ($err != ''): ?>
    <div class="message warning"><blockquote><p><?= $err ?></p></blockquote><div>
<?php endif; ?>
    <div class="widget">
                <header>
    <h2>CATEGORY GROUP &raquo; Inquiry</h2>
    </header>
                <section>
    <form name="fList" method="post" action="">
        <p>Search:
            <input type="text" name="searchkey" value="<?= $searchkey ?>" size="45"/>
            <input type="submit" name="btnSubmitSearch" value="Search" class="button button-gray"/>
            <input type="button" name="btnAdd" value="New Record" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_ctg_grp/change') ?>'"/>
            <input type="button" name="btnAdd" value="Delete Selected" class="button button-gray" onclick="cekdulu(this.form);"/>
        </p><br>

    <?php if ($searchkey != ''): ?>
        <p>Search Result for the <strong>"<?= $searchkey ?>"</strong>
            (Found <?= count($list_ctg_grp) ?> Content) [<a href="<?= site_url('m_sqa_ctg_grp/browse'); ?>">Clear</a>] :
        </p>
    <?php endif; ?>

        <sup><strong>Notes: </strong>Klik on The Category Group Name to See Detail Category</sup>
        <table class="data" width="100%">
            <tr>
                <th width="5%" style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cekall" onclick="cek(this.form);" id="cekall"/></th>
                <th colspan="3" width="5%">Action</th>
                <!--th><a href="<?= site_url($browse_url . '0/' . $sorttype) ?>">Category Group ID</a></th-->
                <th><a href="<?= site_url($browse_url . '1/' . $sorttype) ?>">Category Group Name/Description</a></th>
                <!--th><a href="<?= site_url($browse_url . '2/' . $sorttype) ?>">Category Group Decription</a></th-->
                <th><a href="<?= site_url($browse_url . '5/' . $sorttype) ?>">Valid</a></th>
            </tr> 
        <?php if ($list_ctg_grp): $i = 1;
            foreach ($list_ctg_grp as $l): ?>
                <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
                    <td style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cek[]" value="<?= $l->CTG_GRP_ID ?>"/></td>
                    <td colspan="3" nowrap="nowrap">
                        <a href="<?= site_url('m_sqa_ctg_grp/change/' . $l->CTG_GRP_ID) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Edit" title="Edit"/></a>
                        <a href="javascript:;" onclick="cekgo('<?= site_url('m_sqa_ctg_grp/erase/' . $l->CTG_GRP_ID) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a>
                        <a href="<?= site_url('m_sqa_ctg/browse/' . $l->CTG_GRP_ID) ?>" class="view_detail"><img src="<?= base_url() ?>assets/style/images/search.png" alt="Detail" title="Detail"/></a>
                    </td>
                    <!--td><?= $l->CTG_GRP_ID ?></td-->
                    <td >
                        <a title="Update Category Name under '<?= $l->CTG_GRP_NM ?>'" href="<?=site_url('m_sqa_ctg/browse/' . $l->CTG_GRP_ID)?>" class="view_detail">
                        <strong><?= $l->CTG_GRP_NM ?></strong>
                        </a>
                        <br />
                        <?= $l->CTG_GRP_DESC ?>
                    </td>
                    <!--td></td-->
                    <td style="text-align: center;"><?= conv_date(2, $l->VALID_FROM)?> To <?= conv_date(2, $l->VALID_TO) ?></td>
                </tr>
        <?php
                $i++;
            endforeach;
        else:
        ?>
            <tr class="row-b">
                <td colspan="10">Data Is Empty</td>
            </tr>
<?php endif; ?>
        </table>
        <div class="pagination"><p><?= ($pagination != '') ? "Page: " . $pagination . "<br /><br />" : '' ?></p></div>
</form></section></div></div></div>