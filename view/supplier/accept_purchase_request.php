<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View purchase request</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    
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
                print_r($row);
            }else{
                $sql_purchase_request = "SELECT raw_material_quotation.quotation_id, order_id, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, supplier.contact_no, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, issue_date, valid_till, expected_delivery_date, raw_material_order.manager_approval, raw_material_order.approval_description, dispatch_date, payment, payment_date from raw_material_quotation, raw_material_order, supplier, employee WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material_order.quotation_id = ".$_GET["quotation_id"].";";
                $result_purchase_request = mysqli_query($conn, $sql_purchase_request);
                $row = mysqli_fetch_array($result_purchase_request);
            }
            $sql_quotation_material = "SELECT quotation_id, raw_material.material_id, name, measuring_unit, request_quantity, unit_price FROM raw_material, material_price WHERE material_price.material_id = raw_material.material_id AND quotation_id = ".$row['quotation_id'].";";  
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
                        $presentMaterialList .= "<input type='text' name='material_price[]' id='material_price_".$materialCount."' value='".$quotation_material_row["material_price"]."'class='column-textfield' readonly />";
                        $presentMaterialList .= "</div>";
                        $presentMaterialList .= "</div>";
                        $materialCount++;
                    }
                    
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql_all_material. " . mysqli_error($conn);
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
                    <a href="profile.php">Supplier </a> >View purchase requests 
                </div>

                <div id="form-box">
                <form method="post" name="materialOrderForm" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="raw_material_order/supplier_view" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/supplier/profile.php" />
                        <center>
                            <h2>View purchase request</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Purchase request ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="order_id" id="" value="<?php echo $row["order_id"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="quotation_id" id="" value="<?php echo $row["quotation_id"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_id" id="" value="<?php echo $row["supplier_id"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Valid till : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="valid_till" id="" value="<?php echo $row["valid_till"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Expected Delivery Date : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="expected_delivery_date" id="" value="<?php echo $row["expected_delivery_date"] ?>" readonly />
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - material name(size)</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit Price</b></span>
                                <span><b>Price(LKR)</b></span>
                            </div>
                        </div>

                        <?php echo $presentMaterialList; ?>
                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id="" readonly>
                                    <option disabled>ID - Material name</option>
                                    <option>0004 - Black Thread-S(S)</option>
                                    <option>0014 - Blue Thread-S(S)</option>
                                    <option>0022 - Red anchor button-L(L)</option>
                                </select> 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" value="5" readonly />
                                <input type="text" name="" id="" class="column-textfield" value="metre" readonly />
                                <input type="text" name="" id="" class="column-textfield" value="1000" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id="" readonly>
                                    <option disabled>ID - Material name</option>
                                    <option>0002 - Green Silk-S(S)</option>
                                    <option>0014 - Blue Thread-S(S)</option>
                                    <option>0022 - Red anchor button-L(L)</option>
                                </select> 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" value="10"readonly />
                                <input type="text" name="" id="" class="column-textfield" value="metre" readonly />
                                <input type="text" name="" id="" class="column-textfield" value="2000" readonly/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id="" readonly>
                                    <option disabled>ID - Material name</option>
                                    <option>0003 - White Thread-S(S)</option>
                                    <option>0014 - Blue Thread-S(S)</option>
                                    <option>0022 - Red anchor button-L(L)</option>
                                </select> 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" value="10" readonly />
                                <input type="text" name="" id="" class="column-textfield" value="yards" readonly />
                                <input type="text" name="" id="" class="column-textfield" value="1500" readonly />
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
                        <div class="form-row">
                            <div class="form-row-theme">
                                Dispatch Date : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="dispatch_date" id="" value="<?php echo $row["dispatch_date"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Payment Date : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="payment_date" id="" value="<?php echo $row["payment_date"] ?>" readonly />
                            </div>
                        </div>
                        <br>
                        <br>
                    </form>
                </div>   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
