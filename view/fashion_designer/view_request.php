<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Requests</title>
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/view_list_style.css" />
        <?php 
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $search_sql = "SELECT material_id, name, measuring_unit FROM raw_material WHERE fashion_designer_id = ".$_SESSION["employee_id"]." AND (material_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR measuring_unit LIKE '%$searchbar%')";
                $serach_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material/fashion_designer_request_view' />";
                            $search_output.= "<input type='text' hidden='true' name='material_id' value='".$search_row["material_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row["material_id"]."</span><span>".$search_row["name"]."</span><span style='padding-left:24px;'>".$search_row["measuring_unit"]."</span>";
                            $search_output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            $search_output.= "<td><input type='submit' class='grey' value='View' /></td>";
                            $search_output.= "</tr></table>"; 
                            $search_output.= "<hr class='manager-long-hr' />";
                            $search_output.= "</form>";
                            $search_output.= "</div>";
                    }
                }else {
                    $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
                    }
                } 
            }else{
                    $sql = "SELECT material_id, name, measuring_unit FROM raw_material WHERE fashion_designer_id = ".$_SESSION["employee_id"].";";
                    $serach_output = "";
                    $output = "";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                                $output.= "<div class='item-data-row'>";
                                $output.= "<form method='post' action='../RouteHandler.php'>";
                                $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material/fashion_designer_request_view' />";
                                $output.= "<input type='text' hidden='true' name='material_id' value='".$row["material_id"]."' />";
                                $output.= "<span class='manager-ID-column'>".$row["material_id"]."</span><span>".$row["name"]."</span><span style='padding-left:24px;'>".$row["measuring_unit"]."</span>";
                                $output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                                $output.= "<td><input type='submit' class='grey' value='View' /></td>";
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
            
            <?php include 'leftnav.php';
            require_once('../../model/DBConnection.php');?>
            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Fashion Designer</a> >View Requests 
                </div>

                <div id="list-box">
                    <center>
                        <h2>Request</h2>
                    </center>
                    <center>
                        <form method="post" action="view_request.php" class="search-panel">    
                            <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                            <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        </form>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Material ID</b>
                            <b>Material name</b>
                            <b>Measuring unit</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        
                        
                    </div>
                </div>

                </div>            
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
