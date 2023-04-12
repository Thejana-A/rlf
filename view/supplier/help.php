<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Help</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />

    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="index.php">Welcome </a> >
                     Help
                </div>
                
                <div id="list-box" style="width:90%;">
                    <center>
                        <h2>Help</h2>
                    </center>    
                        <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" style="width:900px;"/>
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    
                    </form>
                    
                  
                    <h3> FAQ </h3>

                    <div class="row">
                        <div class="column" style="background-color:#aaa; width:1000px; align: center; display:inline-block;">
                            <h4><b>How long will it take for my order to arrive</b></h4>
                            <p style= text-align: justify; text-justify: inter-word;>All standard orders will be shipped four to five business days of confirmation from our team that they  have received  <br>your order. If your order includes an item that we indicated will be  shippedat a later date, we will only ship the entire <br>order out  together once the item arrives.</p>
                        </div>
                        <div class="column" style="background-color:#aaa;width:1000px; " >
                            <h4>Can I return or exchange an item I bought on sale?</h4>
                            <p align="justify">Unfortunately, all items purchased during a sale or marked at a discounted rate cannot be exchanged or refunded. If <br> you send them back to us for a return we will not be able to process a refund. If you have any questions about sizing,<br> fit, or fabric, please reach out to our customer service before placing your order. </p>
                        </div>
                    </div>
                 
                    <div class="row">
                        <div class="column" style="background-color:#bbb;width:1000px; ">
                            <h4>How do I place a return or exchange? </h4>
                            <p>It’s our goal to ensure you have the best possible experience with us, and so we offer returns valid for 30 days from the <br> date of arrival. As such, you will be responsible for paying for your own shipping costs for returning your item. </p>
                        </div>
                        <div class="column" style="background-color:#bbb;width:1000px; align: center; display:inline-block;">   
                            <h4>I think I got the sizing wrong on my order, can I exchange it for a different size? </h4>
                            <p>We’re happy to send you the right size and do an exchange! Otherwise, we only replace items if they have arrived defective <br> or damaged. If you need to exchange it for the same  item in a different size, send us an email at rlfapparel@yahoo.com before <br> sending your item. </p>
                        </div>
                    </div>
                </div>
            </div>

                         
            </div> 
        <?php include 'footer.php';?>

    </body> 
</html>
