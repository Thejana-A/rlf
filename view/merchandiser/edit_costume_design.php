<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit costume design</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php   
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                parse_str($_SERVER['REQUEST_URI'],$row);
                //print_r($row);
            }

            $designID = $row["design_id"];
            $conn = new mysqli("localhost", "root", "", "rlf");
        
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            $sql_design_material = "SELECT design_material.design_id, raw_material.material_id, name, measuring_unit, quantity, unit_price from design_material inner join raw_material on design_material.material_id = raw_material.material_id where design_material.design_id = '$designID';";
            $sql_all_material = "SELECT material_id, name, measuring_unit FROM `raw_material` where `manager_approval` = 'approve';";
        
            $materialCount = 0;
            $materialList = "";
            if($result = mysqli_query($conn, $sql_design_material)){
                if(mysqli_num_rows($result) > 0){
                    while($design_material_row = mysqli_fetch_array($result)){
                        $materialList .= "<div class='form-row'>";
                        $materialList .= "<div class='form-row-theme'>";
                        $materialList .= "<input type='text' name='material_id[]' value='".$design_material_row["material_id"]." - ".$design_material_row["name"]." (".$design_material_row["measuring_unit"].")' readonly />";
                        $materialList .= "</div>";
                        $materialList .= "<div class='form-row-data'>";
                        $materialList .= "<input type='text' name='quantity[]' id='quantity_".$materialCount."' class='column-textfield' value='".$design_material_row["quantity"]."' readonly /> ";
                        $materialList .= "<input type='text' name='unit_price[]'' id='unit_price_".$materialCount."' onChange='setPrice(".$materialCount.")' class='column-textfield' value='".$design_material_row["unit_price"]."' /> ";
                        $materialList .= "<input type='text' name='material_price[]'' id='material_price_".$materialCount."' class='column-textfield' value='' readonly />";
                        $materialList .= "</div>";
                        $materialList .= "</div>";
                        $materialCount++;
                    }
                    
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql_design_material. " . mysqli_error($conn);
            }  
        ?>

        <script>
            
            function setPrice(materialRowNumber){
                var quantity = document.getElementById("quantity_"+materialRowNumber).value;
                var unitPrice = document.getElementById("unit_price_"+materialRowNumber).value;
                document.getElementById("material_price_"+materialRowNumber).value = quantity*unitPrice;
                var totalPrice = 0;
                for(let i = 0;i < <?php echo $materialCount; ?>;i++){
                    var quantity = document.getElementById("quantity_"+i).value;
                    var unitPrice = document.getElementById("unit_price_"+i).value;
                    totalPrice = totalPrice + (quantity*unitPrice);
                }
                document.getElementById("total_material_price").value = totalPrice;
            }    
            function setOriginalPrice(){
                var materialCount = <?php echo $materialCount; ?>;
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

    <body onLoad="setOriginalPrice()">
        
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Merchandiser </a> >
                    <a href="#">View costume designs </a> > Edit
                </div>

                <div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>Edit costume design</h2>
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
                                Design name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" value="<?php echo $row["name"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size">
                                    <option value="XS" <?php echo ($row["size"] == "XS")?'selected':'' ?>>XS</option>
                                    <option value="S" <?php echo ($row["size"] == "S")?'selected':'' ?>>S</option>
                                    <option value="M" <?php echo ($row["size"] == "M")?'selected':'' ?>>M</option>
                                    <option value="L" <?php echo ($row["size"] == "L")?'selected':'' ?>>L</option>
                                    <option value="XL" <?php echo ($row["size"] == "XL")?'selected':'' ?>>XL</option>
                                    <option value="XXL" <?php echo ($row["size"] == "XXL")?'selected':'' ?>>XXL</option>
                                </select>
                            </div>
                        </div>

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

                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                Appearance :
                            </div>
                            <div class="form-row-data">
                                <img src="../icons/front_view.png" alt="front-view" class="design-view" />
                                <img src="../icons/rear_view.png" alt="rear-view" /><br />
                                <img src="../icons/left_view.png" alt="left-view" />
                                <img src="../icons/right_view.png" alt="right-view" /> 
                            </div>
                        </div> -->
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description
                            </div>
                            <div class="form-row-data">
                                <textarea rows="4" cols="40" name="description" id="description" readonly><?php echo $row["description"]; ?></textarea>
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
                                            echo "<select name='fashion_designer_id' id='fashion_designer_id'>";
                                            echo "<option disabled>ID - Fashion designer</option>";
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
                    </form>
                </div>

                <div id="form-box">
                    <form >
                        <center>
                            <h2>Price description</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Design ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="design_id" value="<?php echo $designID ?>" readonly />
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
                            <?php 
                                echo $materialList;
                                mysqli_close($conn);  
                            ?>
                            
                        </div>

                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                0002-Anchor button(units)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div> -->
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
                                <b>Final price (LKR) :</b>
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="final_price" value="<?php echo $row["final_price"]; ?>" readonly />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>Approval for material price (By manager) :</b>
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="material_price_approval" value="approve" class="input-radio" <?php echo ($row["material_price_approval"] == "approve")?'checked':'disabled' ?> /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="material_price_approval" value="reject" class="input-radio" <?php echo ($row["material_price_approval"] == "reject")?'checked':'disabled' ?> readonly /> Reject
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
                                <textarea rows="4" cols="40" name="material_price_description" readonly><?php echo $row["material_price_description"]; ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Publish status :
                            </div>
                            <div class="form-row-data">
                                <input type="checkbox" name="publish_status" id="publish_status" class="input-checkbox" value="publish" <?php echo ($row["publish_status"] == "publish")?'checked':'' ?> readonly /> Published
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
            document.getElementById("publish_status").addEventListener("click", function(event){
                event.preventDefault()
            });
        </script>
    </body> 
</html>
