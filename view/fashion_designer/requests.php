<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
	<head>
	      <Meta name="viewpoint" content="width=device-width, initial-scale=1">
              <title> View Request </title>
              <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
              <link rel="stylesheet" type="text/css" href="../css/fashion_designer/view_list_style.css" />
              <?php
                    require_once('../../model/DBConnection.php');
                    $connObj = new DBConnection();
                    $conn = $connObj->getConnection();
                    if(isset($_GET['data'])){ 
                        //parse_str($_SERVER['REQUEST_URI'],$row);
                        $row = $_SESSION["row"];
                        //print_r($row);
                    }else{
                        $sql_view_raw_material = 
                        "SELECT material_id,name,size,measuring_unit,quantity_in_stock,description,image, raw_material.supplier_id as requester_id,'supplier' as requester_role, first_name,last_name,manager_approval,approval_description FROM raw_material,supplier where raw_material.supplier_id = supplier.supplier_id and material_id = '".$_GET["material_id"]."'
                        UNION
                        SELECT material_id,name,size,measuring_unit,quantity_in_stock,description,image, raw_material.fashion_designer_id as requester_id,'fashion designer' as requester_role, first_name,last_name,manager_approval,approval_description FROM raw_material,employee where raw_material.fashion_designer_id = employee.employee_id and material_id = '".$_GET["material_id"]."'
                        UNION
                        SELECT material_id,name,size,measuring_unit,quantity_in_stock,description,image,'' as requester_id,'' as requester_role, '' as first_name,'' as last_name,manager_approval,approval_description FROM raw_material where fashion_designer_id is null and supplier_id is null AND material_id = '".$_GET["material_id"]."';";
                        $result_view_raw_material = mysqli_query($conn, $sql_view_raw_material);
                        $row = mysqli_fetch_array($result_view_raw_material);
                    }
                ?>
	</head>

<body>
	<?php include 'header.php';?>

	<div id="page-body">
            <?php include 'leftnav.php';?>

	        <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Fashion Designer </a> 
                    <a href="#">View Requests </a> > View 
                </div>

                    
                <div id="form-box">
                    <form method="post"  name="rawMaterialForm" action="../RouteHandler.php" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="framework_controller" value="raw_material/fashion_designer_operation" />
                    <input type="text" hidden="true" name="fashion_designer_id" value="<?php echo $_SESSION["employee_id"] ?>" />
                    <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/fashion_designer/home.php" />
                        <center>
                            <h2>Requests</h2>
                        </center>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Material ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="material_id"  id="material_id" value = "<?php echo $row["material_id"];?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="name" id="name" value = "<?php echo $row["name"];?>" <?php if(($row["manager_approval"] == "approve")||($row["manager_approval"] == "reject")){echo "readonly";} ?> />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="size" id="size" <?php if(($row["manager_approval"] == "approve")||($row["manager_approval"] == "reject")){echo "readonly";} ?> >
                                    <option value="XS" <?php echo ($row["size"]=="XS")?'selected':'' ?>>XS</option>
                                    <option value="S" <?php echo ($row["size"]=="S")?'selected':'' ?>>S</option>
                                    <option value="M" <?php echo ($row["size"]=="M")?'selected':'' ?>>M</option>
                                    <option value="L" <?php echo ($row["size"]=="L")?'selected':'' ?>>L</option>
                                    <option value="XL" <?php echo ($row["size"]=="XL")?'selected':'' ?>>XL</option>
                                    <option value="XXL" <?php echo ($row["size"]=="XXL")?'selected':'' ?>>XXL</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring Unit : 
                            </div>
                            <div class="form-row-data">
                                <select name="measuring_unit" id="measuring_unit" <?php if(($row["manager_approval"] == "approve")||($row["manager_approval"] == "reject")){echo "readonly";} ?> >
                                    <option value="units" <?php echo ($row["measuring_unit"]=="units")?'selected':'' ?>>Units</option>
                                    <option value="metre" <?php echo ($row["measuring_unit"]=="m")?'selected':'' ?>>metre</option>
                                    <option value="kilogram" <?php echo ($row["measuring_unit"]=="kg")?'selected':'' ?>>kilogram</option>
                                    <option value="litre" <?php echo ($row["measuring_unit"]=="l")?'selected':'' ?>>litre</option>
                                    <option value="yards" <?php echo ($row["measuring_unit"]=="yards")?'selected':'' ?>>yards</option>
                                    <option value="m^2" <?php echo ($row["measuring_unit"]=="m^2")?'selected':'' ?>>m^2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="description" id="description" rows="4" cols="40" <?php if(($row["manager_approval"] == "approve")||($row["manager_approval"] == "reject")){echo "readonly";} ?> ><?php echo $row["description"];?></textarea>
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Status (By manager) 
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" <?php echo ($row["manager_approval"]=="approve")?'checked':'disabled' ?> /> Accepted
                                        </td>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" <?php echo ($row["manager_approval"]=="reject")?'checked':'disabled' ?> /> Rejected
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Acceptance description :
                            </div>
                            <div class="form-row-data">
                                <textarea name="approval_description" id="approval_description" rows="4" cols="40" readonly ><?php echo $row["approval_description"];?></textarea>
                            </div>
                        </div>

                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <?php 
                                    if(($row["manager_approval"] == "approve")||($row["manager_approval"] == "reject")){
                                        echo "<input type='submit' name='edit' value='Save' disabled />";
                                    }else{
                                        echo "<input type='submit' value='Save' name='edit' />";
                                    }
                                ?>
                            </div>
                            <div class="form-row-reset">
                                <?php 
                                    if(($row["manager_approval"] == "approve")||($row["manager_approval"] == "reject")){
                                        echo "<input type='submit' name='delete' value='Delete'  disabled />";
                                    }else{
                                        echo "<input type='submit' value='Delete' name='delete' />";
                                    }
                                ?>
                            </div>
                        
                    </form>
                </div>   
                         
            </div> 
        </div> 


        <?php include 'footer.php';?>

</body> 
</html>
