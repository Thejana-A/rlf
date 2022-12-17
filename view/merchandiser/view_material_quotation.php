<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View material quotation</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                parse_str($_SERVER['REQUEST_URI'],$row);
                //print_r($row);
            }

            $conn = new mysqli("localhost", "root", "", "rlf");
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            $sql_supplier_material = "SELECT material_supplier.material_id, raw_material.name, raw_material.size, raw_material.measuring_unit FROM `material_supplier` INNER JOIN `raw_material` ON material_supplier.material_id=raw_material.material_id WHERE material_supplier.supplier_id = ".$row["supplier_id"].";";
            $sql_quotation_material = "SELECT quotation_id, raw_material.material_id, name, measuring_unit, request_quantity, unit_price FROM raw_material, material_price WHERE material_price.material_id = raw_material.material_id AND quotation_id = ".$_GET['quotation_id'];
        ?>
        <script>
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
                            $material_row .= "<input type='number' step='0.001' min='0.001' class='column-textfield' name='request_quantity[]' required />&nbsp";
                            $material_row .= "<input type='text' class='column-textfield' name='unit_price[]' readonly />&nbsp";
                            $material_row .= "<input type='text' class='column-textfield' name='price[]' readonly /></div></div>";
                            
                        }else {
                            $material_row .= "0 results";
                        }
                    }else{
                        $material_row .= "ERROR: Could not able to execute $sql_supplier_material. " . mysqli_error($conn);
                    } 
                ?> 
                document.getElementById("form_body").innerHTML += "<?php echo $material_row; ?>";
            }

            function setSizeAndUnit(){
                document.getElementById("size[]").value = "xxx";
            } 

        </script>
    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Merchandiser </a> >
                    <a href="#">Raw material quotation </a> > View
                </div>

                <div id="form-box">
                    <form method="post" action="">
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
                                <span><b>Price(LKR)</b></span><button onclick='addCode()'> + </button>
                            </div>
                        </div>
                        <div id="form_body">
                            <?php 
                                if($result = mysqli_query($conn, $sql_quotation_material)){
                                    if(mysqli_num_rows($result) > 0){
                                        while($quotation_material_row = mysqli_fetch_array($result)){
                                            echo "<div class='form-row'>";
                                            echo "<div class='form-row-theme'>";
                                            echo "<input type='text' name='material_id[]' value='".$quotation_material_row["material_id"]." - ".$quotation_material_row["name"]." (".$quotation_material_row["measuring_unit"].")' readonly />";
                                            echo "</div>";
                                            echo "<div class='form-row-data'>";
                                            echo "<input type='number' step='0.001' min='0' name='request_quantity[]' class='column-textfield' value='".$quotation_material_row["request_quantity"]."' /> ";
                                            echo "<input type='text' name='unit_price[]' class='column-textfield' value='".$quotation_material_row["unit_price"]."' readonly /> ";
                                            echo "<input type='text' name='price[]' id='price[]'' class='column-textfield' readonly />";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                        
                                    }else {
                                        echo "0 results";
                                    }
                                }else{
                                    echo "ERROR: Could not able to execute $sql_all_material. " . mysqli_error($conn);
                                }  
                                mysqli_close($conn);  
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
                                            <input type="radio" name="supplier_approval" class="input-radio" value="approve" <?php echo ($row["supplier_approval"]=="approve")?'checked':'disabled' ?> readonly/> Accepted
                                        </td>
                                        <td>
                                            <input type="radio" name="supplier_approval" class="input-radio" value="reject" <?php echo ($row["supplier_approval"]=="reject")?'checked':'disabled' ?> readonly/> Rejected
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
                                <input type="date" name="expected_delivery_date" id="expected_delivery_date" value="<?php echo $row["expected_delivery_date"]; ?>" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <?php
                                    if($row["supplier_approval"] != null){
                                        echo "<input type='submit' value='Save' disabled />";
                                    }else{
                                        echo "<input type='submit' value='Save' />";
                                    }
                                ?>  
                            </div>
                            <div class="form-row-reset">
                                <?php
                                    if($row["supplier_approval"] == "reject"){
                                        echo "<input type='submit' value='Send purchase request' disabled />";
                                    }else{
                                        echo "<input type='submit' value='Send purchase request' />";
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
