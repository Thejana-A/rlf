<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View raw material</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>
        <div id="page-body">
            
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Merchandiser </a> >
                    <a href="#">View raw materials </a> > View
                </div>

                <div id="form-box-small">
                    <form method="post" action="">
                        <center>
                            <h2>View raw material</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="" disabled>
                                    <option>S</option>
                                    <option>M</option>
                                    <option>L</option>
                                    <option>XL</option>
                                    <option>XXL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring unit : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="" disabled>
                                    <option>Units</option>
                                    <option>m</option>
                                    <option>yards</option>
                                    <option>reels</option>
                                    <option>m^2</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="" rows="4" cols="40" disabled></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Image :
                            </div>
                            <div class="form-row-data">
                                <img src="../icons/anchor_button.png" class="material-image" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Suppliers : 
                            </div>
                            <div class="form-row-data">
                                <select multiple size="2" disabled name="" id="">
                                    <option>ID - Supplier name</option>
                                    <option>0001 - John A</option>
                                    <option>0006 - John B</option>
                                    <option>0020 - John C</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Costume designs : 
                            </div>
                            <div class="form-row-data">
                                <select multiple size="2" disabled name="" id="">
                                    <option>ID - Design name</option>
                                    <option>0004 - Black T-shirt-S</option>
                                    <option>0014 - Blue T-shirt-S</option>
                                    <option>0022 - Red T-shirt-S</option>
                                </select>
                            </div>
                        </div>
                        
                    </form>
                </div> 
                
                <div id="form-box-small">
                    <form method="post" action="">
                        <center>
                            <h2>Retrieve from storage</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Raw material ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Measuring unit : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quantity in storage :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quantity :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Action :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="store_action" class="input-radio" id="" /> Store
                                        </td>
                                        <td>
                                            <input type="radio" name="store_action" class="input-radio" id="" /> Retrieve
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> 
                    </form>
                </div>   

            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
