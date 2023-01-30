<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit customized design</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php   
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
                //print_r($row);
            }

            $designID = $row["design_id"];
            //$conn = new mysqli("localhost", "root", "", "rlf");
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            
            $sql_design_material = "SELECT design_material.design_id, raw_material.material_id, name, measuring_unit, quantity, unit_price from design_material inner join raw_material on design_material.material_id = raw_material.material_id where design_material.design_id = '$designID';";
            $sql_all_material = "SELECT material_id, name, measuring_unit FROM `raw_material` where `manager_approval` = 'approve';";

            $materialCount = 0; 
            $presentMaterialList = "";                  
            if($result = mysqli_query($conn, $sql_design_material)){
                if(mysqli_num_rows($result) > 0){
                    while($design_material_row = mysqli_fetch_array($result)){
                        $presentMaterialList .= "<div class='form-row'>";
                        $presentMaterialList .= "<div class='form-row-theme'>";
                        $presentMaterialList .= "<input type='text' name='material_id[]' value='".$design_material_row["material_id"]." - ".$design_material_row["name"]." (".$design_material_row["measuring_unit"].")' readonly />";
                        $presentMaterialList .= "</div>";
                        $presentMaterialList .= "<div class='form-row-data'>";
                        $presentMaterialList .= "<input type='number' step='0.001' min='0' name='quantity[]' id='quantity_".$materialCount."' onChange='setPrice(".$materialCount.")' class='column-textfield' value='".$design_material_row["quantity"]."' readonly /> ";
                        $presentMaterialList .= "<input type='number' step='0.01' min='0' name='unit_price[]' id='unit_price_".$materialCount."' onChange='setPrice(".$materialCount.")' class='column-textfield' value='".$design_material_row["unit_price"]."' readonly /> ";
                        $presentMaterialList .= "<input type='text' name='material_price[]'' id='material_price_".$materialCount."' class='column-textfield' value='' readonly />"; 
                        $presentMaterialList .= "</div>";
                        $presentMaterialList .= "</div>";
                        $materialCount++;
                    }
                    
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql_design_material. " . mysqli_error($conn);
            }  
            
            $customer_sql = "SELECT customer.customer_id, first_name, last_name, email, contact_no FROM customer INNER JOIN costume_design ON costume_design.customer_id = customer.customer_id AND design_id = ".$row["design_id"].";";
            if($result = mysqli_query($conn, $customer_sql)){
                if(mysqli_num_rows($result) > 0){
                    while($customer_row = mysqli_fetch_array($result)){
                        $customerName = $customer_row["first_name"]." ".$customer_row["last_name"];
                        $customerEmail = $customer_row["email"];
                        $customerContactNo = $customer_row["contact_no"];
                    }
                }
            }else{
                echo "ERROR: Could not able to execute $customer_sql. " . mysqli_error($conn);
            }
                                
        ?>

        <script>
            var materialCount = "<?php echo $materialCount; ?>";
            function setOriginalPrice(){
                var totalPrice = 0;
                for(let i = 0;i < materialCount;i++){
                    var quantity = document.getElementById("quantity_"+i).value;
                    var unitPrice = document.getElementById("unit_price_"+i).value;
                    document.getElementById("material_price_"+i).value = quantity*unitPrice;
                    totalPrice = totalPrice + (quantity*unitPrice); 
                } 
                document.getElementById("total_material_price").value = totalPrice;
            } 
        </script>
    </head>

    <body onLoad="setOriginalPrice();">
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Manager </a> >
                    <a href="#">Customized designs </a> > View
                </div>

                <!--<div id="form-box-ultra-small">-->
                <div id="form-box">
                    <form method="post" action="">
                    <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <center>
                            <h2>Customized costume design</h2>
                        </center>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Design ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="design_id" value="<?php echo $designID; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Proposed name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" value="<?php echo $row["name"]; ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size" disabled>
                                    <option value="XS" <?php echo ($row["size"] == "XS")?'selected':'' ?>>XS</option>
                                    <option value="S" <?php echo ($row["size"] == "S")?'selected':'' ?>>S</option>
                                    <option value="M" <?php echo ($row["size"] == "M")?'selected':'' ?>>M</option>
                                    <option value="L" <?php echo ($row["size"] == "L")?'selected':'' ?>>L</option>
                                    <option value="XL" <?php echo ($row["size"] == "XL")?'selected':'' ?>>XL</option>
                                    <option value="XXL" <?php echo ($row["size"] == "XXL")?'selected':'' ?>>XXL</option>
                                </select>
                            </div>
                        </div>

                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                Raw materials : 
                            </div>
                            <div class="form-row-data">
                                <select name="material_id" id="material_id" multiple size="2">
                                    <option disabled>ID - Material name</option>
                                    <option>0004 - Black Thread-S</option>
                                    <option>0014 - Blue Thread-S</option>
                                    <option>0022 - Red anchor button-L</option>
                                </select>
                            </div>
                        </div> -->

                        <div class="form-row">
                            <div class="form-row-theme">
                                Appearance :
                            </div>
                            <div class="form-row-data">
                                <img src="../front-view-image/<?php echo $row["front_view"]; ?>" alt="front-view" class="design-view" />
                                <img src="../rear-view-image/<?php echo $row["rear_view"]; ?>" alt="rear-view" class="design-view" /><br />
                                <img src="../left-view-image/<?php echo $row["left_view"]; ?>" alt="left-view" class="design-view" />
                                <img src="../right-view-image/<?php echo $row["right_view"]; ?>" alt="right-view" class="design-view" /> 
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description
                            </div>
                            <div class="form-row-data">
                                <textarea rows="4" cols="40" name="description" id="description"><?php echo $row["description"]; ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_id" id="customer_id" value="<?php echo $row["customer_id"]; ?>" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_name" id="customer_name" value="<?php echo $customerName; ?>" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer contact no : : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_contact_no" id="customer_contact_no" value="<?php echo $customerContactNo; ?>" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_email" id="customer_email" value="<?php echo $customerEmail; ?>" disabled />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - Material name (unit)</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit price(LKR)</b></span>
                                <span><b>Price(LKR)</b></span>
                            </div>
                        </div>

                        <div id="form_body">
                            <?php echo $presentMaterialList; ?>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Total material price (LKR) :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="total_material_price" id="total_material_price" readonly />
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-row-theme">
                                Fashion designer : 
                            </div>
                            <div class="form-row-data">
                                <?php 
                                    $sql = "SELECT employee_id, first_name, last_name FROM employee where user_type = 'fashion designer' AND active_status = 'enable'";
                                    if($result = mysqli_query($conn, $sql)){
                                        if(mysqli_num_rows($result) > 0){
                                            echo "<select name='fashion_designer_id' id='fashion_designer_id' required>";
                                            echo "<option disabled selected>ID - Fashion designer</option>";
                                            while($fashion_designer_row = mysqli_fetch_array($result)){
                                                if($fashion_designer_row["employee_id"] == $row["fashion_designer_id"]){
                                                    echo "<option value='".$fashion_designer_row["employee_id"]."' selected>".$fashion_designer_row["employee_id"]." - ".$fashion_designer_row["first_name"]." ".$fashion_designer_row["last_name"]."</option>";
                                                }else{
                                                    echo "<option value='".$fashion_designer_row["employee_id"]."'>".$fashion_designer_row["employee_id"]." - ".$fashion_designer_row["first_name"]." ".$fashion_designer_row["last_name"]."</option>";
                                                }   
                                            }
                                            echo "</select>";
                                        }else {
                                            echo "0 results";
                                        }
                                    }else{
                                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser : 
                            </div>
                            <div class="form-row-data">
                                <?php 
                                    $sql = "SELECT employee_id, first_name, last_name FROM employee where user_type='merchandiser' AND active_status = 'enable'";
                                    if($result = mysqli_query($conn, $sql)){
                                        if(mysqli_num_rows($result) > 0){
                                            echo "<select name='merchandiser_id' id='merchandiser_id' required>";
                                            echo "<option disabled selected>ID - Merchandiser</option>";
                                            while($merchandiser_row = mysqli_fetch_array($result)){
                                                if($merchandiser_row["employee_id"] == $row["merchandiser_id"]){
                                                    echo "<option value='".$merchandiser_row["employee_id"]."' selected>".$merchandiser_row["employee_id"]." - ".$merchandiser_row["first_name"]." ".$merchandiser_row["last_name"]."</option>";
                                                }else{
                                                    echo "<option value='".$merchandiser_row["employee_id"]."'>".$merchandiser_row["employee_id"]." - ".$merchandiser_row["first_name"]." ".$merchandiser_row["last_name"]."</option>";
                                                }
                                            }
                                            echo "</select>";
                                        }else {
                                            echo "0 results";
                                        }
                                    }else{
                                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>Customized design :</b>
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="customized_design_approval" value="approve" class="input-radio" <?php echo ($row["customized_design_approval"] == "approve")?'checked':'' ?> /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="customized_design_approval" value="reject" class="input-radio" <?php echo ($row["customized_design_approval"] == "reject")?'checked':'' ?> /> Reject
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
                                <textarea rows="4" cols="40" name="material_price_description"><?php echo $row["material_price_description"]; ?></textarea>
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
                        
                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                Design ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Proposed name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="">
                                    <option>S</option>
                                    <option>M</option>
                                    <option>L</option>
                                    <option>XL</option>
                                    <option>XXL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw materials : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="" multiple size="2">
                                    <option disabled>Supplier ID - Supplier name</option>
                                    <option>0001-Black-button-S</option>
                                    <option>0004-Blue-button-S</option>
                                    <option>0010-Red poplyn-M</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Appearance :
                            </div>
                            <div class="form-row-data">
                                <img src="../icons/front_view.png" alt="front-view" class="design-view" />
                                <img src="../icons/rear_view.png" alt="rear-view" /><br />
                                <img src="../icons/left_view.png" alt="left-view" />
                                <img src="../icons/right_view.png" alt="right-view" /> 
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Front view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Rear view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Left view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Right view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description
                            </div>
                            <div class="form-row-data">
                                <textarea rows="4" cols="40" name="" id=""></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer contact no : : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>Approve request (By manager) :</b>
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="product_status" class="input-radio" id="" /> Approved
                                        </td>
                                        <td>
                                            <input type="radio" name="product_status" class="input-radio" id="" /> Rejected
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
                                <textarea rows="4" cols="40" name="" id=""></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Fashion designer : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="">
                                    <option disabled>Designer ID - Designer name</option>
                                    <option>0001-John A</option>
                                    <option>0004-John B</option>
                                    <option>0010-John C</option>
                                    <option>0011-John D</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> -->
                    </form>
                </div>   

            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
