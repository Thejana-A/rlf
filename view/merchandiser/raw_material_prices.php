<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Raw material prices</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Merchandiser </a> > Raw material prices
                </div>
                
                <div id="material-price-box">
                    <center>
                        <h2>Raw material prices</h2>
                    </center>

                    <form method="post" action="" class="search-panel">    
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Valid till : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="" id="" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="" id="" class="date-field" />
                            </div>
                        </div>
                    </form> 
                    
                    <div class="item-list" style="width:80%;">
                        <hr style="width:120%;color:#1B3280;" />
                        <?php
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $merchandiserID = $_SESSION["employee_id"];
                            $sql = "SELECT raw_material.material_id, name, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, raw_material_quotation.quotation_id, valid_till, unit_price, request_quantity, measuring_unit FROM raw_material_quotation, employee, supplier, material_price, raw_material WHERE raw_material_quotation.quotation_id = material_price.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material.material_id = material_price.material_id AND supplier_approval = 'approve' AND raw_material_quotation.merchandiser_id = '$merchandiserID' ORDER BY valid_till DESC;";
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
                                        echo "</div>";
                                        echo "</div>";

                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Supplier ID : <input type='text' value='".$row["supplier_id"]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Supplier name : <input type='text' value='".$row["supplier_first_name"]." ".$row["supplier_last_name"]."' readonly />";
                                        echo "</div> ";
                                        echo "</div>";

                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Quotation&nbsp&nbsp : <input type='text' value='".$row["quotation_id"]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Valid till&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".$row["valid_till"]."' readonly />";
                                        echo "</div> ";
                                        echo "</div>";

                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Quantity&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".$row["request_quantity"]." ".$row["measuring_unit"]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Unit price(LKR) : <input type='text' value='".$row["unit_price"]."' readonly />";
                                        echo "</div> ";
                                        echo "</div>";

                                        echo "<hr />";
                                        echo "</div>";
                                    }
                                }else {
                                    echo "No material quotations are approved yet.";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn);
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
                                    Price(LKR)&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Quantity&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id="" />
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
