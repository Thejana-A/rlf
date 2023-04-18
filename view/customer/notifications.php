<?php error_reporting(E_ERROR | E_PARSE);
    session_start();
    $customerID =$_SESSION["customer_id"];
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Notifications</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $minDate = $_POST["min_date"];
                $maxDate = $_POST["max_date"];
                if(($minDate == "")&&($maxDate == "")){
                    $search_sql = "SELECT * FROM notification WHERE message LIKE '%$searchbar%' AND customer_id=$customerID ORDER BY notification_date DESC" ;
                }else if(($minDate == "")&&($maxDate != "")){
                    $search_sql = "SELECT * FROM notification WHERE message LIKE '%$searchbar%' AND customer_id=$customerID AND (notification_date <= '$maxDate') ORDER BY notification_date DESC";
                }else if(($minDate != "")&&($maxDate == "")){
                    $search_sql = "SELECT * FROM notification WHERE message LIKE '%$searchbar%' AND customer_id=$customerID AND (notification_date >= '$minDate') ORDER BY notification_date DESC";
                }else{
                    $search_sql = "SELECT * FROM notification WHERE message LIKE '%$searchbar%' AND customer_id=$customerID AND (notification_date BETWEEN '$minDate' AND '$maxDate') ORDER BY notification_date DESC";
                }
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<span class='notification-message'>".$search_row["message"]."</span>";
                            $search_output.= "<span>".$search_row["notification_date"]."</span>";
                            $search_output.= "<span>".$search_row["time"]."</span>";
                            $search_output.= "<hr />";
                            $search_output.= "</div>";
                        }   
                    }else{
                        $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
                    }
                }
            }else{
                $sql = "SELECT * FROM notification WHERE customer_id=$customerID ORDER BY notification_date DESC";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $output.= "<div class='item-data-row'>";
                            if($row["category"] == "costume quotation"){
                                $output.= "<span class='notification-message'><a style='text-decoration:none;' href='view_quotation.php?quotation_id=".explode(" ",$row["message"])[(count(explode(" ",$row["message"])))-1]."'>".$row["message"]."</a></span>";  
                            }else if($row["category"] == "costume order"){
                                $output.= "<span class='notification-message'><a style='text-decoration:none;' href='view_order.php?order_id=".explode(" ",$row["message"])[(count(explode(" ",$row["message"])))-1]."'>".$row["message"]."</a></span>";
                            }
                            $output.= "<span>".$row["notification_date"]."</span>";
                            $output.= "<span>".$row["time"]."</span>";
                            $output.= "<hr />";
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
                    <a href="customer_home.php">Home</a> > Notifications
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Notifications</h2>
                    </center>

                    <form method="post" action="notifications.php" class="search-panel">    
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" name="search" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Date : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_date" id="min_date" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_date" id="max_date" class="date-field" />
                            </div>
                        </div>
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b style="width:50%;">Notification</b>
                            <b>Date</b>
                            <b>Time</b>
                            <hr />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
