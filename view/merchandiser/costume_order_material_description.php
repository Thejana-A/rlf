<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Raw material description</title>
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
                    <a href="#">Merchandiser </a> >
                    <a href="#">View costume designs quotations </a> > 
                    <a href="#">View</a> > Raw material description
                </div>

                <div id="form-box">
                    <center>
                        <h2>Raw material for costume quotation</h2>
                    </center>

                    <div class="item-list">
                        <center>
                            <b>Costume quotation ID - <?php echo $_GET["quotation_id"]; ?></b></br></br>
                        </center>
                        <div class="item-heading-row">
                            <b>Material ID-Name</b>
                            <b>Measuring unit</b>
                            <b>Available quantity</b>
                            <b>Deficient quantity</b>
                            <hr class="manager-long-hr" style="width:99%" />
                        </div>

                        <?php
                            $materialQuantity = [];
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql_material_type_for_costume_quotation = "SELECT DISTINCT raw_material.material_id, name, quantity_in_stock, measuring_unit FROM design_material, design_quotation, raw_material WHERE design_quotation.design_id = design_material.design_id AND design_material.material_id = raw_material.material_id AND design_quotation.quotation_id = ".$_GET["quotation_id"].";";
                            if($result = mysqli_query($conn, $sql_material_type_for_costume_quotation)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        $materialQuantity[$row["material_id"]] = [$row["material_id"], $row["name"], $row["measuring_unit"], $row["quantity_in_stock"], 0];
                                    }
                                }
                            }
                            //print_r($materialQuantity);
                            $sql_material_quantity_for_costume_quotation = "SELECT quotation_id, design_quotation.design_id, design_material.material_id, design_material.quantity AS material_quantity, design_quotation.quantity AS costume_quantity FROM design_material, design_quotation WHERE design_quotation.design_id = design_material.design_id AND design_quotation.quotation_id = ".$_GET["quotation_id"].";";
                            if($result = mysqli_query($conn, $sql_material_quantity_for_costume_quotation)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        $materialQuantity[$row["material_id"]][4] = $materialQuantity[$row["material_id"]][4] + $row["material_quantity"]*$row["costume_quantity"];
                                    }
                                }
                            } 

                            foreach($materialQuantity as $material_id => $material_quantity){
                                $deficient_quantity = (($material_quantity[4]-$material_quantity[3])>=0)?($material_quantity[4]-$material_quantity[3]):0;
                                echo "<div class='item-data-row'>";
                                echo "<form method='post' action='../RouteHandler.php'>";
                                echo "<input type='text' hidden='true' name='framework_controller' value='raw_material/merchandiser_view' />";
                                echo "<input type='text' hidden='true' name='material_id' value='".$material_id."' />";
                                echo "<span>".$material_id." - ".$material_quantity[1]."</span>";
                                echo "<span style='padding-left:10px;'>".$material_quantity[2]."</span>";
                                echo "<span>".$material_quantity[3]."</span>";
                                echo "<span>".$deficient_quantity."</span>";
                                echo "<table class='two-button-table'><tr>";
                                echo "<td><input type='submit' class='grey' name='edit' value='View' /></td>";
                                echo "</tr></table>"; 
                                echo "<hr class='manager-long-hr' style='width:99%' />";
                                echo "</form>";
                                echo "</div>";
                            }
                        ?>
    
                        <!--<div class="item-data-row">
                            <span>0001-Blue anchor button-S</span>
                            <span>Units</span>
                            <span>300</span>
                            <span>100</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div> -->
                    </div>

                </div>
            </div>
        </div>
        <?php include 'footer.php';?>

    </body>
</html>

                          