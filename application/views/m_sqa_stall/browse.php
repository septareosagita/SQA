<div class="columns">
    <div class="column grid_6 first">
        <?php if ($err != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widget">
                <header>
                    <h2>STALL &raquo; INQUIRY</h2>
                </header>
                <section>
                    <form name="fList" method="post" action="">
                        <p>Search:
                            <input type="text" name="searchkey" value="<?= $searchkey ?>" size="45"/>
                            <input type="submit" name="btnSubmitSearch" value="Search" class="button button-gray"/>
                            <input type="button" name="btnAdd" value="New Record" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_stall/change') ?>'"/>
                            <input type="button" name="btnAdd" value="Delete Selected" class="button button-gray" onclick="cekdulu(this.form);"/>
                        </p><br>

                    <?php if ($searchkey != ''): ?>
                        <p>Search Result for the <strong>"<?= $searchkey ?>"</strong>
                            (Found <?= count($list_m_sqa_stall) ?> Content) [<a href="<?= site_url('m_sqa_stall/browse'); ?>">Clear</a>] :
                        </p>
                    <?php endif; ?>

                        <table class="data" width="100%">
                            <tr>
                                <th width="5%" style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cekall" onclick="cek(this.form);" id="cekall"/></th>
                                <th width="5%">Action</th>
                                <th><a href="<?= site_url($browse_url . '0/' . $sorttype) ?>">Plant Code</a></th>
                                <th><a href="<?= site_url($browse_url . '1/' . $sorttype) ?>">Stall Number</a></th>
                                <th><a href="<?= site_url($browse_url . '2/' . $sorttype) ?>">Stall Description</a></th>
                                <th><a href="<?= site_url($browse_url . '3/' . $sorttype) ?>">Stall Status</a></th>
                                <th><a href="<?= site_url($browse_url . '4/' . $sorttype) ?>">Shop</a></th>
                            </tr>
                        <?php if ($list_m_sqa_stall): $i = 1;
                            foreach ($list_m_sqa_stall as $l): ?>
                                <tr <?= ($i % 2 == 0) ? "class=\"row-a\"" : "class=\"row-b\"" ?> >
                                    <td style="text-align: center; border-left: 1px solid #cccccc;"><input type="checkbox" name="cek[]" value="<?= AsciiToHex(base64_encode($l->PLANT_CD . ';' . $l->STALL_NO)) ?>"/></td>
                                    <td nowrap="nowrap" style="text-align: center;">
                                        <a href="<?= site_url('m_sqa_stall/change/' . AsciiToHex(base64_encode($l->PLANT_CD . ';' . $l->STALL_NO))) ?>"><img src="<?= base_url() ?>assets/style/images/add19.gif" alt="Edit" title="Edit"/></a>
                                        <a href="javascript:;" onclick="cekgo('<?= site_url('m_sqa_stall/erase/' . $l->PLANT_CD . '/' . $l->STALL_NO) ?>')"><img src="<?= base_url() ?>assets/style/images/delete19.gif" alt="Delete" title="Delete"/></a>
                                    </td>                                    
                                    <td style="text-align: center;"><?= $l->PLANT_CD ?></td>
                                    <td style="text-align: center;"><?= $l->STALL_NO ?></td>
                                    <td style="text-align: center;"><?= $l->STALL_DESC ?></td>
                                    <td style="text-align: center;"><?= ($l->STALL_STS=='0')?'Available':'Used' ?></td>
                                    <td style="text-align: center;"><?= $l->SHOP_NM ?></td>
                                </tr>
                        <?php
                                $i++;
                            endforeach;
                        else:
                        ?>
                            <tr class="row-b">
                                <td colspan="11">Data Is Empty</td>
                            </tr>
                        <?php endif; ?>
                        </table>
                        <div class="pagination"><p><?= ($pagination != '') ? "Page: " . $pagination . "<br /><br />" : '' ?></p></div>
                </form></section></div></div></div>
