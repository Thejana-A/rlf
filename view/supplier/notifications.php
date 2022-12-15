<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Notifications</title>
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
                    <a href="home.php">Supplier </a> > Notifications
                </div>
                
                <div id="list-box-small">
                    <center>
                        <h2>Notifications</h2>
                    </center>

                    <form method="post" action="" class="search-panel">    
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Date : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="" id="" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="" id="" class="date-field" />
                            </div>
                        </div>
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b style="width:50%;">Message</b>
                            <b>Date</b>
                            <b>Time</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">A raw material quotation is requested</span>
                            <span>2022-04-17</span>
                            <span>17:16:14</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">A raw material purchase is requested</span>
                            <span>2022-05-12</span>
                            <span>20:19:45</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">A raw material quotation is requested </span>
                            <span>2022-06-22</span>
                            <span>20:19:45</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">A raw material purchase is requested</span>
                            <span>2022-08-29</span>
                            <span>20:19:45</span>
                            <hr />
                        </div>
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
