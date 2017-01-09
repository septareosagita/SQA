<div class="columns">
    <div class="column grid_x first">        
            <div class="widget">
                <header>
                    <h2><?=$ctg_grp->CTG_GRP_NM?> &raquo; Category Inquiry</h2>
                </header>
                <section>
                    <form name="fList" method="post" action="">
                        <p>
                            <input type="button" name="btnAdd" value="New Record" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_ctg/change/' . $this->uri->segment(3)) ?>'"/>                            
                        </p><br>
                        <table class="data" width="100%">
                            <tr>
                                <th colspan="2" width="5%" style="border-left: 1px solid #cccccc;">Action</th>
                                <th>Category Group</th>
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th>Valid</th>
                            </tr>
                        <?php if (count($list_ctg)>0): $i = 1;
                            foreach ($list_ctg as $l): ?>
                                <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
                                    <td colspan="2" nowrap="nowrap" style="border-left: 1px solid #cccccc;">
                                        <a href="<?= site_url('m_sqa_ctg/change/'. $this->uri->segment(3) .'/' . $l->CTG_ID) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Edit" title="Edit"/></a>
                                        <a href="javascript:;" onclick="cekgo('<?= site_url('m_sqa_ctg/erase/'. $this->uri->segment(3) .'/' . $l->CTG_ID) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a>
                                    </td>                                                                        
                                    <td style="text-align: center;"><?= $l->CTG_GRP_NM ?></td>
                                    <td style="text-align: center;"><?= $l->CTG_NM ?></td>
                                    <td style="text-align: center;"><?= $l->CTG_DESC ?></td>
                                    <td><?= conv_date(2, $l->VALID_FROM)?> To <?= conv_date(2, $l->VALID_TO) ?></td>
                                </tr>
                        <?php
                                $i++;
                            endforeach;
                        else:
                        ?>
                            <tr class="row-b">
                                <td colspan="8">Data Is Empty</td>
                            </tr>
                        <?php endif; ?>
                        </table>                        
                </form></section></div></div></div>