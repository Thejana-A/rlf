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
                    echo "Sorry! Quotation couldn't be created.";
                }else{
                    echo "New costume quotation was created successfully";
                    echo "<table>";
                    echo "<tr><td>Quotation ID </td><td>: $this->quotationID </td></tr>";
                    echo "<tr><td>Customer ID </td><td>: $this->customerID</td></tr>"; 
                    echo "<tr><td>Request date </td><td>: $this->requestDate </td></tr>";
                    echo "</table>";
                    $designQuotationModel = new DesignQuotation($_POST, $publicQuotationID); 
                    $designQuotationModel->insertQuantityPrice();
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 				
            
            $stmt->close(); 
            $conn->close(); 
        }

        public function updateCostumeQuotation(){

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

    }
?>
         