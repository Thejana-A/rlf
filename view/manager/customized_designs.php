<?php require_once 'redirect_login.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customized costume designs</title>
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
                    <a href="#">Manager </a> >Customized costume designs
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Customized costume designs</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design ID</b>
                            <b>Design name</b>
                            <b>Customer name</b>
                            <b>Fashion designer</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <?php 
                            require_once('../../model/DBConnection.php');
                            $connObj = new DBConnection();
                            $conn = $connObj->getConnection();
                            $sql = "SELECT design_id, name, customized_design_approval, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, employee.first_name AS fashion_designer_first_name, employee.last_name AS fashion_designer_last_name FROM costume_design, customer, employee WHERE costume_design.customer_id = customer.customer_id AND costume_design.fashion_designer_id = employee.employee_id
                            UNION
                            SELECT design_id, name, customized_design_approval, customer.first_name AS customer_first_name, customer.last_name AS customer_last_name, '' AS fashion_designer_first_name, '' AS fashion_designer_last_name FROM costume_design, customer WHERE costume_design.customer_id = customer.customer_id AND costume_design.fashion_designer_id IS NULL;";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        $class = ($row["customized_design_approval"]=="approve")?"green":(($row["customized_design_approval"]=="reject")?"red":"grey");
                                        echo "<div class='item-data-row'>";
                                        echo "<form method='post' action='../RouteHandler.php'>";
                                        echo "<input type='text' hidden='true' name='framework_controller' value='costume_design/manager_view_customized_design' />";
                                        echo "<input type='text' hidden='true' name='design_id' value='".$row["design_id"]."' />";
                                        echo "<span class='manager-ID-column'>".$row["design_id"]."</span><span style='padding-left:20px;'>".$row["name"]."</span><span>".$row["customer_first_name"]." ".$row["customer_last_name"]."</span><span>".$row["fashion_designer_first_name"]." ".$row["fashion_designer_last_name"]."</span>";
                                        echo "<input type='submit' class='".$class."' value='View' />";
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
                        <!--<div class="item-data-row">
                            <span>0003</span>
                            <span>Blue-long-sleeve</span>
                            <span>Jane Eyre</span>
                            <span>John A</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0005</span>
                            <span>White Chinese collar</span>
                            <span>Sherlock H</span>
                            <span>&nbsp</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>  -->
                        
                        
                    </div>
                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
