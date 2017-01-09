<div class="columns">
    <div class="column grid_6 first">
<?php if ($err != ''): ?>
    <div class="message error"><blockquote><p><?= $err ?></p></blockquote></div>
<?php endif; ?>
    <div class="widget">
        <header>
            <h2>Master Rank &raquo; Inquiry</h2>
     </header>
    <section>
    <form name="fList" method="post" action="">
        <p>Search:
            <input type="text" name="searchkey" value="<?= $searchkey ?>" size="45"/>
            <input type="submit" name="btnSubmitSearch" value="Search" class="button button-gray"/>
            <input type="button" name="btnAdd" value="New Record" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_rank/change') ?>'"/>
            <input type="button" name="btnAdd" value="Delete Selected" class="button button-gray" onclick="cekdulu(this.form);"/>
        </p><br>

    <?php if ($searchkey != ''): ?>
        <p>Search Result for the <strong>"<?= $searchkey ?>"</strong>
            (Found <?= count($list_rank) ?> Content) [<a href="<?= site_url('m_sqa_rank/browse'); ?>">Clear</a>] :
        </p>
    <?php endif; ?>

        <table class="data" width="100%">
            <tr>
                <th style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cekall" onclick="cek(this.form);" id="cekall"/></th>
                <th colspan="2">Action</th>
                <th><a href="<?= site_url($browse_url . '0/' . $sorttype) ?>">Rank ID</a></th>
                <th width="20%"><a href="<?= site_url($browse_url . '1/' . $sorttype) ?>">Rank Name</a></th>
                <th><a href="<?= site_url($browse_url . '2/' . $sorttype) ?>">Rank Description</a></th>
                <th><a href="<?= site_url($browse_url . '3/' . $sorttype) ?>">Update By</a></th>
                <th><a href="<?= site_url($browse_url . '4/' . $sorttype) ?>">Update Time</a></th>
            </tr>
        <?php if ($list_rank): $i = 1;
            foreach ($list_rank as $l): ?>
                <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
                    <td style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cek[]" value="<?= $l->RANK_ID ?>"/></td>
                    <td colspan="2" nowrap="nowrap" style="text-align: center;">
                        <a href="<?= site_url('m_sqa_rank/change/' . $l->RANK_ID) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Edit" title="Edit"/></a>
                        <a href="javascript:;" onclick="cekgo('<?= site_url('m_sqa_rank/erase/' . $l->RANK_ID) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a>
                    </td>
                    <td style="text-align: center;"><?= $l->RANK_ID ?></td>
                    <td style="text-align: center;"><?= $l->RANK_NM ?></td>
                    <td style="text-align: center;"><?= $l->RANK_DESC ?></td>
                    <td style="text-align: center;"><?= $l->Updateby ?></td>
                    <td style="text-align: center;"><?= $l->Updatedt ?></td>
                    
                </tr>
        <?php $i++;
            endforeach;
        else: ?>
            <tr class="row-b">
                <td colspan="8">Data Is Empty</td>
            </tr>
<?php endif; ?>
        </table>
        <div class="pagination"><p><?= ($pagination != '') ? "Page: " . $pagination . "<br /><br />" : '' ?></p></div>
</form></section></div></div></div>
