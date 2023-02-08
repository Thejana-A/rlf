<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__.'/DBConnection.php');
    require_once(__DIR__.'/DesignMaterial.php');
    require_once(__DIR__.'/IDBModel.php');
    class CostumeDesign implements IDBModel{
        
        private $designID;
        private $name;
        private $size;
        private $frontView;
        private $rearView;
        private $leftView;
        private $rightView;
        private $publishStatus;
        private $materialPriceApproval;
        private $materialPriceDescription;
        private $description;
        private $finalPrice;
        private $customizedDesignApproval;
        private $designApprovalDescription;
        private $designapprovalDate;
        
        function __construct($args) {
            $this->name = $args["name"];
            $this->size = $args["size"];
            $this->frontView = $_FILES["front_view"]["name"];
            $this->rearView = $_FILES["rear_view"]["name"];
            $this->leftView = $_FILES["left_view"]["name"];
            $this->rightView = $_FILES["right_view"]["name"];
            $this->publishStatus = $args["publish_status"];
            $this->materialPriceApproval = $args["material_price_approval"];
            $this->materialPriceDescription = $args["material_price_description"];
            $this->description = $args["description"];
            $this->finalPrice = $args["final_price"];
            $this->customizedDesignApproval = $args["customized_design_approval"]; 
            $this->designApprovalDescription = $args["design_approval_description"];
            $this->designApprovalDate = $args["design_approval_date"];
            $this->customerID = $args["customer_id"];
            $this->merchandiserID = $args["merchandiser_id"];
            $this->fashionDesignerID = $args["fashion_designer_id"];
        }

        public function add(){
            //print_r($_POST);
            while (true) {
                $newFrontImage = uniqid().".".explode("/", $_FILES["front_view"]["type"])[1];
                if (!file_exists("../view/front-view-image/".$newFrontImage)) break;
            }
            while (true) {
                $newRearImage = uniqid().".".explode("/", $_FILES["rear_view"]["type"])[1];
                if (!file_exists("../view/rear-view-image/".$newRearImage)) break;
            }
            while (true) {
                $newLeftImage = uniqid().".".explode("/", $_FILES["left_view"]["type"])[1];
                if (!file_exists("../view/left-view-image/".$newLeftImage)) break;
            }
            while (true) {
                $newRightImage = uniqid().".".explode("/", $_FILES["right_view"]["type"])[1];
                if (!file_exists("../view/right-view-image/".$newRightImage)) break;
            }
            
            $frontImageTarget = "../view/front-view-image/".$newFrontImage;
            $rearImageTarget = "../view/rear-view-image/".$newRearImage;
            $leftImageTarget = "../view/left-view-image/".$newLeftImage;
            $rightImageTarget = "../view/right-view-image/".$newRightImage;	

            $tempFrontImage = $_FILES["front_view"]["tmp_name"];
            $tempRearImage = $_FILES["rear_view"]["tmp_name"];
            $tempLeftImage = $_FILES["left_view"]["tmp_name"];
            $tempRightImage = $_FILES["right_view"]["tmp_name"];

            $frontImageResult = move_uploaded_file($tempFrontImage, $frontImageTarget);
            $rearImageResult = move_uploaded_file($tempRearImage, $rearImageTarget);
            $leftImageResult = move_uploaded_file($tempLeftImage, $leftImageTarget);
            $rightImageResult = move_uploaded_file($tempRightImage, $rightImageTarget);
            if($frontImageResult&&$rearImageResult&&$leftImageResult&&$rightImageResult) { 
                $connObj = new DBConnection();
                $conn = $connObj->getConnection();
                $sql = "INSERT INTO costume_design (name, size, front_view, rear_view, left_view, right_view, publish_status, material_price_approval, material_price_description, description, final_price, customized_design_approval, design_approval_description, design_approval_date, customer_id, merchandiser_id, fashion_designer_id) SELECT ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT design_id FROM costume_design WHERE name = '$this->name')";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssssssssssssssiii", $this->name, $this->size, $newFrontImage, $newRearImage, $newLeftImage, $newRightImage, $this->publishStatus, $this->materialPriceApproval, $this->materialPriceDescription, $this->description, $this->finalPrice, $this->customizedDesignApproval, $this->designApprovalDescription, $this->designApprovalDate, $this->customerID, $this->merchandiserID, $this->fashionDesignerID);
                    mysqli_stmt_execute($stmt);
                    $this->designID = $conn->insert_id;
                    $publicDesignID = $this->designID;
                    if($this->designID == 0){
                        echo "Sorry ! That design name already exists.";
                    }else{
                        $designMaterialModel = new DesignMaterial($_POST, $publicDesignID); 
                        $designMaterialModel->insertMaterialQuantity();
                        ?><script>
                        alert("New costume design was added successfully");
                        window.location.href='<?php echo $_POST["home_url"]; ?>';
                        </script><?php  
                    }
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $stmt->close(); 
                $conn->close();  				
            }else{			
                echo "Sorry !!! There was an error in uploading your file";			
            }   
        }

        public function addCustomizedDesign(){
            while (true) {
                $newFrontImage = uniqid().".".explode("/", $_FILES["front_view"]["type"])[1];
                if (!file_exists("../view/front-view-image/".$newFrontImage)) break;
            }
            while (true) {
                $newRearImage = uniqid().".".explode("/", $_FILES["rear_view"]["type"])[1];
                if (!file_exists("../view/rear-view-image/".$newRearImage)) break;
            }
            while (true) {
                $newLeftImage = uniqid().".".explode("/", $_FILES["left_view"]["type"])[1];
                if (!file_exists("../view/left-view-image/".$newLeftImage)) break;
            }
            while (true) {
                $newRightImage = uniqid().".".explode("/", $_FILES["right_view"]["type"])[1];
                if (!file_exists("../view/right-view-image/".$newRightImage)) break;
            }
            
            $frontImageTarget = "../view/front-view-image/".$newFrontImage;
            $rearImageTarget = "../view/rear-view-image/".$newRearImage;
            $leftImageTarget = "../view/left-view-image/".$newLeftImage;
            $rightImageTarget = "../view/right-view-image/".$newRightImage;	

            $tempFrontImage = $_FILES["front_view"]["tmp_name"];
            $tempRearImage = $_FILES["rear_view"]["tmp_name"];
            $tempLeftImage = $_FILES["left_view"]["tmp_name"];
            $tempRightImage = $_FILES["right_view"]["tmp_name"];

            $frontImageResult = move_uploaded_file($tempFrontImage, $frontImageTarget);
            $rearImageResult = move_uploaded_file($tempRearImage, $rearImageTarget);
            $leftImageResult = move_uploaded_file($tempLeftImage, $leftImageTarget);
            $rightImageResult = move_uploaded_file($tempRightImage, $rightImageTarget);
            if($frontImageResult&&$rearImageResult&&$leftImageResult&&$rightImageResult) { 
                $connObj = new DBConnection();
                $conn = $connObj->getConnection();
                foreach ($this->size as $size) {
                    $name = $this->name."-".$size;
                    $sql = "INSERT INTO costume_design (name, size, front_view, rear_view, left_view, right_view, publish_status, material_price_approval, material_price_description, description, final_price, customized_design_approval, design_approval_description, design_approval_date, customer_id, merchandiser_id, fashion_designer_id) SELECT ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? WHERE NOT EXISTS (SELECT design_id FROM costume_design WHERE name = '$this->name')";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssssssssssssssiii", $name, $size, $newFrontImage, $newRearImage, $newLeftImage, $newRightImage, $this->publishStatus, $this->materialPriceApproval, $this->materialPriceDescription, $this->description, $this->finalPrice, $this->customizedDesignApproval, $this->designApprovalDescription, $this->designApprovalDate, $this->customerID, $this->merchandiserID, $this->fashionDesignerID);
                        mysqli_stmt_execute($stmt);
                        $this->designID = $conn->insert_id;
                        
                    } else {
                        echo "Error: <br>" . mysqli_error($conn);
                    } 
                    
                }
                if($this->designID == 0){
                    ?><script>
                    alert("Sorry ! That design name already exists.");
                    window.location.href='<?php echo $_POST["page_url"]; ?>';
                    </script><?php  
                }else{
                    ?><script>
                    alert("New costume design was added successfully");
                    window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php  
                } 
                $stmt->close();
                $conn->close();  				
            }else{			
                echo "Sorry !!! There was an error in uploading your file";			
            }
                
        }
        
        
        public function view(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->designID = $_POST["design_id"];
            $sql = "SELECT * FROM costume_design where design_id='$this->designID'";
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

        public function update(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->designID = $_POST["design_id"];  
            
            if($_FILES["front_view"]["name"] != ""){
                while (true) {
                    $frontViewImage = uniqid().".".explode("/", $_FILES["front_view"]["type"])[1];
                    if (!file_exists("../view/front-view-image/".$frontViewImage)) break;
                }

                $frontViewImageTarget = "../view/front-view-image/".$frontViewImage;
                $tempFrontViewImage = $_FILES["front_view"]["tmp_name"];
                $frontViewImageResult = move_uploaded_file($tempFrontViewImage, $frontViewImageTarget);
                $sql_reset_front_image = "UPDATE costume_design SET front_view = ? WHERE design_id = '$this->designID'";        
                if ($stmt = mysqli_prepare($conn, $sql_reset_front_image)) {
                    mysqli_stmt_bind_param($stmt, "s", $frontViewImage);
                    mysqli_stmt_execute($stmt);
                } 
            } 

            if($_FILES["rear_view"]["name"] != ""){
                while (true) {
                    $rearViewImage = uniqid().".".explode("/", $_FILES["rear_view"]["type"])[1];
                    if (!file_exists("../view/rear-view-image/".$rearViewImage)) break;
                }

                $rearViewImageTarget = "../view/rear-view-image/".$rearViewImage;
                $tempRearViewImage = $_FILES["rear_view"]["tmp_name"];
                $rearViewImageResult = move_uploaded_file($tempRearViewImage, $rearViewImageTarget);
                $sql_reset_rear_image = "UPDATE costume_design SET rear_view = ? WHERE design_id = '$this->designID'";        
                if ($stmt = mysqli_prepare($conn, $sql_reset_rear_image)) {
                    mysqli_stmt_bind_param($stmt, "s", $rearViewImage);
                    mysqli_stmt_execute($stmt);
                } 
            } 

            if($_FILES["left_view"]["name"] != ""){
                while (true) {
                    $leftViewImage = uniqid().".".explode("/", $_FILES["left_view"]["type"])[1];
                    if (!file_exists("../view/left-view-image/".$leftViewImage)) break;
                }

                $leftViewImageTarget = "../view/left-view-image/".$leftViewImage;
                $tempLeftViewImage = $_FILES["left_view"]["tmp_name"];
                $leftViewImageResult = move_uploaded_file($tempLeftViewImage, $leftViewImageTarget);
                $sql_reset_left_image = "UPDATE costume_design SET left_view = ? WHERE design_id = '$this->designID'";        
                if ($stmt = mysqli_prepare($conn, $sql_reset_left_image)) {
                    mysqli_stmt_bind_param($stmt, "s", $leftViewImage);
                    mysqli_stmt_execute($stmt);
                } 
            } 

            if($_FILES["right_view"]["name"] != ""){
                while (true) {
                    $rightViewImage = uniqid().".".explode("/", $_FILES["right_view"]["type"])[1];
                    if (!file_exists("../view/right-view-image/".$rightViewImage)) break;
                }

                $rightViewImageTarget = "../view/right-view-image/".$rightViewImage;
                $tempRightViewImage = $_FILES["right_view"]["tmp_name"];
                $rightViewImageResult = move_uploaded_file($tempRightViewImage, $rightViewImageTarget);
                $sql_reset_right_image = "UPDATE costume_design SET right_view = ? WHERE design_id = '$this->designID'";        
                if ($stmt = mysqli_prepare($conn, $sql_reset_right_image)) {
                    mysqli_stmt_bind_param($stmt, "s", $rightViewImage);
                    mysqli_stmt_execute($stmt);
                } 
            } 
             

            $sql = "UPDATE costume_design SET name=?, size=?, description=?, customized_design_approval=?, design_approval_description=?, design_approval_date=?, merchandiser_id = ?, fashion_designer_id=? WHERE design_id='$this->designID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssii", $this->name, $this->size, $this->description, $this->customizedDesignApproval, $this->designApprovalDescription, $this->DesignApprovalDate, $this->merchandiserID, $this->fashionDesignerID);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    echo "Sorry ! Couldn't update.";
                }else{
                    echo "Design was updated successfully";
                    /*echo "<table>";
                    echo "<tr><td>Raw material ID </td><td>: $this->materialID</td></tr>";
                    echo "<tr><td>Name </td><td>: $this->name</td></tr>";
                    echo "<tr><td>Size </td><td>: $this->size</td></tr>"; 
                    echo "<tr><td>Image </td><td>: $this->image</td></tr>"; 
                    echo "<tr><td>Measuring unit </td><td>: $this->measuringUnit</td></tr>"; 
                    echo "<tr><td>Description </td><td>: $this->description</td></tr>"; 
                    echo "<tr><td>Manager's approval </td><td>: $this->managerApproval</td></tr>"; 
                    echo "<tr><td>Approval description </td><td>: $this->approvalDescription</td></tr>"; 
                    echo "</table>"; */
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); 
        }

        public function updatePrice(){
            //print_r($_POST);
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->designID = $_POST["design_id"];  
            $publicDesignID = $this->designID;

            $sql = "UPDATE costume_design SET final_price = ?, material_price_approval = ?, material_price_description = ?, publish_status = ? WHERE design_id='$this->designID'";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "isss", $this->finalPrice, $this->materialPriceApproval, $this->materialPriceDescription, $this->publishStatus);
                mysqli_stmt_execute($stmt);
                $affectedRows = mysqli_stmt_affected_rows($stmt);
                if($affectedRows == -1){
                    echo "Sorry ! Couldn't update.";
                }else{
                    $sql_reset_material = "DELETE FROM design_material WHERE design_id = '$this->designID'";
                    $conn->query($sql_reset_material);
                    $designMaterialModel = new DesignMaterial($_POST, $publicDesignID); 
                    $designMaterialModel->insertMaterialQuantity();
                    ?><script>
                    alert("Price description was updated successfully");
                    window.location.href='<?php echo $_POST["home_url"]; ?>';
                    </script><?php  
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close(); 
        }

        public function delete(){
            $connObj = new DBConnection();
            $conn = $connObj->getConnection();
            $this->designID = $_POST["design_id"];
            $sql = "DELETE FROM costume_design WHERE design_id = ?";        
            if ($stmt = mysqli_prepare($conn, $sql)) {
                $sql_quotation = "SELECT * FROM design_quotation where design_id='$this->designID'";
                $path = mysqli_query($conn, $sql_quotation);
                $quotation_result = $path->fetch_array(MYSQLI_ASSOC);
                if($quotation_result = mysqli_query($conn, $sql_quotation)){
                    if(mysqli_num_rows($quotation_result) > 0){
                        ?><script>
                        alert("Sorry ! That costume can't be deleted.");
                        window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php
                    }else{
                        $sql_delete_material = "DELETE FROM design_material WHERE design_id = '$this->designID'";
                        $conn->query($sql_delete_material);
                        mysqli_stmt_bind_param($stmt, "s", $this->designID);
                        mysqli_stmt_execute($stmt);
                        $affectedRows = mysqli_stmt_affected_rows($stmt);
                        if($affectedRows == -1){
                            ?><script>
                                alert("Sorry ! That costume can't be deleted.");
                                window.location.href='<?php echo $_POST["page_url"]; ?>';
                            </script><?php
                        }else{
                            ?><script>
                                alert("Costume was deleted successfully");
                                window.location.href='<?php echo $_POST["home_url"]; ?>';
                            </script><?php
                        }
                    }
                }
            } else {
                echo "Error: <br>" . mysqli_error($conn);
            } 
            $stmt->close(); 
            $conn->close();
        }

        public function addDesign() {
            $this->add();
        }

        public function updateDesign() {
            $this->update();
        }

        public function viewDesign() {
            $row = $this->view();
            return $row;
        }

        public function deleteDesign() {
            $this->delete();
        }
    
        
    }
?>