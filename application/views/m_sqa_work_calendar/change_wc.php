<div class="columns">
    <div class="column grid_6 first">


        <?php if ($err != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widgetform">
                <header>
                    <h2><?= ucwords($todo); ?> WORK CALENDAR</h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>

                        <table width="100%">
                            <tr>
                                <td>Plant</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top" width="20%" height="30">Fiscal Year</td>
                                <td style="vertical-align: top" width="2%">:</td>
                                <td style="vertical-align: top" >
                                    <input type="text" name="fiscal_year" value="" size="5" class="numeric" />
                                </td>
                            </tr>
                            <tr>
                                <td height="30">&nbsp;</td>
                                <td colspan="2" height="30">
                                    <input type="submit" name="btnSubmit" value="Create" class="button button-gray" />
                                    <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_work_calendar/browse') ?>'"/>
                                </td>
                            </tr>
                        </table>

                </form></section></div></div></div>