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

// Check if an item category has been selected
if (isset($_GET['category_id'])) {
  $category_id = $_GET['category_id'];
  $category_sql = "SELECT * FROM item_category WHERE item_category_id = $category_id";
  $category_result = mysqli_query($connect, $category_sql);
  $category = mysqli_fetch_assoc($category_result);

  // Retrieve the menu items from the selected category from the database
  $sql = "SELECT * FROM menu JOIN item_category ON menu.item_category_id = item_category.item_category_id WHERE item_category.menu_category_id = 2 AND menu.item_category_id = $category_id";
} else {
  // Retrieve all menu items from the database
  $sql = "SELECT * FROM menu JOIN item_category ON menu.item_category_id = item_category.item_category_id WHERE item_category.menu_category_id = 2";
}

$result = mysqli_query($connect, $sql);

$menu_items = array();
while ($row = mysqli_fetch_assoc($result)) {
  $menu_items[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Drinks | Vanilla Cafe</title>
    <link rel = "icon" href="images/logo.jpg" type = "image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/customer_foods&drinks.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
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
  
<h1><a href="customer_drinks.php?id=2" style="color: #343a40;">Drinks</a></h1>

<div class="container2">
  <?php
  // Retrieve only specific item categories from the database and display them as buttons
  $category_sql = "SELECT * FROM item_category WHERE menu_category_id = 2";
  $category_result = mysqli_query($connect, $category_sql);

  while ($category = mysqli_fetch_assoc($category_result)) {
    $category_id = $category['item_category_id'];
    $category_title = $category['item_category_title'];
    echo "<button class='mbutton' type='button' onclick=\"location.href='?category_id=$category_id'\">$category_title</button>";
  }
  ?>
</div>

<table>
  <?php foreach ($menu_items as $index => $item) { ?>

    <?php if ($index % 4 == 0) { ?>

      <tr class="menu-row">

    <?php } ?>

    <td class="menu-item">
      <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($item['Item_Image']).'" alt="Image" class="item-image">' ;?>

      <div class="item-details">
        <div class="item-name"><?php echo $item['Item_Name']; ?></div>
        <div class="item-price">RM <?php echo $item['Item_Price']; ?></div>
        <div class="item-description"><?php echo $item['Item_Description']; ?></div>

        <button class="add-to-cart" onclick="window.location.href='customer_productdetails.php?item_id=<?php echo $item['Item_ID']; ?>'">
        <p class="btnText">View Details</p>
        <div class="btnTwo">
            <p class="btnText2"><span class="material-symbols-outlined">visibility</span></p>
        </div>
        </button>
        

      </div>
      
    </td>
    
    <!--Set item display 1 row have 4 column-->
    <?php if (($index + 1) % 4 == 0 || ($index + 1) == count($menu_items)) { ?>

      </tr>

    <?php } ?>
    
  <?php } ?>
</table>

</main>
<footer>
    <p>All Rights Reserved © 2023 by Vanilla Café</p>
</footer>

</body>
</html>