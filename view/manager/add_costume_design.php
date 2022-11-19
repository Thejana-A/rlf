<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Create costume design</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
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

                <div id="form-box-small">
                    <form method="post" name="costumeDesignForm" action="../RouteHandler.php" enctype="multipart/form-data">
                        <input type="text" hidden="true" name="framework_controller" value="costume_design/add" />
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
                                <select name="size" id="size" required>
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
                                Raw materials : 
                            </div>
                            <div class="form-row-data">
                                <?php 
                                    require_once('../../model/DBConnection.php');
                                    $connObj = new DBConnection();
                                    $conn = $connObj->getConnection();
                                    $sql = "SELECT material_id, name FROM raw_material";
                                    if($result = mysqli_query($conn, $sql)){
                                        if(mysqli_num_rows($result) > 0){
                                            echo "<select name='material_id[]' id='material_id' multiple size='2' required>";
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
                                    mysqli_close($conn);
                                ?>
                                <!--<select name="raw_material_id" id="raw_material_id" multiple size="2">
                                    <option disabled>ID - Material name</option>
                                    <option>0004 - Black Thread-S</option>
                                    <option>0014 - Blue Thread-S</option>
                                    <option>0022 - Red anchor button-L</option>
                                </select> -->
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
                        <div class="form-row">
                            <div class="form-row-theme">
                                Fashion designer : 
                            </div>
                            <div class="form-row-data">
                                <?php 
                                    $conn = $connObj->getConnection();
                                    $sql = "SELECT employee_id, first_name, last_name FROM employee where user_type='fashion designer'";
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
                                    mysqli_close($conn);
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
                                    $conn = $connObj->getConnection();
                                    $sql = "SELECT employee_id, first_name, last_name FROM employee where user_type='merchandiser'";
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
