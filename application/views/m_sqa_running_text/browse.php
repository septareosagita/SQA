<div class="columns">
    <div class="column grid_6 first">
<?php if ($err != ''): ?>
    <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
<?php endif; ?>
     <div class="widget">
    <header>
    <h2>RUNNING TEXT &raquo; INQUIRY</h2>
    </header>
    <section>
    <form name="fList" method="post" action="">
        <p>Search:
        <input type="text" name="searchkey" value="<?= $searchkey ?>" size="45"/>
        <input type="submit" name="btnSubmitSearch" value="Search" class="button button-gray"/>
        <input type="button" name="btnAdd" value="New Record" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_running_text/change') ?>'"/>
        <input type="button" name="btnAdd" value="Delete Selected" class="button button-gray" onclick="cekdulu(this.form);"/>
        </p><br />

    <?php if ($searchkey != ''): ?>
        <p>Search Result for the <strong>"<?= $searchkey ?>"</strong>
            (Found <?= count($list_m_sqa_running_text) ?> Content) [<a href="<?= site_url('m_sqa_running_text/browse'); ?>">Clear</a>] :
        </p>
    <?php endif; ?>

    <table class="data" width="100%">
        <tr>
            <th style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cekall" onclick="cek(this.form);" id="cekall"/></th>
            <th colspan="2">Action</th>
            <th><a href="<?= site_url($browse_url . '0/' . $sorttype) ?>">Run Teks</a></th>
            <th><a href="<?= site_url($browse_url . '1/' . $sorttype) ?>">Font Name</a></th>
            <th><a href="<?= site_url($browse_url . '2/' . $sorttype) ?>">Font Size</a></th>
            <th><a href="<?= site_url($browse_url . '3/' . $sorttype) ?>">Font Color</a></th>
            <th><a href="<?= site_url($browse_url . '4/' . $sorttype) ?>">Background Color</a></th>
            <th><a href="<?= site_url($browse_url . '5/' . $sorttype) ?>">Date From</a></th>
            <th><a href="<?= site_url($browse_url . '6/' . $sorttype) ?>">Date To</a></th>
            <th><a href="<?= site_url($browse_url . '9/' . $sorttype) ?>">Plant Name</a></th>         
        </tr>
        <?php if ($list_m_sqa_running_text): $i = 1; foreach ($list_m_sqa_running_text as $l): ?>
        <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
            <td style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cek[]" value="<?= $l->PLANT_CD ?>"/></td>
            <td colspan="2" nowrap="nowrap" style="text-align: center;">
                <a href="<?= site_url('m_sqa_running_text/change/' . $l->PLANT_CD) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Edit" title="Edit"/></a>
                <a href="javascript:;" onclick="cekgo('<?= site_url('m_sqa_running_text/erase/' . $l->PLANT_CD) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a>
            </td>            
            <td><?= $l->RUNTEXT ?></td>
            <td style="text-align: center;"><?= $l->FONT_NM ?></td>
            <td style="text-align: center;"><?= $l->FONT_SIZE ?></td>
            <td style="text-align: center;">
                <span style="color: #<?= $l->FONT_CLR ?>"><?= $l->FONT_CLR ?></span>
            </td>
            <td style="text-align: center;">
                <span style="color: #<?= $l->BACKGROUND_CLR ?>"><?= $l->BACKGROUND_CLR ?></span>                
            </td>
            <td style="text-align: center;"><?= $l->DATE_FROM ?></td>
            <td style="text-align: center;"><?= $l->DATE_TO ?></td>
            <td style="text-align: center;"><?= $l->PLANT_NM ?></td>
        </tr>
        <?php $i++; endforeach; else: ?>
        <tr class="row-b">
            <td colspan="16" style="text-align: center;">Data Is Empty</td>
        </tr>
        <?php endif; ?>
    </table>
    <div class="pagination"><p><?= ($pagination != '') ? "Page: " . $pagination . "<br /><br />" : '' ?></p></div>
</form></section></div></div></div>