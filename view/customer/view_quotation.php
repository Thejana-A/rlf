<?php 

//include "db_conn.php";
    session_start();
    $total_price = 0;
    $sname= "localhost";
    $unmae= "root";
    $password = "";
    $db_name = "rlf";
    $conn = mysqli_connect($sname, $unmae, $password, $db_name);

    $quotation_id= $_GET["quotation_id"]; 

    $sql = "SELECT * FROM costume_quotation WHERE costume_quotation.quotation_id = $quotation_id";
    $path = mysqli_query($conn, $sql);
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);

            $request_date = $row["request_date"];
            $manager_approval = $row["manager_approval"];
            $issue_date = $row["issue_date"];
            $valid_till =$row["valid_till"];
            $approval_description = $row["approval_description"];
            $approval_date = $row["approval_date"];
            
            
        }else {
            echo "0 results";
        } 
    }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }

    ?>

<?php
    $sql_costume_list = "SELECT * FROM costume_design INNER JOIN design_quotation INNER JOIN costume_quotation WHERE design_quotation.quotation_id = $quotation_id AND design_quotation.design_id=costume_design.design_id AND costume_quotation.quotation_id = $quotation_id;";
    $path = mysqli_query($conn, $sql);
    if($result_costume_list = mysqli_query($conn, $sql_costume_list)){
        if(mysqli_num_rows($result_costume_list) > 0){
            $costume_list = "<table>";
            $costume_list .= "<tr>";
            $costume_list .= "<th style='padding: 5px;'>Size</th>";
            $costume_list .= "<th style='padding-left: 5px;'>Quantity</th>";
            if(($row["manager_approval"] == "approve")){
                $costume_list .= "<th style='padding-left: 5px;'>Unit Price</th>";
                $costume_list .= "<th style='padding-left: 5px;'>Price</th>";
            }
            
            $costume_list .= "</tr>";
            
            while ($row = $result_costume_list->fetch_assoc()){
                //echo $row["name"]."<br>";
                
                $unit_price = $row["final_price"];
                $quantity = $row["quantity"];
                $costume_list .= "<tr>";
                $costume_list .= "<td style='padding: 5px;'>".$row["name"]."</td>";
                $costume_list .= "<input type='text' hidden='true' value='".$row["final_price"]."' name='unit_price[]' >";
                $costume_list .= "<input type='text' hidden='true' value='".$row["design_id"]."' name='design_id[]' >";
                
                if(($row["manager_approval"] == "approve")){
                    $costume_list .= "<td style='padding-left: 20px; display: flex; justify-content: center;'><input type='text' name='quantity[]' value='".$row["quantity"]."' style='width: 40%' disabled ></td>";
                    $costume_list .= "<td style='padding-left: 10px;'><input type='text' name='final_price[]' style='width: 50%' disabled value='".$unit_price."'></td>";
                    $price = $unit_price * $quantity;
                    $costume_list .= "<td style='padding-left: 10px;'><input type='text' name='final_price[]' style='width: 50%' disabled value='".$price."'></td>";
                    $total_price= $total_price+$price;
                }
                else{
                    $costume_list .= "<td style='padding-left: 20px; display: flex; justify-content: center;'><input type='text' name='quantity[]' value='".$row["quantity"]."' style='width: 40%'  ></td>";

                }
                $costume_list .= "</tr>";
            }
            
            if($manager_approval == "approve"){
                $costume_list .= "<tr>";
                $costume_list .= "<td style='padding-left: 5px;'><b>Total Price</b></td>";
                $costume_list .= "<td style='padding-left: 5px;'></td>";
                $costume_list .= "<td style='padding-left: 5px;'></td>";
                $costume_list .= "<td style='padding-left: 10px;'><input type='text' name='final_price[]' style='width: 50%' disabled value='".$total_price."'></td>";
                $costume_list .= "</tr>";
            }
            

            $costume_list .= "</table>";
        }else {
            echo "0 results";
        } 
    }else{
        echo "ERROR: Could not able to execute $sql_costume_list. " . mysqli_error($conn);
    }

?>

<?php
    $sql = "SELECT  e.first_name, e.contact_no  FROM employee e,costume_quotation c WHERE c.quotation_id = $quotation_id AND c.merchandiser_id = e.employee_id;";
    $path = mysqli_query($conn, $sql);
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            
            $merchandiser_name =$row['first_name'];
            $contactno =$row['contact_no'];
        }else {
            echo "0 results";
        } 
    }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }

?>

<!DOCTYPE html>
<head>
    <title>view Qutation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> >
            <a href="view_all_quotation.php">View All Quotation </a> > View Quotation
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h2>View Quotation</h2>
        </div>
    </div>
    
    <div class="ViewRow">
        <div class="box">
            <form action="" method="">
                <?php
                $sql = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design INNER JOIN design_quotation ON publish_status = 'publish' AND design_quotation.design_id=costume_design.design_id AND design_quotation.quotation_id=$quotation_id;";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_array($result);
                        
                        $costume_name =$row['costume_name'];

                    }else {
                        echo "0 results";
                    } 
                }else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }
            
                ?>   
                
                <label for="fname">Design Name :</label>
                <input type="text"  name="design_name" style="width: 100%;" value="<?php echo $costume_name;?>" disabled />
                <label for="fname">Merchandiser Name :</label>
                <input type="text"  name="merchandiser_name"style="width: 100%;" value="<?php echo $merchandiser_name;?>" disabled />
                <label for="fname">Merchandiser Contact No:</label>
                <input type="text"  name="contact_no"style="width: 100%;" value="<?php echo $contactno;?>" disabled />
            </form>
        </div>
    </div>


    <?php 
    $sql = "SELECT * FROM costume_design INNER JOIN design_quotation ON costume_design.design_id = design_quotation.design_id AND design_quotation.quotation_id=$quotation_id;";
    $path = mysqli_query($conn, $sql);
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $design_name = $row["name"];
            
    ?>
    <div class="ViewRow">
        <div class="box">
            <div class="designimage">
                <img src="../front-view-image/<?php echo $row["front_view"]; ?>">
                <center>Front View</center>
            </div>
            <div class="designimage">
                <img src="../rear-view-image/<?php echo $row["rear_view"]; ?>">
                <center>Back View</center>
            </div>
            <div class="designimage">
                <img src="../left-view-image/<?php echo $row["left_view"]; ?>">
                <center>Left View</center>
            </div>
            <div class="designimage">
                <img src="../right-view-image/<?php echo $row["right_view"]; ?>">
                <center>Right View</center>
            </div>
        </div>   
    </div>
<?php }else {
            echo "0 results";
        } 
    }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }?>



    <div class="ViewRow">
        <div class="box" style="display: block;">
            <center>
            <div class="section-header text-center">
                <?php
                if($manager_approval != "approve"){
                    echo "<h3 style='color: red;''>View Costume Qutation</h3>";
                }else{
                    echo "<h3 style='color: red;''>Place Order...!</h3>";
                }
                ?>
            </div>
            <img src="../image/size-chart- new.png" width="60%">
            <br />
            <form method="post">
                <label for="requestdate">Request Date :</label>
                <input type="text" name="request_date" value="<?php echo $request_date ?>" disabled />
                <br />
                <br />
                <label for="valid_till">Valid Till Date :</label>
                <input type="text" name="valid_till" value="<?php echo $valid_till ?>" disabled />
            </form>
            <?php
              if(( $manager_approval == "approve")){
                echo $costume_list;
              }  
            ?>
                <?php 

                    if(( $manager_approval != "approve")){
                        echo "<form method='post' name='costumeQuotationForm' action='../RouteHandler.php' enctype='multipart/form-data'>";
                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_quotation/customer_update'/>";
                        echo "<input type='text' hidden='true'  name='home_url' value='customer/customer_home.php' />";
                       // echo "<input type='text' hidden='true'  name='page_url' value='".$_SERVER['REQUEST_URI']."' />";
                        //echo "<input type='text' hidden='true' name='request_date' value='".date("Y-m-d")."' />";
                        //echo "<input type='text' hidden='true' name='issue_date' value='".$issue_date."' />";
                        //echo "<input type='text' hidden='true' name='valid_till' value='".$valid_till."' />";
                        //echo "<input type='text' hidden='true' name='approval_description' value='".$approval_description."' />";
                        //echo "<input type='text' hidden='true' name='approval_date' value='".$approval_date."' />";
                        echo "<input type='text' hidden='true' name='quotation_id' value='".$quotation_id."' />";
                        echo $costume_list;
                        echo "<input type='submit' value='Edit' name='edit' class='Quotationbtn'>";
                        echo "<br/>";
                        echo "<input type='submit' value='Delete' name='delete' class='Quotationbtn'>";
                        echo "</form>";
                    }  
                ?>
            </center>
        </div>
        
    </div>
    <?php             
    if(( $manager_approval == "approve")){  

    echo "<div class='ViewRow'>" ;
        echo "<div class='box'>";
                echo "<form method='post' name='costumeOrderForm' action='../RouteHandler.php'>";
                echo "<input type='text' hidden='true' name='framework_controller' value='costume_order/add' />";
                echo "<input type='text' hidden='true' name='home_url' value='customer/customer_home.php' />"; 
                echo "<input type='text' hidden='true' name='order_placed_on' value='".date("Y-m-d")."' />";
                echo "<input type='text' hidden='true' name='quotation_id' value='".$quotation_id."' />";
                echo "<label for='fname'>Order Deadline :</label>";
                echo "<input type='date' name='expected_delivery_date' style='width: 100%;' required>";
                echo "<br />";
                echo "<br />";
                echo "<center>";
                echo "<input type='submit' value='Place Order' class='Quotationbtn' style='width: 50%;'>";
                echo "</center>";
              echo "</form>";
        echo "</div>";
    echo "</div>";
    }
    ?>
    <?php
    include "footer.php";
    ?>
</body>
</html>


<?php

    mysqli_close($conn); 

?>