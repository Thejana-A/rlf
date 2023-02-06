<?php
 error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<!DOCTYPE html>
<head>
    <title>Customized Request Qutation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
    <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
</head>
<body>
        <div id="breadcrumb">
            <a href="customer_home.php">Home </a> > Request Customized Design
        </div>


    <!--<div class="ViewRow">
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
        
    </div>-->

    <div id="form-box">
                        <form method="post" name="costumeDesignForm" action="../RouteHandler.php" enctype="multipart/form-data">
                            <input type="text" hidden="true" name="framework_controller" value="costume_design/add" />
                            <input type="text" hidden="true" name="home_url" value="customer/customer_home.php" />
                            <center>
                                <h2>Request Customized Design</h2>
                            </center>
                            
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Proposed Name : 
                                </div>
                                <div class="form-row-data">
                                    <input type="text" name="name" id="name" required />
                                </div>
                            </div>

                            
                            
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Front view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="front_view" id="front_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Rear view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="rear_view" id="rear_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Left view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="left_view" id="left_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Right view : 
                                </div>
                                <div class="form-row-data">
                                    <input type="file" name="right_view" id="right_view" accept="image/png, image/gif, image/jpeg, image/tiff" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row-theme">
                                    Description
                                </div>
                                <div class="form-row-data">
                                    <textarea rows="4" cols="40" name="description" id="description" required></textarea>
                                </div>
                            </div>

                            <input type="text" hidden="true" name="customized_design_approval" value="approve" />

                            <div class="form-row">
                                <div class="form-row-submit">
                                    <a href="request_customized_quotation.php">
                                        <input type="submit" value="Request Design Quotation" />
                                    </a>
                                </div>
                                <div class="form-row-reset">
                                    <input type="reset" value="Cancel" />
                                </div>
                            </div> 
                        </form>
                    </div> 

    <?php include 'footer.php';?>
</body>
</html>