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
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='supplier/merchandiser_view' />";
                            $search_output.= "<input type='text' hidden='true' name='supplier_id' value='".$search_row["supplier_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row["supplier_id"]."</span><span>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span>".$search_row["city"]."</span><span>".$search_row["contact_no"]."</span>";
                            $search_output.= "<table align='right' style='margin-right:22px;' class='two-button-table'><tr>";
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
                $search_output = "";
                $output = "";
                $sql = "SELECT supplier_id, first_name, last_name, city, contact_no, verify_status FROM supplier WHERE verify_status = 'approve'";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='supplier/merchandiser_view' />";
                            $output.= "<input type='text' hidden='true' name='supplier_id' value='".$row["supplier_id"]."' />";
                            $output.= "<span class='manager-ID-column'>".$row["supplier_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["city"]."</span><span>".$row["contact_no"]."</span>";
                            $output.= "<table align='right' style='margin-right:22px;' class='two-button-table'><tr>";
                            $output.= "<td>&nbsp;&nbsp;<input type='submit' class='grey' value='View' /></td>";
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
                    <a href="#">Merchandiser </a> > Suppliers
                </div>
                
                <div id="list-box-small">
                    <center>
                        <h2>Suppliers</h2>
                    </center>
                    <center>
                        <form method="post" action="suppliers.php" class="search-panel">
                            
                            <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                            <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />   
                        </form>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Supplier ID</b>
                            <b>Supplier name</b>
                            <b>City</b>
                            <b>Contact no</b>
                            <hr class='manager-long-hr' />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        <?php /*
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT supplier_id, first_name, last_name, city, contact_no, verify_status FROM supplier WHERE `verify_status` = 'approve'";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='supplier/merchandiser_view' />";
                                        echo "<input type='text' hidden='true' name='supplier_id' value='".$row["supplier_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["supplier_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["city"]."</span><span style='padding-left:15px;padding-right:15px;'>".$row["contact_no"]."</span>";
                                        echo "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                                        echo "<td><input type='submit' class='grey' value='View' /></td>";
                                        echo "</tr></table>"; 
                                        //echo "<input type='submit' class='grey' value='View' />";
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
                            <span>John Honter</span>
                            <span>Piliyandala</span>
                            <span>0777762043</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>John A</span>
                            <span>Kottawa</span>
                            <span>0777762045</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div> -->
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
