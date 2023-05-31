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

// Get user's shopping cart items from the database
$user_id = $row['user_id'];
$result = mysqli_query($connect, "SELECT * FROM shopping_cart 
    INNER JOIN menu ON shopping_cart.Item_ID = menu.Item_ID 
    WHERE shopping_cart.user_id = '$user_id' AND shopping_cart.cart_status = 1");

// Count the number of items in the shopping cart
$num_rows = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shopping Cart | Vanilla Cafe</title>
    <link rel = "icon" href="images/logo.jpg" type = "image/x-icon">
    <link rel="stylesheet" href="css/customer_shoppingcart.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="viewreport" content="width=devive-width, initial-scale=1.0">
</head>

<body style = "margin:0">

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
    
<h1>Shopping Cart</h1>

<?php if($num_rows > 0) { ?>
<table class="shopping-cart">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php while($row=mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['Item_Image'])?>" alt="Product Image"></td>
                <td><?php echo $row['Item_Name']?></td>
                <td>RM <?php echo $row['Item_Price']?></td>

				<!-- Add plus and minus buttons to update quantity -->
                <td>
					<div class="add-minus">
						<button type="button" class="minus-btn" onclick="decrementValue(this)"><i class="fa fa-minus"></i></button>										

						<input type="number" id ="quantity" name="quantity_<?php echo $row['Item_ID']; ?>" value="<?php echo $row['Item_qty']?>" min="1" max="99" data-item-id="<?php echo $row['Item_ID']; ?>" readonly>

						<button type="submit" class="plus-btn" onclick="incrementValue(this)"><i class="fa fa-plus"></i></button>						
					</div>
                </td>

                <td>RM <?php echo number_format($row['Item_Price'] * $row['Item_qty'], 2)?></td>

                <td>
                    <form method="post">
                        <input type="hidden" name="item_id" value="<?php echo $row['Item_ID']; ?>">
                        <button type="submit" name="delete" class="delete-button">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>

        <tfoot>
			<tr>
				<td colspan="4" style="text-align:right;">TOTAL:</td>
				<?php
					// calculate the total price
					$total = 0;
					mysqli_data_seek($result, 0);
					while ($row = mysqli_fetch_assoc($result)) {
						$subtotal = $row['Item_Price'] * $row['Item_qty'];
						$total += $subtotal;
					}
					?>
					<td style="text-align:center;">RM <?php echo number_format($total, 2); ?></td>
					
					<td></td>
			</tr>
		</tfoot>
    </table>

    <div class="checkout-wrapper">
        <a href="customer_payment.php"><button class="checkout-btn">PROCEED TO PAY</button></a>
    </div>

<?php } else { ?>
    <p class="empty-cart">You have nothing in your cart.</p>
<?php } ?>

</main>

<script>
    
    function updateQuantity(input) {
        // Get the new quantity from the input field
        var newQuantity = input.value;
        // Get the item ID from the data attribute
        var itemId = input.getAttribute('data-item-id');
        // Send an AJAX request to update the shopping cart
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Reload the page to reflect the updated shopping cart
                location.reload();
            }
        };
        xhr.open('POST', 'customer_updateCart.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('item_id=' + encodeURIComponent(itemId) + '&quantity=' + encodeURIComponent(newQuantity));
    }

    function incrementValue(button) {
        var input = button.parentNode.querySelector('input[type="number"]');
        input.stepUp();
        updateQuantity(input);
    }

    function decrementValue(button) {
        var input = button.parentNode.querySelector('input[type="number"]');
        input.stepDown();
        updateQuantity(input);
    }
</script>

<footer>
    <p class="footer-content">All Rights Reserved © 2023 by Vanilla Café</p>
</footer>

</body>
</html>

<?php
//delete item
if(isset($_POST['delete'])) {
    $item_id = $_POST['item_id'];
    $result = mysqli_query($connect, "DELETE FROM shopping_cart WHERE Item_ID = '$item_id' AND user_id = '$user_id' AND cart_status = 1");
    ?>
        <script>
            Swal.fire({
                title: "Item deleted",
                icon: "success",
                customClass: {
                    container: 'custom-swal-font'
                }
            }).then(function() {
                window.location.href = "customer_shoppingcart.php";
            });
        </script>
    <?php
}

?>

<?php
// Calculate the total price
$total = 0;
mysqli_data_seek($result, 0);
while ($row = mysqli_fetch_assoc($result)) {
    $subtotal = $row['Item_Price'] * $row['Item_qty'];
    $total += $subtotal;
}

// Store the total price in a session variable
$_SESSION['total_price'] = $total;
?>

