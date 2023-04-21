<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Costume designs</title>
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $search_output = "";
                $output = "";

                $search_sql_costume = "(SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id
                    WHERE (`name` LIKE '%$searchbar%' OR e1.first_name LIKE '%$searchbar%' OR e1.last_name LIKE '%$searchbar%') AND c.fashion_designer_id = ".$_SESSION['employee_id']." LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name 
                    FROM costume_design c 
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id AND `merchandiser_id` IS NULL
                    WHERE (`name` LIKE '%$searchbar%') AND c.fashion_designer_id = ".$_SESSION['employee_id']." LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id AND `fashion_designer_id` IS NULL
                    WHERE (`name` LIKE '%$searchbar%' OR e1.first_name LIKE '%$searchbar%' OR e1.last_name LIKE '%$searchbar%') AND c.fashion_designer_id = ".$_SESSION['employee_id']." LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON `merchandiser_id` IS NULL
                    JOIN employee e2 ON `fashion_designer_id` IS NULL
                    WHERE `name` LIKE '%$searchbar%' AND c.fashion_designer_id = ".$_SESSION['employee_id']." LIMIT 1);";
                    $search_result_costume_row = $conn->query($search_sql_costume);
                    if ($search_result_costume_row->num_rows > 0) {
                        while ($search_costume_row = $search_result_costume_row->fetch_assoc()) { 
                            $parts_of_name = explode('-', $search_costume_row["name"]);
                            $last = array_pop($parts_of_name);
                            $parts_of_name = array(implode('-', $parts_of_name), $last);
                            $costumeNameResult = $parts_of_name[0]; 

                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/fd_view_general_design' />";
                            $search_output.= "<input type='text' hidden='true' name='name' value='".$costumeNameResult."' />";
                            $search_output.= "<span style='width:20%;'>".$costumeNameResult."</span><span style='width:20%;'>".$search_costume_row["merchandiser_first_name"]." ".$search_costume_row["merchandiser_last_name"]."</span><span style='padding-left:25px;'><img src='../front-view-image/".$search_costume_row["front_view"]."' style='width:60px;' /><img src='../rear-view-image/".$search_costume_row["rear_view"]."' style='width:60px;' /></span>";
                            $search_output.= "<table align='right' style='margin-right:24px;' class='two-button-table'><tr>";
                            $search_output.= "<td><input type='submit' class='grey' value='View' /></td>";
                            $search_output.= "</tr></table>";
                            $search_output.= "<hr class='manager-long-hr' />";
                            $search_output.= "</form>";
                            $search_output.= "</div>";
                        }
                    }else{
                        $search_output.= "No costume designs";
                    } 
            }else{
                $search_output = "";
                $output = "";
                $sql_costume = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE fashion_designer_id = ".$_SESSION['employee_id'].";";
                $sql_costume_result = $conn->query($sql_costume);
                $costume_name = array();
                if ($sql_costume_result->num_rows > 0) {
                    while ($row = $sql_costume_result->fetch_assoc()) {
                        array_push($costume_name , $row["costume_name"]);
                    }
                }
                //print_r($costume_name);
                for($i = 0;$i<count($costume_name);$i++){
                    $sql_costume = "(SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id
                    WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name 
                    FROM costume_design c 
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id AND `merchandiser_id` IS NULL
                    WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id AND `fashion_designer_id` IS NULL
                    WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON `merchandiser_id` IS NULL
                    JOIN employee e2 ON `fashion_designer_id` IS NULL
                    WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1);";
                    $result_costume_row = $conn->query($sql_costume);
                    if ($result_costume_row->num_rows > 0) {
                        while ($costume_row = $result_costume_row->fetch_assoc()) { 
                            //$output.= $costume_name[$i]." - ".$costume_row["merchandiser_id"]." - ".$costume_row["merchandiser_first_name"]." ".$costume_row["merchandiser_last_name"]." - ".$costume_row["fashion_designer_id"]." - ".$costume_row["fd_first_name"]." ".$costume_row["fd_last_name"]." - ".$costume_row["front_view"];
                            //$output.= "<br />";   
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/fd_view_general_design' />";
                            $output.= "<input type='text' hidden='true' name='name' value='".$costume_name[$i]."' />";
                            $output.= "<span style='width:20%;'>".$costume_name[$i]."</span><span style='width:20%;'>".$costume_row["merchandiser_first_name"]." ".$costume_row["merchandiser_last_name"]."</span><span style='padding-left:25px;'><img src='../front-view-image/".$costume_row["front_view"]."' style='width:60px;' /><img src='../rear-view-image/".$costume_row["rear_view"]."' style='width:60px;' /></span>";
                            $output.= "<table align='right' style='margin-right:24px;' class='two-button-table'><tr>";
                            $output.= "<td><input type='submit' class='grey' value='View' /></td>";
                            $output.= "</tr></table>";
                            $output.= "<hr class='manager-long-hr' />";
                            $output.= "</form>";
                            $output.= "</div>";
                        }
                    }else{
                        $output.= "No costume designs";
                    }
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
                    <a href="home.php">Fashion Designer </a> > View costume designs
                </div>

                <div class="link-row">
                    <a href="add_costume_design.php" class="right-button">Add new design</a>
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Costume designs</h2>
                    </center>
                    <center>
                    <form method="post" action="view_costume_design.php" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design name</b>
                            <b>Merchandiser</b>
                            <b>Appearance</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            echo $search_output;
                            echo $output;
                            mysqli_close($conn);
                        
                        ?>
                        <?php 
                            /*require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $fashionDesignerID = $_SESSION["employee_id"];
                            //$fashionDesignerID = 19;
                            $sql = "SELECT design_id,name, size, merchandiser_id, first_name, last_name, front_view, rear_view FROM costume_design INNER JOIN employee ON employee_id = merchandiser_id WHERE fashion_designer_id = '$fashionDesignerID'
                            UNION 
                            SELECT design_id,name, size, '' AS merchandiser_id ,'' AS first_name, '' AS last_name, front_view, rear_view FROM costume_design, employee WHERE merchandiser_id IS NULL AND fashion_designer_id = '$fashionDesignerID'";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_design/fashion_designer_view' />";
                                        echo "<input type='text' hidden='true' name='design_id' value='".$row["design_id"]."' />";
                                        //echo "<span class='manager-ID-column'>".$row["design_id"]."</span><span style='padding-left:10px;'>".$row["name"]."</span><span style='padding-left:25px;'>".$row["size"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span>";
                                        echo "<span class='manager-ID-column'>".$row["design_id"]."</span><span style='padding-left:10px;'>".$row["name"]."</span><span style='padding-left:25px;'><img src='../front-view-image/".$row["front_view"]."' style='width:60px;' /><img src='../rear-view-image/".$row["rear_view"]."' style='width:60px;' /></span>";
                                        echo "<table align='right' style='margin-right:8px;'><tr>";
                                        echo "<td><input type='submit' class='grey' name='edit' value='Edit' /></td>";
                                        echo "<td><input type='submit' class='grey' name='delete' value='Delete' /></td>";
                                        echo "</tr></table>"; 
                                        echo "<hr class='manager-long-hr' />";
                                        echo "</form>";
                                        echo "</div>";
                                    }
                                }else {
                                    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNo costume designs yet";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn);*/
                        ?>
                        
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
