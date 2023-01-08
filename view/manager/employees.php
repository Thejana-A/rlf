<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customers</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $search_sql = "SELECT employee_id, first_name, last_name, user_type, contact_no FROM employee WHERE employee_id LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR user_type LIKE '%$searchbar%' OR contact_no LIKE '%$searchbar%'";
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='employee/manager_view' />";
                            $search_output.= "<input type='text' hidden='true' name='employee_id' value='".$search_row["employee_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row["employee_id"]."</span><span>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span>".$search_row["user_type"]."</span><span>".$search_row["contact_no"]."</span>";
                            $search_output.= "<table class='two-button-table'><tr>";
                            $search_output.= "<td><input type='submit' class='grey' name='edit' value='Edit' /></td>";
                            $search_output.= "<td><input type='submit' class='grey' name='delete' value='Delete' /></td>";
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
                $sql = "SELECT employee_id, first_name, last_name, user_type, contact_no FROM employee";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='employee/manager_view' />";
                            $output.= "<input type='text' hidden='true' name='employee_id' value='".$row["employee_id"]."' />";
                            $output.= "<span class='manager-ID-column'>".$row["employee_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["user_type"]."</span><span>".$row["contact_no"]."</span>";
                            $output.= "<table class='two-button-table'><tr>";
                            $output.= "<td><input type='submit' class='grey' name='edit' value='Edit' /></td>";
                            $output.= "<td><input type='submit' class='grey' name='delete' value='Delete' /></td>";
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
                    <a href="#">Manager </a> > Employees
                </div>
                <div class="link-row">
                    <a href="./add_employee.php" class="right-button">Add new employee</a>
                </div>
                <div id="list-box">
                    <center>
                        <h2>Employees</h2>
                    </center>

                    <form method="post" action="employees.php" class="search-panel">
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" name="search" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b class="manager-ID-column">Employee ID</b>
                            <b>Employee Name</b>
                            <b>Type</b>
                            <b>Contact no</b>
                            <hr class="manager-long-hr" style="width:99%" />
                        </div>
                        <?php 
                            echo $search_output;
                            echo $output;
                            mysqli_close($conn);
                        ?>
                        <!--<div class="item-data-row">
                            <span class="manager-ID-column">0003</span>
                            <span>John Doe</span>
                            <span>Merchandiser</span>
                            <span>94 777 762 043</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span class="manager-ID-column">0006</span>
                            <span>John Hase</span>
                            <span>Merchandiser</span>
                            <span>0777762045</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span class="manager-ID-column">0010</span>
                            <span>John B</span>
                            <span>Fashion designer</span>
                            <span>0777762044</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span class="manager-ID-column">0011</span>
                            <span>John C</span>
                            <span>Merchandiser</span>
                            <span>0777762046</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span class="manager-ID-column">0026</span>
                            <span>Harry Potter</span>
                            <span>Fashion designer</span>
                            <span>0777762049</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>-->
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
