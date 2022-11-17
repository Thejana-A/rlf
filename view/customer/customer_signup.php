<!DOCTYPE html>
<head>
    <title>Signup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>

<?php 
$emailErr =  "";
$email = "";
include "db_conn.php";

    if (isset($_POST['signup'])) {

        $firstname = $_POST['firstname'];

        $user_id = $_POST['user_id'];

        $lastname = $_POST['lastname'];

        $email = $_POST['email'];

        $cont = $_POST['connum'];

        $password = $_POST['psw'];

        $addr = $_POST['addr']; 

        $sql = "INSERT INTO customer (firstname, lastname, email, contactnumber, city, password)
        VALUES ('$firstname','$lastname','$email','$cont','$addr','$password') "; 

        $result = mysqli_query($conn,$sql); 



        if ($result == TRUE) {
            echo '<script>
                alert("Record updated Successfully");
            </script>';
            //echo "Record updated successfully.";
            
        }else{

            echo "Error:" . $sql . "<br>" . $conn->error;

        }

    } 
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

?>

<body style="background-image: url('../image/login.png'); 
min-height:100%;
background-size: cover;
background-position: center; 
background-repeat: no-repeat; 
background-attachment: fixed;
margin: 0;
padding: 0;">
<button type="button" onclick="goback()" class="back">Go Back</button>

<form action="" method="post"  class="signup">

    <center><div class="loginlogo"><img src="../Icon/logo-login.png" width="150px"/></div>
    <h3>Customer Signup</h3></center>


   
    <label for="name"><b>First Name</b><span>*</span></label>
    <input type="text" placeholder="Enter first Name" name="firstname" required>
    

    <input type="hidden" name="user_id" value="">

    <label for="lastname"><b>LastName</b> <span>*<span></label>
    <input type="text" placeholder="Enter last Name" name="lastname" required>
    

    <label for="email"><b>Email</b><span >* <?php echo $emailErr;?></span></label>
    <input type="text" placeholder="name@gmail.com" name="email" required>

    <label for="contact"><b>Contact Number</b><span>*<span></label>
    <input type="text" placeholder="0711234567" name="connum" required>

    <label for="address"><b>Address</b><span>*<span></label>
    <input type="text" placeholder="Enter Address" name="addr" required>

    <label for="psw"><b>Password</b><span>*<span></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <br />
    <br />
    <button type="submit" class="btn" name="signup">Signup</button>


  </form>
  <script>
    function goback(){
        window.history.go(-1);

    }

    $('#ph').on('keypress',function(){
         var text = $(this).val().length;
         if(text > 9){
              return false;
         }else{
            $('#ph').text($(this).val());
         }
         
    });
</script>

</body>
</html>