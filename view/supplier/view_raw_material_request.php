<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Raw material request</title>
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
            $materialID = $_GET['material_id'];
            $sql_view_material = "SELECT material_id,name,size,measuring_unit,quantity_in_stock,description,image, raw_material.supplier_id as requester_id,'supplier' as requester_role, first_name,last_name,manager_approval,approval_description FROM raw_material,supplier where raw_material.supplier_id = supplier.supplier_id and material_id = ".$_GET['material_id'].";";
            $supplierID = $_SESSION["supplier_id"];
            $result_view_material = mysqli_query($conn, $sql_view_material);
                $row = mysqli_fetch_array($result_view_material);
        }
   ?>  
   
   <script>
            function confirmDeletion(){
                var confirmation = confirm("Are you sure you want to delete ?");
                if (confirmation==true) {
                    return true;
                }else{
                    return false;
                }
            }
        </script>


    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';
            require_once('../../model/DBConnection.php');?>
            <div id="page-content">
                <div id="breadcrumb">
                    <a href="index.php">Welcome </a> >
                    <a href="login.php">Login </a> >
                    <a href="home.php">Supplier </a> >View raw material requests 
                </div>

                <div id="form-box">
                    <form method="post"  name="rawMaterialForm" action="../RouteHandler.php" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="framework_controller" value="raw_material/supplier_operation" />
                    <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/supplier/profile.php" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <center>
                            <h2>View Raw material request</h2>
                        </center>
                       
                        <div class="form-row">
                            <div class="form-row-theme">
                                Material ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="material_id"  id="material_id" value = "<?php echo $row["material_id"];?>" readonly />
                                <input type="text" hidden="true" name="quantity_in_stock" value="0" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Material name : 
                            </div>
                            <div class="form-row-data">
                            <?php 
                                    if(($row["manager_approval"] == "approve")||($row["manager_approval"] == "reject")){
                                        echo "<input type='text' name='name' value='".$row["name"]."' required readonly />"; 
                                    }else{
                                        echo "<input type='text' value='".$row["name"]."' name='name' required />";
                                    }
                                ?>
                            </div>
                        </div>
                      

                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data"> 
                            <select name="size" required>
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
                                Measuring Unit : 
                            </div>
                            <div class="form-row-data">
                            <select name="measuring_unit" required>
                                    <option value="units" <?php echo ($row["measuring_unit"]=="units")?'selected':'' ?>>Units</option>
                                    <option value="metre" <?php echo ($row["measuring_unit"]=="m")?'selected':'' ?>>metre</option>
                                    <option value="kilogram" <?php echo ($row["measuring_unit"]=="kg")?'selected':'' ?>>kilogram</option>
                                    <option value="litre" <?php echo ($row["measuring_unit"]=="l")?'selected':'' ?>>litre</option>
                                    <option value="yards" <?php echo ($row["measuring_unit"]=="yards")?'selected':'' ?>>yards</option>
                                    <option value="m^2" <?php echo ($row["measuring_unit"]=="m^2")?'selected':'' ?>>m^2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material description :
                            </div>
                            <div class="form-row-data">
                                <textarea name="description" id="description" rows="4" cols="40" required ><?php echo $row["description"];?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Image :
                            </div>
                            <div class="form-row-data">
                            <img src="../raw-material-image/<?php echo $row["image"]; ?>" class="design-view" />

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Update image :
                            </div>
                            <div class="form-row-data">
                        <?php
                            if(($row["manager_approval"] == "approve")||($row["manager_approval"] == "reject")){
                                echo "<input type='file' name='image' accept='image/png, image/gif, image/jpeg, image/tiff' value= '".$row["image"]."' disabled />";
                            }else{
                                echo "<input type='file' name='image' accept='image/png, image/gif, image/jpeg, image/tiff' value= '".$row["image"]."' />";
                            }
                            ?>
                            </div>  
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Status (By manager) :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" <?php echo ($row["manager_approval"]=="approve")?'checked':'disabled' ?> /> Accepted
                                        </td>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" <?php echo ($row["manager_approval"]=="reject")?'checked':'disabled' ?> /> Rejected
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
                                <textarea name="approval_description" id="approval_description" rows="4" cols="40" disabled ><?php echo $row["approval_description"];?></textarea>
                            </div>
                        </div>
                        
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <?php 
                                    if(($row["manager_approval"] == "approve")||($row["manager_approval"] == "reject")){
                                        echo "<input type='submit' name='edit' value='Save' disabled />";
                                    }else{
                                        echo "<input type='submit' value='Save' name='edit' />";
                                    }
                                ?>
                            </div>
                            <div class="form-row-reset">
                                <?php 
                                    if(($row["manager_approval"] == "approve")||($row["manager_approval"] == "reject")){
                                        echo "<input type='submit' name='delete' value='Delete'  disabled />";
                                    }else{
                                        echo "<input type='submit' value='Delete' name='delete' id='confirmation' onclick='confirmDeletion()' />";
                                    }
                                ?>
                            </div>
                    </form>
                </div>   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>