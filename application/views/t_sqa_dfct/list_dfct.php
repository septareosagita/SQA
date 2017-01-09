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

    function on_check_dfct(problem_id) {
        if ($('#dfct_' + problem_id).is(':checked')) {
            $('#problem_id').val(problem_id);            
            $('input[name=checkonlyone_dfct]').removeAttr('checked');
            $('#dfct_' + problem_id).attr('checked', 'checked');
        } else {
            $('#problem_id').val('');            
        }
        get_dfct_by_problem_id();
    }

    function on_check_dfct2(problem_id) {
        if ($('#dfct_' + problem_id).is(':checked')) {
            //alert('<?=$this->uri->segment(2)?>');
            $('#problem_id').val('');
            $('#tr_' + problem_id).removeAttr('class');
        } else {            
            $('#problem_id').val(problem_id);            
            $('input[name=checkonlyone_dfct]').removeAttr('checked');
            $('#dfct_' + problem_id).attr('checked', 'checked');
            get_dfct(problem_id);
        }        
        get_dfct_by_problem_id();
    }
    
</script>

<table class="data" width="100%" id="demoTable2">
  <tr>
    <!--th>&nbsp;</th-->
    <th style="text-align: center; border-left: 1px solid #cccccc;">Date</th>
    <th style="text-align: center;">Responsible</th>
    <th style="text-align: center;">Model</th>
    <th style="text-align: center;">Frame No.</th>
    <th style="text-align: center;">Body No.</th>
    <th style="text-align: center;">Color</th>
    <th style="text-align: center;">Defect</th>
    <th style="text-align: center;">Rank</th>
    <th style="text-align: center;">Category</th>
    <th style="text-align: center;">Preview</th>
    <th style="text-align: center;">Attach</th>
  </tr>
  <?php if ($list_dfct): $i=1; foreach ($list_dfct as $l):
        $c = ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"";
		$tit = "Click to select defect [".$l->PROBLEM_ID."]";
        if ($l->PROBLEM_ID == $problem_id) {
            $c = "class=\"active\" style=\"font-weight: bold; cursor: pointer\"";
			$tit = "Click to un-select defect [".$l->PROBLEM_ID."]";
        }
  ?>
  <tr <?= $c ?> onclick="on_check_dfct2('<?=$l->PROBLEM_ID?>')" style="cursor: pointer" id="tr_<?=$l->PROBLEM_ID?>" title="<?=$tit?>">
    <td style="display: none"><input type="checkbox" name="checkonlyone_dfct" id="dfct_<?=$l->PROBLEM_ID?>" onclick="on_check_dfct('<?=$l->PROBLEM_ID?>')" value="<?=  $l->PROBLEM_ID?>" style="cursor: pointer" title="Edit Defect" <?=($problem_id == $l->PROBLEM_ID)?'checked="checked"':''?>/> </td>    
    <td style="text-align: center; border-left: 1px solid #cccccc; width: 80px"><?= date('d-m-Y', strtotime($l->SQA_PDATE))?></td>
    <td style="text-align: center; width: 100px"><?= $l->SHOP_NM ?></td>
    <td style="text-align: center; width: 120px"><?= $l->KATASHIKI ?></td>
    <td style="text-align: center; width: 150px"><?= $l->VINNO ?></td>
    <td style="text-align: center; width: 70px"><?= $l->BODYNO ?></td>
    <td style="text-align: center; width: 50px"><?= $l->EXTCLR ?></td>
    <td style="text-align: center;"><?= $l->DFCT ?></td>
    <td style="text-align: center; width: 90px"><?= $l->RANK_NM ?> <?= $l->RANK_NM2 ?></td>
    <td style="text-align: center; width: 320px"><?= $l->CTG_NM ?></td>
    <td style="text-align: center;">
        <a href="<?=site_url('t_sqa_dfct/report_sqa/' . $l->PROBLEM_ID . '/' . $l->VINNO . '/r')?>">
            Preview
        </a>
    </td>
    <td style="text-align: center;">
        <a href="<?=site_url('t_sqa_dfct/upload_attch/' . $l->PROBLEM_ID)?>" class="view_detail">
            Attach
        </a>
    </td>
  </tr>
  <?php endforeach; endif; ?>
</table>