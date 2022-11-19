<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit supplier</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php 
            //$supplierID = $_GET["supplier_id"];
            $supplierID = 2;
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "SELECT material_supplier.material_id, raw_material.name, raw_material.size, raw_material.measuring_unit FROM `material_supplier` INNER JOIN `raw_material` ON material_supplier.material_id=raw_material.material_id WHERE material_supplier.supplier_id = '$supplierID';";
            if (isset($_GET['material_number_increment'])) {
                $material_number++;
            }
        ?>
        <script>
            var material_numberx = 1;
            function addCode() {
                <?php  
                    $material_row = "";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){ 
                            $material_row .= "<div class='form-row'><div class='form-row-theme'>";
                            $material_row .= "<select name='material_id[]' id='material_id[]' required>";
                            $material_row .= "<option disabled>ID - Material name</option>";
                            while($row = mysqli_fetch_array($result)){
                                $material_row .= "<option value='".$row["material_id"]."'>".$row["material_id"]." - ".$row["name"]."</option>";
                            }
                            $material_row .= "</select></div>";
                            $material_row .= "<div class='form-row-data'>";
                            $material_row .= "<input type='text' class='column-textfield' name='size[]' readonly />&nbsp";
                            $material_row .= "<input type='text' class='column-textfield' name='measuring_unit[]' readonly />&nbsp";
                            $material_row .= "<input type='text' class='column-textfield' name='quantity[]' required /></div></div>";
                            
                        }else {
                            $material_row .= "0 results";
                        }
                    }else{
                        $material_row .= "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                    } 
                ?> 
                
                document.getElementById("form_body").innerHTML += "<?php echo $material_row; ?>";
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
                    <a href="#">Manager </a> >
                    <a href="#">Suppliers </a> > Edit
                </div>

                <div id="form-box">
                    <form method="post" name="supplierForm" onSubmit="return validateForm()" action="../RouteHandler.php">
                        <center>
                            <h2>Edit suppliers</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                First name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact number : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                City : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw materials : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="" multiple size="3">
                                    <option disabled>ID - Material name</option>
                                    <option>0004 - Black Thread-S</option>
                                    <option>0014 - Blue Thread-S</option>
                                    <option>0022 - Red anchor button-L</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Verify :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="verify_status" class="input-radio" id="" /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="verify_status" class="input-radio" id="" /> Deny
                                        </td>
                                    </tr>
                                </table>
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
                    <form method="post" name="materialQuotationForm" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="raw_material_quotation/add" />
                        <center>
                            <h2>Send raw material quotation request</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
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
                                        if($result = mysqli_query($conn, $sql)){
                                            if(mysqli_num_rows($result) > 0){
                                                echo "<select name='material_id[]' id='material_id[]' required>";
                                                echo "<option disabled>ID - Material name</option>";
                                                while($row = mysqli_fetch_array($result)){
                                                    echo "<option value='".$row["material_id"]."'>".$row["material_id"]." - ".$row["name"]."</option>";
                                                }
                                                echo "</select>";
                                            }else {
                                                echo "0 results";
                                            }
                                        }else{
                                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
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
                                    <input type="text" name="size[]" id="size[]" class="column-textfield" value="" readonly />
                                    <input type="text" name="measuring_unit[]" id="measuring_unit[]" class="column-textfield" value="" readonly />
                                    <input type="text" name="quantity[]" id="quantity[]" class="column-textfield" required />
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
                                <input type="date" name="" id="" />
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

    </body> 
</html>
