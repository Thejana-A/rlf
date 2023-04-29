<?php session_start();
    $total_price = 0;
    $sname= "localhost";
    $unmae= "root";
    $password = "";
    $db_name = "rlf";
    $conn = mysqli_connect($sname, $unmae, $password, $db_name);

    $order_id = $_GET["order_id"];

    $sql = "SELECT * FROM costume_order WHERE costume_order.order_id = $order_id";
    $path = mysqli_query($conn, $sql);
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);

            $order_deadline = $row["expected_delivery_date"];
            $order_status = $row["order_status"];
            $advance_payment =$row["advance_payment"];
            $advance_payment_date = $row["advance_payment_date"];
            $balance_payment =$row["balance_payment"];
            $dispatch_date = $row["dispatch_date"];
            $quotation_id = $row["quotation_id"];

        }else {
            echo "0 results";
        } 
    }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    
    $sql = "SELECT * FROM costume_quotation WHERE costume_quotation.quotation_id = $quotation_id";
    $path = mysqli_query($conn, $sql);
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);

            $request_date = $row["request_date"];
            $manager_approval = $row["manager_approval"];
            
            
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
            $costume_list .= "<th style='padding-left: 5px;'>Unit Price</th>";
            $costume_list .= "<th style='padding-left: 5px;'>Price</th>";

            
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
            
            /*if(($row["manager_approval"] == "approve")){*/
            $costume_list .= "<tr>";
            $costume_list .= "<td style='padding-left: 5px;'><b>Total Price</b></td>";
            $costume_list .= "<td style='padding-left: 5px;'></td>";
            $costume_list .= "<td style='padding-left: 5px;'></td>";
            $costume_list .= "<td style='padding-left: 10px;'><input type='text' name='final_price[]' style='width: 50%' disabled value='".$total_price."'></td>";
            $costume_list .= "</tr>";
           /* }*/

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
    <title>View Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> >
            <a href="view_all_order.php">View All Orders </a> > View Order
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h2>View Order</h2>
        </div>
    </div>
    
    <div class="ViewRow">
        <div class="box">
            <form action="">
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


    <!--<div class="ViewRow">
        <div class="box">
            <form action="">
                <label for="fname">Quotation Created On :</label>
                <input type="text" id="fname" name="fname"style="width: 100%;" disabled placeholder="2022-11-11">
                <label for="fname">Valid till :</label>
                <input type="text" id="fname" name="fname"style="width: 100%;" disabled placeholder="2022-11-18">
              </form>
        </div>
    </div>-->
    <div class="ViewRow">
        <div class="box" style="display: block;">
            <center>
            <div class="section-header text-center">
                <?php
                    if($order_status == "accepted"){
                        echo "<h3 style='color: red;'>Payment..!</h3>";
                    }else if($order_status == "delivered"){
                        echo "<h3 style='color: red;'>Your Order is Completed..!</h3>";
                    }else if($order_status == "rejected"){
                        echo "<h3 style='color: red;'>Your Order is rejected..!</h3>";
                    }
                ?>
            </div>
            <img src="../image/size-chart- new.png" width="60%">
            <br />
            <form action="">

                <?php echo $costume_list; ?>


              </form>
            </center>
        </div>   
    </div>
    <div class="ViewRow">
        <div class="box">
        <form action="payment.php">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <input type="hidden" name="quotation_id" value="<?php echo $quotation_id; ?>">
                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                <input type="hidden" name="costume_name" value="<?php echo $costume_name; ?>">

                <label for="fname">Order Deadline :</label>
                <input type="text" name="order_deadline"style="width: 100%;" disabled value="<?php echo $order_deadline?>">
                <br />
                <br />
                <?php
                if($order_status == "accepted"){
                    echo "<center>";
                    
                    echo "<input type='submit' value='Advance Payment' style='width: 50%;' class='Quotationbtn'>";
                   
                    echo "</center>";
                }else if($order_status == "rejected"){
                    echo "<label for='reason'>Reason :</label>";
                    echo "<input type='text' name='reason' placeholder='Deadline can not be achieved' style='width: 100%;' disabled >";
                }else if($order_status == "delivered"){
                    echo "<center>";
                    echo "<input type='text' name='compete' style='width: 80%;' disabled placeholder='You Order is Completed' >";
                    echo "</center>";
                    echo "<br />";
                    echo "<br />";
                    echo "<label for='reason'>Advance Payment :</label>";
                    echo "<input type='text' name='advance_payment' style='width: 100%;' disabled value= Rs.".$advance_payment." >";
                    echo "<label for='reason'>Advance payment Date :</label>";
                    echo "<input type='text' name='reason' style='width: 100%;' disabled value=".$advance_payment_date." >";
                    echo "<label for='reason'>Balance Payment :</label>";
                    echo "<input type='text' name='balance_payment' style='width: 100%;' disabled value=Rs.".$balance_payment.">";
                    echo "<label for='reason'>Dispatch Date :</label>";
                    echo "<input type='text' name='dispatch_date' style='width: 100%;' disabled value=".$dispatch_date.">";
                }else if($order_status == "confirmed"){
                    echo "<center>";
                    echo "<input type='text' name='compete' style='width: 80%;' disabled placeholder='You Order is Confirmed' >";
                    echo "</center>";
                    echo "<br />";
                    echo "<br />";
                    echo "<label for='reason'>Advance Payment :</label>";
                    echo "<input type='text' name='advance_payment' style='width: 100%;' disabled value= Rs.".$advance_payment." >";
                    echo "<label for='reason'>Advance payment Date :</label>";
                    echo "<input type='text' name='reason' style='width: 100%;' disabled value=".$advance_payment_date." >";
                    echo "<label for='reason'>Balance Payment :</label>";
                    echo "<input type='text' name='balance_payment' style='width: 100%;' disabled value=Rs.".$balance_payment.">";
                    
                }
                ?>
              </form>
        </div>
    </div>
    <?php
    include "footer.php";
    ?>
</body>
</html>