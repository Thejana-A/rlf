<?php session_start();
    $total_price = 0;
    $sname= "localhost";
    $unmae= "root";
    $password = "";
    $db_name = "rlf";
    $conn = mysqli_connect($sname, $unmae, $password, $db_name);

    $quotation_id= $_GET["quotation_id"]; 
    $order_id = $_GET["order_id"];

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
<!DOCTYPE html>
<head>
    <title>View Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> >
            <a href="view_all_order.html">View All Orders </a> > View Order
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h2>View Order</h2>
        </div>
    </div>
    
    <div class="ViewRow">
        <div class="box">
            <form action="">
                <input type="text" name="designname"style="width: 100%;" placeholder="Sport T-shirt" disabled>
                <label for="fname">Merchandiser Name :</label>
                <input type="text"  name="merchandisername"style="width: 100%;" placeholder="Kamal Perera" disabled>
                <label for="fname">Merchandiser Contact No :</label>
                <input type="text" name="contacno"style="width: 100%;" placeholder="94 123 456 789" disabled>
              </form>
        </div>
    </div>
    <div class="ViewRow">
        <div class="box">
            <div class="designimage">
                <img src="../image/lorem_tshirt.PNG">
                <center>Front View</center>
            </div>
            <div class="designimage">
                <img src="../image/left.PNG">
                <center>Left View</center>
            </div>
            <div class="designimage">
                <img src="../image/back.PNG">
                <center>Back View</center>
            </div>
            <div class="designimage">
                <img src="../image/right.PNG">
                <center>Right View</center>
            </div>
        </div>   
    </div>
    <div class="ViewRow">
        <div class="box">
            <form action="">
                <label for="fname">Quotation Created On :</label>
                <input type="text" id="fname" name="fname"style="width: 100%;" disabled placeholder="2022-11-11">
                <label for="fname">Valid till :</label>
                <input type="text" id="fname" name="fname"style="width: 100%;" disabled placeholder="2022-11-18">
              </form>
        </div>
    </div>
    <div class="ViewRow">
        <div class="box" style="display: block;">
            <center>
            <div class="section-header text-center">
                <h3 style="color: red;">Place Order Now ..!</h3>
            </div>
            <img src="../image/size-chart- new.png" width="60%">
            <br />
            <form action="">
                <!--<table>
                    <tr>
                        <th style="padding: 5px; ">Size</th>
                        <th style="padding-left: 20px;">Quantity</th>
                        <th >Price</th>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">XS</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="XS"style="width: 40%" disabled placeholder="10"></td>
                        <td style="padding-left: 20px;"><input type="text" id="" name="XSP"style="width: 80%" disabled placeholder="10 000"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">S</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="S"style="width: 40%" disabled placeholder="5"></td>
                        <td style="padding-left: 20px;"><input type="text" id="" name="SP"style="width: 80%" disabled placeholder=" 5 000"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">M</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="M"style="width: 40%" disabled placeholder="10"></td>
                        <td style="padding-left: 20px;"><input type="text" id="" name="MP"style="width: 80%" disabled placeholder="12 000"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">L</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="L"style="width: 40%" disabled placeholder="5"></td>
                        <td style="padding-left: 20px;"><input type="text" id="" name="LP"style="width: 80%" disabled placeholder=" 6 000"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">XL</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="XL"style="width: 40%" disabled placeholder="4"></td>
                        <td style="padding-left: 20px;"><input type="text" id="" name="XLP"style="width: 80%" disabled placeholder=" 6 000"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">XXL</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="XXL"style="width: 40%" disabled placeholder="2"></td>
                        <td style="padding-left: 20px;"><input type="text" id="" name="XXLP"style="width: 80%" disabled placeholder=" 3 000"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;"> Total Price</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"></td>
                        <td style="padding-left: 20px;"><input type="text" id="" name="totalprice"style="width: 80%" disabled placeholder="32 000"></td>
                    </tr>
                </table>-->
                <?php echo $costume_list; ?>


              </form>
            </center>
        </div>   
    </div>
    <div class="ViewRow">
        <div class="box">
            <form action="">
                <label for="fname">Order Deadline :</label>
                <input type="text" id="fname" name="fname"style="width: 100%;" disabled placeholder="2022-12-20">

              </form>
        </div>
    </div>
    <?php
    include "footer.php";
    ?>
</body>
</html>