<?php 
    session_start();    
    include "db_conn.php";
    $customerID =$_SESSION["customer_id"];
    //$sql = "SELECT * FROM costume_quotation INNER JOIN employee ON employee.employee_id=costume_quotation.merchandiser_id AND costume_quotation.customer_id='$customerID'";
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
        $sql = "SELECT * FROM costume_quotation 
                INNER JOIN employee ON employee.employee_id = costume_quotation.merchandiser_id 
                AND costume_quotation.customer_id = '$customerID' 
                WHERE (costume_quotation.request_date >= '$startDate' AND costume_quotation.request_date <= '$endDate')
                AND (costume_quotation.quotation_id LIKE '%$searchTerm%' OR employee.first_name LIKE '%$searchTerm%')";
    } elseif(empty($startDate) && !empty($endDate)){
        $sql = "SELECT * FROM costume_quotation 
                INNER JOIN employee ON employee.employee_id = costume_quotation.merchandiser_id 
                AND costume_quotation.customer_id = '$customerID' 
                WHERE (costume_quotation.request_date <= '$endDate')
                AND (costume_quotation.quotation_id LIKE '%$searchTerm%' OR employee.first_name LIKE '%$searchTerm%')";
    } elseif(!empty($startDate) && empty($endDate)){
        $sql = "SELECT * FROM costume_quotation 
                INNER JOIN employee ON employee.employee_id = costume_quotation.merchandiser_id 
                AND costume_quotation.customer_id = '$customerID' 
                WHERE (costume_quotation.request_date >= '$startDate')
                AND (costume_quotation.quotation_id LIKE '%$searchTerm%' OR employee.first_name LIKE '%$searchTerm%')";
    } else {
        $sql = "SELECT * FROM costume_quotation 
                INNER JOIN employee ON employee.employee_id = costume_quotation.merchandiser_id 
                AND costume_quotation.customer_id = '$customerID'
                WHERE costume_quotation.quotation_id LIKE '%$searchTerm%' OR employee.first_name LIKE '%$searchTerm%'";
    }

    $result = mysqli_query($conn, $sql);
    
?>


<!DOCTYPE html>
<head>
    <title>view all quotation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> > View All Quotation
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h2>View All Quotation</h2>
        </div>
    </div>
    
    <div class="ViewRow">
        <div class="box" style="margin-bottom: 0;">
            <div>
            <form action="" method="get">
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
                        <b>Quotation ID</b>
                        <b>Date</b>
                        <b>Merchandiser Name</b>                   
                        <hr />
                    </div>
            <?php

                if (mysqli_num_rows($result)  > 0) {

                    while ($row = mysqli_fetch_array($result)) {

                     ?>
                    
                    <div class="item-data-row">
                        <?php $class = ($row["manager_approval"]=="approve")?"green":"grey"; ?>
                        <span><?php echo $row['quotation_id']; ?></span>
                        <span><?php echo $row['request_date']; ?></span>
                        <span><?php echo $row['first_name'] ?></span>
                        <a href="view_quotation.php?quotation_id=<?php echo $row['quotation_id']; ?>" class="<?php echo $class ?>" >View</a>
                        
                        <hr />
                    </div>

            <?php   }

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