<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View supplier</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php 
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }

            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
                //print_r($row);
            }else{

                $sql = "SELECT * FROM supplier WHERE supplier_id = ".$row["supplier_id"].";";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                } else {
                    echo "0 results";
                }
            }
            $supplierID = $row["supplier_id"];
            $sql_supplier_material = "SELECT material_supplier.material_id, raw_material.name, raw_material.size, raw_material.measuring_unit FROM `material_supplier` INNER JOIN `raw_material` ON material_supplier.material_id=raw_material.material_id WHERE material_supplier.supplier_id = '$supplierID';";
            $sql_all_material = "SELECT material_id, name, measuring_unit FROM `raw_material` where `manager_approval` = 'approve'";
        ?>
        <script>
            var materialCount = 1;
            function addCode() {
                material_row = "<div class='form-row'><div class='form-row-theme'>";
                material_row += "<select name='material_id[]' id='material_id_"+materialCount+"' onChange='setSizeAndUnit("+materialCount+", this)' required>";
                material_row += "<option selected disabled>ID - Material name</option>";
                <?php
                    if($result = mysqli_query($conn, $sql_supplier_material)){
                        if(mysqli_num_rows($result) > 0){ 
                            while($optional_row = mysqli_fetch_array($result)){
                ?>
                                material_row += "<option value='"+"<?php echo $optional_row["material_id"]; ?>"+"'>"+"<?php echo $optional_row["material_id"]; ?>"+" - "+"<?php echo $optional_row["name"]; ?>"+" - ("+"<?php echo $optional_row["measuring_unit"]; ?>"+")</option>";
                <?php
                            }
                        }
                    }
                ?>
                material_row += "</select></div>";
                material_row += "<div class='form-row-data'>";
                material_row += "<input type='text' class='column-textfield' name='size[]' id='size_"+materialCount+"' readonly />&nbsp";
                material_row += "<input type='text' class='column-textfield' name='measuring_unit[]' id='measuring_unit_"+materialCount+"' readonly />&nbsp";
                material_row += "<input type='number' step='0.001' min='0.001' class='column-textfield' name='request_quantity[]' required /></div></div>";
                materialCount++;
                document.getElementById("form_body").innerHTML += material_row;
            }

            function setSizeAndUnit(rowNumber , sel){
                var materialData = sel.options[sel.selectedIndex].text;
                var materialSize = materialData.split("-")[2];
                var measuringUnit = materialData.split("-")[3];
                document.getElementById("size_"+rowNumber).value = materialSize;
                document.getElementById("measuring_unit_"+rowNumber).value = measuringUnit;
            }
        </script>
        <!--<script>
            function addCode() {
            document.getElementById("form_body").innerHTML += 
            "<div class='form-row'><div class='form-row-theme'><select id=''><option disabled>ID - Material name</option><option>0004 - Black Thread-S</option><option>0014 - Blue Thread-S</option><option>0022 - Red anchor button-L</option></select></div><div class='form-row-data'><input type='text' class='column-textfield' disabled />&nbsp<input type='text' class='column-textfield' disabled />&nbsp<input type='text' class='column-textfield' /></div></div>";
            }
        </script> -->
    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    Merchandiser >
                    <a href="suppliers.php">Suppliers </a> > View
                </div>

                <div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>View suppliers</h2>
                        </center>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_id" id="supplier_id" value="<?php echo $supplierID; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                First name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="first_name" id="first_name" value="<?php echo $row["first_name"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="last_name" id="last_name" value="<?php echo $row["last_name"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="NIC" id="NIC" value="<?php echo $row["NIC"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="email" id="email" value="<?php echo $row["email"] ?>" readonly />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact number : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="contact_no" id="contact_no" value="<?php echo $row["contact_no"] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC :
                            </div>
                            <div class="form-row-data">
                                <img src="../NIC-front-image/<?php echo $row["NIC_front_image"]; ?>" class="material-image" />
                                <img src="../NIC-rear-image/<?php echo $row["NIC_rear_image"]; ?>" class="material-image" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Business certificate :
                            </div>
                            <div class="form-row-data">
                                <img src="../business-certificate/<?php echo $row["business_certificate"]; ?>" class="material-image" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                City : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="city" id="city" value="<?php echo $row["city"] ?>" readonly />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw materials : 
                            </div>
                            <div class="form-row-data">
                                <?php  
                                    $supplier_material_id = array();
                                    if($result = mysqli_query($conn, $sql_supplier_material)){
                                        if(mysqli_num_rows($result) > 0){
                                            while($supplier_material_row = mysqli_fetch_array($result)){
                                                array_push($supplier_material_id, $supplier_material_row["material_id"]);
                                            }
                                        }
                                    }
                                    $all_material_select = "";
                                    if($result = mysqli_query($conn, $sql_all_material)){
                                        if(mysqli_num_rows($result) > 0){
                                            $all_material_select .= "<select name='material_id[]' id='material_id[]' multiple size='2' disabled>";
                                            $all_material_select .= "<option disabled>ID - Material name</option>";
                                            while($all_material_row = mysqli_fetch_array($result)){
                                                $all_material_select .= "<option value=".$all_material_row["material_id"];
                                                if(in_array($all_material_row["material_id"], $supplier_material_id)){
                                                    $all_material_select .= " selected>".$all_material_row["material_id"]." - ".$all_material_row["name"]." - (".$all_material_row["measuring_unit"].")</option>";
                                                }else{
                                                    $all_material_select .= ">".$all_material_row["material_id"]." - ".$all_material_row["name"]." - (".$all_material_row["measuring_unit"].")</option>";
                                                }
                                            }
                                            $all_material_select .= "</select>";
                                        }else {
                                            $all_material_select = "0 results";
                                        }
                                        echo $all_material_select;
                                    }else{
                                        echo "ERROR: Could not able to execute $sql_all_material. " . mysqli_error($conn);
                                    }  
                                ?>
                                <!--<select name="" id="" multiple size="3">
                                    <option disabled>ID - Material name</option>
                                    <option>0004 - Black Thread-S</option>
                                    <option>0014 - Blue Thread-S</option>
                                    <option>0022 - Red anchor button-L</option>
                                </select> -->
                            </div>
                        </div>
                        
                    </form>
                </div> 
                
                <div id="form-box">
                    <form method="post" name="materialQuotationForm" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="raw_material_quotation/add" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/merchandiser/home.php" />
                        <center>
                            <h2>Send raw material quotation request</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="supplier_id" value="<?php echo $supplierID; ?>" readonly />
                                <input type="text" hidden="true" name="merchandiser_id" value="<?php echo $_SESSION["employee_id"]; ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - Material name</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Material Size</b></span>
                                <span><b>Measuring unit</b></span>
                                <span><b>Quantity</b></span>
                            </div>
                        </div>
                        <div id="form_body">
                            <div class="form-row">
                                <div class="form-row-theme">
                                    <?php 
                                        if($result = mysqli_query($conn, $sql_supplier_material)){
                                            if(mysqli_num_rows($result) > 0){
                                                echo "<select name='material_id[]' id='material_id_0' onChange='setSizeAndUnit(0 ,this)' required>";
                                                echo "<option selected disabled>ID - Material name</option>";
                                                while($supplier_material_row = mysqli_fetch_array($result)){
                                                    echo "<option value='".$supplier_material_row["material_id"]."'>".$supplier_material_row["material_id"]." - ".$supplier_material_row["name"]." - (".$supplier_material_row["measuring_unit"].")</option>";
                                                    array_push($supplier_material_id, $supplier_material_row["material_id"]);
                                                }
                                                echo "</select>";
                                            }else {
                                                echo "0 results";
                                            }
                                        }else{
                                            echo "ERROR: Could not able to execute $sql_supplier_material. " . mysqli_error($conn);
                                        }    
                                    ?>
                                    <!--<select name="" id="">
                                        <option disabled>ID - Material name</option>
                                        <option>0004 - Black Thread-S</option>
                                        <option>0014 - Blue Thread-S</option>
                                        <option>0022 - Red anchor button-L</option>
                                    </select>-->
                                </div>
                                <div class="form-row-data">
                                    <input type="text" name="size[]" id="size_0" class="column-textfield" value="" readonly />
                                    <input type="text" name="measuring_unit[]" id="measuring_unit_0" class="column-textfield" value="" readonly />
                                    <input type="number" step='0.001' min='0.001' name="request_quantity[]" id="request_quantity_0" class="column-textfield" required />
                                    <button onclick="addCode()"> + </button>
                                </div>
                            </div>
                        </div>
                        <?php
                            mysqli_close($conn);
                        ?>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Expected delivery date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="expected_delivery_date" id="expected_delivery_date" required />
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
