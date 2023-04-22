<?php
    error_reporting(E_ERROR | E_PARSE);
?>
        <?php
            require_once('../../model/database.php');
            $conn = mysqli_connect($db_params['servername'], $db_params['username'], $db_params['password'], $db_params['dbname']);
            if($conn->connect_error){
                die("Connection Faild: ". $conn->connect_error);
            }

            if(isset($_POST["sendMessage"])){
                $sql = "INSERT INTO feedback (name, email, message) VALUES (?,?,?);";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sss", $_POST["name"], $_POST["email"], $_POST["message"]);
                    mysqli_stmt_execute($stmt);
                    $feedbackID = $conn->insert_id;
                    if($feedbackID == 0){
                        ?><script>alert("Sorry! Message wasn't sent");
                            window.location.href='<?php echo $_POST["page_url"]; ?>';
                        </script><?php   
                    }else{
                        ?><script>alert("Message was sent successfully");
                            window.location.href='<?php echo $_POST["home_url"]; ?>';
                        </script><?php             
                    }
                    $stmt->close(); 
                } else {
                    echo "Error: <br>" . mysqli_error($conn);
                } 
                $conn->close();
            }
            
        ?>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/footer_style.css" />
        
        <div id="page-footer">
            <hr color="#cccccc" size="8px" width="100%" style="margin:0;" /> 
            <div id="footer-left-column">
                <b>Contact us</b><br /><br />
                <span><img src="../icons/telephone.jpg" />&nbsp +94 774 719 095 </span><br />
                <span><img src="../icons/email.jpg" />&nbsp rlfapparel@gmail.com </span><br />
                <span><img src="../icons/location_logo.png" />&nbsp 341/c/194 , 6th Lane ,<br />&nbsp Mahayaya Watta , Piliyandala </span>
                
            </div>
            <div id="footer-middle-column">
                <b>Follow us</b><br /><br />
                <a href="#"><img src="../icons/instagram.png" /></a>
                <a href="#"><img src="../icons/facebook.png" /></a>
                <a href="#"><img src="../icons/twitter.png" /></a>
                <br /><br />
                <b>Pay with</b><br /><br />
                <img src="../icons/visa_card.jpeg" id="visa-card-icon" />
            </div>
            <div id="footer-right-column">
                <b>Your message</b><br /><br />
                <form method="post" action="footer.php">
                    <input type="text" hidden="true" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                    <input type="text" hidden="true" name="home_url" value="http://localhost/rlf/view/manager/home.php" />
                    <input type="text" name="name" width="30%" placeholder="Name" /><br />
                    <input type="text" name="email" width="30%" placeholder="Email" /><br />
                    <textarea name="message" rows="4" cols="30" placeholder="Message"></textarea><br />
                    <input type="submit" name="sendMessage" value="Send" />
                </form>
            </div>
        </div>