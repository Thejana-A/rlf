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
                    ?><script>
                    alert("Sorry ! An error occured.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php  
                }else{
                    /*echo "Costume order was added successfully";
                    echo "<table>";
                    echo "<tr><td>Order ID </td><td>: $this->orderID</td></tr>";
                    echo "<tr><td>Quotation ID </td><td>: $this->quotationID</td></tr>";
                    echo "</table>";*/
                    /*customer notification */
                    if($this->orderStatus == "confirmed"){
                        date_default_timezone_set("Asia/Calcutta");
                        $notification_message = "Costume order was confirmed - ID ".$this->orderID;
                        $sql_notification = "INSERT INTO notification (message, notification_date, time, customer_id, category) VALUES ('".$notification_message."', '".Date("Y-m-d")."', '".Date("h:i:sa")."', '".$_POST["customer_id"]."', 'costume order');";
                        $conn->query($sql_notification); 
                    }
                    /*merchandiser notification */
                    if($this->orderStatus != "confirmed"){
                        date_default_timezone_set("Asia/Calcutta");
                        $notification_message = "Costume order was added - ID ".$this->orderID;
                        $sql_notification = "INSERT INTO notification (message, notification_date, time, merchandiser_id, category) VALUES ('".$notification_message."', '".Date("Y-m-d")."', '".Date("h:i:sa")."', '".$_POST["merchandiser_id"]."', 'costume order');";
                        $conn->query($sql_notification); 
                    }
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
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->orderID = $_POST["order_id"];
            $orderID = $this->orderID;
            $sql = "UPDATE costume_order SET order_status = ?, quality_status = ?, quality_status_description = ?, dispatch_date = ?, balance_payment = ? WHERE order_id = '$orderID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                if($this->dispatchDate == ''){
                    $this->dispatchDate = NULL;
                }else{
                    $this->orderStatus = "delivered";
                }
                mysqli_stmt_bind_param($stmt, "ssssi", $this->orderStatus, $this->qualityStatus, $this->qualityStatusDescription, $this->dispatchDate, $this->balancePayment);
                 
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    ?><script>
                    alert("Sorry ! Order couldn't be updated.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php
                }else{
                    /*customer notification */
                    if(($this->orderStatus == "accepted")||($this->orderStatus == "rejected")){
                        date_default_timezone_set("Asia/Calcutta");
                        $notification_message = "Costume order was updated - ID ".$this->orderID;
                        $sql_notification = "INSERT INTO notification (message, notification_date, time, customer_id, category) VALUES ('".$notification_message."', '".Date("Y-m-d")."', '".Date("h:i:sa")."', '".$_POST["customer_id"]."', 'costume order');";
                        $conn->query($sql_notification); 
                    }
                    /*customer notification */
                    if($this->qualityStatus == "good"){
                        date_default_timezone_set("Asia/Calcutta");
                        $notification_message = "Costume order is ready - ID ".$this->orderID;
                        $sql_notification = "INSERT INTO notification (message, notification_date, time, customer_id, category) VALUES ('".$notification_message."', '".Date("Y-m-d")."', '".Date("h:i:sa")."', '".$_POST["customer_id"]."', 'costume order');";
                        $conn->query($sql_notification); 
                    }
                    /*merchandiser notification */
                    if($this->orderStatus == "confirmed"){
                        date_default_timezone_set("Asia/Calcutta");
                        $notification_message = "Costume order was confirmed - ID ".$this->orderID;
                        $sql_notification = "INSERT INTO notification (message, notification_date, time, merchandiser_id, category) VALUES ('".$notification_message."', '".Date("Y-m-d")."', '".Date("h:i:sa")."', '".$_POST["merchandiser_id"]."', 'costume order');";
                        $conn->query($sql_notification); 
                    }
                    ?><script>
                    alert("Order was updated successfully");
                    window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php  
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); 
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
                    echo "No results found";
                }
            }else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
            mysqli_close($conn); 
        }
    }
?>