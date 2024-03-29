<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View costume quotation</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
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
                $sql_view_costume_quotation = "SELECT quotation_id, customer.customer_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, customer.contact_no, customer.email, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, issue_date, valid_till, manager_approval, approval_description FROM costume_quotation, employee, customer where costume_quotation.merchandiser_id = employee.employee_id AND costume_quotation.customer_id = customer.customer_id AND quotation_id=".$_GET["quotation_id"].";";
                $result_view_costume_quotation = mysqli_query($conn, $sql_view_costume_quotation);
                $row = mysqli_fetch_array($result_view_costume_quotation);
            }

            $quotationID = $row["quotation_id"];
            
            $sql_costume_order = "SELECT * FROM costume_order WHERE quotation_id = '$quotationID';";  
            $costume_order_result = mysqli_query($conn, $sql_costume_order);  
            
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
                        $costumeDesignList .= "<input type='number' step='1' min='0' name='quantity[]' id='quantity_".$costumeCount."' onChange='setPrice(".$costumeCount.")' class='column-textfield' value='".$sql_costume_quotation["quantity"]."' required /> ";
                        $costumeDesignList .= "<input type='number' step='1' min='0' name='unit_price[]' id='unit_price_".$costumeCount."' onChange='setPrice(".$costumeCount.")' class='column-textfield' value='".$sql_costume_quotation["unit_price"]."' readonly /> ";
                        $costumeDesignList .= "<input type='text' name='costume_price[]'' id='costume_price_".$costumeCount."' class='column-textfield' value='' readonly />"; 
                        $costumeDesignList .= "</div>";
                        $costumeDesignList .= "</div>";
                        $costumeCount++;
                    }
                    
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql_design_material. " . mysqli_error($conn);
            }  
        ?>

        <script>
            var costumeCount = "<?php echo $costumeCount; ?>";
            function setPrice(){
                var totalPrice = 0;
                var totalQuantity = 0;
                for(let i = 0;i < costumeCount;i++){
                    var quantity = document.getElementById("quantity_"+i).value;
                    var unitPrice = document.getElementById("unit_price_"+i).value;
                    document.getElementById("costume_price_"+i).value = quantity*unitPrice;
                    totalPrice = totalPrice + (quantity*unitPrice); 
                    totalQuantity = totalQuantity + (quantity*1); 
                } 
                document.getElementById("total_price").value = totalPrice;
                document.getElementById("total_quantity").value = totalQuantity;
            } 

            function validateForm(){
                var manager_approval = document.forms["costumeQuotationForm"]["manager_approval"].value;
                var approval_description = document.forms["costumeQuotationForm"]["approval_description"].value;
                var total_quantity = document.forms["costumeQuotationForm"]["total_quantity"].value;
            
                if(total_quantity <= 0){
                    alert("At least one item should be selected");
                    return false;
                }else if(manager_approval == "") {
                    alert("Manager approval is required");
                    return false;
                }else if ((manager_approval == "reject")&&(approval_description == "")) {
                    alert("Reason for rejection is required");
                    return false;
                }else if(total_quantity > 0){   
                    for(let j = 0;j < costumeCount;j++){
                        var costume_quantity = document.getElementById("quantity_"+j).value;
                        if((costume_quantity>0)&&(costume_quantity<5)){
                            alert("Minimum order quantity is 5");
                            return false;
                        }
                    }
                }else{
                    return true;
                } 
            }

            function Disable() {
                document.getElementById("valid_till").disabled = true;
            }
            function Enable(){
                document.getElementById("valid_till").disabled = false;
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
                    <a href="home.php">Manager</a> >
                    <a href="costume_quotations.php">Costume designs quotation </a> > View
                </div>

                <div id="form-box">
                    <form method="post" name="costumeQuotationForm" onSubmit="return validateForm()" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="costume_quotation/manager_update" />
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <center>
                            <h2>Edit costume quotation</h2>
                        </center>
                    
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
                                Merchandiser ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="merchandiser_id" value="<?php echo $row["employee_id"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="merchandiser_name" value="<?php echo $row["merchandiser_first_name"]." ".$row["merchandiser_last_name"]; ?>" readonly />
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
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0008 - Black T-shirt-large
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0010 - Black T-shirt-XXL
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                                <input type="text" name="" id="" class="column-textfield" readonly />
                            </div>
                        </div> -->
                        <div class="form-row">
                            <div class="form-row-theme">
                                <a style="text-decoration:none;" href="costume_order_material_description.php?quotation_id=<?php echo $row["quotation_id"]; ?>">View raw material description</a>
                            </div>
                            <div class="form-row-data">
                            </div>
                        </div>

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
                                <input type="date" name="issue_date" id="issue_date" value="<?php echo ($row["issue_date"])==""?Date("Y-m-d"):$row["issue_date"]; ?>" readonly />
                                <input type="date" hidden="true" name="approval_date" id="approval_date" value="<?php echo ($row["approval_date"])==""?Date("Y-m-d"):$row["approval_date"]; ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation Valid till :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="valid_till" id="valid_till" value="<?php echo $row["valid_till"]; ?>" <?php echo ($row["manager_approval"]=="reject")?"disabled":""; ?> required />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Approval (By manager) :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="manager_approval" value="approve" class="input-radio" <?php echo ($row["manager_approval"]=="approve")?'checked':'' ?> onChange="Enable()" /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="manager_approval" value="reject" class="input-radio" <?php echo ($row["manager_approval"]=="reject")?'checked':'' ?> onChange="Disable()" /> Reject
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Approval description :
                            </div>
                            <div class="form-row-data">
                                <textarea name="approval_description" rows="4" cols="40"><?php echo $row["approval_description"]; ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <?php 
                                    if(mysqli_num_rows($costume_order_result)>0){
                                        echo "<a style='text-decoration:none;' href='view_costume_order.php?quotation_id=".$row["quotation_id"]."' >View costume order</a>";
                                    }
                                ?>
                            </div>
                            <div class="form-row-data">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <?php 
                                    if(mysqli_num_rows($costume_order_result)==0){
                                        echo "<input type='submit' value='Save' name='update_costume_quotation' />";
                                    }else{
                                        echo "<input type='submit' value='Save' name='update_costume_quotation' disabled />";
                                    }
                                ?>
                            </div>
                            <div class="form-row-reset">
                                <?php 
                                    if(($row["manager_approval"] == "approve")&&($row["valid_till"])>Date("Y-m-d")&&(mysqli_num_rows($costume_order_result)==0)){
                                        echo "<input type='submit' value='Add costume order' name='add_costume_order' />";
                                    }else{
                                        echo "<input type='submit' value='Add costume order' name='add_costume_order' disabled />";
                                    }
                                ?>
                            </div>
                        </div> 
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
            mm = mm+2;
            var yyyy = today.getFullYear();

            var min_valid_till = yyyy + '-' + addLeadingZeros(mm,2) + '-' + addLeadingZeros(dd,2);
            var max_valid_till = new Date();
            max_valid_till.setYear(max_valid_till.getFullYear()+2);
            max_valid_till = max_valid_till.getFullYear() + '-' + addLeadingZeros(max_valid_till.getMonth(),2) + '-' + addLeadingZeros(max_valid_till.getDate(),2);

            document.getElementById("valid_till").setAttribute("min", min_valid_till);
            document.getElementById("valid_till").setAttribute("max", max_valid_till);
        </script>

    </body> 
</html>
