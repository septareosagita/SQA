<?php
#########################################################################################################
# CONSTANTS																								#
# You can alter the options below																		#
#########################################################################################################
$thumb_width = "100";      // Width of thumbnail image
$thumb_height = "100";      // Height of thumbnail image
?>

<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.imgareaselect.min.js"></script>
<script type="text/javascript">
    function preview(img, selection) {
        $('#x1').val(selection.x1);
        $('#y1').val(selection.y1);
        $('#x2').val(selection.x2);
        $('#y2').val(selection.y2);
    }

    $(window).load(function () { 
        $('#thumbnail').imgAreaSelect({ onSelectChange: preview });
    });
</script>
<table width="100%" border="0">
    <tr>
        <td>&nbsp;</td>
        <td>Problem ID: <?= $problem_id ?></td>
        <td style="text-align:right; padding-right:20px">
            <input type="button" name="btnUploadPart2" id="btnUploadPart3" value="&laquo; Back" class="button button-gray" onClick="window.location='<?= site_url('t_sqa_dfct/upload_img') ?>'">
            <input type="button" name="btnUploadPart3" id="btnUploadPart3" value="Refresh" class="button button-gray" onclick="location.reload()">
        </td>
    </tr>
    <tr>
        <td colspan="3"><hr size="1"></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:center">
            <?php if (file_exists(PATH_IMG . $img)): ?>
                <img src="<?= base_url() . PATH_IMG . $img ?>" alt="MAIN IMAGE" id="thumbnail" />
            <?php endif; ?>
                <form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <input type="hidden" name="x1" value="" id="x1" />
                <input type="hidden" name="y1" value="" id="y1" />
                <input type="hidden" name="x2" value="" id="x2" />
                <input type="hidden" name="y2" value="" id="y2" />
                <input type="submit" name="upload_thumbnail" value="Save Selection" id="save_thumb" class="button button-gray"/>
            </form>

        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td width="4%">&nbsp;</td>
        <td width="96%" colspan="2">&nbsp;</td>
    </tr>
</table>
