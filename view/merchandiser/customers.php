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
                    <a href="#">Merchandiser </a> > Customers
                </div>
                
                <div id="list-box-small">
                    <center>
                        <h2>Customers</h2>
                    </center>
                    <center>
                        <form method="post" action="" class="search-panel">  
                            <input type="text" name="" id="" placeholder="Search" class="text-field" />
                            <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
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
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT customer_id, first_name, last_name, city, contact_no FROM customer";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='customer/merchandiser_view' />";
                                        echo "<input type='text' hidden='true' name='customer_id' value='".$row["customer_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["customer_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span style='padding-left:15px;'>".$row["city"]."</span><span style='padding-left:20px;'>".$row["contact_no"]."</span>";
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
                            mysqli_close($conn);
                        ?>
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
                            <span>0011</span>
                            <span>John C</span>
                            <span>Kandy</span>
                            <span>0777762046</span>
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
