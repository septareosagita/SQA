<?php
$mn = $this->uri->segment(1);
$uinfo = $this->session->userdata('user_info');
if ($uinfo == '' && $mn != 'monitoring') redirect('welcome/out');
    
/** get menu Access */
$this->dm->init('V_SQA_GROUPAUTH_MENU', 'GRPAUTH_ID');
$c_menu_hak_akses = "GRPAUTH_ID = '" . get_user_info($this, 'GRPAUTH_ID') . "' and SHOP_ID = '" . get_user_info($this, 'SHOP_ID') . "'";
$c_menu = $c_menu_hak_akses . " and IS_SHOW = '1'";
$m_menu = $this->dm->select('','', $c_menu, '*');
$m_menu_hak_akses = $this->dm->select('','', $c_menu_hak_akses, '*');

// cek validasi apakah user ini boleh akses halaman ini
$m_restricted = array();    
foreach ($m_menu_hak_akses as $m) {
    $m_restricted[] = $m->MENU_CTRL;        
}
if (!in_array($mn, $m_restricted)) {    
    if ($mn != 'welcome' && $mn != 'monitoring') redirect($m_restricted[0]);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>Shipping Quality Audit - Toyota Motor Manufacturing Indonesia</title>

        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/css/reset.css" />
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/css/daily_report.css" />
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/css/style.css" />
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/css/messages.css" />
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/css/tables.css" />
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/css/forms.css" />
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/blitzer/jquery-ui-1.8.11.custom.css" />
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/css/slideshow.css" />
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/css/slideshow_du.css" />         
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/css/superTables.css" />

        <script src="<?= base_url() ?>assets/style/js/html5.js"></script>
        <!-- jquerytools -->
        <script src="<?= base_url() ?>assets/style/js/jquery.tools.min.js"></script>
        <!--[if lte IE 9]>
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/style/css/ie.css" />
        <script type="text/javascript" src="<?= base_url() ?>assets/style/js/ie.js"></script>
        <![endif]-->

        <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/style/js/jquery.tools.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-1.8.11.custom.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/style/js/global.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/default.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.numeric.js"></script>        
        <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.cycle.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/superTables.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/highcharts.js"></script>
        <?php if ($mn=='monitoring'):?>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/clock.js"></script>
        <?php endif; ?>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/specialedit.jquery.min.js"></script>

       	<script type="text/javascript">
            $(document).ready(function() {
                $("a#single_image").fancybox();
                $("#uploadimage").fancybox({
                    'width'             : '50%',
                    'height'			: '50%',
                    'autoScale'			: false,
                    'transitionIn'      :'elastic',
                    'transitionOut'     :'elastic',
                    'width'             : 1100,
                    'height'            : 700,
                    'type'			:'iframe'
                });
                $(".numeric").numeric();                
                
                // buat form change password
                $("#dialog-password").dialog({
                    autoOpen: false,
                    height: 220,
                    width: 300,
                    modal: true,
                    title: 'Change Password',
                    buttons: {
                        'Change': function() {      
                            on_change_pass();
                        },
                        'Close': function() {
                            $(this).dialog('close');
                        }
                    }
                });
            });
            
            function on_change_pass() {
                var old_pass = $('#old_pass').val();
                var new_pass = $('#new_pass').val();
                var con_pass = $('#con_pass').val();
                
                if (old_pass != '' && new_pass != '' && con_pass != '') {
                    
                    //cek dulu confirmasinya
                    if (new_pass == con_pass) {
                        // cek pass lama                        
                        $.post('<?=site_url('welcome/check_old_pass')?>', {old_pass: old_pass, new_pass: new_pass}, function(html){
                            if (html == 0) {
                                alert ('Your old password not match');
                            } else if (html == 1){
                                alert('Your password has been changed in next time you log on');
                                $('#dialog-password').dialog('close');
                            } else {
                                // ada kesalahan
                            }
                        });                    
                    } else {
                        alert('Your confirmation password not match');
                        $('#con_pass').focus();
                    }                    
                } else {
                    alert('Please input old, new, and confirmation new password');
                }
            }
            
            // fungsi untuk buka form ganti apss
            function open_change_pass() {
                $('#dialog-password').dialog('open');
            }
            
            function on_change_show_char() {
                if ($('#cek_show_char').is(':checked')) {
                    $('#old_pass').hide();
                    $('#new_pass').hide();
                    $('#con_pass').hide();
                    $('#old_pass_t').show();
                    $('#new_pass_t').show();
                    $('#con_pass_t').show();
                } else {
                    $('#old_pass').show();
                    $('#new_pass').show();
                    $('#con_pass').show();
                    $('#old_pass_t').hide();
                    $('#new_pass_t').hide();
                    $('#con_pass_t').hide();
                }       
            }
            
            /* untuk paging ajax,by: satriadarma*/
            function page_ajax(pg, url, panel, condition) {
                $('#'+panel).html('<center><img src="<?=base_url()?>assets/images/loading-gif.gif" alt="loading" /></center>');
                $.post(url, {pg: pg, condition: condition}, function(html){
                   $('#'+panel).html(html);
                    new superTable("demoTable", {
                   	    cssSkin : "sDefault"                    
                    });
                });
            }
        </script>
        <link href="<?= base_url() ?>assets/style/css/screen.css" rel="stylesheet" type="text/css" media="screen" />
    </head>
    <body id="body_sqa">
        <div id="wrapper">
            <header id="page-header" <?=($mn=='monitoring')?'style="height: 40px"':''?>>
            
                <?php if ($mn != 'monitoring'): ?>
                <div class="wrapper">
                    <table width="100%" border="1">
                        <tr>
                            <td width="6%" style="vertical-align: middle" rowspan="2">
                                <img src="<?= base_url() ?>assets/img/LOGO1-48.png" alt="toyota-logo" />
                            </td>
                            <td style="vertical-align: bottom;"><h1 style="font-weight: bold; font-size: 16px;">SHIPPING QUALITY AUDIT</h1></td>
                            <td rowspan="2" style="text-align: right; vertical-align: middle;">
                                <?php
                            /**
                            --> edited 20110610 @toyota, menu d ambil dari database langsung (bukan dari table ci_database)supaya
                            mencegah sess_expiration karena CONFIG sess_use_database
                            
                            --> saat login 
                            */
                            $i=0; 
                            foreach ($m_menu as $m): 
                                    if ($m->MENU_PARENT == ''):
                                    // check menu selected
                                    $ct = ($mn == $m->MENU_CTRL || ($m->MENU_CTRL == 'master' && (substr($mn, 0, 6) == 'master' || $mn == 'm_sqa_rank' || $mn == 'm_sqa_ctg_grp' || $mn == 'm_sqa_shop' || $mn == 'm_sqa_dfct' || $mn == 'm_sqa_running_text' || $mn == 'm_sqa_shift' || $mn == 'm_sqa_work_calendar' || $mn == 'm_sqa_plant' || $mn == 'm_sqa_shiftgrp' || $mn == 'm_sqa_stall'))) ? '' : 'class="testedi"';
                                    $cts = ($mn == $m->MENU_CTRL || ($m->MENU_CTRL == 'master' && (substr($mn, 0, 6) == 'master' || $mn == 'm_sqa_rank' || $mn == 'm_sqa_ctg_grp' || $mn == 'm_sqa_shop' || $mn == 'm_sqa_dfct' || $mn == 'm_sqa_running_text' || $mn == 'm_sqa_shift' || $mn == 'm_sqa_work_calendar' || $mn == 'm_sqa_plant' || $mn == 'm_sqa_shiftgrp' || $mn == 'm_sqa_stall'))) ? 'style="color: #ffffff; background-color: #A92C2C; padding: 3px"' : 'style="padding: 3px"';
                                    ?>                                    
                                    <strong><a href="<?= site_url($m->MENU_CTRL) ?>" <?=$ct?> <?=$cts?> title="<?= $m->MENU_NM ?>"><?= strtoupper($m->MENU_NM) ?></a></strong> |
                                    <?php $i++; endif;
                            endforeach; ?>
                            <strong><a href="<?=site_url('welcome/out')?>" class="testedi" style="padding: 3px;">LOGOUT</a></strong>
                            </td>                            
                        </tr>
                        <tr>
                            <td style="vertical-align: top; margin-top: -5px;">
                                <!--
                                User:<strong title="<?= get_user_info($this, 'GRPAUTH_NM') ?>"><?= get_user_info($this) ?> (<?= get_user_info($this, 'GRPAUTH_NM') ?>)</strong>                            
                                <br /> <a class="tested" href="javascript:;" onclick="open_change_pass();">Change Password</a>
                                -->
                            </td>
                        </tr>                       
                    </table>                                    
                </div>
                <?php endif; ?>
                <div id="page-subheader">
                    <div class="wrapper">
                        <table width="100%">
                            <tr>
                                <?php if ($mn=='monitoring'): ?>
                                <td width="4%" style="vertical-align: middle;">       
                                    <img src="<?=base_url()?>assets/img/LOGO1-32.png" alt="toyota-logo"/>                                                                </td>
                                <?php endif; ?>
                                <td style="vertical-align: middle; margin-top: -2px;">
                                    <h2 <?=($mn=='monitoring')?'style="line-height: 20px;"':''?>>
                                    <?= (isset($page_title)) ? $page_title : '' ?>
                                    </h2>
                                </td>
                                <td>
                                    <?php if ($mn == 'monitoring'): ?>                                    
                                    <h2>
                                    <span style="float: right; font-size: 12px; ">
                                        <?php $uinfo = $this->session->userdata('user_info'); if ($uinfo == ''): ?>                                        
                                        <a href="javascript:;" onclick="open_login();" class="tested" style="color: white;" title="Click here to login ">LOGIN</a>
                                        <?php else: ?>
                                        <a href="<?=site_url('welcome/out')?>" class="tested" style="color: white;" title="You Are Currently Login. Click here to logout">LOGOUT</a>
                                        <?php endif; ?>
                                    </span>
                                    </h2>
                                    <?php else: ?>
                                    <h2>
                                    <span style="float: right; font-size: 10px; font-weight: normal;">
                                        User: <?= get_user_info($this) ?> (<?= get_user_info($this, 'GRPAUTH_NM') ?>)
                                        - <a class="tested" href="javascript:;" onclick="open_change_pass();">Change Password</a> 
                                    </span>
                                    </h2>
                                    <?php endif; ?>                                    
                                </td>
                            </tr>
                        </table>                    
                        <?php if ($mn=='monitoring'):?>                            
                        <span style="float: right; margin-top:5px; font-weight: bold;">
                            <?= date('d-m-Y') ?> <span id="tm">11:57</span>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </header>

            <section id="content">
                <div class="wrapper">