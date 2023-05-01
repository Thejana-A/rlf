<?php require_once 'redirect_customer_login.php' ?>
<?php
 error_reporting(E_ERROR | E_PARSE);
?>
<?php 

//include "db_conn.php";
    session_start();
    $sname= "localhost";
    $unmae= "root";
    $password = "";
    $db_name = "rlf";
    $conn = mysqli_connect($sname, $unmae, $password, $db_name);
    $view_design_id= $_GET["design_id"];
    $sql = "SELECT * FROM `costume_design` WHERE `design_id` = $view_design_id;";
    $path = mysqli_query($conn, $sql);
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $design_name = $row["name"];
            
        }else {
            echo "0 results";
        } 
    }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }

    ?>
    <?php
    $sql = "SELECT  e.first_name, e.contact_no FROM employee e,costume_design c WHERE c.design_id = $view_design_id AND c.merchandiser_id = e.employee_id;";
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
<?php
    $sql_costume_list = "SELECT * FROM `costume_design` WHERE (`name` LIKE '".$_GET["design_name"]."-_' OR `name` LIKE '".$_GET["design_name"]."-__' OR `name` LIKE '".$_GET["design_name"]."-___') AND (`publish_status` = 'publish' OR `customer_id`='".$_SESSION['customer_id']."');";
    $path = mysqli_query($conn, $sql);
    if($result_costume_list = mysqli_query($conn, $sql_costume_list)){
        if(mysqli_num_rows($result_costume_list) > 0){
            $costume_list = "<table>";
            $costume_list .= "<tr>";
            $costume_list .= "<th style='padding: 5px;'>Size</th>";
            $costume_list .= "<th style='padding-left: 20px;'>Quantity</th>";
            $costume_list .= "</tr>";
            
            while ($row = $result_costume_list->fetch_assoc()){
                //echo $row["name"]."<br>";
                $costume_list .= "<tr>";
                $costume_list .= "<td style='padding: 5px;'>".$row["name"]."</td>";
                $costume_list .= "<input type='text' hidden='true' value='".$row["final_price"]."' name='unit_price[]' >";
                $costume_list .= "<input type='text' hidden='true' value='".$row["design_id"]."' name='design_id[]' >";
                $costume_list .= "<td style='padding-left: 20px; display: flex; justify-content: center;'><input type='number' min='0' name='quantity[]' required style='width: 40%'></td>";
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
<!DOCTYPE html>
<head>
    <title>Customized Request Qutation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> > Request Quotation
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h2>Request Quotation</h2>
        </div>
    </div>
    
    <div class="ViewRow">
        <div class="box">
            <form action="" method="">
                
                <input type="hidden" name="view_design_id"style="width: 100%;" value="<?php echo $view_design_id;?>"  readonly />
                <label for="fname">Design Name :</label>
                <input type="text"  name="design_name"style="width: 100%;" value="<?php echo $_GET["design_name"] ?>" disabled />
                <label for="fname">Merchandiser Name :</label>
                <input type="text"  name="merchandiser_name"style="width: 100%;" value="<?php echo $merchandiser_name;?>" disabled />
                <label for="fname">Merchandiser Contact No:</label>
                <input type="text"  name="contact_no"style="width: 100%;" value="<?php echo $contactno;?>" disabled />
            </form>
        </div>
    </div>
    <?php 
    $sql = "SELECT * FROM `costume_design` WHERE `design_id` = $view_design_id;";
    $path = mysqli_query($conn, $sql);
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $design_name = $row["name"];
            $merchandiser_name =$row["merchandiser_id"];
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
                <h3 style="color: red;">Request Qutation Now ..!</h3>
            </div>
            <img src="../image/size-chart- new.png" width="60%">
            <br />
            <form method="post" name="costumeQuotationForm" onSubmit="" action="../RouteHandler.php">
                <input type="text" hidden="true" name="framework_controller" value="costume_quotation/add" />
                <input type="text" hidden="true" name="home_url" value="customer/customer_home.php" />
                <input type="text" hidden="true" name="request_date" value="<?php echo date("Y-m-d"); ?>" />
                <input type="text" hidden="true" name="valid_till" value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>" />
                <input type="text" hidden="true" name="merchandiser_id" value="<?php echo $merchandiser_name; ?>" />
                <input type="text" hidden="true" name="customer_id" value="<?php echo $_SESSION["customer_id"]; ?>" />
                <!--<table>
                    <tr>
                        <th style="padding: 5px;">Size</th>
                        <th style="padding-left: 20px;">Quantity</th>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">XS</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="XS"style="width: 40%"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">S</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="S"style="width: 40%"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">M</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="M"style="width: 40%"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">L</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="L"style="width: 40%"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">XL</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="XL"style="width: 40%"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">XXL</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="XXL"style="width: 40%"></td>
                    </tr>
                </table> -->
                <?php echo $costume_list; ?>

                <br />
                <input type="submit" value="Request Quotation" class="Quotationbtn" style="margin-top: 20px; width:200px">
              </form>
            </center>
        </div>
        
    </div>
    <?php
    include "footer.php";
    ?>
</body>
</html>

<?php

    mysqli_close($conn); 

?>