<script type="text/javascript">

    /*function on_check_vin2(bodyno) {        
        if ($('#vin_' + bodyno).is(':checked')) {            
            $('#body_no').val('');
			$('#problem_id').val('');
            get_vehicle('body_no');
            $('#content_dfct').html('');        
        } else {
            $('#body_no').val(bodyno);
            $('input[name=onlyone]').removeAttr('checked');
            $('#vin_' + bodyno).attr('checked', 'checked');
            get_vehicle('body_no');            
        }        
    }*/

    function on_check_vin2(vinno) {        
        if ($('#vin_' + vinno).is(':checked')) {            
            $('#vinno').val('');
			$('#problem_id').val('');
            get_vehicle('vinno');
            $('#content_dfct').html('');        
        } else {
            $('#vinno').val(vinno);
            $('input[name=onlyone]').removeAttr('checked');
            $('#vin_' + vinno).attr('checked', 'checked');
            get_vehicle('vinno');        
        }        
    }
</script>

<table class="data" id="demoTable" width="100%">
    <tr>
        <th>Date</th>
        <th>Model</th>
        <th>Frame No</th>
        <th>Body No</th>
        <th>Color</th>
        <th>Auditor 1</th>
        <th>Auditor 2</th>
        <th>Stall</th>
        <th>Input</th>
        <th>Finish</th>
        <th>Output</th>
    </tr>
    <?php if ($list_t_vinf): $i = 1; foreach ($list_t_vinf as $l):

            $c = ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"";
			$tit = "Click to show defect under Vehicle [".$l->VINNO."]";
            //if ($l->BODY_NO == $bodyno) { 
            /* edited by: irfan.satriadarma@gmail.com 201205070944pm */
            if ($l->VINNO == $vinno) {
                $c = "class=\"active\" style=\"font-weight: bold; cursor: pointer\"";
				$tit = "Click to unshow defect under Vehicle [".$l->VINNO."]";
            }
        ?>
    <!-- tr <?= $c ?> onclick="on_check_vin2('<?=$l->BODY_NO?>')" style="cursor: pointer" title="<?=$tit?>"-->
    <tr <?= $c ?> onclick="on_check_vin2('<?=$l->VINNO?>')" style="cursor: pointer" title="<?=$tit?>">
        <td style="text-align: center; border-left: 1px solid #cccccc;">
            <!-- input style="display: none;" type="checkbox" value="<?=$l->BODY_NO?>" id="vin_<?=$l->BODY_NO?>" onclick="on_check_vin('<?=$l->BODY_NO?>')" <?=($bodyno == $l->BODY_NO)?'checked="checked"':''?> name="onlyone" style="cursor: pointer" /-->
            <input style="display: none;" type="checkbox" value="<?=$l->VINNO?>" id="vin_<?=$l->VINNO?>" onclick="on_check_vin('<?=$l->VINNO?>')" <?=($vinno == $l->VINNO)?'checked="checked"':''?> name="onlyone" />
            <?= date('d-m-Y', strtotime($l->AUDIT_PDATE))?>
        </td>
        <td style="text-align: center;"><?= $l->DESCRIPTION ?></td>
        <td style="text-align: center;"><?= $l->VINNO ?></td>
        <td style="text-align: center;"><?= $l->BODY_NO ?></td>
        <td style="text-align: center;"><?= $l->EXTCLR ?></td>
        <td style="text-align: center;"><?= $l->AUDITOR_NM_1?></td>
        <td style="text-align: center;"><?= ($l->AUDITOR_NM_2==null)?'&nbsp;':$l->AUDITOR_NM_2?></td>
        <td style="text-align: center;"><?= $l->STALL_NO ?></td>
        <td style="text-align: center;"><?= date('d-m-Y H:i', strtotime($l->REG_IN))?></td>
        <td style="text-align: center;"><?= ($l->AUDIT_FINISH_PDATE=='')?'Not Yet':'Finish' ?></td>
        <td style="text-align: center;"><?= ($l->REG_OUT != '') ? date('d-m-Y H:i', strtotime($l->REG_OUT)) : ''?></td>
    </tr>
    <?php $i++; endforeach; else: ?>
    <tr class="row-b">
        <td style="text-align: center; border-left: 1px solid #cccccc;" colspan="11">- Data Is Empty -</td>
    </tr>
    <?php endif; ?>
    <tr>
        <td colspan="6"><?=$pagination?> </td>
        <td colspan="5" style="text-align: left;"><strong>Records:</strong> <?=$total_rows?></td>
    </tr>            
</table>

<script type="text/javascript">
    $(function() {
        $('#page').val('<?=$page?>');
    });
</script>