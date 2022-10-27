<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit customized design</title>
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
                    <a href="#">Manager </a> >
                    <a href="#">Customized designs </a> > View
                </div>

                <div id="form-box-ultra-small">
                    <form method="post" action="">
                        <center>
                            <h2>Customized costume design</h2>
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
                                Proposed name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Size : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="">
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
                                Raw materials : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="" multiple size="2">
                                    <option disabled>Supplier ID - Supplier name</option>
                                    <option>0001-Black-button-S</option>
                                    <option>0004-Blue-button-S</option>
                                    <option>0010-Red poplyn-M</option>
                                </select>
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
                                Front view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Rear view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Left view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Right view : 
                            </div>
                            <div class="form-row-data">
                                <input type="file" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Description
                            </div>
                            <div class="form-row-data">
                                <textarea rows="4" cols="40" name="" id=""></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer contact no : : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer email : 
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
                                            <input type="radio" name="product_status" class="input-radio" id="" /> Approved
                                        </td>
                                        <td>
                                            <input type="radio" name="product_status" class="input-radio" id="" /> Rejected
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
                                <textarea rows="4" cols="40" name="" id=""></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Fashion designer : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="">
                                    <option disabled>Designer ID - Designer name</option>
                                    <option>0001-John A</option>
                                    <option>0004-John B</option>
                                    <option>0010-John C</option>
                                    <option>0011-John D</option>
                                </select>
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
