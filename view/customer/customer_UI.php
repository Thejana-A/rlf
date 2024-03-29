<?php 
 error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include "db_conn.php";

if (isset($_POST['update'])) {

  $firstname = $_POST['first_name'];

  $lastname = $_POST['last_name'];

  $customer_id = $_POST['customer_id'];

  $NIC = $_POST['NIC'];

  $email = $_POST['email'];

  $contactno = $_POST['contact_no'];

  $city = $_POST['city']; 

  $sql = "UPDATE `customer` SET `first_name`='$firstname',`last_name`='$lastname',`NIC`='$NIC',`email`='$email',`contact_no`='$contactno',`city`='$city' WHERE `customer_id`='$customer_id'"; 

  $result = $conn->query($sql); 

  if ($result == TRUE) {
    
      echo "Record updated successfully.";

  }else{

      echo "Error:" . $sql . "<br>" . $conn->error;

  }

} 

if(($_SESSION["customer_id"]=="")){
  header("location:http://localhost/rlf/view/customer/customer_login.php");
  exit();
}
?>

<!DOCTYPE html>
<head>
    <link rel = "icon" href ="../Icon/logo.png"type = "image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="RLF_customer_css.css" />
    <title>RLF Apparel Factory</title>
    <style>

        /* Full-width input fields */
        input[type=text]{
        width: 100%;
        padding: 8px 10px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        background: #f5dcc2;
        }

        /* Set a style for all buttons */
        .updatebtn{
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        }

        .updatebtn:hover {
        opacity: 0.5;
        }

        /* Extra styles for the cancel button */
        .updatebtn {
        width: auto;
        padding: 10px 18px;
        background-color: #04AA6D;
        }

        /* Center the image and position the close button */
        .imgcontainer {
        text-align: center;
        margin: 0 0 0 0;
        position: relative;
       
        }

        img.avatar {
        width: 40%;
        border-radius: 50%;
        }

        .container {
        padding: 16px;
        
        }

        /* The Modal (background) */
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        padding-top: 40px;
        }

        /* Modal Content/Box */
        .modal-content {
        background-color: #fefefe;
        margin: 3% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
        border: 1px solid #888;
        width: 40%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button (x) */
        .close {
        position: absolute;
        right: 25px;
        top: 0;
        color: #000;
        font-size: 35px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: red;
        cursor: pointer;
        }

        /* Add Zoom Animation */
        .animate {
        -webkit-animation: animatezoom 0.6s;
        animation: animatezoom 0.6s
        }

        @-webkit-keyframes animatezoom {
        from {-webkit-transform: scale(0)} 
        to {-webkit-transform: scale(1)}
        }
        
        @keyframes animatezoom {
        from {transform: scale(0)} 
        to {transform: scale(1)}
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {

        .updatebtn {
            width: 100%;
        }
        }
    </style>
    <?php
        $stmt = $conn->prepare("SELECT * FROM `customer` WHERE `customer_id` = ?");
        $stmt->bind_param("i", $_SESSION['customer_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $first_name = $row["first_name"];
            $last_name = $row["last_name"];
            $NIC =$row['NIC'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $city = $row['city'];
        } else {
            echo "0 results";
        }

    ?>
</head>
<body>
    <header  class="header">
        <div id="header-top">
            <span id="logo">
               <center> <img src="../Icon/logo.png"></center>
            </span>
            <span id="centertitle">
                    <button onclick="aboutus()">About Us</button>
                    <button onclick="contactus()">Contact Us</button>
                    <button onclick="help()">Help</button>
                    <script>
                    function aboutus() {
                      var iframe = document.getElementsByName("iframe_a")[0];
                      iframe.src = "about_us.php";
                    }
                    function contactus() {
                      var iframe = document.getElementsByName("iframe_a")[0];
                      iframe.src = "contact_us.php";
                    }
                    function help() {
                      var iframe = document.getElementsByName("iframe_a")[0];
                      iframe.src = "help.php";
                    }
                    </script>
                    <!--<button ><a href="notifications.php" target="iframe_a">Help</a></button>-->
            </span>
            
            <span id ="button">
                <button id="logoutbutton" onclick="window.location.href='customer_login.php';">
                    Logout
                </button>
            </span>
        </div>

        <div id="header-bottom">
            <button id="menubutton" onclick="openNav()">
                <img src="../Icon/menu.png">
            </button>
            
            <a href="javascript:void(0)" onclick="openForm()" ><span id="username"> <?php echo  $first_name." ".$last_name?> &nbsp <img src="../Icon/user.png"/></span></a>
            
        </div>
    </header>
            <div>

                    <div id="mySidenav" class="sidenav">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <a href="#">Customer</a>
                        <a href="customer_home.php" target="iframe_a">Home</a>
                        <a href="notifications.php" target="iframe_a">Notification</a>
                        <a href="view_all_quotation.php" target="iframe_a">View All Quotation</a>
                        <a href="view_all_order.php" target="iframe_a">View All Order</a>
                        <a href="view_all_customized_design_request.php" target="iframe_a">View Customized Design Request</a>
                        <a href="edit_self_profile.php" target="iframe_a"> Reset password </a>
                    </div>

                    <div id="main">
                        <iframe src="customer_home.php" name="iframe_a" class="iframe"></iframe>
                      </div>
            <div>

          <script>
          function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";

          }
          
          function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
          }
          </script>



<div id="id01" class="modal">
  
  <form class="modal-content animate" action="" method="post" name="customerForm" onSubmit="return validateForm()" >
  
    <div class="imgcontainer" style="background-color:#bbbbbb">
      <span onclick="closeForm()" class="close" title="Close Modal">&times;</span>
      <img src="../Icon/user.png" alt="Avatar" class="avatar" style="width:80px">
    </div>

    <div class="container" style="background-color:#EEEEEE">
      <label for="firstname"><b>First Name</b></label>
      <input type="text" placeholder="Enter First Name" name="first_name" value="<?php echo $first_name?> ">
      
      <input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer_id']; ?>">
      <label for="lastname"><b>Last Name</b></label>
      <input type="text" placeholder="Enter Last name" name="last_name" value="<?php echo  $last_name?> ">
      <label for="nic"><b>NIC</b></label>
      <input type="text" placeholder="Enter your NIC" name="NIC" value="<?php echo  $NIC?> ">
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" value="<?php echo  $email ?> ">
      <label for="connumber"><b>Contact Number</b></label>
      <input type="text" placeholder="071 1234567" name="contact_no" value="<?php echo  $contact_no?> ">
      <label for="city"><b>City</b></label>
      <input type="text" placeholder="Enter your City" name="city" value="<?php echo  $city?> ">
      
        
    </div>

    <div class="container" style="background-color:#bbbbbb; text-align: center;">
      <button type="submit" class="updatebtn" name="update">Update</button>

    </div>
  </form>
</div>

<script>
function openForm() {
  document.getElementById("id01").style.display = "block";
}

function closeForm() {
  document.getElementById("id01").style.display = "none";
}
</script>
</body>
</html>

