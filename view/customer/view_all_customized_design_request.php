<?php 
    error_reporting(E_ERROR | E_PARSE);
    session_start();    
    include "db_conn.php";
    $customerID =$_SESSION["customer_id"];
    $search = "";
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    //$sql = "SELECT * FROM costume_design WHERE costume_design.customer_id='$customerID' AND costume_design.name LIKE '%$search%'";
    $sql = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE costume_design.customer_id='$customerID' AND costume_design.name LIKE '%$search%' ;";
    $result = mysqli_query($conn, $sql);
    
?>


<!DOCTYPE html>
<head>
    <title>view all customized design request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> > View All Customized Design Request
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h2>View All Customized Design Request</h2>
        </div>
    </div>
    
    <div class="ViewRow">
        <div class="box" style="margin-bottom: 0;">
            <div>
            <form action="" method="GET">
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
                        <b>Proposed Name</b>
                        <b style="width:27%;">Merchandiser Name</b>
                        <b style="width:30%;">Status</b>                   
                        <hr />
                    </div>

                <?php

                /*$sql_merchandisername = "SELECT * FROM costume_design INNER JOIN employee ON costume_design.merchandiser_id = employee.employee_id AND costume_design.customer_id = '$customerID' ";
                if($result_merchandisername = mysqli_query($conn, $sql_merchandisername)){
                    if(mysqli_num_rows($result_merchandisername) > 0){
                        $row_merchandisername = mysqli_fetch_array($result_merchandisername);
                    }
                }*/

                $costume_name = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        array_push($costume_name , $row["costume_name"]);
                        
                    }
                }else{
                    echo "No results found.";
                }
                        
                for($i = 0;$i<count($costume_name);$i++){

                    //$sql_costume = "SELECT design_id, name, customized_design_approval, first_name FROM costume_design, employee  WHERE  costume_design.customer_id = '$customerID' AND (costume_design.merchandiser_id = employee.employee_id OR costume_design.merchandiser_id = '') AND (`name` LIKE '$costume_name[$i]-_' OR `name` LIKE '$costume_name[$i]-__' OR `name` LIKE '$costume_name[$i]-___') LIMIT 1 ;";
                    $sql_costume = "SELECT costume_design.design_id, costume_design.name, costume_design.customized_design_approval, IFNULL(employee.first_name, '') AS merchandiser_name
                    FROM costume_design
                    LEFT JOIN employee ON costume_design.merchandiser_id = employee.employee_id
                    WHERE costume_design.customer_id = '$customerID'
                    AND (costume_design.name LIKE '$costume_name[$i]-_' OR costume_design.name LIKE '$costume_name[$i]-__' OR costume_design.name LIKE '$costume_name[$i]-___') 
                    AND (costume_design.merchandiser_id IS NULL OR costume_design.merchandiser_id IS NOT NULL)
                    LIMIT 1;";

                    $result_costume = $conn->query($sql_costume);
                    if ($result_costume->num_rows > 0) {
                        while ($row = $result_costume->fetch_assoc()) { 
                ?>
               <?php

                /*if (mysqli_num_rows($result)  > 0) {

                        while ($row = mysqli_fetch_array($result)) {*/

                ?>
                    
                    <div class="item-data-row">
                        <?php $class = ($row["customized_design_approval"]=="reject")?"red":(($row["customized_design_approval"]== NULL)?"grey":"green"); ?>
                        <span><?php echo $costume_name[$i]; ?></span>
                        <span><?php echo $row['merchandiser_name'];?></span>
                        <span><?php if($row["customized_design_approval"]==NULL){
                                echo "pending";
                            }
                                echo $row['customized_design_approval'] ?>
                        </span>
                        <a href="view_customized_design_request.php?design_id=<?php echo $row['design_id']?>&design_name=<?php echo $costume_name[$i]?>" class="<?php echo $class ?>" >View</a>
                        
                        <hr />
                    </div>

                    <?php/* }

                }else {
                    echo "No results found.";
                }*/

               ?> 
                <?php       
                }
                
                }
                        
                        //echo $costume_name[$i];
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