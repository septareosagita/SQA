<?php
class monitoring extends CI_Controller {
    function  __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);        
    }

    
    function index() {
        redirect('monitoring/show_du/');
    }
    
    function show() {
        // default PLANT
        $plant_cd_default = '';
        
        $err = '';
		$plant_nm = ($this->uri->segment(3)!='') ? $this->uri->segment(3) : get_user_info($this, 'PLANT_NM');      
		$plantcd=get_user_info($this, 'PLANT_CD')  ;
        if ($plant_nm == '') {
            $err = 1;
        }
        $sql = "select distinct DESCRIPTION from V_T_SQA_DFCT WHERE SHOW_FLG = '1' AND IS_DELETED = '0' AND PLANT_NM = '" . $plant_nm . "' ORDER BY DESCRIPTION ASC";
        $data['katashiki'] = $this->dm->sql_self($sql);

        $this->dm->init('V_T_SQA_DFCT','PROBLEM_ID');
        $data['dfct_show'] = $this->dm->select('','DESCRIPTION ASC, SQA_PDATE DESC',"SHOW_FLG = '1' AND IS_DELETED = '0' AND PLANT_NM = '" . $plant_nm . "'");
	
        // find running text
        $this->dm->init('V_SQA_RUNNING_TEXT', 'PLANT_CD');
        $tgl_now = get_date();
        $w = "PLANT_NM = '" . $plant_nm . "' and (DATE_FROM <= '" . $tgl_now . "' and DATE_TO >= '" . $tgl_now . "')";
        $rt = $this->dm->select('','',$w);
        $data['rt'] = (count($rt)>0) ? $rt[0] : '';
        
                        
		
        $data['page_title'] = 'TMMIN - SHIPPING QUALITY AUDIT';
        $this->load->view('header', $data);
		$this->load->view('monitoring', $data); 
      
					
    }
    
    function show_sps() {
		$tgl=date("Y-m-d");
		$vk=$_POST['vk'];
        $err = '';
        $plant_nm = $_POST['plant_nm'];
	
		//SUMMARY MONTHLY
		/*$sql = "SELECT DISTINCT PLANT_NM,MONTH(pdate) MONTH,MODEL,SHOP_NM,SUM_TYPE,NUM_PS_MONTHLY  FROM T_SQA_REPLY_SUMMARY_MDL_SHOP A,M_SQA_PLANT B
				WHERE A.PLANT_CD=B.PLANT_CD AND PLANT_NM = '" . $plant_nm . "' and MODEL='" . $vk . "'
				order by SHOP_NM asc, SUM_TYPE asc";
                echo $sql;
                */
        $sql = "SELECT MONTH(dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP.PDATE) AS MONTH, 
                        dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP.MODEL, 
                        dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP.SHOP_NM, 
                        dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP.SUM_TYPE, 
                        COUNT(dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP.NUM_PS_MONTHLY) AS NUM_PS_MONTHLY, 
                        dbo.M_SQA_PLANT.PLANT_NM
                FROM 
                    dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP INNER JOIN 
                    dbo.M_SQA_PLANT ON dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP.PLANT_CD = dbo.M_SQA_PLANT.PLANT_CD
                WHERE 
                    PLANT_NM = '".$plant_nm."' AND MODEL = '".$vk."' 
                GROUP BY MONTH(dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP.PDATE), 
                        dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP.MODEL, 
                        dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP.SHOP_NM, 
                        dbo.T_SQA_REPLY_SUMMARY_MDL_SHOP.SUM_TYPE, 
                        dbo.M_SQA_PLANT.PLANT_NM";
        //echo $sql;
        $data['SUM_MONTH'] = $this->dm->sql_self($sql);
                
        // ambil plant code berdasarkan plant nm
        $this->dm->init('M_SQA_PLANT', 'PLANT_CD');
        $plant = $this->dm->select('','',"PLANT_NM = '" . $plant_nm . "'",'PLANT_CD');
        $plantcd = (count($plant)>0) ? $plant[0]->PLANT_CD : '';
        
		/** --- STATUS D/U ---- */
		//TARGET
		$this->dm->init('M_SQA_DU_TARGET','PLANT_CD');
        $du=$this->dm->select('DU_TARGET','',"PLANT_CD = '" . $plantcd . "' and (DATE_FROM <= '" . $tgl ."' AND DATE_TO >=  '" . $tgl . "')", '*');
        $data['du_target'] = (count($du)>0) ? $du[0]->DU_TARGET : 0;

		//TODAY	
        // get prdt first
		$this->dm->init('M_SQA_PRDT','PLANT_CD');
        $pd = $this->dm->select('','',"PLANT_CD = '" . $plantcd . "'",'PDATE');
		$pd = (count($pd)>0) ? $pd[0]->PDATE : $tgl;		
		
		$this->dm->init('T_SQA_DU_SUMMARY_MDL','PLANT_CD');
        $u=$this->dm->select('','',"PLANT_CD = '" . $plantcd . "' and MODEL='" . $vk . "' AND PDATE='" .$pd. "'",'DU_DAILY, DU_MONTHLY');
        $data['u'] = (count($u)>0 && $u[0]->DU_DAILY != '') ? $u[0]->DU_DAILY : 0;
        $data['M'] = (count($u)>0) ? $u[0]->DU_MONTHLY : 0;	
        
         //menampilkan shop_nm dari master 
        $this->dm->init('M_SQA_SHOP','SHOP_ID');
        $w = "SHOP_SHOW = '1' AND SHOP_ID != 'IN'" ;
        $sn = $this->dm->select('','',$w);
        $jml_sn = count($sn);
        
        $blnkrgsatu = strtoupper(date("n",strtotime("-1 month")));
		$bln = strtoupper(date("n"));
        $smonth = array();                
        
        //debug_array($data['SUM_MONTH']);
        $data['smonth'] = $smonth;                  
        $data['jml_sn'] = $jml_sn; 
        $data['sn'] = $sn;        	
		
        $data['page_title'] = 'TMMIN - SQA DATA';
        $this->load->view('monitoring_sps', $data); 
    }
    
    function du_chart(){
        $this->load->library('highcharts');
        
       	$tgl=date("Y-m-d");
        $date_daily_report = date("Y-m-d",strtotime(get_date())); 
        $bulan = date("n",strtotime(get_date()));  
       // $bulan = date("m", mktime(0, 0, 0, date("m") - 1 , date("d"), date("Y")));       
		$model=$_POST['vk'];
        $data['model'] = $model;
        $err = '';
        $plant_nm = $_POST['plant_nm'];
        
        
        // Collumn CHART DAILY D/U ===================================================================
          
          //tanggal dari work calender
        
        $sql = "select DISTINCT WORK_PRDT
        from M_SQA_WORK_CALENDAR
        where WORK_FLAG = '1' and month(WORK_PRDT) = '". $bulan ."'
        ";
        $ambil = $this->dm->sql_self($sql);
        foreach ($ambil as $l){
        $tgl_work_calender[] = $l->WORK_PRDT;
        $tgl_work_calender_chart[] = date("j",strtotime($l->WORK_PRDT));
        }
        
          // hitung jumlah work calender dalam 1 bulan
        $sql = "select COUNT(WORK_PRDT) as TOTAL_WORK_PRDT
        from M_SQA_WORK_CALENDAR
        where WORK_FLAG = '1' and month(WORK_PRDT) = '". $bulan ."' and SHIFTNO ='2'
        ";
        $jml_work_calender = $this->dm->sql_self_count($sql,'TOTAL_WORK_PRDT');
        
        
        //mengambil max pdate dari summary_model untuk batas cummulative DU
        $sql = "select MAX(PDATE) as PDATE 
        from T_SQA_DU_SUMMARY_MDL
        ";
        $max = $this->dm->sql_self($sql);
        $max_pdate = $max[0]->PDATE; 
        
        // mengeluarkan data yang dibutuhkan
        for ($i = 0; $i < $jml_work_calender; $i++)
        {
            
            //==ASSY
            $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG', 'PLANT_CD');
            $w = "PDATE = '" . $tgl_work_calender[$i] . "' AND MODEL = '" . $model .
                "' AND DFCT_CTG = 'A'";
            $l_graph = $this->dm->select('', '', $w);
            if ($l_graph[0]->DU_MDL_CTG_RANK_DAILY != '')
            {
                $l_graphA[$i] = $l_graph[0]->DU_MDL_CTG_RANK_DAILY;
            } else
            {
                $l_graphA[$i] = null;
            }

            //===== DRIVE
            $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG', 'PLANT_CD');
            $w = "PDATE = '" . $tgl_work_calender[$i] . "' AND MODEL = '" . $model .
                "' AND DFCT_CTG = 'D'";
            $l_graph = $this->dm->select('', '', $w);
            if ($l_graph[0]->DU_MDL_CTG_RANK_DAILY != '')
            {
                $l_graphD[$i] = $l_graph[0]->DU_MDL_CTG_RANK_DAILY;
            } else
            {
                $l_graphD[$i] = null;
            }

            //===== PAINT
            $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG', 'PLANT_CD');
            $w = "PDATE = '" . $tgl_work_calender[$i] . "' AND MODEL = '" . $model .
                "' AND DFCT_CTG = 'P'";
            $l_graph = $this->dm->select('', '', $w);
            if ($l_graph[0]->DU_MDL_CTG_RANK_DAILY != '' )
            {
                $l_graphP[$i] = $l_graph[0]->DU_MDL_CTG_RANK_DAILY;
            } else
            {
                $l_graphP[$i] = null;
            }
            
            
           //===== DU
            $this->dm->init('T_SQA_DU_SUMMARY_MDL', 'PLANT_CD');
            $w = "PDATE = '" . $tgl_work_calender[$i] . "' AND MODEL = '" . $model . "'";
            $l_graph = $this->dm->select('', '', $w);
            if ($l_graph[0]->DU_MONTHLY != '')
            {
                $l_graphDU[$i] = $l_graph[0]->DU_MONTHLY;
                
            } 
  
            else if ( $tgl_work_calender[$i] > $max_pdate)
            {
                $l_graphDU[$i] = NULL;
            } 
            
            else if ( $l_graph[0]->DU_MONTHLY == '')
            {
                $l_graphDU[$i] = $l_graphDU[$i-1];
            }
            
                     
         
             //===== DU Target
                        $this->dm->init('M_SQA_DU_TARGET','PLANT_CD');
                        $l_graph = $this->dm->select('','','');
                        if($l_graph[0]->DU_TARGET !=''){
                        $l_graphDU_target[$i] = $l_graph[0]->DU_TARGET;
                        }
                        else {
                            $l_graphDU_target[$i] = 0;
                        }
        }
        
        $data['Assy']['data'] = $l_graphA;
        $data['Assy']['type'] = 'column';
        $data['Assy']['name'] = 'Assy';
        $data['Painting']['data'] = $l_graphP;
        $data['Painting']['type'] = 'column';
        $data['Painting']['name'] = 'Painting';
        $data['Driving']['data'] = $l_graphD;
        $data['Driving']['type'] = 'column';
        $data['Driving']['name'] = 'Driving';
		$data['target']['data'] = $l_graphDU_target;
		$data['target']['name'] = 'Target';
        $data['target']['type'] = 'spline';
        $data['target']['color'] = 'red';
        $data['dpu']['data'] = $l_graphDU;
		$data['dpu']['name'] = 'Cumm DPU';
        $data['dpu']['color'] = 'purple';
		$data['axis']['categories'] = $tgl_work_calender_chart;
      
        $callback = "function() { return '<b>'+ this.x +'</b><br/>'+this.series.name +': '+ Highcharts.numberFormat(this.y, 2, ',') +'<br/>'+'Total: '+ Highcharts.numberFormat(this.point.stackTotal, 2, ',') }";
        
        
        $tool->formatter = $callback;
        $plot->column->stacking = 'normal';
       // $plot->column->stackLabels->enabled = 'false';
       // $plot->column->dataLabels->enabled = 'true';
       // $plot->column->dataLabels->color = 'white';
        $plot->line->dataLabels->color = 'black';
        $plot->line->dataLabels->enabled = 'true';
        
                                
        $yAxis->stackLabels->enabled = 'true';
        $yAxis->stackLabels->style->color = 'black';
        $yAxis->title->text = '';
            
        $legend->align = 'right';
        $legend->verticalAlign = 'top';
        $legend->x = -10;
        $legend->y = 20;
        $legend->floating = true;
        $legend->shadow = false;
        $legend->backgroundColor = '#FFFFFF';
        $legend->borderColor = '#CCC';
        
        $this->dm->init('M_SQA_DU_TARGET','PLANT_CD');
        $l_graph = $this->dm->select('','','');
        $du_target = $l_graph[0]->DU_TARGET;
        $data['du_target'] = $du_target;

        // $this->highcharts->set_type('column'); // drauwing type
        	$this->highcharts->set_title('Trend Daily D/U', 'DU Target = <b><blink>[ '. $du_target .' ]</blink></b> '); // set chart title: title, subtitle(optional)
        //  $this->highcharts->set_title('daily pdate perdate dr tabel daily', '');
        //	$this->highcharts->set_axis_titles('Number', 'Number'); // axis titles: x axis,  y axis
      
       
        $this->highcharts->set_yAxis($yAxis);
        $this->highcharts->set_tooltip($tool);
        $this->highcharts->set_plotOptions($plot);
        
		
		$this->highcharts->set_xAxis($data['axis']); // pushing categories for x axis labels
        // pushing categories for x axis labels
        	$this->highcharts->set_serie($data['target']); // second serie
        $this->highcharts->set_serie($data['Assy']);
        $this->highcharts->set_serie($data['Painting']); // second serie           
        $this->highcharts->set_serie($data['Driving']); // the first serie
	
 	    $this->highcharts->set_serie($data['dpu']); // the first serie
		
		
		$this->highcharts->render_to('charts'); // choose a specific div to render to graph
		
		$data['charts'] = $this->highcharts->render(); // we render js and div in same time
        
       
        // END Collumn CHART DAILY D/U ===================================================================

        // PIE CHART DAILY ===================================================================
       
         $list_pie = array();
        // PIE chart
        $sql = "select SHOP_NM, SUM(DU_MDL_MONTHLY) AS NILAI 
        from T_SQA_DU_SUMMARY_MDL_SHOP
        where PDATE = '". $date_daily_report ."'
        and MODEL = '" . $model . "'         
        GROUP BY SHOP_NM ";
        $pie_chart = $this->dm->sql_self($sql);
        $data['pie_chart'] = $pie_chart;

        $sql = "select  SUM(DU_MDL_MONTHLY) AS TOTAL
        from T_SQA_DU_SUMMARY_MDL_SHOP
        where PDATE = '". $date_daily_report ."'
        and MODEL = '" . $model . "'  
            ";
        $total = $this->dm->sql_self_count($sql, 'TOTAL');

        foreach ($pie_chart as $t)
        {
            $shop_nm = $t->SHOP_NM;
            $nilai = $t->NILAI;
            
             $persen = round(($nilai/$total*100),2);    
            
            $bulat = (int)$persen;
            if($persen-$bulat >= 0.5){
            $bulat = $bulat + 1;
            }
             $bulat;   
 
            if($nilai > 0){
            $list_pie[] = array($shop_nm, $persen);
    
            }
            
            // array 2 dimensi
                    }


       

        $serie['data'] = $list_pie;
     

        $callback = "function() { return '<b>'+ this.point.name +'</b>: '+ this.y +' ' }";
        $tool->formatter = $callback;
        $plot->pie->dataLabels->enabled = 'true';
        $plot->pie->stacking = 'normal';
        $plot->pie->allowPointSelect = 'true';
        $plot->pie->cursor = 'pointer';
        $plot->pie->dataLabels->formatter = "function() { return '<b>'+ this.point.name +'</b>: '+ this.y +'%' }";
		
        
        $legend->align = 'right';
        $legend->verticalAlign = 'top';
        $legend->x = -10;
        $legend->y = 20;
        $legend->floating = true;
        $legend->shadow = false;
        $legend->backgroundColor = '#FFFFFF';
        $legend->borderColor = '#CCC';

        $this->highcharts->set_type('pie'); // drauwing type
        $this->highcharts->set_title('Daily Responsible', ''); // set chart title: title, subtitle(optional)
       // $this->highcharts->set_axis_titles('Number', 'Number'); // axis titles: x axis,  y axis
        $this->highcharts->set_tooltip($tool);
        $this->highcharts->set_plotOptions($plot);
        $this->highcharts->set_legend($legend);
        $this->highcharts->set_serie($serie);
        
        $this->highcharts->render_to('charts2'); // choose a specific div to render to graph
        
        $data['charts2'] = $this->highcharts->render(); // we render js and div in same time
        
        // END PIE CHART DAILY ===================================================================
        
        // PIE CHART MONTLY ===================================================================
        
         $list_pie = array();
        // PIE chart
        $sql = "select SHOP_NM, SUM(DU_MDL_MONTHLY) AS NILAI 
        from T_SQA_DU_SUMMARY_MDL_SHOP
        where MONTH(PDATE) = '". $bulan ."'
        and MODEL = '" . $model . "'         
        GROUP BY SHOP_NM ";
        $pie_chart = $this->dm->sql_self($sql);
        $data['pie_chart'] = $pie_chart;

        $sql = "select  SUM(DU_MDL_MONTHLY) AS TOTAL
        from T_SQA_DU_SUMMARY_MDL_SHOP
        where MONTH(PDATE) = '". $bulan ."'
        and MODEL = '" . $model . "'  
            ";
        $total = $this->dm->sql_self_count($sql, 'TOTAL');

        foreach ($pie_chart as $t)
        {
            $shop_nm = $t->SHOP_NM;
            $nilai = $t->NILAI;
            
            $persen = round(($nilai/$total*100),2);  
            
            $bulat = (int)$persen;
            if($persen-$bulat >= 0.5){
            $bulat = $bulat + 1;
            }
             $bulat;   
 
          

              if($nilai > 0){
            $list_pie[] = array($shop_nm, $persen);
    
            }
        }


       

        $serie['data'] = $list_pie;
     

        $callback = "function() { return '<b>'+ this.point.name +'</b>: '+ this.y +' ' }";
        $tool->formatter = $callback;
        $plot->pie->dataLabels->enabled = 'true';
        $plot->pie->stacking = 'normal';
        $plot->pie->allowPointSelect = 'true';
        $plot->pie->cursor = 'pointer';
        $plot->pie->dataLabels->formatter = "function() { return '<b>'+ this.point.name +'</b>: '+ this.y +'%' }";
		
        
        $legend->align = 'right';
        $legend->verticalAlign = 'top';
        $legend->x = -10;
        $legend->y = 20;
        $legend->floating = true;
        $legend->shadow = false;
        $legend->backgroundColor = '#FFFFFF';
        $legend->borderColor = '#CCC';

        $this->highcharts->set_type('pie'); // drauwing type
        $this->highcharts->set_title('Monthly Responsible', ''); // set chart title: title, subtitle(optional)
       // $this->highcharts->set_axis_titles('Number', 'Number'); // axis titles: x axis,  y axis
        $this->highcharts->set_tooltip($tool);
        $this->highcharts->set_plotOptions($plot);
        $this->highcharts->set_legend($legend);
        $this->highcharts->set_serie($serie);

        $this->highcharts->render_to('charts3'); // choose a specific div to render to graph
        
        $data['charts3'] = $this->highcharts->render(); // we render js and div in same time
        
        // END PIE CHART MONTLY ===================================================================
        
       	 
		$this->load->view('monitoring_du_chart', $data);
        
        
        
    }
    
    function check_runtext() {
        $plant_nm = $_POST['plant_nm'];
        $last_rt_dt = $_POST['last_rt_dt'];
        
        // find running text
        $this->dm->init('V_SQA_RUNNING_TEXT', 'PLANT_CD');
        $tgl_now = get_date();
        $w = "PLANT_NM = '" . $plant_nm . "' and (DATE_FROM <= '" . $tgl_now . "' and DATE_TO >= '" . $tgl_now . "')";
        $w .= ($last_rt_dt != '') ? " and (Updatedt > '" . $last_rt_dt . "')" : '';
        $rt = $this->dm->select('','',$w, '*', true);
        $rt = (count($rt)>0) ? $rt[0] : '';
        
        $out = '';
        if ($rt != '') {
            $out = '<div style="border: 1px solid #B9B9B9; 
                        background-color: #'.$rt->BACKGROUND_CLR.'; 
                        color: #'.$rt->FONT_CLR.'; 
                        font-size: '.$rt->FONT_SIZE.'px; 
                        font-family: '.$rt->FONT_NM.'; 
                        height: auto;">
                        <marquee behavior="scroll" scrollamount="3" direction="left" width="100%">
                            <div style="padding: 15px 0 20px 0;">'.$rt->RUNTEXT.'</div>
                        </marquee>
                    </div>
                    <input type="text" id="last_rt_dt" value="'.date('Y-m-d H:i:s', strtotime($rt->Updatedt)).'" />
                    ';
        }
        echo $out;
    }
    
     function show_du() {
        // default PLANT
        $plant_cd_default = '';
        
        $err = '';
		$plant_nm = ($this->uri->segment(3)!='') ? $this->uri->segment(3) : get_user_info($this, 'PLANT_NM');      
		$plantcd=get_user_info($this, 'PLANT_CD')  ;
        if ($plant_nm == '') {
            $err = 1;
        }
        $sql = "select distinct DESCRIPTION from V_T_SQA_DFCT WHERE SHOW_FLG = '1' AND IS_DELETED = '0' AND PLANT_NM = '" . $plant_nm . "' ORDER BY DESCRIPTION ASC";
        //$sql = "select distinct DESCRIPTION from V_T_SQA_DFCT WHERE AND IS_DELETED = '0' AND PLANT_NM = '" . $plant_nm . "' ORDER BY DESCRIPTION ASC";
        $data['katashiki'] = $this->dm->sql_self($sql);
                                
        $this->dm->init('V_T_SQA_DFCT_2','PROBLEM_ID');
        $data['dfct_show'] = $this->dm->select('','DESCRIPTION ASC, SQA_PDATE DESC',"SHOW_FLG = '1' AND IS_DELETED = '0' AND PLANT_NM = '" . $plant_nm . "'");
	     
        // find running text
        $this->dm->init('V_SQA_RUNNING_TEXT', 'PLANT_CD');
        $tgl_now = get_date();
        $w = "PLANT_NM = '" . $plant_nm . "' and (DATE_FROM <= '" . $tgl_now . "' and DATE_TO >= '" . $tgl_now . "')";
        $rt = $this->dm->select('','',$w);
        $data['rt'] = (count($rt)>0) ? $rt[0] : '';
		
        $data['page_title'] = 'TMMIN - SHIPPING QUALITY AUDIT';
        
        // jumlah model
        $sql = "select distinct DESCRIPTION from V_T_SQA_DFCT";
        $data['vks'] = $this->dm->sql_self($sql);
        
        $this->load->view('header', $data);
		$this->load->view('monitoring_du', $data); 
      
					
    }

    function test(){
        $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
        $sql = "select distinct KATASHIKI from V_T_SQA_DFCT where SHOW_FLG = '1'";
        $M= $this->dm->sql_self($sql);
        $k = $M[0];
        echo $k->KATASHIKI;
        $b=  $M[1];
        echo $b->KATASHIKI;
        $c = $M[2];
        echo $c->KATASHIKI;
    }
}

?>