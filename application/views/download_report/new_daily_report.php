
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js"></script>  
<script type="text/javascript" src="<?= base_url() ?>assets/js/highcharts.src.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/public/javascript/FusionCharts.js"></script>
<style>
	.tablenya
	{
		border-collapse: collapse;
		width:100%;
		height:100%;
		text-align:center;
	}
	.header
	{
		background: #EEEEEE none repeat scroll 0 0;
		border: solid black 1px;
		font-size: 10px;
		padding: 5px;
		text-align: center;
		vertical-align: middle;
	} 
	.borderTable {
		border: 1px solid black;
	}

</style>


<script type="text/javascript">
function daily_report_print(){ 
    var cek = confirm('Are your sure want to print ?');    
    if(cek){                                                            
    var report_url = '<?=site_url('download_report_print/daily_report')?>' + '/' + '<?= $this->uri->segment(3) ?>' + '/' + '<?= $this->uri->segment(4) ?>';
        window.open(report_url);
    }
}

function getdatereport()
{
	$.ajax({
		type: "POST",
		url: "<?= base_url() ?>" + "download_report/getData_daily_report", 
		dataType:'json',
		data:{
			model:"<?= $MODEL ?>",
			dailydate:"<?= date("Y-m-d", strtotime($date_daily_report)) ?>"
		},
		success : function(r)
		{   
			createtendency(r[0], r[1], r[2]);
			createtendency2(r[3], r[4], r[5], r[6],r[7]);
			createproblemsheet(r[3],r[8],r[9]);
			createproblemsheet2(r[10],r[11],r[12]); 
			InsertTable(r[13]);
			 createreport(r[14],r[15],r[16],r[17],r[18],r[19]);
		},
		error:function(r){
			console.log("Error read controller"); 
		}
	});
}



function createtendency(cat,Global,Regional)
{ 
	Highcharts.chart('dailytendency1', {
        chart: {
            type: 'column',
			spacingLeft: 0,
			spacingRight: 0,
			height:450
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: cat
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'left',
            x: 30,
            verticalAlign: 'top',
            y: 0,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                }
            }
        },
        series: [{
            name: 'Global',
            data: Global
        }, { 
            name: 'Regional',
            data: Regional
        }]
    });
};

function createtendency2(cat,Global,Regional,Cumulative, title)
{ 
    Highcharts.chart('dailytendency2', {
        title: {
            text: title
        },
		chart: {  
			spacingLeft: 0,
			spacingRight: 0,
			height:450
        }, 
		legend: {
			y: 20,
            align: 'center',
            verticalAlign: 'top'
		},
        xAxis: {
            categories: cat 
        }, 
        series: [{
            type: 'column',
            name: 'Global',
            data: Global
        }, {
            type: 'column',
            name: 'Regional',
            data: Regional
        },  {
            type: 'spline',
            name: 'Cumulative',
            data: Cumulative,
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        }]
    });

}

function createproblemsheet(cat,send,reply)
{
	 
	Highcharts.chart('problemsheet1', {
        title: {
            text: '',
            x: -20 //center
        },
		chart: { 
			height:250
        },  
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: cat
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        // tooltip: {
            // valueSuffix: '°C'
        // },
        legend: {
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'top',
            borderWidth: 0
        },
        series: [{
            name: 'Send',
            data: send
        }, { 
            name: 'Reply',
            data: reply
        }]
    });
}

function createproblemsheet2(cat,send,reply)
{
Highcharts.chart('problemsheet3', {
        title: {
            text: ''
        },
		chart: { 
			height:250
        }, 
        legend: {
            layout: 'horizontal',
            align: 'right',
            verticalAlign: 'top',
            borderWidth: 0
        }, 
        xAxis: {
            categories: cat
        },
        labels: {
            items: [{
                html: '',
                style: {
                    left: '50px',
                    top: '18px',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }]
        },
        series: [{
            type: 'column',
            name: 'Send',
            data: send
        }, {
            type: 'column',
            name: 'Reply',
            data: reply
        }]
    });
}

$(document).ready(function(){ 
	getdatereport(); 
});

function createreport(outcat, outnum, occcat,occnum, outsum, occsum)
{  
    Highcharts.chart('distributedproblem1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
			margin: [0, 0, 0, 0],
			spacingTop: 0,
			spacingBottom: 0,
			spacingLeft: 0,
			spacingRight: 0,
			height:195
        },  
	
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
				size:'55%'
            }
			
        },
        series: [{
            name: 'SHOP NAME',
            colorByPoint: true,
            data: [{
                name: outcat[0],
                y: outnum[0]/outsum
            }, {
                name: outcat[1],
                y: outnum[1]/outsum
            }, {
                name: outcat[2],
                y: outnum[2]/outsum
            }, {
                name: outcat[3],
                y: outnum[3]/outsum
            }, {
                name: outcat[4],
                y: outnum[4]/outsum
            }, {
                name: outcat[5],
                y: outnum[5]/outsum
            }]
        }]
    });

    Highcharts.chart('distributedproblem2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
			margin: [0, 0, 0, 0],
			spacingTop: 0,
			spacingBottom: 0,
			spacingLeft: 0,
			spacingRight: 0,
			height:195
        },  
	
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
				size:'55%'
            }
			
        },
        series: [{
            name: 'SHOP NAME',
            colorByPoint: true,
            data: [{
                name: occcat[0],
                y: occnum[0]/occsum
            }, {
                name: occcat[1],
                y: occnum[1]/occsum
            }, {
                name: occcat[2],
                y: occnum[2]/occsum
            }, {
                name: occcat[3],
                y: occnum[3]/occsum
            }, {
                name: occcat[4],
                y: occnum[4]/occsum
            }, {
                name: occcat[5],
                y: occnum[5]/occsum
            }]
        }]
    }); 
};

function InsertTable(data) { 
    var table = document.getElementById("tablefollow");
	var arr;
	for(var i =data.length-1; i>=0; i--)
	{
		var row = table.insertRow(3);
		var cell0 = row.insertCell(0); 
		var cell1 = row.insertCell(0); 
		var cell2 = row.insertCell(0);
		var cell3 = row.insertCell(0); 
		var cell4 = row.insertCell(0); 
		var cell5 = row.insertCell(0); 
		var cell6 = row.insertCell(0); 
		var cell7 = row.insertCell(0); 
		var cell8 = row.insertCell(0); 
		var cell9 = row.insertCell(0); 
		var cell10 = row.insertCell(0); 
		var cell11 = row.insertCell(0); 
		var cell12 = row.insertCell(0); 
		var cell13 = row.insertCell(0); 
		var cell14 = row.insertCell(0); 
		var cell15 = row.insertCell(0); 
		var cell16 = row.insertCell(0); 
		var cell17 = row.insertCell(0); 
		var cell18 = row.insertCell(0); 
		var cell19 = row.insertCell(0); 
		var cell20 = row.insertCell(0); 
		var cell21 = row.insertCell(0); 
		var cell22 = row.insertCell(0); 
		var cell23 = row.insertCell(0); 
		var cell24 = row.insertCell(0); 
		var cell25 = row.insertCell(0); 
		var cell26 = row.insertCell(0); 	
		var cell27 = row.insertCell(0); 	
		 
		cell0.innerHTML = "";
		cell1.innerHTML = "" ; 
		cell2.innerHTML = data[i].REPLAY_DATE_INPS ; 
		cell3.innerHTML = data[i].REPLAY_DATE_PROD ; 
		cell4.innerHTML = data[i].REPEAT_P ; 
		cell5.innerHTML = data[i].TARGET_REPLAY ; 
		cell6.innerHTML = data[i].FOUND_DATE ; 
		cell7.innerHTML = data[i].RESPONSIBLE ; 
		
		if(data[i].SQA_SHIFTGRPNM=="WHITE"){
			cell8.innerHTML = "x" ;
			cell9.innerHTML = "" ;
		}else if (data[i].SQA_SHIFTGRPNM=="RED"){
			cell8.innerHTML = "" ;
			cell9.innerHTML = "x" ;
		}else{
			cell8.innerHTML = "" ;
			cell9.innerHTML = "" ;
		} 
		
		if(data[i].PROD_SHIFT=="WHITE"){
			cell10.innerHTML = "x" ;
			cell11.innerHTML = "" ;
		}else if (data[i].PROD_SHIFT=="RED"){
			cell10.innerHTML = "" ;
			cell11.innerHTML = "x" ;
		}else{
			cell10.innerHTML = "" ;
			cell11.innerHTML = "" ;
		} 
		cell12.innerHTML = data[i].REPAIR_FLG ; 
		
		if(data[i].INSPECTION =="Assy"){
			cell13.innerHTML = ""; 
			cell14.innerHTML = ""; 
			cell15.innerHTML = "x"; 
			cell16.innerHTML = ""; 
			cell17.innerHTML = ""; 
			cell18.innerHTML = ""; 
		}
		else if(data[i].INSPECTION =="Inspection"){
			cell13.innerHTML = ""; 
			cell14.innerHTML = ""; 
			cell15.innerHTML = ""; 
			cell16.innerHTML = ""; 
			cell17.innerHTML = ""; 
			cell18.innerHTML = ""; 
		} 
		else if(data[i].INSPECTION =="Quality"){
			cell13.innerHTML = "x"; 
			cell14.innerHTML = ""; 
			cell15.innerHTML = ""; 
			cell16.innerHTML = ""; 
			cell17.innerHTML = ""; 
			cell18.innerHTML = "x"; 
		}
		else if(data[i].INSPECTION =="Tosho"){
			cell13.innerHTML = ""; 
			cell14.innerHTML = ""; 
			cell15.innerHTML = ""; 
			cell16.innerHTML = "x"; 
			cell17.innerHTML = ""; 
			cell18.innerHTML = ""; 
		}
		else if(data[i].INSPECTION =="Welding"){
			cell13.innerHTML = ""; 
			cell14.innerHTML = ""; 
			cell15.innerHTML = ""; 
			cell16.innerHTML = ""; 
			cell17.innerHTML = "x"; 
			cell18.innerHTML = ""; 
		} else {
			cell13.innerHTML = "x"; 
			cell14.innerHTML = ""; 
			cell15.innerHTML = ""; 
			cell16.innerHTML = ""; 
			cell17.innerHTML = ""; 
			cell18.innerHTML = ""; 
		}   
		if(data[i].PLANT==0)
		{
			cell19.innerHTML = "x"; 
			cell20.innerHTML = "" ; 
		}
		else
		{
			cell19.innerHTML = ""; 
			cell20.innerHTML = "x" ; 
		} 
		
		if(data[i].KCY=='true')
		{
			cell21.innerHTML = "x"; 
			cell22.innerHTML = "" ; 
		}
		else
		{
			cell21.innerHTML = ""; 
			cell22.innerHTML = "x" ; 
		} 
		cell23.innerHTML = data[i].STANDARD ; 
		cell24.innerHTML = data[i].ACTUAL ; 
		
		arr=data[i].JUDGE.split(',');
		if(arr[0]='F'){
			cell25.innerHTML = '<img src=<?= base_url() ?>assets/style/images/box.gif" width="8" heigth="8" /> &nbsp;'+ arr[1] ; 	
		}else{
			cell25.innerHTML = '<img src=<?= base_url() ?>assets/style/images/box_putih.gif" width="8" heigth="8" /> &nbsp;'+ arr[1]; 
		}
		cell26.innerHTML = data[i].DFCT ; 
		cell27.innerHTML = i +1;   
		cell0.className = 'borderTable'; 
		cell1.className = 'borderTable';  
		cell2.className = 'borderTable';  
		cell3.className = 'borderTable';  
		cell4.className = 'borderTable';  
		cell5.className = 'borderTable';  
		cell6.className = 'borderTable';  
		cell7.className = 'borderTable';  
		cell8.className = 'borderTable';  
		cell9.className = 'borderTable';  
		cell10.className = 'borderTable';  
		cell11.className = 'borderTable';  
		cell12.className = 'borderTable';  
		cell13.className = 'borderTable';  
		cell14.className = 'borderTable';  
		cell15.className = 'borderTable';  
		cell16.className = 'borderTable';  
		cell17.className = 'borderTable';  
		cell18.className = 'borderTable';  
		cell19.className = 'borderTable';  
		cell20.className = 'borderTable';  
		cell21.className = 'borderTable';  
		cell22.className = 'borderTable';  
		cell23.className = 'borderTable';  
		cell24.className = 'borderTable';  
		cell25.className = 'borderTable';  
		cell26.className = 'borderTable';  
		cell27.className = 'borderTable'; 
	}
}


</script>
                      
<div class="wrapper" align="center">
	<div class="columns" align="center">
		<div id="current_report">
			<div class="column grid_8 first" width="100%">  
				<div align="right" style="font-weight: bold;"><?= date('F d, Y', strtotime($date_daily_report)) ?></div>   
				<div class="judul" style=" border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">
					<span>DAILY TENDENCY OF SHIPPING QUALITY AUDIT</span><br />
					<span style="text-decoration: none;"> <?= $MODEL ?> MODEL  <?php $daily_tendency1 ?><span>
				</div>
				<br/> 
				<table style="width:100%">
					<tr><td>
						<div id="middlecontent1" style="width:100%;">    
							<div style="width: 15%; float: left;">
								<div class="daily_1_left">  
									<div class="title" align="left"> I. DAILY TENDENCY</div> 
									<div id="dailytendency1" class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;"></div>
								</div>                      
							</div> 
							<div style="width: 54%; float: left; margin-left:1%">
								<div class="daily_1_left">  
									<div class="title" align="left">&nbsp;</div> 
									<div id="dailytendency2" class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;"></div>
								</div>                      
							</div> 
							<div style="width: 29%; float: left; margin-left:1%;">
								<div class="daily_1_left">  
									<div class="title"> II. DISTRIBUTED PROBLEM</div> 
									<table style="width:100%">
									<tr><td>Outflow</td></tr>
									<tr><td>
									<div id="distributedproblem1" class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;"></div>                 
									</td></tr>
									<tr><td>Occurence</td></tr>
									<tr><td>
									<div id="distributedproblem2" class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;"></div>                 
									</td></tr>
									</table>
								</div>
							</div>  
						</div>
					</td></tr>
					<tr><td>
						<div id="middlecontent2" style="width:100%; margin-top:10px;">  
							<div style="width: 35%; float: left;">
								<div class="daily_1_left">  
									<div class="title" align="left"> III. AUDIT RESULT ON <?= date('F Y', strtotime($date_daily_report)) ?></div> 
									<div class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">
										<table class="tablenya">
											<thead>
												<tr>
													<th class="header" rowspan="2">Category</th>
													<th class="header"  rowspan="2">Total Unit</th>
													<th class="header"  colspan="4">Global</th>
													<th class="header"  >Regional</th>
													<th class="header"  rowspan="2">Total Issue</th>
													<th class="header"  rowspan="2">Daily DPV</th> 
												</tr>
												<tr>
													<th class="header" ><img src="<?= base_url() ?>assets/style/images/box.gif" width="8" heigth="8" /> &nbsp; A</th>
													<th class="header" ><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="8" heigth="8" /> &nbsp; A</th>
													<th class="header" ><img src="<?= base_url() ?>assets/style/images/box.gif" width="8" heigth="8" /> &nbsp;B</th> 
													<th class="header" ><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="8" heigth="8" /> &nbsp;B-G</th>
													<th class="header" ><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="8" heigth="8" /> &nbsp;B</th>
												</tr>
											</thead>
											<tbody>
												<?php    
												$i =1;
												$satu=0;
												$dua=0;
												$tiga=0;
												$empat=0;
												$enam=0;
												$sum=0;
													foreach ($auditresult1 as $a):   
														$sum=$sum+$a->SATU+$a->DUA+$a->TIGA+$a->EMPAT+$a->ENAM;
														$satu=$satu+$a->SATU;
														$dua=$satu+$a->DUA;
														$tiga=$satu+$a->TIGA;
														$empat=$satu+$a->EMPAT;
														$enam=$satu+$a->ENAM;
														if($i==1)
														{
														?><tr>
															<td class="borderTable"><? echo $a->CATEGORY; ?></td>
															<td class="borderTable"><? echo $a->TOTAL; ?></td>
															<td class="borderTable"><? echo $a->SATU; ?></td>
															<td class="borderTable"><? echo $a->DUA; ?></td>
															<td class="borderTable"><? echo $a->TIGA; ?></td>
															<td class="borderTable"><? echo $a->EMPAT; ?></td>
															<td class="borderTable"><? echo $a->ENAM; ?></td>
															<td class="borderTable"><? echo $a->SATU+$a->DUA+$a->TIGA+$a->EMPAT+$a->ENAM; ?></td>
															<td class="borderTable" rowspan="<? echo count($auditresult1)+1;?>"><? echo ($sum/$a->TOTAL); ?></td>
														</tr> <?php
														}else{
														?><tr>
															<td class="borderTable"><? echo $a->CATEGORY; ?></td>
															<td class="borderTable"><? echo $a->TOTAL; ?></td>
															<td class="borderTable"><? echo $a->SATU; ?></td>
															<td class="borderTable"><? echo $a->DUA; ?></td>
															<td class="borderTable"><? echo $a->TIGA; ?></td>
															<td class="borderTable"><? echo $a->EMPAT; ?></td>
															<td class="borderTable"><? echo $a->ENAM; ?></td>
															<td class="borderTable"><? echo $a->SATU+$a->DUA+$a->TIGA+$a->EMPAT+$a->ENAM; ?></td>
														</tr> <?php
														}
														$i+=1;
													endforeach 
													?>
													<tr>
														<td class="header" colspan="2">Total issue</td>
														<td class="header"><? echo $satu; ?></td>
														<td class="header"><? echo $dua; ?></td>
														<td class="header"><? echo $tiga; ?></td>
														<td class="header"><? echo $empat; ?></td>
														<td class="header"><? echo $enam; ?></td> 
														<td class="header"><? echo $sum; ?></td>
													</tr> 
											</tbody> 
										</table>
									</div>
								</div>                      
							</div> 
							<div   style="width: 49%; float: left;">
								<div class="daily_1_left">  
									<div class="title" align="left"> IV. CUMULATIVE AUDIT RESULT ON <?= date('F Y', strtotime($date_daily_report)) ?></div> 
									<div   class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">
										<table class="tablenya">
											<thead>
												<tr>
													<th class="header" rowspan="2">Category</th>
													<th class="header"  rowspan="2">Total Unit</th>
													<th class="header"  colspan="4">Global</th>
													<th class="header"  >Regional</th>
													<th class="header"  rowspan="2">Total Issue</th> 
												</tr>
												<tr>
													<th class="header" ><img src="<?= base_url() ?>assets/style/images/box.gif" width="8" heigth="8" /> &nbsp; A</th>
													<th class="header" ><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="8" heigth="8" /> &nbsp; A</th>
													<th class="header" ><img src="<?= base_url() ?>assets/style/images/box.gif" width="8" heigth="8" /> &nbsp;B</th> 
													<th class="header" ><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="8" heigth="8" /> &nbsp;B-G</th>
													<th class="header" ><img src="<?= base_url() ?>assets/style/images/box_putih.gif" width="8" heigth="8" /> &nbsp;B</th>
												</tr>
											</thead>
											<tbody>
												<?php    
												$i =1;
												$satu2=0;
												$dua2=0;
												$tiga2=0;
												$empat2=0;
												$enam2=0;
												$sum2=0;
													foreach ($auditresult2 as $a):   
														$sum2=$sum2+$a->SATU+$a->DUA+$a->TIGA+$a->EMPAT+$a->ENAM;
														$satu2=$satu2+$a->SATU;
														$dua2=$satu2+$a->DUA;
														$tiga2=$satu2+$a->TIGA;
														$empat2=$satu2+$a->EMPAT;
														$enam2=$satu2+$a->ENAM;
														if($i==1)
														{
														?><tr>
															<td class="borderTable"><? echo $a->CATEGORY; ?></td>
															<td class="borderTable"><? echo $a->TOTAL; ?></td>
															<td class="borderTable"><? echo $a->SATU; ?></td>
															<td class="borderTable"><? echo $a->DUA; ?></td>
															<td class="borderTable"><? echo $a->TIGA; ?></td>
															<td class="borderTable"><? echo $a->EMPAT; ?></td>
															<td class="borderTable"><? echo $a->ENAM; ?></td>
															<td class="borderTable"><? echo $a->SATU+$a->DUA+$a->TIGA+$a->EMPAT+$a->ENAM; ?></td>
														</tr> <?php
														}else{
														?><tr>
															<td class="borderTable"><? echo $a->CATEGORY; ?></td>
															<td class="borderTable"><? echo $a->TOTAL; ?></td>
															<td class="borderTable"><? echo $a->SATU; ?></td>
															<td class="borderTable"><? echo $a->DUA; ?></td>
															<td class="borderTable"><? echo $a->TIGA; ?></td>
															<td class="borderTable"><? echo $a->EMPAT; ?></td>
															<td class="borderTable"><? echo $a->ENAM; ?></td>
															<td class="borderTable"><? echo $a->SATU+$a->DUA+$a->TIGA+$a->EMPAT+$a->ENAM; ?></td>
														</tr> <?php
														}
														$i+=1;
													endforeach 
													?>
													<tr>
														<td class="header" colspan="2">Total issue</td>
														<td class="header"><? echo $satu2; ?></td>
														<td class="header"><? echo $dua2; ?></td>
														<td class="header"><? echo $tiga2; ?></td>
														<td class="header"><? echo $empat2; ?></td>
														<td class="header"><? echo $enam2; ?></td> 
														<td class="header"><? echo $sum2; ?></td>
													</tr> 
											</tbody> 
										</table>
									</div>
								</div>                      
							</div> 
							<div  style="width: 15%; float: right;">
								<div class="daily_1_left">   
									<div class="title" align="left">&nbsp;</div> 
									<div class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">
										<table class="tablenya" style="height: 115">
											<thead>
												<tr>
													<th class="header" style="height:45px;">Cumulative DPV</th> 
												</tr> 
											</thead>
											<tbody> 												
												<?php    
													$i =1; 
													$cum=0;
													$cumtot=0;
													foreach ($auditresult2 as $a):   
														$cum=$cum+$a->SATU+$a->DUA+$a->TIGA+$a->EMPAT+$a->ENAM; 
														$cumtot=$a->TOTAL;
														$i+=1;
													endforeach 
												?>
												<tr><td style="height:92px;"><?php echo ($cum/$cumtot); ?></td></tr>
											</tbody> 
										</table>
									</div>
								</div>                      
							</div> 
						</div>
					</td></tr>
					<tr><td>
						<div id="middlecontent3" style="width:100%; margin-top:10px;">  
							<div style="width: 30%; float: left;">
								<div class="daily_1_left">  
									<div class="title" align="left"> V. PROBLEM SHEET SEND, REPLY & GENBA ACTIVITY</div> 
									<div id="problemsheet1" class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;"></div>
								</div>                      
							</div> 
							<div style="width: 20%; float: left;">
								<div class="daily_1_left">   
									<div class="title" align="left"> &nbsp;</div> 
									<div class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">
									 <table class="tablenya" style="height:250px">
											<thead>
												<tr>
													<th class="header" style="background:black; color:white" >Total P/ Sheet</th>
													<th class="header"  style="background:black; color:white" colspan="2"  >P/ Sheet delay</th> 
												</tr> 
											</thead>
											<tbody>
												
												
													<?php  
														$i=1; 
														foreach ($total as $t):  
															?><tr>
																<? if($i==1){?> 
																	<td style="width:33%" class="header">Send</td> 
																<?}else if($i==2){?>
																	<td style="width:33%" class="borderTable"><?echo $totalsend;?></td> <?
																} else  if($i==3){?>
																	<td style="width:33%" class="header">Reply</td> <?
																} else if($i==4){?>
																	<td style="width:33%" class="borderTable"><?echo $totalreplay;?></td> <?
																} else if($i==5){?>
																	<td style="width:33%" class="header">Not yet replay</td> <?
																} else if($i==6){?>
																	<td style="width:33%" class="borderTable"><?echo ($totalsend-$totalreplay);?></td> <?
																} else{?>
																	<td style="width:33%" class="header"></td> <?
																} ?>
																
																<td style="width:33%" class="header"><? echo $t->SHOP_NM; ?></td>
																<td style="width:33%" class="borderTable"><? echo $t->TOTAL; ?></td>
															</tr><?php 
															   
															$i=$i+1;
														endforeach ?>
											
												 
											</tbody> 
										</table>
									</div>
								</div>                      
							</div> 
							<div style="width: 50%; float: right;">
								<div class="title" align="left"> &nbsp;</div> 
								<div class="daily_1_left">   
									<div id="problemsheet3" class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;"></div>
								</div>                      
							</div> 
						</div>
					</td></tr>
					<tr><td>
						<div id="middlecontent4" style="width:100%; margin-top:10px;">  
							<div>
								<div class="daily_1_left">  
									<div class="title" align="left"> VI. PROBLEM FOLLOW UP ON <?= date('F Y', strtotime($date_daily_report)) ?></div> 
									<div id="ddd" class="judul" style="border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">
										<table class="tablenya" id="tablefollow">
											<thead>
												<tr>
													<th class="header" rowspan="3">No</th>
													<th class="header" rowspan="3">Problem</th>
													<th class="header" rowspan="3">Judge</th>
													<th class="header" rowspan="3">Actual</th>
													<th class="header" rowspan="3">Standard</th> 
													<th class="header" colspan="2" rowspan="2">KCY</th> 
													<th class="header" colspan="2" rowspan="2">Plant</th> 
													<th class="header" colspan="6" rowspan="2">Inspection</th> 
													<th class="header" rowspan="3">H.Repair</th>
													<th class="header" colspan="4">shift</th>
													<th class="header" rowspan="3">Responsible occure</th>
													<th class="header" colspan="5">Problem history</th>
													<th class="header" colspan="2" rowspan="2">Status</th>
												</tr>
												<tr>
													<th class="header" colspan="2" >Production</th>
													<th class="header" colspan="2">Inspection</th> 
													<th class="header" rowspan="2">Found date</th> 
													<th class="header" rowspan="2">Target Replay</th> 
													<th class="header" rowspan="2">Repeat problem</th>
													<th class="header" colspan="2"> Replay date</th>
												</tr>
												<tr>
													<th class="header" >Pio</th>
													<th class="header" >Non Pio</th> 
													<th class="header" >InLine</th>
													<th class="header" >OutLine</th>
													<th class="header" >QC</th>
													<th class="header" >W</th>
													<th class="header" >T</th>
													<th class="header" >A</th>
													<th class="header" >S</th>
													<th class="header" >N</th>
													<th class="header" >Red</th>
													<th class="header" >White</th> 
													<th class="header" >Red</th>
													<th class="header" >White</th>
													
													<th class="header" >Prod</th>
													<th class="header" >Insp</th>
													
													<th class="header" >Occure</th>
													<th class="header" >Outflow</th>
												</tr>
											</thead>
											<tbody> </tbody> 
										</table>
									</div>
								</div>                      
							</div>  
						</div>
					</td></tr>
				</table>
			</div>
		</div>
	</div>
</div> 
<div align="center" style="margin-bottom: 20px;"> 
    <button style="width: 200px; height: 40px; font-weight: bold; font-size: 15px;" class="button button-blue " id="result_search_print" type="button" onclick='daily_report_print()'>PRINT</button>
</div>
  
  