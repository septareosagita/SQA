<h2 style="font-weight: bold">II. LIST DEFECT</h2>
<table width="100%">

    <?php if (count($dfct) >0): $i=1; foreach ($dfct as $d): ?>

    <tr>
        <td width="5%"><?=$i?>. </td>
        <td>Defect</td>
        <td width="1%">:</td>
        <td><?=$d->DFCT?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Rank</td>
        <td>:</td>
        <td><?=$d->RANK_NM?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Category Group</td>
        <td>:</td>
        <td><?=$d->CTG_GRP_NM?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Category Name</td>
        <td>:</td>
        <td><?=$d->CTG_NM?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Measurement</td>
        <td>:</td>
        <td><?=$d->MEASUREMENT?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Reference Value</td>
        <td>:</td>
        <td><?=$d->REFVAL?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Image</td>
        <td>:</td>
        <td>
            &nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>            
            <?php if ($d->MAIN_IMG!=''): if (file_exists(PATH_IMG . $d->MAIN_IMG)): ?>
            <img src="<?=PATH_IMG_URL.$d->MAIN_IMG?>" alt="Main Image" width="900" height="900" />            
            <?php endif; endif?>
        </td>
        <td>&nbsp;</td>
        <td>
            <?php if ($d->PART_IMG!=''): if (file_exists(PATH_IMG . $d->PART_IMG)): ?>
            <img src="<?=PATH_IMG_URL.$d->PART_IMG?> " alt="Part Image" width="900" height="900" />
            <?php endif; endif?>
        </td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;<br/></td>
    </tr>    

    <?php $i++; endforeach; endif; ?>
</table>