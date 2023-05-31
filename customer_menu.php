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

//Retrieve the menu items from the database
$sql = "SELECT * FROM menu";
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
    <title>Menu | Vanilla Cafe</title>
    <link rel = "icon" href="images/logo.jpg" type = "image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/customer_menu.css">
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
  
<h1>Our Menu</h1>

<div class="container2">
  <?php 
  $sql = "SELECT * FROM menu_category";
  $result = mysqli_query($connect, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    $category_id = $row['menu_category_id'];
    $category_title = $row['menu_category_title'];
    $page_url = ($category_id == 1) ? 'customer_foods.php' : 'customer_drinks.php';
  ?>
    <button class="mbutton" type="button" onclick="document.location='<?php echo $page_url; ?>?id=<?php echo $category_id; ?>'" title="Go to <?php echo $category_title; ?> page"><?php echo $category_title; ?></button>
  <?php } ?>
</div>

<!-- Display the menu items -->
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
