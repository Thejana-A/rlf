<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View costume design</title>
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/view_list_style.css" />
        <?php   

            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }

            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['name'])){ 
                
                $designName = $_GET['name'];
                $sql = "SELECT * FROM costume_design WHERE `name` LIKE '$designName-_' OR `name` LIKE '$designName-__' OR `name` LIKE '$designName-___' LIMIT 1;";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    //print_r($row);
                } else {
                    echo "0 results";
                }
            }
    
        ?>
            
    </head>

    <body onLoad="setOriginalPrice()">
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Fashion Designer </a> >
                    <a href="view_costume_design">View costume design </a> > View
                </div>

                <div class="link-row" style="margin-left:-15%;">
                    <a href="new_design_size.php?name=<?php echo $designName ?>" class="right-button">Add new size</a>
                </div><br />

                <div id="form-box-ultra-small">
                    <form method="post" action="../RouteHandler.php" enctype="multipart/form-data">
                        <input type="text" hidden="true" name="framework_controller" value="costume_design/update" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <input type="text" hidden="true" name="customized_design_approval" value="<?php echo $row["customized_design_approval"] ?>" />
                        <input type="text" hidden="true" name="design_approval_date" value="<?php echo $row["design_approval_date"] ?>" />
                        <input type="text" hidden="true" name="design_approval_description" value="<?php echo $row["design_approval_description"] ?>" />
                        <input type="text" hidden="true" name="fashion_designer_id" value="<?php echo $row["fashion_designer_id"] ?>" />
                        <center>
                            <h2>Edit costume design</h2>
                        </center>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Design name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" value="<?php echo $designName; ?>" required readonly />
                            </div>
                        </div>

                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                Raw materials : 
                            </div>
                            <div class="form-row-data">
                                <select name="material_id" id="material_id" multiple size="2">
                                    <option disabled>ID - Material name</option>
                                    <option>0004 - Black Thread-S</option>
                                    <option>0014 - Blue Thread-S</option>
                                    <option>0022 - Red anchor button-L</option>
                                </select>
                            </div>
                        </div> -->

                        <div class="form-row">
                            <div class="form-row-theme">
                                Appearance :
                            </div>
                            <div class="form-row-data">
                                <img src="../front-view-image/<?php echo $row["front_view"]; ?>" alt="front-view" class="design-view" />
                                <img src="../rear-view-image/<?php echo $row["rear_view"]; ?>" alt="rear-view" class="design-view" /><br />
                                <img src="../left-view-image/<?php echo $row["left_view"]; ?>" alt="left-view" class="design-view" />
                                <img src="../right-view-image/<?php echo $row["right_view"]; ?>" alt="right-view" class="design-view" /> 
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Front view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="front_view" id="front_view" accept="image/png, image/gif, image/jpeg, image/tiff" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Rear view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="rear_view" id="rear_view" accept="image/png, image/gif, image/jpeg, image/tiff" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Left view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="left_view" id="left_view" accept="image/png, image/gif, image/jpeg, image/tiff" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Right view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="right_view" id="right_view" accept="image/png, image/gif, image/jpeg, image/tiff" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description
                            </div>
                            <div class="form-row-data">
                                <textarea rows="4" cols="40" name="description" id="description" required><?php echo $row["description"]; ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> 
                    </form>
                </div>   

                <div id="list-box">
                    <center>
                        <h2>Available sizes</h2>
                    </center>


                    <div class="item-list">
                        <div class="item-heading-row">
                            <b class='manager-ID-column'>Design ID</b>
                            <b>Design name</b>
                            <b style="width:10%;">Size</b>
                            <b>Publish status</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            $sql_costume = "SELECT design_id, name, size, publish_status from costume_design WHERE `name` LIKE '$designName-_' OR `name` LIKE '$designName-__' OR `name` LIKE '$designName-___'";
                            $result_costume_row = $conn->query($sql_costume);
                            if ($result_costume_row->num_rows > 0) {
                                while ($costume_row = $result_costume_row->fetch_assoc()) {   
                                    echo "<div class='item-data-row'>";
                                    echo "<form method='post' action='../RouteHandler.php'>";
                                    echo "<input type='text' hidden='true' name='framework_controller' value='costume_design/fashion_designer_view' />";
                                    echo "<input type='text' hidden='true' name='design_id' value='".$costume_row["design_id"]."' />";
                                    echo "<span class='manager-ID-column'>".$costume_row["design_id"]."</span><span>".$costume_row["name"]."</span><span style='width:12%;'>".$costume_row["size"]."</span><span>".(($costume_row["publish_status"]=="publish")?"Published":"Not published")."</span>";
                                    echo "<table align='right' style='margin-right:4px;' class='two-button-table'><tr>";
                                    echo "<td><input type='submit' class='grey' name='edit' value='Edit' /></td>";
                                    echo "<td><input type='submit' class='grey' name='delete' value='Delete' /></td>";
                                    echo "</tr></table>";
                                    echo "<hr class='manager-long-hr' />";
                                    echo "</form>";
                                    echo "</div>";
                                }
                            }else{
                                $output.= "No costume designs";
                            }
                            mysqli_close($conn);
                        
                        ?>
                        <!--<div class="item-data-row">
                            <span class="manager-ID-column">0003</span>
                            <span>Black long-sleeve-XL</span>
                            <span>John Doe</span>
                            <span>Harry A</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span class="manager-ID-column">0010</span>
                            <span>Green chinese collar-S</span>
                            <span>John B</span>
                            <span>Harry C</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div> -->
                    </div>


                </div>
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
