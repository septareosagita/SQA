<script type="text/javascript">
    function get_attch_by_problem_id (pid) {
        if (pid!='') {
            $.post('<?=site_url('t_sqa_dfct/get_att_sqpr')?>', {problem_id:pid}, function(html){
                $('#dfct_attach').html(html);
            });
        }
    }

    function on_remove_attach(pid, file_id) {
        if (file_id!='') {
            var c = confirm("Are you sure to remove your file/doc ["+file_id+"] from directory and system?");
            if (c) {
                $.post('<?=site_url('t_sqa_dfct/remove_att_sqpr')?>', {problem_id:pid, file_id: file_id}, function(html){
                    get_attch_by_problem_id(pid)
                    alert('Delete file/doc['+file_id+'] Successful ...');
                });
            }
        }
    }
</script>
<form action="" method="post" enctype="multipart/form-data" name="form1">
<input type="hidden" name="problem_id" id="problem_id" >
  <table width="100%" border="0">
    <tr>
        <td width="84%"><strong>Attachment</strong></td>
    </tr>
    <tr>
      <td><input type="file" name="userfile_0" id="userfile_0">
        <input type="submit" name="btnSave1" id="btnSave1" value="Attach The File To The List" class="button button-gray" />
      </td>
    </tr>
    <tr>
      <td><hr size="1"></td>
    </tr>
    <tr>
        <td><strong>Current File Attachment</strong></td>
    </tr>
    <tr>
      <td id="dfct_attach">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<script type="text/javascript">
	$(function(){
        <?php if ($problem_id==''): ?>
        var problem_id = parent.$('#problem_id').val();
        <?php else: ?>
        var problem_id = '<?=$problem_id?>';
        <?php endif; ?>
        $('#problem_id').val(problem_id);
        get_attch_by_problem_id(problem_id);
    });
</script>
