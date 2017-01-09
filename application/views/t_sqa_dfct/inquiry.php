<div class="widgetform">
    <header>
        <h2>Searching</h2>
    </header>
    <section>
        <form>
            <table width="100%" border="0" class="data">
                <tr>
                    <td colspan="9" style="border-bottom: 1px solid #dadada; font-weight: bold">Sqa Date</td>
                </tr>
                <tr>
                    <td colspan="4">From
                        <input type="text" name="search_from" id="search_from" size="8" style="text-align: center" />
                        Until
                        <input type="text" name="search_to" id="search_to" size="8" style="text-align: center" /></td>
                    <td colspan="2">Shift
                        <select name="select" id="select">
                        </select></td>
                    <td colspan="2">Responsible Shop
                        <select name="select2" id="select2">
                        </select></td>
                    <td width="15%"><input type="checkbox" name="checkbox" id="checkbox" />
                        Auto Refresh</td>
                </tr>
                <tr>
                    <td colspan="9" style="border-bottom: 1px solid #dadada; font-weight: bold">Company Data</td>
                </tr>
                <tr>
                    <td width="16%">Company
                        <select name="select3" id="select3">
                        </select></td>
                    <td width="16%">Plant
                        <select name="select4" id="select4">
                        </select></td>
                    <td width="13%">Line
                        <select name="select5" id="select5">
                        </select></td>
                        <td colspan="6" style="text-align: right">
                        <input type="button" name="button" id="button" value="Search"  class="button button-gray" />
                        <input type="button" name="button2" id="button2" value="Advance Search"  class="button button-gray" onclick="$('#adv_search').toggle('slow')"/>
                        <input type="button" name="button3" id="button3" value="Entry Data"  class="button button-gray"/></td>
                </tr>
            </table>
        </form>
    </section>
</div>

<div class="widgetform" id="adv_search" style="display: none">
    <header>
        <h2>Advanced Search</h2>
    </header>
    <section>
        <form>
            <table width="100%" border="0" class="data">
                <tr>
                    <td colspan="9" style="border-bottom: 1px solid #dadada; font-weight: bold">Sqa Date</td>
                </tr>
                <tr>
                    <td colspan="4">From
                        <input type="text" name="search_from" id="search_from" size="8" style="text-align: center" />
                        Until
                        <input type="text" name="search_to" id="search_to" size="8" style="text-align: center" /></td>
                    <td colspan="2">Shift
                        <select name="select" id="select">
                        </select></td>
                    <td colspan="2">Responsible Shop
                        <select name="select2" id="select2">
                        </select></td>
                    <td width="15%"><input type="checkbox" name="checkbox" id="checkbox" />
                        Auto Refresh</td>
                </tr>
                <tr>
                    <td colspan="9" style="border-bottom: 1px solid #dadada; font-weight: bold">Company Data</td>
                </tr>
                <tr>
                    <td width="16%">Company
                        <select name="select3" id="select3">
                        </select></td>
                    <td width="16%">Plant
                        <select name="select4" id="select4">
                        </select></td>
                    <td width="13%">Line
                        <select name="select5" id="select5">
                        </select></td>
                        <td colspan="6" style="text-align: right">
                        <input type="submit" name="button" id="button" value="Search"  class="button button-gray" />
                        <input type="submit" name="button2" id="button2" value="Advance Search"  class="button button-gray"/>
                        <input type="submit" name="button3" id="button3" value="Entry Data"  class="button button-gray"/></td>
                </tr>
            </table>
        </form>
    </section>
</div>

<script type="text/javascript">
    $(function(){
        $("#search_from").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
        $("#search_to").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
    });
</script>