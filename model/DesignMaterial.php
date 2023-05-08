<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    class DesignMaterial{
        
        private $quantity;
        private $unitPrice;
        
        function __construct($args, $publicDesignID) {
            $this->designID = $publicDesignID;
            $this->materialID = $args["material_id"];
            $this->unitPrice = $args["unit_price"];
            $this->quantity = $args["quantity"];
        }

        public function add(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            for($materialCount = 0;$materialCount<count($this->materialID);$materialCount++){
                if($this->quantity[$materialCount] > 0){
                    $sql = "INSERT INTO rlf.design_material (design_id, material_id, unit_price, quantity) VALUES (?,?,?,?);";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "iiid", $this->designID, $this->materialID[$materialCount], $this->unitPrice[$materialCount], $this->quantity[$materialCount]);
                        mysqli_stmt_execute($stmt);
                        $insertedRow = $conn -> affected_rows;
                        if($insertedRow == -1){
                            ?><script>
                            var materialID = "<?php echo $this->materialID[$materialCount]; ?>";
                            var message = "Sorry ! That material already exists. - ".concat(materialID);
                            alert(message);
                            </script><?php  
            
                        }else{
                        }             
                    } else {
                        echo "Error: <br>" . mysqli_error($conn);
                    } 
                    $stmt->close(); 

                }
            }	
            $conn->close(); 
            if($_SESSION["costumeIDArrayCount"] < count($_SESSION["costumeIDArray"])){
                $_SESSION["costumeIDArrayCount"] = $_SESSION["costumeIDArrayCount"]+1;
                ?><script>
                window.location.href='<?php echo $_POST["page_url"]; ?>';
                </script><?php  
            }
            if($_SESSION["costumeIDArrayCount"] == count($_SESSION["costumeIDArray"])){
                $_SESSION["costumeIDArrayCount"] = 0;
                $_SESSION["costumeIDArray"] = array();
                $_SESSION["costumeNameArray"] = array();
                ?><script>
                alert("Raw materials were added successfully");
                window.location.href = '<?php echo $_POST["home_url"]; ?>';
                </script><?php  
            }
        }

        public function update(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            for($materialCount = 0;$materialCount<count($this->materialID);$materialCount++){
                if($this->quantity[$materialCount] > 0){
                    $sql = "INSERT INTO rlf.design_material (design_id, material_id, unit_price, quantity) VALUES (?,?,?,?);";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "iiid", $this->designID, $this->materialID[$materialCount], $this->unitPrice[$materialCount], $this->quantity[$materialCount]);
                        mysqli_stmt_execute($stmt);
                        $insertedRow = $conn -> affected_rows;
                        if($insertedRow == -1){
                            ?><script>
                            var materialID = "<?php echo $this->materialID[$materialCount]; ?>";
                            var message = "Sorry ! That material already exists. - ".concat(materialID);
                            alert(message);
                            </script><?php  
                        }else{
                            
                        }             
                    } else {
                        echo "Error: <br>" . mysqli_error($conn);
                    } 
                    $stmt->close(); 

                }
            }	
            $conn->close(); 
        }

        public function view(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->materialID = $_GET["material_id"];
            $sql = "SELECT * FROM design_material where design_id='$this->designID'";
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


        public function insertMaterialQuantity() {
            $this->add();
        }

        public function updateMaterialQuantity() {
            $this->update();
        }

        public function viewMaterialQuantity() {
            $row = $this->view();
            return $row;
        }
        
    
        
    }
?>