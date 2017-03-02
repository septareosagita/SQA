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
        $data['date_daily_report'] = $date_daily_report; 
		$sql="declare @Date varchar(100)='" . $date_daily_report . "'
			declare @model varchar(100)='" . $model . "' 
			SELECT [SUM_TYPE]
				,sum([NUM_PS_DAILY])TOTAL 
			FROM [T_SQA_REPLY_SUMMARY_MDL_SHOP]
			WHERE MODEL=@MODEL
			AND PDATE=@DATE
			GROUP BY [PLANT_CD]
				,[PDATE]
				,[FISCAL_YEAR]
				,[MODEL] 
				,[SUM_TYPE]";
		$totalsend = $this->dm->sql_self($sql); 
		$TotalSend=0;
		$TotalReplay=0;
		foreach ($totalsend as $row)
		{
			if($row->SUM_TYPE=="R")
			{
				$TotalReply=$row->TOTAL;
			}
			else
			{
				$TotalSend=$row->TOTAL;
			}
		}
		
		$sql="
			declare @Date varchar(100)='" . $date_daily_report . "'
			declare @model varchar(100)='" . $model . "' 
			SELECT [SHOP_NM] 
				,sum([NUM_PS_DAILY])TOTAL 
			FROM [T_SQA_REPLY_SUMMARY_MDL_SHOP]
			WHERE MODEL=@MODEL
			AND PDATE=@DATE
			and SUM_TYPE='R'
			GROUP BY [PLANT_CD]
				,[PDATE]
				,[FISCAL_YEAR]
				,[MODEL]
				,[SHOP_NM]
				,[SUM_TYPE]
			ORDER BY [SHOP_NM]";
		$totalpsheet = $this->dm->sql_self($sql); 
		
		$sql="
			declare @Date varchar(100)='" . $date_daily_report . "'
			declare @model varchar(100)='" . $model . "'  
			SELECT MODEL, CATEGORY, TOTAL, [01] SATU,[02] DUA,[03] TIGA,[04]EMPAT,[06]ENAM FROM ( 
			SELECT [MODEL] ,
			CASE WHEN [DFCT_CTG]='A' THEN 'ASSEMBLY' WHEN [DFCT_CTG]='D' THEN 'DRIVING' ELSE 'PAINTING' END CATEGORY ,
			[RANK_ID] ,
			MAX([NUM_VEH])TOTAL ,
			SUM([DU_MDL_CTG_RANK_DAILY] ) NILAI 
			FROM [dbo].[T_SQA_DU_SUMMARY_MDL_CTG_RANK] 
			WHERE PDATE=@Date AND MODEL =@Model 
			GROUP BY [MODEL] ,[DFCT_CTG] ,[RANK_ID] ) TB 
			PIVOT (MAX(NILAI) FOR [RANK_ID] IN ([01],[02],[03],[04],[06])) AS PV";
		$auditresult1 = $this->dm->sql_self($sql); 
		 
		 $sql="
			declare @Date varchar(100)='" . $date_daily_report . "'
			declare @model varchar(100)='" . $model . "'  
			SELECT MODEL, CATEGORY, TOTAL, [01] SATU,[02] DUA,[03] TIGA,[04]EMPAT,[06]ENAM FROM ( 
			SELECT [MODEL] ,
			CASE WHEN [DFCT_CTG]='A' THEN 'ASSEMBLY' WHEN [DFCT_CTG]='D' THEN 'DRIVING' ELSE 'PAINTING' END CATEGORY ,
			[RANK_ID] ,
			MAX([NUM_VEH])TOTAL ,
			SUM([DU_MDL_CTG_RANK_DAILY] ) NILAI 
			FROM [dbo].[T_SQA_DU_SUMMARY_MDL_CTG_RANK] 
			WHERE left(PDATE,7)=left(@Date,7) AND MODEL =@Model 
			GROUP BY [MODEL] ,[DFCT_CTG] ,[RANK_ID] ) TB 
			PIVOT (MAX(NILAI) FOR [RANK_ID] IN ([01],[02],[03],[04],[06])) AS PV";
		$auditresult2 = $this->dm->sql_self($sql); 
		
		
		
		$sql = "
				DECLARE @@date_from datetime, @@date_to datetime='" . $date_daily_report . "' 
				SELECT @@date_from=DATEADD(MONTH,-3,@@date_to) 
				;with dates as(
					SELECT @@date_from as dt
					UNION ALL
					SELECT DATEADD(MM,1,dt) from dates where dt<@@date_to
				)   
				SELECT DT,ISNULL(B.Category,'G') CATEGORY,ISNULL(VALUE,0) NILAI ,
				DATENAME(m, DT+'-01') DName
				FROM
				(
					SELECT LEFT(CONVERT(VARCHAR(7),DT,120),7) DT FROM dates 
				) A LEFT JOIN 
				(
					SELECT  LEFT(PDATE,7) PDATE,Category,sum([DU_MDL_CTG_RANK_DAILY]) VALUE
					FROM [T_SQA_DU_SUMMARY_MDL_CTG_RANK] m
					left join m_sqa_rank r on m.rank_id=r.RANK_ID
					WHERE Category='G' AND MODEL='" . $model . "'
					group by  Category, LEFT(PDATE,7) 
				) B ON A.DT=B.PDATE
				UNION ALL
				SELECT DT,ISNULL(B.Category,'R'),ISNULL(VALUE,0) ,DATENAME(m, DT+'-01') DName FROM
				(
					SELECT LEFT(CONVERT(VARCHAR(7),DT,120),7) DT FROM dates 
				) A LEFT JOIN 
				(
					SELECT  LEFT(PDATE,7) PDATE,Category,sum([DU_MDL_CTG_RANK_DAILY]) VALUE
					FROM [T_SQA_DU_SUMMARY_MDL_CTG_RANK] m
					left join m_sqa_rank r on m.rank_id=r.RANK_ID
					WHERE Category='R' AND MODEL='" . $model . "'
					group by  Category, LEFT(PDATE,7) 
				) B ON A.DT=B.PDATE
				"; 
		$daily_tendency1 = $this->dm->sql_self($sql);  
		$Month1=   array(); 
		$Global1=   array(); 
		$Regional1=   array();
		foreach ($daily_tendency1 as $row)
		{
			if($row->CATEGORY=="R")
			{
				$Regional1[]=$row->NILAI;
				$Month1[]=$row->DName;
			}
			else if($row->CATEGORY=="G")
			{
				$Global1[]=$row->NILAI;
			} 
		}  
		
		
		
		$sql="
			declare @Date varchar(100)='" . $date_daily_report . "'
			DECLARE @@date_from datetime, @@date_to datetime=@Date
			SELECT @@date_from=DATEADD(MONTH, DATEDIFF(MONTH, 0, @Date), 0)
			SELECT @@date_to=dateadd(d,-(day(dateadd(m,1,@Date))),dateadd(m,1,@Date))
			;with dates as(
				SELECT @@date_from as dt
				UNION ALL
				SELECT DATEADD(d,1,dt) from dates where dt<@@date_to
			)  
			select TB.*, ISNULL(T.VALUE,0) Cum from
			(
				SELECT DAY(DT) DAYNUMBER, DT,ISNULL(B.Category,'G') CATEGORY,ISNULL(VALUE,0) NILAI
				FROM
				(
					SELECT CONVERT(VARCHAR(10),DT,120) DT FROM dates 
				) A LEFT JOIN 
				(
					SELECT  PDATE PDATE,Category,sum([DU_MDL_CTG_RANK_DAILY]) VALUE
					FROM [T_SQA_DU_SUMMARY_MDL_CTG_RANK] m
					left join m_sqa_rank r on m.rank_id=r.RANK_ID
					WHERE Category='G' AND MODEL='" . $model . "'
					group by  Category, PDATE 
				) B ON A.DT=B.PDATE
				UNION ALL
				SELECT DAY(DT) DAYNUMBER, DT,ISNULL(B.Category,'R'),ISNULL(VALUE,0) FROM
				(
					SELECT CONVERT(VARCHAR(10),DT,120) DT FROM dates 
				) A LEFT JOIN 
				(
					SELECT  PDATE PDATE,Category,sum([DU_MDL_CTG_RANK_DAILY]) VALUE
					FROM [T_SQA_DU_SUMMARY_MDL_CTG_RANK] m
					left join m_sqa_rank r on m.rank_id=r.RANK_ID
					WHERE Category='R' AND MODEL='" . $model . "'
					group by  Category, PDATE
				) B ON A.DT=B.PDATE 
			) TB 
			LEFT JOIN 
			(
				SELECT PDATE, SUM(VALUE) VALUE FROM
				(
					SELECT PDATE, sum([DU_MDL_CTG_RANK_DAILY]) VALUE
					FROM [T_SQA_DU_SUMMARY_MDL_CTG_RANK] m
					left join m_sqa_rank r on m.rank_id=r.RANK_ID
					WHERE Category='G' AND MODEL='" . $model . "'
					group by  Category, PDATE  
					UNION ALL 
					SELECT PDATE, sum([DU_MDL_CTG_RANK_DAILY]) VALUE
					FROM [T_SQA_DU_SUMMARY_MDL_CTG_RANK] m
					left join m_sqa_rank r on m.rank_id=r.RANK_ID
					WHERE Category='R' AND MODEL='" . $model . "'
					group by  Category, PDATE
				) TB GROUP BY PDATE
			) T ON T.PDATE=TB.DT
		";
		$daily_tendency2 = $this->dm->sql_self($sql); 
		 
		$Month2=array(); 
		$Global2=array(); 
		$Regional2=array();
		$Cumulative2=array();
		foreach ($daily_tendency2 as $row)
		{
			if($row->CATEGORY=="R")
			{
				$Regional2[]=$row->NILAI;
				$Month2[]=$row->DAYNUMBER;
				$Cumulative2[]=$row->Cum;
			}
			else if($row->CATEGORY=="G")
			{
				$Global2[]=$row->NILAI;  
			} 
		} 
		
		$sql="declare @Date varchar(100)='" . $date_daily_report . "'
			declare @model varchar(100)='" . $model . "' 
			DECLARE @@date_from datetime, @@date_to datetime=@Date
			SELECT @@date_from=DATEADD(MONTH, DATEDIFF(MONTH, 0, @Date), 0)
			SELECT @@date_to=dateadd(d,-(day(dateadd(m,1,@Date))),dateadd(m,1,@Date))
			;with dates as(
				SELECT @@date_from as dt
				UNION ALL
				SELECT DATEADD(d,1,dt) from dates where dt<@@date_to
			)   
			SELECT SUM_TYPE,DT, SUM(NUM_PS_DAILY) nilai FROM
			(
				SELECT  
					TB.SHOP_NM,
					DT, 
					ISNULL(R.MODEL,@MODEL) MODEL,
					ISNULL(R.SUM_TYPE,'R')SUM_TYPE,
					ISNULL(R.NUM_PS_DAILY,0)NUM_PS_DAILY
				FROM
				(
					SELECT SHOP_ID, SHOP_NM,CONVERT(VARCHAR(10),DT ,120) DT FROM dates 
					CROSS JOIN  (SELECT SHOP_ID,SHOP_NM FROM [dbo].[M_SQA_SHOP] WHERE SHOP_SHOW=1) SHOP
				) TB
				LEFT JOIN 
				(
					SELECT [PDATE] 
						,[MODEL]
						,[SHOP_NM]
						,[SUM_TYPE]
						,[NUM_PS_DAILY]  
					FROM [T_SQA_REPLY_SUMMARY_MDL_SHOP] 
					where MODEL=@model
					and SUM_TYPE='R' 
				) R ON TB.dt=R.PDATE AND R.SHOP_NM=TB.SHOP_NM
			) T GROUP BY DT,SUM_TYPE
			UNION ALL 
			SELECT SUM_TYPE,DT, SUM(NUM_PS_DAILY) NUM_PS_DAILY FROM
			(
				SELECT  
					TB.SHOP_NM,
					DT, 
					ISNULL(R.MODEL,@MODEL) MODEL,
					ISNULL(R.SUM_TYPE,'S')SUM_TYPE,
					ISNULL(R.NUM_PS_DAILY,0)NUM_PS_DAILY
				FROM
				(
					SELECT SHOP_ID, SHOP_NM,CONVERT(VARCHAR(10),DT ,120) DT FROM dates 
					CROSS JOIN  (SELECT SHOP_ID,SHOP_NM FROM [dbo].[M_SQA_SHOP] WHERE SHOP_SHOW=1) SHOP
				) TB
				LEFT JOIN 
				(
					SELECT [PDATE] 
						,[MODEL]
						,[SHOP_NM]
						,[SUM_TYPE]
						,[NUM_PS_DAILY]  
					FROM [T_SQA_REPLY_SUMMARY_MDL_SHOP] 
					where MODEL=@model
					and SUM_TYPE='S' 
				) R ON TB.dt=R.PDATE AND R.SHOP_NM=TB.SHOP_NM
			) U GROUP BY DT,SUM_TYPE";
		$problemsheet1 = $this->dm->sql_self($sql); 
		$Send1=array(); 
		$Reply1=array(); 
		$NomSend=0;
		$NomReply=0;
		foreach ($problemsheet1 as $row)
		{
			if($row->SUM_TYPE=="R")
			{
				if($row->DT<=$date_daily_report)
				{
					$NomReply=$NomReply+$row->nilai;
				}
				else
				{
					$NomReply=0;
				}
				$Reply1[]=$NomReply;
			}
			else if($row->SUM_TYPE=="S")
			{
				if($row->DT<=$date_daily_report)
				{
					$NomSend=$NomSend+$row->nilai; 
				}
				else
				{
					$NomSend=0;
				}
				$Send1[]=$NomSend;
			} 
		} 
		
		
		
		
		$sql="declare @Date varchar(100)='" . $date_daily_report . "'
			declare @model varchar(100)='" . $model . "' 
			DECLARE @@date_from datetime, @@date_to datetime=@Date
			SELECT @@date_from=DATEADD(MONTH, DATEDIFF(MONTH, 0, @Date), 0)
			SELECT @@date_to=@Date
			;with dates as(
				SELECT @@date_from as dt
				UNION ALL
				SELECT DATEADD(d,1,dt) from dates where dt<@@date_to
			)   
			 SELECT SHOP_NM,SUM_TYPE,SUM(NUM_PS_DAILY) NILAI
			 FROM (
				SELECT  
					TB.SHOP_NM,
					DT, 
					ISNULL(R.MODEL,@MODEL) MODEL,
					ISNULL(R.SUM_TYPE,'R')SUM_TYPE,
					ISNULL(R.NUM_PS_DAILY,0)NUM_PS_DAILY
				FROM
				(
					SELECT SHOP_ID, SHOP_NM,CONVERT(VARCHAR(10),DT ,120) DT FROM dates 
					CROSS JOIN  (SELECT SHOP_ID,SHOP_NM FROM [dbo].[M_SQA_SHOP] WHERE SHOP_SHOW=1) SHOP
				) TB
				LEFT JOIN 
				(
					SELECT [PDATE] 
						,[MODEL]
						,[SHOP_NM]
						,[SUM_TYPE]
						,[NUM_PS_DAILY]  
					FROM [T_SQA_REPLY_SUMMARY_MDL_SHOP] 
					where MODEL=@model
					and SUM_TYPE='R' 
				) R ON TB.dt=R.PDATE AND R.SHOP_NM=TB.SHOP_NM
			 ) A GROUP BY SHOP_NM,SUM_TYPE
			UNION ALL 
			SELECT SHOP_NM,SUM_TYPE,SUM(NUM_PS_DAILY) NILAI
			FROM(
				SELECT  
					TB.SHOP_NM,
					DT, 
					ISNULL(R.MODEL,@MODEL) MODEL,
					ISNULL(R.SUM_TYPE,'S')SUM_TYPE,
					ISNULL(R.NUM_PS_DAILY,0)NUM_PS_DAILY
				FROM
				(
					SELECT SHOP_ID, SHOP_NM,CONVERT(VARCHAR(10),DT ,120) DT FROM dates 
					CROSS JOIN  (SELECT SHOP_ID,SHOP_NM FROM [dbo].[M_SQA_SHOP] WHERE SHOP_SHOW=1) SHOP
				) TB
				LEFT JOIN 
					(
						SELECT [PDATE] 
							,[MODEL]
							,[SHOP_NM]
							,[SUM_TYPE]
							,[NUM_PS_DAILY]  
						FROM [T_SQA_REPLY_SUMMARY_MDL_SHOP] 
						where MODEL=@model
						and SUM_TYPE='S' 
					) R ON TB.dt=R.PDATE AND R.SHOP_NM=TB.SHOP_NM
				 ) B GROUP BY SHOP_NM,SUM_TYPE";
		$problemsheet3 = $this->dm->sql_self($sql); 
		$Shop3=array(); 
		$Send3=array(); 
		$Reply3=array();
		
		foreach ($problemsheet3 as $row)
		{
			if($row->SUM_TYPE=="R")
			{ 
				$Shop3[]=$row->SHOP_NM; 
				$Reply3[]=$row->NILAI; 
			}
			else if($row->SUM_TYPE=="S")
			{  
				$Send3[]=$row->NILAI; 
			} 
		} 
		
		$sql="
			DECLARE @MODEL  VARCHAR(15)='" . $model . "'
			DECLARE @DATE VARCHAR(10)='" . $date_daily_report . "'
			SELECT  DFCT	
				,RANK_NM	
				,(SELECT B.judge FROM [dbo].[M_SQA_RANK] B WHERE B.RANK_ID=D.RANK_NM) AS JUDGE
				,MEASUREMENT as ACTUAL	
				,REFVAL	AS [STANDARD]
				,[KCY]
				,[PLANT]
				,[INSPECTION]
				,REPAIR_FLG	
				,[PROD_SHIFT]
				,SQA_SHIFTGRPNM	
				,SHOP_NM AS RESPONSIBLE
				,CONVERT(VARCHAR(6),SQA_PDATE,6) AS FOUND_DATE 
				,CONVERT(VARCHAR(6),[TARGET_DATE],6) TARGET_REPLAY 
				,(
					SELECT COUNT(1) FROM [T_SQA_DFCT]  A
					LEFT JOIN [dbo].[T_SQA_VINF] B
					ON A.VINNO=B.VINNO 
					and A.IDNO=B.[IDNO]
					and A.BODYNO=B.BODY_NO
					and A.REFNO=B.REFNO 
					WHERE V.DESCRIPTION =@MODEL 
					AND LEFT(SQA_PDATE,7)=LEFT(@DATE,7)
					AND A.DFCT=D.DFCT
				) REPEAT_P 
				,CONVERT(VARCHAR(6),[REPLAY_DATE],6)  AS REPLAY_DATE_PROD
				,CONVERT(VARCHAR(6),CHECK_PDATE,6) AS REPLAY_DATE_INPS 
			  FROM [T_SQA_DFCT] D
			  LEFT JOIN [dbo].[T_SQA_VINF] V
			  ON D.VINNO=D.VINNO 
			  and d.IDNO=v.[IDNO]
			  and d.BODYNO=v.BODY_NO
			  and d.REFNO=v.REFNO 
			  WHERE V.DESCRIPTION =@MODEL
			  AND SQA_PDATE=@DATE
		";
		$problemfollow = $this->dm->sql_self($sql); 
		
		
		
				$sql="
			DECLARE @MODEL  VARCHAR(15)='" . $model . "'
			DECLARE @DATE VARCHAR(10)='" . $date_daily_report . "'
			SELECT m.SHOP_NM ,CASE WHEN RESPONSIBLE IS NULL THEN 0 ELSE COUNT(1) END JUMLAH 
			FROM M_SQA_SHOP M 
			LEFT JOIN
			(
						SELECT  DFCT	
							,RANK_NM	
							,(SELECT B.judge FROM [dbo].[M_SQA_RANK] B WHERE B.RANK_ID=D.RANK_NM) AS JUDGE
							,MEASUREMENT as ACTUAL	
							,REFVAL	AS [STANDARD]
							,[KCY]
							,[PLANT]
							,[INSPECTION]
							,REPAIR_FLG	
							,[PROD_SHIFT]
							,SQA_SHIFTGRPNM	
							,SHOP_NM AS RESPONSIBLE
							,CONVERT(VARCHAR(6),SQA_PDATE,6) AS FOUND_DATE 
							,CONVERT(VARCHAR(6),[TARGET_DATE],6) TARGET_REPLAY 
							,(
								SELECT COUNT(1) FROM [T_SQA_DFCT]  A
								LEFT JOIN [dbo].[T_SQA_VINF] B
								ON A.VINNO=B.VINNO 
								and A.IDNO=B.[IDNO]
								and A.BODYNO=B.BODY_NO
								and A.REFNO=B.REFNO 
								WHERE V.DESCRIPTION =@MODEL 
								AND LEFT(SQA_PDATE,7)=LEFT(@DATE,7)
								AND A.DFCT=D.DFCT
							) REPEAT_P 
							,CONVERT(VARCHAR(6),[REPLAY_DATE],6)  AS REPLAY_DATE_PROD
							,CONVERT(VARCHAR(6),CHECK_PDATE,6) AS REPLAY_DATE_INPS 
						  FROM [T_SQA_DFCT] D
						  LEFT JOIN [dbo].[T_SQA_VINF] V
						  ON D.VINNO=D.VINNO 
						  and d.IDNO=v.[IDNO]
						  and d.BODYNO=v.BODY_NO
						  and d.REFNO=v.REFNO 
						  WHERE V.DESCRIPTION =@MODEL
						  AND SQA_PDATE=@DATE
			) TB ON TB.RESPONSIBLE=M.SHOP_NM
			WHERE M.SHOP_SHOW=1 AND SHOP_ID<>'IN'
			GROUP BY M.SHOP_NM,RESPONSIBLE
		";
		$occurence = $this->dm->sql_self($sql); 
		$occurencecat=array(); 
		$occurencenum=array(); 
		$occsum=0;
		foreach ($occurence as $row)
		{ 
			$occurencecat[]=$row->SHOP_NM; 
			$occurencenum[]=$row->JUMLAH; 
			$occsum=$occsum+$row->JUMLAH; 
		}
		
		
		
		
		$sql="
			DECLARE @MODEL  VARCHAR(15)='" . $model . "'
			DECLARE @DATE VARCHAR(10)='" . $date_daily_report . "'
			SELECT SHOP_NM ,CASE WHEN INSPECTION IS NULL THEN 0 ELSE COUNT(1) END JUMLAH 
			FROM M_SQA_SHOP M 
			LEFT JOIN
			(
						SELECT  DFCT	
							,RANK_NM	
							,(SELECT B.judge FROM [dbo].[M_SQA_RANK] B WHERE B.RANK_ID=D.RANK_NM) AS JUDGE
							,MEASUREMENT as ACTUAL	
							,REFVAL	AS [STANDARD]
							,[KCY]
							,[PLANT]
							,[INSPECTION]
							,REPAIR_FLG	
							,[PROD_SHIFT]
							,SQA_SHIFTGRPNM	
							,SHOP_NM AS RESPONSIBLE
							,CONVERT(VARCHAR(6),SQA_PDATE,6) AS FOUND_DATE 
							,CONVERT(VARCHAR(6),[TARGET_DATE],6) TARGET_REPLAY 
							,(
								SELECT COUNT(1) FROM [T_SQA_DFCT]  A
								LEFT JOIN [dbo].[T_SQA_VINF] B
								ON A.VINNO=B.VINNO 
								and A.IDNO=B.[IDNO]
								and A.BODYNO=B.BODY_NO
								and A.REFNO=B.REFNO 
								WHERE V.DESCRIPTION =@MODEL 
								AND LEFT(SQA_PDATE,7)=LEFT(@DATE,7)
								AND A.DFCT=D.DFCT
							) REPEAT_P 
							,CONVERT(VARCHAR(6),[REPLAY_DATE],6)  AS REPLAY_DATE_PROD
							,CONVERT(VARCHAR(6),CHECK_PDATE,6) AS REPLAY_DATE_INPS 
						  FROM [T_SQA_DFCT] D
						  LEFT JOIN [dbo].[T_SQA_VINF] V
						  ON D.VINNO=D.VINNO 
						  and d.IDNO=v.[IDNO]
						  and d.BODYNO=v.BODY_NO
						  and d.REFNO=v.REFNO 
						  WHERE V.DESCRIPTION =@MODEL
						  AND SQA_PDATE=@DATE
			) TB ON TB.INSPECTION=M.SHOP_NM
			WHERE M.SHOP_SHOW=1 AND SHOP_ID<>'IN'
			GROUP BY M.SHOP_NM,INSPECTION
		";
		$outflow = $this->dm->sql_self($sql); 
		
		$outflowcat=array(); 
		$outflownum=array(); 
		$outsum=0;
		foreach ($outflow as $row)
		{ 
			$outflowcat[]=$row->SHOP_NM; 
			$outflownum[]=$row->JUMLAH;  
			$outsum=$outsum+$row->JUMLAH; 
		} 
		
		
		  
		
		//daily tendency  1
		$rtn[0]=$Month1;
		$rtn[1]=$Global1;
		$rtn[2]=$Regional1; 
		//daily tendency  2
		$rtn[3]=$Month2;
		$rtn[4]=$Global2;
		$rtn[5]=$Regional2; 
		$rtn[6]=$Cumulative2; 
		
		//parameter data III & IV
		$rtn[7]=$dateparam; 
		
		//v. problem sheet 1
		$rtn[8]=$Send1;
		$rtn[9]=$Reply1; 
		
		//v. problem sheet 3
		$rtn[10]=$Shop3;
		$rtn[11]=$Send3;
		$rtn[12]=$Reply3;
		
		//vi. follow up
		$rtn[13]=$problemfollow; 
		
		//II. distributed occurence & outflow
		$rtn[14]=$outflowcat;
		$rtn[15]=$outflownum;
		$rtn[16]=$occurencecat;
		$rtn[17]=$occurencenum;
		$rtn[18]=$outsum;
		$rtn[19]=$occsum;
		
		
		$data['RTNJSON']= json_encode ($rtn) ; 
		
		
		
		$data['MODEL']=$model;
		$data['total'] = $totalpsheet;
		$data['totalsend'] =$TotalSend;
		$data['totalreplay'] =$TotalReplay;
		$data['auditresult1'] =$auditresult1;
		$data['auditresult2'] =$auditresult2;
         $this->load->view('download_report/print_plaint');
        $this->load->view('download_report/new_daily_report_print', $data);
    }
     

}

?>