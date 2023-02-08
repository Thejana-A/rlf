<?php 
 error_reporting(E_ERROR | E_PARSE);
include "db_conn.php";

session_start();

//$sql = "SELECT * FROM costume_design where publish_status = 'publish';";
$sql = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE publish_status = 'publish';";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<head>
    <title>Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
 
                </div>
            </div>   
    <?php            }
            } 
        }
    ?>
    </div>

    <div class="clearfix"></div>
    <?php
    include "footer.php";
    ?>
</body>
</html>