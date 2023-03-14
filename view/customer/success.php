<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap");
        .success-container {
            width: 50%;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #bdc3c7;
            font-weight: bold;
            font-family: "Poppins", sans-serif;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <?php
        if (isset($_GET["amount"]) && !empty($_GET["amount"])) {
            /*$servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "rlf";

            $order_id = $_GET['order_id'];
            echo $order_id;

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "UPDATE costume_order SET order_status='confirmed' WHERE order_id=$order_id";
            if ($conn->query($sql) === TRUE) {*/
                echo "Your transaction has been successfully completed.";
                echo "Your order is confirmed.";
          /*  } else {
                echo "Error updating record: " . $conn->error;
            }

            $conn->close();*/
        }
        ?>
    </div>
</body>
</html>
