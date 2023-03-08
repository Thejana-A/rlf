<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>All quotation requests</title>
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
                    <a href="home.php">Supplier </a> >Quotation requests
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>All quotation requests</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Enter merchandiser name" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Request ID</b>
                            <b>Merchandiser name</b>
                            <b>Issued date</b>
                            <b>Valid till</b>

                            <hr class = "manager-long-hr" />
                        </div>
                        <?php 
                            $supplierID = $_SESSION["supplier_id"];
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = '$supplierID'";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/supplier_view' />";
                                        echo "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                                        echo "<input type='text' hidden='true' name='expected_delivery_date' value-'".$row["expected_delivery_date"]."' />";
                                        echo "<input type='text' hidden='true' name='suppler_approval'value='".$row["supplier_approval"]."' />";
                                        echo "<input type='text' hidden='true' name='approval_description' value='".$row["approval_description"]."' />";
                                        echo "<input type='text' hidden='true' name'supplier_id' value='".$row["supplier_id"]."' />";
                                        echo "<input type='text' hidden='true' name'merchandiser_id' value='".$row["merchandiser_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["quotation_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span style='padding-left:24px;'>".(($row["issue_date"])==""?"Pending":$row["issue_date"])."</span><span>".(($row["valid_till"])==""?"Pending":$row["valid_till"])."</span>";
                                        echo "<input type='submit' class='grey' name='view' value='View' />";
                                        echo "<hr class='manager-long-hr' />";
                                        echo "</form>";
                                        echo "</div>";
                                    }
                                }else {
                                    echo "0 results";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn);
                        ?>
                        <!--
                        <div class="item-data-row">
                            <span>0001</span>
                            <span>James R</span>
                            <span>2022-01-16</span>
                            <span>2022-04-08</span>
                            
                            <a href="send_quotation.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0002</span>
                            <span>James U</span>
                            <span>2022-04-16</span>
                            <span>2022-12-16</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>James P</span>
                            <span>2022-07-28</span>
                            <span>2022-12-16</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0004</span>
                            <span>James A</span>
                            <span>2022-07-16</span>
                            <span>2022-09-18</span>
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
