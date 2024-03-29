<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View material purchase request</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }


            if(isset($_GET['data'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
                //print_r($row);
            }else{
                //$sql_purchase_request = "SELECT raw_material_quotation.quotation_id, order_id, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, supplier.contact_no, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, issue_date, valid_till, expected_delivery_date, raw_material_order.manager_approval, raw_material_order.approval_description, dispatch_date, payment, payment_date from raw_material_quotation, raw_material_order, supplier, employee WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material_order.quotation_id = ".$_GET["quotation_id"].";";
                $sql_purchase_request = "SELECT raw_material_quotation.quotation_id, order_id, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, supplier.contact_no, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, issue_date, valid_till, expected_delivery_date, raw_material_order.manager_approval, raw_material_order.approval_description, dispatch_date, payment, payment_date FROM raw_material_quotation, raw_material_order, supplier, employee WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material_order.quotation_id = ".$_GET["quotation_id"].";";
                $result_purchase_request = mysqli_query($conn, $sql_purchase_request);
                $row = mysqli_fetch_array($result_purchase_request);
            }
            
            
            $quotation_material_list = array();
            $sql_quotation_material = "SELECT quotation_id, raw_material.material_id, name, measuring_unit, request_quantity, unit_price FROM raw_material, material_price WHERE material_price.material_id = raw_material.material_id AND quotation_id = ".$row['quotation_id'];
            if($result = mysqli_query($conn, $sql_quotation_material)){
                $materialCount = 0;
                $presentMaterialList = "";
                if(mysqli_num_rows($result) > 0){
                    while($quotation_material_row = mysqli_fetch_array($result)){
                        $presentMaterialList .= "<div class='form-row'>";
                        $presentMaterialList .= "<div class='form-row-theme'>";
                        $presentMaterialList .= "<input type='text' name='material_id[]' value='".$quotation_material_row["material_id"]." - ".$quotation_material_row["name"]." (".$quotation_material_row["measuring_unit"].")' readonly />";
                        $presentMaterialList .= "</div>";
                        $presentMaterialList .= "<div class='form-row-data'>";
                        $presentMaterialList .= "<input type='number' step='0.001' min='0.001' name='request_quantity[]' id='request_quantity_".$materialCount."' class='column-textfield' value='".$quotation_material_row["request_quantity"]."' readonly />&nbsp";
                        $presentMaterialList .= "<input type='text' name='unit_price[]' id='unit_price_".$materialCount."' class='column-textfield' value='".$quotation_material_row["unit_price"]."' readonly /> ";
                        $presentMaterialList .= "<input type='text' name='material_price[]' id='material_price_".$materialCount."' class='column-textfield' readonly />";
                        $presentMaterialList .= "</div>";
                        $presentMaterialList .= "</div>";
                        array_push($quotation_material_list, $quotation_material_row["material_id"]);
                        $materialCount++;
                    }
                    $_SESSION["quotation_material_list"] = $quotation_material_list;
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql_all_material. " . mysqli_error($conn);
            }    

            if($row["dispatch_date"] == ""){
                $sql_goods_received_notice = "SELECT quotation_id, raw_material.material_id, name, measuring_unit, request_quantity FROM raw_material, material_price WHERE material_price.material_id = raw_material.material_id AND quotation_id = ".$row['quotation_id'];
            }else{
                $sql_goods_received_notice = "SELECT quotation_id, raw_material.material_id, name, measuring_unit, request_quantity, quantity_received FROM raw_material, material_price, order_material_received WHERE material_price.material_id = raw_material.material_id AND quotation_id = ".$row['quotation_id']." AND material_price.material_id = order_material_received.material_id AND order_id = ".$row['order_id'];
            }    
            if($result = mysqli_query($conn, $sql_goods_received_notice)){
                $goodsReceivedCount = 0;
                $goodsReceivedNotice = "";
                if(mysqli_num_rows($result) > 0){
                    while($goods_received_notice_row = mysqli_fetch_array($result)){
                        $goodsReceivedNotice .= "<div class='form-row'>";
                        $goodsReceivedNotice .= "<div class='form-row-theme'>";
                        $goodsReceivedNotice .= "<input type='text' name='material_id[]' value='".$goods_received_notice_row["material_id"]." - ".$goods_received_notice_row["name"]."' readonly />";
                        $goodsReceivedNotice .= "</div>";
                        $goodsReceivedNotice .= "<div class='form-row-data'>";
                        $goodsReceivedNotice .= "<input type='number' step='0.001' min='0.001' name='request_quantity[]' id='request_quantity_".$goodsReceivedCount."' class='column-textfield' value='".$goods_received_notice_row["request_quantity"]."' readonly />&nbsp";
                        $goodsReceivedNotice .= "<input type='text' name='unit_price[]' id='measuring_unit[]' class='column-textfield' value='".$goods_received_notice_row["measuring_unit"]."' readonly /> ";
                        $goodsReceivedNotice .= "<input type='number' step='0.001' min='0' name='quantity_received[]' id='quantity_received_".$goodsReceivedCount."' class='column-textfield' value='".$goods_received_notice_row["quantity_received"]."' required />"; 
                        $goodsReceivedNotice .= "</div>";
                        $goodsReceivedNotice .= "</div>";
                        $goodsReceivedCount++;
                    }
                    
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql_goods_received_notice. " . mysqli_error($conn);
            }      
        ?>

        <script>
            var materialCount = "<?php echo $materialCount; ?>";
            function setPrice(){
                var totalPrice = 0;
                for(let i = 0;i < materialCount;i++){
                    var quantity = document.getElementById("request_quantity_"+i).value;
                    var unitPrice = document.getElementById("unit_price_"+i).value;
                    document.getElementById("material_price_"+i).value = quantity*unitPrice;
                    totalPrice = totalPrice + (quantity*unitPrice); 
                } 
                document.getElementById("total_price").value = totalPrice;
                document.getElementById("payment").value = totalPrice;
            } 

            function checkQuantityReceived(){
                var invalidQuantity = 0;
                for(let j = 0;j < materialCount;j++){
                    var quantity_requested = document.getElementById("request_quantity_"+j).value;
                    var quantity_received = document.getElementById("quantity_received_"+j).value;
                    if(quantity_requested < quantity_received){
                        invalidQuantity = 1;
                    }
                } 
                if(invalidQuantity == 1){
                    alert("Quantity received can't exceed the quantity requested.");
                    return false;
                }else{
                    return true;
                }
            } 

            function validateForm(){
                var manager_approval = document.forms["materialOrderForm"]["manager_approval"].value;
                var approval_description = document.forms["materialOrderForm"]["approval_description"].value;
    
                if (manager_approval == "") {
                    alert("Manager approval is required");
                    return false;
                }else if ((manager_approval == "reject")&&(approval_description == "")) {
                    alert("Reason for rejection is required");
                    return false;
                }else{
                    return true;
                }
            }

        </script>
    </head>

    <body onLoad="setPrice()">
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Manager</a> >
                    <a href="material_purchase_requests.php">Raw material purchase request </a> > View
                </div>

                <div id="form-box">
                    <form method="post" name="materialOrderForm" onSubmit="return validateForm()" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="raw_material_order/update" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <center>
                            <h2>View material purchase requests</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="quotation_id" value="<?php echo $row["quotation_id"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Order ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="order_id" value="<?php echo $row["order_id"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_id" value="<?php echo $row["supplier_id"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_name" value="<?php echo $row["supplier_first_name"]." ".$row["supplier_last_name"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier contact no : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_contact_no" value="<?php echo $row["contact_no"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="merchandiser_id" value="<?php echo $row["employee_id"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="merchandiser_name" value="<?php echo $row["merchandiser_first_name"]." ".$row["merchandiser_last_name"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation issuing date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="issue_date" value="<?php echo $row["issue_date"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation Valid till :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="valid_till" value="<?php echo $row["valid_till"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Expected delivery date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="expected_delivery_date" value="<?php echo $row["expected_delivery_date"] ?>" readonly />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - material name(Measuring unit)</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit price(LKR)</b></span>
                                <span><b>Price(LKR)</b></span>
                            </div>
                        </div>

                        <?php echo $presentMaterialList; ?>
                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                0005-Black anchor button-S(S)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0005-Blue thin thread-L(L)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                            </div>
                        </div>-->
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Total price (LKR) :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="total_price" id="total_price" readonly />
                            </div>
                        </div>

                        <?php
                            $quotation_material_list = $_SESSION["quotation_material_list"];

                            $material_list_string = "";
                            for($count = 0;$count < count($quotation_material_list);$count++){
                                $material_list_string .= "material_price.material_id = ".$quotation_material_list[$count];
                                if($count != (count($quotation_material_list)-1)){
                                    $material_list_string .= " OR ";
                                }
                            }
                            $merchandiser_id = ($row["employee_id"] == "")?$row["merchandiser_id"]:$row["employee_id"];
                            $quotation_sql = "SELECT raw_material_quotation.quotation_id, material_price.material_id, name, raw_material_quotation.supplier_id, supplier.first_name, supplier.last_name, request_date, valid_till, measuring_unit, unit_price, supplier_approval,request_quantity FROM raw_material_quotation, supplier, raw_material, material_price WHERE raw_material_quotation.supplier_id = supplier.supplier_id AND material_price.material_id = raw_material.material_id AND raw_material_quotation.quotation_id = material_price.quotation_id AND supplier_approval = 'approve' AND raw_material_quotation.request_date = '".$row["request_date"]."' AND raw_material_quotation.merchandiser_id = ".$merchandiser_id." AND raw_material_quotation.quotation_id != ".$row["quotation_id"]." GROUP BY raw_material_quotation.quotation_id,material_price.material_id HAVING (".$material_list_string.");"; 
                            
                            if($result_quotation = mysqli_query($conn, $quotation_sql)){
                                $materialCount = 0;
                                $output = "";
                                $_SESSION["quotation_id"] = 0;
                                if(mysqli_num_rows($result_quotation) > 0){
                                    $validity = 1;
                                    while($row_quotation = mysqli_fetch_array($result_quotation)){
                                        
                                        if($_SESSION["quotation_id"] == $row_quotation["quotation_id"]){
                                            $materialCount++;
                                        }else{
                                            $materialCount = 1;
                                            $_SESSION["quotation_id"] = $row_quotation["quotation_id"];
                                            $totalPrice = 0;
                                        }
                
                
                                        $select_material_id = "SELECT material_id FROM material_price WHERE quotation_id = ".$row_quotation["quotation_id"].";";
                                        $material_result = mysqli_query($conn, $select_material_id);
                                        $material_id_array = array();
                                        if(mysqli_num_rows($material_result) > 0){
                                            while($material_id = mysqli_fetch_array($material_result)){
                                                array_push($material_id_array, $material_id["material_id"]);
                                            }
                                        }
                                    
                
                                        if($material_id_array == $quotation_material_list){
                                            if($validity == 1){
                                                echo "<div class='form-row'>";
                                                echo "<div class='form-row-theme'>";
                                                echo "<a href='see_more_quotations.php' style='text-decoration:none;'>See more</a>";
                                                echo "</div>";
                                                echo "<div class='form-row-data'>";
                                            
                                                echo "</div>";
                                                echo "</div>";
                                            }
                                            $validity++;
                                        } 
                                    }
                                }
                            } 
                        ?>
                        
                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                <a href="see_more_quotations.php">See more</a>
                            </div>
                            <div class="form-row-data">
                                
                            </div>
                        </div> -->
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Approval (By manager) :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="manager_approval" value="approve" class="input-radio" <?php echo ($row["manager_approval"]=="approve")?'checked':'' ?> /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="manager_approval" value="reject" class="input-radio" <?php echo ($row["manager_approval"]=="reject")?'checked':'' ?> /> Reject
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Approval description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="approval_description" rows="4" cols="40"><?php echo $row["approval_description"] ?></textarea>
                                <input type="date" hidden="true" name="approval_date" value="<?php echo ($row["approval_date"] == ''?Date('Y-m-d'):$row["approval_date"]) ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Payment (LKR) :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="payment" id="payment" value="<?php echo $row["payment"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Payment date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="payment_date" id="payment_date" value="<?php echo $row["payment_date"] ?>" <?php echo ($row["manager_approval"] == "approve")?'':'readonly'; ?> />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> 
                    </form>
                </div> 
                
                <div id="form-box">
                    <form method="post" onSubmit="return checkQuantityReceived()" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="order_material_received/add" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <center>
                            <h2>Goods received notice</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="quotation_id" value="<?php echo $row["quotation_id"] ?>" required readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Order ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="order_id" value="<?php echo $row["order_id"] ?>" required readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - material name(size)</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Measuring Unit</b></span>
                                <span><b>Quantity received</b></span>
                            </div>
                        </div>
                        <?php echo $goodsReceivedNotice; ?>
                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                0005-Black anchor button-S(S)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0005-Blue thin thread-L(L)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" />
                            </div>
                        </div>  -->
                        <div class="form-row">
                            <div class="form-row-theme">
                                Material received on :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="dispatch_date" id="dispatch_date" value="<?php echo $row["dispatch_date"] ?>" required />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <?php
                                    if($row["manager_approval"] == "approve"){
                                        echo "<input type='submit' value='Save' />";
                                    }else{
                                        echo "<input type='submit' value='Save' disabled />";
                                    }
                                ?>
                            </div>
                            <div class="form-row-reset">
                                <?php
                                    if($row["manager_approval"] == "approve"){
                                        echo "<input type='reset' value='Cancel' />";
                                    }else{
                                        echo "<input type='reset' value='Cancel' disabled />";
                                    }
                                ?>
                            </div>
                        </div> 
                    </form>
                </div>   

            </div> 
        </div> 

        <?php include 'footer.php';?>
        
        <script>
            function addLeadingZeros(num, totalLength) {
                return String(num).padStart(totalLength, '0');
            }
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; 
            var yyyy = today.getFullYear();
            var today_date = yyyy + '-' + addLeadingZeros(mm,2) + '-' + addLeadingZeros(dd,2);
            document.getElementById("dispatch_date").setAttribute("max", today_date);
            document.getElementById("dispatch_date").setAttribute("min", today_date);

            document.getElementById("payment_date").setAttribute("max", today_date);
            document.getElementById("payment_date").setAttribute("min", today_date);
        </script>

    </body> 
</html>
