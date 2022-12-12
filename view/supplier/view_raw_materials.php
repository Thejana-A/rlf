<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View raw material</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';
            require_once('../../model/DBConnection.php');?>
            <div id="page-content">
                <div id="breadcrumb">
                    <a href="index.php">Welcome </a> >
                    <a href="login.php">Login </a> >
                    <a href="home.php">Supplier </a> >View raw materials 
                </div>

                <div id="form-box-small">
                <form method="post" name="rawMaterialForm" action="../RouteHandler.php" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="framework_controller" value="raw_material/view" />
                        <center>
                            <h2> Raw material details</h2>
                        </center>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            if(isset($_GET['material_id'])){
                                $material_id = $_GET['material_id'];
                                $sql = "SELECT material_id, name, size, measuring_unit, description, image FROM raw_material WHERE material_ID = '$material_id' ";
                                $result = mysqli_query($conn, $sql);
                           
                                if(mysqli_num_rows($result) > 0)
                                {
                                    foreach($result as $row)
                                    {
                                        ?>
                            <div class="form-row">
                            <div class="form-row-theme">
                                Raw material ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="material_id" id="material_id" value = "<?php echo $row["material_id"];?>"disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name"value = "<?php echo $row["name"];?>" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                            <input type="text" name="size" id="size"value = "<?php echo $row["size"];?>" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring unit : 
                            </div>
                            <div class="form-row-data">
                            <input type="text" name="measuring_unit" id="measuring_unit"value = "<?php echo $row["measuring_unit"];?>" disabled />
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description :
                            </div>
                            <div class="form-row-data">
                            <input type="text" name="description" id="description"value = "<?php echo $row["description"];?>" disabled />
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


 
                        



                            <?php                                   
                                    }
                                }
                                else {
                                    echo "0 results";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn);
                        ?>
                        <?php

                        ?>
               
                    </div>
                </div>  
                    
        <?php include 'footer.php';?>

    </body> 
</html>
