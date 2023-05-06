<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit costume design</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php   

            //$conn = new mysqli("localhost", "root", "", "rlf");
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }

            if(isset($_GET['costume_design'])){ 
                $_SESSION["view_costume_path"] = "costume_design";
            }
            if(isset($_GET['customized_design'])){ 
                $_SESSION["view_costume_path"] = "customized_design";
            }

            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
                //print_r($row);
            }else{

                $sql = "SELECT * FROM costume_design WHERE design_id = ".$_GET["design_id"].";";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                } else {
                    echo "0 results";
                }
            }
        

            $designID = $row["design_id"];
            
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
                        $presentMaterialList .= "<input type='number' step='0.01' min='0' name='quantity[]' id='quantity_".$materialCount."' onChange='setPrice(".$materialCount.")' class='column-textfield' value='".$design_material_row["quantity"]."' required /> ";
                        $presentMaterialList .= "<input type='number' step='0.01' min='0' name='unit_price[]' id='unit_price_".$materialCount."' onChange='setPrice(".$materialCount.")' class='column-textfield' value='".$design_material_row["unit_price"]."' /> ";
                        $presentMaterialList .= "<input type='text' name='material_price[]'' id='material_price_".$materialCount."' class='column-textfield' value='' readonly />"; 
                        $presentMaterialList .= "</div>";
                        $presentMaterialList .= "</div>";
                        $materialCount++;
                    }
                    
                }else {
                    //echo "0 results";
                    $presentMaterialList.= "<div class='form-row'><div class='form-row-theme'>";
                    $presentMaterialList.= "<select name='material_id[]' id='material_id[]' required>";
                    $presentMaterialList.= "<option disabled>ID - Material name</option>";  
                    if($result = mysqli_query($conn, $sql_all_material)){
                        if(mysqli_num_rows($result) > 0){ 
                            while($optional_row = mysqli_fetch_array($result)){
                
                                $presentMaterialList.= "<option value='".$optional_row["material_id"]."'>".$optional_row["material_id"]." - ".$optional_row["name"]." - (".$optional_row["measuring_unit"].")</option>";
                
                            }
                        }
                    }
                    $presentMaterialList.= "</select></div>";
                    $presentMaterialList.= "<div class='form-row-data'>";
                    $presentMaterialList.= "<input type='number' step='0.01' min='0' class='column-textfield' name='quantity[]' id='quantity_".$materialCount."' onChange='setPrice(".$materialCount.")' required />&nbsp";
                    $presentMaterialList.= "<input type='number' step='0.01' min='0' class='column-textfield' name='unit_price[]' id='unit_price_".$materialCount."' onChange='setPrice(".$materialCount.")' />&nbsp";
                    $presentMaterialList.= "<input type='text' class='column-textfield' name='material_price[]' id='material_price_".$materialCount."' readonly /></div></div>";
                    $materialCount++;
                }
            }else{
                echo "ERROR: Could not able to execute $sql_design_material. " . mysqli_error($conn);
            }  

            $parts_of_name = explode('-', $row["name"]);
            $last = array_pop($parts_of_name);
            $parts_of_name = array(implode('-', $parts_of_name), $last);
            $costumeNameResult = $parts_of_name[0]; 
                            
        ?>

        <script>
            
            var materialCount = "<?php echo $materialCount; ?>";
            function addCode() {
                var material_row = "<div class='form-row'><div class='form-row-theme'>";
                material_row += "<select name='material_id[]' id='material_id[]' required>";
                material_row += "<option disabled>ID - Material name</option>";
                <?php  
                    if($result = mysqli_query($conn, $sql_all_material)){
                        if(mysqli_num_rows($result) > 0){ 
                            while($optional_row = mysqli_fetch_array($result)){
                ?>
                                material_row += "<option value='"+"<?php echo $optional_row["material_id"]; ?>"+"'>"+"<?php echo $optional_row["material_id"]; ?>"+" - "+"<?php echo $optional_row["name"]; ?>"+" - ("+"<?php echo $optional_row["measuring_unit"]; ?>"+")"+"</option>";
                <?php
                            }
                        }
                    }
                ?>
                material_row += "</select></div>";
                material_row += "<div class='form-row-data'>";
                material_row += "<input type='number' step='0.01' min='0' class='column-textfield' name='quantity[]' id='quantity_"+materialCount+"' onChange='setPrice("+materialCount+")' required />&nbsp";
                material_row += "<input type='number' step='0.01' min='0' class='column-textfield' name='unit_price[]' id='unit_price_"+materialCount+"' onChange='setPrice("+materialCount+")' />&nbsp";
                material_row += "<input type='text' class='column-textfield' name='material_price[]' id='material_price_"+materialCount+"' readonly /></div></div>";
                materialCount++;
                document.getElementById("form_body").innerHTML += material_row;
            }

            function setPrice(materialRowNumber){
                var quantity = document.getElementById("quantity_"+materialRowNumber).value;
                var unitPrice = document.getElementById("unit_price_"+materialRowNumber).value;
                document.getElementById("material_price_"+materialRowNumber).value = quantity*unitPrice;
                var totalPrice = 0;
                for(let i = 0;i < materialCount;i++){
                    var quantity = document.getElementById("quantity_"+i).value;
                    var unitPrice = document.getElementById("unit_price_"+i).value;
                    totalPrice = totalPrice + (quantity*unitPrice);
                }
                document.getElementById("total_material_price").value = totalPrice;
            }    
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
            function validateMaterialForm(){
                //var arrayLength = document.getElementById("material_id[]").length;
                //alert(arrayLength);
                //return false;
                var materialPriceApproval = document.forms["materialForm"]["material_price_approval"].value;
                var materialPriceDescription = document.forms["materialForm"]["material_price_description"].value;
                var finalPrice = document.forms["materialForm"]["final_price"].value;
                var publishStatus = document.querySelector('#publish_status');
                if((materialPriceApproval != "approve")&&(finalPrice > 0)){
                    alert("Material price should be approved to set final price");
                    return false;
                }else if((finalPrice == 0)&&(publishStatus.checked === true)){
                    alert("Final price is required to publish");
                    return false;
                }else if((materialPriceApproval == "reject")&&(materialPriceDescription == "")){
                    alert("Reason for rejection is required");
                    return false;   
                }else{
                    return true;
                }
            } 
                
        </script>
    </head>

    <body onLoad="setOriginalPrice()">
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Manager</a> >
                    <?php
                    if($_SESSION["view_costume_path"] == "costume_design"){
                        echo "<a href='costume_designs.php'>View costume design </a>";
                    }else{
                        echo "<a href='customized_designs.php'>View customized design </a>";
                    }
                    ?> >
                    <a href="./view_costume_design.php?name=<?php echo $costumeNameResult ?>" > View </a> > Edit
                </div>

                <div class="link-row" style="width:95%;">
                    <a href="./view_costume_design.php?name=<?php echo $costumeNameResult ?>" class="right-button">View design</a>
                </div><br />

                <div id="form-box">
                    <form method="post" name="materialForm" onSubmit="return validateMaterialForm()" action="../RouteHandler.php" enctype="multipart/form-data">
                        <input type="text" hidden="true" name="framework_controller" value="costume_design/update_price" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <input type="text" hidden="true" name="fashion_designer_id" value="<?php echo $row["fashion_designer_id"]; ?>" />
                        <input type="text" hidden="true" name="merchandiser_id" value="<?php echo $row["merchandiser_id"]; ?>" />
                        <input type="text" hidden="true" name="customer_id" value="<?php echo $row["customer_id"]; ?>" />

                        <center>
                            <h2>Costume design details</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Design ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="design_id" value="<?php echo $designID ?>" required readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Design name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" value="<?php echo $row["name"]; ?>" required readonly />
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
                            <h2>Price description</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - Material name (unit)</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit price(LKR)</b></span>
                                <span><b>Price(LKR)</b></span><button onclick="addCode();setOriginalPrice();"> + </button>
                            </div>
                        </div>

                        <div id="form_body">
                            <?php echo $presentMaterialList; ?>
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
                                <input type="number" name="final_price" min="0" value="<?php echo $row["final_price"]; ?>" />
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
                                            <input type="radio" name="material_price_approval" value="approve" class="input-radio" <?php echo ($row["material_price_approval"] == "approve")?'checked':'' ?> /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="material_price_approval" value="reject" class="input-radio" <?php echo ($row["material_price_approval"] == "reject")?'checked':'' ?> /> Reject
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
                            <div class="form-row-theme">
                                Publish status :
                            </div>
                            <div class="form-row-data">
                                <input type="checkbox" name="publish_status" id="publish_status" class="input-checkbox" value="publish" <?php echo ($row["publish_status"] == "publish")?'checked':'' ?> /> Published
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
