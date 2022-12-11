<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Costume designs</title>
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
                    <a href="#">Manager </a> > View costume designs
                </div>
                <div class="link-row">
                    <a href="./add_costume_design.php" class="right-button">Add new design</a>
                </div>
                <div id="list-box">
                    <center>
                        <h2>Costume designs</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b class="manager-ID-column">Design ID</b>
                            <b>Design name</b>
                            <b>Fashion designer</b>
                            <b>Merchandiser</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql1 = "SELECT design_id,name, fashion_designer_id, merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = fashion_designer_id WHERE customized_design_approval = 'approve'";
                            $sql2 = "SELECT merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = merchandiser_id WHERE customized_design_approval = 'approve'";
                            if(($result1 = mysqli_query($conn, $sql1)) && ($result2 = mysqli_query($conn, $sql2))){
                                if((mysqli_num_rows($result1) > 0) && (mysqli_num_rows($result2) > 0)){
                                    while(($row1 = mysqli_fetch_array($result1)) && ($row2 = mysqli_fetch_array($result2))){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view' />";
                                        echo "<input type='text' hidden='true' name='design_id' value='".$row1["design_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row1["design_id"]."</span><span>".$row1["name"]."</span><span>".$row1["first_name"]." ".$row1["last_name"]."</span><span>".$row2["first_name"]." ".$row2["last_name"]."</span>";
                                        /*echo "<input type='submit' class='grey' name='edit' value='Edit' />";
                                        echo "<input type='submit' class='grey' name='delete' value='Delete' />"; */
                                        echo "<table align='right' style='margin-right:4px;' class='two-button-table'><tr>";
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
