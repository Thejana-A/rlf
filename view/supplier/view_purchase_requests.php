<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View puchase requests</title>
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
                    <a href="login.php">Login </a> >
                    <a href="home.php">Supplier </a> > Purchase requests
                </div>
                
                <div id="list-box" style="width:120%;">
                    <center>
                        <h2>View puchase requests</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Enter merchandiser name" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Purchase request ID</b>
                            <b>Merchandiser name</b>
                            <b>Expected delivery date</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0001</span>
                            <span>James R</span>
                            <span>2022-10-05</span>
                            <span></span>
                            <a href="accept_purchase_request.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0002</span>
                            <span>James S</span>
                            <span>2022-10-10</span>
                            <span></span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>James W</span>
                            <span>2022-10-15</span>
                            <span></span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                    
            
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
