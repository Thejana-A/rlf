<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class StorageLog{
        
        private $timeStamp;
        private $storeAction;
        private $quantity;
        
        function __construct($args) {
            $this->merchandiserID = $args["merchandiser_id"];
            $this->materialID = $args["material_id"];
            $this->timeStamp = $args["time_stamp"];
            $this->storeAction = $args["store_action"];
            $this->quantityInStock = $args["quantity_in_stock"];
            $this->quantity = $args["quantity"];
        }

        public function manageStorage(){
            //print_r($_POST);
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $storage_log_sql = "INSERT INTO storage_log (merchandiser_id, material_id, time_stamp, store_action, quantity) VALUES (?,?,?,?,?);";
            if ($stmt = mysqli_prepare($conn, $storage_log_sql)) {
                mysqli_stmt_bind_param($stmt, "iissd", $this->merchandiserID, $this->materialID, $this->timeStamp, $this->storeAction, $this->quantity);
                mysqli_stmt_execute($stmt);
                $insertedRow = $conn -> affected_rows;
                if($insertedRow == -1){
                    echo "Sorry ! That operation can't proceed.";
                }else{
                    echo "Operation was successful!";
                    echo "<table>";
                    echo "<tr><td>Employee ID </td><td>: $this->merchandiserID</td></tr>";
                    echo "<tr><td>Material ID </td><td>: $this->materialID</td></tr>";
                    echo "<tr><td>Date & time </td><td>: $this->timeStamp</td></tr>"; 
                    echo "<tr><td>Action </td><td>: $this->storeAction</td></tr>"; 
                    echo "<tr><td>Quantity </td><td>: $this->quantity</td></tr>"; 
                    echo "</table>";
                    if($this->storeAction == "store"){
                        $quantityInStock = $this->quantityInStock + $this->quantity;
                    }else{
                        $quantityInStock = $this->quantityInStock - $this->quantity;
                    }
                    $sql = "UPDATE raw_material SET quantity_in_stock = ".$quantityInStock." WHERE material_id = ".$this->materialID.";";
                    if ($conn->query($sql) === TRUE) {
                        echo "Storage was updated.";
                    } else {
                        echo "Error updating storage: " . $conn->error;
                    }
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close();  
        } 

        public function viewStorage(){

        }
    }
?>

