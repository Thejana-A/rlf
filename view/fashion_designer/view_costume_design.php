<?php require_once 'redirect_login.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Costume designs</title>
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/view_list_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Fashion Designer </a> > View costume designs
                </div>
                
                <div id="list-box-small">
                    <center>
                        <h2>Costume designs</h2>
                    </center>
                    <center>
                        <form method="post" action="" class="search-panel">  
                            <input type="text" name="" id="" placeholder="Search" class="text-field" />
                            <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />   
                        </form>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design ID</b>
                            <b>Design name</b>
                            <b>Appearance</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $fashionDesignerID = $_SESSION["employee_id"];
                            //$fashionDesignerID = 19;
                            $sql = "SELECT design_id,name, size, merchandiser_id, first_name, last_name, front_view, rear_view FROM costume_design INNER JOIN employee ON employee_id = merchandiser_id WHERE fashion_designer_id = '$fashionDesignerID'";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_design/fashion_designer_view' />";
                                        echo "<input type='text' hidden='true' name='design_id' value='".$row["design_id"]."' />";
                                        //echo "<span class='manager-ID-column'>".$row["design_id"]."</span><span style='padding-left:10px;'>".$row["name"]."</span><span style='padding-left:25px;'>".$row["size"]."</span><span>".$row["first_name"]." ".$row["last_name"]."</span>";
                                        echo "<span class='manager-ID-column'>".$row["design_id"]."</span><span style='padding-left:10px;'>".$row["name"]."</span><span style='padding-left:25px;'><img src='../front-view-image/".$row["front_view"]."' style='width:60px;' /><img src='../rear-view-image/".$row["rear_view"]."' style='width:60px;' /></span>";
                                        echo "<table align='right' style='margin-right:8px;'><tr>";
                                        echo "<td><input type='submit' class='grey' name='edit' value='Edit' /></td>";
                                        echo "<td><input type='submit' class='grey' name='delete' value='Delete' /></td>";
                                        echo "</tr></table>"; 
                                        echo "<hr class='manager-long-hr' />";
                                        echo "</form>";
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
                        
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
