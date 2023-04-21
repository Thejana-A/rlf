<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>About Us</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />
        <style>
            p {
                display: block;
                margin-top: 2em;
                margin-bottom: 1em;
                margin-left: 5em;
                margin-right: 0;
                text-align: left;
    
            }

            h2{
                margin-top: 3em;
                margin-left: 3em;
                text-align: left;
                color:#330099;
            }
            .text-block {
                position: absolute;
                bottom: 150px;
                right: 20px;
                background-color: #cccccc;
                color: black;
                padding-left: 20px;
                padding-right: 20px;
                padding-bottom: 20px;
            }
        </style>
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> 
                     > About us
                </div>
                
                <div style ="background-image: url(images/about_us.jpg); height: 450px; width: 1000px;  background-repeat: no-repeat;">
                    <div class="text-block">
                        <center>
                            <h2>About Us</h2>
                            <p>RLF Apparel T-shirt manufacturing <br> company started in 2012. Mr.Anoona <br> Udattawa is a product development <br> technologist who works in RLF apparel <br> factory. He was graduate in University of <br>moratuwa. And he has a degree in <br> Bachelor of Design in Fashion Design & <br> Product Development, University of <br> Moratuwa .</p>
                        </center>
                    </div>
                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
