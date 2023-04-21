<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection(); 
            
            $today = date("Y-m-d");
            $home_costume_order_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND expected_delivery_date = '$today';";
            $home_costume_order_output = "";
            if($home_costume_order_result = mysqli_query($conn, $home_costume_order_sql)){
                if(mysqli_num_rows($home_costume_order_result) > 0){
                    while($home_costume_order_row = mysqli_fetch_array($home_costume_order_result)){
                        $costume_order_class = ($home_costume_order_row["quality_status"]=="good")?"green":(($home_costume_order_row["quality_status"]=="bad")?"red":"grey");
                        if($home_costume_order_row["order_status"] == NULL){
                            $orderStatus = "Pending";
                        }else{
                            $orderStatus = $home_costume_order_row["order_status"];
                        }
                        $home_costume_order_output.= "<div class='item-data-row'>";
                        $home_costume_order_output.= "<form method='post' action='../RouteHandler.php'>";
                        $home_costume_order_output.= "<input type='text' hidden='true' name='framework_controller' value='costume_order/manager_view' />";
                        $home_costume_order_output.= "<input type='text' hidden='true' name='order_id' value='".$home_costume_order_row["order_id"]."' />";
                        $home_costume_order_output.= "<span class='manager-ID-column'>".$home_costume_order_row["first_name"]." ".$home_costume_order_row["last_name"]."</span><span style='padding-left:24px;'>".$orderStatus."</span><span>".$home_costume_order_row["order_placed_on"]."</span><span>".$home_costume_order_row["expected_delivery_date"]."</span>";
                        $home_costume_order_output.= "<input type='submit' style='float:right;margin-right:25px;margin-bottom:10px;' class='".$costume_order_class."' value='View' />";
                        $home_costume_order_output.= "<hr />";
                        $home_costume_order_output.= "</form>";
                        $home_costume_order_output.= "</div>";
                    }
                }else {
                    $home_costume_order_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No due costume orders today";
                }
            }else{
                echo "ERROR: Could not able to execute $home_costume_order_sql. " . mysqli_error($conn);
            } 


            $home_material_order_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, manager_approval, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND expected_delivery_date = '$today';";
            $home_material_order_output = "";
            if($home_material_order_result = mysqli_query($conn, $home_material_order_sql)){
                if(mysqli_num_rows($home_material_order_result) > 0){
                    while($home_material_order_row = mysqli_fetch_array($home_material_order_result)){
                        $material_order_class = ($home_material_order_row["manager_approval"]=="approve")?"green":(($home_material_order_row["manager_approval"]=="reject")?"red":"grey");
                        $home_material_order_output.= "<div class='item-data-row'>";
                        $home_material_order_output.= "<form method='post' action='../RouteHandler.php'>";
                        $home_material_order_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_order/manager_view' />";
                        $home_material_order_output.= "<input type='text' hidden='true' name='order_id' value='".$home_material_order_row["order_id"]."' />";
                        $home_material_order_output.= "<input type='text' hidden='true' name='quotation_id' value='".$home_material_order_row["quotation_id"]."' />";
                        $home_material_order_output.= "<span class='manager-ID-column'>".$home_material_order_row["order_id"]."</span><span style='padding-left:24px;'>".$home_material_order_row["first_name"]." ".$home_material_order_row["last_name"]."</span><span>".$home_material_order_row["expected_delivery_date"]."</span><span>".$home_material_order_row["dispatch_date"]."</span>";
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

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    Manager 
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
                <div id="list-box" style="width:90%;box-sizing: border-box;margin-top:20px;">
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
                        <div id="content-list">
                            <?php 
                                echo $home_costume_order_output;
                            ?>
                        </div>
                        <!--<div class="item-data-row">
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
                        </div> -->
                    </div>
                </div><br />

                <div id="list-box" style="width:90%;box-sizing: border-box;margin-top:10px;">
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
                        <div>
                            <?php 
                                echo $home_material_order_output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        <!--<div class="item-data-row">
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
                        </div> -->
                    </div>


                </div>

                <?php /*echo $_SESSION["username"];echo $_SESSION["employee_id"];echo $_SESSION["user_type"];*/ ?>
                   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
