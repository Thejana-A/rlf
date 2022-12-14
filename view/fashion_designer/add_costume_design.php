<!DOCTYPE html>
<html>
	<head>
	      <Meta name="viewpoint" content="width=device-width, initial-scale=1">
              <title> Add costume design </title>
              <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
	</head>

<body>
	<?php include 'header.php';?>

	<div id="page-body">
            <?php include 'leftnav.php';?>

	<div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Fashion Designer </a> > Add costume design
                </div>

	<div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>Create Costume Design</h2>
                        </center>

		                <div class="form-row">
                            <div class="form-row-theme">
                                Design name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id=""  />
                            </div>
                        </div>

		                <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="">
                                    <option>XS</option>
                                    <option>S</option>
                                    <option>M</option>
				                    <option>L</option>
				                    <option>XL</option>
                                    <option>2XL</option>
                                </select>
                            </div>
                        </div>

		                <div class="form-row">
                            <div class="form-row-theme">
                                Front view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Rear view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Left view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Right view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>

		                <div class="form-row">
                            <div class="form-row-theme">
                               Description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="" rows="4" cols="40"></textarea>
                            </div>
                        </div>

		                <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - Material name </b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit</b></span>
                            </div>
                        </div>
                        

                        <div id="form_body">
                                <div class="form-row">
                                    <div class="form-row-theme">
                                        <?php
                                            if($result = mysqli_query($conn, $sql_all_material)){
                                                if(mysqli_num_rows($result) > 0){
                                                    echo "<select name='material_id[]' id='material_id_0' onChange='setSizeAndUnit(0 , this)' required>";
                                                    echo "<option disabled>ID - Material name</option>";
                                                    while($all_material_row = mysqli_fetch_array($result)){
                                                        echo "<option value='".$all_material_row["material_id"]."'>".$all_material_row["material_id"]." - ".$all_material_row["name"]." - (".$all_material_row["measuring_unit"].")</option>";
                                                    }
                                                    echo "</select>";
                                                }else {
                                                    echo "0 results";
                                                }
                                            }else{
                                                echo "ERROR: Could not able to execute $sql_all_material. " . mysqli_error($conn);
                                            }  
                                        ?>
                                        <!--<select name="" id="">
                                            <option disabled>ID - Material name</option>
                                            <option>0004 - Black Thread-S</option>
                                            <option>0014 - Blue Thread-S</option>
                                            <option>0022 - Red anchor button-L</option>
                                        </select>-->
                                    </div>
                                    <div class="form-row-data">
                                        <input type="text" name="material_size[]" id="material_size_0" class="column-textfield" value="" readonly />
                                        <input type="text" name="measuring_unit[]" id="measuring_unit_0" class="column-textfield" value="" readonly />
                                        <input type="number" step="0.001" min="0.001" name="quantity[]" id="quantity_0" class="column-textfield" required />
                                        <button onclick="addCode()"> + </button>
                                    </div>
                                </div>
                            </div>


		                <div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id="">
                                    <option>Pink linen clothe</option>
                                    <option>black silk clothe</option>
                                    <option>red flat button</option>
                                </select>
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield"  />
                            </div>
                            <div class="form-row-add">
                                    <input type="submit" value="+" />
                            </div>
                        </div>

		                <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> 
                    </form>
		        </div>
	        </div>
	    </div>


        <?php include 'footer.php';?>

    </body> 
</html>

