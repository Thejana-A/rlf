<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit costume design</title>
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
                    <a href="#">View costume designs </a> > Edit
                </div>

                <div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>Edit costume design</h2>
                        </center>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Design ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Design name : 
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
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Appearance :
                            </div>
                            <div class="form-row-data">
                                <img src="../icons/front_view.png" alt="front-view" class="design-view" />
                                <img src="../icons/rear_view.png" alt="rear-view" /><br />
                                <img src="../icons/left_view.png" alt="left-view" />
                                <img src="../icons/right_view.png" alt="right-view" /> 
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description
                            </div>
                            <div class="form-row-data">
                                <textarea rows="4" cols="40" name="" id="" disabled></textarea>
                            </div>
                        </div>

                        <center>
                            <h2>Price description</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - Material name (unit)</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit price(LKR)</b></span>
                                <span><b>Price(LKR)</b></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0002-Anchor button(units)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0010-Blue poplin clothe(m)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0010-Black thick clothe(m)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Total material price (LKR) :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>Final price (LKR) :</b>
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>Approval for material price (By manager) :</b>
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="product_status" class="input-radio" id="" disabled /> Approved
                                        </td>
                                        <td>
                                            <input type="radio" name="product_status" class="input-radio" id="" disabled /> Rejected
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Approval description :
                            </div>
                            <div class="form-row-data">
                                <textarea rows="4" cols="40" name="" id="" disabled></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Publish status :
                            </div>
                            <div class="form-row-data">
                                <input type="checkbox" name="" id="" class="input-checkbox" disabled /> Published
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
