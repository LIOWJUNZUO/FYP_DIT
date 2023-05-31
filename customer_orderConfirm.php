<?php
include("dataconnection.php"); 

session_start();

//To remove the error message when user isn't logged in but try to access the page
//error_reporting(E_ERROR | E_PARSE);

$user_email = $_SESSION['user_email'];
$result = mysqli_query($connect,"SELECT * FROM users WHERE user_email = '$user_email'");
$row=mysqli_fetch_assoc($result);

if(!isset($_SESSION['user_email'] ))
{
	?>
        <script type="text/javascript">
            alert("Please log in!");
            window.location.href='customer_signup&login.php';
        </script>
        <?php
        exit;
}

// Retrieve the last order number based on the user ID
$userId = $row['user_id'];
$lastOrderQuery = mysqli_query($connect, "SELECT order_number FROM orders WHERE user_id = $userId ORDER BY order_id DESC LIMIT 1");
$lastOrder = mysqli_fetch_assoc($lastOrderQuery);
$orderNumber = ($lastOrder) ? $lastOrder['order_number'] : '-';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thank you | Vanilla Cafe</title>
    <link rel = "icon" href="images/logo.jpg" type = "image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/customer_orderConfirm.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewreport" content="width=devive-width, initial-scale=1.0">
</head>

<body>

<!-- Navbar -->
<nav>
    <ul>
         <li><a href="customer_dashboard.php">Home</a></li>
         <li><a href="customer_menu.php">Menu</a></li>
         <li><a href="customer_account.php">My Account</a></li>
         
         <li class="logo" style="position: absolute; left: 50%; transform: translateX(-50%);"><a href="customer_dashboard.php">Vanilla Café</a></li>
 
         <li style="float:right"><a href="customer_logout.php" span class="material-symbols-outlined" style="font-size: 35px; padding-right:60px;">Logout</span></a></li>
         <li style="float:right"><a href="customer_shoppingcart.php" span class="material-symbols-outlined" style="font-size: 35px;">shopping_cart</span></a></li>
           
    </ul>
 </nav>
<!-- end of Navbar -->

<main>

<h1>Your order has been received</h1>

<p class="icon"><span class="material-symbols-outlined">check_circle</span></p>

<h2>Thank you for your purchase !</h2>

<p class="orderid">Your order ID is: <?php echo $orderNumber; ?></p>

<div class="row">
    <div>
        <button class="btn1" onclick="window.location.href='customer_dashboard.php'">Continue Shopping</button>
    </div>

    <div>
        <button class="btn2" onclick="window.location.href='customer_orderHistory.php'">View Order Details</button>
    </div>

</div>


</main>

<footer>
    <p class="footer-content">All Rights Reserved © 2023 by Vanilla Café</p>
</footer>

</body>
</html>