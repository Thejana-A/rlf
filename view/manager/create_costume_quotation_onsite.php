<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Create costume quotation</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php 
            $conn = new mysqli("localhost", "root", "", "rlf");
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            } 

            function selectCostumeDesign($designName){
                $costume_quotation_sql = "SELECT design_id, name, final_price FROM costume_design WHERE final_price IS NOT NULL AND (name LIKE '".$designName."-__' OR name LIKE '".$designName."-_')";
                $costume_list = "";
                if($result = mysqli_query($conn, $costume_quotation_sql)){
                    $costumeRowCount = 0;
                    if(mysqli_num_rows($result) > 0){
                        while($costume_quotation_row = mysqli_fetch_array($result)){
                            $costume_list .= "<div class='form-row'>";
                            $costume_list .= "<div class='form-row-theme'>";
                            $costume_list .= "<input type = 'text' name='costume_id[]' value='".$costume_quotation_row["design_id"]." - ".$costume_quotation_row["name"]."' readonly />";
                            $costume_list .= "</div>";
                            $costume_list .= "<div class='form-row-data'>";
                            $costume_list .= "<input type='number' min='0' step='1' name='quantity[]' id='quantity_".$costumeRowCount."' onChange='setPrice(".$costumeRowCount.")' class='column-textfield' value='0' required />&nbsp";
                            $costume_list .= "<input type='text' name='unit_price[]' id='unit_price_".$costumeRowCount."' class='column-textfield' value='".$costume_quotation_row["final_price"]."' readonly />&nbsp";
                            $costume_list .= "<input type='text' name='price[]' id='price_".$costumeRowCount."' class='column-textfield' readonly />";
                            $costume_list .= "</div>";
                            $costume_list .= "</div>";
                            $costumeRowCount++;
                        }
                    }else {
                        $costume_list .= "0 results";
                    }
                }else{
                    $costume_list .= "ERROR: Could not able to execute $costume_quotation_sql. " . mysqli_error($conn);
                } 
                return $costume_list;
            }
                
        ?>
        <script>
            function selectCustomer(){
                var customerDetails = document.getElementById("customer_id").value;
                var customerContactNo = customerDetails.split("-")[1];
                var customerEmail = customerDetails.split("-")[2];
                document.getElementById("customer_contact_no").value = customerContactNo;
                document.getElementById("customer_email").value = customerEmail;
            }
            
            function selectCostume(){
                var costumeName = document.getElementById("select_costume_name").value;
                //document.cookie = "costume_name="+costumeName+";path=/"; 
                
                document.getElementById("form-body").innerHTML = "<?php echo $xx; ?>";
            }

            function setPrice(costumeRowCount){
                var quantity = document.getElementById("quantity_"+costumeRowCount).value;
                var unitPrice = document.getElementById("unit_price_"+costumeRowCount).value;
                var product = quantity*unitPrice;
                document.getElementById("price_"+costumeRowCount).value = product;
                var totalQuantity = 0;
                var totalPrice = 0;
                for(let i = 0;i < <?php echo $costumeRowCount; ?>;i++){
                    var quantity = document.getElementById("quantity_"+i).value;
                    var unitPrice = document.getElementById("unit_price_"+i).value;
                    totalQuantity = parseInt(totalQuantity) + parseInt(quantity);
                    totalPrice = parseInt(totalPrice) + (parseInt(quantity)*parseInt(unitPrice));
                } 
                document.getElementById("total_quantity").value = totalQuantity;
                document.getElementById("total_price").value = totalPrice;
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
                    <form method="post" action="">
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
                                            echo "<option disabled>ID - Customer</option>";
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
                                <?php 
                                    //$costume_sql = "SELECT design_id, name FROM costume_design where customized_design_approval = 'approve'";
                                    $costume_sql = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE final_price IS NOT NULL";
                                    if($result = mysqli_query($conn, $costume_sql)){
                                        if(mysqli_num_rows($result) > 0){
                                            echo "<select name='select_costume_name' id='select_costume_name' onChange='selectCostume()' required>";
                                            echo "<option disabled>ID - Costume</option>";
                                            while($costume_name = mysqli_fetch_array($result)){
                                                echo "<option value='".$costume_name["costume_name"]."'>".$costume_name["costume_name"]."</option>";
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
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
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
                                <input type="date" name="issue_date" id="issue_date" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation valid till :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="valid_till" id="valid_till" />
                            </div>
                        </div>
                        
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

            var min_valid_till = new Date();
            min_valid_till.setMonth(min_valid_till.getMonth()+3);
            min_valid_till = min_valid_till.getFullYear() + '-' + addLeadingZeros(min_valid_till.getMonth(),2) + '-' + addLeadingZeros(min_valid_till.getDate(),2);
            
            document.getElementById("issue_date").setAttribute("min", min_issue_date);
            document.getElementById("valid_till").setAttribute("min", min_valid_till);
        </script>
        
    </body> 
</html>
