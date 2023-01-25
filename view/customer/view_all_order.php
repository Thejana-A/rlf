<?php 
    session_start();    
    include "db_conn.php";
    
    $sql = "SELECT * FROM costume_order INNER JOIN costume_quotation ON costume_quotation.quotation_id=costume_order.quotation_id";
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
            <form action="">
                <input type="text" placeholder="Search.." name="search" class="search-bar" style="background-color:rgb(252, 250, 247);">
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
                            <?php $class = ($row["order_status"]=="reject")?"red":(($row["order_status"]== NULL)?"grey":"green");
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
    
                    }
    
                ?> 

                    <!--<div class="item-data-row">
                        <span>O001</span>
                        <span>2022-10-01</span>
                        <span>John Doe</span>
                        <a href="view_order.html" class="grey">View</a>
                        <hr />
                    </div>
                    <div class="item-data-row">
                        <span>O002</span>
                        <span>2022-10-21</span>
                        <span>Selena Gomez</span>
                        <a href="view_order.html" class="grey">View</a>
                        <hr />
                    </div>
                    <div class="item-data-row">
                        <span>O003</span>
                        <span>2022-10-12</span>
                        <span>John Perera</span>
                        <a href="view_reject_order.html" class="red">View</a>
                        <hr />
                    </div>
                    <div class="item-data-row">
                        <span>O004</span>
                        <span>2022-11-11</span>
                        <span>Harry petter</span>
                        <a href="view_approve_order.html" class="green">View</a>
                        <hr />
                    </div>
                    -->
                    <div class="item-data-row">
                        <span>O005</span>
                        <span>2022-11-01</span>
                        <span>Kamal Perera</span>
                        <a href="view_order.php" class="grey">View</a>
                        <hr />
                    </div>
                    <div class="item-data-row">
                        <span>O006</span>
                        <span>2022-10-06</span>
                        <span>Nimal Dias</span>
                        <a href="view_approve_order.html" class="green">View</a>
                        <hr />
                    </div>
                </div>
            
        </div>
        
    </div>
    <?php
    include "footer.php";
    ?>
</body>
</html>