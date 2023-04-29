<link rel="stylesheet" type="text/css" href="../css/calendar.css" />
<script>
    const quotation_request_dates = [];
    var quotation_request__count = 0;
    const material_order_dates = [];
    var material_order_count = 0;
</script>
<?php

    $today_date = date("Y-m-d");
    $first_date = date("Y-m-01", strtotime($today_date));
    $last_date = date("Y-m-t", strtotime($today_date)); 
    $sql_quotation_request = "SELECT order_id, costume_quotation.quotation_id, customer.customer_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, customer.contact_no, customer.email, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, issue_date, valid_till, advance_payment, advance_payment_date, order_status, quality_status, quality_status_description, balance_payment, order_placed_on, expected_delivery_date, dispatch_date FROM costume_quotation, costume_order, employee, customer WHERE costume_quotation.merchandiser_id = employee.employee_id AND costume_quotation.customer_id = customer.customer_id AND costume_order.quotation_id = costume_quotation.quotation_id AND costume_order.expected_delivery_date >= '$first_date' AND costume_order.expected_delivery_date <= '$last_date' AND (costume_order.advance_payment IS NOT NULL) AND (costume_order.dispatch_date IS NULL);";
    $result_quotation_request = mysqli_query($conn, $sql_quotation_request);
    if(mysqli_num_rows($result_quotation_request) > 0){
        while($quotation_request_row = mysqli_fetch_array($result_quotation_request)){
            ?><script>
                quotation_request_dates[quotation_request_count] = "<?php echo explode("-",$quotation_request_row["expected_delivery_date"])[2]; ?>";
                costume_order_count++;
            </script><?php
        }
    }

    $sql_material_order = "SELECT raw_material_quotation.quotation_id, order_id, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, supplier.contact_no, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, issue_date, valid_till, expected_delivery_date, raw_material_order.manager_approval, raw_material_order.approval_description, dispatch_date, payment, payment_date FROM raw_material_quotation, raw_material_order, supplier, employee WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material_quotation.expected_delivery_date >= '$first_date' AND raw_material_quotation.expected_delivery_date <= '$last_date' AND (raw_material_order.dispatch_date IS NULL) AND (raw_material_order.manager_approval != 'reject');";
    $result_material_order = mysqli_query($conn, $sql_material_order);
    if(mysqli_num_rows($result_material_order) > 0){
        while($material_order_row = mysqli_fetch_array($result_material_order)){
            ?><script>
                material_order_dates[material_order_count] = "<?php echo explode("-",$material_order_row["expected_delivery_date"])[2]; ?>";
                material_order_count++;
            </script><?php
        }
    }
    
?>

<script>
    function getNumberOfDaysInMonth(year, month) {
        return new Date(year, month, 0).getDate();
    } 
    const date = new Date();
    var calendar = "";
    var currentYear = date.getFullYear();
    var currentMonth = date.getMonth();
    const firstOfThisMonth = new Date(currentYear+"-"+(currentMonth+1)+"-"+01);
    var dayOfFirstThisMonth = firstOfThisMonth.getDay();
    var numberOfDate = 1;
    var multiplicationFactor = 0;
    var numberOfDaysInMonth = getNumberOfDaysInMonth(currentYear, (currentMonth+1));
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    
    calendar += "<table border='1'>"; 
    calendar += "<tr><td colspan='7' style='background-color:#FFA500;'><center><b>"+currentYear+"</b></center></td></tr>";
    calendar += "<tr><td colspan='7' style='background-color:#cccccc;'><center><b>"+months[currentMonth]+"</b></center></td></tr>";
    calendar += "<tr class='nameOfDay'><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td></tr>";
    switch(dayOfFirstThisMonth){
        case 0: 
            while(numberOfDate < numberOfDaysInMonth){
                calendar += "<tr>";
                while(numberOfDate <= 7+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            if((quotation_request_dates.includes(numberOfDate.toString())==true)&&(material_order_dates.includes(numberOfDate.toString())==true)){
                                calendar += "<td class='both_order_cell'>"+numberOfDate+"</td>";
                            }else if(quotation_request_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='quotation_request_cell'>"+numberOfDate+"</td>";
                            }else if(material_order_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='material_order_cell'>"+numberOfDate+"</td>";
                            }else{
                                calendar += "<td>"+numberOfDate+"</td>";
                            }
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 1: 
            while(numberOfDate < numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 6+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            if((quotation_request_dates.includes(numberOfDate.toString())==true)&&(material_order_dates.includes(numberOfDate.toString())==true)){
                                calendar += "<td class='both_order_cell'>"+numberOfDate+"</td>";
                            }else if(quotation_request_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='quotation_request_cell'>"+numberOfDate+"</td>";
                            }else if(material_order_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='material_order_cell'>"+numberOfDate+"</td>";
                            }else{
                                calendar += "<td>"+numberOfDate+"</td>";
                            }
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 2: 
            while(numberOfDate < numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 5+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            if((quotation_request_dates.includes(numberOfDate.toString())==true)&&(material_order_dates.includes(numberOfDate.toString())==true)){
                                calendar += "<td class='both_order_cell'>"+numberOfDate+"</td>";
                            }else if(quotation_request_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='quotation_request_cell'>"+numberOfDate+"</td>";
                            }else if(material_order_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='material_order_cell'>"+numberOfDate+"</td>";
                            }else{
                                calendar += "<td>"+numberOfDate+"</td>";
                            }
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 3: 
            while(numberOfDate < numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td><td></td><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 4+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            if((quotation_request_dates.includes(numberOfDate.toString())==true)&&(material_order_dates.includes(numberOfDate.toString())==true)){
                                calendar += "<td class='both_order_cell'>"+numberOfDate+"</td>";
                            }else if(quotation_request_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='quotation_request_cell'>"+numberOfDate+"</td>";
                            }else if(material_order_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='material_order_cell'>"+numberOfDate+"</td>";
                            }else{
                                calendar += "<td>"+numberOfDate+"</td>";
                            }
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 4: 
            while(numberOfDate < numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td><td></td><td></td><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 3+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            if((quotation_request_dates.includes(numberOfDate.toString())==true)&&(material_order_dates.includes(numberOfDate.toString())==true)){
                                calendar += "<td class='both_order_cell'>"+numberOfDate+"</td>";
                            }else if(quotation_request_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='quotation_request_cell'>"+numberOfDate+"</td>";
                            }else if(material_order_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='material_order_cell'>"+numberOfDate+"</td>";
                            }else{
                                calendar += "<td>"+numberOfDate+"</td>";
                            }
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 5: 
            while(numberOfDate < numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td><td></td><td></td><td></td><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 2+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            if((quotation_request_dates.includes(numberOfDate.toString())==true)&&(material_order_dates.includes(numberOfDate.toString())==true)){
                                calendar += "<td class='both_order_cell'>"+numberOfDate+"</td>";
                            }else if(quotation_request_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='quotation_request_cell'>"+numberOfDate+"</td>";
                            }else if(material_order_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='material_order_cell'>"+numberOfDate+"</td>";
                            }else{
                                calendar += "<td>"+numberOfDate+"</td>";
                            }
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
        case 6: 
            while(numberOfDate <= numberOfDaysInMonth){
                if(multiplicationFactor == 0){
                    calendar += "<tr><td></td><td></td><td></td><td></td><td></td><td></td>";
                }else{
                    calendar += "<tr>";
                }
                while(numberOfDate <= 1+(7*multiplicationFactor)){
                    if(numberOfDate <= numberOfDaysInMonth){
                        if(numberOfDate == date.getDate()){
                            calendar += "<td class='today_cell'>"+numberOfDate+"</td>";
                        }else{
                            if((quotation_request_dates.includes(numberOfDate.toString())==true)&&(material_order_dates.includes(numberOfDate.toString())==true)){
                                calendar += "<td class='both_order_cell'>"+numberOfDate+"</td>";
                            }else if(quotation_request_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='quotation_request_cell'>"+numberOfDate+"</td>";
                            }else if(material_order_dates.includes(numberOfDate.toString())==true){
                                calendar += "<td class='material_order_cell'>"+numberOfDate+"</td>";
                            }else{
                                calendar += "<td>"+numberOfDate+"</td>";
                            }
                        }
                    }else{
                        calendar += "<td></td>";
                    }
                    numberOfDate++;
                }
                calendar += "</tr>"
                multiplicationFactor++;
            }
            break;
    }
            

    calendar += "</table>";
    document.write(calendar);
    //alert(costume_order_dates);
    //alert(material_order_dates);
</script>


    

