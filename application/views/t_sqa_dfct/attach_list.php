<table class="data" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <th width="2%">No</th>
        <th>Attachment</th>
        <th>Remove</th>
    </tr>
    <?php if (count($attch)>0): $i=1; foreach ($attch as $a): ?>
    <tr class="row-<?=($i%2==0)?'a':'b'?>">
        <td><?=$i?></td>
        <td>
            <?php if (file_exists(PATH_ATTCH . $a->ATTACH_DOC)) : ?>
            <a href="<?=site_url('welcome/download_file/' . AsciiToHex(base64_encode($a->ATTACH_NAME.';'.PATH_ATTCH . $a->ATTACH_DOC)))?>"><?=$a->ATTACH_NAME?></a>
            <?php endif; ?>
        </td>
        <td>
            <a href="javascript:;" class="tested" onclick="on_remove_attach('<?= $a->PROBLEM_ID?>','<?=  $a->FILE_ID?>')">Remove</a>
        </td>
    </tr>
    <?php $i++; endforeach; else: ?>
    <tr>
        <td colspan="3">Empty Attachment</td>
    </tr>
    <?php endif; ?>
</table>