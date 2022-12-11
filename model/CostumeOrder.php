<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class CostumeOrder{
        
        private $orderID;
        private $advancePayment;
        private $balancePayment;
        private $orderStatus;
        private $orderPlacedOn;
        private $expectedDeliveryDate;
        private $qualityStatus;
        private $qualityStatusDescription;
        private $dispatchDate;
        
        function __construct($args) {
            $this->advancePayment = $args["advance_payment"];
            $this->balancePayment = $args["balance_payment"];
            $this->orderStatus = $args["order_status"];
            $this->orderPlacedOn = $args["order_placed_on"];
            $this->expectedDeliveryDate = $args["expected_delivery_date"];
            $this->qualityStatus = $args["quality_status"];
            $this->qualityStatusDescription = $args["quality_status_description"];
            $this->dispatchDate = $args["dispatch_date"];
        }

        public function addCostumeOrder(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "INSERT INTO raw_material_order (dispatch_date, payment, payment_date, manager_approval, approval_description, approval_date, quotation_id) VALUES (?,?,?,?,?,?,?);";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sissssi", $this->dispatchDate, $this->payment, $this->paymentDate, $this->managerApproval, $this->approvalDescription, $this->approvalDate, $this->quotationID);
                mysqli_stmt_execute($stmt);
                $this->orderID = $conn->insert_id;
                if($this->orderID == 0){
                    echo "Sorry ! An error occured.";
                }else{
                    echo "Material purchase request was added successfully";
                    echo "<table>";
                    echo "<tr><td>Order ID </td><td>: $this->orderID</td></tr>";
                    echo "<tr><td>Quotation ID </td><td>: $this->quotationID</td></tr>";
                    echo "</table>";
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close();
        }

        public function updateCostumeOrder(){

        }

        public function viewCostumeOrder(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->orderID = $_POST["order_id"];
            $sql = "SELECT raw_material_quotation.quotation_id, order_id, supplier.supplier_id, supplier.first_name AS supplier_first_name, supplier.last_name AS supplier_last_name, supplier.contact_no, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, issue_date, valid_till, expected_delivery_date, raw_material_order.manager_approval, raw_material_order.approval_description, dispatch_date, payment, payment_date from raw_material_quotation, raw_material_order, supplier, employee WHERE raw_material_order.quotation_id = raw_material_quotation.quotation_id AND raw_material_quotation.supplier_id = supplier.supplier_id AND raw_material_quotation.merchandiser_id = employee.employee_id AND raw_material_order.order_id = '$this->orderID';";
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