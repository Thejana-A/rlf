<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class RawMaterialOrder{
        
        private $orderID;
        private $dispatchDate;
        private $payment;
        private $paymentDate;
        private $managerApproval;
        private $approvalDescription;
        private $approvalDate;
        
        function __construct($args) {
            $this->dispatchDate = $args["dispatch_date"];
            $this->payment = $args["payment"];
            $this->paymentDate = $args["payment_date"];
            $this->managerApproval = $args["manager_approval"];
            $this->approvalDescription = $args["approval_description"];
            $this->approvalDate = $args["approval_date"];
            $this->quotationID = $args["quotation_id"];
        }

        public function addMaterialOrder(){
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
                    /*echo "Material purchase request was added successfully";
                    echo "<table>";
                    echo "<tr><td>Order ID </td><td>: $this->orderID</td></tr>";
                    echo "<tr><td>Quotation ID </td><td>: $this->quotationID</td></tr>";
                    echo "</table>"; */
                    ?><script>
                    alert("New raw material purchase request was saved successfully");
                    window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php  
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close();
        }

        public function updateMaterialOrder(){

        }

        public function viewMaterialOrder(){
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