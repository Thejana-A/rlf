<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View raw material</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
        <?php
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }

            if(isset($_GET['data'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
                //print_r($row);
            }else{
                $sql_view_raw_material = "SELECT material_id,name,size,measuring_unit,description,image FROM raw_material WHERE material_id = ".$_GET["material_id"].";";
                $result_view_raw_material = mysqli_query($conn, $sql_view_raw_material);
                $row = mysqli_fetch_array($result_view_raw_material); 
                //print_r($row);
            }
        ?>
    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';
            require_once('../../model/DBConnection.php');?>
            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Fashion designer </a> >View raw materials 
                </div>

                <div id="form-box-small">
                <form method="post" name="rawMaterialForm" action="../RouteHandler.php" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="framework_controller" value="raw_material/view" />
                        <center>
                            <h2> Raw Material Details</h2>
                        </center>
                        
                            <div class="form-row">
                            <div class="form-row-theme">
                                Raw material ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="material_id" id="material_id" value = "<?php echo $row["material_id"];?>"readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name" value = "<?php echo $row["name"];?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                            <input type="text" name="size" id="size" value = "<?php echo $row["size"];?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring unit : 
                            </div>
                            <div class="form-row-data">
                            <input type="text" name="measuring_unit" id="measuring_unit" value = "<?php echo $row["measuring_unit"];?>" readonly />
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description :
                            </div>
                            <div class="form-row-data">
                            <input type="text" name="description" id="description" value = "<?php echo $row["description"];?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Image :
                            </div>
                            <div class="form-row-data">
                            <img src="../raw-material-image/<?php echo $row["image"]; ?>" class="design-view" />

                            </div>
                        </div>


 
                        



                            

               
                    </div>
                </div>  
                    
        <?php include 'footer.php';?>

    </body> 
</html>
