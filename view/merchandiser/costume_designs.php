<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Costume designs</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $merchandiserID = $_SESSION["employee_id"];
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $search_sql = "SELECT design_id,name, size, fashion_designer_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = fashion_designer_id WHERE merchandiser_id = '$merchandiserID' AND (design_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR size LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%')";
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/merchandiser_view' />";
                            $search_output.= "<input type='text' hidden='true' name='design_id' value='".$search_row["design_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row["design_id"]."</span><span style='padding-left:10px;'>".$search_row["name"]."</span><span style='padding-left:25px;'>".$search_row["size"]."</span><span>".$search_row["first_name"]." ".$search_row["last_name"]."</span>";
                            $search_output.= "<table align='right' style='margin-right:18px;' class='two-button-table'><tr>";
                            $search_output.= "<td><input type='submit' class='grey' value='View' /></td>";
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
                $sql = "SELECT design_id,name, size, fashion_designer_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = fashion_designer_id WHERE merchandiser_id = '$merchandiserID';";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/merchandiser_view' />";
                            $output.= "<input type='text' hidden='true' name='design_id' value='".$row["design_id"]."' />";
                            $output.= "<span class='manager-ID-column'>".$row["design_id"]."</span><span style='padding-left:10px;'>".$row["name"]."</span><span style='padding-left:25px;'>".$row["size"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span>";
                            $output.= "<table align='right' style='margin-right:18px;' class='two-button-table'><tr>";
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
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Merchandiser </a> > View costume designs
                </div>
                
                <div id="list-box-small">
                    <center>
                        <h2>Costume designs</h2>
                    </center>
                    <center>
                        <form method="post" action="costume_designs.php" class="search-panel">  
                            <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                            <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />   
                        </form>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design ID</b>
                            <b>Design name</b>
                            <b>Size</b>
                            <b>Fashion designer</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        <?php 
                            /*require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $merchandiserID = $_SESSION["employee_id"];
                            $sql = "SELECT design_id,name, size, fashion_designer_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = fashion_designer_id WHERE merchandiser_id = '$merchandiserID'";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_design/merchandiser_view' />";
                                        echo "<input type='text' hidden='true' name='design_id' value='".$row["design_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["design_id"]."</span><span style='padding-left:10px;'>".$row["name"]."</span><span style='padding-left:25px;'>".$row["size"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span>";
                                        echo "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                                        echo "<td><input type='submit' class='grey' value='View' /></td>";
                                        echo "</tr></table>"; 
                                        echo "<hr class='manager-long-hr' />";
                                        echo "</form>";
                                        echo "</div>";
                                    }
                                }else {
                                    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNo costume designs yet.";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn);  */
                        ?>
                        <!--<div class="item-data-row">
                            <span>0003</span>
                            <span>Blue collarless T-shirt-S</span>
                            <span>S</span>
                            <span>John Doe</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>Blue collarless T-shirt-M</span>
                            <span>M</span>
                            <span>John Doe</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>  -->
                        
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
