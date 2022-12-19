<!DOCTYPE html>
<html>
	<head>
	      <Meta name="viewpoint" content="width=device-width, initial-scale=1">
              <title> View Costume Design </title>
              <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
              <link rel="stylesheet" type="text/css" href="../css/fashion_designer/view_list_style.css" />
              <?php   
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                parse_str($_SERVER['REQUEST_URI'],$row);
                //print_r($row);
            }

            $designID = $row["design_id"];
            $conn = new mysqli("localhost", "root", "", "rlf");
        
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }
            $sql_design_material = "SELECT design_material.design_id, raw_material.material_id, name, measuring_unit, quantity, unit_price from design_material inner join raw_material on design_material.material_id = raw_material.material_id where design_material.design_id = '$designID';";
            $sql_all_material = "SELECT material_id, name, measuring_unit FROM `raw_material` where `manager_approval` = 'approve';";
        
            $materialCount = 0;
            $materialList = "";
            if($result = mysqli_query($conn, $sql_design_material)){
                if(mysqli_num_rows($result) > 0){
                    while($design_material_row = mysqli_fetch_array($result)){
                        $materialList .= "<div class='form-row'>";
                        $materialList .= "<div class='form-row-theme'>";
                        $materialList .= "<input type='text' name='material_id[]' value='".$design_material_row["material_id"]." - ".$design_material_row["name"]." (".$design_material_row["measuring_unit"].")' readonly />";
                        $materialList .= "</div>";
                        $materialList .= "<div class='form-row-data'>";
                        $materialList .= "<input type='text' name='quantity[]' id='quantity_".$materialCount."' class='column-textfield' value='".$design_material_row["quantity"]."' readonly /> ";
                        $materialList .= "<input type='text' name='unit_price[]'' id='unit_price_".$materialCount."' onChange='setPrice(".$materialCount.")' class='column-textfield' value='".$design_material_row["unit_price"]."' /> ";
                        $materialList .= "<input type='text' name='material_price[]'' id='material_price_".$materialCount."' class='column-textfield' value='' readonly />";
                        $materialList .= "</div>";
                        $materialList .= "</div>";
                        $materialCount++;
                    }
                    
                }else {
                    echo "0 results";
                }
            }else{
                echo "ERROR: Could not able to execute $sql_design_material. " . mysqli_error($conn);
            }  
        ?>
	</head>

<body>
	<?php include 'header.php';?>

	<div id="page-body">
            <?php include 'leftnav.php';?>

	        <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Fashion Designer </a> > View Costume Design
                </div>
                <div class="link-row">
                    <a href="./add_costume_design.php" class="right-button">Add new design</a>
                </div>

                    <div id="list-box-small">
                        <center>
                            <h2>View Costume Design</h2>
                        </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>

                    

                  <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design Name</b>
                            <b>Appearance</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>White T shirt S</span>
                                <span>
                                <div class="form-row-data">
                                <img src="../front-view-image/<?php echo $row["front_view"]; ?>" alt="front-view" class="design-view" />
                                <img src="../rear-view-image/<?php echo $row["rear_view"]; ?>" alt="rear-view" class="design-view" /><br />
                                <img src="../left-view-image/<?php echo $row["left_view"]; ?>" alt="left-view" class="design-view" />
                                <img src="../right-view-image/<?php echo $row["right_view"]; ?>" alt="right-view" class="design-view" /> 
                            </div>
                                </span>
                            
                            <a href="./costume_design.php" class="grey">View</a> 
                            <a href="./edit_costume_design.php" class="red">Edit</a>
                    
                           <!-- <table style="width:40%;margin:0;" border=1><tr>
                                <td><span>OREM shirt</span></td>
                                <td><img src="../icons/shirt.png" alt="All-views"  length="370px" width="320"/></td>
                                <td><a href="./costume_design.php" class="grey">View</a></td>
                            </tr></table>  -->
                            <hr class="manager-long-hr" />
                        </div>
                    </div>


                </div>
                         
            </div> 
        </div> 


        <?php include 'footer.php';?>

</body> 
</html>
