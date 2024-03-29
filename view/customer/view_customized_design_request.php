<?php require_once 'redirect_customer_login.php' ?>
<?php
 
 error_reporting(E_ERROR |E_PARSE);
 ?>
 <?php 
    
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
            $generalNameArray = explode("-",$propose_name);
            $generalName = "";
            for($i=0;$i<(count($generalNameArray)-1);$i++){
                $generalName .= $generalNameArray[$i];
            } 
            
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
            <input type="text" hidden="true" name="home_url" value="customer/view_all_customized_design_request.php" />
            <input type="text" hidden="true" name="customer_id" value="<?php echo $_SESSION["customer_id"] ?>"/>
            <input type="text" hidden="true" name="design_id" value="<?php echo $design_id ?>"/>
            <input type="text" hidden="true" name="name" value="<?php echo $_GET["design_name"] ?>"/>
        
            <center>
                <h2>Request Customized Design</h2>
            </center>
                
            <div class="form-row">
                <div class="form-row-theme">
                    Proposed Name : 
                </div>
                <div class="form-row-data">
                    <input type="text" name="name" id="name" value="<?php echo $generalName;?>" disabled  />
                </div>
            </div>

            <div class="form-row">
                <div class="form-row-theme">
                    Front view : 
                </div>
                <div class="form-row-data">
                <img src="../front-view-image/<?php echo $front_view ?>" width="30%" />
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
                    <img src="../rear-view-image/<?php echo $rear_view ?>" width="30%" />
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
                    <img src="../left-view-image/<?php echo $left_view ?>"  width="30%"/>
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
                    <img src="../right-view-image/<?php echo $right_view ?>" width="30%" />
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
                <?php
                    if($row["customized_design_approval"] == NULL ){
                        echo "<textarea rows='4' cols='40' name='description' id='description'>".$description."</textarea>";
                    }else{
                        echo "<textarea rows='4' cols='40' name='description' id='description' readonly>".$description."</textarea>";
                    }
                ?>
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
                    echo "<input type='reset' value='Cancel'/>";
                    echo "</div>";
                    echo "</div>";
                    echo "</form>";
                }

                if($customized_design_approval == "reject"){
                    echo "<p style = 'font-weight: bold; color: red; text-align: center;'>Sorry!! Your customized Design Quotation is rejected</p>";
                }

                if($customized_design_approval == "approve"){

                    /*$sql = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE customer_id=$customerID AND design_id=$design_id;";
                    $result = $conn->query($sql);
                    $costume_name = array();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            array_push($costume_name , $row["costume_name"]);
                        
                        }
                    }
                    
                    for($i = 0;$i<count($costume_name);$i++){
                        $sql_costume = "SELECT * FROM costume_design where (`name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___')  LIMIT 1;";
                        $result_costume = $conn->query($sql_costume);
                        if ($result_costume->num_rows > 0) {
                            while ($row = $result_costume->fetch_assoc()) {
                                echo "</form>";
                                echo "<input type='hidden' name='design_id'  value='".$row['design_id'].";'>";
                                echo "<div class='form-row'  style='display: flex; justify-content: center;'>";
                                echo "<button class='Quotationbtn' onclick=location.href='request_quotation.php?design_id=".$row['design_id']."&design_name=".$costume_name[$i]."'>";
                                echo "Request Quotation";
                                echo "</button>";
                                echo "</div>"; 
                                
                            }
                        }
                    }  */
                    $sql = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE customer_id=$customerID AND design_id=$design_id;";
                    $result = $conn->query($sql);
                    $costume_name = array();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            array_push($costume_name , $row["costume_name"]);
                        }
                    }

                    for ($i = 0; $i < count($costume_name); $i++) {
                        $sql_costume = "SELECT * FROM costume_design WHERE `name` LIKE ? OR `name` LIKE ? LIMIT 1;";
                        $stmt = $conn->prepare($sql_costume);
                        $stmt->bind_param("ss", $name1, $name2);
                        $name1 = $costume_name[$i] . "-_";
                        $name2 = $costume_name[$i] . "-__";
                        $stmt->execute();
                        $result_costume = $stmt->get_result();
                        if ($result_costume->num_rows > 0) {
                            while ($row = $result_costume->fetch_assoc()) {
                                $design_id = $row['design_id'];
                                echo "</form>";
                                echo "<input type='hidden' name='design_id' value='".$row['design_id']."' />";
                                echo "<div class='form-row' style='display: flex; justify-content: center;'>";
                                echo "<button class='Quotationbtn' onclick=\"location.href='request_quotation.php?design_id=".$row['design_id']."&design_name=".$costume_name[$i]."'\">";
                                echo "Request Quotation";
                                echo "</button>";
                                echo "</div>";
                            }
                        }
                    }                                   
                }
            ?>

    </div>
    <?php 
        if($customized_design_approval == NULL ){
            $sql = "SELECT * FROM `costume_design` WHERE (`name` LIKE '".$_GET["design_name"]."-_' OR `name` LIKE '".$_GET["design_name"]."-__' OR `name` LIKE '".$_GET["design_name"]."-___') AND (`publish_status` = 'publish' OR `customer_id`='".$_SESSION['customer_id']."');";
            $result = mysqli_query($conn, $sql);
  
    ?>      
            <div class="ViewRow" style="padding: 10px;">
                <div class="box" style="padding: 10px;">
                    <div class="item-list" style="width:80%;" >
                        <div class="item-heading-row" >
                            <b>Design id </b>
                            <b>Proposed Name</b>
                            <b>Size</b>                  
                            <hr />
                        </div>
                        <?php
                        if (mysqli_num_rows($result)  > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class="item-data-row">
                                <span><?php echo $row['design_id']; ?></span>
                                <span><?php echo $row['name']; ?></span>
                                <span><?php echo $row['size'];?></span>
                                <form method="post" name="costumeDesignForm" action="../RouteHandler.php">
                                    <input type="text" hidden="true" name="framework_controller" value="costume_design/customer_operation" />
                                    <input type="text" hidden="true" name="home_url" value="customer/view_all_customized_design_request.php" />
                                    <input type="text" hidden="true" name="customer_id" value="<?php echo $_SESSION["customer_id"] ?>"/>
                                    <input type="text" hidden="true" name="design_id" value="<?php echo $design_id ?>"/>
                                    <input type="text" hidden="true" name="name" value="<?php echo $_GET["design_name"] ?>"/>
                                     <input type='submit' value='Delete' name='delete' class="Quotationbtn" style='border-radius:2px; border-color:none;' onclick="return confirm('Are you sure you want to delete this item?')"/>
                                <hr/>
                                </form>
                            </div> 
                            <br/>
                        <?php
                           }
                           
                        }
                        ?>
                    </div>
                </div>
            </div>
    <?php
                            
                        
        }
    ?>            

    <?php include 'footer.php';?>
</body>
</html>