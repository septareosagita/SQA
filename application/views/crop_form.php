   <head>
        <title></title>
        <script src="<?php echo base_url(); ?>public/javascript/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>public/javascript/jquery.imgareaselect.min.js" type="text/javascript"></script>

        <?php if ($large_photo_exists && $thumb_photo_exists == NULL): ?>
            <script src="<?php echo base_url(); ?>public/javascript/jquery.imgpreview.js" type="text/javascript"></script>
            <script type="text/javascript">
                // <![CDATA[
                var thumb_width    = <?php echo $thumb_width; ?> ;
                var thumb_height   = <?php echo $thumb_height; ?> ;
                var image_width    = <?php echo $img['image_width']; ?> ;
                var image_height   = <?php echo $img['image_height']; ?> ;

                var auto_x1 = <?php echo $img['x1']; ?> ;
                var auto_x2 = <?php echo $img['x2']; ?> ;
                var auto_y1 = <?php echo $img['y1']; ?> ;
                var auto_y2 = <?php echo $img['y2']; ?> ;
                // ]]>
            </script>
        <?php endif; ?>

            <style type="text/css">
                #form{
                    font-family:Calibri;
                    width:400px;
                    height:auto;
                    background-color:#EEEEEE;
                    border:3px solid #DCDCDC;
                    padding:30px;
                    float: left;
                    margin-left: 20px;
                    margin-top: 20px;
                    margin-bottom: 20px;
                    border-radius:20px;
                    -moz-border-radius:10px;
                }
                #form1{
                    font-family:Calibri;
                    width:450px;
                    height:auto;
                    background-color:#EEEEEE;
                    border:3px solid #DCDCDC;
                    padding:15px;
                    float: left;
                    margin: auto;
                    margin-left: 10px;
                    margin-top: 20px;
                    margin-bottom: 20px;
                    border-radius:20px;
                    -moz-border-radius:10px;
                }


            </style>

        </head>
        <body>

             <h2>DEFECT</h2><hr/>

        <?php if ($error) : ?>
                <ul><li><strong>Error!</strong></li><li><?php echo $error; ?></li></ul>
        <?php endif; ?>

        <?php if ($large_photo_exists && $thumb_photo_exists == NULL) : ?>

                        <div id="form1">

                                <img src="<?php echo base_url() . $destination_medium . $img['file_name']; ?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
                                <br style="clear:both;"/>
                                <form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                    <input type="hidden" name="x1" value="" id="x1" />
                                    <input type="hidden" name="y1" value="" id="y1" />
                                    <input type="hidden" name="x2" value="" id="x2" />
                                    <input type="hidden" name="y2" value="" id="y2" />
                                    <input type="hidden" name="file_name" value="<?php echo $img['file_name']; ?>" /><br /><hr />
                                    <input type="submit" name="upload_thumbnail" value="Save Defect" id="save_thumb" class="button button-gray"/>
                                </form>

                        </div>


                
                <div id="form1">

                                <img src="<?php echo base_url() . $destination_medium . $img['file_name']; ?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
                                <br style="clear:both;"/>
                                <form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                    <input type="hidden" name="x1" value="" id="x1" />
                                    <input type="hidden" name="y1" value="" id="y1" />
                                    <input type="hidden" name="x2" value="" id="x2" />
                                    <input type="hidden" name="y2" value="" id="y2" />
                                    <input type="hidden" name="file_name" value="<?php echo $img['file_name']; ?>" /><br /><hr />
                                    <input type="submit" name="upload_thumbnail" value="Save Defect" id="save_thumb" class="button button-gray"/>
                                </form>

                        </div>
<?php else : ?>

                
                    <div id="form">
                        <h2 align="center">Upload Main Image</h2>
                        <div align="center"><form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                <input type="file" name="image" size="30" /><br><hr/>
                                <input  type="submit" name="upload" value="Upload" />
                            </form></div>

                 </div>

                 <div id="form">
                        <h2 align="center">Upload Part Image</h2>
                        <div align="center"><form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                <input type="file" name="image2" size="30" /><br><hr/>
                                <input  type="submit" name="upload" value="Upload" />
                            </form></div>
            <?php endif ?>
                 </div>


    </body>
