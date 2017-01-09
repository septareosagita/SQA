<script type="text/javascript">
    function change_work_flag(plant_cd, work_prdt, shiftno, work_flag) {
        $.post('<?=site_url('m_sqa_work_calendar/change_work_flag')?>',{plant_cd: plant_cd, work_prdt:work_prdt, shiftno: shiftno, work_flag: work_flag},function(html){
            $('#wf_status_' + plant_cd + work_prdt + shiftno).html(html);
        });;
    }
    
    function del_fiscal() {
        var year = prompt('Input Fiscal year to Delete all work calendar', '');
        if (year) {
            cekgod('<?=site_url('m_sqa_work_calendar/erasefiscal')?>' + '/' + year, 'Are you sure to delete All Record per fiscal year ' + year + ' ?');
        }
    }
    
    function on_change_shiftgrp(plant_cd, work_prdt, shiftno, shiftgrp_id) {
        $('#change_shiftgrp_' + plant_cd + work_prdt + shiftno).html("<img src='<?= base_url() ?>assets/img/ajax-loader.gif' />");
        $.post('<?=site_url('m_sqa_work_calendar/get_shiftgrp')?>',{plant_cd: plant_cd, work_prdt:work_prdt, shiftno: shiftno, shiftgrp_id : shiftgrp_id}, function(html){
            $('#change_shiftgrp_' + plant_cd + work_prdt + shiftno).html(html);
        });
    }
    
    function set_shiftgrp(plant_cd, work_prdt, shiftno) {
        $.post('<?=site_url('m_sqa_work_calendar/set_shiftgrp')?>',{plant_cd: plant_cd, work_prdt:work_prdt, shiftno: shiftno, shiftgrp_id:$('#shiftgrp_id_'+plant_cd+work_prdt+shiftno).val()}, function(html){
            $('#change_shiftgrp_' + plant_cd + work_prdt + shiftno).html(html);
        });
    }
</script>
<div class="columns">
    <div class="column grid_6 first">
        <?php if ($err != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widget">
                <header>
                    <h2>WORK CALENDAR &raquo; INQUIRY</h2>
                </header>
                <section>
                    <form name="fList" method="post" action="">
                        <input type="hidden" name="searchkey" value="" />
                        <table width="100%">
                            <tr>
                                <td width="20%" height="30">Fiscal Year</td>
                                <td width="2%">:</td>
                                <td>
                                    <select name="fiscal_year" id="fiscal_year">
                                        <option value="0">-- All --</option>
                                        <?php foreach ($list_fy as $l): ?>
                                        <option value="<?=$l->FISCAL_YEAR?>" <?=($l->FISCAL_YEAR == $fiscal_year)?'selected="selected"':''?>><?=$l->FISCAL_YEAR?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td height="35">Date Range</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="work_prdt_from" id="work_prdt_from" size="7" value="<?=$work_prdt_from?>" onclick="this.select()" /> To
                                    <input type="text" name="work_prdt_to" id="work_prdt_to" size="7" value="<?=$work_prdt_to?>" onclick="this.select()" />
                                    <br/>
                                    <a href="javascript:;" onclick="$('#work_prdt_from').val(''); $('#work_prdt_to').val('')" class="tested">&radic; All Date</a>
                                    <br/><br/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td>
                                    <input type="submit" name="btnSubmitSearch" value="Search" class="button button-gray"/>
                                    <input type="button" name="btnAdd" value="New Record (per Fiscal Year)" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_work_calendar/change') ?>'"/>
                                    <input type="button" name="btnDel" value="Delete (per Fiscal Year)" class="button button-gray" onclick="del_fiscal();" />
                                </td>
                            </tr>
                        </table>
                        <br/>

                    <?php if ($searchkey != ''): ?>
                        <p>Search Result for the <strong>"<?= $searchkey ?>"</strong>
                            (Found <?= count($list_m_sqa_work_calendar) ?> Content) [<a href="<?= site_url('m_sqa_work_calendar/browse'); ?>">Clear</a>] :
                        </p>
                    <?php endif; ?>

                        <table class="data" width="100%">
                            <tr>
                                <th width="20%" style="border-left: 1px solid #cccccc;"><a href="<?= site_url($browse_url . '0/' . $sorttype) ?>">Date</a></th>
                                <th><a href="<?= site_url($browse_url . '1/' . $sorttype) ?>">Work Flag</a></th>
                                <th><a href="<?= site_url($browse_url . '2/' . $sorttype) ?>">Shift No</a></th>
                                <th><a href="<?= site_url($browse_url . '3/' . $sorttype) ?>">Shift Group</a></th>
                                <th><a href="<?= site_url($browse_url . '4/' . $sorttype) ?>">Fiscal Year</a></th>
                                <th><a href="<?= site_url($browse_url . '5/' . $sorttype) ?>">Week</a></th>
                                <th><a href="<?= site_url($browse_url . '6/' . $sorttype) ?>">Plant</a></th>
                            </tr>
                        <?php if ($list_m_sqa_work_calendar): $i = 1;
                            foreach ($list_m_sqa_work_calendar as $l): 
                                $d_prdt = explode('-', $l->WORK_PRDT);
                                $d_prdt = $d_prdt[2];
                                ?>
                                <tr <?= ($d_prdt % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
                                    <?php
                                        $tx = explode('-', $l->WORK_PRDT);
                                        $d = date("l", mktime(0, 0, 0, $tx[1], $tx[2], $tx[0]));
                                    ?>
                                    <td style="border-left: 1px solid #cccccc; text-align: center;" nowrap="nowrap"><?= conv_date('2', $l->WORK_PRDT) . ', ' . $d ?></td>
                                    <td style="text-align: center;" id="wf_status_<?=$l->PLANT_CD.$l->WORK_PRDT.$l->SHIFTNO?>">
                                        <a href="javascript:;" onclick="change_work_flag('<?=$l->PLANT_CD?>', '<?=$l->WORK_PRDT?>', '<?=$l->SHIFTNO?>', '<?=($l->WORK_FLAG=='1')?'0':'1'?>');" title="Click to Change Work Flag Status">
                                            <img src="<?=base_url()?>assets/img/icon_<?= ($l->WORK_FLAG=='1')?'accept':'error' ?>.png" alt="<?= ($l->WORK_FLAG=='1')?'Yes':'No' ?>" />
                                        </a>
                                    </td>
                                    <td style="text-align: left;"><?= $l->SHIFTNO ?> - <?= $l->DESCRIPTION ?></td>
                                    <td style="text-align: center;" id="change_shiftgrp_<?=$l->PLANT_CD.$l->WORK_PRDT.$l->SHIFTNO?>">
                                        <a href="javascript:;" onclick="on_change_shiftgrp('<?=$l->PLANT_CD?>', '<?=$l->WORK_PRDT?>', '<?=$l->SHIFTNO?>', '<?=$l->SHIFTGRP_ID?>');" class="tested">
                                            <?= ($l->SHIFTTGRP_NM!='')?$l->SHIFTTGRP_NM:'Set Group &raquo;' ?>
                                        </a>
                                    </td>
                                    <td style="text-align: center;"><?= $l->FISCAL_YEAR ?></td>
                                    <td style="text-align: center;"><?= $l->WEEK ?></td>
                                    <td style="text-align: center;"><?= $l->PLANT_CD ?></td>
                                </tr>
                        <?php
                                $i++;
                            endforeach;
                        else:
                        ?>
                            <tr class="row-b">
                                <td colspan="15">Data Is Empty</td>
                            </tr>
                        <?php endif; ?>
                        </table>
                        <div class="pagination"><p><?= ($pagination != '') ? "Page: " . $pagination . "<br /><br />" : '' ?></p></div
                </form></section></div></div></div>

<script type="text/javascript">
    $(function(){
        $("#work_prdt_from").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
        $("#work_prdt_to").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
    });
</script>