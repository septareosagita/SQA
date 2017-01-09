<script type="text/javascript" src="<?= base_url() ?>assets/js/highcharts.src.js"></script>
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
            this.context = $('#slideshow_du');

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
            $('#title_<?=$k->DESCRIPTION?>' ).css('background-color', '#eee');
            $('#title_<?=$k->DESCRIPTION?>' ).css('color', '#eee');
          
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
            
        <?php elseif (count($dfct_show)>0):?>            
            sps();
        <?php elseif (count($dfct_show)==0):?>
            var test_sps2 = setInterval(function(){
                sps();
            }, 10000);
        <?php endif; ?>
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
        $.post('<?= site_url('monitoring/du_chart') ?>',
	           {
                   vk : vk,
                   plant_nm : plant_nm
                },
    
            function(html){
              $('#du_chart').html(html); 
    
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
        padding: 5px; background-color: #EEEEEE; border: 1px solid #DDDDDD; font-size: 14px; font-weight: bold; margin-left: 10px; 
    }
    
   html, body {
     height: 100%;
     width: 100%;
	
}
.wrapper {
    margin: 0 auto;
    width: 1250px;
    <?php if (count($dfct_show)>=0):?>  <?php else:?> width: 980px; <? endif; ?>
   
}

.grid_7 {
    width:100%;
}



	
</style>


<!-- Main Section -->
<section class="grid_7 first">
    <div class="columns leading">
        <div class="grid_7 first">
            <!-- judul -->           
           
            
                     
             <?php if (count($dfct_show)>0): ?>             
             <?php endif; ?>         
             
             <input type="text" id="curr_vk" />    

            <!-- defect slideshow -->
            
            <div id="slideshow_du" <?php if (count($dfct_show)>=0):?> <?php else:?> style="width: 980px; " <? endif; ?>>
             
            <?php if (count($katashiki)>0): foreach ($katashiki as $k): ?>
                <span id="title_<?=$k->DESCRIPTION?>" class="default_tab_katashiki" style="border-radius: 2px;" ><?=$k->DESCRIPTION?></span> | 
            <?php endforeach; endif; ?>  
           
            <div class="slides" style="margin-top: 5px;">  
                    <ul>
                        <?php if (count($dfct_show)>0): $i=1; $sk=''; foreach ($dfct_show as $d): ?>

                        <?php $ks = $d->DESCRIPTION; if ($sk != $ks): $i=1; ?>
                        <?php $sk = $ks; endif; ?>

                        <li id="slide-<?= $d->PROBLEM_ID ?>">
                            <input type="hidden" id="vk_slide-<?= $d->PROBLEM_ID ?>" value="<?=$d->DESCRIPTION?>" />
                          
                        <div style="float: left; margin-right: 10px;">
                            <!-- main image -->
                            <?php if (file_exists(PATH_IMG.$d->MAIN_IMG)): ?>
                            <div style="width: 280px; height: 230px; border: 5px solid #fff; -moz-box-shadow: 0px 0px 10px #ccc;
                            box-shadow: 0px 0px 10px #ccc;">
                            <img src="<?=PATH_IMG_URL.$d->MAIN_IMG?>" alt="Main Image" width="280" height="230"/></div>
                            <?php endif; ?><br />

                            <!-- part image -->
                            <?php if (file_exists(PATH_IMG.$d->PART_IMG)): ?>
                            <div style="width: 280px; height: 230px; border: 5px solid #fff; -moz-box-shadow: 0px 0px 10px #ccc;
                            box-shadow: 0px 0px 10px #ccc;"><img src="<?=PATH_IMG_URL.$d->PART_IMG?>" alt="Part Image" width="280" height="230"  /></div>
                            <?php endif; ?>
                           </div>
                          <div style="float: left;">
                            <table class="data info" align="center" style="text-align: center; background: black;" width="50">
                               
                                <tr>
                                  <td colspan="2" height="180" style="padding: 8px; color: white;"><span style="font-size: 13px;"><?=$d->CTG_GRP_NM?></span><p></p><p></p><br /><h3><?=$d->DFCT?></h3></td>
                                </tr>
                                
                                
                               
                            </table>
                            
                             <table class="data info" align="left" style="text-align: left; clear: both; margin-top: 25px; font-size: 11px; font-weight: bold;" width="50">
                               
                               
                                <tr>
                                    <th colspan="2" height="60" style="text-align: center;"><h2>Vehicle Information</h2></th>
                                </tr>
                               
                                <tr>
                                  <td style="padding: 10px;">Rank</td>
                                  <td style="text-align: left; padding: 5px;"><?=$d->RANK_NM2?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px;">Model Code</td>
                                    <td style="text-align: left; padding: 5px;"><?= $d->KATASHIKI ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px;">Body No</td>
                                    <td style="text-align: left; padding: 5px;"><?=$d->BODYNO?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px;">Color</td>
                                    <td style="text-align: left; padding: 5px;"><?=$d->EXTCLR?></td>
                                </tr>
                                <tr>
                                  <td style="padding: 10px;">Prod. Date</td>
                                  <td style="text-align: left; padding: 5px;"><?= date('d-m-Y', strtotime($d->ASSY_PDATE))?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px;">Responsibility</td>
                                    <td style="text-align: left; padding: 5px;"><?=$d->SHOP_NM?></td>
                                </tr>
                            </table>
                          </div> 
                      </li>
                        <?php $i++; endforeach; else: ?>
                        	<?php foreach ($katashiki as $d): ?>
                        		<li id="slide-no-dfct-<?=$d->DESCRIPTION?>">
                            		<input type="hidden" id="vk_slide-no-dfct-<?=$d->DESCRIPTION?>"" value="<?=$d->DESCRIPTION?>" />
                            	</li>
                        	<?php endforeach; ?>
                        
                        	<!--li id="slide_nodefect">No Defect To show</li-->
                        
                        <?php endif; ?>
                    </ul>
              </div>
            <ul class="slides-nav">
                    <?php if (count($dfct_show)>0): $y=0; $i=1; $sk = ''; foreach ($dfct_show as $d): ?>

                        <?php $ks = $d->DESCRIPTION; if ($sk != $ks): $idbks = 'bottom_ks_' . $ks; $i=1; ?>
                        <?php $sk = $ks; endif; ?>
                            
                        <li class="<?=$idbks?> <?=($y==0)?'on':''?>"><a href="#slide-<?= $d->PROBLEM_ID ?>" style="font-weight: bold; font-size: 16px;"><?=$i?></a></li>

                    <?php $i++; $y++; endforeach; else: ?>
                        <?php foreach ($katashiki as $d): ?>
                    		<li class="bottom_ks_<?=$d->DESCRIPTION?> <?=($y==0)?'on':''?>"><!--a href="#slide-no-dfct-<?= $d->DESCRIPTION ?>" style="font-weight: bold; font-size: 16px;"><?=$i?></a--></li>
                    	<?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
                    
              <!-- Chart Daily D/U -->
            <div id="du_chart" style="width: 709px;  float: left; margin-left: 10px; margin-top: 15px;">
                  
            </div>
            
                        
        </div>    
    </div>
</section>



<div class="columns">
    <div class="column grid_7 first" id="runtext_panel"  <?php if (count($dfct_show)>0):?> onmouseover="sps();" <?php else:?> style="width: 980px;" <? endif; ?>>
      <?php if ($rt != ''): ?>
  
         <?php if (count($dfct_show)>0): ?>
        
        <div style="border: 1px solid #B9B9B9; width: 1250px; background-color: #<?=$rt->BACKGROUND_CLR?>; color: #<?=$rt->FONT_CLR?>; font-size: <?=$rt->FONT_SIZE?>px; font-family: <?=$rt->FONT_NM?>; height: auto;"
        <?php if (count($dfct_show)>0):?>  <?php else:?> style="width: 980px;" <? endif; ?>>
            <marquee behavior="scroll" scrollamount="3" direction="left" width="100%">
            <div style="padding: 15px 0 20px 0;">
                <?=$rt->RUNTEXT?>
            </div>
            </marquee>
        </div><br />
        
        <?php endif; ?>
      
         <?php else: ?>        
        <div style="border: 1px solid #B9B9B9; width: 960px; <?php if (count($dfct_show)>0):?>  width: 1230px; <? endif; ?>  padding: 10px; text-align: center">
            PT. Toyota Motor Manufacturing Indonesia
        </div>
        
        <input type="hidden" id="last_rt_dt" value="" />

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