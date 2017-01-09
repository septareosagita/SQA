<html>
<head>
<title>Running Text Preview</title>
<style type="text/css">

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

#content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		normal;
font-size:			14px;
color:				#990000;
margin:				0 0 4px 0;
}
</style>
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#rt_content').html(parent.$('#RUNTEXT').val());
        $('#rt_content').attr('style', 'color:#'+ parent.$('#FONT_CLR').val() + '; font-size: ' + parent.$('#FONT_SIZE').val() + 'px;  font-family: ' + parent.$('#FONT_NM').val() );
        $('#content').attr('style', 'background-color: #'+ parent.$('#BACKGROUND_CLR').val());
    });
</script>

</head>
<body>
	<div id="content">
            <marquee behavior="scroll" scrollamount="3" direction="left" width="100%">
                <p id="rt_content">

                </p>
            </marquee>
	</div>
</body>
</html>