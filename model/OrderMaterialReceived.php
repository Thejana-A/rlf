<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class OrderMaterialReceived{
        
        private $quantityReceived;
        
        function __construct($args) {
            $this->orderID = $args["order_id"];
            $this->materialID = $args["material_id"];
            $this->quantityReceived = $args["quantity_received"];
            $this->dispatchDate = $args["dispatch_date"];
        }

        public function insertQuantityReceived(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            for($materialCount = 0;$materialCount<count($this->materialID);$materialCount++){
                $sql = "INSERT INTO rlf.order_material_received (order_id, material_id, quantity_received) VALUES (?,?,?);";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iid", $this->orderID, $this->materialID[$materialCount], $this->quantityReceived[$materialCount]);
                    mysqli_stmt_execute($stmt);
                    $insertedRow = $conn -> affected_rows;
                    if($insertedRow == -1){
                        echo "<br>Material ID : ".$this->materialID[$materialCount]."<br>Sorry ! That material already exists.<br>";
                    }else{
                        $sql_update_dispatch_date = "UPDATE raw_material_order SET `dispatch_date` = '$this->dispatchDate' WHERE `order_id` = '$this->orderID'";
                        if ($conn->query($sql_update_dispatch_date) === TRUE) {
                            echo "Record updated successfully";
                        } else {
                            echo "Error : " . $conn->error;
                        }
                        echo "<br><table>";
                        echo "<tr><td>Raw material ID </td><td> : ".$this->materialID[$materialCount]."</td></tr>";
                        echo "<tr><td>Request quantity </td><td> : ".$this->quantityReceived[$materialCount]."</td></tr>";
                        echo "</table>";
                    }	
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                
            }	
            $stmt->close(); 	
            $conn->close(); 
        }

        public function viewQuantityReceived(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->quotationID = $_POST["quotation_id"];
            $sql = "SELECT * FROM material_price WHERE quotation_id='$this->quotationID';";
            
            $result = $conn->query($sql);
            $quantity_price_array = array();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    array_push($quantity_price_array, $row); 
                    print_r($row);
                    echo "<br>";
                }
                return $quantity_price_array;
            }else{
                echo "0 results";
            } 
            mysqli_close($conn);

        }

        public function updateQuantityPrice(){
             
        }

        
    }
?>