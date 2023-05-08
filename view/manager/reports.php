<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reports</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
        <script>
            function saveReportBody(){
                var form_body = document.getElementById("report_body").innerHTML;
                form_body = "<table>"+form_body;
                var result = form_body.replace(/div/g, "tr");
                result = result.replace(/span/g, "td");
                for(var i=0;i<5;i++){
                    result = result.replace(/\<b\>/, "<td>");
                    result = result.replace(/\<\\b\>/, "<\\td>");
                }
                result = result.replace(/hr/g, "");

                result += "</table>";
                document.getElementById("report_content").value = result;
                //alert(document.getElementById("report_content").value);
                return true;
            }
        </script>
        <?php
            require_once('../../model/DBConnection.php');
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $output = "<br /><br /><br /><br />";
            if(isset($_POST["search"])){
                $customerName = $_POST["customer_name"];
                $merchandiserName = $_POST["merchandiser_name"];
                $supplierName = $_POST["supplier_name"];
                $startDate = $_POST["start_date"];
                $endDate = $_POST["end_date"];
                if($_POST["report_type"]=="income_report"){
                    
                    if(($startDate == "")&&($endDate == "")){
                        $search_income_sql = "SELECT order_id, advance_payment, advance_payment_date, balance_payment, dispatch_date, costume_order.quotation_id, costume_quotation.customer_id, costume_quotation.merchandiser_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name FROM costume_order, costume_quotation, customer, employee WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = employee.employee_id AND (customer.first_name LIKE '%$customerName%' OR customer.last_name LIKE '%$customerName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND advance_payment_date IS NOT NULL;";
                    }else if(($startDate == "")&&($endDate != "")){
                        $search_income_sql = "SELECT order_id, advance_payment, advance_payment_date, balance_payment, dispatch_date, costume_order.quotation_id, costume_quotation.customer_id, costume_quotation.merchandiser_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name FROM costume_order, costume_quotation, customer, employee WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = employee.employee_id AND (customer.first_name LIKE '%$customerName%' OR customer.last_name LIKE '%$customerName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND (advance_payment_date <= '$endDate' OR dispatch_date <= '$endDate')";
                    }else if(($startDate != "")&&($endDate == "")){
                        $search_income_sql = "SELECT order_id, advance_payment, advance_payment_date, balance_payment, dispatch_date, costume_order.quotation_id, costume_quotation.customer_id, costume_quotation.merchandiser_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name FROM costume_order, costume_quotation, customer, employee WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = employee.employee_id AND (customer.first_name LIKE '%$customerName%' OR customer.last_name LIKE '%$customerName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND (advance_payment_date >= '$startDate' OR dispatch_date >= '$startDate')";
                    }else{
                        $search_income_sql = "SELECT order_id, advance_payment, advance_payment_date, balance_payment, dispatch_date, costume_order.quotation_id, costume_quotation.customer_id, costume_quotation.merchandiser_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name FROM costume_order, costume_quotation, customer, employee WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = employee.employee_id AND (customer.first_name LIKE '%$customerName%' OR customer.last_name LIKE '%$customerName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND (advance_payment_date BETWEEN '$startDate' AND '$endDate' OR dispatch_date BETWEEN '$startDate' AND '$endDate')";
                    }
                    $search_output = "";
                    $output = "";

                    if($search_result = mysqli_query($conn, $search_income_sql)){
                        //For pdf download
                        $search_output.= "<form method='post' action='download_report.php' onSubmit='return saveReportBody();'><div id='report_body'>";
                        $search_output.= "<center><h2>Income report</h2></center>";
                        $search_output.= "<div class='report-heading-row'>";
                        $search_output.= "<b>Order ID</b>";
                        $search_output.= "<b>Customer</b>";
                        $search_output.= "<b>Merchandiser</b>";
                        $search_output.= "<b>Value (LKR)</b>";
                        $search_output.= "<b>Payment date</b>";
                        $search_output.= "<hr />";
                        $search_output.= "</div>";
                        $totalIncome = 0;
                        if(mysqli_num_rows($search_result) > 0){
                            while($search_row = mysqli_fetch_array($search_result)){
                                if($search_row["dispatch_date"] != NULL){
                                    if(($startDate != "")&&($search_row["advance_payment_date"] < $startDate)){
                                        $search_output.= "<div class='report-data-row'>";
                                        $search_output.= "<span>".$search_row["order_id"]."</span>";
                                        $search_output.= "<span>".$search_row["customer_first_name"]." ".$search_row["customer_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                        $search_output.= "<span><b>".$search_row["balance_payment"]."</b></span>";
                                        $search_output.= "<span><b>".$search_row["dispatch_date"]."</b></span>";
                                        $search_output.= "<hr />";
                                        $search_output.= "</div>";
                                        $totalIncome += $search_row["balance_payment"];
                                    }else if(($endDate != "")&&($search_row["dispatch_date"] > $endDate)){
                                        $search_output.= "<div class='report-data-row'>";
                                        $search_output.= "<span>".$search_row["order_id"]."</span>";
                                        $search_output.= "<span>".$search_row["customer_first_name"]." ".$search_row["customer_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["advance_payment"]."</span>";
                                        $search_output.= "<span>".$search_row["advance_payment_date"]."</span>";
                                        $search_output.= "<hr />";
                                        $search_output.= "</div>";
                                        $totalIncome += $search_row["advance_payment"];
                                    }else{ 
                                        $search_output.= "<div class='report-data-row'>";
                                        $search_output.= "<span>".$search_row["order_id"]."</span>";
                                        $search_output.= "<span>".$search_row["customer_first_name"]." ".$search_row["customer_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["advance_payment"]."</span>";
                                        $search_output.= "<span>".$search_row["advance_payment_date"]."</span>";
                                        $search_output.= "<hr />";
                                        $search_output.= "</div>";
                                        $search_output.= "<div class='report-data-row'>";
                                        $search_output.= "<span>".$search_row["order_id"]."</span>";
                                        $search_output.= "<span>".$search_row["customer_first_name"]." ".$search_row["customer_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                        $search_output.= "<span><b>".$search_row["balance_payment"]."</b></span>";
                                        $search_output.= "<span><b>".$search_row["dispatch_date"]."</b></span>";
                                        $search_output.= "<hr />";
                                        $search_output.= "</div>";
                                        $totalIncome += $search_row["advance_payment"]+$search_row["balance_payment"];
                                    }
                                }else{
                                    $search_output.= "<div class='report-data-row'>";
                                    $search_output.= "<span>".$search_row["order_id"]."</span>";
                                    $search_output.= "<span>".$search_row["customer_first_name"]." ".$search_row["customer_last_name"]."</span>";
                                    $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                    $search_output.= "<span>".$search_row["advance_payment"]."</span>";
                                    $search_output.= "<span>".$search_row["advance_payment_date"]."</span>";
                                    $search_output.= "<hr />";
                                    $search_output.= "</div>";
                                    $totalIncome += $search_row["advance_payment"];
                                }
                                         
                            } 
                             
                        }else{
                            $search_output.= "<div class='report-data-row'>";
                            $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No income found<br />";
                            $search_output.= "<hr />";
                            $search_output.= "</div>";
                        }
                        $search_output.= "<div class='report-data-row'>";
                        $search_output.= "<span><b>Total income:</b></span>";
                        $search_output.= "<span></span>";
                        $search_output.= "<span></span>";
                        $search_output.= "<span style='color:#0A6522;'><b>".$totalIncome."</b></span>";
                        $search_output.= "<span></span>";
                        $search_output.= "<hr />";
                        $search_output.= "</div>"; 
                        //For pdf download
                        $search_output.= "</div><textarea hidden='true' name='report_content' id='report_content'></textarea><center><input type='submit' name='pdf_download' value='Generate PDF' class='pdf-download-button' /></center></form>"; 
                    }
                }else if($_POST["report_type"]=="loss_profit_report"){
                    if(($startDate == "")&&($endDate == "")){
                        $search_income_sql = "SELECT order_id, advance_payment, advance_payment_date, balance_payment, dispatch_date, costume_order.quotation_id, costume_quotation.customer_id, costume_quotation.merchandiser_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name FROM costume_order, costume_quotation, customer, employee WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = employee.employee_id AND (customer.first_name LIKE '%$customerName%' OR customer.last_name LIKE '%$customerName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND advance_payment_date IS NOT NULL;";
                        $search_expense_sql = "SELECT order_id, payment, payment_date, raw_material_order.quotation_id, raw_material_quotation.supplier_id, raw_material_quotation.merchandiser_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name FROM raw_material_order, raw_material_quotation, supplier, employee WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND (supplier.first_name LIKE '%$supplierName%' OR supplier.last_name LIKE '%$supplierName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND payment_date IS NOT NULL;";
                    }else if(($startDate == "")&&($endDate != "")){
                        $search_income_sql = "SELECT order_id, advance_payment, advance_payment_date, balance_payment, dispatch_date, costume_order.quotation_id, costume_quotation.customer_id, costume_quotation.merchandiser_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name FROM costume_order, costume_quotation, customer, employee WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = employee.employee_id AND (customer.first_name LIKE '%$customerName%' OR customer.last_name LIKE '%$customerName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND (advance_payment_date <= '$endDate' OR dispatch_date <= '$endDate')";
                        $search_expense_sql = "SELECT order_id, payment, payment_date, raw_material_order.quotation_id, raw_material_quotation.supplier_id, raw_material_quotation.merchandiser_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name FROM raw_material_order, raw_material_quotation, supplier, employee WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND (supplier.first_name LIKE '%$supplierName%' OR supplier.last_name LIKE '%$supplierName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND (payment_date <= '$endDate') AND payment_date IS NOT NULL;";
                    }else if(($startDate != "")&&($endDate == "")){
                        $search_income_sql = "SELECT order_id, advance_payment, advance_payment_date, balance_payment, dispatch_date, costume_order.quotation_id, costume_quotation.customer_id, costume_quotation.merchandiser_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name FROM costume_order, costume_quotation, customer, employee WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = employee.employee_id AND (customer.first_name LIKE '%$customerName%' OR customer.last_name LIKE '%$customerName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND (advance_payment_date >= '$startDate' OR dispatch_date >= '$startDate')";
                        $search_expense_sql = "SELECT order_id, payment, payment_date, raw_material_order.quotation_id, raw_material_quotation.supplier_id, raw_material_quotation.merchandiser_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name FROM raw_material_order, raw_material_quotation, supplier, employee WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND (supplier.first_name LIKE '%$supplierName%' OR supplier.last_name LIKE '%$supplierName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND (payment_date >= '$startDate') AND payment_date IS NOT NULL;";
                    }else{
                        $search_income_sql = "SELECT order_id, advance_payment, advance_payment_date, balance_payment, dispatch_date, costume_order.quotation_id, costume_quotation.customer_id, costume_quotation.merchandiser_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name FROM costume_order, costume_quotation, customer, employee WHERE costume_order.quotation_id = costume_quotation.quotation_id AND costume_quotation.customer_id = customer.customer_id AND costume_quotation.merchandiser_id = employee.employee_id AND (customer.first_name LIKE '%$customerName%' OR customer.last_name LIKE '%$customerName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND (advance_payment_date BETWEEN '$startDate' AND '$endDate' OR dispatch_date BETWEEN '$startDate' AND '$endDate')";
                        $search_expense_sql = "SELECT order_id, payment, payment_date, raw_material_order.quotation_id, raw_material_quotation.supplier_id, raw_material_quotation.merchandiser_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name FROM raw_material_order, raw_material_quotation, supplier, employee WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND (supplier.first_name LIKE '%$supplierName%' OR supplier.last_name LIKE '%$supplierName%') AND (employee.first_name LIKE '%$merchandiserName%' OR employee.last_name LIKE '%$merchandiserName%') AND (payment_date BETWEEN '$startDate' AND '$endDate') AND payment_date IS NOT NULL;";
                    }
                    $search_output = "";
                    $output = "";
                    if($search_result = mysqli_query($conn, $search_income_sql)){
                        //For pdf download
                        $search_output.= "<form method='post' action='download_report.php' onSubmit='return saveReportBody();'><div id='report_body'>";
                        $search_output.= "<center><h2>Loss/profit report</h2></center>";
                        $search_output.= "<center><h3>Total income</h3></center>";
                        $search_output.= "<div class='report-heading-row'>";
                        $search_output.= "<b>Order ID</b>";
                        $search_output.= "<b>Customer</b>";
                        $search_output.= "<b>Merchandiser</b>";
                        $search_output.= "<b>Value (LKR)</b>";
                        $search_output.= "<b>Payment date</b>";
                        $search_output.= "<hr />";
                        $search_output.= "</div>";
                        $totalIncome = 0;
                        if(mysqli_num_rows($search_result) > 0){
                            while($search_row = mysqli_fetch_array($search_result)){
                                if($search_row["dispatch_date"] != NULL){
                                    if(($startDate != "")&&($search_row["advance_payment_date"] < $startDate)){
                                        $search_output.= "<div class='report-data-row'>";
                                        $search_output.= "<span>".$search_row["order_id"]."</span>";
                                        $search_output.= "<span>".$search_row["customer_first_name"]." ".$search_row["customer_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                        $search_output.= "<span><b>".$search_row["balance_payment"]."</b></span>";
                                        $search_output.= "<span><b>".$search_row["dispatch_date"]."</b></span>";
                                        $search_output.= "<hr />";
                                        $search_output.= "</div>";
                                        $totalIncome += $search_row["balance_payment"];
                                    }else if(($endDate != "")&&($search_row["dispatch_date"] > $endDate)){
                                        $search_output.= "<div class='report-data-row'>";
                                        $search_output.= "<span>".$search_row["order_id"]."</span>";
                                        $search_output.= "<span>".$search_row["customer_first_name"]." ".$search_row["customer_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["advance_payment"]."</span>";
                                        $search_output.= "<span>".$search_row["advance_payment_date"]."</span>";
                                        $search_output.= "<hr />";
                                        $search_output.= "</div>";
                                        $totalIncome += $search_row["advance_payment"];
                                    }else{ 
                                        $search_output.= "<div class='report-data-row'>";
                                        $search_output.= "<span>".$search_row["order_id"]."</span>";
                                        $search_output.= "<span>".$search_row["customer_first_name"]." ".$search_row["customer_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["advance_payment"]."</span>";
                                        $search_output.= "<span>".$search_row["advance_payment_date"]."</span>";
                                        $search_output.= "<hr />";
                                        $search_output.= "</div>";
                                        $search_output.= "<div class='report-data-row'>";
                                        $search_output.= "<span>".$search_row["order_id"]."</span>";
                                        $search_output.= "<span>".$search_row["customer_first_name"]." ".$search_row["customer_last_name"]."</span>";
                                        $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                        $search_output.= "<span><b>".$search_row["balance_payment"]."</b></span>";
                                        $search_output.= "<span><b>".$search_row["dispatch_date"]."</b></span>";
                                        $search_output.= "<hr />";
                                        $search_output.= "</div>";
                                        $totalIncome += $search_row["advance_payment"]+$search_row["balance_payment"];
                                    }
                                }else{
                                    $search_output.= "<div class='report-data-row'>";
                                    $search_output.= "<span>".$search_row["order_id"]."</span>";
                                    $search_output.= "<span>".$search_row["customer_first_name"]." ".$search_row["customer_last_name"]."</span>";
                                    $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                    $search_output.= "<span>".$search_row["advance_payment"]."</span>";
                                    $search_output.= "<span>".$search_row["advance_payment_date"]."</span>";
                                    $search_output.= "<hr />";
                                    $search_output.= "</div>";
                                    $totalIncome += $search_row["advance_payment"];
                                }
                                         
                            } 
                              
                        }else{
                            $search_output.= "<div class='report-data-row'>";
                            $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No income found<br />";
                            $search_output.= "<hr />";
                            $search_output.= "</div>";
                        }
                        $search_output.= "<div class='report-data-row'>";
                        $search_output.= "<span><b>Total income:</b></span>";
                        $search_output.= "<span></span>";
                        $search_output.= "<span></span>";
                        $search_output.= "<span style='color:#0A6522;'><b>".$totalIncome."</b></span>";
                        $search_output.= "<span></span>";
                        $search_output.= "<hr />";
                        $search_output.= "</div><br /><br />";
                    }
                    if($search_result = mysqli_query($conn, $search_expense_sql)){
                        $search_output.= "<center><h3>Total expenses</h3></center>";
                        $search_output.= "<div class='report-heading-row'>";
                        $search_output.= "<b>Order ID</b>";
                        $search_output.= "<b>Supplier</b>";
                        $search_output.= "<b>Merchandiser</b>";
                        $search_output.= "<b>Value (LKR)</b>";
                        $search_output.= "<b>Payment date</b>";
                        $search_output.= "<hr />";
                        $search_output.= "</div>";
                        $totalExpense = 0;
                        if(mysqli_num_rows($search_result) > 0){
                            while($search_row = mysqli_fetch_array($search_result)){
                                $search_output.= "<div class='report-data-row'>";
                                $search_output.= "<span>".$search_row["order_id"]."</span>";
                                $search_output.= "<span>".$search_row["supplier_first_name"]." ".$search_row["supplier_last_name"]."</span>";
                                $search_output.= "<span>".$search_row["merchandiser_first_name"]." ".$search_row["merchandiser_last_name"]."</span>";
                                $search_output.= "<span>".$search_row["payment"]."</span>";
                                $search_output.= "<span>".$search_row["payment_date"]."</span>";
                                $search_output.= "<hr />";
                                $search_output.= "</div>";
                                $totalExpense += $search_row["payment"];
                            }
                            
                        }else{
                            $search_output.= "<div class='report-data-row'>";
                            $search_output.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No expense found<br />";
                            $search_output.= "<hr />";
                            $search_output.= "</div>";
                        }
                        $search_output.= "<div class='report-data-row'>";
                        $search_output.= "<span><b>Total expense:</b></span>";
                        $search_output.= "<span></span>";
                        $search_output.= "<span></span>";
                        $search_output.= "<span style='color:#B90E0A;'><b>".$totalExpense."</b></span>";
                        $search_output.= "<span></span>";
                        $search_output.= "<hr />";
                        $search_output.= "</div><br /><br />";  
                    }
                    $search_output.= "<center><h3>Loss/profit</h3></center>";
                    $search_output.= "<div class='report-data-row'>";
                    $search_output.= "<hr />";
                    if($totalIncome >= $totalExpense){
                        $search_output.= "<span><b>Profit :</b></span>";
                    }else{
                        $search_output.= "<span><b>Loss :</b></span>";
                    }
                    $search_output.= "<span></span>";
                    $search_output.= "<span></span>";
                    if($totalIncome >= $totalExpense){
                        $profit = $totalIncome - $totalExpense;
                        $search_output.= "<span style='color:#0A6522;;'><b>".$profit."</b></span>";
                    }else{
                        $loss =  $totalExpense - $totalIncome;
                        $search_output.= "<span style='color:#B90E0A;'><b>".$loss."</b></span>";
                    }
                    $search_output.= "<span></span>";
                    $search_output.= "<hr />";
                    $search_output.= "</div><br /><br />";  
                    //For pdf download
                    $search_output.= "</div><textarea hidden='true' name='report_content' id='report_content'></textarea><center><input type='submit' name='pdf_download' value='Generate PDF' class='pdf-download-button' /></center></form>";
                }
                
            }
        ?>
        <script>
            function validateForm(){
                var formType = document.getElementById("report_type").value;
                if(formType == ""){
                    alert("Please select a report type");
                    return false;
                }else{
                    return true;
                } 
            }
            function editFields(){
                var formType = document.getElementById("report_type").value;
                if(formType == "income_report"){
                    var formFieldContent = "";
                }else if(formType == "loss_profit_report"){
                    var formFieldContent = "<div class='search-panel-row'>";
                    formFieldContent += "<div class='search-panel-row-left'>";
                    formFieldContent += "<input type='text' name='supplier_name' id='supplier_name' class='date-field' style='width:37%;' placeholder='Material supplier' />";
                    formFieldContent += "</div>";
                    formFieldContent += "</div>";
                }
                document.getElementById("supplier-name-panel").innerHTML = formFieldContent;
            }
        </script>
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Manager</a> > Reports
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Reports</h2>
                    </center>

                    <form method="post" action="reports.php" class="search-panel" onSubmit="return validateForm()">
                        <select class="text-field" id="report_type" name="report_type" onChange="editFields()">
                            <option value="" disabled selected >Select report type</option>
                            <option value="income_report">Income report</option>
                            <option value="loss_profit_report">Loss/profit report</option>
                        </select>
                        <input type="submit" value="search" name="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />

                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                <input type="text" name="merchandiser_name" id="merchandiser_name" class="date-field" style="width:70%;" placeholder="Merchandiser" />
                            </div>
                            <div class="search-panel-row-right">
                                <input type="text" name="customer_name" id="customer_name" class="date-field" style="width:70%;" placeholder="Customer" />
                            </div>
                        </div>
                        <div id="supplier-name-panel">
                            <!--Space for supplier name-->
                        </div>

                        <b>Duration : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="start_date" id="start_date" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="end_date" id="end_date" class="date-field" />
                            </div>
                        </div>
                    </form>

                    <div class="report-list">
                        <?php
                            echo $search_output;
                            echo $output;
                        ?>
                        <!--<div class="report-heading-row">
                            <b>Order ID</b>
                            <b>Customer</b>
                            <b>Merchandiser</b>
                            <b>Value (LKR)</b>
                            <b>Dispatch date</b>
                            <hr />
                        </div>
                        <div class="report-data-row">
                            <span>0003</span>
                            <span>John Doe</span>
                            <span>Kenny A</span>
                            <span>115000</span>
                            <span>2022-06-01</span>
                            <hr />
                        </div>
                        <div class="report-data-row">
                            <span>0004</span>
                            <span>John A</span>
                            <span>Harry Potter</span>
                            <span>250000</span>
                            <span>2022-08-01</span>
                            <hr />
                        </div>
                        <div class="report-data-row">
                            <span>0005</span>
                            <span>John C</span>
                            <span>Henry R</span>
                            <span>550000</span>
                            <span>2022-09-01</span>
                            <hr />
                        </div> -->
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
