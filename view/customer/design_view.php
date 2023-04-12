<?php 
    session_start();
    $sname= "localhost";
    $unmae= "root";
    $password = "";
    $db_name = "rlf";
    $conn = mysqli_connect($sname, $unmae, $password, $db_name);
    $view_design_id= $_GET["design_id"]; 
    $sql = "SELECT * FROM `costume_design` WHERE `design_id` = $view_design_id;";
    $path = mysqli_query($conn, $sql);
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $design_name = $row["name"];
            
        }else {
            echo "0 results";
        } 
    }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
?>

<!DOCTYPE html>
<head>
    <title>View Design</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <?php 
            if( $_SESSION["customer_id"] == NULL){
            ?>
                <a href="index_home.php">Home </a> > View Design
            <?php
            }else{
            ?>
                <a href="customer_home.php">Home </a> > View Design
            <?php
            }
            ?>
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h3><?php echo $_GET["design_name"] ?></h3>
        </div>
    </div>
    
    <div class="ViewRow">
        <div class="box" style="display: block;">
            <center>
            <?php 
                $sql = "SELECT * FROM `costume_design` WHERE `design_id` = $view_design_id;";
                $path = mysqli_query($conn, $sql);
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_array($result);

            ?>
            <div class="designimage" >

                <img src="../front-view-image/<?php echo $row["front_view"]; ?>" style="width: 30%;">

            </div>
            <div style="background-color:rgb(191, 187, 187); width: 80%; padding:5px; border-radius: 10px; opacity: 0.8; margin-bottom:10px;">
                <p>
                    <i><?php echo $row["description"]; ?></i>
                </p>
            </div>
            <?php }else {
                    echo "0 results";
                } 
                }else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }?>
              <div style="background-color:rgb(226, 94, 94)">
                <p>
                <?php 
                    if( $_SESSION["customer_id"] == NULL){
                ?>
                    <i>If you want to buy t-shirts, please signup our web site.</i>
                <?php
                    }
                ?>
                </p>
              </div>
            </center>
        </div>
        
    </div>
    <?php
    include "footer.php";
    ?>
</body>
</html>