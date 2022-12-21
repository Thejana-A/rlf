<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Create costume quotation</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <script>
            let costumeQuotation = [[]];
            let merchandiser = [[]];
        </script>
        <?php 
            $conn = new mysqli("localhost", "root", "", "rlf");
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            } 

            //costume name list to be displayed
            $costume_sql = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE final_price IS NOT NULL";
            $costumeNameCount = 0;
            $costumeNameList = "";
            if($costumeNameResult = mysqli_query($conn, $costume_sql)){
                if(mysqli_num_rows($costumeNameResult) > 0){
                    $costumeNameList .= "<select name='select_costume_name' id='select_costume_name' onChange='selectCostume()' required>";
                    $costumeNameList .= "<option disabled selected>ID - Costume</option>";
                    while($costume_name = mysqli_fetch_array($costumeNameResult)){
                        $costumeNameList .= "<option value='".$costumeNameCount."'>".$costume_name["costume_name"]."</option>";
                        $costume_quotation_sql = "SELECT design_id, name, final_price FROM costume_design WHERE final_price IS NOT NULL AND (name LIKE '".$costume_name["costume_name"]."-__' OR name LIKE '".$costume_name["costume_name"]."-_')";
                        if($result = mysqli_query($conn, $costume_quotation_sql)){
                            if(mysqli_num_rows($result) > 0){
                                $costumeCountForName = 0; ?>
                                <script> costumeListForName = []; </script>
                            <?php 
                                while($costume_quotation_row = mysqli_fetch_array($result)){  ?>                                 
                                    <script> costumeListForName["<?php echo $costumeCountForName; ?>"] = ["<?php echo $costume_quotation_row["design_id"]; ?>", "<?php echo $costume_quotation_row["name"]; ?>", "<?php echo $costume_quotation_row["final_price"]; ?>"]; </script>
                            <?php   
                                    if($costumeCountForName == 0){
                                        $merchandiser_sql = "SELECT employee_id, first_name, last_name FROM employee INNER JOIN costume_design ON costume_design.merchandiser_id = employee.employee_id WHERE costume_design.design_id = ".$costume_quotation_row["design_id"].";";
                                        if($merchandiserResult = mysqli_query($conn, $merchandiser_sql)){
                                            if(mysqli_num_rows($merchandiserResult) > 0){
                                                while($merchandiser_row = mysqli_fetch_array($merchandiserResult)){ 
                                                    if($costumeNameCount == 0){ ?>
                                                        <script>merchandiser[0] = ["<?php echo $merchandiser_row["employee_id"] ?>", "<?php echo $merchandiser_row["first_name"] ?>", "<?php echo $merchandiser_row["last_name"] ?>"];</script>
                            <?php                   }else{  ?>
                                                        <script>merchandiser.push(["<?php echo $merchandiser_row["employee_id"] ?>", "<?php echo $merchandiser_row["first_name"] ?>", "<?php echo $merchandiser_row["last_name"] ?>"]);</script>
                            <?php                   }
                                                }
                                            }else {
                                                echo "0 results";
                                            }
                                        }else{
                                            echo "ERROR: Could not able to execute $merchandiser_sql. " . mysqli_error($conn);
                                        }
                                    }
                                    $costumeCountForName++;                   
                                }       
                            } 
                        } 
                        if($costumeNameCount == 0){ ?>
                            <script> costumeQuotation[0] = costumeListForName </script>                
                <?php   }else{ ?>
                            <script> costumeQuotation.push(costumeListForName) </script> 
                <?php   }
                        $costumeNameCount++;
                    } 
                    $costumeNameList .= "</select>";
                }else {
                $costumeNameList .= "0 results";
                }
            }else{
                $costumeNameList .= "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
        ?>
        
        <script>
            var costumeSizeCount = 0;
            function selectCustomer(){
                var customerDetails = document.getElementById("customer_id").value;
                var customerContactNo = customerDetails.split("-")[1];
                var customerEmail = customerDetails.split("-")[2];
                document.getElementById("customer_contact_no").value = customerContactNo;
                document.getElementById("customer_email").value = customerEmail;
            }
            
            function selectCostume(){
                var costumeName = document.getElementById("select_costume_name").value;
                var costumeList = "";
                for(var i = 0;i <(costumeQuotation[costumeName]).length;i++){
                    costumeList += "<div class='form-row'>";
                    costumeList += "<div class='form-row-theme'>";
                    costumeList += "<input type = 'text' name='design_id[]' value='"+costumeQuotation[costumeName][i][0]+" - "+costumeQuotation[costumeName][i][1]+"' readonly />";
                    costumeList += "</div>";
                    costumeList += "<div class='form-row-data'>";
                    costumeList += "<input type='number' min='0' step='1' name='quantity[]' id='quantity_"+i+"' onChange='setPrice("+i+")' class='column-textfield' value='0' required />&nbsp";
                    costumeList += "<input type='text' name='unit_price[]' id='unit_price_"+i+"' class='column-textfield' value='"+costumeQuotation[costumeName][i][2]+"' readonly />&nbsp";
                    costumeList += "<input type='text' name='price[]' id='price_"+i+"' class='column-textfield' readonly />";
                    costumeList += "</div>";
                    costumeList += "</div>";
                }
                costumeSizeCount = (costumeQuotation[costumeName]).length;
                document.getElementById("form-body").innerHTML = costumeList;
                document.getElementById("merchandiser_id").value = merchandiser[costumeName][0];
                document.getElementById("merchandiser_name").value = merchandiser[costumeName][1]+" "+merchandiser[costumeName][2];
            }

            function setPrice(costumeRowCount){
                var quantity = document.getElementById("quantity_"+costumeRowCount).value;
                var unitPrice = document.getElementById("unit_price_"+costumeRowCount).value;
                var product = quantity*unitPrice;
                document.getElementById("price_"+costumeRowCount).value = product;
                var totalQuantity = 0;
                var totalPrice = 0;
                for(let i = 0;i < costumeSizeCount;i++){
                    var quantity = document.getElementById("quantity_"+i).value;
                    var unitPrice = document.getElementById("unit_price_"+i).value;
                    totalQuantity = parseInt(totalQuantity) + parseInt(quantity);
                    totalPrice = parseInt(totalPrice) + (parseInt(quantity)*parseInt(unitPrice));
                } 
                document.getElementById("total_quantity").value = totalQuantity;
                document.getElementById("total_price").value = totalPrice;
            } 
            function validateForm(){
                var total_quantity = document.forms["costumeQuotationForm"]["total_quantity"].value;
                if(total_quantity <= 0){
                    alert("At least one item should be selected");
                    return false; 
                }else{
                    return true;  
                }
            }
        
        </script>
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Manager </a> >
                    <a href="#">Costume designs quotations </a> > Create a costume quotation
                </div>

                <div id="form-box">
                    <form method="post" name="costumeQuotationForm" onSubmit="return validateForm()" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="costume_quotation/add" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <center>
                            <h2>Create costume quotation (onsite)</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer ID : 
                            </div>
                            <div class="form-row-data">
                                <?php 
                                    $customer_sql = "SELECT customer_id, first_name, last_name, contact_no, email FROM customer";
                                    if($result = mysqli_query($conn, $customer_sql)){
                                        if(mysqli_num_rows($result) > 0){
                                            echo "<select name='customer_id' id='customer_id' onChange='selectCustomer()' required>";
                                            echo "<option disabled selected>ID - Customer</option>";
                                            while($customer_row = mysqli_fetch_array($result)){
                                                echo "<option value='".$customer_row["customer_id"]."-".$customer_row["contact_no"]."-".$customer_row["email"]."'>".$customer_row["customer_id"]." - ".$customer_row["first_name"]." ".$customer_row["last_name"]."</option>";
                                            }
                                            echo "</select>";
                                        }else {
                                            echo "0 results";
                                        }
                                    }else{
                                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                                    }
                                ?>
                                <!--<select name="" id="">
                                    <option>0001 - John Doe</option>
                                    <option>0002 - Harry Potter</option>
                                    <option>0004 - John A</option>
                                </select> -->
                            </div>
                        </div>
                
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer contact no : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_contact_no" id="customer_contact_no" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_email" id="customer_email" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Costume design : 
                            </div>
                            <div class="form-row-data">
                                <?php echo $costumeNameList; ?>
                                <!--<select name="" id="">
                                    <option>0001 - Black T-shirt-S</option>
                                    <option>0002 - Black T-shirt-M</option>
                                    <option>0004 - Red stripped-shirt-XL</option>
                                </select> -->
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="merchandiser_id" id="merchandiser_id" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="merchandiser_name" id="merchandiser_name" readonly />
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
                        <div id="form-body">
                            
                        </div>
                        <!--<div class="form-row">
                            <div class="form-row-theme">
                                0001 - Black T-shirt-S
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0002 - Black T-shirt-L
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" />
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
                                Quotation issued on :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="issue_date" id="issue_date" value="<?php echo Date("Y-m-d"); ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation valid till :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="valid_till" id="valid_till" required />
                            </div>
                        </div>
                        <input type="text" hidden="true" name="manager_approval" value="approve" />
                        <input type="date" hidden="true" name="approval_date" value="<?php echo date("Y-m-d"); ?>" />
                        <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
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
            var yyyy = today.getFullYear();
            var min_issue_date = yyyy + '-' + addLeadingZeros(mm,2) + '-' + addLeadingZeros(dd,2);
            var max_issue_date = new Date();
            max_issue_date.setMonth(max_issue_date.getMonth()+2);
            max_issue_date = max_issue_date.getFullYear() + '-' + addLeadingZeros(max_issue_date.getMonth(),2) + '-' + addLeadingZeros(max_issue_date.getDate(),2);

            var min_valid_till = new Date();
            min_valid_till.setMonth(min_valid_till.getMonth()+3);
            min_valid_till = min_valid_till.getFullYear() + '-' + addLeadingZeros(min_valid_till.getMonth(),2) + '-' + addLeadingZeros(min_valid_till.getDate(),2);
            var max_valid_till = new Date();
            max_valid_till.setYear(max_valid_till.getFullYear()+2);
            max_valid_till = max_valid_till.getFullYear() + '-' + addLeadingZeros(max_valid_till.getMonth(),2) + '-' + addLeadingZeros(max_valid_till.getDate(),2);

            document.getElementById("issue_date").setAttribute("min", min_issue_date);
            document.getElementById("issue_date").setAttribute("max", max_issue_date);

            document.getElementById("valid_till").setAttribute("min", min_valid_till);
            document.getElementById("valid_till").setAttribute("max", max_valid_till);
        </script>
        
    </body> 
</html>
