<?php 

include "db_conn.php";

$sql = "SELECT * FROM quotation";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<head>
    <title>view all quotation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> > View All Quotation
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h2>View All Quotation</h2>
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
                        <b>Quotation ID</b>
                        <b>Date</b>
                        <b>Merchandiser Name</b>                   
                        <hr />
                    </div>
            <?php

                if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {

                     ?>

                    <div class="item-data-row">
                        <span><?php echo $row['quotation_id']; ?></span>
                        <span><?php echo $row['date']; ?></span>
                        <span><?php echo $row['merchandiser_name']; ?></span>
                        <a href="view_quotation.php?quotation_id=<?php echo $row['quotation_id']; ?>" class="grey">View</a>
                        <hr />
                    </div>

                    <?php }

                }

            ?> 
                    <!--<div class="item-data-row">
                        <span>Q002</span>
                        <span>2022-10-21</span>
                        <span>Selena Gomez</span>
                        <a href="view_quotation.html" class="grey">View</a>
                        <hr />
                    </div>
                    <div class="item-data-row">
                        <span>Q003</span>
                        <span>2022-10-12</span>
                        <span>John Perera</span>
                        <a href="view_quotation.html" class="red">View</a>
                        <hr />
                    </div>
                    <div class="item-data-row">
                        <span>Q004</span>
                        <span>2022-11-11</span>
                        <span>Harry petter</span>
                        <a href="view_approve_quotation.html" class="green">View</a>
                        <hr />
                    </div>
                    <div class="item-data-row">
                        <span>Q005</span>
                        <span>2022-11-01</span>
                        <span>Kamal Perera</span>
                        <a href="view_quotation.html" class="grey">View</a>
                        <hr />
                    </div>
                    <div class="item-data-row">
                        <span>Q006</span>
                        <span>2022-10-06</span>
                        <span>Nimal Dias</span>
                        <a href="view_approve_quotation.html" class="green">View</a>
                        <hr />
                    </div>-->

                </div>
            
        </div>
        
    </div>
 
    <footer class="footer">
        <div id="page-footer">
            <hr color="#cccccc" size="8px" width="100%" style="margin:0;" /> 
            <div id="footer-left-column">
                <b>Contact us</b><br /><br />
                <span><img src="../Icon/call.png" />&nbsp +94 774 719 095 </span><br />
                <span><img src="../icon/email.png" />&nbsp rlfapparel@gmail.com </span><br />
                <span><img src="../icon/loc.png" />&nbsp 341/c/194 , 6th Lane ,<br />&nbsp Mahayaya Watta , Piliyandala </span>
                
            </div>
            <div id="footer-middle-column">
                <b>Follow us</b><br /><br />
                <a href="#"><img src="../icon/insta.png" /></a>
                <a href="#"><img src="../icon/fb.png" /></a>
                <a href="#"><img src="../icon/twitter.png" /></a>
                <br /><br />
                <b>Pay with</b><br /><br />
                <img src="../icon/visa.png" id="visa-card-icon" />
            </div>
            <div id="footer-right-column">
                <b>Your message</b><br /><br />
                <form method="post" action="">
                    <input type="text" name="name" width="30%" placeholder="Name" /><br />
                    <input type="text" name="email" width="30%" placeholder="Email" /><br />
                    <textarea name="message" rows="4" cols="30" placeholder="Message"></textarea><br />
                    <input type="submit" value="Send" />
                </form>
            </div>
        </div>

    </footer>
</body>
</html>