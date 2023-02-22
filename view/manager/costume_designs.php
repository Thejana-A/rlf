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
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $search_output = "";
                $output = "";

                $search_sql_costume = "(SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id
                    WHERE `name` LIKE '%$searchbar%' OR e1.first_name LIKE '%$searchbar%' OR e1.last_name LIKE '%$searchbar%' OR e2.first_name LIKE '%$searchbar%' OR e2.last_name LIKE '%$searchbar%' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name 
                    FROM costume_design c 
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id AND `merchandiser_id` IS NULL
                    WHERE `name` LIKE '%$searchbar%' OR e2.first_name LIKE '%$searchbar%' OR e2.last_name LIKE '%$searchbar%' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id AND `fashion_designer_id` IS NULL
                    WHERE `name` LIKE '%$searchbar%' OR e1.first_name LIKE '%$searchbar%' OR e1.last_name LIKE '%$searchbar%' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON `merchandiser_id` IS NULL
                    JOIN employee e2 ON `fashion_designer_id` IS NULL
                    WHERE `name` LIKE '%$searchbar%' LIMIT 1);";
                    $search_result_costume_row = $conn->query($search_sql_costume);
                    if ($search_result_costume_row->num_rows > 0) {
                        while ($search_costume_row = $search_result_costume_row->fetch_assoc()) { 
                            $parts_of_name = explode('-', $search_costume_row["name"]);
                            $last = array_pop($parts_of_name);
                            $parts_of_name = array(implode('-', $parts_of_name), $last);
                            $costumeNameResult = $parts_of_name[0]; 

                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view_general_design' />";
                            $search_output.= "<input type='text' hidden='true' name='name' value='".$costumeNameResult."' />";
                            $search_output.= "<span style='width:20%;'>".$costumeNameResult."</span><span style='width:20%;'>".$search_costume_row["merchandiser_first_name"]." ".$search_costume_row["merchandiser_last_name"]."</span><span style='width:30%;'>".$search_costume_row["fd_first_name"]." ".$search_costume_row["fd_last_name"]."</span>";
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
                $sql_costume = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE customized_design_approval = 'approve';";
                $sql_costume_result = $conn->query($sql_costume);
                $costume_name = array();
                if ($sql_costume_result->num_rows > 0) {
                    while ($row = $sql_costume_result->fetch_assoc()) {
                        array_push($costume_name , $row["costume_name"]);
                    }
                }
                //print_r($costume_name);
                for($i = 0;$i<count($costume_name);$i++){
                    $sql_costume = "(SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id
                    WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name 
                    FROM costume_design c 
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id AND `merchandiser_id` IS NULL
                    WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id AND `fashion_designer_id` IS NULL
                    WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name 
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
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view_general_design' />";
                            $output.= "<input type='text' hidden='true' name='name' value='".$costume_name[$i]."' />";
                            $output.= "<span style='width:20%;'>".$costume_name[$i]."</span><span style='width:20%;'>".$costume_row["merchandiser_first_name"]." ".$costume_row["merchandiser_last_name"]."</span><span style='width:30%;'>".$costume_row["fd_first_name"]." ".$costume_row["fd_last_name"]."</span>";
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
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Manager </a> > View costume designs
                </div>
                <div class="link-row-small">
                    <a href="./add_costume_design.php" class="right-button">Add new design</a>
                </div>
                <div id="list-box-small">
                    <center>
                        <h2>Costume designs</h2>
                    </center>

                    <form method="post" action="costume_designs.php" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b style="width:20%;">Design name</b>
                            <b style="width:20%;">Merchandiser</b>
                            <b style="width:30%;">Fashion designer</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            echo $search_output;
                            echo $output;
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
