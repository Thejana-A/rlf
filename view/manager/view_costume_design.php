<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View costume design</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php   
            //$conn = new mysqli("localhost", "root", "", "rlf");
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }

            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['name'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                echo $_GET['name'];
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
        ?>
            
    </head>

    <body onLoad="setOriginalPrice()">
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Manager </a> >
                    <a href="#">View costume design </a> > View
                </div>

                <div id="form-box">
                    <form method="post" action="../RouteHandler.php" enctype="multipart/form-data">
                        <input type="text" hidden="true" name="framework_controller" value="costume_design/update" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <input type="text" hidden="true" name="customized_design_approval" value="<?php echo $row["customized_design_approval"] ?>" />
                        <input type="text" hidden="true" name="design_approval_date" value="<?php echo $row["design_approval_date"] ?>" />
                        <input type="text" hidden="true" name="design_approval_description" value="<?php echo $row["design_approval_description"] ?>" />
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
                                <input type="text" name="name" value="<?php echo $row["name"]; ?>" required />
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
                                Front view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="front_view" id="front_view" accept="image/png, image/gif, image/jpeg, image/tiff" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Rear view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="rear_view" id="rear_view" accept="image/png, image/gif, image/jpeg, image/tiff" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Left view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="left_view" id="left_view" accept="image/png, image/gif, image/jpeg, image/tiff" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Right view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="right_view" id="right_view" accept="image/png, image/gif, image/jpeg, image/tiff" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description
                            </div>
                            <div class="form-row-data">
                                <textarea rows="4" cols="40" name="description" id="description" required><?php echo $row["description"]; ?></textarea>
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
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> 
                    </form>
                </div>   

                <div id="list-box-small">
                    <center>
                        <h2>Available sizes</h2>
                    </center>


                    <div class="item-list">
                        <div class="item-heading-row">
                            <b style="width:20%;">Design name</b>
                            <b style="width:20%;">Merchandiser</b>
                            <b style="width:30%;">Fashion designer</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            $sql_costume = "SELECT design_id, name, size from costume_design WHERE `name` LIKE '$costume_name[$i]-_'";
                            $result_costume_row = $conn->query($sql_costume);
                            if ($result_costume_row->num_rows > 0) {
                                while ($costume_row = $result_costume_row->fetch_assoc()) { 
                                    //$output.= $costume_name[$i]." - ".$costume_row["merchandiser_id"]." - ".$costume_row["merchandiser_first_name"]." ".$costume_row["merchandiser_last_name"]." - ".$costume_row["fashion_designer_id"]." - ".$costume_row["fd_first_name"]." ".$costume_row["fd_last_name"]." - ".$costume_row["front_view"];
                                    //$output.= "<br />";   
                                    $output.= "<div class='item-data-row'>";
                                    $output.= "<form method='post' action='../RouteHandler.php'>";
                                    $output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view' />";
                                    $output.= "<input type='text' hidden='true' name='design_id' value='".$costume_name[$i]."' />";
                                    $output.= "<span style='width:20%;'>".$costume_name[$i]."</span><span style='width:20%;'>".$costume_row["merchandiser_first_name"]." ".$costume_row["merchandiser_last_name"]."</span><span style='width:30%;'>".$costume_row["fd_first_name"]." ".$costume_row["fd_last_name"]."</span>";
                                    $output.= "<table align='right' style='margin-right:4px;' class='two-button-table'><tr>";
                                    $output.= "<td><input type='submit' class='grey' value='View' /></td>";
                                    $output.= "</tr></table>";
                                    $output.= "<hr class='manager-long-hr' />";
                                    $output.= "</form>";
                                    $output.= "</div>";
                                }
                            }else{
                                $output.= "No costume designs";
                            }
                            mysqli_close($conn);
                        
                        ?>
                        <!--<div class="item-data-row">
                            <span class="manager-ID-column">0003</span>
                            <span>Black long-sleeve-XL</span>
                            <span>John Doe</span>
                            <span>Harry A</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span class="manager-ID-column">0010</span>
                            <span>Green chinese collar-S</span>
                            <span>John B</span>
                            <span>Harry C</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div> -->
                    </div>


                </div>
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
