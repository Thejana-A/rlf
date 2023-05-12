<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/fashion_designer/view_list_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="http://localhost/rlf">Welcome </a> >
                    <a href="../customer/customer_login.php">Login </a> >
                    <a href="home.php">Fashion Designer </a> > Home
                </div>
                <div class="form-row" style="width:115%;">
                    <div class="form-row-theme">
                        <div id="list-box-home" style="color:#330099; flex: 65%;box-sizing: border-box;background-color:#ffcc99;border-radius:6px;padding:30px;margin:10px;clear:inherit; font-family:sans-serif;width:195%;margin-top:20px;margin-right:80px;height:245px;">
                            <h2>Hi <?php echo $_SESSION["username"]; ?>,</h2>
                            <h4>Welcome you to RLF Apparel Factory !</h4><br>
                            <h4>Below designs are assigned within this week.</h4>
                        </div>
                    </div>
                    <div class="form-row-data">
                        <div style="flex: 35%;box-sizing: border-box;">
                            <?php include 'calendar.php';?>
                        </div>
                    </div>
                </div>
                <div id="list-box-ultra-small" style="width:95%;">
                    <center>
                        <h2>Costume designs</h2>
                    </center>
                    <div class="item-list">
                    <div class="item-heading-row">
                            <b style="width:10%;">Design name</b>
                            <b style="width:12%;">Merchandiser</b>
                            <b style="width:5%;">Appearance</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $output = "";
                            
                            $lastSunday = Date('y:m:d', strtotime('Last Sunday'));
                            $nextSunday = Date('y:m:d', strtotime('+7 days Last Sunday'));
                            $lastSunday = "20".$lastSunday."<br>";
                            $nextSunday = "20".$nextSunday;

                            $sql_costume = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name, design_approval_date FROM costume_design WHERE ((design_approval_date >= '$lastSunday') AND (design_approval_date <= '$nextSunday')) AND fashion_designer_id = ".$_SESSION['employee_id'].";";
                            $sql_costume_result = $conn->query($sql_costume);
                            $costume_name = array();
                            if ($sql_costume_result->num_rows > 0) {
                                while ($row = $sql_costume_result->fetch_assoc()) {
                                    array_push($costume_name , $row["costume_name"]);
                                }
                            }
                            for($i = 0;$i<count($costume_name);$i++){
                                $sql_costume = "(SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name, design_approval_date
                                FROM costume_design c 
                                JOIN employee e1 ON c.merchandiser_id = e1.employee_id
                                JOIN employee e2 ON c.fashion_designer_id = e2.employee_id
                                WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                                UNION
                                (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  e2.first_name fd_first_name, e2.last_name fd_last_name, design_approval_date
                                FROM costume_design c 
                                JOIN employee e2 ON c.fashion_designer_id = e2.employee_id AND `merchandiser_id` IS NULL
                                WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                                UNION
                                (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, e1.first_name merchandiser_first_name, e1.last_name merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name, design_approval_date
                                FROM costume_design c 
                                JOIN employee e1 ON c.merchandiser_id = e1.employee_id AND `fashion_designer_id` IS NULL
                                WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1)
                                UNION
                                (SELECT c.design_id, c.name, c.fashion_designer_id, c.merchandiser_id, c.front_view, c.rear_view, '' AS merchandiser_first_name, '' AS merchandiser_last_name,  '' AS fd_first_name, '' AS fd_last_name, design_approval_date 
                                FROM costume_design c 
                                JOIN employee e1 ON `merchandiser_id` IS NULL
                                JOIN employee e2 ON `fashion_designer_id` IS NULL
                                WHERE `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__' OR name LIKE '$costume_name[$i]-___' LIMIT 1);";
                                $result_costume_row = $conn->query($sql_costume);
                                if ($result_costume_row->num_rows > 0) {
                                    while ($costume_row = $result_costume_row->fetch_assoc()) { 
                                        //$output.= $costume_name[$i]." - ".$costume_row["merchandiser_id"]." - ".$costume_row["merchandiser_first_name"]." ".$costume_row["merchandiser_last_name"]." - ".$costume_row["fashion_designer_id"]." - ".$costume_row["fd_first_name"]." ".$costume_row["fd_last_name"]." - ".$costume_row["front_view"];
                                        //$output.= "<br />";  
                                            $output.= "<div class='item-data-row'>";
                                            $output.= "<form method='post' action='../RouteHandler.php'>";
                                            $output.= "<input type='text' hidden='true' name='framework_controller' value='costume_design/fd_view_general_design' />";
                                            $output.= "<input type='text' hidden='true' name='name' value='".$costume_name[$i]."' />";
                                            $output.= "<span style='width:10%;'>".$costume_name[$i]."</span><span style='width:11%;'>".$costume_row["merchandiser_first_name"]." ".$costume_row["merchandiser_last_name"]."</span><span style='padding-left:25px;padding-bottom:8px;display:flex;'><img src='../front-view-image/".$costume_row["front_view"]."' style='width:60px;' /><img src='../rear-view-image/".$costume_row["rear_view"]."' style='width:60px;' /></span>";
                                            /*$output.= "<table align='right' style='margin-right:24px;' class='two-button-table'><tr>";
                                            $output.= "<td><input type='submit' class='grey' value='View' /></td>";
                                            $output.= "</tr></table>"; */
                                            $output.= "<input type='submit' style='float:right;margin-right:20px;margin-bottom:10px;' class='grey' value='View' />";
                                            $output.= "<hr class='manager-long-hr' />";
                                            $output.= "</form>";
                                            $output.= "</div>";
                                        //}
                                        
                                    }
                                }else{
                                    $output.= "No costume designs";
                                }
                            }
                            
                            echo $output;
                            mysqli_close($conn);
                        ?>
                        
                    </div>
                </div><br />
            

                <?php /*echo $_SESSION["username"];echo $_SESSION["employee_id"];echo $_SESSION["user_type"];*/ ?>
                   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
