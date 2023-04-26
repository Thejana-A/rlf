<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />

    <?php
        require_once('../../model/DBConnection.php');
        $connObj = new DBConnection();
        $conn = $connObj->getConnection();

        $today = date("Y-m-d");
        $home_quotation_request_sql = "SELECT quotation_id, request_date, employee_id, employee.first_name AS first_name, employee.last_name AS last_name, employee.contact_no AS contact_no FROM raw_material_quotation JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id JOIN employee ON raw_material_quotation.merchandiser_id = employee.employee_id AND request_date = '$today';";
        $home_quotation_request_output = "";
        if($home_quotation_request_result = mysqli_query($conn, $home_quotation_request_sql)){
            if(mysqli_num_rows($home_quotation_request_result) > 0){
                while($home_quotation_request_row = mysqli_fetch_array($home_quotation_request_result)){
                    $home_quotation_request_output.= "<div class='item-data-row'>";
                    $home_quotation_request_output.= "<form method='post' action='../RouteHandler.php'>";
                    $home_quotation_request_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/supplier_view' />";
                    $home_quotation_request_output.= "<input type='text' hidden='true' name='quotation_id' value='".$home_quotation_request_row["quotation_id"]."' />";
                    $home_quotation_request_output.= "<span class='manager-ID-column'>".$home_quotation_request_row["quotation_id"]."</span><span style='padding-left:24px;'>".$home_quotation_request_row["first_name"]." ".$home_quotation_request_row["last_name"]."</span><span>".$home_quotation_request_row["contact_no"]."</span><span>".$home_quotation_request_row["request_date"]."</span>";
                    $home_quotation_request_output.= "<input type='submit' style='float:right;margin-right:25px;margin-bottom:10px;' class='".$material_order_class."' value='View' />";
                    $home_quotation_request_output.= "<hr />";
                    $home_quotation_request_output.= "</form>";
                    $home_quotation_request_output.= "</div>";
                }
            }else {
                $home_quotation_request_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No due material quotations today";
            }
        }else{
            echo "ERROR: Could not able to execute $home_quotation_request_sql. " . mysqli_error($conn);
        }

        $home_material_order_sql = "SELECT order_id, employee_id, employee.first_name AS first_name, employee.last_name AS last_name, employee.contact_no AS contact_no , expected_delivery_date, dispatch_date, manager_approval, raw_material_quotation.quotation_id FROM raw_material_order, employee, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND expected_delivery_date = '$today';";
        $home_material_order_output = "";
        if($home_material_order_result = mysqli_query($conn, $home_material_order_sql)){
            if(mysqli_num_rows($home_material_order_result) > 0){
                while($home_material_order_row = mysqli_fetch_array($home_material_order_result)){
                    $material_order_class = ($home_material_order_row["manager_approval"]=="approve")?"green":(($home_material_order_row["manager_approval"]=="reject")?"red":"grey");
                    $home_material_order_output.= "<div class='item-data-row'>";
                    $home_material_order_output.= "<form method='post' action='../RouteHandler.php'>";
                    $home_material_order_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_order/supplier_view' />";
                    $home_material_order_output.= "<input type='text' hidden='true' name='order_id' value='".$home_material_order_row["order_id"]."' />";
                    $home_material_order_output.= "<input type='text' hidden='true' name='quotation_id' value='".$home_material_order_row["quotation_id"]."' />";
                    $home_material_order_output.= "<span class='manager-ID-column'>".$home_material_order_row["order_id"]."</span><span style='padding-left:24px;'>".$home_material_order_row["first_name"]." ".$home_material_order_row["last_name"]."</span><span>".$home_material_order_row["contact_no"]."</span><span>".$home_material_order_row["expected_delivery_date"]."</span>";
                    $home_material_order_output.= "<input type='submit' style='float:right;margin-right:25px;margin-bottom:10px;' class='".$material_order_class."' value='View' />";
                    $home_material_order_output.= "<hr />";
                    $home_material_order_output.= "</form>";
                    $home_material_order_output.= "</div>";
                }
            }else {
                $home_material_order_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No due material orders today";
            }
        }else{
            echo "ERROR: Could not able to execute $home_material_order_sql. " . mysqli_error($conn);
        }
    ?>



</head>


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
                            <?php include '../manager/calendar.php';?>
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
                        <div id="content-list">
                            <?php 
                                echo $home_quotation_request_output;
                            ?>
                        </div>
                        <!--<div class="item-data-row">
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
                        </div>-->
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
                        <div>
                            <?php 
                                echo $home_material_order_output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        <!--
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
                        </div>-->
                    </div>


                </div>

                <?php /*echo $_SESSION["username"];echo $_SESSION["employee_id"];echo $_SESSION["user_type"];*/ ?>
                   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
