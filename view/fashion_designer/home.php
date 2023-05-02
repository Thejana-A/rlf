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
                            <h4>You have following upcoming tasks today.</h4>
                        </div>
                    </div>
                    <div class="form-row-data">
                        <div style="flex: 35%;box-sizing: border-box;">
                            <?php //include 'calendar.php';?>
                        </div>
                    </div>
                </div>
                <div id="list-box-small" >
                    <center>
                        <h2>Customized designs</h2>
                    </center>
                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design ID</b>
                            <b>Design Name</b>
                            <b>Customer</b>
                            <b style="width:150px;">Contact no</b>
                            <hr />
                        </div>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT design_id, name, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, customer.contact_no FROM costume_design, customer, employee WHERE costume_design.customer_id = customer.customer_id AND costume_design.fashion_designer_id = employee.employee_id
                            UNION
                            SELECT design_id, name, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, customer.contact_no FROM costume_design, customer WHERE costume_design.customer_id = customer.customer_id AND costume_design.fashion_designer_id IS NULL;";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view_customized_design' />";
                                        echo "<input type='text' hidden='true' name='design_id' value='".$row["design_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["design_id"]."</span><span style='padding-left:20px;'>".$row["name"]."</span><span>".$row["customer_first_name"]." ".$row["customer_last_name"]."</span><span>".$row["contact_no"]."</span>";
                                        echo "<td><input type='submit' class='grey' value='View' /></td>";
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
                </div><br />
            

                <?php /*echo $_SESSION["username"];echo $_SESSION["employee_id"];echo $_SESSION["user_type"];*/ ?>
                   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
