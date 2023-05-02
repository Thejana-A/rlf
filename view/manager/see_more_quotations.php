<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Related material quotations</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();

            $row = $_SESSION["row"];
            $quotation_material_list = $_SESSION["quotation_material_list"];
            
            
            $material_list_string = "";
            for($count = 0;$count < count($quotation_material_list);$count++){
                $material_list_string .= "material_price.material_id = ".$quotation_material_list[$count];
                if($count != (count($quotation_material_list)-1)){
                    $material_list_string .= " OR ";
                }
            }
            
            $merchandiser_id = ($row["employee_id"] == "")?$row["merchandiser_id"]:$row["employee_id"];
            $quotation_sql = "SELECT raw_material_quotation.quotation_id, material_price.material_id, name, raw_material_quotation.supplier_id, supplier.first_name, supplier.last_name, request_date, valid_till, measuring_unit, unit_price, supplier_approval,request_quantity FROM raw_material_quotation, supplier, raw_material, material_price WHERE raw_material_quotation.supplier_id = supplier.supplier_id AND material_price.material_id = raw_material.material_id AND raw_material_quotation.quotation_id = material_price.quotation_id AND supplier_approval = 'approve' AND raw_material_quotation.request_date = '".$row["request_date"]."' AND raw_material_quotation.merchandiser_id = ".$merchandiser_id." GROUP BY raw_material_quotation.quotation_id,material_price.material_id HAVING (".$material_list_string.");"; 
            //echo $quotation_sql;
            if($result = mysqli_query($conn, $quotation_sql)){
                $materialCount = 0;
                $output = "";
                $_SESSION["quotation_id"] = 0;
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        if($_SESSION["quotation_id"] == $row["quotation_id"]){
                            $materialCount++;
                        }else{
                            $materialCount = 1;
                            $_SESSION["quotation_id"] = $row["quotation_id"];
                            $totalPrice = 0;
                        }


                        $select_material_id = "SELECT material_id FROM material_price WHERE quotation_id = ".$row["quotation_id"].";";
                        $material_result = mysqli_query($conn, $select_material_id);
                        $material_id_array = array();
                        if(mysqli_num_rows($material_result) > 0){
                            while($material_id = mysqli_fetch_array($material_result)){
                                array_push($material_id_array, $material_id["material_id"]);
                            }
                        }
                    

                        if($material_id_array == $quotation_material_list){
                            $output.= "<div class='item-data-row' style='width:100%;'>";
                            //$output.= "<form method='post' action='../RouteHandler.php'>";
                            //$output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/manager_view' />";
                            //$output.= "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                            $output.= "<span style='width:8%;margin-left:30px;'>".$row["quotation_id"]."</span>";
                            $output.= "<span style='width:15%;'>".$row["supplier_id"]."-".$row["first_name"]." ".$row["last_name"]."</span>";
                            $output.= "<span style='width:15%;'>".$row["material_id"]."-".$row["name"].")</span>";
                            $output.= "<span style='width:10%;'>".$row["request_quantity"]." ".$row["measuring_unit"]."</span>";
                            $output.= "<span style='width:10%;'>".$row["unit_price"]."</span>";
                            $output.= "<span style='width:10%;'>".$row["valid_till"]."</span>";
                            //$output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            //$output.= "<td><input type='submit' class='grey' value='View' /></td>";
                            //$output.= "</tr></table>";
                            $output.= "<hr style='width:100%;margin-left:5px;' />";
                            $output.= "</form>";
                            $output.= "</div>";
                            $totalPrice += $row["request_quantity"]*$row["unit_price"];
                            if($materialCount == count($quotation_material_list)){
                                $output.= "<div class='item-data-row' style='width:100%;'>";
                                $output.= "<form method='post' action='../RouteHandler.php'>";
                                $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/manager_view' />";
                                $output.= "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                                $output.= "<span style='width:8%;margin-left:30px;'></span>";
                                $output.= "<span style='width:15%;'><b>Total price</b></span>";
                                $output.= "<span style='width:15%;'></span>";
                                $output.= "<span style='width:10%;'></span>";
                                $output.= "<span style='width:10%;'><b> LKR ".$totalPrice."</b></span>";
                                //$output.= "<span style='width:10%;'></span>"; 
                                $output.= "<table align='right' style='margin-right:40px;' class='two-button-table'><tr>";
                                $output.= "<td><input type='submit' class='grey' value='View' /></td>";
                                $output.= "</tr></table>";
                                $output.= "<hr style='width:100%;margin-left:5px;' />";
                                $output.= "</form>";
                                $output.= "</div>";
                            }
                        } 
                    
                    }
                    //$_SESSION["quotation_material_list"] = $quotation_material_list;
                }else {
                    $output.= "No results found";
                }
            }else{
                echo "ERROR: Could not able to execute $sql_all_material. " . mysqli_error($conn);
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
                    <a href="material_purchase_requests.php">Raw material purchase request </a> > 
                    <a href="javascript:history.back()">View</a> > More quotations
                </div>
                
                <div id="list-box-see-more">
                    <center>
                        <h2>Other material quotations</h2>
                    </center>

                    <div class="item-list">
                        <div class="item-heading-row" style="width:100%;">
                            <b style="width:8%;margin-left:20px;">Quotation ID</b>
                            <b style="width:15%;">ID-Supplier name</b>
                            <b style="width:15%;">ID-Material name</b>
                            <b style="width:10%;">Request quantity</b>
                            <b style="width:10%;">Unit price(LKR)</b>
                            <b style="width:10%;">Valid till</b>
                            <hr style="width:100%;margin-left:5px;" />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $output;
                                mysqli_close($conn); 
                            ?>
                        </div>
                        <!--<div class="item-heading-row">
                            <b>Quotation ID</b>
                            <b>ID-Supplier name</b>
                            <b>Request quantity</b>
                            <b>Unit price(LKR)</b>
                            <b>Valid till</b>
                            <hr class="manager-long-hr" />
                        </div> -->
                        
                    
                        
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
