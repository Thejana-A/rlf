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
            $sql_delete_material = "DELETE FROM order_material_received WHERE order_id = '$this->orderID'";
            $conn->query($sql_delete_material);
            for($materialCount = 0;$materialCount<count($this->materialID);$materialCount++){
                $sql = "INSERT INTO rlf.order_material_received (order_id, material_id, quantity_received) VALUES (?,?,?);";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iid", $this->orderID, $this->materialID[$materialCount], $this->quantityReceived[$materialCount]);
                    mysqli_stmt_execute($stmt);
                    $insertedRow = $conn -> affected_rows;
                    if($insertedRow == -1){
                        ?><script>
                        alert("Sorry! An error occured");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php  
                    }else{
                        $sql_update_dispatch_date = "UPDATE raw_material_order SET `dispatch_date` = '$this->dispatchDate' WHERE `order_id` = '$this->orderID'";
                        if ($conn->query($sql_update_dispatch_date) === TRUE) {
                            ?><script>
                            alert("Goods received notice was saved successfully");
                            window.location.href='<?php echo $_POST["home_url"]; ?>';
                            </script><?php  
                        } else {
                            echo "Error : " . $conn->error;
                        }
                    }	
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                
            }	
            $stmt->close(); 	
            $conn->close(); 
        }
        
    }
?>