<?php
include("dataconnection.php"); 

session_start();

//To remove the error message when user isn't logged in but try to access the page
error_reporting(E_ERROR | E_PARSE);

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

$user_id = $row['user_id'];

// Get the item ID and new quantity from the AJAX request
$itemId = $_POST['item_id'];
$newQuantity = $_POST['quantity'];

// Update the quantity in the database
$query = "UPDATE shopping_cart SET Item_qty = '$newQuantity' WHERE user_id = '$user_id' AND Item_ID = '$itemId' AND cart_status = 1";
mysqli_query($connect, $query);

// Return a success response
echo 'success';
?>
