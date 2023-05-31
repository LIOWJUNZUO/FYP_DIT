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
    
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Welcome | Vanilla Cafe</title>
    <link rel = "icon" href="images/logo.jpg" type = "image/x-icon">
    <link rel="stylesheet" href="css/customer_dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
     <div class="container">
        <section>
            <img class="mySlides" src="images/background1.jpg" style="width:100%; height:100%;">
            <img class="mySlides" src="images/background2.jpg" style="width:100%; height:100%;">
            <img class="mySlides" src="images/background3.jpg" style="width:100%; height:100%;">
            <div class="centered">
                <?php 
                    $result = mysqli_query($connect,"SELECT user_name FROM users WHERE user_email = '$user_email'");
                    $_SESSION['user_name'] = $row['user_name']; 
                ?>
                <p>Welcome valued customer <br><i><?php echo $_SESSION['user_name'] ?></i></p>
                <button onclick="window.location.href='customer_menu.php'">Order Now</button>
            </div>
        </section>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
        
    </div>
    
    <script>
        var myIndex = 0;
        carousel();
        
        function carousel() {
          var i;
          var x = document.getElementsByClassName("mySlides");
          for (i = 0; i < x.length; i++) {
             x[i].style.display = "none";
          }
          myIndex++;
          if (myIndex > x.length) {myIndex = 1}
          x[myIndex-1].style.display = "block";
          setTimeout(carousel, 5000);
        }
    </script>
    
    <script>
        var slideIndex = 1;
        showSlides(slideIndex);
        
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }
        
        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            if (n > slides.length) {
                slideIndex = 1;
            }    
            if (n < 1) {
                slideIndex = slides.length;
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex-1].style.display = "block";
        }
    </script>
    
    </main>
    <footer>
        <p>All Rights Reserved © 2023 by Vanilla Café</p>
    </footer>

</body>
</html>