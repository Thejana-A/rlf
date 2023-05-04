<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<!--<html>
	<head>
	      <Meta name="viewpoint" content="width=device-width, initial-scale=1">
              <title> Costume Design </title>
              <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
              <?php   
           /* error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
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
            $presentMaterialList = "";                  
            if($result = mysqli_query($conn, $sql_design_material)){
                if(mysqli_num_rows($result) > 0){
                    while($design_material_row = mysqli_fetch_array($result)){
                        $presentMaterialList .= "<div class='form-row'>";
                        $presentMaterialList .= "<div class='form-row-theme'>";
                        $presentMaterialList .= "<input type='text' name='material_id[]' value='".$design_material_row["material_id"]." - ".$design_material_row["name"]." (".$design_material_row["measuring_unit"].")' readonly />";
                        $presentMaterialList .= "</div>";
                        $presentMaterialList .= "<div class='form-row-data'>";
                        $presentMaterialList .= "<input type='number' step='0.001' min='0' name='quantity[]' id='quantity_".$materialCount."' onChange='setPrice(".$materialCount.")' class='column-textfield' value='".$design_material_row["quantity"]."' required /> ";
                        $presentMaterialList .= "<input type='number' step='0.01' min='0' name='unit_price[]' id='unit_price_".$materialCount."' onChange='setPrice(".$materialCount.")' class='column-textfield' value='".$design_material_row["unit_price"]."' /> ";
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
                            
        ?>

	</head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Fashion Designer </a> >
                    <a href="#">View costume designs </a> > view
                </div>

                <div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>Costume Design</h2>
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
                                Appearance :
                            </div>
                            <div class="form-row-data">
                                <img src="../front-view-image/<?php echo $row["front_view"]; ?>" alt="front-view" class="design-view" />
                                <img src="../rear-view-image/<?php echo $row["rear_view"]; ?>" alt="rear-view" class="design-view" /><br />
                                <img src="../left-view-image/<?php echo $row["left_view"]; ?>" alt="left-view" class="design-view" />
                                <img src="../right-view-image/<?php echo $row["right_view"]; ?>" alt="right-view" class="design-view" /> 
                            </div>
                        </div>

                        <center>
                            <h2>Material Description</h2>
                        </center>
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
                                                    echo "<option disabled>ID - Material name</option>";
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
                                        
                                    </div>
                                    <div class="form-row-data">
                                        <input type="number" step="0.001" min="0.001" name="quantity[]" id="quantity_0" class="column-textfield" readonly />
                                        <input type="text" name="material_size[]" id="material_size_0" class="column-textfield" value="" readonly />
                                        <input type="text" name="measuring_unit[]" id="measuring_unit_0" class="column-textfield" value="" readonly />
                                        
                                    </div>
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
                        </div> 
                    </form>
		</div>
	    </div>
	</div>


        <?php include 'footer.php';?>

    </body> 
</html>

