<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Notifications</title>
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
                    <a href="#">Merchandiser </a> > Notifications
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
                            <span class="notification-message">A costume quotation is requested</span>
                            <span>2022-03-12</span>
                            <span>13:16:12</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">A raw material quotation is accepted</span>
                            <span>2022-03-12</span>
                            <span>13:16:12</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">Quality of an order is set </span>
                            <span>2022-03-12</span>
                            <span>13:16:12</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">A raw material quotation is accepted</span>
                            <span>2022-03-12</span>
                            <span>13:16:12</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">A raw material quotation is accepted</span>
                            <span>2022-03-12</span>
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
