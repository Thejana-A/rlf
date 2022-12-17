<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customers</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
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

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
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
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT employee_id, first_name, last_name, user_type, contact_no FROM employee";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='employee/manager_view' />";
                                        echo "<input type='text' hidden='true' name='employee_id' value='".$row["employee_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["employee_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span>".$row["user_type"]."</span><span>".$row["contact_no"]."</span>";
                                        echo "<table class='two-button-table'><tr>";
                                        echo "<td><input type='submit' class='grey' name='edit' value='Edit' /></td>";
                                        echo "<td><input type='submit' class='grey' name='delete' value='Delete' /></td>";
                                        echo "</tr></table>";
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
