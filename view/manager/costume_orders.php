<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Costume orders</title>
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
                    <a href="#">Manager </a> > Costume orders
                </div>
                
                <div class="link-row">
                    <!--<a href="./add_costume_order_onsite.php" class="right-button">Add new costume order</a> -->
                </div>
                <div id="list-box">
                    <center>
                        <h2>Costume orders</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Order placed on : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="" id="" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="" id="" class="date-field" />
                            </div>
                        </div>
                        <b>Expected delivery date : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="" id="" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="" id="" class="date-field" />
                            </div>
                        </div>   
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Customer name</b>
                            <b>Order status</b>
                            <b>Order placed on</b>
                            <b>EDD</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT order_id, first_name, last_name, order_status, order_placed_on, expected_delivery_date, costume_order.quotation_id, advance_payment, dispatch_date, quality_status FROM costume_order, customer, costume_quotation WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id;";
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
                                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_order/manager_view' />";
                                        echo "<input type='text' hidden='true' name='order_id' value='".$row["order_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["first_name"]." ".$row["last_name"]."</span><span style='padding-left:24px;'>".$orderStatus."</span><span>".$row["order_placed_on"]."</span><span>".$row["expected_delivery_date"]."</span>";
                                        //echo "<input type='submit' class='grey' value='View' />";
                                        echo "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                                        echo "<td><input type='submit' class='".$class."' value='View' /></td>";
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
                            mysqli_close($conn);
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
                            <span>John Winsent</span>
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
                        </div>
                        <div class="item-data-row">
                            <span>Harry P</span>
                            <span>Accepted</span>
                            <span>2022-01-01</span>
                            <span>2022-03-01</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>Harry P</span>
                            <span>Rejected</span>
                            <span>2022-01-01</span>
                            <span>2022-03-01</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div> -->
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
