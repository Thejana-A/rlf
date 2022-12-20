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
                    <a href="index.php">Welcome </a> >
                    <a href="login.php">Login </a> >
                    <a href="home.php">Supplier </a> > All raw materials                    
                </div>
			
				<div class="form-row" style="width:115%;">
                    <div class="form-row-theme">
                        <div id="list-box-home" style="flex:65%;box-sizing: border-box;">
                            <h2>Hi <?php echo $_SESSION["username"]; ?></h2>
                            <h4>Welcome you to RLF Apparel Factory !</h4><br>
                            <h4>You have following upcoming tasks today.</h4>
                        </div>
                    </div>
                    <div class="form-row-data">
                        <div style="flex: 35%;box-sizing: border-box;">
                            <?php include 'calender.php';?>
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
							<span>&nbsp &nbsp &nbsp</span>
                            <b>Requested on</b>
                            <b>Valid till</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
							<span>0001</span>
                            <span>James A</span>
                            <span>2022-10-01</span>
                            <span>2022-12-01</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
							<span>0002</span>
                            <span>James B</span>
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
                            <b>Merchandiser name</b>
                            <b>EDD</b>
                            <b>Valid till</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>John A</span>
                            <span>2022-01-01</span>
                            <span>2022-07-08</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>John B</span>
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
