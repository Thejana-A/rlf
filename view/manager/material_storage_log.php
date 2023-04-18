<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Material storage log</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $minDate = $_POST["min_date"];
                $maxDate = $_POST["max_date"];
                if(($minDate == "")&&($maxDate == "")){
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit, quotation_id FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR store_action LIKE '%$searchbar%') ORDER BY time_stamp DESC;";
                }else if(($minDate == "")&&($maxDate != "")){
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit, quotation_id FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR store_action LIKE '%$searchbar%') AND (time_stamp <= '$maxDate') ORDER BY time_stamp DESC;";
                }else if(($minDate != "")&&($maxDate == "")){
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit, quotation_id FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR store_action LIKE '%$searchbar%') AND (time_stamp >= '$minDate') ORDER BY time_stamp DESC;";
                }else{
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit, quotation_id FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR store_action LIKE '%$searchbar%') AND (time_stamp BETWEEN '$minDate' AND '$maxDate') ORDER BY time_stamp DESC;";
                }
                
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='material-price-block'>";

                            $search_output.= "<div class='material-price-row'>";
                            $search_output.= "<div class='material-price-left'>";
                            $search_output.= "Material ID : <input type='text' value='".$search_row["material_id"]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "<div class='material-price-right'>";
                            $search_output.= "Material name : <input type='text' value='".$search_row["name"]."' readonly />";
                            $search_output.= "</div>  ";
                            $search_output.= "</div>";

                            $search_output.= "<div class='material-price-row'>";
                            $search_output.= "<div class='material-price-left'>";
                            $search_output.= "Merch. ID&nbsp&nbsp : <input type='text' value='".$search_row["employee_id"]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "<div class='material-price-right'>";
                            $search_output.= "Merch. name&nbsp&nbsp : <input type='text' value='".$search_row["first_name"]." ".$search_row["last_name"]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "</div>";

                            $search_output.= "<div class='material-price-row'>";
                            $search_output.= "<div class='material-price-left'>";
                            $search_output.= "Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".explode(" ",$search_row["time_stamp"])[0]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "<div class='material-price-right'>";
                            $search_output.= "Store/ retrieve : <input type='text' value='".$search_row["store_action"]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "</div>";

                            $search_output.= "<div class='material-price-row'>";
                            $search_output.= "<div class='material-price-left'>";
                            $search_output.= "Quantity&nbsp&nbsp&nbsp : <input type='text' value='".$search_row["quantity"]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "<div class='material-price-right'>";
                            $search_output.= "Unit&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".$search_row["measuring_unit"]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "</div>";
                            if($search_row["store_action"] == "store"){
                                $search_output.= "&nbsp&nbsp&nbsp&nbsp&nbsp<a href='view_material_quotation.php?quotation_id=".$search_row["quotation_id"]."' style='text-decoration:none;'>View quotation</a>";
                            }
                        
                            $search_output.= "<hr />";
                            $search_output.= "</div>";
                        }   
                    }else{
                        $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
                    }
                }
            }else{
                $sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit, quotation_id FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id ORDER BY time_stamp DESC;";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $output.= "<div class='material-price-block'>";

                            $output.= "<div class='material-price-row'>";
                            $output.= "<div class='material-price-left'>";
                            $output.= "Material ID : <input type='text' value='".$row["material_id"]."' readonly />";
                            $output.= "</div>";
                            $output.= "<div class='material-price-right'>";
                            $output.= "Material name : <input type='text' value='".$row["name"]."' readonly />";
                            $output.= "</div>  ";
                            $output.= "</div>";

                            $output.= "<div class='material-price-row'>";
                            $output.= "<div class='material-price-left'>";
                            $output.= "Merch. ID&nbsp&nbsp : <input type='text' value='".$row["employee_id"]."' readonly />";
                            $output.= "</div>";
                            $output.= "<div class='material-price-right'>";
                            $output.= "Merch. name&nbsp&nbsp : <input type='text' value='".$row["first_name"]." ".$row["last_name"]."' readonly />";
                            $output.= "</div>";
                            $output.= "</div>";

                            $output.= "<div class='material-price-row'>";
                            $output.= "<div class='material-price-left'>";
                            $output.= "Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".explode(" ",$row["time_stamp"])[0]."' readonly />";
                            $output.= "</div>";
                            $output.= "<div class='material-price-right'>";
                            $output.= "Store/ retrieve : <input type='text' value='".$row["store_action"]."' readonly />";
                            $output.= "</div>";
                            $output.= "</div>";

                            $output.= "<div class='material-price-row'>";
                            $output.= "<div class='material-price-left'>";
                            $output.= "Quantity&nbsp&nbsp&nbsp : <input type='text' value='".$row["quantity"]."' readonly />";
                            $output.= "</div>";
                            $output.= "<div class='material-price-right'>";
                            $output.= "Unit&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".$row["measuring_unit"]."' readonly />";
                            $output.= "</div>";
                            $output.= "</div>";
                            if($row["store_action"] == "store"){
                                $output.= "&nbsp&nbsp&nbsp&nbsp&nbsp<a href='view_material_quotation.php?quotation_id=".$row["quotation_id"]."' style='text-decoration:none;'>View quotation</a>";
                            }
                            $output.= "<hr />";
                            $output.= "</div>";
                        }
                    }else {
                        $output.= "0 results";
                    }
                }else{
                    $output.= "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }
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
                    <a href="home.php">Manager</a> >
                    <a href="raw_materials.php">View raw materials </a> > Material storage log
                </div>
                <div id="material-price-box">
                    <center>
                        <h2>Material storage log</h2>
                    </center>

                    <form method="post" action="material_storage_log.php" class="search-panel">    
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Date of action : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_date" id="min_date" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_date" id="max_date" class="date-field" />
                            </div>
                        </div>
                    </form> 
                    
                    <div class="item-list" style="width:80%;">
                        <hr style="width:120%;color:#1B3280;" />
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        <?php /*
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id ORDER BY time_stamp DESC;";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='material-price-block'>";
                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Material ID : <input type='text' value='".$row["material_id"]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Material name : <input type='text' value='".$row["name"]."' readonly />";
                                        echo "</div>  ";
                                        echo "</div>";
                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Merch. ID&nbsp&nbsp : <input type='text' value='".$row["employee_id"]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Merch. name&nbsp&nbsp : <input type='text' value='".$row["first_name"]." ".$row["last_name"]."' readonly />";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".explode(" ",$row["time_stamp"])[0]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Store/ retrieve : <input type='text' value='".$row["store_action"]."' readonly />";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Quantity&nbsp&nbsp&nbsp : <input type='text' value='".$row["quantity"]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Unit&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".$row["measuring_unit"]."' readonly />";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<hr />";
                                        echo "</div>";
                                    }
                                }else {
                                    $search_output.= "0 results";
                                }
                            }else{
                                $search_output.= "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn); */
                        ?>

                        <!--<div class="material-price-block">
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Material ID : <input type="text" name="" id="" />
                                </div>
                                <div class="material-price-right">
                                    Material name : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Merch. ID&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Merch. name&nbsp&nbsp : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Store/ retrieve : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Quantity&nbsp&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Unit&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <hr />
                        </div>

                        <div class="material-price-block">
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Material ID : <input type="text" name="" id="" />
                                </div>
                                <div class="material-price-right">
                                    Material name : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Merch. ID&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Merch. name&nbsp&nbsp : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Store/ retrieve : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Quantity&nbsp&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Unit&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <hr />
                        </div> -->


                    </div>
                </div> 


            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
