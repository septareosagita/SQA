<script type="text/javascript">

function disabled_button(button_id, status){
    for(var i in button_id)
{
    //alert(button_id[i]);
    if(status = 'disable'){
    $('#'+button_id[i]).attr('disabled','disabled');
    }
    else{
    $('#'+button_id[i]).removeAttr('disabled');     
    }
}

}

/* Edited : 20110720, cek user object : Important!*/
function cek_user_object() {
    
    var grpauth_id = '<?=get_user_info($this, 'GRPAUTH_ID')?>';
    
    <?php
        /* PENDING DULU */
        $usr_grpauth_id = get_user_info($this, 'GRPAUTH_ID');
        $usr_shop_id = get_user_info($this, 'SHOP_ID');
    ?>            
    
}

</script>
                    <div class="clear"></div>
                </div>
                <!--div id="push"></div-->
                <?php if ($this->uri->segment(1)!='monitoring'): ?>
                <br /><br /><br />
                <?php endif; ?>
            </section>
        </div>

    <footer id="page-footer">
        <div id="footer-inner">            
            <p class="wrapper" style="text-align: center;">
            &copy; 2011. Toyota Motor Manufacturing Indonesia. All Right Reserved
            <br />                 
                ^_^v Cheers. Page rendered in {elapsed_time} seconds             
            </p>            
        </div>
    </footer>
    

<!-- dialog untuk ganti password -->
<div id="dialog-password">
    <table>
        <tr>
            <td height="30px">Old Password</td>
            <td width="5%">:</td>
            <td>
                <input type="password" id="old_pass" value="" onkeyup="$('#old_pass_t').val($('#old_pass').val());" />
                <input type="text" id="old_pass_t" value="" onkeyup="$('#old_pass').val($('#old_pass_t').val());" style="display: none;"/>
            </td>
        </tr>
        <tr>
            <td height="30px">New Password</td>
            <td>:</td>
            <td>
                <input type="password" id="new_pass" value="" onkeyup="$('#new_pass_t').val($('#new_pass').val());" />
                <input type="text" id="new_pass_t" value="" onkeyup="$('#new_pass').val($('#new_pass_t').val());" style="display: none;"/>
            </td>
        </tr>
        <tr>
            <td height="30px">Confirm Password</td>
            <td>:</td>
            <td>
                <input type="password" id="con_pass" value="" onkeyup="$('#con_pass_t').val($('#con_pass').val());" />
                <input type="text" id="con_pass_t" value="" onkeyup="$('#con_pass').val($('#con_pass_t').val());" style="display: none;"/>
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td>
                <input type="checkbox" id="cek_show_char" value="1" onclick="on_change_show_char();" />
                Show Character
            </td>
        </tr>
    </table>
</div>   
</body>
</html>