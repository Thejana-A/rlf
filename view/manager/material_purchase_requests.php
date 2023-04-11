<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Material purchase requests</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php 
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $minEDD = $_POST["min_EDD"];
                $maxEDD = $_POST["max_EDD"];
                $minDispatchDate = $_POST["min_dispatch_date"];
                $maxDispatchDate = $_POST["max_dispatch_date"];
                if(($minEDD == "")&&($maxEDD == "")&&($minDispatchDate == "")&&($maxDispatchDate == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%');";
                }else if(($minEDD == "")&&($maxEDD == "")&&($minDispatchDate == "")&&($maxDispatchDate != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (dispatch_date <= '$maxDispatchDate');";
                }else if(($minEDD == "")&&($maxEDD == "")&&($minDispatchDate != "")&&($maxDispatchDate == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (dispatch_date >= '$minDispatchDate');";
                }else if(($minEDD == "")&&($maxEDD != "")&&($minDispatchDate == "")&&($maxDispatchDate == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date <= '$maxEDD');";
                }else if(($minEDD != "")&&($maxEDD == "")&&($minDispatchDate == "")&&($maxDispatchDate == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minEDD');";
                }else if(($minEDD != "")&&($maxEDD != "")&&($minDispatchDate == "")&&($maxDispatchDate == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minEDD' AND expected_delivery_date <= '$maxEDD');";
                }else if(($minEDD == "")&&($maxEDD != "")&&($minDispatchDate != "")&&($maxDispatchDate == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (dispatch_date >= '$minDispatchDate' AND expected_delivery_date <= '$maxEDD');";
                }else if(($minEDD == "")&&($maxEDD == "")&&($minDispatchDate != "")&&($maxDispatchDate != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (dispatch_date >= '$minDispatchDate' AND dispatch_date <= '$maxDispatchDate');";
                }else if(($minEDD != "")&&($maxEDD == "")&&($minDispatchDate == "")&&($maxDispatchDate != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minEDD' AND dispatch_date <= '$maxDispatchDate');";
                }else if(($minEDD != "")&&($maxEDD == "")&&($minDispatchDate != "")&&($maxDispatchDate == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minEDD' AND dispatch_date >= '$minDispatchDate');";
                }else if(($minEDD == "")&&($maxEDD != "")&&($minDispatchDate == "")&&($maxDispatchDate != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date <= '$maxEDD' AND dispatch_date <= '$maxDispatchDate');";
                }else if(($minEDD != "")&&($maxEDD != "")&&($minDispatchDate != "")&&($maxDispatchDate == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minEDD' AND expected_delivery_date <= '$maxEDD' AND dispatch_date >= '$minDispatchDate');";
                }else if(($minEDD == "")&&($maxEDD != "")&&($minDispatchDate != "")&&($maxDispatchDate != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (dispatch_date >= '$minDispatchDate' AND dispatch_date <= '$maxDispatchDate' AND expected_delivery_date <= '$maxEDD');";
                }else if(($minEDD != "")&&($maxEDD == "")&&($minDispatchDate != "")&&($maxDispatchDate != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (dispatch_date >= '$minDispatchDate' AND dispatch_date <= '$maxDispatchDate' AND expected_delivery_date >= '$minEDD');";
                }else if(($minEDD != "")&&($maxEDD != "")&&($minDispatchDate == "")&&($maxDispatchDate != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minEDD' AND expected_delivery_date <= '$maxEDD' AND dispatch_date <= '$maxDispatchDate');";
                }else{
                    $search_sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND (order_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minEDD' AND expected_delivery_date <= '$maxEDD' AND dispatch_date >= '$minDispatchDate' AND dispatch_date <= '$maxDispatchDate');";
                }

                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_order/manager_view' />";
                            $search_output.= "<input type='text' hidden='true' name='order_id' value='".$search_row["order_id"]."' />";
                            $search_output.= "<input type='text' hidden='true' name='quotation_id' value='".$search_row["quotation_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row["order_id"]."</span><span style='padding-left:24px;'>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span>".$search_row["expected_delivery_date"]."</span><span>".$search_row["dispatch_date"]."</span>";
                            $search_output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            $search_output.= "<td><input type='submit' class='grey' value='View' /></td>";
                            $search_output.= "</tr></table>"; 
                            $search_output.= "<hr class='manager-long-hr' />";
                            $search_output.= "</form>";
                            $search_output.= "</div>";
                        }   
                    }else{
                        $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
                    }
                }
            }else{
                $sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id;";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_order/manager_view' />";
                            $output.= "<input type='text' hidden='true' name='order_id' value='".$row["order_id"]."' />";
                            $output.= "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                            $output.= "<span class='manager-ID-column'>".$row["order_id"]."</span><span style='padding-left:24px;'>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["expected_delivery_date"]."</span><span>".$row["dispatch_date"]."</span>";
                            $output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            $output.= "<td><input type='submit' class='grey' value='View' /></td>";
                            $output.= "</tr></table>"; 
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
                    Manager > Raw material purchase requests
                </div>
                
                <div id="list-box-small">
                    <center>
                        <h2>Raw material purchase requests</h2>
                    </center>

                    <form method="post" action="material_purchase_requests.php" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Expected delivery date : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_EDD" id="min_EDD" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_EDD" id="max_EDD" class="date-field" />
                            </div>
                        </div>
                        <b>Goods received on : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_dispatch_date" id="min_dispatch_date" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_dispatch_date" id="max_dispatch_date" class="date-field" />
                            </div>
                        </div>   
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Order ID</b>
                            <b>Supplier name</b>
                            <b>EDD</b>
                            <b>Goods received on</b>
                            <hr class="manager-long-hr" />
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
                            $sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id;";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='raw_material_order/manager_view' />";
                                        echo "<input type='text' hidden='true' name='order_id' value='".$row["order_id"]."' />";
                                        echo "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["order_id"]."</span><span style='padding-left:24px;'>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["expected_delivery_date"]."</span><span>".$row["dispatch_date"]."</span>";
                                        //echo "<input type='submit' class='grey' value='View' />";
                                        echo "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                                        echo "<td><input type='submit' class='grey' value='View' /></td>";
                                        echo "</tr></table>"; 
                                        echo "<hr class='manager-long-hr' />";
                                        echo "</form>";
                                        echo "</div>";
                                    }
                                }else {
                                    echo "0 results";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn); */
                        ?>
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
                            <span>&nbsp</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div> -->
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
