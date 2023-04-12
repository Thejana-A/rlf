<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />
</head>
<body>

	<?php include 'header.php';?>

	<div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="profile.php">Supplier </a> > All raw materials                    
                </div>
			
                <div class="form-row" style="width:115%;">
                    <div class="form-row-theme">
                        <div id="list-box-home" style="color:#330099;flex: 65%;box-sizing: border-box;background-color:#ffcc99;border-radius:6px;padding:30px;margin:10px;clear:inherit; font-family:sans-serif;width:195%;margin-top:20px;margin-right:80px;height:245px;">
                            <h2>Hi <?php echo $_SESSION["first_name"]; ?>,</h2>
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
                        <h2>Quotation requests</h2>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
							<b>Quotation ID</b>
                            <b>Merchandiser name</b>
                            <b style="width:150px;">Contact number</b>
                            <b>Requested on</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
							<span>0001</span>
                            <span>James A</span>
                            <span style="width:150px;">94 123 456 789</span>
                            <span>2022-12-22</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
							<span>0002</span>
                            <span>James B</span>
                            <span style="width:150px;">94 123 654 789</span>
                            <span>2022-12-22</span>
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
                            <b>Merchandiser name</b>
                            <b style="width:150px;">Contact number</b>
                            <b>EDD</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>John A</span>
                            <span style="width:150px;">94 123 456 789</span>
                            <span>2022-12-22</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>John B</span>
                            <span style="width:150px;">94 896 456 789</span>
                            <span>2022-12-22</span>
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
