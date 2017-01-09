<script type="text/javascript" src="<?= base_url() ?>assets/js/jpicker/jpicker-1.1.6.min.js"></script>

<link rel="Stylesheet" type="text/css" href="<?= base_url() ?>assets/js/jpicker/css/jpicker-1.1.6.min.css" />
<link rel="Stylesheet" type="text/css" href="<?= base_url() ?>assets/js/jpicker/jPicker.css" />

<script type="text/javascript">
    $(function(){
        $.fn.jPicker.defaults.images.clientPath='<?= base_url() ?>assets/js/jpicker/images/';
        $('#FONT_CLR').jPicker();
        $('#BACKGROUND_CLR').jPicker();

        $(".view_detail").fancybox({
            'width'         : '75%',
            'height'        : '35%',
            'autoScale'     : false,
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic',
            'type'          : 'iframe'
        });
        
        // ignore these keys
          var ignore = [8,9,13,33,34,35,36,37,38,39,40,46];
        
          // use keypress instead of keydown as that's the only
          // place keystrokes could be canceled in Opera
          var eventName = 'keypress';
        
          // handle textareas with maxlength attribute
          $('textarea[maxlength]')
        
            // this is where the magic happens
            .live(eventName, function(event) {
              var self = $(this),
                  maxlength = self.attr('maxlength'),
                  code = $.data(this, 'keycode');
        
              // check if maxlength has a value.
              // The value must be greater than 0
              if (maxlength && maxlength > 0) {
        
                // continue with this keystroke if maxlength
                // not reached or one of the ignored keys were pressed.
                return ( self.val().length < maxlength
                         || $.inArray(code, ignore) !== -1 );
        
              }
            })
        
            // store keyCode from keydown event for later use
            .live('keydown', function(event) {
              $.data(this, 'keycode', event.keyCode || event.which);
            });
    });        
</script>
<div class="columns">
    <div class="column grid_6 first">
        <?php if ($err != ''): ?>
            <div class="message warning"><blockquote><p><?= $err ?></p></blockquote></div>
        <?php endif; ?>
            <div class="widgetform">
                <header>
                    <h2>RUNNING TEXT &raquo; <?= ucwords($todo); ?></h2>
                </header>
                <section>
                    <form name="fInput" method="post" action="" class="form">
                        <input type="hidden" name="todo" value="<?= $todo ?>"/>
                        <table width="100%">
                            <tr>
                                <td width="20%" style="vertical-align: top;">Plant</td>
                                <td width="3%" style="vertical-align: top">:</td>
                                <td style="vertical-align: top;">
                                    <select name="PLANT_CD" <?= ($todo == 'edit') ? 'readonly ="1"' : '' ?>>
                                    <?php if (count($list_plant)): foreach ($list_plant as $l): ?>
                                            <option value="<?= $l->PLANT_CD ?>" <?= ($l->PLANT_CD == $PLANT_CD) ? 'selected = "selected"' : '' ?>><?= $l->PLANT_CD ?> - <?= $l->PLANT_DESC ?></option>
                                    <?php endforeach;
                                        endif; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top">Run Text</td>
                                <td style="vertical-align: top">:</td>
                                <td style="vertical-align: top">
                                    <textarea maxlength="100" name="RUNTEXT" id="RUNTEXT" cols="50" rows="2" style="margin-left: 0px"><?= $RUNTEXT ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top">Font Name</td>
                                <td style="vertical-align: top">:</td>
                                <td style="vertical-align: top">
                                    <input type="text" name="FONT_NM" id="FONT_NM" value="<?= $FONT_NM ?>" size="50" />
                                    <br/><br/><sup>* 'Lucida Grande', Verdana, Helvetica, Arial, sans-serif;</sup>
                                </td>
                            </tr>
                            <tr>
                                <td height="35" style="vertical-align: top">Font Size</td>
                                <td style="vertical-align: top">:</td>
                                <td style="vertical-align: top">
                                    <input type="text" name="FONT_SIZE" id="FONT_SIZE" value="<?= $FONT_SIZE ?>" size="3" class="numeric" /> px
                                </td>
                            </tr>
                            <tr>
                                <td height="35" style="vertical-align: top">Font Color</td>
                                <td style="vertical-align: top">:</td>
                                <td style="vertical-align: top">
                                    <input type="text" name="FONT_CLR" id="FONT_CLR" value="<?= $FONT_CLR ?>" size="7" />
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top">Background Color</td>
                                <td style="vertical-align: top">:</td>
                                <td style="vertical-align: top">
                                    <input type="text" name="BACKGROUND_CLR" id="BACKGROUND_CLR" value="<?= $BACKGROUND_CLR ?>" size="7" />
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top">Valid From</td>
                                <td style="vertical-align: top">:</td>
                                <td style="vertical-align: top">
                                    <input type="text" name="DATE_FROM" value="<?= $DATE_FROM ?>" size="7" id="DATE_FROM" />
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top">Valid To</td>
                                <td style="vertical-align: top">:</td>
                                <td style="vertical-align: top">                                    
                                    <input type="text" name="DATE_TO" value="<?= $DATE_TO ?>" size="7" id="DATE_TO" />
                                </td>
                            </tr>
                        </table>
                        
                        <hr/>
                        <input type="submit" name="btnSubmit" value="Save" class="button button-gray"/>
                        <a href="<?=site_url('m_sqa_running_text/preview')?>" class="view_detail">
                            <button style="margin-top: 5px;" class="button button-gray">Preview</button>
                        </a>
                        <input type="button" name="btnCancel" value="Cancel" class="button button-gray" onclick="window.location='<?= site_url('m_sqa_running_text/browse') ?>'"/>
                </form></section></div></div></div>
<script type="text/javascript">
    $(function(){
        $("#DATE_FROM").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
        $("#DATE_TO").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
    });
</script>