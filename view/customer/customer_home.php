<?php 

include "db_conn.php";

$sql = "SELECT * FROM design";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
    <div class="home-webbanner">
        <img src="../image/homepage.png" />
        <button class="RequestCustomizedQuotationBtn" onclick="location.href='request_customized_quotation.html';">Request Customized Quotation</button>
    </div>
    <div class="items">
        <div class="section-header text-center">
            <h2>Our Products..!</h2>
        </div>

            <div class="row">

            <?php

                if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {

                ?>
                <div class="column">
                <input type="hidden" name="view_design_id"  value="<?php echo $row['view_design_id']; ?>">
                    <a href="design_view.html" class="grid_view_item_link">
                        <img class="grid_view_item_image" src="../image/lorem_tshirt.PNG"/>
                        <div class="grid_view_item_title">
                            <h3><?php echo $row['design_name']; ?></h3>
                        </div>
                    </a>  
                    <center><!--<button class="Quotationbtn" onclick="location.href='request_quotation.php?view_design_id=<?php/* echo $row['view_design_id']; */?>';">
                        Request Quotation
                    </button>-->
                    <a href="location.href='request_quotation.php?view_design_id=<?php echo $row['view_design_id']; ?>" class="Quotationbtn">Request Quotation</a>
                     </center>  

                </div>
                <?php }

                }

                ?>

                <!--
                <div class="column">
                    <a href="design_view.html" class="grid_view_item_link">
                        <img class="grid_view_item_image" src="../image/lorem_tshirt.PNG"/>
                        <div class="grid_view_item_title">
                            <h3>Lorem Tshirt</h3>
                        </div>
                    </a> 
                    <center><button class="Quotationbtn" onclick="location.href='request_quotation.php';">
                        Request Quotation
                    </button> </center>                   
                </div>
                <div class="column">
                    <a href="design_view.html" class="grid_view_item_link">
                        <img class="grid_view_item_image" src="../image/lorem_tshirt.PNG"/>
                        <div class="grid_view_item_title">
                            <h3>Lorem Tshirt</h3>
                        </div>
                    </a>
                    <center><button class="Quotationbtn" onclick="location.href='request_quotation.php';">
                        Request Quotation
                    </button> </center>                    
                </div>-->
            </div> 
    </div>
    <div class="items">
        <div class="row">
            <div class="column">
                <a href="design_view.html" class="grid_view_item_link">
                    <img class="grid_view_item_image" src="../image/lorem_tshirt.PNG"/>
                    <div class="grid_view_item_title">
                        <h3>Lorem Tshirt</h3>
                    </div>
                </a>  
                <center><button class="Quotationbtn" onclick="location.href='request_quotation.php';">
                    Request Quotation
                </button> </center>                
            </div>
            <div class="column">
                <a href="design_view.html" class="grid_view_item_link">
                    <img class="grid_view_item_image" src="../image/lorem_tshirt.PNG"/>
                    <div class="grid_view_item_title">
                        <h3>Lorem Tshirt</h3>
                    </div>
                </a> 
                <center><button class="Quotationbtn" onclick="location.href='request_quotation.php';">
                    Request Quotation
                </button> </center>                   
            </div>
            <div class="column">
                <a href="design_view.html" class="grid_view_item_link">
                    <img class="grid_view_item_image" src="../image/lorem_tshirt.PNG"/>
                    <div class="grid_view_item_title">
                        <h3>Lorem Tshirt</h3>
                    </div>
                </a>
                <center><button class="Quotationbtn" onclick="location.href='request_quotation.php';">
                    Request Quotation
                </button> </center>                    
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