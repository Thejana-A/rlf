<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View material quotation</title>
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
                        $quotationStatus = ($row["supplier_approval"]=="reject")?"disabled":"";
                        $presentMaterialList .= "<div class='form-row'>";
                        $presentMaterialList .= "<div class='form-row-theme'>";
                        $presentMaterialList .= "<input type='text' name='material_id[]' value='".$quotation_material_row["material_id"]." - ".$quotation_material_row["name"]." (".$quotation_material_row["measuring_unit"].")' readonly />";
                        $presentMaterialList .= "</div>";
                        $presentMaterialList .= "<div class='form-row-data'>";
                        $presentMaterialList .= "<input type='number' step='0.001' min='0.001' name='request_quantity[]' id='request_quantity_".$materialCount."' class='column-textfield' value='".$quotation_material_row["request_quantity"]."' readonly />&nbsp";
                        $presentMaterialList .= "<input type='number' step='0.01' min='0.01' name='unit_price[]' id='unit_price_".$materialCount."' class='column-textfield' value='".$quotation_material_row["unit_price"]."'  onChange='setPrice();' ".$quotationStatus." /> ";
                        $presentMaterialList .= "<input type='text' name='material_price[]' id='material_price_".$materialCount."' value='".$quotation_material_row["material_price"]."' readonly class='column-textfield'  />";
                        $presentMaterialList .= "</div>";
                        $presentMaterialList .= "</div>";
                        $materialCount++;
                    }
                    
                }else {
                    $output.= "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql_all_material. " . mysqli_error($conn);
            } 
            
        ?>
    <script>
    var materialCount = "<?php echo $materialCount; ?>";


    function setPrice() {
        var totalPrice = 0;
        for (let i = 0; i < materialCount; i++) {
            var quantity = document.getElementById("request_quantity_" + i).value;
            var unitPrice = document.getElementById("unit_price_" + i).value;
            document.getElementById("material_price_" + i).value = quantity * unitPrice;
            totalPrice = totalPrice + (quantity * unitPrice);
        }
        document.getElementById("total_price").value = totalPrice;
        document.getElementById("payment").value = totalPrice;
        
    }
  
    
    function Disable() {
        document.getElementById("valid_till").disabled = true;
        for (let j = 0; j < materialCount; j++) {
            document.getElementById("unit_price_" + j).disabled = true;
        }
        
    }
    function Enable(){
        document.getElementById("valid_till").disabled = false;
        for (let j = 0; j < materialCount; j++) {
            document.getElementById("unit_price_" + j).disabled = false;
        }
    }


   function validateForm(){
                var supplier_approval = document.forms["MaterialQuotationForm"]["supplier_approval"].value;
                var approval_description = document.forms["MaterialQuotationForm"]["approval_description"].value;
                
                if ((supplier_approval=="")&&(approval_description!="")) {
                    alert("Suppliers's approval is required");
                    return false;
                }else if ((supplier_approval=="reject")&&(approval_description=="")) {
                    alert("Reason for rejection is required");
                    return false;
                }else{
                    return true;
                }
            }

    </script>

</head>

<body onLoad="setPrice();">
    
    <?php include 'header.php';?>
    <div id="page-body">

        <?php include 'leftnav.php';?>

        <div id="page-content">
            <div id="breadcrumb">
                <a href="http://localhost/rlf">Welcome </a> >
                <a href="../customer/customer_login.php">Login </a> >
                <a href="profile.php">Supplier </a> >
                <a href="all_quotation_requests.php">Quotation requests </a> > View
            </div>

            <div id="form-box">
                <form method="post" name="MaterialQuotationForm"  onSubmit="return validateForm()" action="../RouteHandler.php">
                    <input type="text" hidden="true" name="framework_controller" value="raw_material_quotation/update" />
                    <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                    <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/supplier/profile.php" />
                    <center>
                        <h2>Send quotation</h2>
                    </center>

                    <div class="form-row">
                        <div class="form-row-theme">
                            Quotation ID :
                        </div>
                        <div class="form-row-data">
                            <input type="text" name="quotation_id" id="quotation_id" value="<?php echo $row["quotation_id"]; ?>"
                                readonly />

                            <input type="text" hidden="true" name="manager_approval"
                                value="<?php echo $row["manager_approval"]; ?>" />

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-row-theme">
                            Merchandiser ID :
                        </div>
                        <div class="form-row-data">
                            <input type="text" name="merchandiser_id" value="<?php echo $row["merchandiser_id"]; ?>"
                                readonly />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-row-theme">
                            Merchandiser name :
                        </div>
                        <div class="form-row-data">
                            <input type="text" name="merchandiser_name"
                                value="<?php echo $row["merchandiser_first_name"]." ".$row["merchandiser_last_name"]; ?>" readonly/>
                            </div>
                        </div>
            
                
                        <div class=" form-row">
                            <div class="form-row-theme">
                                Requested on :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="request_date" value="<?php echo $row["request_date"]; ?>"
                                    readonly />
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - material name(Measuring unit)</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit Price</b></span>
                                <span><b>Price(LKR)</b></span>
                            </div>
                        </div>
                        <div id="form_body">
                            <div id="form_body">
                                <?php 
                            echo $presentMaterialList;   
                        ?>
                            </div>
                            <!--<div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id="" readonly>
                                    <option disabled>ID - Material name</option>
                                    <option>0001 - Black Thread-S(S)</option>
                                    <option>0014 - Blue Thread-S(S)</option>
                                    <option>0022 - Red anchor button-L(L)</option>
                                </select> 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" value = "100" class="column-textfield" readonly />
                                <input type="text" name="" id="" value = "metre" class="column-textfield"  readonly/>
                                <input type="text" name="" id="" class="column-textfield"  />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id=""  readonly>
                                    <option disabled>ID - Material name</option>
                                    <option>0002 - Green Silk-S(S)</option>
                                    <option>0014 - Blue Thread-S(S)</option>
                                    <option>0022 - Red anchor button-L(L)</option>
                                </select> 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" value = "200"  class="column-textfield" readonly />
                                <input type="text" name="" id="" value = "metre" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield"  />
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
                                <input type="text" name="" id=""value = "150" class="column-textfield" readonly />
                                <input type="text" name="" id="" value = "metre" class="column-textfield" readonly  />
                                <input type="text" name="" id="" class="column-textfield"  />
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
                                    Quotation issued date :
                                </div>
                                <div class="form-row-data">
                                    <input type="date" name="issue_date"
                                        value="<?php echo ($row["issue_date"]=="")?Date("Y-m-d"):$row["issue_date"] ?>"
                                        readonly />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Valid till :
                                </div>
                                <div class="form-row-data">
                                    <input type="date" name="valid_till" id="valid_till" value="<?php echo $row["valid_till"]; ?>" <?php echo ($row["supplier_approval"]=="reject")?"disabled":""; ?> required />
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-row-theme">
                                    Expected delivery date :
                                </div>
                                <div class="form-row-data">
                                    <input type="date" name="expected_delivery_date"
                                        value="<?php echo $row["expected_delivery_date"]; ?>" readonly />
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-row-theme">
                                    Status (By supplier) :
                                </div>
                                <div class="form-row-data">
                                    <table width="60%">
                                        <tr>
                                            <td>
                                                <input type="radio" name="supplier_approval" value="approve"
                                                    class="input-radio" id="checkYes" onChange="Enable()" 
                                                    <?php echo ($row["supplier_approval"] == "approve")?'checked':'' ?> />
                                                Accepted
                                            </td>
                                            <td>
                                                <input type="radio" name="supplier_approval" value="reject"
                                                    class="input-radio" id="checkNo" onChange="Disable()" 
                                                    <?php echo ($row["supplier_approval"] == "reject")?'checked':'' ?> />
                                                Rejected
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
                                    <textarea name="approval_description"  name="approval_description" rows="4" cols="40"><?php echo $row["approval_description"]; ?></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-row-submit">
                                    <input type="submit" name="update_material_quotation" value="Save" />
                                </div>
                                <div class="form-row-reset">
                                    <input type="reset" value="Cancel" />
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
            var min_VT = yyyy + '-' + addLeadingZeros(mm,2) + '-' + addLeadingZeros(dd,2);
            document.getElementById("valid_till").setAttribute("min", min_VT);
        </script>

</body>

</html>