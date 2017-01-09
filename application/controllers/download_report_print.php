<?php

/*
* @author: ryan@mediantarakreasindo.com
* @created: April, 01 2011 - 00:00
*/

class download_report_print extends CI_Controller
{

    public $fieldseq = array();

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        /*$this->load->model('t_sqa_vinf_model');
        $this->load->model('t_sqa_dfct_model');
        $this->load->model('t_sqa_dfct_reply_model');
        $this->load->model('v_sqa_dfct_model');
        $this->load->model('m_sqa_shop_model');
        $this->load->model('m_sqa_rank_model');
        $this->load->model('m_sqa_plant_model');
        $this->load->model('inquiry_model');
        $this->load->model('m_sqa_shiftgrp_model');
        $this->load->model('m_sqa_ctg_grp_model');
        $this->load->model('m_sqa_ctg_model');
        $this->load->model('m_sqa_prdt_model');*/
        $this->load->model('m_sqa_model', 'dm', true);


        $this->load->vars($data);

        if ($this->session->userdata('user_info') == '')
            redirect('welcome/out');
    }

    function index()
    {
        redirect('download_report_print/daily_report');
    }
    
    function daily_report()
    {
                                
        $model = $this->uri->segment(3);
        $date_daily_report = date("Y-m-d",strtotime($this->uri->segment(4)));
        $date_daily_report2 = date("d-m-Y",strtotime($this->uri->segment(4)));
        //echo $this->uri->segment(3) . ';';
        //echo $date_daily_report;    
        $data['date_daily_report'] = $date_daily_report;
        
        //get current month - 1
        list($thn,$bln,$tgl) = explode('-',$date_daily_report);
        $bulan = date("m", mktime(0, 0, 0, $bln - 1 , $tgl, $thn)); 
        
        //get current month
        list($thn,$bln,$tgl) = explode('-',$date_daily_report);
        $bulan1 = date("m", mktime(0, 0, 0, $bln, $tgl, $thn));
        
        //mencari tanggal search
        list($thn,$bln,$tgl) = explode('-',$date_daily_report);
        $tgl_srch = date("d", mktime(0, 0, 0, $bln , $tgl, $thn)); 
        
        //first date
        list($thn,$bln,$tgl) = explode('-',$date_daily_report);
        $first_date = date("Y-m-d", mktime(0, 0, 0, $bln , 1, $thn));
        
        // mencari beetwen tgl skrng dan 5 minggu lalu
        list($thn,$bln,$tgl) = explode('-',$date_daily_report);
		$timestamp = mktime(0,0,0,$bln,$tgl-35,$thn);
		$lastfiveweeks = date("Y-m-d",$timestamp);
        
        //$kurang = ($date_daily_report  - 35);
        //$sekarang2 = date("Y-m-d");
        //$lastfiveweeks = prevDate($date_daily_report, 35);
        
        // menhitung selisih tanggal skrng dan 5 minggu yang lalu
        list($thn,$bln,$tgl) = explode('-',$date_daily_report);
		$timestamp = mktime(0,0,0,$bln,$tgl-35,$thn);
		$minusfiveweek = date("d-m-Y",$timestamp);
        
        //$timestamp = strtotime("-35 day");
        //$sekarang = date("d-m-Y");
        //$minusfiveweek = date("d-m-Y",strtotime($date_daily_report2), $timestamp);

        //exlplode 1
        $pecah1 = explode("-", $date_daily_report2);
        $date1 = $pecah1[0];
        $month1 = $pecah1[1];
        $year1 = $pecah1[2];
        //exlplode 2
        $pecah2 = explode("-", $minusfiveweek);
        $date2 = $pecah2[0];
        $month2 = $pecah2[1];
        $year2 = $pecah2[2];

        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);

        //hitung selisih
        $selisih = $jd1 - $jd2;
        
        //echo $minusfiveweek;
        // looping dari 5minggu yg lalu
        //$tgl = 35;
        
        for ($i = 1; $i <= $selisih; $i++)
        {
            //$timestamp2 = strtotime("-" . $tgl . " day"); // -35 day
            //$minusfiveweek2 = date("d-m-Y", $timestamp2);
            //$tanggal_daily2 = strtotime($minusfiveweek2);
            //$fiveweeks = strtotime('+1 day', $tanggal_daily2);
            list($tgl,$bln,$thn) = explode('-',$minusfiveweek);
            $now = date("Y-m-d", mktime(0,0,0,$bln,$tgl + $i,$thn));
            $tanggal[] = date('d', strtotime($now));
            //$tgl = 35 - $i;
            $list_tanggal = $tanggal;
            if (date('d', strtotime($now)) == '01')
            {
                $sparator = 35 - $tgl - 5;
                $sparator2 = 35 - $sparator;
            }
            //mencari nilai approve pdate] update "where a.APPROVE_PDATE is NOT NULL and" by ipan 20120120
            $sql = "
            select	a.PROBLEM_ID,a.APPROVE_PDATE,DFCT,SQA_PDATE,INSP_ITEM_FLG,SHOP_NM,REPAIR_FLG,SQA_SHIFTGRPNM,CLOSE_FLG,c.ASSY_SHIFTGRPNM,AUDIT_PDATE,b.APPROVE_PDATE as APPROVE_PDATE_REPLY,SHOP_ID,DUE_DATE,COUNTERMEASURE_TYPE,REPLY_TYPE,d.RANK_NM,RANK_DESC
            from T_SQA_DFCT a LEFT JOIN T_SQA_DFCT_REPLY b ON a.PROBLEM_ID = b.PROBLEM_ID
            LEFT JOIN T_SQA_VINF c ON a.IDNO = c.IDNO
            LEFT JOIN M_SQA_RANK d ON a.RANK_NM = d.RANK_ID  
            where
            a.APPROVE_PDATE is NOT NULL and                       
            c.DESCRIPTION = '" . $model . "'
            and (a.SQA_PDATE >= '" . $lastfiveweeks . "' AND a.SQA_PDATE <= '" . $date_daily_report . "')
            and (b.COUNTERMEASURE_TYPE = 'F' 
            or b.COUNTERMEASURE_TYPE IS NULL)  
            group by a.PROBLEM_ID,a.APPROVE_PDATE,a.DFCT,a.SQA_PDATE,a.RANK_NM,a.INSP_ITEM_FLG,a.SHOP_NM,a.REPAIR_FLG,a.SQA_SHIFTGRPNM,a.CLOSE_FLG,c.ASSY_SHIFTGRPNM,c.AUDIT_PDATE,b.APPROVE_PDATE,b.SHOP_ID,b.REPLY_TYPE,b.COUNTERMEASURE_TYPE,b.DUE_DATE,d.RANK_NM,d.RANK_DESC        
            order by a.SQA_PDATE ASC
            ";
            $list_daily_report = $this->dm->sql_self($sql);
            $data['list_daily_report'] = $list_daily_report;
        }
        $data['sparator'] = $sparator;
        $data['selisih'] = $selisih;
        $data['sparator2'] = $sparator2;
        $data['ap'] = ($tt);
        $data['list_tanggal'] = $list_tanggal;
        $data['list_daily_report'] = $list_daily_report;


        // ngambil PRDT
        $this->dm->init('M_SQA_PRDT', 'PLANT_CD');
        $prdt = $this->dm->select('', '', '');
        $tgl_prdt = $prdt[0]->PDATE;


        // higchart 1========================================================================

        // menghitung 7 bulan kebelakang
      //  $kurangbulan = date("M Y", mktime(0, 0, 0, date("m") - 8, date("d"), date("Y")));
      //  $krgbln = strtotime($kurangbulan);
        
        list($thn,$bln,$tgl) = explode('-',$date_daily_report);
        for ($i = 0; $i <= 6; $i++)
        {
            //$timestamp = mktime(0,0,0,$bln,$tgl-35,$thn);
            $bulan_chart1[] = date("M Y", mktime(0, 0, 0, $bln - 7 + $i, $tgl, $thn));

        }

        // mengeluarkan data yang dibutuhkan
        $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG', 'PLANT_CD');
        $T_graph = $this->dm->select('', 'PDATE DESC', '');
        $str_pdate = date("M Y", strtotime($date_daily_report));

        for ($i = 0; $i <= 6; $i++)
        {

            //==ASSy
            $sql = "
            select SUM(DU_MDL_CTG_RANK_MONTHLY) as DU_MDL_CTG_RANK_MONTHLY from T_SQA_DU_SUMMARY_MDL_CTG
            where
            (SELECT LEFT(DATENAME(MONTH, PDATE), 3) + ' ' + DATENAME(YEAR, PDATE) AS [Mon YY]) = '" . $bulan_chart1[$i] .
            "'  AND MODEL = '" . $model . "' AND DFCT_CTG = 'A'
            ";
            $l_graph = $this->dm->sql_self($sql);                                    
        
          //  $l_graph = $this->dm->select('', 'PDATE DESC', $w);
            $T_graph = $l_graph[0]->DU_MDL_CTG_RANK_MONTHLY;
            if ($T_graph != '')
            {
                $T_graphA[$i] = $T_graph;
            } else
            {
                $T_graphA[$i] = null;
            }

            //== Driving
            $sql = "
            select SUM(DU_MDL_CTG_RANK_MONTHLY) as DU_MDL_CTG_RANK_MONTHLY from T_SQA_DU_SUMMARY_MDL_CTG
            where
            (SELECT LEFT(DATENAME(MONTH, PDATE), 3) + ' ' + DATENAME(YEAR, PDATE) AS [Mon YY]) = '" . $bulan_chart1[$i] .
            "'  AND MODEL = '" . $model . "' AND DFCT_CTG = 'D'
            ";
            $l_graph = $this->dm->sql_self($sql);
            $T_graph = $l_graph[0]->DU_MDL_CTG_RANK_MONTHLY;
            if ($T_graph != '')
            {
                $T_graphD[$i] = $T_graph;
            } else
            {
                $T_graphD[$i] = null;
            }

            //== Paint
           $sql = "
            select SUM(DU_MDL_CTG_RANK_MONTHLY) as DU_MDL_CTG_RANK_MONTHLY from T_SQA_DU_SUMMARY_MDL_CTG
            where
            (SELECT LEFT(DATENAME(MONTH, PDATE), 3) + ' ' + DATENAME(YEAR, PDATE) AS [Mon YY]) = '" . $bulan_chart1[$i] .
            "'  AND MODEL = '" . $model . "' AND DFCT_CTG = 'P'
            ";
            $l_graph = $this->dm->sql_self($sql);
            $T_graph = $l_graph[0]->DU_MDL_CTG_RANK_MONTHLY;
            if ($T_graph != '')
            {
                $T_graphP[$i] = $T_graph;
            } else
            {
                $T_graphP[$i] = null;
            }
            
             //===== DU Target
                        $this->dm->init('M_SQA_DU_TARGET','PLANT_CD');
                        $l_graph = $this->dm->select('','','');
                        if($l_graph[0]->DU_TARGET !=''){
                        $T_graphDU_target[$i] = $l_graph[0]->DU_TARGET;
                        }
                        else {
                            $T_graphDU_target[$i] = 0;
                        }
                        
                        //===== DU
           
                $T_graphDU[$i] = NULL;
            
        }
        
  
        

        // higchart 2========================================================================

        //tanggal dari work calender
        $sql = "select DISTINCT WORK_PRDT
        from M_SQA_WORK_CALENDAR
        where month(WORK_PRDT) = '". $bulan ."'
        ";
        $ambil = $this->dm->sql_self($sql);
        foreach ($ambil as $l){
        $tgl_work_calender[] = $l->WORK_PRDT;
        $tgl_work_calender_chart[] = date("j",strtotime($l->WORK_PRDT));
        }
        // hitung jumlah work calender dalam 1 bulan
        $sql = "select COUNT(WORK_PRDT) as TOTAL_WORK_PRDT
        from M_SQA_WORK_CALENDAR
        where month(WORK_PRDT) = '". $bulan ."' and SHIFTNO ='2'
        ";
        $jml_work_calender = $this->dm->sql_self_count($sql,'TOTAL_WORK_PRDT');
        
       // $datenow = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        
        //mengambil max pdate dari summary_model untuk batas cummulative DU
        $sql = "select MAX(PDATE) as PDATE 
        from T_SQA_DU_SUMMARY_MDL
        ";
        $max = $this->dm->sql_self($sql);
        $max_pdate = $max[0]->PDATE; 
                                
        // mengeluarkan data yang dibutuhkan
        for ($i = 0; $i < $jml_work_calender; $i++)
        {
            for ($x = 0; $x < $tgl_srch; $x++)
            {
            //==ASSY
            $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG', 'PLANT_CD');
            $w = "PDATE = '" . $tgl_work_calender[$x] . "' AND MODEL = '" . $model .
                "' AND DFCT_CTG = 'A'";
            $l_graph = $this->dm->select('', '', $w);
            if ($l_graph[0]->DU_MDL_CTG_RANK_DAILY != '')
            {
                $l_graphA[$x] = round($l_graph[0]->DU_MDL_CTG_RANK_DAILY,2);
            } else
            {
                $l_graphA[$x] = null;
            }

            //===== DRIVE
            $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG', 'PLANT_CD');
            $w = "PDATE = '" . $tgl_work_calender[$x] . "' AND MODEL = '" . $model .
                "' AND DFCT_CTG = 'D'";
            $l_graph = $this->dm->select('', '', $w);
            if ($l_graph[0]->DU_MDL_CTG_RANK_DAILY != '')
            {
                $l_graphD[$x] = $l_graph[0]->DU_MDL_CTG_RANK_DAILY;
            } else
            {
                $l_graphD[$x] = null;
            }

            //===== PAINT
            $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG', 'PLANT_CD');
            $w = "PDATE = '" . $tgl_work_calender[$x] . "' AND MODEL = '" . $model .
                "' AND DFCT_CTG = 'P'";
            $l_graph = $this->dm->select('', '', $w);
            if ($l_graph[0]->DU_MDL_CTG_RANK_DAILY != '')
            {
                $l_graphP[$x] = $l_graph[0]->DU_MDL_CTG_RANK_DAILY;
            } else
            {
                $l_graphP[$x] = null;
            }


            //===== DU
            $this->dm->init('T_SQA_DU_SUMMARY_MDL', 'PLANT_CD');
            $w = "PDATE = '" . $tgl_work_calender[$x] . "' AND MODEL = '" . $model . "'";
            $l_graph = $this->dm->select('', '', $w);
            if ($l_graph[0]->DU_MONTHLY != '')
            {
                $l_graphDU[$x] = $l_graph[0]->DU_MONTHLY;
                
            } 
  
            else if ( $tgl_work_calender[$x] > $max_pdate)
            {
                $l_graphDU[$x] = NULL;
            } 
            
            else if ( $l_graph[0]->DU_MONTHLY == '')
            {
                $l_graphDU[$x] = $l_graphDU[$x-1];
            }           
        
           // echo $tgl_work_calender[$i].'"<br>"'.$datenow; 
          
            
             //===== DU Target
                        $this->dm->init('M_SQA_DU_TARGET','PLANT_CD');
                        $l_graph = $this->dm->select('','','');
                        if($l_graph[0]->DU_TARGET !=''){
                        $l_graphDU_target[$x] = $l_graph[0]->DU_TARGET;
                        }
                        else {
                            $l_graphDU_target[$x] = 0;
                        }
            }
            
            $l_graphA[$i] = null;
            $l_graphD[$i] = null;
            $l_graphP[$i] = null;
            $l_graphDU[$i] = null;
            $l_graphDU_target[$i] = 0;
        }
        
        //merge array chart 1 dan chart 2
        $merge_assy = array_merge($T_graphA,$l_graphA);
        $merge_driving = array_merge($T_graphD,$l_graphD);
        $merge_painting = array_merge($T_graphP,$l_graphP);
        $merge_du_target = array_merge($T_graphDU_target,$l_graphDU_target);
        $merge_du = array_merge($T_graphDU,$l_graphDU);
        $merge_chart1_chart2 = array_merge($bulan_chart1,$tgl_work_calender_chart);
        
        
        
        $data['Assy']['data'] = $merge_assy;
        $data['Assy']['type'] = 'column';
        $data['Assy']['name'] = 'Assy';
        $data['Painting']['data'] = $merge_painting;
        $data['Painting']['type'] = 'column';
        $data['Painting']['name'] = 'Painting';
        $data['Driving']['data'] = $merge_driving;
        $data['Driving']['type'] = 'column';
        $data['Driving']['name'] = 'Driving';
        $data['DU_TARGET']['data'] = $merge_du_target;
        $data['DU_TARGET']['name'] = 'DU Target';
        $data['DU_TARGET']['type'] = 'spline';
        $data['DU_TARGET']['color'] = 'red';
        $data['DU']['data'] = $merge_du;
        $data['DU']['name'] = 'Cumm DU';
        $data['DU']['type'] = 'line';
        $data['DU']['color'] = 'purple';
        

        $data['axis']['categories'] = $merge_chart1_chart2;

        $this->load->library('highcharts');

        $callback = "function() { return '<b>'+ this.x +'</b><br/>'+this.series.name +': '+ Highcharts.numberFormat(this.y, 2, ',') +'<br/>'+'Total: '+ Highcharts.numberFormat(this.point.stackTotal, 2, ',') }";
        
        $tool->formatter = $callback;
        $plot->column->stacking = 'normal';
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

       // $this->highcharts->set_type('column'); // drauwing type
        $this->highcharts->set_title(date("F Y", strtotime($date_daily_report)), ''); // set chart title: title, subtitle(optional)
        //  $this->highcharts->set_title('daily pdate perdate dr tabel daily', '');
        //	$this->highcharts->set_axis_titles('Number', 'Number'); // axis titles: x axis,  y axis
        $this->highcharts->set_yAxis($yAxis);
        $this->highcharts->set_tooltip($tool);
        $this->highcharts->set_plotOptions($plot);
        //   $this->highcharts->set_legend($legend);

        $this->highcharts->set_xAxis($data['axis']); // pushing categories for x axis labels
        $this->highcharts->set_serie($data['DU_TARGET']); // second serie
         $this->highcharts->set_serie($data['Assy']);
        $this->highcharts->set_serie($data['Painting']); // second serie           
       
        $this->highcharts->set_serie($data['Driving']); // the first serie
        
        $this->highcharts->set_serie($data['DU']); // second serie

        $this->highcharts->render_to('daily_1a2'); // choose a specific div to render to graph

        $data['daily_2'] = $this->highcharts->render(); // we render js and div in same time
        // end highchart ============================================================

          // higchart 3========================================================================

        //get from T_SQA_DU_SUMMARY_MDL_SHOP where DU_MDL_SHOP_MONTHLY per date

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
            if($persen-$bulat >= 0.50){
            $bulat = $bulat + 1;
            }
            
             $bulat;   
            
      
             if($nilai > 0){
            $list_pie[] = array($shop_nm, $persen);
    
            }
        }


        $this->load->library('highcharts');

        $serie['data'] = $list_pie; 

        $callback = "function() { return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.y, 2, ',') +' %' }";
        $tool->formatter = $callback;
        $plot->pie->dataLabels->enabled = 'true';
        $plot->pie->stacking = 'normal';
        $plot->pie->allowPointSelect = 'true';
        $plot->pie->cursor = 'pointer';
        $plot->pie->dataLabels->formatter = "function() { return '<b>'+ this.point.name +'</b>: '+ this.y +' %' }";
		
        
        $legend->align = 'right';
        $legend->verticalAlign = 'top';
        $legend->x = -10;
        $legend->y = 20;
        $legend->floating = true;
        $legend->shadow = false;
        $legend->backgroundColor = '#FFFFFF';
        $legend->borderColor = '#CCC';

        $this->highcharts->set_type('pie'); // drauwing type
        //	$this->highcharts->set_title(date("F Y",strtotime(get_date())), ''); // set chart title: title, subtitle(optional)
        //	$this->highcharts->set_axis_titles('Number', 'Number'); // axis titles: x axis,  y axis
        $this->highcharts->set_tooltip($tool);
        $this->highcharts->set_plotOptions($plot);
        $this->highcharts->set_legend($legend);
        $this->highcharts->set_serie($serie);
        $this->highcharts->set_dimensions(400,200);

        //    $this->highcharts->set_xAxis($data['axis']); // pushing categories for x axis labels
        //	$this->highcharts->set_serie($data['Assy']);
        // $this->highcharts->set_serie($data['data']); // the first serie
        //  $this->highcharts->set_serie($data['Paint']); // second serie

        $this->highcharts->render_to('daily_1b'); // choose a specific div to render to graph

        $data['daily_1b'] = $this->highcharts->render(); // we render js and div in same time
        // end highchart ============================================================

        // higchart 4========================================================================
        
       //tanggal dari work calender
        $sql = "select DISTINCT WORK_PRDT
        from M_SQA_WORK_CALENDAR
        where WORK_PRDT >= '". $first_date ."' and WORK_PRDT <= '". $date_daily_report   ."'
        ";
        $ambil = $this->dm->sql_self($sql);
        foreach ($ambil as $l){
        $tgl_work_calender[] = $l->WORK_PRDT;
        $tgl_work_calender_chart[] = date("j",strtotime($l->WORK_PRDT));
        }
        // hitung jumlah work calender dalam 1 bulan
        $sql = "select COUNT(WORK_PRDT) as TOTAL_WORK_PRDT
        from M_SQA_WORK_CALENDAR
        where month(WORK_PRDT) = '". $bulan ."' and SHIFTNO ='2'
        ";
       
       $jml_work_calender = $this->dm->sql_self_count($sql,'TOTAL_WORK_PRDT');


        // mengeluarkan data yang dibutuhkan
        $P_graphA = $P_graphB = array();
        $P_graphA_min = $P_graphB_min = 0;
        for ($x = 0; $x < $jml_work_calender; $x++)
        {
            for ($i = 0; $i < $tgl_srch; $i++)
            {
            $sql = "select SUM(NUM_PS_MONTHLY) as TOTAL 
            from T_SQA_REPLY_SUMMARY_MDL
            where SUM_TYPE = 'S' and PDATE = '" . $tgl_work_calender[$i] .
            "' AND MODEL = '" . $model . "'
            ";
         
            $P_graphAc = $this->dm->sql_self_count($sql, 'TOTAL');
            $P_graphAc = ($P_graphAc == '') ? 0 : $P_graphAc;
            $P_graphA_min += $P_graphAc;
            $P_graphA[$i] = $P_graphAc;

            $sql = "select SUM(NUM_PS_MONTHLY) as TOTAL 
            from T_SQA_REPLY_SUMMARY_MDL
            where SUM_TYPE = 'R' and PDATE = '" . $tgl_work_calender[$i] .
                "' AND MODEL = '" . $model . "'
            ";
            $P_graphBc = $this->dm->sql_self_count($sql, 'TOTAL');
            $P_graphBc = ($P_graphBc == '') ? 0 : $P_graphBc;
            $P_graphB_min += $P_graphBc;
            $P_graphB[$i] = $P_graphBc;
            }
            $P_graphA[$x] = NULL;
            $P_graphB[$x] = NULL;
        }

        $data['Send']['data'] = $P_graphA;
        $data['Send']['name'] = 'Send';
        $data['Reply']['data'] = $P_graphB;
        $data['Reply']['name'] = 'Reply';
        $data['axis']['categories'] = $tgl_work_calender_chart;

        $this->load->library('highcharts');

        //  $callback = "function() { return '<b>'+ this.x +'</b>: '+ this.y }";
        // $tool->formatter = $callback;
        $plot->line->dataLabels->enable = 'false';
        $plot->spline->dataLabels->enable = 'false';
        $yAxis->title->text = '';
      //  $plot->line->stacking = 'normal';
        $legend->align = 'right';
        $legend->verticalAlign = 'top';
        $legend->x = -600;
        $legend->y = -5;
        $legend->floating = true;
        $legend->shadow = false;
        $legend->backgroundColor = '#FFFFFF';
        $legend->borderColor = '#CCC';

        $this->highcharts->set_type('line'); // drauwing type
        $this->highcharts->set_yAxis($yAxis);
        //	$this->highcharts->set_title(date("F Y",strtotime(get_date())), ''); // set chart title: title, subtitle(optional)
        //	$this->highcharts->set_axis_titles('Number', 'Number'); // axis titles: x axis,  y axis
        // $this->highcharts->set_tooltip($tool);
       // $this->highcharts->set_plotOptions($plot);
       // $this->highcharts->set_legend($legend);

        $this->highcharts->set_xAxis($data['axis']); // pushing categories for x axis labels
        $this->highcharts->set_serie($data['Send']);
        $this->highcharts->set_serie($data['Reply']); // the first serie
        

        $this->highcharts->render_to('Prob_sheet'); // choose a specific div to render to graph

        $data['daily_4'] = $this->highcharts->render(); // we render js and div in same time
        // end highchart ============================================================

        // higchart 5========================================================================

        // get from T_SQA_REPLY_SUMMARY_MDL_SHOP Where SUM_TYPE (S=SEND, R=REPLY)
         $insp = array(inspection);
        
        
        //menampilkan data responsible DELAY berdasarkan master
        $list_total = $list_Send = array();
        
        // mengambil shop_nm delay        
        $sql = "select DISTINCT SHOP_NM
        from T_SQA_REPLY_SUMMARY_MDL_SHOP
        where MODEL = '" . $model . "'
        and PDATE = '". $date_daily_report ."'
        ";
        $list_total_delay = $this->dm->sql_self($sql);
        $data['list_total_delay'] = $list_total_delay;

        foreach ($list_total_delay as $t)
        {
          $list_Delay[] = $t->SHOP_NM;
          
        }
                        
        $data['lst_dly'] = $merge_assy;
        
        // mengambil nilai delay
        $sql = "select DISTINCT SHOP_NM, NUM_PS_MONTHLY,SUM_TYPE,PDATE
        from T_SQA_REPLY_SUMMARY_MDL_SHOP
        where MODEL = '" . $model . "' 
        and PDATE = '". $date_daily_report ."'
        ";
        $list_nilai_delay = $this->dm->sql_self($sql);
        $data['list_nilai_delay'] = $list_nilai_delay;
        
         
        
        // mengambil list send        
        $sql = "select DISTINCT SHOP_NM, SUM_TYPE, SUM (NUM_PS_MONTHLY)as TOTAL_SEND
        from T_SQA_REPLY_SUMMARY_MDL_SHOP
        where 
        MODEL = '" . $model . "' and SUM_TYPE = 'S' and (PDATE) = '". $date_daily_report ."'
        GROUP BY SHOP_NM,SUM_TYPE";

        $list_total_send = $this->dm->sql_self($sql);
        $data['list_total_send'] = $list_total_send;

        foreach ($list_total_send as $t)
        {
            
            if($t->TOTAL_SEND !=''){                      
            $list_Send[] = $t->TOTAL_SEND;
            }
            else {
            $list_Send[] = null;    
            }           
}
        
        // mengambil list reply        
        $sql = "select DISTINCT SHOP_NM, SUM_TYPE, SUM (NUM_PS_MONTHLY)as TOTAL_REPLY
        from T_SQA_REPLY_SUMMARY_MDL_SHOP
        where 
        MODEL = '" . $model . "' and SUM_TYPE = 'R' and (PDATE) = '". $date_daily_report ."'
        GROUP BY SHOP_NM,SUM_TYPE";

        $list_total_reply = $this->dm->sql_self($sql);
       
        $data['list_total_reply'] = $list_total_reply;

        foreach ($list_total_reply as $t)
        {
           if($t->TOTAL_REPLY !=''){                      
           $list_Reply[] = $t->TOTAL_REPLY;
            }
            else {
            $list_Reply[] = null;    
            } 
            
        
}

        $data['Send']['data'] = $list_Send;
        $data['Send']['name'] = 'Send';
        $data['Reply']['data'] = $list_Reply;
        $data['Reply']['name'] = 'Reply';
        $data['axis']['categories'] = $list_Delay;
        
        $this->load->library('highcharts');

        //  $callback = "function() { return '<b>'+ this.x +'</b>: '+ this.y }";
        // $tool->formatter = $callback;
        $plot->column->dataLabels->enabled = 'true';
        $plot->column->stacking = '';
        $yAxis->title->text = '';
        
        $legend->align = 'right';
        $legend->verticalAlign = 'top';
        $legend->x = 0;
        $legend->y = -10;
        $legend->floating = true;
        $legend->shadow = false;
        $legend->backgroundColor = '#FFFFFF';
        $legend->borderColor = '#CCC';

        $this->highcharts->set_type('column'); // drauwing type
        //	$this->highcharts->set_title(date("F Y",strtotime(get_date())), ''); // set chart title: title, subtitle(optional)
        //	$this->highcharts->set_axis_titles('Number', 'Number'); // axis titles: x axis,  y axis
        // $this->highcharts->set_tooltip($tool);
        $this->highcharts->set_plotOptions($plot);
        $this->highcharts->set_legend($legend);
        $this->highcharts->set_yAxis($yAxis);

        $this->highcharts->set_xAxis($data['axis']); // pushing categories for x axis labels
        $this->highcharts->set_serie($data['Send']);
        $this->highcharts->set_serie($data['Reply']); // the first serie

        $this->highcharts->render_to('Prob_sheet3'); // choose a specific div to render to graph

        $data['daily_5'] = $this->highcharts->render(); // we render js and div in same time
        // end highchart ============================================================
        
        //get from T_SQA_DU_SUMMARY_MDL Where model per month
        // ambil total unit dan cumulative total unit
        $sql = "select SUM(NUM_VEH) AS NUM_VEH
        from T_SQA_DU_SUMMARY_MDL
        where MODEL = '". $model ."' and MONTH(PDATE) = '". $bulan1 ."'";
        //echo $sql;
        $ambil = $this->dm->sql_self($sql);
        $total_unit = $ambil[0]->NUM_VEH;
        
        
        $this->dm->init('T_SQA_DU_SUMMARY_MDL', 'PLANT_CD');
        $w = "PDATE = '" . $date_daily_report . "' and MODEL = '". $model ."'";
        $ambil = $this->dm->select('', '',$w);
        //check NUM_VEH -per daily/per prod date- get from T_SQA_DU_SUMMARY_MDL
        $num_veh = $ambil[0]->NUM_VEH;

        //count get from T_SQA_REPLY_SUMMARY_MDL_SHOP Where SUM_TYPE (D=DELAY)
        $this->dm->init('T_SQA_REPLY_SUMMARY_MDL_SHOP', 'PLANT_CD');
        $w = "SUM_TYPE = 'D' and MODEL ='". $model ."'";
        $list_delay = $this->dm->select('', '', $w);


        //query total_send per last date
        $sql = "select SUM(NUM_PS_MONTHLY) AS TOTAL_SEND
         from T_SQA_REPLY_SUMMARY_MDL
         where SUM_TYPE = 'S' and (PDATE) = '". $date_daily_report ."'
         and MODEL = '" . $model . "'";
        $list_total_send = $this->dm->sql_self($sql);
        $total_send = $list_total_send[0]->TOTAL_SEND;
        // and PDATE = (select max(PDATE) from T_SQA_REPLY_SUMMARY_MDL_SHOP)

        //query total_reply per last date
        $sql = "select SUM(NUM_PS_MONTHLY) AS TOTAL_REPLY
         from T_SQA_REPLY_SUMMARY_MDL
         where SUM_TYPE = 'R' and (PDATE) = '". $date_daily_report ."'
         and MODEL = '" . $model . "'";
        $list_total_reply = $this->dm->sql_self($sql);
        $total_reply = $list_total_reply[0]->TOTAL_REPLY;
        //and PDATE = (select max(PDATE) from T_SQA_REPLY_SUMMARY_MDL_SHOP)

      
        // get from T_SQA_DU_SUMMARY_MDL_CTG where DU_MDL_CTG_RANK_DAILY accum per date and Ax = ASSY, Dx = Driving, Px = Painting

        // Total DU
        $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG', 'PLANT_CD');
        $w = "PDATE = '" . $tgl_prdt . "' and MODEL = '" . $model . "'";
        $total_DU = $this->dm->select('', '', $w);
        $data['total_DU'] = $total_DU;

        //get from T_SQA_DU_SUMMARY_MDL_CTG_RANK rank_nm where DU_MDL_CTG_RANK_DAILY accum per date and Ax = ASSY, Dx = Driving, Px = Painting

        // rank func & apperance
        $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG_RANK', 'PLANT_CD');
        $w = "PDATE = '" . $date_daily_report . "' and MODEL = '" . $model . "'";
        $list_rank = $this->dm->select('', '', $w);
        $data['list_rank'] = $list_rank;

        //DU_MDL_MONTHLY acc. get from T_SQA_DU_SUMMARY_MDL
        $sql = "select *
        from T_SQA_DU_SUMMARY_MDL_CTG_RANK where MODEL = '" . $model . "'
        and MONTH(PDATE) = '". date("m",strtotime($date_daily_report)) ."'";
        $cum_DU = $this->dm->sql_self($sql);
        $data['cum_DU'] = $cum_DU;
      
        // DU_MDL_MONTHLY acc. get from T_SQA_DU_SUMMARY_MDL
        
        $this->dm->init('T_SQA_DU_SUMMARY_MDL', 'PLANT_CD');
        $w = "PDATE = '" . $tgl_prdt . "' and MODEL = '" . $model . "'";
        $total_DU_Mon = $this->dm->select('', '', $w);
        $data['total_DU_Mon'] = $total_DU_Mon;
        
       // Total Zero Defect. Cummulative day which no defect found at the current month.																
        $this->dm->init('T_SQA_DU_SUMMARY_MDL', 'PLANT_CD');
        $w = "PDATE = '" . $date_daily_report . "' and MODEL = '" . $model . "'";
        $ambil = $this->dm->select('', '', $w);
        
             
        $zero_dfct_day_num = $ambil[0]->ZERO_DFCT_DAY_NUM;
        $rec_zero_dfct_month_year = $ambil[0]->REC_ZERO_DFCT_MONTH_YEAR;
        $rec_zero_dfct_day_num = $ambil[0]->REC_ZERO_DFCT_DAY_NUM;
        $count_zero_dfct_day_num = $ambil[0]->COUNT_ZERO_DFCT;
        
                
        $data['zero_dfct_day_num'] = $zero_dfct_day_num;
        $data['rec_zero_dfct_month_year'] = $rec_zero_dfct_month_year;
        $data['rec_zero_dfct_day_num'] = $rec_zero_dfct_day_num;   
        $data['count_zero_dfct_day_num'] = $count_zero_dfct_day_num;        
        
        //TOTAL WORKING DAY 
       
        $sql = "select COUNT (WORK_FLAG) as TOTAL_WORK_CALENDER 
        from M_SQA_WORK_CALENDAR
        where WORK_FLAG ='1' and SHIFTNO ='2' and month(M_SQA_WORK_CALENDAR.WORK_PRDT) = '". $bulan1 ."'";
        $ambil = $this->dm->sql_self($sql);
        $total_working_day = $ambil[0]->TOTAL_WORK_CALENDER;
        $data['total_working_day'] = $total_working_day;
        
        //TOTAL INPSPRCTION_ITEM_FLG
        $sql = "select COUNT (INSP_ITEM_FLG) AS TOTAL_INPS_ITEM 
        from V_T_SQA_DFCT
        where INSP_ITEM_FLG ='1' and month(SQA_PDATE) = '". $bulan1 ."'
        and SQA_PDATE <= '". $date_daily_report ."'
        and DESCRIPTION = '". $model ."' AND APPROVE_PDATE IS NOT NULL
        ";
        $ambil = $this->dm->sql_self($sql);
        $total_inspection_item = $ambil[0]->TOTAL_INPS_ITEM;
        $data['total_inspection_item'] = $total_inspection_item;
        //month(SQA_PDATE) = '". $bulan ."'
        
        //COUNT TOTAL INSPECTION ITEM
        $sql = "select count(INSP_ITEM_FLG) as TOTAL
        from V_T_SQA_DFCT
        where month(SQA_PDATE) = '". $bulan1 ."'
        and SQA_PDATE <= '". $date_daily_report ."'
        and DESCRIPTION = '". $model ."' 
            ";
        $total_count_inspection_item = $this->dm->sql_self_count($sql, 'TOTAL');
        //hitung persentase inspection_item
        $persentase_insp_item = ($total_inspection_item/$total_count_inspection_item*100);
        $data['persentase_insp_item']= number_format($persentase_insp_item,2);
        
        //TOTAL REPAIR HISTORY
        $sql = "select COUNT (REPAIR_FLG) AS TOTAL_REPAIR_FLAG 
        from V_T_SQA_DFCT
        where REPAIR_FLG ='1'  and month(SQA_PDATE) = '". $bulan1 ."'
        and SQA_PDATE <= '". $date_daily_report ."'
        and DESCRIPTION = '". $model ."' AND APPROVE_PDATE IS NOT NULL
        ";
        $ambil = $this->dm->sql_self($sql);
        $total_repair_flag = $ambil[0]->TOTAL_REPAIR_FLAG;
        $data['total_repair_flag'] = $total_repair_flag;
        
        //COUNT TOTAL REPAIR HISTORY
        $sql = "select count(REPAIR_FLG) as TOTAL
        from V_T_SQA_DFCT
        where month(SQA_PDATE) = '". $bulan1 ."'
        and SQA_PDATE <= '". $date_daily_report ."'
        and DESCRIPTION = '". $model ."' 
            ";
        $total_count_repair_history = $this->dm->sql_self_count($sql, 'TOTAL');
        //hitung persentase repair_history
        $persentase_reply_hist = ($total_repair_flag/$total_count_repair_history*100);
        $data['persentase_reply_hist']= number_format($persentase_reply_hist,2);
        
        //PROD SHIFT RED
        $sql = "select count(ASSY_SHIFTGRPNM) as TOTAL_ASSY_SHIFTGRPNM
        from V_T_SQA_DFCT
        where month(SQA_PDATE) = '". $bulan1 ."' and SQA_PDATE <= '". $date_daily_report ."' and DESCRIPTION = '". $model ."'
        and ASSY_SHIFTGRPNM = '1' AND APPROVE_PDATE IS NOT NULL
        ";
        $ambil = $this->dm->sql_self($sql);
        $total_prod_shift_red = $ambil[0]->TOTAL_ASSY_SHIFTGRPNM;
        $data['total_prod_shift_red'] = $total_prod_shift_red;
        
        //PROD SHIFT WHITE
        $sql = "select count(ASSY_SHIFTGRPNM) as TOTAL_ASSY_SHIFTGRPNM
        from V_T_SQA_DFCT
        where month(SQA_PDATE) = '". $bulan1 ."' and SQA_PDATE <= '". $date_daily_report ."' and DESCRIPTION = '". $model ."'
        and ASSY_SHIFTGRPNM = '2' AND APPROVE_PDATE IS NOT NULL
        ";
        $ambil = $this->dm->sql_self($sql);
        $total_insp_prod_white = $ambil[0]->TOTAL_ASSY_SHIFTGRPNM;
        $data['total_insp_prod_white'] = $total_insp_prod_white;
        
        //COUNT TOTAL PROD SHIFT
        $sql = "select count(ASSY_SHIFTGRPNM) as TOTAL_ASSY_SHIFTGRPNM
        from V_T_SQA_DFCT
        where month(SQA_PDATE) = '". $bulan1 ."' and SQA_PDATE <= '". $date_daily_report ."' and DESCRIPTION = '". $model ."' AND APPROVE_PDATE IS NOT NULL
            ";
        $total_prod_shift = $this->dm->sql_self_count($sql, 'TOTAL_ASSY_SHIFTGRPNM');
        //hitung persentase repair_historyinsp_shift
        $persentase_prod_shift_red = ($total_prod_shift_red/$total_prod_shift*100);
        $data['persentase_prod_shift_red']= number_format($persentase_prod_shift_red,2);
        $persentase_prod_shift_white = ($total_insp_prod_white/$total_prod_shift*100);
        $data['persentase_prod_shift_white']= number_format($persentase_prod_shift_white,2);
        $persentase_insp_shift_white = ($total_insp_prod_white/$total_prod_shift*100);
        $data['persentase_insp_shift_white']= number_format($persentase_insp_shift_white,2);
        
         //INSP SHIFT RED
        $sql = "select count(SQA_SHIFTGRPNM) as TOTAL_SQA_SHIFTGRPNM
        from V_T_SQA_DFCT
        where month(SQA_PDATE) = '". $bulan1 ."' and SQA_PDATE <= '". $date_daily_report ."' and DESCRIPTION = '". $model ."'
        and SQA_SHIFTGRPNM = 'RED' AND APPROVE_PDATE IS NOT NULL
        ";
        $ambil = $this->dm->sql_self($sql);
        $total_insp_shift_red = $ambil[0]->TOTAL_SQA_SHIFTGRPNM;
        $data['total_insp_shift_red'] = $total_insp_shift_red;
        
        //INSP SHIFT WHITE
        $sql = "select count(SQA_SHIFTGRPNM) as TOTAL_SQA_SHIFTGRPNM
        from V_T_SQA_DFCT
        where month(SQA_PDATE) = '". $bulan1 ."' and SQA_PDATE <= '". $date_daily_report ."' and DESCRIPTION = '". $model ."'
        and SQA_SHIFTGRPNM = 'WHITE' AND APPROVE_PDATE IS NOT NULL
        ";
        $ambil = $this->dm->sql_self($sql);
        $total_insp_shift_white = $ambil[0]->TOTAL_SQA_SHIFTGRPNM;
        $data['total_insp_shift_white'] = $total_insp_shift_white;
        
        //COUNT TOTAL INSP SHIFT
        $sql = "select count(SQA_SHIFTGRPNM) as TOTAL_SQA_SHIFTGRPNM
        from V_T_SQA_DFCT
        where month(SQA_PDATE) = '". $bulan1 ."' and SQA_PDATE <= '". $date_daily_report ."' and DESCRIPTION = '". $model ."' AND APPROVE_PDATE IS NOT NULL
            ";
        $total_insp_shift = $this->dm->sql_self_count($sql, 'TOTAL_SQA_SHIFTGRPNM');
        //hitung persentase repair_historyinsp_shift
        $persentase_insp_shift_red = ($total_insp_shift_red/$total_insp_shift*100);
        $data['persentase_insp_shift_red']= $persentase_insp_shift_red;
        $persentase_insp_shift_white = ($total_insp_shift_white/$total_insp_shift*100);
        $data['persentase_insp_shift_white']= $persentase_insp_shift_white;
        
        
        
        //TOTAL UNIT NUM_VEH
        $sql = "select SUM(NUM_VEH) as TOTAL_NUM_VEH
        from T_SQA_DU_SUMMARY_MDL
        where FISCAL_YEAR = (select distinct FISCAL_YEAR from T_SQA_DU_SUMMARY_MDL where PDATE = '". $date_daily_report ."' AND MODEL = '". $model ."')
        and month(PDATE) = '". $bulan1 ."'
        and PDATE <= '". $date_daily_report ."'  
        and MODEL = '". $model ."'       
        ";
        $ambil = $this->dm->sql_self($sql);
        $total_unit_month = $ambil[0]->TOTAL_NUM_VEH;
        $data['total_unit_month'] = $total_unit_month;
        
        //TOTAL UNIT NUM_DFCT and FISCAL YEAR
        $sql = "select SUM(NUM_DFCT) as NUM_DFCT, FISCAL_YEAR
        from T_SQA_DU_SUMMARY_MDL
        where FISCAL_YEAR = (select distinct FISCAL_YEAR from T_SQA_DU_SUMMARY_MDL where PDATE = '". $date_daily_report ."' AND MODEL = '". $model ."')
        and MODEL = '". $model ."'  
        and month(PDATE) = '". $bulan1 ."'  
        and PDATE <= '". $date_daily_report ."'               
        group by FISCAL_YEAR       
        ";
        $ambil = $this->dm->sql_self($sql);
        $total_defect = $ambil[0]->NUM_DFCT;
        $fiscal = $ambil[0]->FISCAL_YEAR;
        $data['fiscal'] = $fiscal;                        
        $data['total_defect'] = $total_defect;
        
        //menampilkan shop_nm dari master 
        $this->dm->init('M_SQA_SHOP','SHOP_ID');
        $w = "SHOP_SHOW = '1'" ;
        $sn = $this->dm->select('','',$w);
        $jml_sn = count($sn);
         
         
        $data['jml_sn'] = $jml_sn; 
        $data['sn'] = $sn;             
        $data['num_veh'] = $num_veh;
        $data['total_unit'] = $total_unit;
        $data['total_reply'] = $total_reply;
        $data['total_send'] = $total_send;
        $data['delay_count'] = $total_delay;
        $data['list_delay'] = $list_delay;
        $data['model'] = $model;

        $this->load->view('download_report/print_plaint');
        $this->load->view('download_report/daily_report_print', $data);
    }
    
    

}

?>