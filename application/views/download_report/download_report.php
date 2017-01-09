<script type="text/javascript">
 $(function(){
        $("#tgl_work_calender").datepicker({nextText: '&raquo;',prevText: '&laquo;',showAnim: 'slideDown',dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true});      
    });
    
    // jika yg login bukan org sqa.. tombol result_search akan non_aktif
   // $(function(){
//       var user_grpauth = $('#user_grpauth').val();
//      //  alert (user_grpauth);
//        if (user_grpauth !='04' && user_grpauth !='05' && user_grpauth !='06'
//         && user_grpauth !='07' && user_grpauth !='08' && user_grpauth !='09'){
//             $('#daily_report_button').attr('disabled', 'disabled');
//             $('#monthly_report_button').attr('disabled', 'disabled');
//             }
//         });
   
   //fungsi result_search 
   function current_report(){
       
        var report_url = '<?=site_url('inquiry/result_search')?>' + '/' + parent.$('#condition').val() + '/' + parent.$('#param').val() ;
        window.open(report_url);
       // $('#monthly_report_button').attr('disabled','disabled');
       //$('#daily_report_button').attr('disabled','disabled');
    }
    
    //fungsi pilih model daily_report
    function pilih_model_daily(){  
        var model = $('#model').val();
         $('#daily_report').show();
         $('#montly_report').hide();
         if(model !=''){ 
         $('#ok').show(); 
         }
       //  $('#monthly_report_button').attr('disabled','disabled');
        // $('#current_report').attr('disabled','disabled');
    }
    
    function select(){
      var model = $('#model').val();
         if(model ==''){ 
         $('#ok').hide(); 
         }
         else{
          $('#ok').show();  
         }
    }  
 
    // fungsi tombol daily_print
    function daily_print(){
        var from = $('#tgl_work_calender').val();
        var model = $('#model').val();
        
        // tanggal from
        var strDate_from = $('#tgl_work_calender').val();      
        var dateParts = strDate_from.split("-");        
        var currentTime = new Date(dateParts[2], (dateParts[1])-1, dateParts[0]);
       // alert (strDate_from);       
        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var tgl_from = (month + "/" + day + "/" + year)
        
        var currentTime = new Date()
        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var currentdate = (month + "/" + day + "/" + year)
         
        if(Date.parse(tgl_from) > Date.parse(currentdate))
        {
        alert("Date greater than daily report !");
         return false;
        }
        
         if(model==''){
            alert ('Select Model First !');
            $('#ok').show(); 
         }
         else{
       var report_url = '<?=site_url('download_report/daily_report')?>' + '/' + $('#model').val() + '/' + $('#tgl_work_calender').val();
       window.open(report_url);
    }
    }
    
    function monthly_report(){
     var report_url = '<?=site_url('monthly_report/monthly_report_screen')?>' ;
        window.open(report_url);   
    }
    
    //fungsi pilih model monthly_report
        
    function pilih_monthly_report(){  
        var model = $('#model2').val();
         $('#montly_report').show();
         $('#daily_report').hide();
         if(model !=''){ 
         $('#ok2').show(); 
         }
        // $('#daily_report_button').attr('disabled','disabled');
        // $('#current_report').attr('disabled','disabled');
    }
    
     function select2(){
      var model = $('#model2').val();
         if(model ==''){ 
         $('#ok2').hide(); 
         }
         else{
          $('#ok2').show();  
         }
    } 
    
    // fungsi tombol montly_print
     function montly_print(){
       $('#Summary_Data').show(); 
       $('#Summary_Defect').show();
       
    }
    function Summary_Data(){
      
        var model = $('#model2').val();
     
         if(model==''){
            alert ('Select Model First !');
            $('#ok2').show(); 
         }
         else{
       var report_url = '<?=site_url('monthly_report/monthly_report_screen')?>' + '/' + $('#model2').val();
       window.open(report_url);
    }
    }
    
    function Summary_defect(){
      
        var model = $('#model2').val();
     
         if(model==''){
            alert ('Select Model First !');
            $('#ok2').show(); 
         }
         else{
       var report_url = '<?=site_url('monthly_report/monthly_report_defect')?>' + '/' + $('#model2').val();
       window.open(report_url);
    }
    }
    
  
 </script>
<div class="column grid_8 first" style="width:80%; margin-top:8%; margin-left:12%;">
   
    <div class="widget" align="center">
        <header>
            <h2>Download Report</h2>
        </header>
        <section>
            <div align="center" style="margin:20px;">
            
            <?php
         $hak_akses = ($user_grpauth !='04' && $user_grpauth !='05' && $user_grpauth !='06'
         && $user_grpauth !='07' && $user_grpauth !='08' && $user_grpauth !='09')
          ?>
          
          <?php
          $tgl_daily = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") -1, date("Y")));
          $tgl_daily2 = date("d-m-Y", mktime(0, 0, 0, date("m"), date("d") -1, date("Y")));
          $daily_report = date("d-m-Y", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
          ?>
                <input type="hidden" value="<?=$user_grpauth;?>" id="user_grpauth"/>
                <button class="button button-gray" type="button" id="monthly_report_button" onclick='pilih_monthly_report()' style="margin-right:20px; width: 20%">Monthly Report</button>
                <button class="button button-gray" type="button" id="daily_report_button" onclick='pilih_model_daily()' style="margin-right:20px; width: 20%; ">Daily<br /> Report</button>                
                <button class="button button-gray" type="button" id="current_report" onclick='current_report()' style="margin-right:20px; width: 20%">Result Search</button>
            </div>
            <div id="daily_report" style="display: none;" onclick='select()'><hr />
             Date : 
              <input type="text" id="tgl_work_calender" style="width:100px;" value="<?=$daily_report?>" readonly=""/>   
               
                Model : <select name="daily_report" id="model" style="width:100px;">
                                    <option value="">-- Select --</option>
                                <?php if (count($query)): foreach ($query as $l): ?>
                                        <option value="<?= $l->DESCRIPTION ?>"><?= $l->DESCRIPTION ?></option>
                                <?php endforeach;
                                    endif; ?>
                                </select> <a href="#" onclick="daily_print()" id="ok" style="display: none;">
                                &nbsp; &nbsp;<button class="button button-gray" id="ok" type="button" onclick='' style="margin-right:20px; width: 15%">Ok</button></a>
           
            </div>
            <div id="montly_report" style="display: none;" onclick='select2()'><hr />
         
                Model : <select name="daily_report" id="model2" onchange="montly_print()" style="width:100px;">
                                    <option value="">-- Select --</option>
                                <?php if (count($query)): foreach ($query as $l): ?>
                                        <option value="<?= $l->DESCRIPTION ?>"><?= $l->DESCRIPTION ?></option>
                                <?php endforeach;
                                    endif; ?>
                                </select> 
								
								
            <p></p><br />
            <button class="button button-gray" id="Summary_Data" onclick="Summary_Data()" type="button" onclick='' style="margin-right:20px; width: 36%;display: none;">Summary Data</button>
            <button class="button button-gray" id="Summary_Defect" onclick="Summary_defect()" type="button" onclick='' style="margin-right:20px; width: 36%;display: none;">Summary Defect</button> 
            </div>
            <br />
</section>
</div>
</div>
