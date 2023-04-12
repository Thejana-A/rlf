<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    require_once(__DIR__.'/DesignQuotation.php');
    class CostumeQuotation{
        
        private $quotationID;
        private $requestDate;
        private $issueDate;
        private $validTill;
        private $managerApproval;
        private $approvalDescription;
        private $approvalDate;
         
        function __construct($args) {
            $this->requestDate = date("Y-m-d");
            $this->issueDate = $args["issue_date"];
            $this->validTill = $args["valid_till"];
            $this->managerApproval = $args["manager_approval"];
            $this->approvalDescription = $args["approval_description"];
            $this->approvalDate = $args["approval_date"];
            $this->customerID = explode("-" , $args["customer_id"])[0];
            $this->merchandiserID = $args["merchandiser_id"];
        }

        public function addCostumeQuotation(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "INSERT INTO costume_quotation (request_date, issue_date, valid_till, manager_approval, approval_description, approval_date, customer_id, merchandiser_id) VALUES (?,?,?,?,?,?,?,?);";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssii", $this->requestDate, $this->issueDate, $this->validTill, $this->managerApproval, $this->approvalDescription, $this->approvalDate, $this->customerID, $this->merchandiserID);
                mysqli_stmt_execute($stmt);
                $this->quotationID = $conn->insert_id;
                $publicQuotationID = $this->quotationID;
                if($this->quotationID == 0){
                    ?><script>
                    alert("Sorry! Quotation couldn't be created.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php     
                }else{
                    $designQuotationModel = new DesignQuotation($_POST, $publicQuotationID); 
                    $designQuotationModel->insertQuantityPrice(); 
                    date_default_timezone_set("Asia/Calcutta");
                    $notification_message = "Costume quotation was created - ID ".$this->quotationID;
                    $sql_notification = "INSERT INTO notification (message, notification_date, time, merchandiser_id, customer_id, category) VALUES ('".$notification_message."', '".Date("Y-m-d")."', '".Date("h:i:sa")."', '".$this->merchandiserID."', '".$this->customerID."', 'costume quotation');";
                    $conn->query($sql_notification); 
                    ?><script>
                    alert("New costume quotation was created successfully");
                    window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 				
            
            $stmt->close(); 
            $conn->close(); 
        }

        public function updateCostumeQuotation(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->quotationID = $_POST["quotation_id"];  
            $publicQuotationID = $this->quotationID;

            $sql = "UPDATE rlf.costume_quotation SET issue_date = ?, valid_till = ?, manager_approval = ?, approval_description = ?, approval_date = ? WHERE quotation_id = '$this->quotationID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssss", $this->issueDate, $this->validTill, $this->managerApproval, $this->approvalDescription, $this->approvalDate);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    ?><script>
                    alert("Sorry ! Couldn't update.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php   
                }else{
                    $sql_reset_quantity = "DELETE FROM rlf.design_quotation WHERE quotation_id = '$this->quotationID'";
                    $conn->query($sql_reset_quantity);
                    $designQuotationModel = new DesignQuotation($_POST, $publicQuotationID); 
                    $designQuotationModel->insertQuantityPrice(); 
                    date_default_timezone_set("Asia/Calcutta");
                    $notification_message = "Costume quotation was updated - ID ".$this->quotationID;
                    $sql_notification = "INSERT INTO rlf.notification (message, notification_date, time, merchandiser_id, customer_id, category) VALUES ('".$notification_message."', '".Date("Y-m-d")."', '".Date("h:i:sa")."', '".$this->merchandiserID."', '".$this->customerID."', 'costume quotation');";
                    $conn->query($sql_notification);
                    ?><script>
                    alert("Costume quotation was updated successfully");
                    window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php        
                }
                
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); 
        }
        
        public function viewCostumeQuotation(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->quotationID = $_POST["quotation_id"];
            $sql = "SELECT quotation_id, customer.customer_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, customer.contact_no, customer.email, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, issue_date, valid_till, manager_approval, approval_description FROM costume_quotation, employee, customer where costume_quotation.merchandiser_id = employee.employee_id AND costume_quotation.customer_id = customer.customer_id AND quotation_id='$this->quotationID'";
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

        public function deleteCostumeQuotation(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->quotationID = $_POST["quotation_id"];
            $sql = "DELETE FROM costume_quotation WHERE quotation_id = ?";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                $sql_quotation = "SELECT manager_approval FROM costume_quotation where quotation_id='$this->quotationID'";
                $path = mysqli_query($conn, $sql_quotation);
                $quotation_result = $path->fetch_array(MYSQLI_ASSOC);
                if($quotation_result = mysqli_query($conn, $sql_quotation)){
                    if(($quotation_result["manager_approval"] == "approve")||($quotation_result["manager_approval"] == "reject")){
                        ?><script>
                        alert("Sorry ! That quotation can't be deleted.");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php
                    }else{
                        $sql_delete_costumes = "DELETE FROM design_quotation WHERE quotation_id = '$this->quotationID'";
                        $conn->query($sql_delete_costumes);
                        mysqli_stmt_bind_param($stmt, "s", $this->quotationID);
                        mysqli_stmt_execute($stmt);
                        $affectedRows = mysqli_stmt_affected_rows($stmt);
                        if($affectedRows == -1){
                            ?><script>
                                alert("Sorry ! That quotation can't be deleted.");
                                window.location.href='<?php echo $_POST["page_url"]; ?>';
                            </script><?php
                        }else{
                            ?><script>
                                alert("Quotation was deleted successfully");
                                window.location.href='<?php echo $_POST["home_url"]; ?>';
                            </script><?php
                        }
                    }
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close();
        }

    }
?>
         