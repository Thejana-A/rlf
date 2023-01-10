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
                /*$search_sql_designer = "SELECT design_id,name, fashion_designer_id, merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = fashion_designer_id WHERE customized_design_approval = 'approve' AND (design_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%')";
                $search_sql_merchandiser = "SELECT design_id, merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = merchandiser_id WHERE customized_design_approval = 'approve' AND (first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%')
                UNION 
                SELECT design_id, '' AS merchandiser_id, '' AS first_name, '' AS last_name FROM costume_design INNER JOIN employee ON merchandiser_id IS NULL WHERE customized_design_approval = 'approve'";
                if(($search_result_designer = mysqli_query($conn, $search_sql_designer)) && ($search_result_merchandiser = mysqli_query($conn, $search_sql_merchandiser))){
                    if((mysqli_num_rows($search_result_designer) > 0) && (mysqli_num_rows($search_result_merchandiser) > 0)){
                        while(($search_row_designer = mysqli_fetch_array($search_result_designer)) && ($search_row_merchandiser = mysqli_fetch_array($search_result_merchandiser))){
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view' />";
                            $search_output.= "<input type='text' hidden='true' name='design_id' value='".$search_row_designer["design_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row_designer["design_id"]."</span><span>".$search_row_designer["name"]."</span><span>".$search_row_designer["first_name"]." ".$search_row_designer["last_name"]."</span><span>".$search_row_merchandiser["first_name"]." ".$search_row_merchandiser["last_name"]."</span>";
                            $search_output.= "<table align='right' style='margin-right:4px;' class='two-button-table'><tr>";
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
                }  */
                $search_sql_designer = "SELECT design_id,name, fashion_designer_id, merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = fashion_designer_id WHERE customized_design_approval = 'approve' AND (design_id LIKE '%$searchbar%' OR name LIKE '%$searchbar%' OR first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%')";
                $search_sql_merchandiser = "SELECT design_id, merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = merchandiser_id WHERE customized_design_approval = 'approve' AND (first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%')
                UNION 
                SELECT design_id, '' AS merchandiser_id, '' AS first_name, '' AS last_name FROM costume_design INNER JOIN employee ON merchandiser_id IS NULL WHERE customized_design_approval = 'approve'";
                $search_result_designer = mysqli_query($conn, $search_sql_designer);
                $search_result_merchandiser = mysqli_query($conn, $search_sql_merchandiser);
                if((mysqli_num_rows($search_result_designer) > 0) && (mysqli_num_rows($search_result_merchandiser) > 0)){
                    while(($search_row_designer = mysqli_fetch_array($search_result_designer)) && ($search_row_merchandiser = mysqli_fetch_array($search_result_merchandiser))){
                        $search_output.= "<div class='item-data-row'>";
                        $search_output.= "<form method='post' action='../RouteHandler.php'>";
                        $search_output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view' />";
                        $search_output.= "<input type='text' hidden='true' name='design_id' value='".$search_row_designer["design_id"]."' />";
                        $search_output.= "<span class='manager-ID-column'>".$search_row_designer["design_id"]."</span><span>".$search_row_designer["name"]."</span><span>".$search_row_designer["first_name"]." ".$search_row_designer["last_name"]."</span><span>".$search_row_merchandiser["first_name"]." ".$search_row_merchandiser["last_name"]."</span>";
                        $search_output.= "<table align='right' style='margin-right:4px;' class='two-button-table'><tr>";
                        $search_output.= "<td><input type='submit' class='grey' name='edit' value='Edit' /></td>";
                        $search_output.= "<td><input type='submit' class='grey' name='delete' value='Delete' /></td>";
                        $search_output.= "</tr></table>";
                        $search_output.= "<hr class='manager-long-hr' />";
                        $search_output.= "</form>";
                        $search_output.= "</div>";
                    } 
                }else if((mysqli_num_rows($search_result_designer) > 0) && (mysqli_num_rows($search_result_merchandiser) == 0)){
                    $search_sql_merchandiser = "SELECT design_id, merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = merchandiser_id WHERE customized_design_approval = 'approve'
                    UNION 
                    SELECT design_id, '' AS merchandiser_id, '' AS first_name, '' AS last_name FROM costume_design INNER JOIN employee ON merchandiser_id IS NULL WHERE customized_design_approval = 'approve'";
                    $search_result_merchandiser = mysqli_query($conn, $search_sql_merchandiser);
                    while(($search_row_designer = mysqli_fetch_array($search_result_designer)) && ($search_row_merchandiser = mysqli_fetch_array($search_result_merchandiser))){
                        $search_output.= "<div class='item-data-row'>";
                        $search_output.= "<form method='post' action='../RouteHandler.php'>";
                        $search_output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view' />";
                        $search_output.= "<input type='text' hidden='true' name='design_id' value='".$search_row_designer["design_id"]."' />";
                        $search_output.= "<span class='manager-ID-column'>".$search_row_designer["design_id"]."</span><span>".$search_row_designer["name"]."</span><span>".$search_row_designer["first_name"]." ".$search_row_designer["last_name"]."</span><span>".$search_row_merchandiser["first_name"]." ".$search_row_merchandiser["last_name"]."</span>";
                        $search_output.= "<table align='right' style='margin-right:4px;' class='two-button-table'><tr>";
                        $search_output.= "<td><input type='submit' class='grey' name='edit' value='Edit' /></td>";
                        $search_output.= "<td><input type='submit' class='grey' name='delete' value='Delete' /></td>";
                        $search_output.= "</tr></table>";
                        $search_output.= "<hr class='manager-long-hr' />";
                        $search_output.= "</form>";
                        $search_output.= "</div>";
                    } 
                }else if((mysqli_num_rows($search_result_designer) == 0) && (mysqli_num_rows($search_result_merchandiser) > 0)){
                    $search_sql_designer = "SELECT design_id,name, fashion_designer_id, merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = fashion_designer_id WHERE customized_design_approval = 'approve'";
                    $search_result_designer = mysqli_query($conn, $search_sql_designer);
                    while(($search_row_designer = mysqli_fetch_array($search_result_designer)) && ($search_row_merchandiser = mysqli_fetch_array($search_result_merchandiser))){
                        $search_output.= "<div class='item-data-row'>";
                        $search_output.= "<form method='post' action='../RouteHandler.php'>";
                        $search_output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view' />";
                        $search_output.= "<input type='text' hidden='true' name='design_id' value='".$search_row_designer["design_id"]."' />";
                        $search_output.= "<span class='manager-ID-column'>".$search_row_designer["design_id"]."</span><span>".$search_row_designer["name"]."</span><span>".$search_row_designer["first_name"]." ".$search_row_designer["last_name"]."</span><span>".$search_row_merchandiser["first_name"]." ".$search_row_merchandiser["last_name"]."</span>";
                        $search_output.= "<table align='right' style='margin-right:4px;' class='two-button-table'><tr>";
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

            }else{
                $search_output = "";
                $output = "";
                $sql_designer = "SELECT design_id,name, fashion_designer_id, merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = fashion_designer_id WHERE customized_design_approval = 'approve'";
                $sql_merchandiser = "SELECT design_id, merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee WHERE employee_id = merchandiser_id AND customized_design_approval = 'approve'
                UNION 
                SELECT design_id, '' AS merchandiser_id, '' AS first_name, '' AS last_name FROM costume_design INNER JOIN employee WHERE  merchandiser_id IS NULL AND customized_design_approval = 'approve'";
                if(($result_designer = mysqli_query($conn, $sql_designer)) && ($result_merchandiser = mysqli_query($conn, $sql_merchandiser))){
                    if((mysqli_num_rows($result_designer) > 0) && (mysqli_num_rows($result_merchandiser) > 0)){
                        while(($row_designer = mysqli_fetch_array($result_designer)) && ($row_merchandiser = mysqli_fetch_array($result_merchandiser))){
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view' />";
                            $output.= "<input type='text' hidden='true' name='design_id' value='".$row_designer["design_id"]."' />";
                            $output.= "<span class='manager-ID-column'>".$row_designer["design_id"]."</span><span>".$row_designer["name"]."</span><span>".$row_designer["first_name"]." ".$row_designer["last_name"]."</span><span>".$row_merchandiser["first_name"]." ".$row_merchandiser["last_name"]."</span>";
                            $output.= "<table align='right' style='margin-right:4px;' class='two-button-table'><tr>";
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
                    <a href="#">Manager </a> > View costume designs
                </div>
                <div class="link-row">
                    <a href="./add_costume_design.php" class="right-button">Add new design</a>
                </div>
                <div id="list-box">
                    <center>
                        <h2>Costume designs</h2>
                    </center>

                    <form method="post" action="costume_designs.php" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
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
                            echo $search_output;
                            echo $output;
                            mysqli_close($conn);
                            /*$sql1 = "SELECT design_id,name, fashion_designer_id, merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = fashion_designer_id WHERE customized_design_approval = 'approve'";
                            $sql2 = "SELECT merchandiser_id, first_name, last_name FROM costume_design INNER JOIN employee ON employee_id = merchandiser_id WHERE customized_design_approval = 'approve'";
                            if(($result1 = mysqli_query($conn, $sql1)) && ($result2 = mysqli_query($conn, $sql2))){
                                if((mysqli_num_rows($result1) > 0) && (mysqli_num_rows($result2) > 0)){
                                    while(($row1 = mysqli_fetch_array($result1)) && ($row2 = mysqli_fetch_array($result2))){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view' />";
                                        echo "<input type='text' hidden='true' name='design_id' value='".$row1["design_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row1["design_id"]."</span><span>".$row1["name"]."</span><span>".$row1["first_name"]." ".$row1["last_name"]."</span><span>".$row2["first_name"]." ".$row2["last_name"]."</span>";
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
                            mysqli_close($conn); */
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
