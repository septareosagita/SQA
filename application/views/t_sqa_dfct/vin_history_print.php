<html>
    <head>
    <style>
        body {font-size: 60%; font-family: sans-serif;}
        table.no-style {
            border: none;
            border-collapse: collapse;
            padding: 0;
            margin: 0;
            background: none;
        
        }
        table.full {
            width: 100%;
        }
        
        table.no-style td, table.no-style th {
            background: none;
            border: none;
        }
        
        table.paginate {
            border: 0px solid #aaa;
            border-collapse: separate;
        }
        
        table.paginate thead th {
            background: #f7f7f7;
            background: -webkit-gradient(linear, left top, left bottom, from(#f7f7f7), to(#e1e1e1));
            background: -moz-linear-gradient(top,  #f7f7f7,  #e1e1e1);
            filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f7f7f7', endColorstr='#e1e1e1');
            color: #333;
            cursor: pointer;
            padding: 10px;
            text-shadow: 0 1px 0 #fff;
        }
        
        table.paginate, table.paginate thead th:first-child {
            -moz-border-radius-topleft: 5px;
            -webkit-border-top-left-radius: 5px;
            -khtml-border-top-left-radius: 5px;
            border-top-left-radius: 5px;
        }
        
        table.paginate, table.paginate thead th:last-child {
            -moz-border-radius-topright: 5px;
            -webkit-border-top-right-radius: 5px;
            -khtml-border-top-right-radius: 5px;
            border-top-right-radius: 5px;
        }
        
        table.paginate, table.paginate tr:last-child td:first-child {
            -moz-border-radius-bottomleft: 5px;
            -webkit-border-bottom-left-radius: 5px;
            -khtml-border-bottom-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
        
        table.paginate, table.paginate tr:last-child td:last-child {
            -moz-border-radius-bottomright: 5px;
            -webkit-border-bottom-right-radius: 5px;
            -khtml-border-bottom-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        
        table.paginate th, table.paginate td {
            padding: 5px;
        }
        
        table.paginate tr:nth-child(odd) td {
            background: #f9f9f9;
        }
        
        table.paginate td.column-selected {
            background: #ffffc0 !important;
        }
        
        
        /* added by satriadarma */
        
        table.data tbody tr td, table.data tr th
        {
            border: 1px solid #cccccc;
            text-align: left;
            padding: 2px;
        
        }
        
        table.data tr th
        {
            font-weight: bold;
            background: #eaeaea;
            text-shadow:0 1px 0 #ffffff;  
            /*border-right: 1px solid #cccccc;*/
            border-top: 1px #cccccc solid;
            border-bottom: 1px #cccccc solid;
            vertical-align: middle;
            text-align: center;
        }
        
        table.data tr td
        {
            color: #666666;
            border-right: 1px solid #cccccc;
            vertical-align: middle;    
        }
        
        table.data tr tt
        {
            color: #666666;
        }
        
        tr.row-a {
            background: #F3F3F3;
        }
        tr.row-a:hover {
            background: #FFCCCC;
            /*	text-shadow:0 1px 0 #ffffff;*/
        }
        tr.row-b {
            background: #FFFFFF;
        }
        tr.row-b:hover {
            background: #FFCCCC;
            /*	text-shadow:0 1px 0 #ffffff;*/
        }
        
        tr.active {
            background: #FFCCCC;
            /*font-weight: bold;*/
            
            /*    text-shadow:0 1px 0 #ffffff;*/
        }
        
        /* css tambahan untuk tooltips SQA Status */
        
        span.tool {
            position: relative;  
            cursor: help;
        
        }
        
        span.tool span.tip {
            display: none;    
        
        }
        
        /* tooltip will display on :hover event */
        
        span.tool:hover span.tip {
            display: block;
            z-index: 100;
            position: absolute;
            bottom: 1.8em;
            right: 0.5em;
            width: 100px;
            padding: 3px 7px 4px 6px;
            border: 1px solid #bbbbbb;
            background-color: #f7f7ee;
            font-family: sans-serif;
            text-align: center;
            color: #000;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            -khtml-border-radius: 3px;
            border-radius: 3px;
        
        }
        
        
        table.data thead
        {
            border-bottom: 1px solid #cccccc;
            text-align: left;
            padding: 0px;
            background: #eaeaea;
            font-weight: bold;
        }
        
        table.data tbody 
        {
            padding: 0px;
            text-align: left;
            border-bottom: 1px solid #cccccc;
        
        }
        
        table.data2 tr th
        {
            font-weight: bold;
            background: #eaeaea;
            text-shadow:0 1px 0 #ffffff;  
            border-right: 1px solid #888;
            border-top: 1px #888 solid;
            border-left: 1px #888 solid;
            border-bottom: 1px #888 solid;
            text-align: center;
            vertical-align: middle;
            padding: 1px;
        }
        
        table.data2 td
        {
            color: #666666;
            border: 1px solid #888;
            text-align: center;
            vertical-align: middle;
            padding: 1px;    
        }
        
        
        /* table fixed header */
        
        .fht-table th,
        .fht-table thead{
            margin: 2px;
            background: #eaeaea;
            padding: 2px;
            border-bottom: 1px solid #cccccc;
            text-align: left;
            font-weight: bold;
        }
        
        .fht-table tbody,
        .fht-table td,
        .fht-table tr{
        
            border-bottom: 1px solid #cccccc;
            text-align: left;
        
        
        }
        
        
        .fht-table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        
        /* @end */
        
        /* @group Content */
        
        div.fht-table-wrapper {
            overflow: hidden;
        }
        
        div.fht-tbody {
            overflow-y: auto;
            overflow-x: auto;
        }
        
        .fht-table .fht-cell {
            overflow: hidden;
            height: 1px;
        }
    </style>
    
    <script type="text/javascript">
        // set portrait orientation
       jsPrintSetup.setOption('orientation', jsPrintSetup.kLandscapeOrientation);
       // set scalling
       jsPrintSetup.setOption('scaling', 70);       
       // set top margins in millimeters
       jsPrintSetup.setOption('marginTop', 15);
       jsPrintSetup.setOption('marginBottom', 15);
       jsPrintSetup.setOption('marginLeft', 10);
       jsPrintSetup.setOption('marginRight', 10);
       // set page header
       jsPrintSetup.setOption('headerStrLeft', '&T');
       jsPrintSetup.setOption('headerStrCenter', '');
       jsPrintSetup.setOption('headerStrRight', '&PT');
       // set empty page footer
       jsPrintSetup.setOption('footerStrLeft', '');
       jsPrintSetup.setOption('footerStrCenter', '');
       jsPrintSetup.setOption('footerStrRight', '');       
       jsPrintSetup.clearSilentPrint();       
       jsPrintSetup.print();    
      
    </script>
    
    </head>
    
</html>

<h1>PT. TMMIN - Shipping Quality Audit - Vehicle History</h1>
<hr size="1" />
<table width="100%" border="0" class="data">
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

<h1>Status List Defect QIS</h1>
<hr size="1" />
<table width="100%" border="0" class="data">
    <tr>
        <th width="20%">INSPJOB</th>
        <th>INSPSJOB</th>
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
        <?php foreach ($list_dfctqis as $l): ?>
            <tr>
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
        <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td style="text-align: center;" colspan="14">No History Defect on QIS</td>
    </tr>
    <?php endif; ?>
</table>

<h1>Status SQA</h1>
<hr size="1" />
<table width="<?=($print=='')?'200':'100'?>%" border="1" class="data">
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