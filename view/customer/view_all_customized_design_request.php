<?php 
    session_start();    
    include "db_conn.php";
    $customerID =$_SESSION["customer_id"];
    $sql = "SELECT * FROM costume_design WHERE costume_design.customer_id='$customerID'";
    $result = mysqli_query($conn, $sql);
    
?>


<!DOCTYPE html>
<head>
    <title>view all customized design request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> > View All Customized Design Request
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h2>View All Customized Design Request</h2>
        </div>
    </div>
    
    <div class="ViewRow">
        <div class="box" style="margin-bottom: 0;">
            <div>
            <form action="">
                <input type="text" placeholder="Search.." name="search" class="search-bar" style="background-color:rgb(252, 250, 247);">
                <input type="submit" value="Search" class="search-bar">
            </form>
            </div>
        </div>
    </div>


    <div class="ViewRow" style="padding: 10px;">
        <div class="box" style="padding: 10px;">
            
                <div class="item-list" style="width:80%;">
                    <div class="item-heading-row">
                        <b>Proposed Name</b>
                        <b>Size</b>
                        <b>Status</b>                   
                        <hr />
                    </div>
            <?php

                if (mysqli_num_rows($result)  > 0) {

                        while ($row = mysqli_fetch_array($result)) {

                     ?>
                    
                    <div class="item-data-row">
                        <?php $class = ($row["customized_design_approval"]=="reject")?"red":(($row["customized_design_approval"]== NULL)?"grey":"green"); ?>
                        <span><?php echo $row['name']; ?></span>
                        <span><?php echo $row['size']; ?></span>
                        <span><?php if($row["customized_design_approval"]==NULL){
                                echo "pending";
                            }
                                echo $row['customized_design_approval'] ?>
                        </span>
                        <a href="view_customized_design_request.php?design_id=<?php echo $row['design_id']?>" class="<?php echo $class ?>" >View</a>
                        
                        <hr />
                    </div>

                    <?php }

                }

            ?> 
                    <!--<div class="item-data-row">
                        <span>1</span>
                        <span>2022-11-11</span>
                        <span>Kamal Perera</span>
                        <a href="view_approve_quotation.html" class="green">View</a>
                        <hr />
                    </div>-->


                </div>
            
        </div>
        
    </div>
 
    <?php
    include "footer.php";
    ?>
</body>
</html>