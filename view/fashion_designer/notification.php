<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Notifications</title>
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/view_list_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Fashion Designer </a> > Notifications
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
                            <span class="notification-message">New costume added to the system</span>
                            <span>2022-09-12</span>
                            <span>13:16:12</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">Raw material form sent</span>
                            <span>2022-09-11</span>
                            <span>13:16:12</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">Raw material list approval received</span>
                            <span>2022-08-12</span>
                            <span>13:16:12</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">New costume added to the system</span>
                            <span>2022-08-10</span>
                            <span>13:16:12</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">Design no 1120 is updated</span>
                            <span>2022-07-12</span>
                            <span>13:16:12</span>
                            <hr />
                        </div>
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
