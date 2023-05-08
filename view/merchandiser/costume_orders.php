<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Costume orders</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php 
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $merchandiserID = $_SESSION["employee_id"];
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $minOrderPlacedOn = $_POST["min_order_placed_on"];
                $maxOrderPlacedOn = $_POST["max_order_placed_on"];
                $minExpectedDeliveryDate = $_POST["min_expected_delivery_date"];
                $maxExpectedDeliveryDate = $_POST["max_expected_delivery_date"];
                if(($minExpectedDeliveryDate == "")&&($maxExpectedDeliveryDate == "")&&($minOrderPlacedOn == "")&&($maxOrderPlacedOn == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%');";
                }else if(($minExpectedDeliveryDate == "")&&($maxExpectedDeliveryDate == "")&&($minOrderPlacedOn == "")&&($maxOrderPlacedOn != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (order_placed_on <= '$maxOrderPlacedOn');";
                }else if(($minExpectedDeliveryDate == "")&&($maxExpectedDeliveryDate == "")&&($minOrderPlacedOn != "")&&($maxOrderPlacedOn == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (order_placed_on >= '$minOrderPlacedOn');";
                }else if(($minExpectedDeliveryDate == "")&&($maxExpectedDeliveryDate != "")&&($minOrderPlacedOn == "")&&($maxOrderPlacedOn == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date <= '$maxExpectedDeliveryDate');";
                }else if(($minExpectedDeliveryDate != "")&&($maxExpectedDeliveryDate == "")&&($minOrderPlacedOn == "")&&($maxOrderPlacedOn == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minExpectedDeliveryDate');";
                }else if(($minExpectedDeliveryDate != "")&&($maxExpectedDeliveryDate != "")&&($minOrderPlacedOn == "")&&($maxOrderPlacedOn == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minExpectedDeliveryDate' AND expected_delivery_date <= '$maxExpectedDeliveryDate');";
                }else if(($minExpectedDeliveryDate == "")&&($maxExpectedDeliveryDate != "")&&($minOrderPlacedOn != "")&&($maxOrderPlacedOn == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (order_placed_on >= '$minOrderPlacedOn' AND expected_delivery_date <= '$maxExpectedDeliveryDate');";
                }else if(($minExpectedDeliveryDate == "")&&($maxExpectedDeliveryDate == "")&&($minOrderPlacedOn != "")&&($maxOrderPlacedOn != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (order_placed_on >= '$minOrderPlacedOn' AND order_placed_on <= '$maxOrderPlacedOn');";
                }else if(($minExpectedDeliveryDate != "")&&($maxExpectedDeliveryDate == "")&&($minOrderPlacedOn == "")&&($maxOrderPlacedOn != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minExpectedDeliveryDate' AND order_placed_on <= '$maxOrderPlacedOn');";
                }else if(($minExpectedDeliveryDate != "")&&($maxExpectedDeliveryDate == "")&&($minOrderPlacedOn != "")&&($maxOrderPlacedOn == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minExpectedDeliveryDate' AND order_placed_on >= '$minOrderPlacedOn');";
                }else if(($minExpectedDeliveryDate == "")&&($maxExpectedDeliveryDate != "")&&($minOrderPlacedOn == "")&&($maxOrderPlacedOn != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date <= '$maxExpectedDeliveryDate' AND order_placed_on <= '$maxOrderPlacedOn');";
                }else if(($minExpectedDeliveryDate != "")&&($maxExpectedDeliveryDate != "")&&($minOrderPlacedOn != "")&&($maxOrderPlacedOn == "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minExpectedDeliveryDate' AND expected_delivery_date <= '$maxExpectedDeliveryDate' AND order_placed_on >= '$minOrderPlacedOn');";
                }else if(($minExpectedDeliveryDate == "")&&($maxExpectedDeliveryDate != "")&&($minOrderPlacedOn != "")&&($maxOrderPlacedOn != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (order_placed_on >= '$minOrderPlacedOn' AND order_placed_on <= '$maxOrderPlacedOn' AND expected_delivery_date <= '$maxExpectedDeliveryDate');";
                }else if(($minExpectedDeliveryDate != "")&&($maxExpectedDeliveryDate == "")&&($minOrderPlacedOn != "")&&($maxOrderPlacedOn != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (order_placed_on >= '$minOrderPlacedOn' AND order_placed_on <= '$maxOrderPlacedOn' AND expected_delivery_date >= '$minExpectedDeliveryDate');";
                }else if(($minExpectedDeliveryDate != "")&&($maxExpectedDeliveryDate != "")&&($minOrderPlacedOn == "")&&($maxOrderPlacedOn != "")){
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minExpectedDeliveryDate' AND expected_delivery_date <= '$maxExpectedDeliveryDate' AND order_placed_on <= '$maxOrderPlacedOn');";
                }else{
                    $search_sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID' AND (order_id LIKE '%$searchbar%' OR order_status LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (expected_delivery_date >= '$minExpectedDeliveryDate' AND expected_delivery_date <= '$maxExpectedDeliveryDate' AND order_placed_on >= '$minOrderPlacedOn' AND order_placed_on <= '$maxOrderPlacedOn');";
                }

                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $class = ($search_row["quality_status"]=="good")?"green":(($search_row["quality_status"]=="bad")?"red":"grey");
                            if($search_row["order_status"] == NULL){
                                $orderStatus = "Pending";
                            }else{
                                $orderStatus = $search_row["order_status"];
                            }
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='costume_order/merchandiser_view' />";
                            $search_output.= "<input type='text' hidden='true' name='order_id' value='".$search_row["order_id"]."' />";
                            $search_output.= "<span style='width:6%;'>".$search_row["order_id"]."</span><span class='manager-ID-column'>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span style='padding-left:24px;width:15%;'>".$orderStatus."</span><span>".$search_row["order_placed_on"]."</span><span style='width:12%;'>".$search_row["expected_delivery_date"]."</span>";
                            //$search_output.= "<input type='submit' class='grey' value='View' />";
                            $search_output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            $search_output.= "<td><input type='submit' class='".$class."' value='View' /></td>";
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
                $sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID';";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $class = ($row["quality_status"]=="good")?"green":(($row["quality_status"]=="bad")?"red":"grey");
                            if($row["order_status"] == NULL){
                                $orderStatus = "Pending";
                            }else{
                                $orderStatus = $row["order_status"];
                            }
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='costume_order/merchandiser_view' />";
                            $output.= "<input type='text' hidden='true' name='order_id' value='".$row["order_id"]."' />";
                            $output.= "<span style='width:6%;'>".$row["order_id"]."</span><span class='manager-ID-column'>".$row["first_name"]." ".$row["last_name"]."</span><span style='padding-left:24px;width:15%;'>".$orderStatus."</span><span>".$row["order_placed_on"]."</span><span style='width:12%;'>".$row["expected_delivery_date"]."</span>";
                            //$output.= "<input type='submit' class='grey' value='View' />";
                            $output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            $output.= "<td><input type='submit' class='".$class."' value='View' /></td>";
                            $output.= "</tr></table>"; 
                            $output.= "<hr class='manager-long-hr' />";
                            $output.= "</form>";
                            $output.= "</div>";
                        }
                    }else {
                        $output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
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
                    <a href="home.php">Merchandiser</a> > Costume orders
                </div>
                
                <!--<div class="link-row">
                    <a href="./add_costume_order_onsite.php" class="right-button">Add new costume order</a>
                </div> -->
                <div id="list-box">
                    <center>
                        <h2>Costume orders</h2>
                    </center>
                    
                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Order placed on : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_order_placed_on" id="min_order_placed_on" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_order_placed_on" id="max_order_placed_on" class="date-field" />
                            </div>
                        </div>
                        <b>Expected delivery date : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_expected_delivery_date" id="min_expected_delivery_date" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_expected_delivery_date" id="max_expected_delivery_date" class="date-field" />
                            </div>
                        </div>   
                    </form>
                
                    <div class="item-list">
                        <div class="item-heading-row">
                            <!--<b>Customer name</b>
                            <b>Order status</b>
                            <b>Order placed on</b>
                            <b>EDD</b>
                            <hr class="manager-long-hr" /> -->
                            <b style="width:6%;">Order ID</b>
                            <b>Customer name</b>
                            <b style="width:15%;">Order status</b>
                            <b>Order placed on</b>
                            <b>EDD</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        <?php /*
                            $merchandiserID = $_SESSION["employee_id"];
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = '$merchandiserID';";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        if($row["order_status"] == "accepted"){
                                            $orderStatus = "accepted";
                                        }else if($row["order_status"] == "rejected"){
                                            $orderStatus = "rejected";
                                        }else if($row["order_status"] == "complete"){
                                            $orderStatus = "complete";
                                        }else if($row["order_status"] == "incomplete"){
                                            $orderStatus = "incomplete";
                                        }else if(($row["order_status"] == "complete")&&($row["dispatch_date"] != "")){
                                            $orderStatus = "delivered";
                                        }else if($row["order_status"] == "confirmed"){
                                            $orderStatus = "confirmed";
                                        }
                                        $class = ($row["quality_status"]=="good")?"green":(($row["quality_status"]=="bad")?"red":"grey");
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_order/merchandiser_view' />";
                                        echo "<input type='text' hidden='true' name='order_id' value='".$row["order_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["first_name"]." ".$row["last_name"]."</span><span style='padding-left:24px;'>".$orderStatus."</span><span>".$row["order_placed_on"]."</span><span>".$row["expected_delivery_date"]."</span>";
                                        echo "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                                        echo "<td><input type='submit' class='".$class."' value='View' /></td>";
                                        echo "</tr></table>"; 
                                        echo "<hr class='manager-long-hr' />";
                                        echo "</form>";
                                        echo "</div>";
                                    }
                                }else {
                                    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNo costume orders yet.";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn); */
                        ?>
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
                        </div>
                        <div class="item-data-row">
                            <span>John Doe</span>
                            <span>Confirmed</span>
                            <span>2022-08-01</span>
                            <span>2022-12-01</span>
                            <a href="#" class="red">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>John C</span>
                            <span>Completed</span>
                            <span>2022-01-05</span>
                            <span>2022-12-15</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>Harry P</span>
                            <span>Completed</span>
                            <span>2022-07-01</span>
                            <span>2022-11-30</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>Harry P</span>
                            <span>Delivered</span>
                            <span>2022-01-01</span>
                            <span>2022-03-01</span>
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
