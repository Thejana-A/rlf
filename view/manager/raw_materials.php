<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Raw materials</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $search_sql = "SELECT material_id, name, measuring_unit, quantity_in_stock, manager_approval FROM raw_material WHERE material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR measuring_unit LIKE '%$searchbar%'";
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $class = ($search_row["manager_approval"]=="approve")?"green":(($search_row["manager_approval"]=="reject")?"red":"grey");
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material/manager_view' />";
                            $search_output.= "<input type='text' hidden='true' name='material_id' value='".$search_row["material_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row["material_id"]."</span><span>".$search_row["name"]."</span><span style='padding-left:20px;'>".$search_row["measuring_unit"]."</span><span>".$search_row["quantity_in_stock"]."</span>";
                            $search_output.= "<table class='two-button-table'><tr>";
                            $search_output.= "<td><input type='submit' class='".$class."' name='edit' value='Edit' /></td>";
                            $search_output.= "<td><input type='submit' class='".$class."' name='delete' value='Delete' /></td>";
                            $search_output.= "</tr></table>"; 
                            $search_output.= "<hr class='manager-long-hr' />";
                            $search_output.= "</form>";
                            $search_output.= "</div>";
                        }   
                    }else{
                        $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
                    }
                }
            }else{
                $sql = "SELECT material_id, name, measuring_unit, quantity_in_stock, manager_approval FROM raw_material";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $class = ($row["manager_approval"]=="approve")?"green":(($row["manager_approval"]=="reject")?"red":"grey");
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material/manager_view' />";
                            $output.= "<input type='text' hidden='true' name='material_id' value='".$row["material_id"]."' />";
                            $output.= "<span class='manager-ID-column'>".$row["material_id"]."</span><span>".$row["name"]."</span><span style='padding-left:20px;'>".$row["measuring_unit"]."</span><span>".$row["quantity_in_stock"]."</span>";
                            $output.= "<table class='two-button-table'><tr>";
                            $output.= "<td><input type='submit' class='".$class."' name='edit' value='Edit' /></td>";
                            $output.= "<td><input type='submit' class='".$class."' name='delete' value='Delete' /></td>";
                            $output.= "</tr></table>"; 
                            $output.= "<hr class='manager-long-hr' />";
                            $output.= "</form>";
                            $output.= "</div>";
                        }
                    }else {
                        $output.= "0 results";
                    }
                }else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }
            }
        ?>
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Manager</a> > View raw materials
                </div>
                <div class="link-row">
                    <a href="./material_storage_log.php" class="left-button">Material storage log</a>
                    <a href="./add_raw_material.php" class="right-button">Add new raw material</a>
                </div>
                <div id="list-box">
                    <center>
                        <h2>Raw materials</h2>
                    </center>

                    <form method="post" action="raw_materials.php" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" name="search" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Material ID</b>
                            <b>Material name</b>
                            <b>Measuring unit</b>
                            <b>Available quantity</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        <!--<div class="item-data-row">
                            <span>0003</span>
                            <span>Blue thread-S</span>
                            <span>reels</span>
                            <span>0</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>Black poplyn-M</span>
                            <span>m</span>
                            <span>25</span>
                            <a href="#" class="green">Edit</a>
                            <a href="#" class="green">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0010</span>
                            <span>Blue anchor button-L</span>
                            <span>units</span>
                            <span>500</span>
                            <a href="#" class="green">Edit</a>
                            <a href="#" class="green">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0011</span>
                            <span>Blue anchor button-M</span>
                            <span>units</span>
                            <span>200</span>
                            <a href="#" class="green">Edit</a>
                            <a href="#" class="green">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0026</span>
                            <span>White raw clothe-S</span>
                            <span>m</span>
                            <span>0</span>
                            <a href="#" class="red">Edit</a>
                            <a href="#" class="red">Delete</a>
                            <hr class="manager-long-hr" />
                        </div> -->
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
