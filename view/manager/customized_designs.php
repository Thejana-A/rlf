<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customized costume designs</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            /*require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();*/
            $_SESSION["view_costume_path"] = "customized_design";
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }

            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $search_output = "";
                $output = "";
                $search_sql_costume = "(SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.customer_id, c.front_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id
                    WHERE `name` LIKE '%$searchbar%' OR e1.first_name LIKE '%$searchbar%' OR e1.last_name LIKE '%$searchbar%' OR e2.first_name LIKE '%$searchbar%' OR e2.last_name LIKE '%$searchbar%' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.customer_id, c.front_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name 
                    FROM costume_design c 
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id AND `merchandiser_id` IS NULL
                    WHERE `name` LIKE '%$searchbar%' OR e2.first_name LIKE '%$searchbar%' OR e2.last_name LIKE '%$searchbar%' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.customer_id, c.front_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name 
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id AND `fashion_designer_id` IS NULL
                    WHERE `name` LIKE '%$searchbar%' OR e1.first_name LIKE '%$searchbar%' OR e1.last_name LIKE '%$searchbar%' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.customer_id, c.front_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name 
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
                $sql_costume = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE customer_id IS NOT NULL";
                $sql_costume_result = $conn->query($sql_costume);
                $costume_name = array();
                if ($sql_costume_result->num_rows > 0) {
                    while ($row = $sql_costume_result->fetch_assoc()) {
                        array_push($costume_name , $row["costume_name"]);
                    }
                }
                //print_r($costume_name);
                for($i = 0;$i<count($costume_name);$i++){
                    $sql_costume = "(SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.customer_id, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name, cu.first_name AS customer_first_name, cu.last_name AS customer_last_name
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id
                    JOIN customer cu ON c.customer_id = cu.customer_id
                    WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.customer_id, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name, cu.first_name AS customer_first_name, cu.last_name AS customer_last_name
                    FROM costume_design c 
                    JOIN employee e2 ON c.fashion_designer_id = e2.employee_id 
                    JOIN customer cu ON c.customer_id = cu.customer_id
                    AND `merchandiser_id` IS NULL
                    WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.customer_id, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name, cu.first_name AS customer_first_name, cu.last_name AS customer_last_name
                    FROM costume_design c 
                    JOIN employee e1 ON c.merchandiser_id = e1.employee_id 
                    JOIN customer cu ON c.customer_id = cu.customer_id
                    AND `fashion_designer_id` IS NULL
                    WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                    UNION
                    (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.customer_id, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name, cu.first_name AS customer_first_name, cu.last_name AS customer_last_name
                    FROM costume_design c 
                    JOIN employee e1 ON `merchandiser_id` IS NULL
                    JOIN employee e2 ON `fashion_designer_id` IS NULL
                    JOIN customer cu ON c.customer_id = cu.customer_id
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
                            $output.= "<span style='width:20%;'>".$costume_name[$i]."</span><span style='width:20%;'>".$costume_row["customer_id"]." - ".$costume_row["customer_first_name"]." ".$costume_row["customer_last_name"]."</span><span style='width:30%;'>".$costume_row["fd_first_name"]." ".$costume_row["fd_last_name"]."</span>";
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
                    Manager > Customized costume designs
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Customized costume designs</h2>
                    </center>

                    <form method="post" action="customized_designs.php" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b style="width:20%;">Design name</b>
                            <b style="width:18%;">Customer</b>
                            <b>Fashion designer</b>
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
                            $sql = "SELECT design_id, name, customized_design_approval, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, employee.first_name AS fashion_designer_first_name, employee.last_name AS fashion_designer_last_name FROM costume_design, customer, employee WHERE costume_design.customer_id = customer.customer_id AND costume_design.fashion_designer_id = employee.employee_id
                            UNION
                            SELECT design_id, name, customized_design_approval, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, '' AS fashion_designer_first_name, '' AS fashion_designer_last_name FROM costume_design, customer WHERE costume_design.customer_id = customer.customer_id AND costume_design.fashion_designer_id IS NULL;";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        $class = ($row["customized_design_approval"]=="approve")?"green":(($row["customized_design_approval"]=="reject")?"red":"grey");
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view_customized_design' />";
                                        echo "<input type='text' hidden='true' name='design_id' value='".$row["design_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["design_id"]."</span><span style='padding-left:20px;'>".$row["name"]."</span><span>".$row["customer_first_name"]." ".$row["customer_last_name"]."</span><span>".$row["fashion_designer_first_name"]." ".$row["fashion_designer_last_name"]."</span>";
                                        echo "<input type='submit' class='".$class."' value='View' />";
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
                            mysqli_close($conn); */
                        ?>
                        <!--<div class="item-data-row">
                            <span>0003</span>
                            <span>Blue-long-sleeve</span>
                            <span>Jane Eyre</span>
                            <span>John A</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0005</span>
                            <span>White Chinese collar</span>
                            <span>Sherlock H</span>
                            <span>&nbsp</span>
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
