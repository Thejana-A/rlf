<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reports</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Manager </a> > Reports
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Reports</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        <select class="text-field" id="" name="">
                            <option>Income report</option>
                            <option>Loss/profit report</option>
                        </select>
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                <input type="text" name="" id="" class="date-field" style="width:70%;" placeholder="Merchandiser" />
                            </div>
                            <div class="search-panel-row-right">
                                <input type="text" name="" id="" class="date-field" style="width:70%;" placeholder="Customer" />
                            </div>
                        </div>
                        <b>Dispatch date : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="" id="" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="" id="" class="date-field" />
                            </div>
                        </div>
                    </form>

                    <div class="report-list">
                        <div class="report-heading-row">
                            <b>Order ID</b>
                            <b>Customer</b>
                            <b>Merchandiser</b>
                            <b>Value (LKR)</b>
                            <b>Dispatch date</b>
                            <hr />
                        </div>
                        <div class="report-data-row">
                            <span>0003</span>
                            <span>John Doe</span>
                            <span>Kenny A</span>
                            <span>115000</span>
                            <span>2022-06-01</span>
                            <hr />
                        </div>
                        <div class="report-data-row">
                            <span>0004</span>
                            <span>John A</span>
                            <span>Harry Potter</span>
                            <span>250000</span>
                            <span>2022-08-01</span>
                            <hr />
                        </div>
                        <div class="report-data-row">
                            <span>0005</span>
                            <span>John C</span>
                            <span>Henry R</span>
                            <span>550000</span>
                            <span>2022-09-01</span>
                            <hr />
                        </div>
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
