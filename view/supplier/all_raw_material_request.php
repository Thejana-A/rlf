<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>All raw material requests</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php 
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $search_sql = "SELECT material_id, name, measuring_unit, manager_approval FROM raw_material WHERE supplier_id =  ".$_SESSION["supplier_id"]." AND (material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR measuring_unit LIKE '%$searchbar%');";
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                if(mysqli_num_rows($search_result) > 0){
                    while($search_row = mysqli_fetch_array($search_result)){
                        $class = ($search_row["manager_approval"]=="approve")?"green":(($search_row["manager_approval"]=="reject")?"red":"grey");
                        $search_output.= "<div class='item-data-row'>";
                        $search_output.= "<form method='post' action='../RouteHandler.php'>";
                        $search_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material/supplier_request_view' />";
                        $search_output.= "<input type='text' hidden='true' name='material_id' value='".$search_row["material_id"]."' />";
                        $search_output.= "<span class='manager-ID-column'>".$search_row["material_id"]."</span><span>".$search_row["name"]."</span><span style='padding-left:24px;'>".$search_row["measuring_unit"]."</span><span>".(($search_row["manager_approval"])==""?"Pending":$search_row["manager_approval"])."</span>";
                        $search_output.= "<table align='right' style='margin-right:80px;' class='two-button-table'><tr>";
                        $search_output.= "</tr></table>"; 
                        $search_output.= "<input type='submit' class='".$class."' value='View' />";
                        $search_output.= "<hr class='manager-long-hr' />";
                        $search_output.= "</form>";
                        $search_output.= "</div>";
                    }
                }else {
                    $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
                }
            }
        }else{
            $sql = "SELECT material_id, name, measuring_unit, manager_approval FROM raw_material WHERE supplier_id =  ".$_SESSION["supplier_id"].";";
            $search_output = "";
            $output = "";
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        $class = ($row["manager_approval"]=="approve")?"green":(($row["manager_approval"]=="reject")?"red":"grey");
                        $output.= "<div class='item-data-row'>";
                        $output.= "<form method='post' action='../RouteHandler.php'>";
                        $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material/supplier_request_view' />";
                        $output.= "<input type='text' hidden='true' name='material_id' value='".$row["material_id"]."' />";
                        $output.= "<span class='manager-ID-column'>".$row["material_id"]."</span><span>".$row["name"]."</span><span style='padding-left:24px;'>".$row["measuring_unit"]."</span><span>".(($row["manager_approval"])==""?"Pending":$row["manager_approval"])."</span>";
                        $output.= "<table align='right' style='margin-right:80px;' class='two-button-table'><tr>";
                        $output.= "</tr></table>"; 
                        $output.= "<input type='submit' class='".$class."' value='View' />";
                        $output.= "<hr class='manager-long-hr' />";
                        $output.= "</form>";
                        $output.= "</div>";
                    }
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
        }
    ?>
</head>
    
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

                    <form method="post" action="all_raw_material_request.php" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" name="search" /><br />
                        
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Raw material ID</b>
                            <b>Raw material name</b>
                            <b>Measuring unit</b>
                            <b>Status</b>
                            <hr />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>

                        
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
