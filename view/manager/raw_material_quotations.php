<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Raw material quotations</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $minIssueDate = $_POST["min_issue_date"];
                $maxIssueDate = $_POST["max_issue_date"];
                $minValidTill = $_POST["min_valid_till"];
                $maxValidTill = $_POST["max_valid_till"];
                if(($minIssueDate == "")&&($maxIssueDate == "")&&($minValidTill == "")&&($maxValidTill == "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%');";
                }else if(($minIssueDate == "")&&($maxIssueDate == "")&&($minValidTill == "")&&($maxValidTill != "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till <= '$maxValidTill');";
                }else if(($minIssueDate == "")&&($maxIssueDate == "")&&($minValidTill != "")&&($maxValidTill == "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill');";
                }else if(($minIssueDate == "")&&($maxIssueDate != "")&&($minValidTill == "")&&($maxValidTill == "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date <= '$maxIssueDate');";
                }else if(($minIssueDate != "")&&($maxIssueDate == "")&&($minValidTill == "")&&($maxValidTill == "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate');";
                }else if(($minIssueDate != "")&&($maxIssueDate != "")&&($minValidTill == "")&&($maxValidTill == "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate');";
                }else if(($minIssueDate == "")&&($maxIssueDate != "")&&($minValidTill != "")&&($maxValidTill == "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill' AND issue_date <= '$maxIssueDate');";
                }else if(($minIssueDate == "")&&($maxIssueDate == "")&&($minValidTill != "")&&($maxValidTill != "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill');";
                }else if(($minIssueDate != "")&&($maxIssueDate == "")&&($minValidTill == "")&&($maxValidTill != "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND valid_till <= '$maxValidTill');";
                }else if(($minIssueDate != "")&&($maxIssueDate == "")&&($minValidTill != "")&&($maxValidTill == "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND valid_till >= '$minValidTill');";
                }else if(($minIssueDate == "")&&($maxIssueDate != "")&&($minValidTill == "")&&($maxValidTill != "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date <= '$maxIssueDate' AND valid_till <= '$maxValidTill');";
                }else if(($minIssueDate != "")&&($maxIssueDate != "")&&($minValidTill != "")&&($maxValidTill == "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate' AND valid_till >= '$minValidTill');";
                }else if(($minIssueDate == "")&&($maxIssueDate != "")&&($minValidTill != "")&&($maxValidTill != "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill' AND issue_date <= '$maxIssueDate');";
                }else if(($minIssueDate != "")&&($maxIssueDate == "")&&($minValidTill != "")&&($maxValidTill != "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill' AND issue_date >= '$minIssueDate');";
                }else if(($minIssueDate != "")&&($maxIssueDate != "")&&($minValidTill == "")&&($maxValidTill != "")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate' AND valid_till <= '$maxValidTill');";
                }else{
                    $search_sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate' AND valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill');";
                }

                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $class = ($search_row["supplier_approval"]=="approve")?"green":(($row["supplier_approval"]=="deny")?"red":"grey");
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/manager_view' />";
                            $search_output.= "<input type='text' hidden='true' name='quotation_id' value='".$search_row["quotation_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row["quotation_id"]."</span><span>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span style='padding-left:24px;'>".($search_row["issue_date"]==""?"Pending":$search_row["issue_date"])."</span><span>".($search_row["valid_till"]==""?"Pending":$search_row["valid_till"])."</span>";
                            $search_output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            $search_output.= "<td><input type='submit' class='".$class."' value='View' /></td>";
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
                $sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id;";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $class = ($row["supplier_approval"]=="approve")?"green":(($row["supplier_approval"]=="deny")?"red":"grey");
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/manager_view' />";
                            $output.= "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                            $output.= "<span class='manager-ID-column'>".$row["quotation_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span style='padding-left:24px;'>".($row["issue_date"]==""?"Pending":$row["issue_date"])."</span><span>".($row["valid_till"]==""?"Pending":$row["valid_till"])."</span>";
                            $output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            $output.= "<td><input type='submit' class='".$class."' value='View' /></td>";
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
                    <a href="#">Manager </a> > Raw material quotations
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Raw material quotations</h2>
                    </center>

                    <form method="post" action="raw_material_quotations.php" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Issued on : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_issue_date" id="min_issue_date" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_issue_date" id="max_issue_date" class="date-field" />
                            </div>
                        </div>
                        <b>Valid till : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_valid_till" id="min_valid_till" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_valid_till" id="max_valid_till" class="date-field" />
                            </div>
                        </div>   
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Quotation ID</b>
                            <b>Supplier name</b>
                            <b>Issued date</b>
                            <b>Valid till</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        <?php 
                            /*require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT quotation_id, first_name, last_name, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id;";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        $class = ($row["supplier_approval"]=="approve")?"green":(($row["supplier_approval"]=="deny")?"red":"grey");
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/manager_view' />";
                                        echo "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["quotation_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span style='padding-left:24px;'>".($row["issue_date"]==""?"Pending":$row["issue_date"])."</span><span>".($row["valid_till"]==""?"Pending":$row["valid_till"])."</span>";
                                        echo "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                                        echo "<td><input type='submit' class='".$class."' value='View' /></td>";
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
                            <span>0003</span>
                            <span>John Doe</span>
                            <span>2022-01-01</span>
                            <span>2022-06-25</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>John Winsent</span>
                            <span>2022-02-01</span>
                            <span>2022-12-01</span>
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
