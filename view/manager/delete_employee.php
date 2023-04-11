<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Delete employee</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <?php 
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            if(isset($_GET['data'])){ 
                //parse_str($_SERVER['REQUEST_URI'],$row);
                $row = $_SESSION["row"];
                //print_r($row);
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
                    Manager >
                    <a href="employees.php">Employees </a> > Delete
                </div> 

                <div id="form-box-small">
                    <form method="post" action="../RouteHandler.php">
                        <input type="text" hidden="true" name="framework_controller" value="employee/delete">
                        <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                        <center>
                            <h2>Delete employee</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Employee ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="employee_id" value="<?php echo $row["employee_id"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                First name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="first_name" id="first_name" value="<?php echo $row["first_name"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Last name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="last_name" id="last_name" value="<?php echo $row["last_name"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                NIC : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="NIC" id="NIC" value="<?php echo $row["NIC"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Email : 
                            </div>
                            <div class="form-row-data">
                                <input type="email" name="email" id="email" value="<?php echo $row["email"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Contact number : 
                            </div>
                            <div class="form-row-data">
                                <input type="tel" name="contact_no" id="contact_no" pattern="[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{3}" placeholder="94 123 456 789" value="<?php echo $row["contact_no"]; ?>" readonly />
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                User type :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="user_type" value="<?php echo $row["user_type"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Address line 1 : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="address_line1" value="<?php echo $row["address_line1"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Address line 2 : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="address_line2" value="<?php echo $row["address_line2"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Address line 3 : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="address_line3" value="<?php echo $row["address_line3"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Date of birth : 
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="DOB" id="DOB" value="<?php echo $row["DOB"]; ?>" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Joined date : 
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="joined_date" id="joined_date" value="<?php echo $row["joined_date"]; ?>" required readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Active status :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="active_status" class="input-radio" value="enable" <?php echo ($row["active_status"]=="enable")?'checked':'disabled' ?> /> Enable
                                        </td>
                                        <td>
                                            <input type="radio" name="active_status" class="input-radio" value="disable" <?php echo ($row["active_status"]=="disable")?'checked':'disabled' ?> /> Disable
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-center-button">
                                <input type="submit" value="Delete" />
                            </div>
                        </div> 
                    </form>
                </div>  
                

            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
