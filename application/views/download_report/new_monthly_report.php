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

</style>

<script type="text/javascript">
$(document).ready(function(){ 
	getdatereport(); 
});

function getdatereport()
{
	$.ajax({
		type: "POST",
		url: "<?= base_url() ?>" + "monthly_report/getData_monthly_report", 
		dataType:'json',
		data:{
			model:"<?= $model ?> "
		},
		success : function(r)
		{   
			console.log(r);
		},
		error:function(r){
			console.log("Error read controller"); 
		}
	});
}


$(function(){
         var afunc = $('#rank_a_func').val();
		 var bfunc = $('#rank_b_func').val();
		 var unit_veh = $('#unit_veh').val();
         var hasil_plus = parseInt(afunc) + parseInt(bfunc);
		 var hasil_du_func = parseInt(hasil_plus) / parseInt(unit_veh);
         var result = hasil_du_func.toFixed(2);
         if(hasil_plus ==''){
          $("#hasil").html('0.00');       
         }
         else{
         $("#hasil").html(result);
         }
		// alert (hasil_du_func);
         });
        
function monthly_print(){
        $('#monthly_print').hide();
        
        // set portrait orientation
   jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
   
   // set scalling
   jsPrintSetup.setOption('scaling', 70);
   jsPrintSetup.setOption('shrinkToFit', false);
   
   // set top margins in millimeters
   jsPrintSetup.setOption('marginTop', 15);
   jsPrintSetup.setOption('marginBottom', 15);
   jsPrintSetup.setOption('marginLeft', 10);
   jsPrintSetup.setOption('marginRight', 10);
   // set page header
   jsPrintSetup.setOption('headerStrLeft', '&T');
   jsPrintSetup.setOption('headerStrCenter', '');
   jsPrintSetup.setOption('headerStrRight', '&PT');
   // set empty page footer
   jsPrintSetup.setOption('footerStrLeft', '');
   jsPrintSetup.setOption('footerStrCenter', '');
   jsPrintSetup.setOption('footerStrRight', '');
   // clears user preferences always silent print value
   // to enable using 'printSilent' option
   jsPrintSetup.clearSilentPrint();
   // Suppress print dialog (for this context only)
  // jsPrintSetup.setOption('printSilent', 1);
   // Do Print 
   // When print is submitted it is executed asynchronous and
   // script flow continues after print independently of completetion of print process! 
   jsPrintSetup.print();
     // window.print();
		setTimeout('window.close()',3000);
    //    alert ("Print Document Succesful");
}

$(function () {
    Highcharts.chart('trendresult1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart'
        },
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption'
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
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
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
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, { 
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
        }]
    });
});

$(function () {
    Highcharts.chart('trendresult2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart'
        },
        xAxis: {
            categories: ['Apples', 'Oranges']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption'
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
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
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
            name: 'John',
            data: [5, 3]
        }, { 
            name: 'Joe',
            data: [3, 4]
        }]
    });
});

$(function () {
    Highcharts.chart('defectcat1', {
        title: {
            text: ''
        },
		chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false, 
			margin: [0, 0, 0, 0],
			spacingTop: 0,
			spacingBottom: 0,
			spacingLeft: 0,
			spacingRight: 0 
        }, 
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            borderWidth: 0
        }, 
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums']
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
            name: 'Jane',
            data: [3, 2, 1, 3, 4]
        }, {
            type: 'column',
            name: 'John',
            data: [2, 3, 5, 7, 6]
        }]
    });
});
 
$(function () {
    Highcharts.chart('Analyze1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart'
        },
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption'
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
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
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
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, { 
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
        }]
    });
});
 
 $(function () {
    Highcharts.chart('Analyze2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart'
        },
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption'
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
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
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
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, { 
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
        }]
    });
});
 
 $(function () {
    Highcharts.chart('Analyze3', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart'
        },
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption'
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
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
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
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, { 
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
        }]
    });
});
 
 $(function () {
    Highcharts.chart('Analyze4', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart'
        },
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption'
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
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
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
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, { 
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
        }]
    });
});
 
</script>

              
<div class="wrapper" align="center">
	<div class="columns" align="center">
		<div id="current_report">
			<div class="column grid_8 first" width="100%">  
				<div align="right" style="font-weight: bold;"><?= date('F d, Y', strtotime($date_daily_report)) ?></div>   
				<div class="judul" style=" border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">
					<span>MONTHLY SQA REPORT PLANT #1</span><br />
					<span style="text-decoration: none;"> <?= $model ?> PERIODE<span>
				</div>
				<br/>  
				
				<div class="judul" style="width:49%;float:left; padding:5px;">
				
					<table style="width:100%">
						<tr>
							<td> 
							<div class="title" align="left"> 1. OUT LINE</div> 
							<table>
								<tr>
									<td>(1)</td>
									<td>Model sampling</td>
									<td>:</td>
									<td>INNOVA - 72 UNIT</td>
									<td rowspan="4" style="padding:5px">==></td> 
									<td rowspan="4" style="padding:5px">Total 174 Units</td> 
								</tr>
								<tr>
									<td></td>
									<td>[Target 2%or>100 Unit's/ Plant]</td>
									<td>:</td>
									<td>Fortuner : 102 Unit</td>
								</tr>
								<tr>
									<td>(2)</td>
									<td>Location</td>
									<td>:</td>
									<td>Karawang plant #1</td>
								</tr> 
							</table> 
							</td>
						<tr>
						<tr>
							<td>
								<div class="title" align="left"> 2. OVERAL RESULT</div> 
									<div style="width:97%; padding:5px;">    
										<div style="width:89%; float:left; border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc; ">    
											 <table class="tablenya">
												<thead>
													<tr>
														<th class="header" rowspan="2">Category</th>
														<th class="header" colspan="2">Vehicle size</th>
														<th class="header"  rowspan="2">Total</th>
														<th class="header"  colspan="4">Global</th>
														<th class="header"  >Regional</th>
														<th class="header"  rowspan="2">Total Issue</th> 
													</tr>
													<tr>
														<th class="header" >INNOVA</th>
														<th class="header" >FORTUNER</th>
														<th class="header" >A</th>
														<th class="header" >A</th>
														<th class="header" >B</th>
														<th class="header" >B-G</th>
														<th class="header" >B</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>PAINTING</td>
														<td>72</td>
														<td>102</td>
														<td>174</td>
														<td></td>
														<td>0</td>
														<td></td> 
														<td>1</td> 
														<td>9</td> 
														<td>10</td> 
													</tr>
													<tr>
														<td>ASSEMBLY</td>
														<td>72</td>
														<td>102</td>
														<td>174</td>
														<td></td>
														<td>0</td>
														<td></td> 
														<td>1</td> 
														<td>38</td> 
														<td>50</td> 
													</tr>
													<tr>
														<td>DRIVING</td>
														<td>72</td>
														<td>102</td>
														<td>174</td>
														<td></td>
														<td>0</td>
														<td></td> 
														<td>1</td> 
														<td>38</td> 
														<td>50</td> 
													</tr>
												</tbody> 
											</table> 
										</div>  
										<div  style="width:10%; float:right; border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">    
											  <table class="tablenya">
												<thead>
													<tr>
														<th height="50px" class="header">Total</th> 
													</tr>  
												</thead>
												<tbody>
													<tr> 
														<td height="45px">72</td>  
													</tr> 
													<tr>  
														<td>DPV</td> 
													</tr> 
												</tbody> 
											</table> 

										</div>
									</div>  
							</td> 
						</tr>
						
						<tr>
							<td> 
								<div class="title" align="left"> 3. TREND RESULT</div> 
								<div style="width:97%; padding:5px;">    
									<div style="width:69%; float:left; border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc; ">    
										 <div id="trendresult1" ></div> 
									</div>  
									<div  style="width:29%; float:right; border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">    
										 <div id="trendresult2" ></div> 
									</div>
								</div> 
								
								<br/><span>DEFECT CATEGORY<span>
								<div style="width:97%; padding:5px;">    
									<div style="width:70%; float:left; border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc; ">    
										 <div id="defectcat1" ></div> 
									</div>  
									<div  style="width:29%; float:right; border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">    
										 <div id="defectcat2" >
											<?php
												$x = 1; 
												while($x <= 5) {
													echo "A$x : test loop for content<br>";
													$x++;
												} 
											?>
										 </div> 
									</div> 
								</div>
							</td>
						</tr>
					</table>
				</div>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				<div class="judul" style="width:49%; float:right; padding:5px;">
					<table style="width:100%"> 
						<tr>
							<td> 
								<div class="title" align="left"> 4. ANALYZE BY OUT FLOW</div> 
								<div style="width:97%; padding:5px;">
									<div style="width:49%; float:left; border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc; ">    
										 <div id="Analyze1" ></div> 
									</div>  
									<div  style="width:49%; float:right; border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">    
										 <div id="Analyze2" ></div> 
									</div>  
								</div>
							</td>
						</tr>
						<tr>
							<td> 
								<div class="title" align="left"> 5. ANALYZE BY OCCURENCE</div> 
								<div style="width:97%; padding:5px;">
									<div style="width:49%; float:left; border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc; ">    
										 <div id="Analyze3" >asdasdsads</div> 
									</div>  
									<div  style="width:49%; float:right; border:1px solid #888;-webkit-box-shadow:0 1px 5px #cccccc;-moz-box-shadow: 0 1px 5px #cccccc;box-shadow: 0 1px 5px #cccccc;">    
										 <div id="Analyze4" >dasdasd</div> 
									</div>  
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div> 


 
  
<div align="center" style="margin-bottom: 20px;"> 
<button style="width: 200px; height: 40px; font-weight: bold; font-size: 15px;" class="button button-blue " id="monthly_print" type="button" onclick='monthly_print()'>PRINT</button>
</div>