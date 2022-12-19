<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Create costume quotation</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="customer_css.css" />
        <script>
            let costumeQuotation = [[]];
            let merchandiser = [[]];
        </script>
        <?php 
            session_start();
            $sname= "localhost";
            $unmae= "root";
            $password = "";
            $db_name = "rlf";
            $conn = mysqli_connect($sname, $unmae, $password, $db_name);
            $design_id = $_GET['design_id']; 
            $sql = "SELECT * FROM `costume_design` WHERE `design_id` = $design_id;";

            $path = mysqli_query($conn, $sql);
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                    $name = $row["name"];
                    
                    
        
                
            
            /*$conn = new mysqli("localhost", "root", "", "rlft");
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
                    $costumeNameList .= "<option disabled>ID - Costume</option>";
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
            */
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
                var costumeList = "";
                for(var i = 0;i <(costumeQuotation[costumeName]).length;i++){
                    costumeList += "<div class='form-row'>";
                    costumeList += "<div class='form-row-theme'>";
                    costumeList += "<input type = 'text' name='costume_id[]' value='"+costumeQuotation[costumeName][i][0]+" - "+costumeQuotation[costumeName][i][1]+"' readonly />";
                    costumeList += "</div>";
                    costumeList += "<div class='form-row-data'>";
                    costumeList += "<input type='number' min='0' step='1' name='quantity[]' id='quantity_"+i+"' onChange='setPrice("+i+")' class='column-textfield' value='0' required />&nbsp";
                    costumeList += "<input type='text' name='unit_price[]' id='unit_price_"+i+"' class='column-textfield' value='"+costumeQuotation[costumeName][i][2]+"' readonly />&nbsp";
                    costumeList += "<input type='text' name='price[]' id='price_"+i+"' class='column-textfield' readonly />";
                    costumeList += "</div>";
                    costumeList += "</div>";
                }
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
                for(let i = 0;i < 2;i++){
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
        

        <div id="page-body">
            

            <div >
                <div id="breadcrumb">
                    <a href="customer_home.php">Home </a> > Request Quotation
                </div>
                
                <div id="form-box" >
                    <form method="post" name="costumeQuotationForm" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="costume_quotation/add" />
                        <center>
                            <h2>Request costume quotation</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer Name : 
                            </div>
                            <div class="form-row-data">
                            <input type="text" name="customer_name" value="<?php echo  $_SESSION['first_name']." ".$_SESSION['last_name'] ;?>" readonly /> 
                            </div>
                        </div>
                
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer contact no : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_contact_no" value="<?php echo  $_SESSION['contact_no'] ?> " readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="customer_email" value="<?php echo  $_SESSION['email'] ?> " readonly />
                            </div>
                        </div>
                        <div class="ViewRow" style="background-color: transparent;">
                        <div class="box" >
                            <div class="designimage">
                                <img src="../front-view-image/<?php echo $row["front_view"]; ?>">
                                <center>Front View</center>
                            </div>
                            <div class="designimage">
                                <img src="../rear-view-image/<?php echo $row["rear_view"]; ?>">
                                <center>Rear View</center>
                            </div>
                            <div class="designimage">
                                <img src="../left-view-image/<?php echo $row["left_view"]; ?>">
                                <center>Left View</center>
                            </div>
                            <div class="designimage">
                                <img src="../right-view-image/<?php echo $row["right_view"]; ?>">
                                <center>Right View</center>
                            </div>
                        </div>   
                    </div> 
                        <div class="form-row">
                            <div class="form-row-theme">
                                Costume design : 
                            </div>
                            <div class="form-row-data">
                            <input type="text" name="customer_email" value="<?php echo  $name; ?> " readonly />
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
                                <input type="text" name="merchandiser_name" id="merchandiser_name" value="<?php echo  $first_name; ?> " readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quantity :
                            </div>
                            <div class="form-row-data">
                            <input type="text" name="quantity"  />
                            </div>
                        </div>
                        <div id="form-body">
                            
                        </div>

                        
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation issued on :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="issue_date" id="issue_date" required />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Request Quotation" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> 
                    </form>
                </div>   
            </div> 
        </div> 
        <?php

        }else {
            echo "0 results";
        } 
    }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    mysqli_close($conn); 

?>

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
