<?php
 error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<!DOCTYPE html>
<head>
    <title>Customized Request Qutation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> > Request Customized Design
        </div>
    <div class="ViewRow">
        <div class="section-header text-center">
            <h2>Request Customized Design</h2>
        </div>
    </div>

    <div class="ViewRow">
        <div class="box">
            <form action="">
                <label for="fname">Propased Name :</label>
                <input type="text" id="fname" name="fname"style="width: 100%;" required>
              </form>
        </div>
    </div>
    <div class="ViewRow">
        <div class="box">
            <img src="../image/size-chart- new.png" width="60%">
            <br /><br/>
            <form action="" style="width:40%;">
                <label for="size">Size :</label>
                <select name="size"  multiple>
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                    <option value="XXXL">XXXL</option>
                </select>
            </form>
        </div>
    </div>
    <div class="ViewRow">
        <div class="box">
            <form action="">
                <label for="material">Raw Material :</label>
                <select name="material"  multiple>
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                  </select>
              </form>
        </div>
    </div>
    <div class="ViewRow">
        <div class="box">
            <form action="">
                <label for="fname">Input Design Image :</label>
                <br>
                Front View<input type="file" id="myFile" name="filename" style="width: 100%;">
                <br>Back view<input type="file" id="myFile" name="filename" style="width: 100%;">
                <br>Left View<input type="file" id="myFile" name="filename" style="width: 100%;">
                <br>Right View<input type="file" id="myFile" name="filename" style="width: 100%;">
              </form>
        </div>
        
    </div>
    <div class="ViewRow">
        <div class="box">
            Description :  &nbsp
            <form action="">
                <textarea name="message" rows="5" cols="30"></textarea>
              </form>
        </div>
        
    </div>
    <div class="ViewRow">
        <div class="box" style="display: block;">
            <center>
            <div class="section-header text-center">
                <h3 style="color: red;">Request Customized Qutation Now ..!</h3>
            </div>
            <img src="../image/size-chart- new.png" width="60%">
            <br />
            <form action="">
                <table>
                    <tr>
                        <th style="padding: 5px;">Size</th>
                        <th style="padding-left: 20px;">Quantity</th>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">XS</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="XS"style="width: 40%"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">S</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="S"style="width: 40%"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">M</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="M"style="width: 40%"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">L</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="L"style="width: 40%"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">XL</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="XL"style="width: 40%"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">XXL</td>
                        <td style="padding-left: 20px; display: flex; justify-content: center;"><input type="text" id="" name="XXL"style="width: 40%"></td>
                    </tr>
                </table>

                <br />
                <input type="submit" value="Request Customized Quotation" class="Quotationbtn" style="margin-top: 20px; width:200px">
              </form>
              
            </center>
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