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
            $merchandiserID = $_SESSION["employee_id"];
            if(isset($_POST["search"])){
                $searchbar = $_POST["searchbar"];
                $minIssueDate = $_POST["min_issue_date"];
                $maxIssueDate = $_POST["max_issue_date"];
                $minValidTill = $_POST["min_valid_till"];
                $maxValidTill = $_POST["max_valid_till"];
                $minRequestDate = $_POST["min_request_date"];
                $maxRequestDate = $_POST["max_request_date"];
                
                if(($minIssueDate=="")&&($maxIssueDate=="")&&($minValidTill=="")&&($maxValidTill=="")&&($minRequestDate=="")&&($maxRequestDate=="")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = '$merchandiserID' AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%');";
                }else if((($minRequestDate!="")||($maxRequestDate!=""))&&($minIssueDate=="")&&($maxIssueDate=="")&&($minValidTill=="")&&($maxValidTill=="")){
                    $minRequestDate = ($minRequestDate=="")?"1900-01-01":$minRequestDate;
                    $maxRequestDate = ($maxRequestDate=="")?"3000-01-01":$maxRequestDate;
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = '$merchandiserID' AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (request_date >= '$minRequestDate' AND request_date <= '$maxRequestDate');";
                }else{
                    if((($minIssueDate!="")||($maxIssueDate!=""))&&($minValidTill=="")&&($maxValidTill=="")){
                        $minRequestDate = ($minRequestDate=="")?"1900-01-01":$minRequestDate;
                        $maxRequestDate = ($maxRequestDate=="")?"3000-01-01":$maxRequestDate;
                        $minIssueDate = ($minIssueDate=="")?"1900-01-01":$minIssueDate;
                        $maxIssueDate = ($maxIssueDate=="")?"3000-01-01":$maxIssueDate;
                        $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = '$merchandiserID' AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (request_date >= '$minRequestDate' AND request_date <= '$maxRequestDate' AND issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate');";
                    }else{
                        $minIssueDate = ($minIssueDate=="")?"1900-01-01":$minIssueDate;
                        $maxIssueDate = ($maxIssueDate=="")?"3000-01-01":$maxIssueDate;
                        $minValidTill = ($minValidTill=="")?"1900-01-01":$minValidTill;
                        $maxValidTill = ($maxValidTill=="")?"3000-01-01":$maxValidTill;
                        $minRequestDate = ($minRequestDate=="")?"1900-01-01":$minRequestDate;
                        $maxRequestDate = ($maxRequestDate=="")?"3000-01-01":$maxRequestDate;
                        $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = '$merchandiserID' AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (request_date >= '$minRequestDate' AND request_date <= '$maxRequestDate' AND issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate' AND valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill');";
                    }
                } 
                /*if(($minIssueDate=="")&&($maxIssueDate=="")&&($minValidTill=="")&&($maxValidTill=="")&&($minRequestDate=="")&&($maxRequestDate=="")){
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = '$merchandiserID' AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%');";
                }else if((($minRequestDate!="")||($maxRequestDate!=""))&&($minIssueDate=="")&&($maxIssueDate=="")&&($minValidTill=="")&&($maxValidTill=="")){
                    $minIssueDate = "1900-01-01";
                    $maxIssueDate = "3000-01-01";
                    $minValidTill = "1900-01-01";
                    $maxValidTill = "3000-01-01";
                    $minRequestDate = ($minRequestDate=="")?"1900-01-01":$minRequestDate;
                    $maxRequestDate = ($maxRequestDate=="")?"3000-01-01":$maxRequestDate;
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = '$merchandiserID' AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (request_date >= '$minRequestDate' AND request_date <= '$maxRequestDate');";
                }else{
                    $minIssueDate = ($minIssueDate=="")?"1900-01-01":$minIssueDate;
                    $maxIssueDate = ($maxIssueDate=="")?"3000-01-01":$maxIssueDate;
                    $minValidTill = ($minValidTill=="")?"1900-01-01":$minValidTill;
                    $maxValidTill = ($maxValidTill=="")?"3000-01-01":$maxValidTill;
                    $minRequestDate = ($minRequestDate=="")?"1900-01-01":$minRequestDate;
                    $maxRequestDate = ($maxRequestDate=="")?"3000-01-01":$maxRequestDate;
                    $search_sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = '$merchandiserID' AND (quotation_id LIKE '%$searchbar%' OR  first_name LIKE '%$searchbar%' OR last_name LIKE '%$searchbar%') AND (request_date >= '$minRequestDate' AND request_date <= '$maxRequestDate' AND issue_date >= '$minIssueDate' AND issue_date <= '$maxIssueDate' AND valid_till >= '$minValidTill' AND valid_till <= '$maxValidTill');";
                } */
                

                $search_output = "";
                $output = "";
                if($search_result = mysqli_query($conn, $search_sql)){
                    if(mysqli_num_rows($search_result) > 0){
                        while($search_row = mysqli_fetch_array($search_result)){
                            $class = ($search_row["supplier_approval"]=="approve")?"green":(($row["supplier_approval"]=="deny")?"red":"grey");
                            $search_output.= "<div class='item-data-row'>";
                            $search_output.= "<form method='post' action='../RouteHandler.php'>";
                            $search_output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/merchandiser_view' />";
                            $search_output.= "<input type='text' hidden='true' name='quotation_id' value='".$search_row["quotation_id"]."' />";
                            //For selecting the order related to the raw material quotation
                            $tempQuotationID = $search_row["quotation_id"];
                            $sql_select_order = "SELECT raw_material_quotation.quotation_id, raw_material_order.order_id FROM raw_material_quotation, raw_material_order WHERE raw_material_quotation.quotation_id = raw_material_order.quotation_id AND raw_material_quotation.quotation_id = ".$tempQuotationID.";";
                            if($result_select_order = mysqli_query($conn, $sql_select_order)){
                                if(mysqli_num_rows($result_select_order) > 0){
                                    $search_output.= "<span style='width:8%;'><b>".$search_row["quotation_id"]."</b></span><span style='width:15%;'>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span style='width:14%;'>".$search_row["request_date"]."</span><span style='width:12%;'>".($search_row["issue_date"]==""?"Pending":$search_row["issue_date"])."</span><span style='width:12%;'>".($search_row["valid_till"]==""?"N/A":$search_row["valid_till"])."</span>";
                                }else{
                                    $search_output.= "<span style='width:8%;'>".$search_row["quotation_id"]."</span><span style='width:15%;'>".$search_row["first_name"]." ".$search_row["last_name"]."</span><span style='width:14%;'>".$search_row["request_date"]."</span><span style='width:12%;'>".($search_row["issue_date"]==""?"Pending":$search_row["issue_date"])."</span><span style='width:12%;'>".($search_row["valid_till"]==""?"N/A":$search_row["valid_till"])."</span>";
                                }
                            }
                            $search_output.= "<table align='right' style='margin-right:30px;' class='two-button-table'><tr>";
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
                $sql = "SELECT quotation_id, first_name, last_name, request_date, issue_date, valid_till, supplier_approval FROM raw_material_quotation INNER JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id WHERE merchandiser_id = '$merchandiserID';";
                $search_output = "";
                $output = "";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $class = ($row["supplier_approval"]=="approve")?"green":(($row["supplier_approval"]=="deny")?"red":"grey");
                            $output.= "<div class='item-data-row'>";
                            $output.= "<form method='post' action='../RouteHandler.php'>";
                            $output.= "<input type='text' hidden='true' name='framework_controller' value='raw_material_quotation/merchandiser_view' />";
                            $output.= "<input type='text' hidden='true' name='quotation_id' value='".$row["quotation_id"]."' />";
                            //For selecting the order related to the raw material quotation
                            $tempQuotationID = $row["quotation_id"];
                            $sql_select_order = "SELECT raw_material_quotation.quotation_id, raw_material_order.order_id FROM raw_material_quotation, raw_material_order WHERE raw_material_quotation.quotation_id = raw_material_order.quotation_id AND raw_material_quotation.quotation_id = ".$tempQuotationID.";";
                            if($result_select_order = mysqli_query($conn, $sql_select_order)){
                                if(mysqli_num_rows($result_select_order) > 0){
                                    $output.= "<span style='width:8%;'><b>".$row["quotation_id"]."</b></span><span style='width:15%;'>".$row["first_name"]." ".$row["last_name"]."</span><span style='width:14%;'>".$row["request_date"]."</span><span style='width:12%;'>".($row["issue_date"]==""?"Pending":$row["issue_date"])."</span><span style='width:12%;'>".($row["valid_till"]==""?"N/A":$row["valid_till"])."</span>";
                                }else{
                                    $output.= "<span style='width:8%;'>".$row["quotation_id"]."</span><span style='width:15%;'>".$row["first_name"]." ".$row["last_name"]."</span><span style='width:14%;'>".$row["request_date"]."</span><span style='width:12%;'>".($row["issue_date"]==""?"Pending":$row["issue_date"])."</span><span style='width:12%;'>".($row["valid_till"]==""?"N/A":$row["valid_till"])."</span>";
                                }
                            }
                            $output.= "<table align='right' style='margin-right:30px;' class='two-button-table'><tr>";
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
                    <a href="home.php">Merchandiser</a> > Raw material quotations
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Raw material quotations</h2>
                    </center>

                    <form method="post" action="raw_material_quotations.php" class="search-panel">
                        
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
                        <b style="width:8%;">Quote. ID</b>
                            <b style="width:15%;">Supplier name</b>
                            <b style="width:12%;">Request date</b>
                            <b style="width:12%;">Issued date</b>
                            <b style="width:12%;">Valid till</b>
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
                        </div>  -->
                        
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
