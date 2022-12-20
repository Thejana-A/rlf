<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
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
                    <a href="#">Manager </a> > Home
                </div>
                <div class="form-row" style="width:115%;">
                    <div class="form-row-theme">
                        <div id="list-box-home" style="flex: 65%;box-sizing: border-box;">
                            <h2>Hi <?php echo $_SESSION["username"] ?>,</h2>
                            <h4>Welcome you to RLF Apparel Factory !</h4><br>
                            <h4>You have following upcoming tasks today.</h4>
                        </div>
                    </div>
                    <div class="form-row-data">
                        <div style="flex: 35%;box-sizing: border-box;">
                            <?php include 'calendar.php';?>
                        </div>
                    </div>
                </div>
                <div id="list-box-small" style="width:90%;box-sizing: border-box;margin-top:20px;">
                    <center>
                        <h2>Costume orders</h2>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Customer name</b>
                            <b>Order status</b>
                            <b>Order placed on</b>
                            <b>EDD</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>John Doe</span>
                            <span>Pending</span>
                            <span>2022-10-01</span>
                            <span>2022-12-01</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>John A</span>
                            <span>Confirmed</span>
                            <span>2022-06-01</span>
                            <span>2023-01-01</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                    </div>
                </div><br />

                <div id="list-box-small" style="width:90%;box-sizing: border-box;margin-top:10px;">
                    <center>
                        <h2>Raw material purchase requests</h2>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Order ID</b>
                            <b>Supplier name</b>
                            <b>EDD</b>
                            <b>Goods received on</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>John Doe</span>
                            <span>2022-01-01</span>
                            <span>&nbsp</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>John A</span>
                            <span>2022-02-01</span>
                            <span>2022-07-01</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                    </div>


                </div>

                <?php /*echo $_SESSION["username"];echo $_SESSION["employee_id"];echo $_SESSION["user_type"];*/ ?>
                   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
