<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notifications</title>
    <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />
    <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $minDate = $_POST["min_date"];
                $maxDate = $_POST["max_date"];
                if(($minDate == "")&&($maxDate == "")){
                    $search_sql = "SELECT * FROM notification WHERE message LIKE '%$searchbar%' AND supplier_id IS NOT NULL ORDER BY notification_date DESC";
                }else if(($minDate == "")&&($maxDate != "")){
                    $search_sql = "SELECT * FROM notification WHERE message LIKE '%$searchbar%' AND supplier_id IS NOT NULL AND (notification_date <= '$maxDate') ORDER BY notification_date DESC";
                }else if(($minDate != "")&&($maxDate == "")){
                    $search_sql = "SELECT * FROM notification WHERE message LIKE '%$searchbar%' AND supplier_id IS NOT NULL AND (notification_date >= '$minDate') ORDER BY notification_date DESC";
                }else{
                    $search_sql = "SELECT * FROM notification WHERE message LIKE '%$searchbar%' AND supplier_id IS NOT NULL AND (notification_date BETWEEN '$minDate' AND '$maxDate') ORDER BY notification_date DESC";
                }
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='item-data-row'>";
                            //$search_output.= "<span class='notification-message'>".$search_row["message"]."</span>";
                            if($search_row["category"] == "tender request"){
                                $search_output.= "<span class='notification-message'><a style='text-decoration:none;' href='view_raw_material_request.php?material_id=".explode(" ",$search_row["message"])[(count(explode(" ",$search_row["message"])))-1]."'>".$search_row["message"]."</a></span>";  
                            }else if($search_row["category"] == "material order"){
                                $search_output.= "<span class='notification-message'><a style='text-decoration:none;' href='accept_purchase_request.php?order_id=".explode(" ",$search_row["message"])[(count(explode(" ",$search_row["message"])))-1]."'>".$search_row["message"]."</a></span>";
                            }else if($search_row["category"] == "material quotation"){
                                $search_output.= "<span class='notification-message'><a style='text-decoration:none;' href='send_quotation.php?quotation_id=".explode(" ",$search_row["message"])[(count(explode(" ",$search_row["message"])))-1]."'>".$search_row["message"]."</a></span>";
                            }
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
                $sql = "SELECT * FROM notification WHERE supplier_id IS NOT NULL ORDER BY notification_date DESC";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $output.= "<div class='item-data-row'>";
                            if($row["category"] == "tender request"){
                                $output.= "<span class='notification-message'><a style='text-decoration:none;' href='view_raw_material_request.php?material_id=".explode(" ",$row["message"])[(count(explode(" ",$row["message"])))-1]."'>".$row["message"]."</a></span>";  
                            }else if($row["category"] == "material order"){
                                $output.= "<span class='notification-message'><a style='text-decoration:none;' href='accept_purchase_request.php?order_id=".explode(" ",$row["message"])[(count(explode(" ",$row["message"])))-1]."'>".$row["message"]."</a></span>";
                            }
                            else if($row["category"] == "material quotation"){
                                $output.= "<span class='notification-message'><a style='text-decoration:none;' href='send_quotation.php?quotation_id=".explode(" ",$row["message"])[(count(explode(" ",$row["message"])))-1]."'>".$row["message"]."</a></span>";
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
                <a href="http://localhost/rlf">Welcome </a> >
                <a href="../customer/customer_login.php">Login </a> >
                <a href="profile.php">Supplier </a> > Notifications
            </div>

            <div id="list-box">
                <center>
                    <h2>Notifications</h2>
                </center>

                <form method="post" action="notifications.php" class="search-panel">
                    <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                    <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
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
                        <b style="width:50%;">Message</b>
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
                    <!--<div class="item-data-row">
                            <span class="notification-message">A raw material quotation is requested</span>
                            <span>2022-04-17</span>
                            <span>17:16:14</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">A raw material purchase is requested</span>
                            <span>2022-05-12</span>
                            <span>20:19:45</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">A raw material quotation is requested </span>
                            <span>2022-06-22</span>
                            <span>20:19:45</span>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span class="notification-message">A raw material purchase is requested</span>
                            <span>2022-08-29</span>
                            <span>20:19:45</span>
                            <hr />
                        </div>-->
                </div>


            </div>

        </div>
    </div>

    <?php include 'footer.php';?>

</body>

</html>