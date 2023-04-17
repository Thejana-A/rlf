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
                $search_sql = "SELECT customer_id, first_name, last_name, city, contact_no FROM customer WHERE customer_id LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR city LIKE '%$searchbar%' OR contact_no LIKE '%$searchbar%'";
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='customer/merchandiser_view' />";
                            $search_output.= "<input type='text' hidden='true' name='customer_id' value='".$search_row["customer_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row["customer_id"]."</span><span>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span>".$search_row["city"]."</span><span>".$search_row["contact_no"]."</span>";
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
                $sql = "SELECT customer_id, first_name, last_name, city, contact_no FROM customer";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='customer/merchandiser_view' />";
                            $output.= "<input type='text' hidden='true' name='customer_id' value='".$row["customer_id"]."' />";
                            $output.= "<span class='manager-ID-column'>".$row["customer_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["city"]."</span><span>".$row["contact_no"]."</span>";
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
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Merchandiser</a> > Customers
                </div>
                
                <div id="list-box-small">
                    <center>
                        <h2>Customers</h2>
                    </center>
                    <center>
                        <form method="post" action="customers.php" class="search-panel">  
                            <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                            <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        </form>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Customer ID</b>
                            <b>Customer name</b>
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
                            <span>0006</span>
                            <span>John A</span>
                            <span>Borella</span>
                            <span>0777762045</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0010</span>
                            <span>John B</span>
                            <span>Galle</span>
                            <span>0777762044</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0026</span>
                            <span>Harry P</span>
                            <span>Jaffna</span>
                            <span>0777762049</span>
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
