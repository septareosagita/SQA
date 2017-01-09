<style>
    .fakeContainer { /* The parent container */
        margin: 10px;
        padding: 0px;
        border: none;
        width: auto; /* Required to set */
        height: 150px; /* Required to set */
        overflow: hidden; /* Required to set */
    }        
</style>
<script type="text/javascript">
    function on_print_qis() {
        window.open('<?=site_url('t_sqa_dfct/vin_history/'.$this->uri->segment(3).'/print')?>');        
    }
</script>
<section class="grid_8">
    <div class="columns leading">
        <div class="grid_8 first" style="width: 950px;">
            <div class="widget">
                <header>
                    <h2 style="cursor: pointer" onclick="$('#widget_vehicle').toggle()">VEHICLE</h2>
                    <input type="hidden" value="" id="idno" name="idno" />
                    <input type="hidden" value="" id="refno" name="reno" />
                </header>
                <section id="widget_vehicle">
                    <table width="100%" border="0">
                        <tr>
                            <td width="9%" height="29">Body No</td>
                            <td width="1%">:</td>
                            <td width="18%"><input type="text" name="body_no" id="body_no" onclick="this.select();" value="<?=$vin->BODY_NO?>" /></td>
                            <td width="9%">Frame No</td>
                            <td width="1%">:</td>
                            <td width="19%"><input type="text" name="vinno" id="vinno" onclick="this.select();" value="<?=$vin->VINNO?>"/></td>
                            <td width="12%">Inspection Date</td>
                            <td width="1%">:</td>
                            <td width="21%"><input type="text" name="insp_pdate" id="insp_pdate" readonly="readonly" value="<?=$vin->INSP_PDATE?>"/></td>                            
                        </tr>
                        <tr>
                            <td height="29">Suffix No</td>
                            <td>:</td>
                            <td><input type="text" name="suffix" id="suffix" readonly="readonly" value="<?=$vin->SUFFIX?>"/></td>
                            <td>Model Code</td>
                            <td>:</td>
                            <td><input type="text" name="katashiki" id="katashiki" readonly="readonly" value="<?=$vin->KATASHIKI?>"/></td>
                            <td>Production Date</td>
                            <td>:</td>
                            <td><input type="text" name="assy_pdate" id="assy_pdate" readonly="readonly" value="<?=$vin->ASSY_PDATE?>"/></td>                            
                        </tr>
                        <tr>
                            <td>Seq Body No.</td>
                            <td>:</td>
                            <td><input type="text" name="bd_seq" id="bd_seq" readonly="readonly" value="<?=$vin->BD_SEQ?>"/></td>
                            <td>Seq Assy No</td>
                            <td>:</td>
                            <td><input type="text" name="assy_seq" id="assy_seq" readonly="readonly" value="<?=$vin->ASSY_SEQ?>"/></td>
                            <td>Color</td>
                            <td>:</td>
                            <td><input type="text" name="extclr" id="extclr" readonly="readonly" value="<?=$vin->EXTCLR?>"/></td>                            
                        </tr>
                    </table>                    
                </section>
            </div>
            
            <div class="widget">
                <header>
                    <h2 style="cursor: pointer" onclick="$('#widget_qis').toggle()">Status List Defect QIS</h2>
                    <input type="hidden" value="" id="idno" name="idno" />
                    <input type="hidden" value="" id="refno" name="reno" />
                </header>
                <section id="widget_qis">
                    <?php if ($print == ''): ?>
                    <!--div align="center" style="height: auto; height: 150px; width: 940px; overflow: scroll; padding: 0px;" id="list_qis"-->
                    <div align="center" class="fakeContainer" id="list_qis">
                    <?php endif; ?>
                    
                        <table width="200%" border="0" class="data" id="demo1">
                            <tr>
                                <th width="10%">INSPJOB</th>
                                <th width="15%">INSPSJOB</th>
                                <th>IDFCT</th>
                                <th>SDFCT</th>
                                <th>DFCTCTG</th>
                                <th>DFCTNM</th>
                                <th>RPK_FLAG</th>
                                <th>OK_ITEM_FLAG</th>
                                <th>SHOP</th>
                                <th>CHKPDATE/CHKPTIME</th>
                                <th>CHKPSHIFT</th>
                                <th>CHKINSP</th>
                                <th>CHKSHIFTGRP</th>
                                <th>SAFETY_FLG</th>
                            </tr>
                            <?php if (count($list_dfctqis)>0): ?>
                                <?php $i=0; foreach ($list_dfctqis as $l): $c = ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\""; ?>
                                    <tr <?=$c?>>
                                        <td><?=$l->INSPJOB?></td>
                                        <td><?=$l->INSPSJOB?></td>
                                        <td><?=$l->IDFCT?></td>
                                        <td><?=$l->SDFCT?></td>
                                        <td><?=$l->DFCTCTG?></td>
                                        <td><?=$l->DFCTNM?></td>
                                        <td><?=$l->RPK_FLAG?></td>
                                        <td><?=$l->OK_ITEM_FLAG?></td>
                                        <td><?=$l->SHOP?></td>
                                        <td><?=$l->CHKPDATE?>/<?=$l->CHKPTIME?></td>
                                        <td><?=$l->CHKPSHIFT?></td>
                                        <td><?=$l->CHKINSP?></td>
                                        <td><?=$l->CHKSHIFTGRP?></td>
                                        <td><?=$l->SAFETY_FLG?></td>
                                    </tr>
                                <?php $i++; endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td style="text-align: center;" colspan="14">No History Defect on QIS</td>
                            </tr>
                            <?php endif; ?>
                        </table>
                        
                    <?php if ($print == ''): ?>                        
                    </div>
                    <?php endif; ?>
                    
                </section>
            </div>
            
            <?php if ($print == ''): ?>
            <div class="widget">                
                <header>
                    <h2 style="cursor: pointer" onclick="$('#widget_sqa').toggle()">Status SQA</h2>
                    <input type="hidden" value="" id="idno" name="idno" />
                    <input type="hidden" value="" id="refno" name="reno" />
                </header>
            <?php else: ?>
                    <h1>Status SQA</h1>
            <?php endif; ?>
                <?php if ($print == ''): ?>
                <section id="widget_sqa">                    
                    <div align="center" class="fakeContainer" id="list_sqa">
                    <?php endif; ?>
                        <table width="<?=($print=='')?'200':'100'?>%" border="0" class="data" id="demo2">
                            <tr>
                                <th width="7%">Rank</th>
                                <th width="9%">Category Group</th>
                                <th width="7%">Category Name</th>
                                <th width="8%">Respons. Shop</th>
                                <th width="10%">Measurement</th>
                                <th width="9%">Reference Value</th>
                                <th width="9%">Conf By QCD</th>
                                <th width="14%">Conf By Related Div</th>
                                <th width="9%">Inspection Item</th>
                                <th width="8%">Quality Gate Item</th>
                                <th width="10%">History Repair Process</th>
                            </tr>
                            <?php if (count($list_dfct) >0): $i=0; foreach ($list_dfct as $l): $c = ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"";?>
                            <tr <?=$c?>>
                                <td style="text-align: center;"><?=$l->RANK_NM?></td>
                                <td style="text-align: center;"><?=$l->CTG_GRP_NM?></td>
                                <td style="text-align: center;"><?=$l->CTG_NM?></td>
                                <td style="text-align: center;"><?=$l->SHOP_NM?></td>
                                <td style="text-align: center;"><?=$l->MEASUREMENT?></td>
                                <td style="text-align: center;"><?=$l->REFVAL?></td>
                                <td style="text-align: center;">
                                    <?php
                                        if (is_array($list_confby[$l->PROBLEM_ID][0])) {
                                            $list_confby_qcd = $list_confby[$l->PROBLEM_ID][0];
                                            if (count($list_confby_qcd) > 0) {
                                                foreach ($list_confby_qcd as $q) {
                                                    echo $q->CONF_BY . ', ';
                                                }
                                            }
                                        }
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                                        if (is_array($list_confby[$l->PROBLEM_ID][1])) {
                                            $list_confby_qcd = $list_confby[$l->PROBLEM_ID][1];
                                            if (count($list_confby_qcd) > 0) {
                                                foreach ($list_confby_qcd as $q) {
                                                    echo $q->CONF_BY . ', ';
                                                }
                                            }
                                        }
                                    ?>
                                </td>
                                <td style="text-align: center;"><?=$l->INSP_ITEM_FLG?></td>
                                <td style="text-align: center;"><?=$l->QLTY_GT_ITEM?></td>
                                <td style="text-align: center;"><?=$l->REPAIR_FLG?></td>
                            </tr>
                            <?php $i++; endforeach; endif; ?>
                        </table>
                    <?php if ($print == ''): ?>
                    </div>                    
                </section>                
            </div>
            <?php endif; ?>
            
            <?php if ($print == ''): ?>
            <div style="text-align: right;">
                <input type="button" name="btnPrint" id="btnPrint" value="Print" class="button button-gray" style="width:100px;" onclick="on_print_qis();" />
                <input type="button" name="btnClose" id="btnClose" value="Close" class="button button-gray" style="width:100px;" onclick="parent.$.fancybox.close();" />
            </div>
            <?php else: ?>
            <script>window.print()</script>
            <?php endif; ?>
            
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function(){
        new superTable("demo1", {cssSkin : "sDefault"});         
        new superTable("demo2", {cssSkin : "sDefault"});
    });
</script>