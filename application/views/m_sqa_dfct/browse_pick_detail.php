<table class="data" width="100%">
    <?php if ($list_dfct): $i = 1; foreach ($list_dfct as $l): ?>
    <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> style="cursor: pointer" onclick="pick_to_list('<?=$l->DFCT_ID?>', '<?=$l->DFCTNM?>', '<?=$l->CTG_GRP_ID?>', '<?=$l->CTG_ID?>','<?=$l->CTG_GRP_NM?>');" >
        <td width="40" style="text-align: center;"><a href="javascript:;" onclick="parent.pick_dfct('<?= $l->DFCT_ID ?>')"><img src="<?= base_url() ?>assets/img/icon_accept.png" alt="Pick" title="Pick Defect"/></a></td>
        <td width="50"><?= $l->DFCT_ID ?></td>
        <td width="300"><?= $l->DFCTNM ?></td>
        <td width="220"><?= $l->CTG_GRP_NM ?></td>
        <td><?= $l->CTG_NM ?></td>
    </tr>
    <?php $i++; endforeach; else: ?>
    <tr class="row-b">
        <td colspan="7">Data Is Empty</td>
    </tr>
    <?php endif; ?>
</table>