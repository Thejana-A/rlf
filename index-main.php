<?php 
 error_reporting(E_ERROR | E_PARSE);
 include "db_conn.php";
 $sql = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE publish_status = 'publish';";
 $result = $conn->query($sql);
?>

<!DOCTYPE html>
<head>
    <title>Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="view/customer/RLF_customer_css.css" />
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
    <style>

        div.desc {
        padding: 15px;
        text-align: center;
        }
        div.gallery img {
        width: 80%;
        height: auto;
        }

        .responsive {
        padding: 0 6px;
        float: left;
        width: 24.99999%;
        }

        @media only screen and (max-width: 700px) {
        .responsive {
            width: 49.99999%;
            margin: 6px 0;
        }
        }

        @media only screen and (max-width: 500px) {
        .responsive {
            width: 100%;
        }
        }
        .clearfix:after {
        content: "";
        display: table;
        clear: both;
        }
    </style>
</head>
<body>
    <div class="home-webbanner">
        <img src="../image/homepage.png" />    
    </div>
    
    <div class="section-header text-center">
        <h2>Our Products..!</h2>
        <?php
        $costume_name = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($costume_name , $row["costume_name"]);
         
            }
        }
        for($i = 0;$i<count($costume_name);$i++){
            $sql_costume = "SELECT * FROM costume_design where `name` LIKE '$costume_name[$i]-_' OR name LIKE '$costume_name[$i]-__'  LIMIT 1;";
            $result_costume = $conn->query($sql_costume);
            if ($result_costume->num_rows > 0) {
                while ($row = $result_costume->fetch_assoc()) { ?>
                    
                    <div class="responsive">
                <div class="gallery">
                    <input type="hidden" name="design_id"  value="<?php echo $row['design_id']; ?>">
                    <a href="design_view.html">
                                <img  src="../front-view-image/<?php echo $row["front_view"]; ?>" width="20px" height="auto"/>
                                <div class="desc">
                                    <h3><?php echo $costume_name[$i]; ?></h3>
                                </div>
                    </a>  
                    <center>
                    <button class="Quotationbtn" onclick="location.href='request_quotation.php?design_id=<?php echo $row['design_id'] ?>&design_name=<?php echo $costume_name[$i] ?>'">
                        Request Quotation
                    </button>           
                    </center>  
                </div>
            </div>   
    <?php            }
            } 
            //echo $costume_name[$i];
        }
    ?>
    </div>

    <div class="clearfix"></div>
    <!--<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome</title>
        <link rel="stylesheet" type="text/css" href="view/customer/RLF_customer_css.css" />
        <link rel="stylesheet" type="text/css" href="view/customer/customer_css.css" />
    </head>

    <body>

        <section  class="content">
            <div class="home-webbanner">
                <img src="view/image/homepage.png" />
        
            </div>
            <div class="items" >
                <div class="section-header text-center">
                    <h2>Our Products..!</h2>
                </div>

                <div class="row">
                    <div class="column">
                        <a href="design_view.html" class="grid_view_item_link">
                            <img class="grid_view_item_image" src="view/image/lorem_tshirt.PNG"/>
                            <div class="grid_view_item_title">
                                <h3>Lorem Tshirt</h3>
                            </div>
                        </a>                 
                    </div>
                    <div class="column">
                        <a href="design_view.html" class="grid_view_item_link">
                            <img class="grid_view_item_image" src="view/image/lorem_tshirt.PNG"/>
                            <div class="grid_view_item_title">
                                <h3>Lorem Tshirt</h3>
                            </div>
                        </a> 
                  
                    </div>
                    <div class="column">
                        <a href="design_view.html" class="grid_view_item_link">
                            <img class="grid_view_item_image" src="view/image/lorem_tshirt.PNG"/>
                            <div class="grid_view_item_title">
                                <h3>Lorem Tshirt</h3>
                            </div>
                        </a>
                    
                    </div>
                </div> 
            </div>
            <div class="items">
                <div class="row">
                    <div class="column">
                        <a href="design_view.html" class="grid_view_item_link">
                            <img class="grid_view_item_image" src="view/image/lorem_tshirt.PNG"/>
                            <div class="grid_view_item_title">
                                <h3>Lorem Tshirt</h3>
                            </div>
                        </a>  
                    
                    </div>
                    <div class="column">
                        <a href="design_view.html" class="grid_view_item_link">
                            <img class="grid_view_item_image" src="view/image/lorem_tshirt.PNG"/>
                            <div class="grid_view_item_title">
                                <h3>Lorem Tshirt</h3>
                            </div>
                        </a> 
                        
                    </div>
                    <div class="column">
                        <a href="design_view.html" class="grid_view_item_link">
                            <img class="grid_view_item_image" src="view/image/lorem_tshirt.PNG"/>
                            <div class="grid_view_item_title">
                                <h3>Lorem Tshirt</h3>
                            </div>
                        </a>
                        
                    </div>
                </div> 
            </div>
        </section>-->
        <?php
    include "footer.php";
    ?>

    </body>
</html>