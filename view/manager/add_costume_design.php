<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Create costume design</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php 
            $conn = new mysqli("localhost", "root", "", "rlf");
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            } 
            $sql_all_material = "SELECT material_id, name, measuring_unit FROM `raw_material` where `manager_approval` = 'approve'";
            $materialCount = 0;
        ?>
        <script>
            var materialCount = 1;
            function addCode() {
                var material_row = "<div class='form-row'><div class='form-row-theme'>";
                material_row += "<select name='material_id[]' id='material_id_"+materialCount+"' onChange='setSizeAndUnit("+materialCount+", this)' required>";
                material_row += "<option selected disabled>ID - Material name</option>";
                <?php 
                    if($result = mysqli_query($conn, $sql_all_material)){
                        if(mysqli_num_rows($result) > 0){ 
                            while($optional_row = mysqli_fetch_array($result)){ 
                ?>
                                material_row += "<option value='"+"<?php echo $optional_row["material_id"] ?>"+"'>"+"<?php echo $optional_row["material_id"]; ?>"+" - "+"<?php echo $optional_row["name"] ?>"+" - ("+"<?php echo $optional_row["measuring_unit"] ?>"+")</option>";
                <?php       
                            }
                        }
                    }   
                ?>
                material_row += "</select></div>";
                material_row += "<div class='form-row-data'>";
                material_row += "<input type='text' class='column-textfield' name='material_size[]' id='material_size_"+materialCount+"' readonly />&nbsp";
                material_row += "<input type='text' class='column-textfield' name='measuring_unit[]' id='measuring_unit_"+materialCount+"' readonly />&nbsp";
                material_row += "<input type='number' step='0.001' min='0.001' class='column-textfield' name='quantity[]' id='quantity_"+materialCount+"' required /></div></div>";
                materialCount++; 
                document.getElementById("form_body").innerHTML += material_row;
            }
            function setSizeAndUnit(rowNumber , sel){
                var materialData = sel.options[sel.selectedIndex].text;
                var materialSize = materialData.split("-")[2];
                var measuringUnit = materialData.split("-")[3];
                document.getElementById("material_size_"+rowNumber).value = materialSize;
                document.getElementById("measuring_unit_"+rowNumber).value = measuringUnit;
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
                        <a href="#">View costume designs </a> > Create 
                    </div>

                    <div id="form-box">
                        <form method="post" name="costumeDesignForm" action="../RouteHandler.php" enctype="multipart/form-data">
                            <input type="text" hidden="true" name="framework_controller" value="costume_design/add" />
                            <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                            <center>
                                <h2>Create costume design</h2>
                            </center>
                            
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Design name : 
                                </div>
                                <div class="form-row-data">
                                    <input type="text" name="name" id="name" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Size : 
                                </div>
                                <div class="form-row-data">
                                    <select name="size" required>
                                        <option value="XS">XS</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="XXL">XXL</option>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Front view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="front_view" id="front_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Rear view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="rear_view" id="rear_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Left view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="left_view" id="left_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Right view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="right_view" id="right_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Description
                                </div>
                                <div class="form-row-data">
                                    <textarea rows="4" cols="40" name="description" id="description" required></textarea>
                                </div>
                            </div>

                            <input type="text" hidden="true" name="customized_design_approval" value="approve" />

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
                                            if($result = mysqli_query($conn, $sql_all_material)){
                                                if(mysqli_num_rows($result) > 0){
                                                    echo "<select name='material_id[]' id='material_id_0' onChange='setSizeAndUnit(0 , this)' required>";
                                                    echo "<option selected disabled>ID - Material name</option>";
                                                    while($all_material_row = mysqli_fetch_array($result)){
                                                        echo "<option value='".$all_material_row["material_id"]."'>".$all_material_row["material_id"]." - ".$all_material_row["name"]." - (".$all_material_row["measuring_unit"].")</option>";
                                                    }
                                                    echo "</select>";
                                                }else {
                                                    echo "0 results";
                                                }
                                            }else{
                                                echo "ERROR: Could not able to execute $sql_all_material. " . mysqli_error($conn);
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
                                        <input type="text" name="material_size[]" id="material_size_0" class="column-textfield" value="" readonly />
                                        <input type="text" name="measuring_unit[]" id="measuring_unit_0" class="column-textfield" value="" readonly />
                                        <input type="number" step="0.001" min="0.001" name="quantity[]" id="quantity_0" class="column-textfield" required />
                                        <button onclick="addCode()"> + </button>
                                    </div>
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
                                                echo "<option disabled>ID - Fashion designer</option>";
                                                while($row = mysqli_fetch_array($result)){
                                                    echo "<option value='".$row["employee_id"]."'>".$row["employee_id"]." - ".$row["first_name"]." ".$row["last_name"]."</option>";
                                                }
                                                echo "</select>";
                                            }else {
                                                echo "0 results";
                                            }
                                        }else{
                                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                                        }
                                    ?>
                                    <!--<select name="fashion_designer_id" id="fashion_designer_id">
                                        <option disabled>Designer ID - Designer name</option>
                                        <option>0001-John A</option>
                                        <option>0004-John B</option>
                                        <option>0010-John C</option>
                                        <option>0011-John D</option>
                                    </select> -->
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
                                                echo "<option disabled>ID - Merchandiser</option>";
                                                while($row = mysqli_fetch_array($result)){
                                                    echo "<option value='".$row["employee_id"]."'>".$row["employee_id"]." - ".$row["first_name"]." ".$row["last_name"]."</option>";
                                                }
                                                echo "</select>";
                                            }else {
                                                echo "0 results";
                                            }
                                        }else{
                                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                                        }
                                        mysqli_close($conn);
                                    ?>
                                    <!--<select name="merchandiser_id" id="merchandiser_id">
                                        <option disabled>Merchandiser ID - Merchandiser name</option>
                                        <option>0001-John A</option>
                                        <option>0004-John B</option>
                                        <option>0010-John C</option>
                                        <option>0011-John D</option>
                                    </select> -->
                                </div>
                            </div> 
                            <div class="form-row">
                                <div class="form-row-submit">
                                    <a href="add_costume_design.php">
                                        <input type="submit" value="Save" />
                                    </a>
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
