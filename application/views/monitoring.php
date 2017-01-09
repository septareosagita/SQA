
<script type="text/javascript">
    $slideshow = {
        context: false,
        tabs: false,
        timeout: 10000,      // time before next slide appears (in ms)
        slideSpeed: 3000,   // time it takes to slide in each slide (in ms)
        tabSpeed: 300,      // time it takes to slide in each slide (in ms) when clicking through tabs
        fx: 'scrollLeft',   // the slide effect to use

        init: function() {
            // set the context to help speed up selectors/improve performance
            this.context = $('#slideshow');

            // set tabs to current hard coded navigation items
            this.tabs = $('ul.slides-nav li', this.context);

            // remove hard coded navigation items from DOM
            // because they aren't hooked up to jQuery cycle
            <?php if (count($dfct_show)>1): ?>
            this.tabs.remove();
            <?php endif; ?>

            // prepare slideshow and jQuery cycle tabs
            this.prepareSlideshow();
        },

        prepareSlideshow: function() {
            // initialise the jquery cycle plugin -
            // for information on the options set below go to:
            // http://malsup.com/jquery/cycle/options.html
            $('div.slides > ul', $slideshow.context).cycle({
                fx: $slideshow.fx,
                timeout: $slideshow.timeout,
                speed: $slideshow.slideSpeed,
                fastOnEvent: $slideshow.tabSpeed,
                pager: $('ul.slides-nav', $slideshow.context),
                pagerAnchorBuilder: $slideshow.prepareTabs,
                before: $slideshow.activateTab,
                pauseOnPagerHover: true,
                pause: true
            });
        },

        prepareTabs: function(i, slide) {
            // return markup from hardcoded tabs for use as jQuery cycle tabs
            // (attaches necessary jQuery cycle events to tabs)
            return $slideshow.tabs.eq(i);
        },

        activateTab: function(currentSlide, nextSlide) {
            // get the active tab
            var activeTab = $('a[href="#' + nextSlide.id + '"]', $slideshow.context);

            // if there is an active tab
            if(activeTab.length) {
                // remove active styling from all other tabs
                $slideshow.tabs.removeClass('on');

                // add active styling to active button
                activeTab.parent().addClass('on');
            }

            // change background color of title katashiki here
            var ns = nextSlide.id;
            var vk = $('#vk_' + ns).val();
            
            // setting curr_vk di text global
            $('#curr_vk').val(vk);           

            // set the default background for all katashiki get from database
            <?php if (count($katashiki)>0): foreach ($katashiki as $k): ?>
            $('#title_<?=$k->DESCRIPTION?>' ).css('background-color', 'white');
            $('#title_<?=$k->DESCRIPTION?>' ).css('color', 'black');
            $('.bottom_ks_<?=$k->DESCRIPTION?>').hide();
            <?php endforeach; endif; ?>

            $('#title_' + vk ).css('background-color', '#5fbf00');
            $('#title_' + vk ).css('color', 'white');
            $('.bottom_ks_' + vk).show();
                                    
            <?php if (count($dfct_show) > 1): ?>
                sps();
            <?php endif; ?>
        }
    };


    $(function() {
        // add a 'js' class to the body
        $('body').addClass('js');

        // initialise the slideshow when the DOM is ready
        $slideshow.init();
        
        // test interval, mau berapa detik sekali refresh halaman
        var test = setInterval(function() {
              location.reload();
        }, 3600000); //3600000 , 1800000
        
        <?php if (count($dfct_show) == 1): ?>            
            sps();
            var test_sps = setInterval(function(){
               sps();
            }, 10000);
            
        <?php else: if (count($dfct_show)>0):?>            
            sps();
        <?php endif; endif; ?>
    });  
    /*PEMANGGILAN PAGE DGN DIV*/
    function sps() {
        var vk = $('#curr_vk').val();

        if (vk == null) {            
            <?php if (count($katashiki)>0): if (count($dfct_show)==1): ?>
            var vk = '<?=$katashiki[0]->DESCRIPTION?>';
            <?php else: ?>
            var vk = '';
            <?php endif; endif;?>
        }
        var plant_nm = '<?=($this->uri->segment(3)!='')?$this->uri->segment(3):get_user_info($this, 'PLANT_NM')?>';
        $.post('<?= site_url('monitoring/show_sps') ?>',
	           {
                   vk : vk,
                   plant_nm : plant_nm
                },
    
            function(html){
              $('#sps').html(html); 
    
            });
            
        // cek running text updated 
        /*
        $.post('<?= site_url('monitoring/check_runtext') ?>', 
                {
                    plant_nm : plant_nm,
                    last_rt_dt : $('#last_rt_dt').val()
                }, 
                function (html) {
                    if (html != '') {
                        $('#runtext_panel').html(html);
                    }
                }
        ); */
    } /*PEMANGGILAN PAGE DGN DIV*/ 
    
    
    
    /** buat login */
    function open_login() {                
        var str_login = '<br /><table><tr><td height="25px" width="35%"><strong>User ID</strong></td><td width="5%">:</td><td><input type="text" id="user_id" value="" size="30" /></td></tr><tr><td><strong>Password</strong></td><td>:</td><td><input type="password" id="pass" value="" size="30" /></td></tr></table>';
        $('#dialog-form-login').html(str_login);
        $('#dialog-form-login').dialog('open');
        $('#pass').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                on_login_user();
            }
        });
    }
    
     $(function() {
            // buat form login
            $("#dialog-form-login").dialog({
                autoOpen: false,
                height: 190,
                width: 300,
                modal: true,
                title: 'Login SQA System',
                buttons: {
                    'Login': function() {      
                        on_login_user();
                    },
                    'Cancel': function() {
                        $(this).dialog('close');
                    }
                }
            });                                       
    	});
    
    function on_login_user() {
        if ($('#user_id').val()!='' && $('#pass').val()!='') {
            var user_id = $('#user_id').val();
            var pass = $('#pass').val();
            
            $("#dialog-form-login").html("<br/><br/><center><img src='<?= base_url() ?>assets/style/images/loading-gif.gif' /><br/><sup><strong>Loging in... please wait</strong></sup></center>");
            
            $.post('<?=site_url('welcome/login_ajax')?>', {user_id: user_id, pass: pass}, function(html){
                
                if (html == 0) {
                    alert('Invalid User ID or Password');
                    var str_login = '<br /><table><tr><td height="25px" width="35%"><strong>User ID</strong></td><td width="5%">:</td><td><input type="text" id="user_id" value="" size="30" /></td></tr><tr><td><strong>Password</strong></td><td>:</td><td><input type="password" id="pass" value="" size="30" /></td></tr></table>';
                    $('#dialog-form-login').html(str_login);
                    $('#pass').keypress(function(event){
                        var keycode = (event.keyCode ? event.keyCode : event.which);
                        if(keycode == '13'){
                            on_login_user();
                        }
                    });
                } else {
                    //alert(html);
                    window.location='<?=site_url()?>' + html;                                    
                }
                                                
            });
        } else {
            alert('Please add User ID & Password for Login to the system');
        }
    }
</script>

<style>
    .default_tab_katashiki {
        padding-top:5px; padding: 5px; background-color: yellow; font-size: 14px; font-weight: bold;
    }
	
</style>

<!-- Main Section -->
<section class="grid_8 first">
    <div class="columns leading">
        <div class="grid_8 first">
            <!-- judul -->            
            <?php if (count($katashiki)>0): foreach ($katashiki as $k): ?>
            <span id="title_<?=$k->DESCRIPTION?>" class="default_tab_katashiki"><?=$k->DESCRIPTION?></span> | 
            <?php endforeach; endif; ?>
                        
             <?php if (count($dfct_show)>0): ?>             
             <?php endif; ?>         
             
             <input type="hidden" id="curr_vk" />    

            <!-- defect slideshow -->
            <div id="slideshow" <?php if (count($dfct_show)>0):?> onmouseover="sps();" <?php endif; ?>>
                <div class="slides">
                    <ul>
                        <?php if (count($dfct_show)>0): $i=1; $sk=''; foreach ($dfct_show as $d): ?>

                        <?php $ks = $d->DESCRIPTION; if ($sk != $ks): $i=1; ?>
                        <?php $sk = $ks; endif; ?>

                        <li id="slide-<?= $d->PROBLEM_ID ?>">
                            <input type="hidden" id="vk_slide-<?= $d->PROBLEM_ID ?>" value="<?=$d->DESCRIPTION?>" />
                            <h2><?=$i?>. <?=$d->DFCT?></h2>

                            <!-- main image -->
                            <?php if (file_exists(PATH_IMG.$d->MAIN_IMG)): ?>
                            
                            <img src="<?=PATH_IMG_URL.$d->MAIN_IMG?>" alt="Main Image" width="320" height="250" 
                            style="border: 5px solid #fff; -moz-box-shadow: 0px 0px 10px #ccc;
                            box-shadow: 0px 0px 10px #ccc;" />
                            <?php endif; ?>

                            <!-- part image -->
                            <?php if (file_exists(PATH_IMG.$d->PART_IMG)): ?>
                            <img src="<?=PATH_IMG_URL.$d->PART_IMG?>" alt="Part Image" width="320" height="250" 
                            style="border: 5px solid #fff; -moz-box-shadow: 0px 0px 10px #ccc;
                            box-shadow: 0px 0px 10px #ccc;"  />
                            <?php endif; ?>
                            
                            <table class="data info" align="center" style="text-align: center;">
                                <tr>
                                    <th colspan="2">Responsibility</th>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;"><?=$d->SHOP_NM?></td>
                                </tr>
                                <tr>
                                    <th>Rank</th>
                                    <th>Body No</th>
                                </tr>
                                <tr>
                                    <td style="text-align: center;"><?=$d->RANK_NM2?></td>
                                    <td style="text-align: center;"><?=$d->BODYNO?></td>
                                </tr>
                                <tr>
                                    <th>Color</th>
                                    <th>Date</th>
                                </tr>
                                <tr>
                                    <td style="text-align: center;"><?=$d->EXTCLR?></td>                                    
                                    <td style="text-align: center;"><?= date('d-m-Y', strtotime($d->AUDIT_PDATE))?></td>
                                </tr>
                            </table>
                        </li>
                        <?php $i++; endforeach; else: ?>
                        <li>No Defect To show</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <ul class="slides-nav">
                    <?php if (count($dfct_show)>0): $y=0; $i=1; $sk = ''; foreach ($dfct_show as $d): ?>

                        <?php $ks = $d->DESCRIPTION; if ($sk != $ks): $idbks = 'bottom_ks_' . $ks; $i=1; ?>
                        <?php $sk = $ks; endif; ?>
                            
                        <li class="<?=$idbks?> <?=($y==0)?'on':''?>"><a href="#slide-<?= $d->PROBLEM_ID ?>"><?=$i?>. <?=$d->DFCT?></a></li>

                    <?php $i++; $y++; endforeach; ?>
                        
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Main Section End -->
<div class="columns"  id="sps">

</div>

<div class="columns">
    <div class="column grid_8 first" id="runtext_panel">
        <?php if ($rt == ''): ?>
        <div style="border: 1px solid #B9B9B9; padding: 10px; text-align: center">
            PT. Toyota Motor Manufacturing Indonesia
        </div>
        <input type="hidden" id="last_rt_dt" value="" />
        <?php else: ?>
        
        <div style="border: 1px solid #B9B9B9; background-color: #<?=$rt->BACKGROUND_CLR?>; color: #<?=$rt->FONT_CLR?>; font-size: <?=$rt->FONT_SIZE?>px; font-family: <?=$rt->FONT_NM?>; height: auto;">
            <marquee behavior="scroll" scrollamount="3" direction="left" width="100%">
            <div style="padding: 15px 0 20px 0;">
                <?=$rt->RUNTEXT?>
            </div>
            </marquee>
        </div>
        <input type="hidden" id="last_rt_dt" value="<?=date('Y-m-d H:i:s', strtotime($rt->Updatedt))?>" />
        <?php endif; ?>
        <br/>
    </div>
</div>

<!-- only show the first katashiki -->
<script type="text/javascript">
    $(function(){
        //sps('');
        <?php if (count($katashiki)>0): foreach ($katashiki as $k): ?>
        $('.bottom_ks_<?=$k->DESCRIPTION?>').hide();
        <?php endforeach; ?>
        $('.bottom_ks_<?=$katashiki[0]->DESCRIPTION?>').show();
        <?php endif; ?>
                

        $('#body_sqa').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                //alert('tekan enter');
            } else if (keycode == '27') {
                //alert('tekan escape');
            }
        });
    });
</script>

<!-- buat login -->

<div id="dialog-form-login">

</div>