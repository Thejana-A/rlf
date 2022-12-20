<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View material quotation</title>
        <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="index.php">Welcome </a> >
                    <a href="login.php">Login </a> >
                    <a href="home.php">Supplier </a> >Quotation requests
                </div>

                <div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>Send quotation</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" value ="1" readonly/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" value ="4" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" value ="RLF Manager" readonly/>
                            </div>
                        </div>
            
                
                        <div class="form-row">
                            <div class="form-row-theme">
                                Requested on :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" value ="2022-11-21" readonly/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Valid till :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" value ="2023-11-21" readonly/>
                            </div>
                        </div>

                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - material name(size)</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Measuring Unit</b></span>
                                <span><b>Price(LKR)</b></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id="" readonly>
                                    <option disabled>ID - Material name</option>
                                    <option>0001 - Black Thread-S(S)</option>
                                    <option>0014 - Blue Thread-S(S)</option>
                                    <option>0022 - Red anchor button-L(L)</option>
                                </select> 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" value = "100" class="column-textfield" />
                                <input type="text" name="" id="" value = "meters" class="column-textfield"  />
                                <input type="text" name="" id="" class="column-textfield"  />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <select name="" id=""  readonly>
                                    <option disabled>ID - Material name</option>
                                    <option>0002 - Green Silk-S(S)</option>
                                    <option>0014 - Blue Thread-S(S)</option>
                                    <option>0022 - Red anchor button-L(L)</option>
                                </select> 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" value = "200"  class="column-textfield" />
                                <input type="text" name="" id="" value = "meters" class="column-textfield"  />
                                <input type="text" name="" id="" class="column-textfield"  />
                            </div>
                        </div>
                        <div class="form-row">
                             <div class="form-row-theme">
                                <select name="" id="" readonly>
                                    <option disabled>ID - Material name</option>
                                    <option>0003 - White Thread-S(S)</option>
                                    <option>0014 - Blue Thread-S(S)</option>
                                    <option>0022 - Red anchor button-L(L)</option>
                                </select> 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id=""value = "150" class="column-textfield" />
                                <input type="text" name="" id="" value = "meters" class="column-textfield"  />
                                <input type="text" name="" id="" class="column-textfield"  />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Total price (LKR) :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id=""  />
                            </div>
                        </div>
                        
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation issued date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" />
                            </div>
                        </div>
                        

                        <div class="form-row">
                            <div class="form-row-theme">
                                Expected delivery date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" />
                            </div>
                        </div>
                        
                       
                        <div class="form-row">
                            <div class="form-row-theme">
                                Status (By supplier) :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="acceptance" class="input-radio" id="" /> Accepted
                                        </td>
                                        <td>
                                            <input type="radio" name="acceptance" class="input-radio" id=""  /> Rejected
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Acceptance description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="" rows="4" cols="40" ></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Send" />
                            </div>
                        </div> 

                    </form>
                </div>   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
