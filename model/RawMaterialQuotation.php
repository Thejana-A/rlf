<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    require_once(__DIR__.'/MaterialPrice.php');
    class RawMaterialQuotation{
        
        private $quotationID;
        private $expectedDeliveryDate;
        private $supplierApproval;
        private $approvalDescrition;
        private $requestDate;
        private $issueDate;
        private $validTill;
         
        function __construct($args) {
            $this->expectedDeliveryDate = $args["expected_delivery_date"];
            $this->supplierApproval = $args["supplier_approval"];
            $this->approvalDescrition = $args["approval_description"];
            $this->requestDate = date("Y-m-d");
            $this->issueDate = $args["issue_date"];
            $this->validTill = $args["valid_till"];
            $this->supplierID = $args["supplier_id"];
            $this->merchandiserID = $args["merchandiser_id"]; 
        }

        public function add(){
            //print_r($_POST);
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "INSERT INTO raw_material_quotation (expected_delivery_date, supplier_approval, approval_description, request_date, issue_date, valid_till, supplier_id, merchandiser_id) VALUES (?,?,?,?,?,?,?,?);";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssii", $this->expectedDeliveryDate, $this->supplierApproval, $this->approvalDescription, $this->requestDate, $this->issueDate, $this->validTill, $this->supplierID, $this->merchandiserID);
                mysqli_stmt_execute($stmt);
                $this->quotationID = $conn->insert_id;
                $publicQuotationID = $this->quotationID;
                if($this->quotationID == 0){ 
                    ?><script>alert("Sorry ! An error occured.");
                    window.location.href='<?php echo $_POST["page_url"] ?>';
                    </script><?php
                }else{
                    /*echo "<table>";
                    echo "<tr><td>Quotation ID </td><td>: $this->quotationID</td></tr>";
                    echo "<tr><td>Expected delivery date </td><td>: $this->expectedDeliveryDate</td></tr>";
                    echo "<tr><td>Request date </td><td>: $this->requestDate</td></tr>"; 
                    echo "<tr><td>Supplier ID </td><td>: $this->supplierID</td></tr>"; 
                    echo "</table>"; */
                    $materialPriceModel = new MaterialPrice($_POST, $publicQuotationID); 
                    $materialPriceModel->setQuantity();
                    ?><script>
                    alert("Material quotation request was added successfully");
                    window.location.href='<?php echo $_POST["home_url"] ?>';
                    </script><?php
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); 
        }

        public function view(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->quotationID = $_POST["quotation_id"];
            $sql = "SELECT quotation_id, expected_delivery_date, supplier_approval, approval_description, request_date, issue_date, valid_till, supplier.supplier_id, merchandiser_id , supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, supplier.contact_no AS supplier_contact_no, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name FROM raw_material_quotation JOIN supplier ON raw_material_quotation.supplier_id = supplier.supplier_id JOIN employee ON raw_material_quotation.merchandiser_id = employee.employee_id WHERE quotation_id = $this->quotationID
            UNION
            SELECT quotation_id, expected_delivery_date, supplier_approval, approval_description, request_date, issue_date, valid_till, supplier.supplier_id, merchandiser_id , supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, supplier.contact_no AS supplier_contact_no, '' AS merchandiser_first_name, '' AS merchandiser_last_name FROM raw_material_quotation, supplier WHERE raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id IS NULL AND quotation_id = $this->quotationID;";
            $path = mysqli_query($conn, $sql);
            $result = $path->fetch_array(MYSQLI_ASSOC);
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                    return $row;
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
            mysqli_close($conn);
        }

        public function update(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->quotationID = $_POST["quotation_id"];
            $publicQuotationID = $this->quotationID;
            $validity = 0;
            for($i = 0;$i<count($_POST["material_id"]);$i++){
                if($_POST["request_quantity"][$i] > 0){
                    $validity = 1;
                }
            }
            if($validity == 1){
                $sql = "UPDATE raw_material_quotation SET issue_date = ?, valid_till = ?, supplier_approval = ?, approval_description = ?, expected_delivery_date = ? WHERE quotation_id = '$this->quotationID'";        
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    if($this->issueDate == ''){
                        $this->issueDate = NULL;
                    }
                    if($this->validTill == ''){
                        $this->validTill = NULL;
                    }
                    mysqli_stmt_bind_param($stmt, "sssss", $this->issueDate, $this->validTill, $this->supplierApproval, $this->approvalDescription, $this->expectedDeliveryDate);
                    mysqli_stmt_execute($stmt);
                    $affectedRows = mysqli_stmt_affected_rows($stmt);
                    if($affectedRows == -1){
                        echo "Sorry ! An error occured.";
                    }else{
                        $sql_reset_material = "DELETE FROM material_price WHERE quotation_id = '$this->quotationID'";
                        $conn->query($sql_reset_material);
                        $materialPriceModel = new MaterialPrice($_POST, $publicQuotationID); 
                        $materialPriceModel->setQuantity();
                        ?><script>
                        alert("Quotation was updated successfully");
                        window.location.href='<?php echo $_POST["home_url"]; ?>';
                        </script><?php  
                    }
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close(); 
            }else{
                ?><script>
                alert("There should be at least one item");
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php 
            }
            
        }


        public function addMaterialQuotation() {
            $this->add();
        }

        public function updateMaterialQuotation() {
            $this->update();
        }

        public function viewMaterialQuotation() {
            $row = $this->view();
            return $row;
        }
        
        
        public function logout() {
            header("location: http://localhost/rlf/view/merchandiser/login.php");
        }
    }
?>