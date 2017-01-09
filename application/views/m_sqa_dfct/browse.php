<div class="columns">
    <div class="column grid_6 first">
<?php if ($err != ''): ?>
    <blockquote><p><?= $err ?></p></blockquote>
<?php endif; ?>
    <div class="widget">
    <header>
        <h2>DEFECT &raquo; INQUIRY</h2>
    <form name="fList" method="post" action="">
     </header>
    <section>
        <p>Search:
            <input type="text" name="searchkey" value="<?= $searchkey ?>" size="45"/>
            <input type="submit" name="btnSubmitSearch" value="Search" class="button button-gray"/>
            <input type="button" name="btnAdd" value="New Record" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_dfct/change') ?>'"/>
            <input type="button" name="btnAdd" value="Delete Selected" class="button button-gray" onclick="cekdulu(this.form);"/>
        </p><br />

    <?php if ($searchkey != ''): ?>
        <p>Search Result for the <strong>"<?= $searchkey ?>"</strong>
            (Found <?= count($list_dfct) ?> Content) [<a href="<?= site_url('m_sqa_dfct/browse'); ?>">Clear</a>] :
        </p>
    <?php endif; ?>

        <table class="data" width="100%">
            <tr>
                <th style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cekall" onclick="cek(this.form);" id="cekall"/></th>
                <th colspan="2" style="text-align: center;">Action</th>
                <th><a href="<?= site_url($browse_url . '0/' . $sorttype) ?>">Defect ID</a></th>
                <th><a href="<?= site_url($browse_url . '1/' . $sorttype) ?>">Defect Name</a></th>
                <th><a href="<?= site_url($browse_url . '2/' . $sorttype) ?>">Category Group</a></th>
                <th><a href="<?= site_url($browse_url . '3/' . $sorttype) ?>">Category</a></th>
            </tr>
        <?php if ($list_dfct): $i = 1;
            foreach ($list_dfct as $l): ?>
                <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
                    <td style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cek[]" value="<?= $l->DFCT_ID ?>"/></td>
                    <td colspan="2" nowrap="nowrap" style="text-align: center;">
                        <a href="<?= site_url('m_sqa_dfct/change/' . $l->DFCT_ID) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Edit" title="Edit"/></a>
                        <a href="javascript:;" onclick="cekgo('<?= site_url('m_sqa_dfct/erase/' . $l->DFCT_ID) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a>
                    </td>               
                    <td style="text-align: center;"><?= $l->DFCT_ID ?></td>
                    <td><?= $l->DFCTNM ?></td>
                    <td style="text-align: center;"><?= $l->CTG_GRP_NM ?></td>
                    <td style="text-align: center;"><?= $l->CTG_NM ?></td>
                </tr>
        <?php $i++; endforeach; else: ?>
            <tr class="row-b">
                <td colspan="7" style="text-align: center;">Data Is Empty</td>
            </tr>
        <?php endif; ?>
        </table>
        <div class="pagination"><p><?= ($pagination != '') ? "Page: " . $pagination . "<br /><br />" : '' ?></p></div>
</form></section></div>
    </div>
</div>