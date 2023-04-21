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
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Fashion Designer </a> > Home
                </div>
                <div class="form-row" style="width:115%;">
                    <div class="form-row-theme">
                        <div id="list-box-home" style="color:#330099; flex: 65%;box-sizing: border-box;background-color:#ffcc99;border-radius:6px;padding:30px;margin:10px;clear:inherit; font-family:sans-serif;width:195%;margin-top:20px;margin-right:80px;height:245px;">
                            <h2>Hi <?php echo $_SESSION["username"]; ?>,</h2>
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
                        <h2>Customized designs</h2>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design ID</b>
                            <b>Design Name</b>
                            <b>Customer</b>
                            <b style="width:150px;">Contact no</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>1102</span>
                            <span>Black T-shirt S</span>
                            <span>Kamal</span>
                            <span style="width:150px;">94 125 455 485</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>1105</span>
                            <span>White T-Shirt M</span>
                            <span>Kumara</span>
                            <span style="width:150px;">94 122 525 855</span>
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
