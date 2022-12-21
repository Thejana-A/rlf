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
            $this->advancePaymentDate = $args["advance_payment_date"];
            $this->balancePayment = $args["balance_payment"];
            $this->orderStatus = $args["order_status"];
            $this->orderPlacedOn = $args["order_placed_on"];
            $this->expectedDeliveryDate = $args["expected_delivery_date"];
            $this->qualityStatus = $args["quality_status"];
            $this->qualityStatusDescription = $args["quality_status_description"];
            $this->dispatchDate = $args["dispatch_date"];
            $this->quotationID = $args["quotation_id"];
        }

        public function addCostumeOrder(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $sql = "INSERT INTO costume_order (advance_payment, advance_payment_date, order_status, order_placed_on, expected_delivery_date, quotation_id) VALUES (?,?,?,?,?,?);";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "issssi", $this->advancePayment, $this->advancePaymentDate, $this->orderStatus, $this->orderPlacedOn, $this->expectedDeliveryDate, $this->quotationID);
                mysqli_stmt_execute($stmt);
                $this->orderID = $conn->insert_id;
                if($this->orderID == 0){
                    echo "Sorry ! An error occured.";
                }else{
                    
                    /*echo "Costume order was added successfully";
                    echo "<table>";
                    echo "<tr><td>Order ID </td><td>: $this->orderID</td></tr>";
                    echo "<tr><td>Quotation ID </td><td>: $this->quotationID</td></tr>";
                    echo "</table>";*/
                    ?><script>
                    alert("Costume order was added successfully");
                    window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php  
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
            $sql = "SELECT order_id, costume_quotation.quotation_id, customer.customer_id, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, customer.contact_no, customer.email, employee.employee_id, employee.first_name AS merchandiser_first_name, employee.last_name AS merchandiser_last_name, issue_date, valid_till, advance_payment, advance_payment_date, order_status, quality_status, quality_status_description, balance_payment, order_placed_on, expected_delivery_date, dispatch_date FROM costume_quotation, costume_order, employee, customer WHERE costume_quotation.merchandiser_id = employee.employee_id AND costume_quotation.customer_id = customer.customer_id AND costume_order.quotation_id = costume_quotation.quotation_id AND order_id = '$this->orderID';";
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