<script type="text/javascript">
    $(function(){
        $( "#accordion" ).accordion({
            autoHeight: false
        });
    });
</script>
<div class="column grid_2">
    <div class="accordion" id="accordion">
        <h2>&nbsp;&nbsp;Data Maintenance</h2>
        <div class="pane" style="display:block">
            <ul>
                <li><a href="<?=site_url('m_sqa_auditor')?>">Auditor</a></li>                             
                <li><a href="<?=site_url('m_sqa_dfct')?>">Defect</a></li>                
                <li><a href="<?=site_url('m_sqa_prdt')?>">PRDT</a></li>
                <li><a href="<?=site_url('m_sqa_rank')?>">Rank</a></li>
                <li><a href="<?=site_url('m_sqa_report')?>">Report</a></li>
                <li><a href="<?=site_url('m_sqa_running_text')?>">Running Text</a></li>
                <li><a href="<?=site_url('m_sqa_shift')?>">Shift</a></li>
                <li><a href="<?=site_url('m_sqa_shiftgrp')?>">Shift Group</a></li>
                <li><a href="<?=site_url('m_sqa_shop')?>">Shop</a></li>
                <li><a href="<?=site_url('m_sqa_stall')?>">Stall</a></li>
                <li><a href="<?=site_url('m_sqa_system')?>">System</a></li>                
                <li><a href="<?=site_url('m_sqa_work_calendar')?>">Work Calendar</a></li>
                
            </ul>
        </div>

         <h2>&nbsp;&nbsp;Master Maintenance</h2>
         <div class="pane">
             <ul>
                 <li><a href="<?=site_url('m_sqa_branch')?>">Branch</a></li>
                <li><a href="<?=site_url('m_sqa_comm')?>">Comm</a></li>
                <li><a href="<?=site_url('m_sqa_company')?>">Company</a></li>
                <li><a href="<?=site_url('m_sqa_country')?>">Country</a></li>
                <li><a href="<?=site_url('m_sqa_div')?>">Division</a></li>
                <li><a href="<?=site_url('m_sqa_div_old')?>">Division Old</a></li>
                 <li><a href="<?=site_url('m_sqa_plant')?>">Plant</a></li>
             </ul>
         </div>

        <h2>&nbsp;&nbsp;Category Master</h2>
         <div class="pane">
             <ul>
                 <li><a href="<?=site_url('m_sqa_ctg')?>">Category</a></li>
                <li><a href="<?=site_url('m_sqa_ctg_grp')?>">Category Group</a></li>
             </ul>
         </div>

         <h2>&nbsp;&nbsp;User &amp; Group Menu</h2>
         <div class="pane">
             <ul>
                 <li><a href="<?=site_url('m_sqa_groupauth')?>">Group Auth</a></li>
                 <li><a href="<?=site_url('m_usr')?>">User</a></li>
                 <li><a href="<?=site_url('m_sqa_usrauth')?>">User Auth</a></li>
                 <li><a href="<?=site_url('m_sqa_menu')?>">Menu</a></li>
                <li><a href="<?=site_url('m_sqa_menu_obj')?>">Menu Object</a></li>
             </ul>
         </div>
    </div>
</div>
