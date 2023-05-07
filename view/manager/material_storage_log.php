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
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit, quotation_id FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR store_action LIKE '%$searchbar%' OR measuring_unit LIKE '%$searchbar%') ORDER BY time_stamp DESC;";
                }else if(($minDate == "")&&($maxDate != "")){
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit, quotation_id FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR store_action LIKE '%$searchbar%' OR measuring_unit LIKE '%$searchbar%') AND (time_stamp <= '$maxDate 23:59:59') ORDER BY time_stamp DESC;";
                }else if(($minDate != "")&&($maxDate == "")){
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit, quotation_id FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR store_action LIKE '%$searchbar%' OR measuring_unit LIKE '%$searchbar%') AND (time_stamp >= '$minDate 00:00:00') ORDER BY time_stamp DESC;";
                }else{
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit, quotation_id FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR store_action LIKE '%$searchbar%' OR measuring_unit LIKE '%$searchbar%') AND (time_stamp BETWEEN '$minDate 00:00:00' AND '$maxDate 23:59:59') ORDER BY time_stamp DESC;";
                }
                
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='item-data-row' style='width:120%;'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/manager_view' />";
                            if($search_row["store_action"] == "store"){
                                $search_output.= "<input type='text' hidden='true' name='quotation_id' value='".$search_row["quotation_id"]."' />";
                            }
                            $search_output.= "<span style='width:15%;'>".$search_row["material_id"]."-".$search_row["name"]."</span>";
                            $search_output.= "<span style='width:12%;'>".$search_row["employee_id"]."-".$search_row["first_name"]." ".$search_row["last_name"]."</span>";
                            $search_output.= "<span style='width:12%;'>".$search_row["quantity"]." ".$search_row["measuring_unit"]." ".$search_row["supplier_last_name"]."</span>";
                            $search_output.= "<span style='width:12%;'>".explode(" ",$search_row["time_stamp"])[0]."</span>";
                            $search_output.= "<span style='width:7%;'>".$search_row["store_action"]."</span>";
                            //$output.= "<span style='width:6%;'>".$row["unit_price"]."</span>";
                            $search_output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            if($search_row["store_action"] == "store"){
                                $search_output.= "<td><input type='submit' class='grey' value='View' /></td>";
                            }
                            $search_output.= "</tr></table>";
                            $search_output.= "<hr class='manager-long-hr' />";
                            $search_output.= "</form>";
                            $search_output.= "</div>";
                            /*$search_output.= "<div class='material-price-block'>";

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
                            $search_output.= "</div>"; */
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
                            $output.= "<div class='item-data-row' style='width:120%;'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/manager_view' />";
                            if($row["store_action"] == "store"){
                                $output.= "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                            }
                            $output.= "<span style='width:15%;'>".$row["material_id"]."-".$row["name"]."</span>";
                            $output.= "<span style='width:12%;'>".$row["employee_id"]."-".$row["first_name"]." ".$row["last_name"]."</span>";
                            $output.= "<span style='width:12%;'>".$row["quantity"]." ".$row["measuring_unit"]." ".$row["supplier_last_name"]."</span>";
                            $output.= "<span style='width:12%;'>".explode(" ",$row["time_stamp"])[0]."</span>";
                            $output.= "<span style='width:7%;'>".$row["store_action"]."</span>";
                            //$output.= "<span style='width:6%;'>".$row["unit_price"]."</span>";
                            $output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            if($row["store_action"] == "store"){
                                $output.= "<td><input type='submit' class='grey' value='View' /></td>";
                            }
                            $output.= "</tr></table>";
                            $output.= "<hr class='manager-long-hr' />";
                            $output.= "</form>";
                            $output.= "</div>";
                            /*$output.= "<div class='material-price-block'>";

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
                            $output.= "</div>"; */
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
                <!--<div id="material-price-box">-->
                <div id="list-box-ultra-small">
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
                        <div class="item-heading-row" style="width:115%;margin-left:-35px;">
                            <b style="width:15%;padding-left:30px;">ID-Material</b>
                            <b style="width:12%;">ID-Merchandiser</b>
                            <b style="width:13%;">Quantity</b>
                            <b style="width:12%;">Date</b>
                            <b style="width:6%;">Action</b>
                            <!--<b style="width:5%;"></b>-->
                            <!--<hr style="width:104%;margin-left:30px;" />-->
                        </div>
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
