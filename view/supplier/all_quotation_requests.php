<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>All quotation requests</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />
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
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%');";
                }else if(($minIssueDate == "")&&($maxIssueDate == "")&&($minValidTill == "")&&($maxValidTill != "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till <= '$maxValidTill');";
                }else if(($minIssueDate == "")&&($maxIssueDate == "")&&($minValidTill != "")&&($maxValidTill == "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill');";
                }else if(($minIssueDate == "")&&($maxIssueDate != "")&&($minValidTill == "")&&($maxValidTill == "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date <= '$maxIssueDate');";
                }else if(($minIssueDate != "")&&($maxIssueDate == "")&&($minValidTill == "")&&($maxValidTill == "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate');";
                }else if(($minIssueDate != "")&&($maxIssueDate != "")&&($minValidTill == "")&&($maxValidTill == "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate');";
                }else if(($minIssueDate == "")&&($maxIssueDate != "")&&($minValidTill != "")&&($maxValidTill == "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill' AND issue_date <= '$maxIssueDate');";
                }else if(($minIssueDate == "")&&($maxIssueDate == "")&&($minValidTill != "")&&($maxValidTill != "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill');";
                }else if(($minIssueDate != "")&&($maxIssueDate == "")&&($minValidTill == "")&&($maxValidTill != "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND valid_till <= '$maxValidTill');";
                }else if(($minIssueDate != "")&&($maxIssueDate == "")&&($minValidTill != "")&&($maxValidTill == "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND valid_till >= '$minValidTill');";
                }else if(($minIssueDate == "")&&($maxIssueDate != "")&&($minValidTill == "")&&($maxValidTill != "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date <= '$maxIssueDate' AND valid_till <= '$maxValidTill');";
                }else if(($minIssueDate != "")&&($maxIssueDate != "")&&($minValidTill != "")&&($maxValidTill == "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate' AND valid_till >= '$minValidTill');";
                }else if(($minIssueDate == "")&&($maxIssueDate != "")&&($minValidTill != "")&&($maxValidTill != "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill' AND issue_date <= '$maxIssueDate');";
                }else if(($minIssueDate != "")&&($maxIssueDate == "")&&($minValidTill != "")&&($maxValidTill != "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill' AND issue_date >= '$minIssueDate');";
                }else if(($minIssueDate != "")&&($maxIssueDate != "")&&($minValidTill == "")&&($maxValidTill != "")){
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate' AND valid_till <= '$maxValidTill');";
                }else{
                    $search_sql =  "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate' AND valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill');";
                }
    
                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/supplier_view' />";
                            $search_output.= "<input type='text' hidden='true' name='quotation_id' value='".$search_row["quotation_id"]."' />";
                            $search_output.= "<input type='text' hidden='true' name='expected_delivery_date' value-'".$search_row["expected_delivery_date"]."' />";
                            $search_output.= "<input type='text' hidden='true' name='suppler_approval'value='".$search_row["supplier_approval"]."' />";
                            $search_output.= "<input type='text' hidden='true' name='approval_description' value='".$search_row["approval_description"]."' />";
                            $search_output.= "<input type='text' hidden='true' name'supplier_id' value='".$search_row["supplier_id"]."' />";
                            $search_output.= "<input type='text' hidden='true' name'merchandiser_id' value='".$search_roww["merchandiser_id"]."' />";
                            $search_output.= "<span class='manager-ID-column'>".$search_row["quotation_id"]."</span><span>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span style='padding-left:24px;'>".(($search_row["issue_date"])==""?"Pending":$search_row["issue_date"])."</span><span>".(($search_row["valid_till"])==""?"Pending":$search_row["valid_till"])."</span>";
                            $search_output.= "<input type='submit' class='grey' name='view' value='View' />";
                            $search_output.= "<hr class='manager-long-hr' />";
                            $search_output.= "</form>";
                            $search_output.= "</div>";
                                    }
                                }else {
                                    $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
                                }
                            }
                        }else{
                            $sql = "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"].";";
                            $search_output = "";
                            $output = "";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        
                                        $output.= "<div class='item-data-row'>";
                                        $output.= "<form method='post' action='../RouteHandler.php'>";
                                        $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/supplier_view' />";
                                        $output.= "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                                        $output.= "<input type='text' hidden='true' name='expected_delivery_date' value-'".$row["expected_delivery_date"]."' />";
                                        $output.= "<input type='text' hidden='true' name='suppler_approval'value='".$row["supplier_approval"]."' />";
                                        $output.= "<input type='text' hidden='true' name='approval_description' value='".$row["approval_description"]."' />";
                                        $output.= "<input type='text' hidden='true' name'supplier_id' value='".$row["supplier_id"]."' />";
                                        $output.= "<input type='text' hidden='true' name'merchandiser_id' value='".$row["merchandiser_id"]."' />";
                                        $output.= "<span class='manager-ID-column'>".$row["quotation_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span style='padding-left:24px;'>".(($row["issue_date"])==""?"Pending":$row["issue_date"])."</span><span>".(($row["valid_till"])==""?"Pending":$row["valid_till"])."</span>";
                                        $output.= "<input type='submit' class='grey' name='view' value='View' />";
                                        $output.= "<hr class='manager-long-hr' />";
                                        $output.= "</form>";
                                        $output.= "</div>";
                                    }
                                }else {
                                    echo "0 results";
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
                    <a href="profile.php">Supplier </a> >Quotation requests
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>All quotation requests</h2>
                    </center>

                    <form method="post" action="all_quotation_requests.php" class="search-panel">
                        
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
                            <b>Request ID</b>
                            <b>Merchandiser name</b>
                            <b>Issued date</b>
                            <b>Valid till</b>

                            <hr class = "manager-long-hr" />
                        </div>
                        <div id="content-list">
                            <?php 
                                echo $search_output;
                                echo $output;
                                mysqli_close($conn);
                            ?>
                        </div>
                        <?php 
                            /*$supplierID = $_SESSION["supplier_id"];
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT quotation_id,first_name, last_name,issue_date,valid_till  FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"].";";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/supplier_view' />";
                                        echo "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                                        echo "<input type='text' hidden='true' name='expected_delivery_date' value-'".$row["expected_delivery_date"]."' />";
                                        echo "<input type='text' hidden='true' name='suppler_approval'value='".$row["supplier_approval"]."' />";
                                        echo "<input type='text' hidden='true' name='approval_description' value='".$row["approval_description"]."' />";
                                        echo "<input type='text' hidden='true' name'supplier_id' value='".$row["supplier_id"]."' />";
                                        echo "<input type='text' hidden='true' name'merchandiser_id' value='".$row["merchandiser_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["quotation_id"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span><span style='padding-left:24px;'>".(($row["issue_date"])==""?"Pending":$row["issue_date"])."</span><span>".(($row["valid_till"])==""?"Pending":$row["valid_till"])."</span>";
                                        echo "<input type='submit' class='grey' name='view' value='View' />";
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
                            mysqli_close($conn);*/
                        ?>
                        <!--
                        <div class="item-data-row">
                            <span>0001</span>
                            <span>James R</span>
                            <span>2022-01-16</span>
                            <span>2022-04-08</span>
                            
                            <a href="send_quotation.php" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0002</span>
                            <span>James U</span>
                            <span>2022-04-16</span>
                            <span>2022-12-16</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>James P</span>
                            <span>2022-07-28</span>
                            <span>2022-12-16</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0004</span>
                            <span>James A</span>
                            <span>2022-07-16</span>
                            <span>2022-09-18</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>-->
            
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
