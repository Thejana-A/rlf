<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View purchase requests</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />
        <?php 
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $minEDD = $_POST["min_EDD"];
                $maxEDD = $_POST["max_EDD"];
                if(($minEDD == "")&&($maxEDD == "")){
                $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND manager_approval = 'approve' AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%');";
                }else if(($minEDD == "")&&($maxEDD != "")){
                $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND manager_approval = 'approve' AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date <= '$maxEDD');";
                }else if(($minEDD != "")&&($maxEDD == "")){
                $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND manager_approval = 'approve' AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minEDD');";
                }else{
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND manager_approval = 'approve' AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minEDD' AND expected_delivery_date <= '$maxEDD');";
                
                }
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_order/supplier_view' />";
                            $search_output.= "<input type='text' hidden='true' name='order_id' value='".$search_row["order_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row["order_id"]."</span><span style='padding-left:24px;'>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span>".$search_row["expected_delivery_date"]."</span>";
                            //echo "<input type='submit' class='grey' value='View' />";
                            $output.= "<input type='submit' class='grey' name='view' value='View' />";
                            $search_output.= "<hr class='manager-long-hr' />";
                            $search_output.= "</form>";
                            $search_output.= "</div>";
                        }
                    }else {
                        $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
                    }
                }
            }else{
                $sql = "SELECT order_id, employee_id, employee.first_name AS first_name, employee.last_name AS last_name, employee.contact_no AS contact_no , expected_delivery_date, dispatch_date, manager_approval, raw_material_quotation.quotation_id FROM raw_material_order, employee, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND manager_approval = 'approve';";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_order/supplier_view' />";
                            $output.= "<input type='text' hidden='true' name='order_id' value='".$row["order_id"]."' />";
                            $output.= "<span class='manager-ID-column'>".$row["order_id"]."</span><span style='padding-left:24px;'>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["expected_delivery_date"]."</span>";
                            //echo "<input type='submit' class='grey' value='View' />";
                            $output.= "<input type='submit' class='grey' name='view' value='View' />";
                            $output.= "<hr class='manager-long-hr' />";
                            $output.= "</form>";
                            $output.= "</div>";
                        }
                    }else {
                        $output.= "0 results";
                    }
                }else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }
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
                    <a href="profile.php">Supplier </a> > Purchase requests
                </div>
                
                <div id="list-box" style="width:120%;">
                    <center>
                        <h2>View puchase requests</h2>
                    </center>

                    <form method="post" action="view_purchase_requests.php" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" name="search" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Expected delivery date : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_EDD" id="min_EDD" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_EDD" id="max_EDD" class="date-field" />
                            </div>
                        </div>
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Purchase request ID</b>
                            <b>Merchandiser name</b>
                            <b>Expected delivery date</b>
                            <hr />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        <?php 
                            /*require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND manager_approval = 'approve';";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='raw_material_order/supplier_view' />";
                                        echo "<input type='text' hidden='true' name='order_id' value='".$row["order_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["order_id"]."</span><span style='padding-left:24px;'>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["expected_delivery_date"]."</span>";
                                        //echo "<input type='submit' class='grey' value='View' />";
                                        echo "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                                        echo "<td><input type='submit' class='grey' value='View' /></td>";
                                        echo "</tr></table>"; 
                                        echo "<hr class='manager-long-hr' />";
                                        echo "</form>";
                                        echo "</div>";
                                    }
                                }else {
                                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No purchase requests";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn);*/
                        ?>
                        <!--<div class="item-data-row">
                            <span>0001</span>
                            <span>James R</span>
                            <span>2022-10-05</span>
                            <span></span>
                            <a href="accept_purchase_request.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0002</span>
                            <span>James S</span>
                            <span>2022-10-10</span>
                            <span></span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>James W</span>
                            <span>2022-10-15</span>
                            <span></span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>-->
                    
            
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
