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
            $this->quotationID = explode("-",$args["quotation_id"])[0];
        }

        public function manageStorage(){
            if($this->quotationID == ''){
                $this->quotationID = NULL;
            }
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $storage_log_sql = "INSERT INTO storage_log (merchandiser_id, material_id, time_stamp, store_action, quantity, quotation_id) VALUES (?,?,?,?,?,?);";
            if ($stmt = mysqli_prepare($conn, $storage_log_sql)) {
                mysqli_stmt_bind_param($stmt, "iissdi", $this->merchandiserID, $this->materialID, $this->timeStamp, $this->storeAction, $this->quantity, $this->quotationID);
                mysqli_stmt_execute($stmt);
                $insertedRow = $conn -> affected_rows;
                if($insertedRow == -1){
                    ?><script>
                    alert("Sorry ! That operation can't proceed.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php  
                }else{
                    ?><script>
                    alert("Operation was successful.");
                    </script><?php  

                    if($this->storeAction == "store"){
                        $quantityInStock = $this->quantityInStock + $this->quantity;
                    }else{
                        $quantityInStock = $this->quantityInStock - $this->quantity;
                    }
                    $sql = "UPDATE raw_material SET quantity_in_stock = ".$quantityInStock." WHERE material_id = ".$this->materialID.";";
                    if ($conn->query($sql) === TRUE) {
                        //echo "Storage was updated.";
                        ?><script>
                        alert("Material storage was updated");
                        window.location.href='<?php echo $_POST["home_url"]; ?>';
                        </script><?php  
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

        /*public function viewStorage(){

        } */
    }
?>

