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


if(isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];
    
    // Select the item details from the database based on the item ID
    $query = "SELECT * FROM `menu` WHERE `Item_ID` = $item_id";
    $result = mysqli_query($connect, $query);
    $item = mysqli_fetch_assoc($result);
} else {
    // Redirect to the menu page if no item ID is provided
    header("Location: customer_menu.php");
    exit();
}

// Get user ID from database using email address
$result = mysqli_query($connect,"SELECT user_id FROM users WHERE user_email = '$user_email'");
$row = mysqli_fetch_assoc($result);
$_SESSION['user_id'] = $row['user_id'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product Details | Vanilla Cafe</title>
    <link rel = "icon" href="images/logo.jpg" type = "image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/customer_productdetails.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="viewreport" content="width=devive-width, initial-scale=1.0">
</head>

<body style = "margin:0">
<main>
<!-- Navbar -->
<nav>
    <ul>
         <li><a href="customer_dashboard.php">Home</a></li>
         <li><a href="customer_menu.php">Menu</a></li>
         <li><a href="customer_account.php">Account</a></li>
         
         <li class="logo" style="position: absolute; left: 50%; transform: translateX(-50%);"><a href="customer_dashboard.php">Vanilla Café</a></li>
 
         <li style="float:right"><a href="customer_logout.php" span class="material-symbols-outlined" style="font-size: 35px; padding-right:60px;">Logout</span></a></li>
         <li style="float:right"><a href="customer_shoppingcart.php" span class="material-symbols-outlined" style="font-size: 35px;">shopping_cart</span></a></li>
           
    </ul>
 </nav>
<!-- end of Navbar -->

<h1>Product Details</h1>


<!-- Display the item information -->
<div class="item-details">

    <div class="left-column">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($item['Item_Image']); ?>" alt="Image" class="item-image">
    </div>

    <div class="right-column">
        <div class="item-name"><?php echo $item['Item_Name']; ?></div>
        <div class="item-price">RM <?php echo $item['Item_Price']; ?></div>
        <div class="item-description"><?php echo $item['Item_Description']; ?></div>

        <form method="POST">
            <label for="quantity">Quantity:</label>

            <div class="add-minus">

                <button type="button" class="minus-btn"
                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                    <i class="fa fa-minus"></i>
                </button>

                <input type="number" id ="quantity" name="quantity" value="1" min="1" max="99" readonly>
                            
                <button type="button" class="plus-btn"
                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                    <i class="fa fa-plus"></i>
                </button>
                        
            </div>

            <input type="hidden" name="item_id" value="<?php echo $item['Item_ID']; ?>">
            <input type="hidden" name="price" value="<?php echo $item['Item_Price']; ?>">

            <button type="submit" name="add_to_cart" class="add-to-cart">
                <p class="btnText">Add to Cart</p>
                <div class="btnTwo">
                    <p class="btnText2"><span class="material-symbols-outlined">add_shopping_cart</span></p>
                </div>
            </button>
            
        </form>
    </div>
</div>

<button class="cta" onclick="goBack()">
  <span class="hover-underline-animation">Continue Shopping</span>
  <svg id="arrow-horizontal" xmlns="http://www.w3.org/2000/svg" width="30" height="10" viewBox="0 0 46 16">
    <path id="Path_10" data-name="Path 10" d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z" transform="translate(30)"></path>
  </svg>
</button>

<script>
  function goBack() {
    window.history.back();
  }
</script>

</main>
<footer>
    <p>All Rights Reserved © 2023 by Vanilla Café</p>
</footer>

</body>
</html>

<?php
// Handle add to cart action
if(isset($_POST['add_to_cart'])){
    $item_id = $_POST['item_id'];
    $user_id = $_SESSION['user_id'];
    $quantity = $_POST['quantity'];
    $cart_status = 1;

    // Check if item already exists in the user's cart
    $check_query = "SELECT * FROM shopping_cart WHERE Item_ID = $item_id AND user_id = $user_id AND cart_status = 1";
    $check_result = mysqli_query($connect, $check_query);

    if(mysqli_num_rows($check_result) > 0){
        // Update the existing cart item with the new quantity
        $cart_item = mysqli_fetch_assoc($check_result);
        $new_qty = $cart_item['Item_qty'] + $quantity;
        $cart_id = $cart_item['cart_id'];
        $update_query = "UPDATE shopping_cart SET Item_qty = $new_qty WHERE cart_id = $cart_id";
        $update_result = mysqli_query($connect, $update_query);
    } else {
        // Add the new item to the user's cart
        $insert_query = "INSERT INTO shopping_cart (user_id, Item_ID, Item_qty, cart_status) VALUES ($user_id, $item_id, $quantity, $cart_status)";
        $insert_result = mysqli_query($connect, $insert_query);
    }

    // Display success message
    echo '<script>
            Swal.fire({
                title: "Item added successfully",
                icon: "success",
                customClass: {
                    container: \'custom-swal-font\'
                }
            });
        </script>';
        }

?>