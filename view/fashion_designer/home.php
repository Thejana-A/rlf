<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
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
                    <a href="#">Fashion Designer </a> > Home
                </div>
                <div class="form-row" style="width:115%;">
                    <div class="form-row-theme">
                        <div id="list-box-home" style="flex: 65%;box-sizing: border-box;">
                            <h2>Hi Kaveesha,</h2>
                            <h4>Welcome you to RLF Apparel Factory !</h4><br>
                            <h4>You have following upcoming tasks today.</h4>
                        </div>
                    </div>
                    <div class="form-row-data">
                        <div style="flex: 35%;box-sizing: border-box;">
                            <?php include '../merchandiser/calendar.php';?>
                        </div>
                    </div>
                </div>
                <div id="list-box-small" style="width:90%;box-sizing: border-box;margin-top:20px;">
                    <center>
                        <h2>Request Approval</h2>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design ID</b>
                            <b>Design Name</b>
                            <b>Published Date</b>
                            <b>Status</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>1102</span>
                            <span>Black T-shirt S</span>
                            <span>2022-10-05</span>
                            <span>Approved</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>1105</span>
                            <span>White T-Shirt M</span>
                            <span>2022-09-01</span>
                            <span>Approved</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                    </div>
                </div><br />
            

                <?php /*echo $_SESSION["username"];echo $_SESSION["employee_id"];echo $_SESSION["user_type"];*/ ?>
                   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
