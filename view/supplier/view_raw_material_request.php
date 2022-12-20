<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Raw material request</title>
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
                    <a href="home.php">Supplier </a> >View raw material requests 
                </div>

                <div id="form-box">
                    <form method="post"  name="rawMaterialForm" action="../RouteHandler.php" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="framework_controller" value="raw_material/update" />
                        <center>
                            <h2>View Raw material request</h2>
                        </center>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            if(isset($_GET['material_id'])){
                                $material_id = $_GET['material_id'];
                                $sql = "SELECT material_id, name, size, measuring_unit, description, image, manager_approval FROM raw_material WHERE material_ID = '$material_id' ";
                                $result = mysqli_query($conn, $sql);
                           
                                if(mysqli_num_rows($result) > 0)
                                {
                                    foreach($result as $row)
                                    {
                                        ?>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Material ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="material_id"  id="material_id" value = "<?php echo $row["material_id"];?>"readonly  />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name"value = "<?php echo $row["name"];?>" readonly />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="size" id="size"value = "<?php echo $row["size"];?>" readonly />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring Unit : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="measuring_unit" id="measuring_unit"value = "<?php echo $row["measuring_unit"];?>" readonly />
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Status (By manager) :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" <?php echo ($row["manager_approval"]=="approve")?'checked':'disabled' ?> /> Accepted
                                        </td>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" <?php echo ($row["manager_approval"]=="reject")?'checked':'disabled' ?> /> Rejected
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Acceptance description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="approval_description" id="approval_description"value = "<?php echo $row["approval_description"];?>" rows="4" cols="40" readonly ></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="description" id="description" rows="4" cols="40" readonly ><?php echo $row["description"];?></textarea>
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
                    </form>
                </div>   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
