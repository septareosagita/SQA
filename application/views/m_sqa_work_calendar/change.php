<div class="columns">
    <div class="column grid_6 first">


       <?php if ($err != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widgetform">
                <header>
                    <h2>WORK CALENDAR &raquo; <?= ucwords($todo); ?></h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>

                        <fieldset>
                            <dl>
                                <dd>
                                    <label>Fiscal Year</label>
                                    <input type="text" name="FISCAL_YEAR" value="" maxlength="4" size="5" class="numeric" />
                                </dd>
                                <dd>
                                    <label>Date Range </label>
                                    <input type="text" name="r1" id="r1" value="<?=date('d/m/Y')?>" /> 
                                    <input type="text" name="r2" id="r2" value="<?=date('d/m/Y')?>" />
                                </dd>
                                <dd>
                                    <label>Plant</label>
                                    <select name="PLANT_CD">
                                        <?php foreach ($list_plant as $l): ?>
                                        <option value="<?=$l->PLANT_CD?>"><?=$l->PLANT_NM?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </dd>
                            </dl>
                        </fieldset>
                        <hr>
                        <input type="submit" name="btnSubmit" value="Next" class="button button-gray"/>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_work_calendar/browse') ?>'"/>

                </form></section></div></div></div>

<script type="text/javascript">
    $(function(){
        $("#r1").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
        $("#r2").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
    });
</script>