<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View material quotation</title>
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
                $sql_view_quotation = "SELECT quotation_id, expected_delivery_date, supplier_approval, approval_description, request_date, issue_date, valid_till, supplier.supplier_id, merchandiser_id , supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, supplier.contact_no AS supplier_contact_no, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name FROM raw_material_quotation JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id JOIN employee ON raw_material_quotation.merchandiser_id = employee.employee_id WHERE quotation_id = ".$_GET['quotation_id'].";";
                $result_view_quotation = mysqli_query($conn, $sql_view_quotation);
                $row = mysqli_fetch_array($result_view_quotation);
            }
            

            $sql_material_purchase_request = "SELECT * FROM raw_material_order WHERE quotation_id = ".$row["quotation_id"].";";  
            $material_purchase_request_result = mysqli_query($conn, $sql_material_purchase_request);  

            $sql_quotation_material = "SELECT quotation_id, raw_material.material_id, name, measuring_unit, request_quantity, unit_price FROM raw_material, material_price WHERE material_price.material_id = raw_material.material_id AND quotation_id = ".$row['quotation_id'].";";  
            $sql_supplier_material = "SELECT material_supplier.material_id, raw_material.name, raw_material.size, raw_material.measuring_unit FROM `material_supplier` INNER JOIN `raw_material` ON material_supplier.material_id=raw_material.material_id WHERE material_supplier.supplier_id = ".$row["supplier_id"].";";

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
                        if(($row["supplier_approval"]=="approve")||($row["supplier_approval"]=="reject")){
                            $presentMaterialList .= "<input type='number' step='0.01' min='0' name='request_quantity[]' id='request_quantity_".$materialCount."' class='column-textfield' value='".$quotation_material_row["request_quantity"]."' readonly /> ";
                        }else{
                            $presentMaterialList .= "<input type='number' step='0.01' min='0' name='request_quantity[]' id='request_quantity_".$materialCount."' class='column-textfield' value='".$quotation_material_row["request_quantity"]."' /> ";
                        }
                        
                        $presentMaterialList .= "<input type='text' name='unit_price[]' id='unit_price_".$materialCount."' class='column-textfield' value='".$quotation_material_row["unit_price"]."' readonly /> ";
                        $presentMaterialList .= "<input type='text' name='material_price[]' id='material_price_".$materialCount."' class='column-textfield' readonly />";
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
            function addCode() {
                <?php  
                    $material_row = "";
                    if($result = mysqli_query($conn, $sql_supplier_material)){
                        if(mysqli_num_rows($result) > 0){ 
                            $material_row .= "<div class='form-row'><div class='form-row-theme'>";
                            $material_row .= "<select name='material_id[]' id='material_id[]' required>";
                            $material_row .= "<option disabled>ID - Material name</option>";
                            while($optional_row = mysqli_fetch_array($result)){
                                $material_row .= "<option value='".$optional_row["material_id"]."'>".$optional_row["material_id"]." - ".$optional_row["name"]." - (".$optional_row["measuring_unit"].")</option>";
                            }
                            $material_row .= "</select></div>";
                            $material_row .= "<div class='form-row-data'>";
                            $material_row .= "<input type='number' step='0.01' min='0' class='column-textfield' name='request_quantity[]' required />&nbsp";
                            $material_row .= "<input type='text' class='column-textfield' name='unit_price[]' readonly />&nbsp";
                            $material_row .= "<input type='text' class='column-textfield' name='material_price[]' id='' readonly /></div></div>";
                            
                        }else {
                            $material_row .= "0 results";
                        }
                    }else{
                        $material_row .= "ERROR: Could not able to execute $sql_supplier_material. " . mysqli_error($conn);
                    } 
                ?> 
                document.getElementById("form_body").innerHTML += "<?php echo $material_row; ?>";
            }

            function setPrice(){
                var totalPrice = 0;
                for(let i = 0;i < materialCount;i++){
                    var quantity = document.getElementById("request_quantity_"+i).value;
                    var unitPrice = document.getElementById("unit_price_"+i).value;
                    document.getElementById("material_price_"+i).value = quantity*unitPrice;
                    totalPrice = totalPrice + (quantity*unitPrice); 
                } 
                document.getElementById("total_price").value = totalPrice;
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
                    <a href="raw_material_quotations.php">Raw material quotation </a> > View
                </div>

                <div id="form-box">
                    <form method="post" name="materialQuotationForm" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="raw_material_quotation/update" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <center>
                            <h2>View raw material quotation</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="quotation_id" value="<?php echo $row["quotation_id"]; ?>" readonly/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_id" value="<?php echo $row["supplier_id"]; ?>" readonly/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_name" value="<?php echo $row["supplier_first_name"]." ".$row["supplier_last_name"]; ?>" readonly/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier contact no : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_contact_no" value="<?php echo $row["supplier_contact_no"]; ?>" readonly/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="merchandiser_id" value="<?php echo $row["merchandiser_id"]; ?>" readonly/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="merchandiser_name" value="<?php echo $row["merchandiser_first_name"]." ".$row["merchandiser_last_name"]; ?>" readonly/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Requesting date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="request_date" value="<?php echo $row["request_date"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation issuing date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="issue_date" value="<?php echo $row["issue_date"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation Valid till :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="valid_till" value="<?php echo $row["valid_till"]; ?>" readonly />
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
                                <?php
                                    if(($row["supplier_approval"] == null)&&($material_row != "0 results")){
                                        echo "<button onclick='addCode()'> + </button>";
                                    }else{
                                        echo "<button onclick='addCode()' disabled> + </button>";
                                    }
                                ?>
                            </div>
                        </div>
                        <div id="form_body">
                        <?php 
                            echo $presentMaterialList;   
                        ?>
                            
                        </div>
                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id="">
                                    <option disabled>ID - Material name</option>
                                    <option>0004 - Black Thread-S(reels)</option>
                                    <option>0014 - Blue Thread-S(reels)</option>
                                    <option>0022 - Red anchor button-L(units)</option>
                                </select> 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" readonly/>
                                <input type="text" name="" id="" class="column-textfield" readonly/>
                            </div>
                        </div> -->
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Total price (LKR) :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="total_price" id="total_price" readonly/>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Acceptance (By supplier) :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="supplier_approval" class="input-radio" value="approve" <?php echo ($row["supplier_approval"]=="approve")?'checked':'disabled' ?> /> Accepted
                                        </td>
                                        <td>
                                            <input type="radio" name="supplier_approval" class="input-radio" value="reject" <?php echo ($row["supplier_approval"]=="reject")?'checked':'disabled' ?> /> Rejected
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Acceptance description :
                            </div>
                            <div class="form-row-data">
                                <textarea name="approval_description" rows="4" cols="40" readonly><?php echo $row["approval_description"]; ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Expected delivery date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="expected_delivery_date" id="expected_delivery_date" value="<?php echo $row["expected_delivery_date"]; ?>" <?php echo ($row["supplier_approval"] != null)?'readonly':''; ?> required />
                                <input type="text" hidden="true" name="manager_approval" value="approve" />
                                <input type="text" hidden="true" name="approval_date" value="<?php echo Date('Y-m-d') ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <?php 
                                    if(mysqli_num_rows($material_purchase_request_result)>0){
                                        echo "<a style='text-decoration:none;' href='view_material_purchase_request.php?quotation_id=".$row["quotation_id"]."' >View material purchase request</a>";
                                    }
                                ?>
                            </div>
                            <div class="form-row-data">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <?php
                                    if($row["supplier_approval"] != null){
                                        echo "<input type='submit' value='Save' disabled />";
                                    }else{
                                        echo "<input type='submit' value='Save' name='update_material_quotation' />";
                                    }
                                ?>  
                            </div>
                            <div class="form-row-reset">
                                <?php
                                    if(($row["supplier_approval"] == "reject")||($row["supplier_approval"] == null)||(mysqli_num_rows($material_purchase_request_result)>0)){
                                        echo "<input type='submit' value='Send purchase request' disabled />";
                                    }else{
                                        echo "<input type='submit' value='Send purchase request' name='add_material_order' />";
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
            var min_EDD = yyyy + '-' + addLeadingZeros(mm,2) + '-' + addLeadingZeros(dd,2);
            document.getElementById("expected_delivery_date").setAttribute("min", min_EDD);
        </script>

    </body> 
</html>
