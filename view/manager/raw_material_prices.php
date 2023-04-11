<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Raw material prices</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $minValidTill = $_POST["min_valid_till"];
                $maxValidTill = $_POST["max_valid_till"];
                if(($minValidTill == "")&&($maxValidTill == "")){
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, raw_material_quotation.quotation_id, valid_till, unit_price, request_quantity, measuring_unit FROM raw_material_quotation, employee, supplier, material_price, raw_material WHERE raw_material_quotation.quotation_id = material_price.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material.material_id = material_price.material_id AND supplier_approval = 'approve' AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR employee.first_name LIKE '%$searchbar%' OR employee.last_name LIKE '%$searchbar%' OR supplier.first_name LIKE '%$searchbar%' OR supplier.last_name LIKE '%$searchbar%') ORDER BY valid_till DESC";
                }else if(($minValidTill == "")&&($maxValidTill != "")){
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, raw_material_quotation.quotation_id, valid_till, unit_price, request_quantity, measuring_unit FROM raw_material_quotation, employee, supplier, material_price, raw_material WHERE raw_material_quotation.quotation_id = material_price.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material.material_id = material_price.material_id AND supplier_approval = 'approve' AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR employee.first_name LIKE '%$searchbar%' OR employee.last_name LIKE '%$searchbar%' OR supplier.first_name LIKE '%$searchbar%' OR supplier.last_name LIKE '%$searchbar%') AND (valid_till <= '$maxValidTill') ORDER BY valid_till DESC";
                }else if(($minValidTill != "")&&($maxValidTill == "")){
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, raw_material_quotation.quotation_id, valid_till, unit_price, request_quantity, measuring_unit FROM raw_material_quotation, employee, supplier, material_price, raw_material WHERE raw_material_quotation.quotation_id = material_price.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material.material_id = material_price.material_id AND supplier_approval = 'approve' AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR employee.first_name LIKE '%$searchbar%' OR employee.last_name LIKE '%$searchbar%' OR supplier.first_name LIKE '%$searchbar%' OR supplier.last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill') ORDER BY valid_till DESC";
                }else{
                    $search_sql = "SELECT raw_material.material_id, name, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, raw_material_quotation.quotation_id, valid_till, unit_price, request_quantity, measuring_unit FROM raw_material_quotation, employee, supplier, material_price, raw_material WHERE raw_material_quotation.quotation_id = material_price.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material.material_id = material_price.material_id AND supplier_approval = 'approve' AND (raw_material.material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR employee.first_name LIKE '%$searchbar%' OR employee.last_name LIKE '%$searchbar%' OR supplier.first_name LIKE '%$searchbar%' OR supplier.last_name LIKE '%$searchbar%') AND (valid_till BETWEEN '$minValidTill' AND '$maxValidTill') ORDER BY valid_till DESC";
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
                            $search_output.= "</div>";
                            $search_output.= "</div>";
                            
                            $search_output.= "<div class='material-price-row'>";
                            $search_output.= "<div class='material-price-left'>";
                            $search_output.= "Merch. ID&nbsp&nbsp : <input type='text' value='".$search_row["employee_id"]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "<div class='material-price-right'>";
                            $search_output.= "Merch. name&nbsp&nbsp : <input type='text' value='".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."' readonly />";
                            $search_output.= "</div> ";
                            $search_output.= "</div>";

                            $search_output.= "<div class='material-price-row'>";
                            $search_output.= "<div class='material-price-left'>";
                            $search_output.= "Supplier ID : <input type='text' value='".$search_row["supplier_id"]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "<div class='material-price-right'>";
                            $search_output.= "Supplier name : <input type='text' value='".$search_row["supplier_first_name"]." ".$search_row["supplier_last_name"]."' readonly />";
                            $search_output.= "</div> ";
                            $search_output.= "</div>";

                            $search_output.= "<div class='material-price-row'>";
                            $search_output.= "<div class='material-price-left'>";
                            $search_output.= "Quotation&nbsp&nbsp : <input type='text' value='".$search_row["quotation_id"]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "<div class='material-price-right'>";
                            $search_output.= "Valid till&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".$search_row["valid_till"]."' readonly />";
                            $search_output.= "</div> ";
                            $search_output.= "</div>";

                            $search_output.= "<div class='material-price-row'>";
                            $search_output.= "<div class='material-price-left'>";
                            $search_output.= "Quantity&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".$search_row["request_quantity"]." ".$row["measuring_unit"]."' readonly />";
                            $search_output.= "</div>";
                            $search_output.= "<div class='material-price-right'>";
                            $search_output.= "Unit price(LKR) : <input type='text' value='".$search_row["unit_price"]."' readonly />";
                            $search_output.= "</div> ";
                            $search_output.= "</div>";

                            $search_output.= "<hr />";
                            $search_output.= "</div>";
                        }   
                    }else{
                        $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
                    }
                }
            }else{
                $sql = "SELECT raw_material.material_id, name, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, raw_material_quotation.quotation_id, valid_till, unit_price, request_quantity, measuring_unit FROM raw_material_quotation, employee, supplier, material_price, raw_material WHERE raw_material_quotation.quotation_id = material_price.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material.material_id = material_price.material_id AND supplier_approval = 'approve' ORDER BY valid_till DESC;";
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
                            $output.= "</div>";
                            $output.= "</div>";
                            
                            $output.= "<div class='material-price-row'>";
                            $output.= "<div class='material-price-left'>";
                            $output.= "Merch. ID&nbsp&nbsp : <input type='text' value='".$row["employee_id"]."' readonly />";
                            $output.= "</div>";
                            $output.= "<div class='material-price-right'>";
                            $output.= "Merch. name&nbsp&nbsp : <input type='text' value='".$row["merchandiser_first_name"]." ".$row["merchandiser_last_name"]."' readonly />";
                            $output.= "</div> ";
                            $output.= "</div>";

                            $output.= "<div class='material-price-row'>";
                            $output.= "<div class='material-price-left'>";
                            $output.= "Supplier ID : <input type='text' value='".$row["supplier_id"]."' readonly />";
                            $output.= "</div>";
                            $output.= "<div class='material-price-right'>";
                            $output.= "Supplier name : <input type='text' value='".$row["supplier_first_name"]." ".$row["supplier_last_name"]."' readonly />";
                            $output.= "</div> ";
                            $output.= "</div>";

                            $output.= "<div class='material-price-row'>";
                            $output.= "<div class='material-price-left'>";
                            $output.= "Quotation&nbsp&nbsp : <input type='text' value='".$row["quotation_id"]."' readonly />";
                            $output.= "</div>";
                            $output.= "<div class='material-price-right'>";
                            $output.= "Valid till&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".$row["valid_till"]."' readonly />";
                            $output.= "</div> ";
                            $output.= "</div>";

                            $output.= "<div class='material-price-row'>";
                            $output.= "<div class='material-price-left'>";
                            $output.= "Quantity&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".$row["request_quantity"]." ".$row["measuring_unit"]."' readonly />";
                            $output.= "</div>";
                            $output.= "<div class='material-price-right'>";
                            $output.= "Unit price(LKR) : <input type='text' value='".$row["unit_price"]."' readonly />";
                            $output.= "</div> ";
                            $output.= "</div>";

                            $output.= "<hr />";
                            $output.= "</div>";
                        }
                    }else {
                        $output.= "0 results";
                    }
                }else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
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
                    Manager > Raw material prices
                </div>
                
                <div id="material-price-box">
                    <center>
                        <h2>Raw material prices</h2>
                    </center>

                    <form method="post" action="raw_material_prices.php" class="search-panel">    
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Valid till : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_valid_till" id="min_valid_till" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_valid_till" id="max_valid_till" class="date-field" />
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
                                    Supplier ID : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Supplier name : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Quotation&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Valid till&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Quantity&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Unit price(LKR) : <input type="text" name="" id="" />
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
                                    Supplier ID : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Supplier name : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Quotation&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Valid till&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Quantity&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Unit price(LKR) : <input type="text" name="" id="" />
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
