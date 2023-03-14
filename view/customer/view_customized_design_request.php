<?php
 session_start();
 error_reporting(E_ERROR |E_PARSE);
 ?>
 <?php 
    session_start();
    $sname= "localhost";
    $unmae= "root";
    $password = "";
    $db_name = "rlf";
    $conn = mysqli_connect($sname, $unmae, $password, $db_name);
    $customerID =$_SESSION["customer_id"];
    $design_id= $_GET["design_id"]; 

    $sql = "SELECT * FROM costume_design WHERE costume_design.design_id = $design_id AND costume_design.customer_id=$customerID";
    $path = mysqli_query($conn, $sql);
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);

            $propose_name = $row["name"];
            $size = $row["size"];
            $customized_design_approval = $row["customized_design_approval"];
            $front_view=$row["front_view"];
            $rear_view = $row["rear_view"];
            $left_view = $row["left_view"];
            $right_view = $row["right_view"];
            $description = $row["description"];
            
        }else {
            echo "0 results";
        } 
    }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }

?>

<!DOCTYPE html>
<head>
    <title>View Request Qutation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
    <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />

</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> >
            <a href="view_all_customized_design_request.php">View All Customized Quotation </a> > View Customized Design Quotation
        </div>
    <div id="form-box">
                        <form method="post" name="costumeDesignForm" action="../RouteHandler.php" enctype="multipart/form-data">
                            <input type="text" hidden="true" name="framework_controller" value="costume_design/customer_operation" />
                            <input type="text" hidden="true" name="home_url" value="customer/customer_home.php" />
                            <input type="text" hidden="true" name="customer_id" value="<?php echo $_SESSION["customer_id"] ?>"/>
                            <input type="text" hidden="true" name="design_id" value="<?php echo $design_id ?>"/>
                            <input type="text" hidden="true" name="name" value="<?php echo $propose_name ?>"/>
                            <input type="text" hidden="true" name="size" value="<?php echo $size?>"/>
                            

                            <center>
                                <h2>Request Customized Design</h2>
                            </center>
                            
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Proposed Name : 
                                </div>
                                <div class="form-row-data">
                                    <input type="text" name="name" id="name" value="<?php echo $propose_name?>" disabled  />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Size : 
                                </div>
                                <div class="form-row-data">
                                <select name="size[]" multiple disabled>
                                    <option value="XS" <?php echo ($size == "XS")?'selected':'' ?> >XS</option>
                                    <option value="S" <?php echo ($size == "S")?'selected':'' ?>>S</option>
                                    <option value="M" <?php echo ($size== "M")?'selected':'' ?>>M</option>
                                    <option value="L" <?php echo ($size== "L")?'selected':'' ?>>L</option>
                                    <option value="XL" <?php echo ($size== "XL")?'selected':'' ?>>XL</option>
                                    <option value="XXL" <?php echo ($size== "XXL")?'selected':'' ?>>XXL</option>
                                    
                                </select>
                                </div>
                            </div>

                            
                            
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Front view : 
                                </div>
                                <div class="form-row-data">
                                <img src="../front-view-image/<?php echo $front_view ?>"  />
                                <?php
                                if($row["customized_design_approval"] == NULL ){
                                    echo "<input type='file' name='front_view'  accept='image/png, image/gif, image/jpeg, image/tiff' />";
                                }
                                ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Rear view : 
                                </div>
                                <div class="form-row-data">
                                    <img src="../rear-view-image/<?php echo $rear_view ?>"  />
                                    <?php
                                     if($row["customized_design_approval"] == NULL ){
                                         echo "<input type='file' name='rear_view' id='rear_view' accept='image/png, image/gif, image/jpeg, image/tiff'/>";
                                     }
                                     ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Left view : 
                                </div>
                                <div class="form-row-data">
                                    <img src="../left-view-image/<?php echo $left_view ?>"  />
                                    <?php
                                     if($row["customized_design_approval"] == NULL ){
                                         echo "<input type='file' name='left_view' id='left_view' accept='image/png, image/gif, image/jpeg, image/tiff'/>";
                                     }
                                     ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Right view : 
                                </div>
                                <div class="form-row-data">
                                    <img src="../right-view-image/<?php echo $right_view ?>"  />
                                    <?php
                                     if($row["customized_design_approval"] == NULL ){
                                         echo "<input type='file' name='right_view' id='right_view' accept='image/png, image/gif, image/jpeg, image/tiff'/>";
                                     }
                                     ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Description
                                </div>
                                <div class="form-row-data">
                                    <textarea rows="4" cols="40" name="description" id="description"><?php echo $description?></textarea>
                                </div>
                            </div>

                            
                            <?php 
                            if($customized_design_approval == NULL ){
                                echo "<div class='form-row'>";
                                echo " <div class='form-row-submit'>";
                                echo "<a href='request_customized_quotation.php'>";
                                echo "<input type='submit' value='Edit' name='edit' />";
                                echo "</a>";
                                echo "</div>";
                                echo "<div class='form-row-reset'>";
                                echo "<input type='submit' value='Delete' name ='delete'/>";
                                echo "</div>";
                                echo "</div>";
                                echo "</form>";
                            }

                            if($customized_design_approval == "approve"){
                                
                                echo "<div class='form-row'  style='display: flex; justify-content: center;'>";
                                echo "<button class='Quotationbtn' onclick='view_approve_order.html'>";
                                echo "Request Quotation";
                                echo "</button>";
                                echo "</div>";
                                echo "</form>";
                            }
                            ?>

                    </div> 

    <?php include 'footer.php';?>
</body>
</html>