<?php 
    session_start();    
    include "db_conn.php";
    $customerID =$_SESSION["customer_id"];
    //$sql = "SELECT * FROM costume_order INNER JOIN costume_quotation ON costume_quotation.quotation_id=costume_order.quotation_id AND costume_quotation.customer_id='$customerID'";
    $searchTerm = "";
    $startDate = "";
    $endDate = "";
    if (isset($_GET['search'])) {
        $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
    }
    if (isset($_GET['start_date'])) {
        $startDate = mysqli_real_escape_string($conn, $_GET['start_date']);
    }
    if (isset($_GET['end_date'])) {
        $endDate = mysqli_real_escape_string($conn, $_GET['end_date']);
    }
    if (!empty($startDate) && !empty($endDate)) {
        $sql = "SELECT * FROM costume_order 
                INNER JOIN costume_quotation ON costume_quotation.quotation_id=costume_order.quotation_id 
                AND costume_quotation.customer_id='$customerID' 
                WHERE (costume_order.order_placed_on >= '$startDate' AND costume_order.order_placed_on <= '$endDate')
                AND (costume_order.order_id LIKE '%$searchTerm%' OR costume_order.order_status LIKE '%$searchTerm%')";
    } elseif(empty($startDate) && !empty($endDate)){
        $sql = "SELECT * FROM costume_order 
                INNER JOIN costume_quotation ON costume_quotation.quotation_id=costume_order.quotation_id 
                AND costume_quotation.customer_id='$customerID' 
                WHERE (costume_order.order_placed_on <= '$endDate')
                AND (costume_order.order_id LIKE '%$searchTerm%' OR costume_order.order_status LIKE '%$searchTerm%')";
    } elseif(!empty($startDate) && empty($endDate)){
        $sql = "SELECT * FROM costume_order 
                INNER JOIN costume_quotation ON costume_quotation.quotation_id=costume_order.quotation_id 
                AND costume_quotation.customer_id='$customerID' 
                WHERE (costume_order.order_placed_on >= '$startDate')
                AND (costume_order.order_id LIKE '%$searchTerm%' OR costume_order.order_status LIKE '%$searchTerm%')";
    } else {
        $sql = "SELECT * FROM costume_order 
                INNER JOIN costume_quotation ON costume_quotation.quotation_id=costume_order.quotation_id 
                AND costume_quotation.customer_id='$customerID'
                WHERE costume_order.order_id LIKE '%$searchTerm%' OR costume_order.order_status LIKE '%$searchTerm%'";
    }

    /*if (isset($_GET['search'])) {
        $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
        $sql = "SELECT * FROM costume_order INNER JOIN costume_quotation ON costume_quotation.quotation_id=costume_order.quotation_id AND costume_quotation.customer_id='$customerID' WHERE costume_order.order_id LIKE '%$searchTerm%' OR costume_order.order_status LIKE '%$searchTerm%'";
    } else {
        $sql = "SELECT * FROM costume_order INNER JOIN costume_quotation ON costume_quotation.quotation_id=costume_order.quotation_id AND costume_quotation.customer_id='$customerID'";
    }*/
    
    $result = mysqli_query($conn, $sql);
    
?>
<!DOCTYPE html>
<head>
    <title>view all order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> > View All Order
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h2>View All Orders</h2>
        </div>
    </div>
    
    <div class="ViewRow">
        <div class="box" style="margin-bottom: 0;">
            <div>
            <form action="" method="GET">
                <input type="text" placeholder="Search.." name="search" class="search-bar" style="background-color:rgb(252, 250, 247); margin-bottom: 10px;">
                <input type="date" name="start_date" placeholder="Start date" class="search-bar" style="background-color:rgb(252, 250, 247); margin-bottom: 10px;">
                <input type="date" name="end_date" placeholder="End date" class="search-bar" style="background-color:rgb(252, 250, 247); margin-bottom: 10px;">
                <input type="submit" value="Search" class="search-bar">
            </form>
            </div>
        </div>
    </div>


    <div class="ViewRow" style="padding: 10px;">
        <div class="box" style="padding: 10px;">
            
                <div class="item-list" style="width:80%;">
                    <div class="item-heading-row">
                        <b> Order ID</b>
                        <b>Placed On</b>
                        <b>Order status</b>                   
                        <hr />
                    </div>

                    <?php

                    if (mysqli_num_rows($result)  > 0) {
    
                            while ($row = mysqli_fetch_array($result)) {
    
                         ?>
                        
                        <div class="item-data-row">
                            <?php $class = ($row["order_status"]=="rejected")?"red":(($row["order_status"]== NULL)?"grey":"green");
                             ?>
                            <span><?php echo $row['order_id']; ?></span>
                            <span><?php echo $row['order_placed_on']; ?></span>
                            <span><?php if($row["order_status"]==NULL){
                                echo "pending";
                            }
                            ?>
                            <?php echo $row['order_status']; ?></span>
                            
                            <a href="view_order.php?order_id=<?php echo $row['order_id']?>&quotation_id=<?php echo $row['quotation_id']?>" class="<?php echo $class ?>" >View</a>
                            
                            <hr />
                        </div>
    
                        <?php }
    
                    }else {
                        echo "No results found.";
                    }
    
                ?> 
                </div>
            
        </div>
        
    </div>
    <?php
    include "footer.php";
    ?>
</body>
</html>