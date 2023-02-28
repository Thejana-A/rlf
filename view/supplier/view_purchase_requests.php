<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View purchase requests</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="index.php">Welcome </a> >
                    <a href="login.php">Login </a> >
                    <a href="home.php">Supplier </a> > Purchase requests
                </div>
                
                <div id="list-box" style="width:120%;">
                    <center>
                        <h2>View puchase requests</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Enter merchandiser name" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Purchase request ID</b>
                            <b>Merchandiser name</b>
                            <b>Expected delivery date</b>
                            <hr />
                        </div>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT order_id, first_name, last_name, expected_delivery_date, dispatch_date, raw_material_quotation.quotation_id FROM raw_material_order, supplier, raw_material_quotation WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND manager_approval = 'approve';";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='raw_material_order/supplier_view' />";
                                        echo "<input type='text' hidden='true' name='order_id' value='".$row["order_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["order_id"]."</span><span style='padding-left:24px;'>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["expected_delivery_date"]."</span>";
                                        //echo "<input type='submit' class='grey' value='View' />";
                                        echo "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                                        echo "<td><input type='submit' class='grey' value='View' /></td>";
                                        echo "</tr></table>"; 
                                        echo "<hr class='manager-long-hr' />";
                                        echo "</form>";
                                        echo "</div>";
                                    }
                                }else {
                                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No purchase requests";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn);
                        ?>
                        <!--<div class="item-data-row">
                            <span>0001</span>
                            <span>James R</span>
                            <span>2022-10-05</span>
                            <span></span>
                            <a href="accept_purchase_request.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0002</span>
                            <span>James S</span>
                            <span>2022-10-10</span>
                            <span></span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>James W</span>
                            <span>2022-10-15</span>
                            <span></span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>-->
                    
            
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
