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
                $minRequestDate = $_POST["min_request_date"];
                $maxRequestDate = $_POST["max_request_date"];

                /*if(($minIssueDate=="")&&($maxIssueDate=="")&&($minValidTill=="")&&($maxValidTill=="")&&($minRequestDate=="")&&($maxRequestDate=="")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN employee ON raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' OR supplier_approval LIKE '%$searchbar%');";
                }else if((($minRequestDate!="")||($maxRequestDate!=""))&&($minIssueDate=="")&&($maxIssueDate=="")&&($minValidTill=="")&&($maxValidTill=="")){
                    $minIssueDate = "1900-01-01";
                    $maxIssueDate = "3000-01-01";
                    $minValidTill = "1900-01-01";
                    $maxValidTill = "3000-01-01";
                    $minRequestDate = ($minRequestDate=="")?"1900-01-01":$minRequestDate;
                    $maxRequestDate = ($maxRequestDate=="")?"3000-01-01":$maxRequestDate;
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN employee ON raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' supplier_approval LIKE '%$searchbar%') AND (request_date >= '$minRequestDate' AND request_date <= '$maxRequestDate');";
                }else{
                    $minIssueDate = ($minIssueDate=="")?"1900-01-01":$minIssueDate;
                    $maxIssueDate = ($maxIssueDate=="")?"3000-01-01":$maxIssueDate;
                    $minValidTill = ($minValidTill=="")?"1900-01-01":$minValidTill;
                    $maxValidTill = ($maxValidTill=="")?"3000-01-01":$maxValidTill;
                    $minRequestDate = ($minRequestDate=="")?"1900-01-01":$minRequestDate;
                    $maxRequestDate = ($maxRequestDate=="")?"3000-01-01":$maxRequestDate;
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN employee ON raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%' supplier_approval LIKE '%$searchbar%') AND (request_date >= '$minRequestDate' AND request_date <= '$maxRequestDate' AND issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate' AND valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill');";
                } */
                if(($minIssueDate=="")&&($maxIssueDate=="")&&($minValidTill=="")&&($maxValidTill=="")&&($minRequestDate=="")&&($maxRequestDate=="")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN employee ON raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%');";
                }else if((($minRequestDate!="")||($maxRequestDate!=""))&&($minIssueDate=="")&&($maxIssueDate=="")&&($minValidTill=="")&&($maxValidTill=="")){
                    $minIssueDate = "1900-01-01";
                    $maxIssueDate = "3000-01-01";
                    $minValidTill = "1900-01-01";
                    $maxValidTill = "3000-01-01";
                    $minRequestDate = ($minRequestDate=="")?"1900-01-01":$minRequestDate;
                    $maxRequestDate = ($maxRequestDate=="")?"3000-01-01":$maxRequestDate;
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN employee ON raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (request_date >= '$minRequestDate' AND request_date <= '$maxRequestDate');";
                }else{
                    $minIssueDate = ($minIssueDate=="")?"1900-01-01":$minIssueDate;
                    $maxIssueDate = ($maxIssueDate=="")?"3000-01-01":$maxIssueDate;
                    $minValidTill = ($minValidTill=="")?"1900-01-01":$minValidTill;
                    $maxValidTill = ($maxValidTill=="")?"3000-01-01":$maxValidTill;
                    $minRequestDate = ($minRequestDate=="")?"1900-01-01":$minRequestDate;
                    $maxRequestDate = ($maxRequestDate=="")?"3000-01-01":$maxRequestDate;
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN employee ON raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"]." AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (request_date >= '$minRequestDate' AND request_date <= '$maxRequestDate' AND issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate' AND valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill');";
                }

                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $class = ($search_row["supplier_approval"]=="approve")?"green":(($row["supplier_approval"]=="reject")?"red":"grey");
                            if($search_row["supplier_approval"] == NULL){
                                $supplierApproval = "Pending";
                            }else{
                                $supplierApproval = $search_row["supplier_approval"];
                            }
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/supplier_view' />";
                            $search_output.= "<input type='text' hidden='true' name='quotation_id' value='".$search_row["quotation_id"]."' />";
                            $search_output.= "<input type='text' hidden='true' name='expected_delivery_date' value-'".$search_row["expected_delivery_date"]."' />";
                            $search_output.= "<input type='text' hidden='true' name='approval_description' value='".$search_row["approval_description"]."' />";
                            $search_output.= "<input type='text' hidden='true' name'supplier_id' value='".$search_row["supplier_id"]."' />";
                            $search_output.= "<input type='text' hidden='true' name'merchandiser_id' value='".$search_row["merchandiser_id"]."' />";
                            $search_output.= "<span style='width:6%;'>".$search_row["quotation_id"]."</span><span style='width:12%;'>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span style='width:12%;'>".$search_row["request_date"]."</span><span style='width:12%;'>".($search_row["issue_date"]==""?"Pending":$search_row["issue_date"])."</span><span style='width:10%;'>".($search_row["valid_till"]==""?"N/A":$search_row["valid_till"])."</span><span style='width:8%;'>".(($search_row["supplier_approval"])==""?"Pending":$search_row["supplier_approval"])."</span>";
                            $search_output.= "<table align='right' style='margin-right:8px;' class='two-button-table'><tr>";
                            $search_output.= "<td><input type='submit' class='".$class."' value='View' /></td>";
                            $search_output.= "</tr></table>";
                            $search_output.= "<hr class='manager-long-hr' />";
                            $search_output.= "</form>";
                            $search_output.= "</div>";
                        }
                    }else {
                        $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
                    }
                }
            }else{
                            $sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN employee on raw_material_quotation.merchandiser_id= employee.employee_id WHERE raw_material_quotation.supplier_id = ".$_SESSION["supplier_id"].";";
                            $search_output = "";
                            $output = "";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){                            
                                        $class = ($row["supplier_approval"]=="approve")?"green":(($row["supplier_approval"]=="reject")?"red":"grey");
                                        if($row["supplier_approval"] == NULL){
                                            $supplierApproval = "Pending";
                                        }else{
                                            $supplierApproval = $row["supplier_approval"];
                                        }
                                        $output.= "<div class='item-data-row'>";
                                        $output.= "<form method='post' action='../RouteHandler.php'>";
                                        $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/supplier_view' />";
                                        $output.= "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                                        $output.= "<span style='width:4%;'>".$row["quotation_id"]."</span><span class='width:8%;'>".$row["first_name"]." ".$row["last_name"]."</span><span style='width:10%;'>".$row["request_date"]."</span><span style='width:12%;'>".($row["issue_date"]==""?"Pending":$row["issue_date"])."</span><span style='width:10%;'>".($row["valid_till"]==""?"N/A":$row["valid_till"])."</span><span style='width:8%;'>".(($row["supplier_approval"])==""?"Pending":$row["supplier_approval"])."</span>";
                                        $output.= "<table align='right' style='margin-right:14px; margin-bottom:8px' class='two-button-table'><tr>";
                                        $output.= "<td><input type='submit' class='".$class."' value='View' /></td>";
                                        $output.= "</tr></table>";
                                        $output.= "<hr class='manager-long-hr' />";
                                        $output.= "</form>";
                                        $output.= "</div>";
                                    }
                                }else {
                                    $output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No results found";
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
                    <a href="profile.php">Supplier </a> > Quotation requests
                </div>
                
                <div id="list-box-ultra-small">
                    <center>
                        <h2>All quotation requests</h2>
                    </center>

                    <form method="post" action="all_quotation_requests.php" class="search-panel">
                        
                        <input type="text" name="searchbar" id="searchbar" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Request date : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="min_request_date" id="min_request_date" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="max_request_date" id="max_request_date" class="date-field" />
                            </div>
                        </div>
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
                            <b style="width:6%;">Quotation ID</b>
                            <b style="width:11%;">Merchandiser name</b>
                            <b style="width:12%;">Request date</b>
                            <b style="width:10%;">Issued date</b>
                            <b style="width:10%;">Valid till</b>
                            <b style="width:8%;">Status</b>


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