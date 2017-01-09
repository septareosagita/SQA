<script type="text/javascript" src="<?= base_url() ?>assets/js/jpicker/jpicker-1.1.6.min.js"></script>

<link rel="Stylesheet" type="text/css" href="<?= base_url() ?>assets/js/jpicker/css/jpicker-1.1.6.min.css" />
<link rel="Stylesheet" type="text/css" href="<?= base_url() ?>assets/js/jpicker/jPicker.css" />

<style>
	#red, #green, #blue {
		float: left;
		clear: left;
		width: 100px;
		margin: 5px;
	}
	#swatch {
		width: 120px;
		height: 100px;
		margin-top: 8px;
		margin-left: 150px;
		background-image: none;
	}
	#red .ui-slider-range { background: #ef2929; }
	#red .ui-slider-handle { border-color: #ef2929; }
	#green .ui-slider-range { background: #8ae234; }
	#green .ui-slider-handle { border-color: #8ae234; }
	#blue .ui-slider-range { background: #729fcf; }
	#blue .ui-slider-handle { border-color: #729fcf; }
	#demo-frame > div.demo { padding: 10px !important; };
	</style>
	<script>
	function hexFromRGB(r, g, b) {
		var hex = [
			r.toString( 16 ),
			g.toString( 16 ),
			b.toString( 16 )
		];
		$.each( hex, function( nr, val ) {
			if ( val.length === 1 ) {
				hex[ nr ] = "0" + val;
			}
		});
		return hex.join( "" ).toUpperCase();
	}
	function refreshSwatch() {
		var red = $( "#red" ).slider( "value" ),
			green = $( "#green" ).slider( "value" ),
			blue = $( "#blue" ).slider( "value" ),
			hex = hexFromRGB( red, green, blue );
		$( "#swatch" ).css( "background-color", "#" + hex );
        
        // flush to textbox
        $('#colset_r').val(red);
        $('#colset_g').val(green);
        $('#colset_b').val(blue);
	}
	$(function() {
		$( "#red, #green, #blue" ).slider({
			orientation: "horizontal",
			range: "min",
			max: 255,
			value: 127,
			slide: refreshSwatch,
			change: refreshSwatch
		});
		$( "#red" ).slider( "value",<?=$colset_r?>);
		$( "#green" ).slider( "value",<?=$colset_g?>);
		$( "#blue" ).slider( "value",<?=$colset_b?>);
        
        $('#colset_r').val(<?=$colset_r?>);
        $('#colset_g').val(<?=$colset_g?>);
        $('#colset_b').val(<?=$colset_b?>);
	});
    </script>

<script type="text/javascript">
    $(function(){
        // cek jika problem id sudah ada ato belum, jika blm ada maka insertkan
        var problem_id = parent.$('#problem_id').val();
        if (problem_id == '' || problem_id == '0') { // edited: pengecekan problem id yg kosong atau nol dari parent form register application/views/t_sqa_dfct/register.php
            // insertkan
            parent.on_add('upload');
            location.reload();
        }
        
        // buat color setting
        $("#col-set").dialog({
            autoOpen: false,
            height: 220,
            width: 300,
            modal: true,
            title: 'Color Setting',
            buttons: {                
                'Set': function() {
                    $(this).dialog('close');
                }
            }
        });
        
        // activate color setting                
    });
    
    function open_setting() {
        $('#col-set').dialog('open');
    }

    function get_img_by_problem_id(problem_id) {
        $.post('<?= site_url('t_sqa_dfct/get_img') ?>', {problem_id:problem_id}, function(html){
            if (html == 0) {
                // no image for this dfct, do nothin?
            } else {
                // show image
                var img = JSON.parse(html);
                var main_img = img[0];
                var part_img = img[1];

                $('#img_main').val(main_img);
                $('#img_part').val(part_img);

                //var img_m = '<img src="<?= base_url() . PATH_IMG ?>'+ main_img +'" alt="Main Image" id="thumbnail1"/>';
                //var img_p = '<img src="<?= base_url() . PATH_IMG ?>'+ part_img +'" alt="Part Image" id="thumbnail2"/>';

                var img_m = '<img src="<?= PATH_IMG_URL ?>'+ main_img +'" alt="Main Image" id="thumbnail1"/>';
                var img_p = '<img src="<?= PATH_IMG_URL ?>'+ part_img +'" alt="Part Image" id="thumbnail2"/>';

                $('#td_main').html(img_m);
                $('#td_part').html(img_p);

                $('#thumbnail1').imgAreaSelect({ onSelectChange: preview1 });
                $('#thumbnail2').imgAreaSelect({ onSelectChange: preview2 });

                $('#thumbnail1').click(function(e){
                    var pos = $(this).position();
                    pos.left = parseInt(pos.left);
                    pos.top = parseInt(pos.top);

                    var relativeX = e.pageX - pos.left;
                    var relativeY = e.pageY - pos.top;

                    on_click_img(relativeX, relativeY, 'thumbnail1');
                });

                $('#thumbnail2').click(function(e){
                    var pos = $(this).position();
                    pos.left = parseInt(pos.left);
                    pos.top = parseInt(pos.top);

                    var relativeX = e.pageX - pos.left;
                    var relativeY = e.pageY - pos.top;

                    on_click_img(relativeX, relativeY, 'thumbnail2');
                });
            }
        });
    }

    function on_click_img(x, y, id) {
        $('#xpos_' + id).val(x);
        $('#ypos_' + id).val(y);
        
        var t = prompt('Input Text to add', '');
        if (t) {
            $('#txt_add').val(t);
            $('#save_img').val(id);
            $('#fUpload').submit();
        } else {
            $('#txt_add').val('');
        }
    }   

    function preview1(img, selection) {
        $('#x1_main').val(selection.x1);
        $('#y1_main').val(selection.y1);
        $('#x2_main').val(selection.x2);
        $('#y2_main').val(selection.y2);
    }

    function preview2(img, selection) {
        $('#x1_part').val(selection.x1);
        $('#y1_part').val(selection.y1);
        $('#x2_part').val(selection.x2);
        $('#y2_part').val(selection.y2);
    }

</script>

<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.imgareaselect.min.js"></script>
<form action="" method="post" enctype="multipart/form-data" name="fUpload" id="fUpload">
    <input type="hidden" name="save_img" id="save_img" value="1" />
    <input type="hidden" name="x1_main" value="" id="x1_main" />
    <input type="hidden" name="y1_main" value="" id="y1_main" />
    <input type="hidden" name="x2_main" value="" id="x2_main" />
    <input type="hidden" name="y2_main" value="" id="y2_main" />
    <input type="hidden" name="x1_part" value="" id="x1_part" />
    <input type="hidden" name="y1_part" value="" id="y1_part" />
    <input type="hidden" name="x2_part" value="" id="x2_part" />
    <input type="hidden" name="y2_part" value="" id="y2_part" />
    <input type="hidden" name="img_main" value="" id="img_main" />
    <input type="hidden" name="img_part" value="" id="img_part" />
    <input type="hidden" name="colset_r" value="<?=$colset_r?>" id="colset_r" />
    <input type="hidden" name="colset_g" value="<?=$colset_g?>" id="colset_g" />
    <input type="hidden" name="colset_b" value="<?=$colset_b?>" id="colset_b" />

    <?php if ($messages != ''): ?>
        <div class="message warning"><blockquote><p><?php echo '<pre>'; print_r($messages); echo '</pre>'; ?></p></blockquote></div>
    <?php endif; ?>

    <table width="100%" border="0">
        <tr>
            <td height="27" colspan="3"><strong>UPLOAD IMAGE</strong></td>
        </tr>
        <tr>
            <td width="11%" height="27">Main Image</td>
            <td width="44%">:
                <input type="file" name="userfile_0" id="userfile_0"></td>
            <td width="45%" style="text-align:right; padding-right:20px">
				<sup><strong>Notes:</strong> Drag Inside Image for Mark, Click To Adding Text.</sup>
                <!--
                Problem ID:--> <input type="hidden" name="problem_id" id="problem_id" size="40" style="text-align: right" readonly="readonly">                
            </td>
        </tr>
        <tr>
            <td height="28">Part Image </td>
            <td>:
                <input type="file" name="userfile_1" id="userfile_1"></td>
            <td style="text-align:right; padding-right:20px">
                <input type="submit" name="btnUploadPart2" id="btnUploadPart3" value="Upload" class="button button-gray">
                <input type="button" name="btnUploadPart3" id="btnUploadPart4" value="Refresh" class="button button-gray" onclick="location.reload()">
                <input type="button" name="btnUploadPart4" id="btnUploadPart5" value="Color" class="button button-gray" onclick="open_setting()">
            </td>
        </tr>
        <tr>
            <td colspan="3"><hr size="1" /></td>
        </tr>
        <tr>
            <td colspan="3"><table width="100%" border="0">
                    <tr>
                        <td style="text-align:center" id="td_main">

                        </td>
                        <td style="text-align:center" id="td_part">

                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center">
                            <!--input type="text" name="BACKGROUND_CLR" id="BACKGROUND_CLR" value="<?= $BACKGROUND_CLR ?>" size="7" />
                            <input type="text" name="FONT_CLR" id="FONT_CLR" value="<?= $FONT_CLR ?>" size="7" /-->
                            <input type="button" name="btnSave1" id="btnSave1" value="Save" class="button button-gray" onclick="$('#save_img').val(1); $('#fUpload').submit();" />                            
                        </td>
                        <td style="text-align:center">
                            <input type="button" name="btnSave2" id="btnSave2" value="Save" class="button button-gray" onclick="$('#save_img').val(2); $('#fUpload').submit();" />
                        </td>
                    </tr>
                </table></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;

            </td>
        </tr>
    </table>

<input type="hidden" id="xpos_thumbnail1" name="xpos_thumbnail1" value="0" />
<input type="hidden" id="ypos_thumbnail1" name="ypos_thumbnail1" value="0" /><br/>
<input type="hidden" id="xpos_thumbnail2" name="xpos_thumbnail2" value="0" />
<input type="hidden" id="ypos_thumbnail2" name="ypos_thumbnail2" value="0" />
<input type="hidden" id="txt_add" name="txt_add" value="" />
</form>

<script type="text/javascript">
    $(function(){
        var problem_id = parent.$('#problem_id').val();
        $('#problem_id').val(problem_id);
        get_img_by_problem_id(problem_id);
    });

    $(window).load(function () {
        $('#thumbnail1').imgAreaSelect({ onSelectChange: preview1 });
        $('#thumbnail2').imgAreaSelect({ onSelectChange: preview2 });       
    });
</script>

<div id="col-set">

<div id="red"></div>
<div id="green"></div>
<div id="blue"></div>

<div id="swatch" class="ui-widget-content ui-corner-all"></div>

</div>
