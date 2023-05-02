<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View costume design</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php   
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
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

            if(isset($_GET['name'])){ 
                
                $designName = $_GET['name'];
                $sql = "SELECT * FROM costume_design WHERE `name` LIKE '$designName-_' OR `name` LIKE '$designName-__' OR `name` LIKE '$designName-___' LIMIT 1;";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    //print_r($row);
                } else {
                    echo "0 results";
                }
            }

            $customer_sql = "SELECT customer.customer_id, first_name, last_name, email, contact_no FROM customer INNER JOIN costume_design ON costume_design.customer_id = customer.customer_id AND design_id = ".$row["design_id"].";";
            if($customer_result = mysqli_query($conn, $customer_sql)){
                if(mysqli_num_rows($customer_result) > 0){
                    while($customer_row = mysqli_fetch_array($customer_result)){
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
            function validateForm(){
                var customized_design_approval = document.forms["costumeDesignForm"]["customized_design_approval"].value;
                var design_approval_description = document.forms["costumeDesignForm"]["design_approval_description"].value;
                var fashion_designer_id = document.forms["costumeDesignForm"]["fashion_designer_id"].value;
                var merchandiser_id = document.forms["costumeDesignForm"]["merchandiser_id"].value;
                if ((customized_design_approval=="")&&(design_approval_description!="")) {
                    alert("Design approval is required");
                    return false;
                }else if ((customized_design_approval=="reject")&&(design_approval_description=="")) {
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
                    ?> > View
                </div>

                <div class="link-row" style="margin-left:-15%;">
                    <a href="./add_new_size.php?name=<?php echo $designName ?>" class="right-button">Add new size</a>
                </div><br />

                <div id="form-box-ultra-small">
                    <form method="post" name="costumeDesignForm" action="../RouteHandler.php" onSubmit="return validateForm()" enctype="multipart/form-data">
                        <input type="text" hidden="true" name="framework_controller" value="costume_design/update" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <input type="text" hidden="true" name="design_approval_date" value="<?php ($row["design_approval_date"] == "")? Date("Y-m-d"):$row["design_approval_date"] ?>" />
                        <center>
                            <h2>Edit costume design</h2>
                        </center>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Design name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" value="<?php echo $designName; ?>" required readonly />
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

                        
                        <?php
                            if($_SESSION["view_costume_path"] == "customized_design"){
                                echo "<div class='form-row'>";
                                    echo "<div class='form-row-theme'>";
                                        echo "Customer ID : ";
                                    echo "</div>";
                                    echo "<div class='form-row-data'>";
                                        echo "<input type='text' name='customer_id' id='customer_id' value='".$row["customer_id"]."' disabled />";
                                    echo "</div>";
                                echo "</div>";
                                echo "<div class='form-row'>";
                                    echo "<div class='form-row-theme'>";
                                        echo "Customer name : ";
                                    echo "</div>";
                                    echo "<div class='form-row-data'>";
                                        echo "<input type='text' name='customer_name' id='customer_name' value='".$customerName."' disabled />";
                                    echo "</div>";
                                echo "</div>"; 
                                echo "<div class='form-row'>";
                                    echo "<div class='form-row-theme'>";
                                        echo "Design approval :"; 
                                    echo "</div>";
                                    echo "<div class='form-row-data'>";
                                        echo "<table width='60%'>";
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo "<input type='radio' name='customized_design_approval' value='approve' class='input-radio' ".(($row["customized_design_approval"]=="approve")?'checked':'')." /> Approve";
                                                echo "</td>";
                                                echo "<td>";
                                                    echo "<input type='radio' name='customized_design_approval' value='reject' class='input-radio' ".(($row["customized_design_approval"]=="reject")?'checked':'')." /> Reject";
                                                echo "</td>";
                                            echo "</tr>";
                                        echo "</table>";
                                    echo "</div>";
                                echo "</div>";
                                echo "<div class='form-row'>";
                                    echo "<div class='form-row-theme'>";
                                        echo "Design approval description";
                                    echo "</div>";
                                    echo "<div class='form-row-data'>";
                                        echo "<textarea rows='4' cols='40' name='design_approval_description' id='design_approval_description'>".$row["design_approval_description"]."</textarea>";
                                    echo "</div>";
                                echo "</div>";  
                            }else{
                                echo "<input type='text' hidden='true' name='customized_design_approval' value='".$row["customized_design_approval"]."' />";
                                echo "<input type='text' hidden='true' name='design_approval_description' value='".$row["design_approval_description"]."' />";
                            }
                        ?>
                        

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
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> 
                    </form>
                </div>   

                <div id="list-box-ultra-small">
                    <center>
                        <h2>Available sizes</h2>
                    </center>


                    <div class="item-list">
                        <div class="item-heading-row">
                            <b class='manager-ID-column'>Design ID</b>
                            <b>Design name</b>
                            <b style="width:10%;">Size</b>
                            <b>Publish status</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            $sql_costume = "SELECT design_id, name, size, publish_status from costume_design WHERE `name` LIKE '$designName-_' OR `name` LIKE '$designName-__' OR `name` LIKE '$designName-___'";
                            $result_costume_row = $conn->query($sql_costume);
                            if ($result_costume_row->num_rows > 0) {
                                while ($costume_row = $result_costume_row->fetch_assoc()) {   
                                    echo "<div class='item-data-row'>";
                                    echo "<form method='post' action='../RouteHandler.php'>";
                                    echo "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view' />";
                                    echo "<input type='text' hidden='true' name='design_id' value='".$costume_row["design_id"]."' />";
                                    echo "<span class='manager-ID-column'>".$costume_row["design_id"]."</span><span>".$costume_row["name"]."</span><span style='width:12%;'>".$costume_row["size"]."</span><span>".(($costume_row["publish_status"]=="publish")?"Published":"Not published")."</span>";
                                    echo "<table align='right' style='margin-right:4px;' class='two-button-table'><tr>";
                                    echo "<td><input type='submit' class='grey' name='edit' value='Edit' /></td>";
                                    echo "<td><input type='submit' class='grey' name='delete' value='Delete' /></td>";
                                    echo "</tr></table>";
                                    echo "<hr class='manager-long-hr' />";
                                    echo "</form>";
                                    echo "</div>";
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
