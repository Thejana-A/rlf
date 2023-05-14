<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class MaterialPrice{
        
        private $requestQuantity;
        private $unitPrice;
        
        function __construct($args, $publicQuotationID) {
            $this->quotationID = $publicQuotationID;
            $this->materialID = $args["material_id"];
            $this->requestQuantity = $args["request_quantity"];
            $this->unitPrice = $args["unit_price"];
        }

        public function setQuantity(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            for($materialCount = 0;$materialCount<count($this->materialID);$materialCount++){
                if($this->requestQuantity[$materialCount] > 0){
                    $sql = "INSERT INTO rlf.material_price (quotation_id, material_id, request_quantity, unit_price) VALUES (?,?,?,?);";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "iidd", $this->quotationID, $this->materialID[$materialCount], $this->requestQuantity[$materialCount], $this->unitPrice[$materialCount]);
                        mysqli_stmt_execute($stmt);
                        $insertedRow = $conn -> affected_rows;
                        if($insertedRow == -1){
                            ?><script>
                            var materialID = "<?php echo $this->materialID[$materialCount]; ?>";
                            var message = "Sorry ! That material already exists. - ".concat(materialID);
                            alert(message);
                            </script><?php  
                            //echo "<br>Material ID : ".$this->materialID[$materialCount]."<br>Sorry ! That material already exists.<br>";
                        }
                    } else {
                        echo "Error: <br>" . mysqli_error($conn);
                    } 
                }
            }	
            $stmt->close(); 	
            $conn->close(); 
            
        }


        
    }
?>