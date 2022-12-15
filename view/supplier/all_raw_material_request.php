<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>All raw material requests</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Supplier </a> > All raw material requests
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Raw material Requests</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Raw material ID</b>
                            <b>Raw material name</b>
                            <b>Measuring unit</b>
                            <b>Status</b>
                            <hr />
                        </div>

                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT material_id, name, measuring_unit, manager_approval FROM raw_material";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        $class = ($row["manager_approval"]=="approve")?"green":(($row["manager_approval"]=="deny")?"red":"grey");
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='raw_material/supplier_view' />";
                                        echo "<input type='text' hidden='true' name='material_id' value='".$row["material_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["material_id"]."</span><span>".$row["name"]."</span><span style='padding-left:24px;'>".$row["measuring_unit"]."</span><span>".$row["manager_approval"]."</span>";
                                        echo "<a href=./view_raw_material_request.php?material_id=".$row["material_id"]." class='".$class."'> View </a>";
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
                            <span>White Silk-M</span>
                            <span>m</span>
                            <span>pending</span>
                            <a href="view_raw_material_request.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0002</span>
                            <span>Black Silk-L</span>
                            <span>yards</span>
                            <span>pending</span>
                            <a href="view_raw_material_request.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>Red Silk-M</span>
                            <span>yards</span>
                            <span>rejected</span>
                            <a href="#" class="red">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0004</span>
                            <span>Orange thread-XXL</span>
                            <span>reels</span>
                            <span>accepted</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0005</span>
                            <span>Blue Silk-L</span>
                            <span>m</span>
                            <span>pending</span>
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
