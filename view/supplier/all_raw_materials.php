<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>All raw materials</title>
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
                    <a href="home.php">Supplier </a> > All raw materials                    
                </div>
                
                <div id="list-box-small">
                    <center>
                        <h2>All Raw Materials</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>ID</b>
                            <b>Material name</b>
                            <hr />
                        </div>

                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT material_id, name  FROM raw_material ORDER BY material_id ASC";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<span class='raw_material-ID-column'>".$row["material_id"]."</span><span>".$row["name"]."</span>";
                                        echo "<span></span>";
                                        echo "<a href=./view_raw_materials.php?material_id=".$row["material_id"]." class='grey'>View</a>";
                                        echo "<hr class='manager-long-hr' />";
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
                        <!--<div class="item-data-row">
                            <span>0001</span>
                            <span>Blue anchor button </span> 
                            <span></span>
                            <span></span>
                            <a href="view_raw_materials.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0002</span>
                            <span>Black threads</span>
                            <span></span>
                            <span></span>
                            <a href="view_raw_materials.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>White buttons</span>
                            <span></span>
                            <span></span>
                            <a href="view_raw_materials.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0004</span>
                            <span>Blue poliyester</span>
                            <span></span>
                            <span></span>
                            <a href="view_raw_materials.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0005</span>
                            <span>Red anchor button</span>
                            <span></span>
                            <span></span>
                            <a href="view_raw_materials.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>Blue threads</span>
                            <span></span>
                            <span></span>
                            <a href="view_raw_materials.php" class="grey">View</a>
                            <hr />
                        </div>-->
                    </div>


                </div>
                         
            </div> 
        
        </div>
    </div>     
        <?php include 'footer.php';?>

    </body> 
</html>
