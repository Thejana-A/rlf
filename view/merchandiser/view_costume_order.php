<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View costume order</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            
            if(isset($_GET['data'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
                //print_r($row);
            }else{
                $sql_view_costume_order = "SELECT order_id, costume_quotation.quotation_id, customer.customer_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, customer.contact_no, customer.email, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, issue_date, valid_till, advance_payment, advance_payment_date, order_status, quality_status, quality_status_description, balance_payment, order_placed_on, expected_delivery_date, dispatch_date FROM costume_quotation, costume_order, employee, customer WHERE costume_quotation.merchandiser_id = employee.employee_id AND costume_quotation.customer_id = customer.customer_id AND costume_order.quotation_id = costume_quotation.quotation_id AND costume_order.quotation_id = ".$_GET["quotation_id"].";";
                $result_view_costume_order = mysqli_query($conn, $sql_view_costume_order);
                $row = mysqli_fetch_array($result_view_costume_order);
            }

            $quotationID = $row["quotation_id"];
        
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            $sql_costume_quotation = "SELECT costume_design.design_id, name, quantity, unit_price FROM costume_design, design_quotation WHERE design_quotation.design_id = costume_design.design_id AND design_quotation.quotation_id = ".$row["quotation_id"].";";
                             
            if($result = mysqli_query($conn, $sql_costume_quotation)){
                if(mysqli_num_rows($result) > 0){
                    $costumeCount = 0; 
                    $costumeDesignList = ""; 
                    while($sql_costume_quotation = mysqli_fetch_array($result)){
                        $costumeDesignList .= "<div class='form-row'>";
                        $costumeDesignList .= "<div class='form-row-theme'>";
                        $costumeDesignList .= "<input type='text' name='design_id[]' value='".$sql_costume_quotation["design_id"]." - ".$sql_costume_quotation["name"]."' readonly />";
                        $costumeDesignList .= "</div>";
                        $costumeDesignList .= "<div class='form-row-data'>";
                        $costumeDesignList .= "<input type='number' step='0.001' min='0' name='quantity[]' id='quantity_".$costumeCount."' onChange='setPrice(".$costumeCount.")' class='column-textfield' value='".$sql_costume_quotation["quantity"]."' readonly required /> ";
                        $costumeDesignList .= "<input type='number' step='0.01' min='0' name='unit_price[]' id='unit_price_".$costumeCount."' onChange='setPrice(".$costumeCount.")' class='column-textfield' value='".$sql_costume_quotation["unit_price"]."' readonly /> ";
                        $costumeDesignList .= "<input type='text' name='costume_price[]'' id='costume_price_".$costumeCount."' class='column-textfield' value='' readonly />"; 
                        $costumeDesignList .= "</div>";
                        $costumeDesignList .= "</div>";
                        $costumeCount++;
                    }
                    
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql_costume_quotation. " . mysqli_error($conn);
            }  
        ?>

        <script>
            var costumeCount = "<?php echo $costumeCount; ?>";
            var totalPrice = 0;
            var totalQuantity = 0;

            function setPrice(){
                for(let i = 0;i < costumeCount;i++){
                    var quantity = document.getElementById("quantity_"+i).value;
                    var unitPrice = document.getElementById("unit_price_"+i).value;
                    document.getElementById("costume_price_"+i).value = quantity*unitPrice;
                    totalPrice = totalPrice + (quantity*unitPrice); 
                    totalQuantity = totalQuantity + (quantity*1); 
                } 
                var advancePayment = document.getElementById("advance_payment").value;
                document.getElementById("total_price").value = totalPrice;
                document.getElementById("total_quantity").value = totalQuantity;
                document.getElementById("balance_payment").value = totalPrice - advancePayment;
            } 

            function validateCostumeOrder(){
                var order_quality = document.forms["costumeOrderForm"]["quality_status"].value;
                
                if(order_quality == "good"){
                    document.forms["costumeOrderForm"]["order_status"].value = "complete";
                    return true;
                }
            }

        </script>
    </head>

    <body onLoad="setPrice()">
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Merchandiser</a> >
                    <a href="costume_orders.php">Costume orders </a> > View
                </div>

                <div id="form-box">
                    <form method="post" name="costumeOrderForm" onSubmit="return validateCostumeOrder()" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="costume_order/update" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/merchandiser/home.php" />
                        <center>
                            <h2>View costume order</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Order ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="order_id" value="<?php echo $row["order_id"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="quotation_id" value="<?php echo $row["quotation_id"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_id" value="<?php echo $row["customer_id"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_name" value="<?php echo $row["customer_first_name"]." ".$row["customer_last_name"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer contact no : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_contact_no" value="<?php echo $row["contact_no"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_email" value="<?php echo $row["email"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - Design name</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit price(LKR)</b></span>
                                <span><b>Price(LKR)</b></span>
                            </div>
                        </div>
                        <?php echo $costumeDesignList; ?>
                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                0005 - Black T-shirt-small
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0008 - Black T-shirt-large
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>  -->

                        <div class="form-row">
                            <div class="form-row-theme">
                                Total items :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="total_quantity" id="total_quantity" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Total price (LKR) :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="total_price" id="total_price" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation issuing date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="issue_date" id="issue_date" value="<?php echo $row["issue_date"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation Valid till :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="valid_till" id="valid_till" value="<?php echo $row["valid_till"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Order placed on :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="order_placed_on" id="order_placed_on" value="<?php echo $row["order_placed_on"]; ?>" readonly />
                            </div>
                        </div>
                        
                        <?php
                            if($row["advance_payment_date"] != NULL){
                                echo "<div class='form-row'>";
                                echo "<div class='form-row-theme'>";
                                echo "<b>Advance payment (LKR) :</b>";
                                echo "</div>";
                                echo "<div class='form-row-data'>";
                                echo "<input type='text' name='advance_payment' id='advance_payment' value='".$row["advance_payment"]."' readonly />";
                                echo "</div>";
                                echo "</div>";
                                echo "<div class='form-row'>";
                                echo "<div class='form-row-theme'>";
                                echo "Advance payment date :";
                                echo "</div>";
                                echo "<div class='form-row-data'>";
                                echo "<input type='date' name='advance_payment_date' id='advance_payment_date' value='".$row["advance_payment_date"]."' readonly />";
                                echo "</div>";
                                echo "</div>";
                            }else{
                                echo "<input type='text' hidden='true' name='advance_payment' id='advance_payment' value='".$row["advance_payment"]."' readonly />";
                                echo "<input type='date' hidden='true' name='advance_payment_date' id='advance_payment_date' value='".$row["advance_payment_date"]."' readonly />";
                            }
                        ?>


                        <div class="form-row">
                            <div class="form-row-theme">
                                Expected delivery date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="expected_delivery_date" id="expected_delivery_date" value="<?php echo $row["expected_delivery_date"]; ?>" readonly />
                            </div>
                        </div>
    
                        
                        <?php
                            if($row["advance_payment_date"] == NULL){
                                echo "<div class='form-row'>";
                                echo "<div class='form-row-theme'>";
                                echo "Order acceptance :";
                                echo "</div>";
                                echo "<div class='form-row-data'>";
                                echo "<table width='60%'>";
                                echo "<tr>";
                                echo "<td>";
                                //echo "<input type='text' name='order_status' hidden='true' value=(".$row["order_status"]." == 'confirmed')?'confirmed':(".$row["order_status"]." == 'pending'?'pending':'') />";
                                //echo "<input type='radio' name='order_status' class='input-radio' ((".$row["order_status"]." == 'accepted')?'checked':'') value='accepted' /> Accept";
                                echo "<input type='radio' name='order_status' class='input-radio' ".(($row["order_status"] == 'accepted')?'checked':'')." value='accepted' /> Accept";
                                echo "</td>";
                                echo "<td>";
                                //echo "<input type='radio' name='order_status' class='input-radio' ((".$row["order_status"]." == 'rejected')?'checked':'') value='rejected' /> Reject";
                                echo "<input type='radio' name='order_status' class='input-radio' ".(($row["order_status"] == 'rejected')?'checked':'')." value='rejected' /> Reject";
                                echo "</td>";
                                echo "</tr>";
                                echo "</table>";
                                echo "</div>";
                                echo "</div>";
                            }
                        ?>
                        
                        <?php
                            if($row["advance_payment_date"] != NULL){
                                if($row["dispatch_date"] == NULL){
                                    echo "<div class='form-row'>";
                                    echo "<div class='form-row-theme'>";
                                    echo "Product status :";
                                    echo "</div>";
                                    echo "<div class='form-row-data'>";
                                    echo "<table width='60%'>";
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<input type='radio' name='order_status' class='input-radio' ".($row["order_status"] == 'incomplete'?'checked':'')." value='incomplete' /> Incomplete";
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<input type='radio' name='order_status' class='input-radio' ".($row["order_status"] == 'complete'?'checked':'')." value='complete' /> Complete";
                                    echo "</td>";
                                    echo "</tr>";
                                    echo "</table>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                echo "<div class='form-row'>";
                                echo "<div class='form-row-theme'>";
                                echo "Quality (By manager) :";
                                echo "</div>";
                                echo "<div class='form-row-data'>";
                                echo "<table width='58%'>";
                                echo "<tr>";
                                echo "<td>";
                                echo "<input type='radio' name='quality_status' class='input-radio' value='good' ".(($row["quality_status"]=='good')?'checked':'disabled')." /> Good";
                                echo "</td>";
                                echo "<td>";
                                echo "<input type='radio' name='quality_status' class='input-radio' value='bad' ".(($row["quality_status"]=='bad')?'checked':'disabled')." /> Bad";
                                echo "</td>";
                                echo "</tr>";
                                echo "</table>";
                                echo "</div>";
                                echo "</div>";
                                echo "<div class='form-row'>";
                                echo "<div class='form-row-theme'>";
                                echo "Quality description :";
                                echo "</div>";
                                echo "<div class='form-row-data'>";
                                echo "<textarea id='quality_status_description' name='quality_status_description' rows='4' cols='40' readonly>".$row["quality_status_description"]."</textarea>";
                                echo "</div>";
                                echo "</div>";
                                echo "<div class='form-row'>";
                                echo "<div class='form-row-theme'>";
                                echo "<b>Balance payment (LKR) :</b>";
                                echo "</div>";
                                echo "<div class='form-row-data'>";
                                echo "<input type='text' name='balance_payment' id='balance_payment' readonly />";
                                echo "</div>";
                                echo "</div>";
                                if($row["quality_status"]=='good'){
                                    echo "<div class='form-row'>";
                                    echo "<div class='form-row-theme'>";
                                    echo "Dispatched date :";
                                    echo "</div>";
                                    echo "<div class='form-row-data'>";
                                    echo "<input type='date' name='dispatch_date' id='dispatch_date' value='".$row["dispatch_date"]."' ".(($row["dispatch_date"]==NULL)?'':'readonly')." />";
                                    echo "</div>";
                                    echo "</div>";
                                }     
                            }
                        ?>
                        
                        <?php
                            if($row["dispatch_date"] == NULL){
                                echo "<div class='form-row'>";
                                echo "<div class='form-row-submit'>";
                                echo "<input type='submit' value='Save' />";
                                echo "</div>";
                                echo "<div class='form-row-reset'>";
                                echo "<input type='reset' value='Cancel' />";
                                echo "</div>";
                                echo "</div>";
                            }
                        ?>
                    </form>
                </div>   
            </div> 
        </div> 

        <?php include 'footer.php';?>
        <script>
            function addLeadingZeros(num, totalLength) {
                return String(num).padStart(totalLength, '0');
            }
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; 
            var yyyy = today.getFullYear();
            var min_dispatch_date = yyyy + '-' + addLeadingZeros(mm,2) + '-' + addLeadingZeros(dd,2);
            var max_dispatch_date = yyyy + '-' + addLeadingZeros(mm,2) + '-' + addLeadingZeros(dd,2);
            document.getElementById("dispatch_date").setAttribute("max", max_dispatch_date);
            document.getElementById("dispatch_date").setAttribute("min", min_dispatch_date);
        </script>


    </body> 
</html>
