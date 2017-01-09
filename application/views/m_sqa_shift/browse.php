<div class="columns">
    <div class="column grid_6 first">
<?php if ($err != ''): ?>
    <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
<?php endif; ?>
     <div class="widget">
    <header>
    <h2>SHIFT &raquo; INQUIRY</h2>
     </header>
    <section>
    <form name="fList" method="post" action="">
        <p>Search:
        <input type="text" name="searchkey" value="<?= $searchkey ?>" size="45"/>
        <input type="submit" name="btnSubmitSearch" value="Search" class="button button-gray"/>
        <input type="button" name="btnAdd" value="New Record" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_shift/change') ?>'"/>
        <input type="button" name="btnAdd" value="Delete Selected" class="button button-gray" onclick="cekdulu(this.form);"/>
        </p><br>

    <?php if ($searchkey != ''): ?>
        <p>Search Result for the <strong>"<?= $searchkey ?>"</strong>
            (Found <?= count($list_m_sqa_shift) ?> Content) [<a href="<?= site_url('m_sqa_shift/browse'); ?>">Clear</a>] :
        </p>
    <?php endif; ?>

    <table class="data" width="100%">
        <tr>
            <th width="5%" style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cekall" onclick="cek(this.form);" id="cekall"/></th>
            <th colspan="2" width="5%">Action</th>
            <th><a href="<?= site_url($browse_url . '0/' . $sorttype) ?>">Plant</a></th>
            <th><a href="<?= site_url($browse_url . '1/' . $sorttype) ?>">Shift No</a></th>
            <th><a href="<?= site_url($browse_url . '2/' . $sorttype) ?>">Time</a></th>
            <th><a href="<?= site_url($browse_url . '4/' . $sorttype) ?>">Shift Description</a></th>
        </tr>
        <?php if ($list_m_sqa_shift): $i = 1; foreach ($list_m_sqa_shift as $l):

            $tf = substr($l->TIME_FROM, 0, 2) . ':' . substr($l->TIME_FROM, 2, 2) . ':' . substr($l->TIME_FROM, 4, 2);
            $tt = substr($l->TIME_TO, 0, 2) . ':' . substr($l->TIME_TO, 2, 2) . ':' . substr($l->TIME_TO, 4, 2);
            
        ?>
        <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
            <td style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cek[]" value="<?= AsciiToHex(base64_encode($l->PLANT_CD . ';' . $l->SHIFTNO)) ?>"/></td>
            <td colspan="2" nowrap="nowrap" style="text-align: center;">
                <a href="<?= site_url('m_sqa_shift/change/' . AsciiToHex(base64_encode($l->PLANT_CD . ';' . $l->SHIFTNO))) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Edit" title="Edit"/></a>
                <a href="javascript:;" onclick="cekgo('<?= site_url('m_sqa_shift/erase/' . $l->PLANT_CD . '/' . $l->SHIFTNO) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a>
            </td>            
            <td style="text-align: center;"><?= $l->PLANT_CD ?> - <?= $l->PLANT_NM ?></td>
            <td style="text-align: center;"><?= $l->SHIFTNO ?></td>
            <td style="text-align: center;"><?= $tf ?> To <?= $tt ?></td>
            <td style="text-align: center;"><?= $l->DESCRIPTION ?></td>
        </tr>
        <?php $i++; endforeach; else: ?>
        <tr class="row-b">
            <td colspan="7">Data Is Empty</td>
        </tr>
        <?php endif; ?>
    </table>
    <div class="pagination"><p><?= ($pagination != '') ? "Page: " . $pagination . "<br /><br />" : '' ?></p></div>
</form></section></div></div></div>