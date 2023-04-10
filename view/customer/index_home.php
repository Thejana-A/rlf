<?php 
 error_reporting(E_ERROR | E_PARSE);
include "db_conn.php";

session_start();
$_SESSION["email"] = "";
$_SESSION["customer_id"] = "";
$_SESSION["username"] = "";
$_SESSION["employee_id"] = "";
$_SESSION["supplier_id"] = "";
$_SESSION["user_type"] = "";

//$sql = "SELECT * FROM costume_design where publish_status = 'publish';";
$sql = "SELECT DISTINCT SUBSTRING_INDEX(name,'-',LENGTH(name)-LENGTH(REPLACE(name,'-',''))) as costume_name FROM costume_design WHERE publish_status = 'publish';";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="home_css.css" />
</head>
<body>
    <div class="home-webbanner">
        <img src="../image/homepage.png" />
        
    </div>
    
    <div class="section-header text-center">
        <h2>Our Products..!</h2>
    </div>
    <div class="gaallery">
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
                    
            
                <div class="content">
                    <input type="hidden" name="design_id"  value="<?php echo $row['design_id']; ?>">
                    <a href="design_view.php?design_id=<?php echo $row['design_id'] ?>&design_name=<?php echo $costume_name[$i]?>">
                        <img src="../front-view-image/<?php echo $row["front_view"]; ?>" width="200px" height="auto"/>
                            <div class="desc">
                                <h4><?php echo $costume_name[$i]; ?></h4>
                            </div>
                    </a>           
                </div>
               
    <?php            }
            } 
            //echo $costume_name[$i];
        }
    ?>
    </div>

    <div class="clearfix"></div>
    <?php
    include "footer.php";
    ?>
</body>
</html>