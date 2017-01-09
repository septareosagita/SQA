<?php
/** get menu Access */
$this->dm->init('V_SQA_GROUPAUTH_MENU', 'GRPAUTH_ID');
$c_menu = "GRPAUTH_ID = '" . get_user_info($this, 'GRPAUTH_ID') . "' and SHOP_ID = '" . get_user_info($this, 'SHOP_ID') . "' and IS_SHOW = '1'";
$m_menu = $this->dm->select('','', $c_menu);

// cek validasi apakah user ini boleh akses halaman ini
$m_restricted = array();    
foreach ($m_menu as $m) {
    $m_restricted[] = $m->MENU_CTRL;
}
?>

<?php if ($this->uri->segment(1)=='master_usrauth'): ?> <br /> <?php endif; ?>
<script type="text/javascript">
    $(function(){
        $( "#accordion" ).accordion({
            autoHeight: false
        });
    });
</script>
<div class="column grid_2">
    <?php if ($this->uri->segment(1)=='master_usrauth'): ?>
    <br/>
    <?php endif; ?>
    <div class="accordion" id="accordion">
        <h2>&nbsp;&nbsp;Master Menu</h2>
        <div class="pane" style="display:block">
            <ul>
                <?php if (count($m_sub)>0): foreach ($m_sub as $m): if (in_array($m->MENU_CTRL, $m_restricted)):                
                ?>
                <li><a href="<?=site_url($m->MENU_CTRL)?>" <?=($this->uri->segment(1)==$m->MENU_CTRL)?'class="active"':''?>><?=$m->MENU_NM?></a></li>
                <?php endif; endforeach; endif; ?>
            </ul>
        </div>        
    </div>
</div>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
