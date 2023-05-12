<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Suppliers</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $search_sql = "SELECT supplier_id, first_name, last_name, city, contact_no, verify_status FROM supplier WHERE supplier_id LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR city LIKE '%$searchbar%' OR contact_no LIKE '%$searchbar%'";
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $class = ($search_row["verify_status"]=="approve")?"green":(($search_row["verify_status"]=="deny")?"red":"grey");
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='supplier/manager_view' />";
                            $search_output.= "<input type='text' hidden='true' name='supplier_id' value='".$search_row["supplier_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'  style='width:12%;'>".$search_row["supplier_id"]."</span><span>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span>".$search_row["city"]."</span><span>".$search_row["contact_no"]."</span>";
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
                $search_output = "";
                $output = "";
                $sql = "SELECT supplier_id, first_name, last_name, city, contact_no, verify_status FROM supplier";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $class = ($row["verify_status"]=="approve")?"green":(($row["verify_status"]=="deny")?"red":"grey");
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='supplier/manager_view' />";
                            $output.= "<input type='text' hidden='true' name='supplier_id' value='".$row["supplier_id"]."' />";
                            $output.= "<span class='manager-ID-column' style='width:12%;'>".$row["supplier_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["city"]."</span><span>".$row["contact_no"]."</span>";
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
                    <a href="home.php">Manager</a> > Suppliers
                </div>
                <div class="link-row">
                    <a href="./add_supplier.php" class="right-button">Add new Supplier</a>
                </div>
                <div id="list-box">
                    <center>
                        <h2>Suppliers</h2>
                    </center>

                    <form method="post" action="suppliers.php" class="search-panel">
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" name="search" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b style="width:12%;">Supplier ID</b>
                            <b>Supplier name</b>
                            <b>City</b>
                            <b>Contact no</b>
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
                            <span>John Doe</span>
                            <span>Piliyandala</span>
                            <span>0777762043</span>
                            <a href="#" class="red">Edit</a>
                            <a href="#" class="red">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0010</span>
                            <span>John B</span>
                            <span>Galle</span>
                            <span>0777762044</span>
                            <a href="#" class="green">Edit</a>
                            <a href="#" class="green">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>  -->
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
