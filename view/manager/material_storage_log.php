<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Material storage log</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Manager </a> >
                    <a href="#">View raw materials </a> > Material storage log
                </div>
                <div id="material-price-box">
                    <center>
                        <h2>Material storage log</h2>
                    </center>

                    <form method="post" action="" class="search-panel">    
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Date of action : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="" id="" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="" id="" class="date-field" />
                            </div>
                        </div>
                    </form> 
                    
                    <div class="item-list" style="width:80%;">
                        <hr style="width:120%;color:#1B3280;" />
                        <?php
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT raw_material.material_id, name, employee.employee_id, first_name, last_name, time_stamp, store_action, quantity, measuring_unit FROM raw_material, employee, storage_log WHERE storage_log.material_id = raw_material.material_id AND storage_log.merchandiser_id = employee.employee_id ORDER BY time_stamp DESC;";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='material-price-block'>";
                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Material ID : <input type='text' value='".$row["material_id"]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Material name : <input type='text' value='".$row["name"]."' readonly />";
                                        echo "</div>  ";
                                        echo "</div>";
                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Merch. ID&nbsp&nbsp : <input type='text' value='".$row["employee_id"]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Merch. name&nbsp&nbsp : <input type='text' value='".$row["first_name"]." ".$row["last_name"]."' readonly />";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".explode(" ",$row["time_stamp"])[0]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Store/ retrieve : <input type='text' value='".$row["store_action"]."' readonly />";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='material-price-row'>";
                                        echo "<div class='material-price-left'>";
                                        echo "Quantity&nbsp&nbsp&nbsp : <input type='text' value='".$row["quantity"]."' readonly />";
                                        echo "</div>";
                                        echo "<div class='material-price-right'>";
                                        echo "Unit&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type='text' value='".$row["measuring_unit"]."' readonly />";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<hr />";
                                        echo "</div>";
                                    }
                                }else {
                                    echo "0 results";
                                }
                            }else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                            mysqli_close($conn);
                        ?>

                        <!--<div class="material-price-block">
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Material ID : <input type="text" name="" id="" />
                                </div>
                                <div class="material-price-right">
                                    Material name : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Merch. ID&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Merch. name&nbsp&nbsp : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Store/ retrieve : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Quantity&nbsp&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Unit&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <hr />
                        </div>

                        <div class="material-price-block">
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Material ID : <input type="text" name="" id="" />
                                </div>
                                <div class="material-price-right">
                                    Material name : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Merch. ID&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Merch. name&nbsp&nbsp : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Store/ retrieve : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <div class="material-price-row">
                                <div class="material-price-left">
                                    Quantity&nbsp&nbsp&nbsp : <input type="text" name="" id=""/>
                                </div>
                                <div class="material-price-right">
                                    Unit&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <input type="text" name="" id="" />
                                </div>  
                            </div>
                            <hr />
                        </div> -->


                    </div>
                </div> 


            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
